<?php
/**
 * File containing the XmlTextConverterPass class.
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
 * Compiler pass adding pre-converters to HTML5 converter.
 * Useful for manipulating internal XML before XSLT rendering.
 */
class XmlTextConverterPass implements CompilerPassInterface
{
    public function process( ContainerBuilder $container )
    {
        if ( !$container->hasDefinition( 'ezpublish.fieldType.ezxmltext.converter.html5' ) )
        {
            return;
        }

        $html5ConverterDef = $container->getDefinition( 'ezpublish.fieldType.ezxmltext.converter.html5' );
        foreach ( $container->findTaggedServiceIds( 'ezpublish.ezxml.converter' ) as $id => $attributes )
        {
            $html5ConverterDef->addMethodCall( 'addPreConverter', array( new Reference( $id ) ) );
        }
    }
}
