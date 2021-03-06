<?php
/**
 * File containing the SSOFactory class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Bundle\EzPublishLegacyBundle\DependencyInjection\Security;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\AbstractFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Security factory for legacy SSO handlers.
 */
class SSOFactory extends AbstractFactory
{
    protected function createAuthProvider( ContainerBuilder $container, $id, $config, $userProviderId )
    {
        $preAuthProviderId = 'security.authentication.provider.pre_authenticated';
        $providerId = "$preAuthProviderId.$id";
        $container
            ->setDefinition( $providerId, new DefinitionDecorator( $preAuthProviderId ) )
            ->replaceArgument( 0, new Reference( $userProviderId ) )
            ->addArgument( $id );

        return $providerId;
    }

    protected function createListener( $container, $id, $config, $userProvider )
    {
        $parentListenerId = $this->getListenerId();
        $listenerId = "$parentListenerId.$id";
        $container
            ->setDefinition( $listenerId, new DefinitionDecorator( $parentListenerId ) )
            ->replaceArgument( 2, $id );

        return $listenerId;
    }

    protected function getListenerId()
    {
        return 'ezpublish_legacy.security.sso_firewall_listener';
    }

    public function getPosition()
    {
        return 'pre_auth';
    }

    public function getKey()
    {
        return 'ezpublish_legacy_sso';
    }
}
