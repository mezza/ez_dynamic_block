<?php
/**
 * File containing the ConfigScopeListener class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Bundle\EzPublishLegacyBundle\EventListener;

use eZ\Publish\Core\MVC\Symfony\Event\ScopeChangeEvent;
use eZ\Publish\Core\MVC\Symfony\MVCEvents;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ConfigScopeListener extends ContainerAware implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            MVCEvents::CONFIG_SCOPE_CHANGE => 'onConfigScopeChange',
            MVCEvents::CONFIG_SCOPE_RESTORE => 'onConfigScopeChange',
        );
    }

    public function onConfigScopeChange( ScopeChangeEvent $event )
    {
        // Resets legacy kernel services to ensure having a new instance of it.
        $this->container->set( 'ezpublish_legacy.kernel', null );
        $this->container->set( 'ezpublish_legacy.kernel.lazy', null );
        $this->container->set( 'ezpublish_legacy.kernel_handler.web', null );
    }
}