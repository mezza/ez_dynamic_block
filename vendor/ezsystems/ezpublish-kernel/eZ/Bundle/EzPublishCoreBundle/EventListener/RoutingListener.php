<?php
/**
 * File containing the RoutingListener class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Bundle\EzPublishCoreBundle\EventListener;

use eZ\Publish\Core\MVC\ConfigResolverInterface;
use eZ\Publish\Core\MVC\Symfony\Routing\Generator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use eZ\Publish\Core\MVC\Symfony\Event\PostSiteAccessMatchEvent;
use eZ\Publish\Core\MVC\Symfony\MVCEvents;
use Symfony\Component\Routing\RouterInterface;

/**
 * This siteaccess listener handles routing related runtime configuration.
 */
class RoutingListener implements EventSubscriberInterface
{
    /**
     * @var \eZ\Publish\Core\MVC\ConfigResolverInterface
     */
    private $configResolver;

    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $urlAliasRouter;

    /**
     * @var \eZ\Publish\Core\MVC\Symfony\Routing\Generator
     */
    private $urlAliasGenerator;

    public function __construct( ConfigResolverInterface $configResolver, RouterInterface $urlAliasRouter, Generator $urlAliasGenerator )
    {
        $this->configResolver = $configResolver;
        $this->urlAliasRouter = $urlAliasRouter;
        $this->urlAliasGenerator = $urlAliasGenerator;
    }

    public static function getSubscribedEvents()
    {
        return array(
            MVCEvents::SITEACCESS => array( 'onSiteAccessMatch', 200 )
        );
    }

    public function onSiteAccessMatch( PostSiteAccessMatchEvent $event )
    {
        $rootLocationId = $this->configResolver->getParameter( 'content.tree_root.location_id' );
        $this->urlAliasRouter->setRootLocationId( $rootLocationId );
        $this->urlAliasGenerator->setRootLocationId( $rootLocationId );
        $this->urlAliasGenerator->setExcludedUriPrefixes( $this->configResolver->getParameter( 'content.tree_root.excluded_uri_prefixes' ) );
    }
}
