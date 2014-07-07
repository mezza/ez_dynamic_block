<?php
/**
 * File containing the RegisterLimitationTypePass class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This compiler pass will register eZ Publish field types.
 */
class RegisterLimitationTypePass implements CompilerPassInterface
{
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @throws \LogicException
     */
    public function process( ContainerBuilder $container )
    {
        if ( !$container->hasDefinition( 'ezpublish.api.repository.factory' ) )
            return;

        $repositoryFactoryDef = $container->getDefinition( 'ezpublish.api.repository.factory' );

        // Limitation types.
        // Alias attribute is the limitation type name.
        foreach ( $container->findTaggedServiceIds( 'ezpublish.limitationType' ) as $id => $attributes )
        {
            foreach ( $attributes as $attribute )
            {
                if ( !isset( $attribute['alias'] ) )
                    throw new \LogicException( 'ezpublish.limitationType service tag needs an "alias" attribute to identify the limitation type. None given.' );

                $repositoryFactoryDef->addMethodCall(
                    'registerLimitationType',
                    array(
                        $attribute['alias'],
                        new Reference( $id )
                    )
                );
            }
        }
    }
}