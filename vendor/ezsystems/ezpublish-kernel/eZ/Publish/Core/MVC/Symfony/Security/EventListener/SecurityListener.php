<?php
/**
 * File containing the SecurityListener class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\MVC\Symfony\Security\EventListener;

use eZ\Publish\API\Repository\Repository;
use eZ\Publish\Core\MVC\ConfigResolverInterface;
use eZ\Publish\Core\MVC\Symfony\MVCEvents;
use eZ\Publish\Core\MVC\Symfony\Security\Authorization\Attribute;
use eZ\Publish\Core\MVC\Symfony\Security\Exception\UnauthorizedSiteAccessException;
use eZ\Publish\Core\MVC\Symfony\Security\InteractiveLoginToken;
use eZ\Publish\Core\MVC\Symfony\Security\UserInterface as eZUser;
use eZ\Publish\API\Repository\Values\User\User as APIUser;
use eZ\Publish\Core\MVC\Symfony\Event\InteractiveLoginEvent;
use eZ\Publish\Core\MVC\Symfony\Security\UserWrapped;
use eZ\Publish\Core\MVC\Symfony\SiteAccess;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent as BaseInteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * This security listener listens to security.interactive_login event to:
 *  - Give a chance to retrieve an eZ user when using multiple user providers
 *  - Check if user can actually login to the current SiteAccess
 *
 * Also listens to kernel.request to:
 *  - Check if current user (authenticated or not) can access to current SiteAccess
 */
class SecurityListener implements EventSubscriberInterface
{
    /**
     * @var \eZ\Publish\API\Repository\Repository
     */
    private $repository;

    /**
     * @var \eZ\Publish\Core\MVC\ConfigResolverInterface
     */
    private $configResolver;

    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var \Symfony\Component\Security\Core\SecurityContextInterface
     */
    private $securityContext;

    /**
     * The fragment path (for ESI/Hinclude...).
     *
     * @var string
     */
    private $fragmentPath;

    public function __construct(
        Repository $repository,
        ConfigResolverInterface $configResolver,
        EventDispatcherInterface $eventDispatcher,
        SecurityContextInterface $securityContext,
        $fragmentPath = '/_fragment'
    )
    {
        $this->repository = $repository;
        $this->configResolver = $configResolver;
        $this->eventDispatcher = $eventDispatcher;
        $this->securityContext = $securityContext;
        $this->fragmentPath = $fragmentPath;
    }

    public static function getSubscribedEvents()
    {
        return array(
            SecurityEvents::INTERACTIVE_LOGIN => array(
                array( 'onInteractiveLogin', 10 ),
                array( 'checkSiteAccessPermission', 9 ),
            ),
            // Priority 7, so that it occurs just after firewall (priority 8)
            KernelEvents::REQUEST => array( 'onKernelRequest', 7 )
        );
    }

    /**
     * Tries to retrieve a valid eZ user if authenticated user doesn't come from the repository (foreign user provider).
     * Will dispatch an event allowing listeners to return a valid eZ user for current authenticated user.
     * Will by default let the repository load the anonymous user.
     *
     * @param \Symfony\Component\Security\Http\Event\InteractiveLoginEvent $event
     */
    public function onInteractiveLogin( BaseInteractiveLoginEvent $event )
    {
        $token = $event->getAuthenticationToken();
        $originalUser = $token->getUser();
        if ( $originalUser instanceof eZUser || !$originalUser instanceof UserInterface )
        {
            return;
        }

        /*
         * 1. Send the event.
         * 2. If no eZ user is returned, load Anonymous user.
         * 3. Inject eZ user in repository.
         * 4. Create the UserWrapped user object (implementing eZ UserInterface) with loaded eZ user.
         * 5. Create new token with UserWrapped user
         * 6. Inject the new token in security context
         */
        $subLoginEvent = new InteractiveLoginEvent( $event->getRequest(), $token );
        $this->eventDispatcher->dispatch( MVCEvents::INTERACTIVE_LOGIN, $subLoginEvent );

        if ( $subLoginEvent->hasAPIUser() )
        {
            $apiUser = $subLoginEvent->getAPIUser();
        }
        else
        {
            $apiUser = $this->repository->getUserService()->loadUser(
                $this->configResolver->getParameter( "anonymous_user_id" )
            );
        }

        $this->repository->setCurrentUser( $apiUser );

        $providerKey = method_exists( $token, 'getProviderKey' ) ? $token->getProviderKey() : __CLASS__;
        $interactiveToken = new InteractiveLoginToken(
            $this->getUser( $originalUser, $apiUser ),
            get_class( $token ),
            $token->getCredentials(),
            $providerKey,
            $token->getRoles()
        );
        $interactiveToken->setAttributes( $token->getAttributes() );
        $this->securityContext->setToken( $interactiveToken );
    }

    /**
     * Returns new user object based on original user and provided API user.
     * One may want to override this method to use their own user class.
     *
     * @param \Symfony\Component\Security\Core\User\UserInterface $originalUser
     * @param \eZ\Publish\API\Repository\Values\User\User $apiUser
     *
     * @return \eZ\Publish\Core\MVC\Symfony\Security\UserInterface
     */
    protected function getUser( UserInterface $originalUser, APIUser $apiUser )
    {
        return new UserWrapped( $originalUser, $apiUser );
    }

    /**
     * Throws an UnauthorizedSiteAccessException if current user doesn't have permission to current SiteAccess.
     *
     * @param BaseInteractiveLoginEvent $event
     *
     * @throws \eZ\Publish\Core\MVC\Symfony\Security\Exception\UnauthorizedSiteAccessException
     */
    public function checkSiteAccessPermission( BaseInteractiveLoginEvent $event )
    {
        $token = $event->getAuthenticationToken();
        $originalUser = $token->getUser();
        $request = $event->getRequest();
        $siteAccess = $request->attributes->get( 'siteaccess' );
        if ( !( $originalUser instanceof eZUser && $siteAccess instanceof SiteAccess ) )
        {
            return;
        }

        if ( !$this->hasAccess( $siteAccess, $originalUser->getUsername() ) )
        {
            throw new UnauthorizedSiteAccessException( $siteAccess, $originalUser->getUsername() );
        }
    }

    /**
     * Throws an UnauthorizedSiteAccessException if current user doesn't have access to current SiteAccess.
     *
     * @param GetResponseEvent $event
     *
     * @throws \eZ\Publish\Core\MVC\Symfony\Security\Exception\UnauthorizedSiteAccessException
     */
    public function onKernelRequest( GetResponseEvent $event )
    {
        $request = $event->getRequest();
        if (
            !(
                // Ignore sub-requests, including fragments.
                $this->isMasterRequest( $request, $event->getRequestType() )
                // In legacy_mode, roles and policies must be delegated to legacy kernel.
                && !$this->configResolver->getParameter( 'legacy_mode' )
            )
        )
        {
            return;
        }

        $siteAccess = $request->attributes->get( 'siteaccess' );
        if ( !$siteAccess instanceof SiteAccess )
        {
            return;
        }

        $token = $this->securityContext->getToken();
        if ( $token === null )
        {
            return;
        }

        if (
            // Leave access to login route, so that user can attempt re-authentication.
            $request->attributes->get( '_route' ) !== 'login'
            && !$this->hasAccess( $siteAccess, $token->getUsername() )
        )
        {
            throw new UnauthorizedSiteAccessException( $siteAccess, $token->getUsername() );
        }
    }

    /**
     * Returns true if given request is considered as a master request.
     * Fragments are considered as sub-requests (i.e. ESI, Hinclude...)
     *
     * @param Request $request
     * @param $requestType
     *
     * @return bool
     */
    private function isMasterRequest( Request $request, $requestType )
    {
        if (
            $requestType !== HttpKernelInterface::MASTER_REQUEST
            || substr( $request->getPathInfo(), -strlen( $this->fragmentPath ) ) === $this->fragmentPath
        )
        {
            return false;
        }

        return true;
    }

    /**
     * Returns true if current user has access to given SiteAccess.
     *
     * @param SiteAccess $siteAccess
     *
     * @return bool
     */
    protected function hasAccess( SiteAccess $siteAccess )
    {
        return $this->securityContext->isGranted( new Attribute( 'user', 'login', array( 'valueObject' => $siteAccess ) ) );
    }
}
