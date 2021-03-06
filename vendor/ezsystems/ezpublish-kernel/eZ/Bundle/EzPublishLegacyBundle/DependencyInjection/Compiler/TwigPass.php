<?php
/**
 * File containing the TwigPass class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Bundle\EzPublishLegacyBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class TwigPass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process( ContainerBuilder $container )
    {
        if ( !$container->hasDefinition( 'twig' ) )
            return;

        // Adding setLegacyEngine method call here to avoid side effect in redefining the twig service completely.
        // Mentioned side effects are losing extensions/loaders addition for which method calls are added in the TwigEnvironmentPass
        $def = $container->getDefinition( 'twig' );
        $def->addMethodCall( 'setEzLegacyEngine', array( new Reference( 'templating.engine.eztpl' ) ) );
    }
}
