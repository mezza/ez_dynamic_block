<?php
/**
 * File containing the BlockViewPassTest class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Bundle\EzPublishCoreBundle\Tests\DependencyInjection\Compiler;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Compiler\BlockViewPass;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTest;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class BlockViewPassTest extends AbstractCompilerPassTest
{
    protected function setUp()
    {
        parent::setUp();
        $this->setDefinition( 'ezpublish.view_manager', new Definition() );
    }

    /**
     * Register the compiler pass under test, just like you would do inside a bundle's load()
     * method:
     *
     *   $container->addCompilerPass(new MyCompilerPass());
     */
    protected function registerCompilerPass( ContainerBuilder $container )
    {
        $container->addCompilerPass( new BlockViewPass() );
    }

    /**
     * @dataProvider addViewProviderProvider
     */
    public function testAddViewProvider( $declaredPriority, $expectedPriority )
    {
        $def = new Definition();
        if ( $declaredPriority !== null )
        {
            $def->addTag( BlockViewPass::VIEW_PROVIDER_IDENTIFIER, array( 'priority' => $declaredPriority ) );
        }
        else
        {
            $def->addTag( BlockViewPass::VIEW_PROVIDER_IDENTIFIER );
        }
        $serviceId = 'service_id';
        $this->setDefinition( $serviceId, $def );

        $this->compile();
        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            'ezpublish.view_manager',
            BlockViewPass::ADD_VIEW_PROVIDER_METHOD,
            array( new Reference( $serviceId ), $expectedPriority )
        );
    }

    public function addViewProviderProvider()
    {
        return array(
            array( null, 0 ),
            array( 0, 0 ),
            array( 57, 57 ),
            array( -23, -23 ),
            array( -255, -255 ),
            array( -256, -255 ),
            array( -1000, -255 ),
            array( 255, 255 ),
            array( 256, 255 ),
            array( 1000, 255 ),
        );
    }
}
