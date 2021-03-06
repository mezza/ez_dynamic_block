<?php
/**
 * File containing the RichTextHtml5ConverterPassTest class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Bundle\EzPublishCoreBundle\Tests;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Compiler\RichTextHtml5ConverterPass;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTest;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class RichTextHtml5ConverterPassTest extends AbstractCompilerPassTest
{
    /**
     * Register the compiler pass under test, just like you would do inside a bundle's load()
     * method:
     *
     *   $container->addCompilerPass(new MyCompilerPass());
     */
    protected function registerCompilerPass( ContainerBuilder $container )
    {
        $container->addCompilerPass( new RichTextHtml5ConverterPass() );
    }

    public function testCollectProviders()
    {
        $configurationResolver = new Definition();
        $this->setDefinition(
            'ezpublish.fieldType.ezrichtext.converter.output.xhtml5',
            $configurationResolver
        );

        $configurationProvider = new Definition();
        $configurationProvider->addTag( 'ezpublish.ezrichtext.converter.output.xhtml5' );
        $this->setDefinition( 'ezrichtext.converter.test1', $configurationProvider );

        $configurationProvider = new Definition();
        $configurationProvider->addTag( 'ezpublish.ezrichtext.converter.output.xhtml5', array( 'priority' => 10 ) );
        $this->setDefinition( 'ezrichtext.converter.test2', $configurationProvider );

        $configurationProvider = new Definition();
        $configurationProvider->addTag( 'ezpublish.ezrichtext.converter.output.xhtml5', array( 'priority' => 5 ) );
        $this->setDefinition( 'ezrichtext.converter.test3', $configurationProvider );

        $configurationProvider = new Definition();
        $configurationProvider->addTag( 'ezpublish.ezrichtext.converter.output.xhtml5', array( 'priority' => 5 ) );
        $this->setDefinition( 'ezrichtext.converter.test4', $configurationProvider );

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithArgument(
            'ezpublish.fieldType.ezrichtext.converter.output.xhtml5',
            0,
            array(
                new Reference( 'ezrichtext.converter.test1' ),
                new Reference( 'ezrichtext.converter.test3' ),
                new Reference( 'ezrichtext.converter.test4' ),
                new Reference( 'ezrichtext.converter.test2' )
            )
        );
    }
}
