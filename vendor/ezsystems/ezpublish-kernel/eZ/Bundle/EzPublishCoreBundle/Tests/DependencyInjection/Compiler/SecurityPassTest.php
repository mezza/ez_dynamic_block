<?php
/**
 * File containing the SecurityPassTest class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Bundle\EzPublishCoreBundle\Tests\DependencyInjection\Compiler;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Compiler\SecurityPass;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTest;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class SecurityPassTest extends AbstractCompilerPassTest
{
    protected function setUp()
    {
        parent::setUp();
        $this->setDefinition( 'security.authentication.provider.dao', new Definition() );
        $this->setDefinition( 'security.authentication.provider.anonymous', new Definition() );
        $this->setDefinition( 'security.http_utils', new Definition() );
    }

    protected function registerCompilerPass( ContainerBuilder $container )
    {
        $container->addCompilerPass( new SecurityPass() );
    }

    public function testAlteredDaoAuthenticationProvider()
    {
        $this->compile();
        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            'security.authentication.provider.dao',
            'setRepository',
            array( new Reference( 'ezpublish.api.repository' ) )
        );
        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            'security.authentication.provider.anonymous',
            'setRepository',
            array( new Reference( 'ezpublish.api.repository' ) )
        );
        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            'security.http_utils',
            'setSiteAccess',
            array( new Reference( 'ezpublish.siteaccess' ) )
        );
    }
}
