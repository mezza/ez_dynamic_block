<?php
/**
 * File contains: eZ\Publish\Core\Persistence\Legacy\Tests\Content\SearchHandler/TransformationProcessorDefinitionBasedParserTest class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\Persistence\Tests\TransformationProcessor;

use eZ\Publish\Core\Persistence\Legacy\Tests\TestCase;
use eZ\Publish\Core\Persistence;

/**
 * Test case for LocationHandlerTest
 */
class TransformationProcessorDefinitionBasedParserTest extends TestCase
{
    public static function getTestFiles()
    {
        return array_map(
            function ( $file )
            {
                return array( realpath( $file ) );
            },
            glob( __DIR__ . '/_fixtures/transformations/*.tr' )
        );
    }

    /**
     * @dataProvider getTestFiles
     */
    public function testParse( $file )
    {
        $parser = new Persistence\TransformationProcessor\DefinitionBased\Parser();

        $fixture = include $file . '.result';
        $this->assertEquals(
            $fixture,
            $parser->parse( $file )
        );
    }
}

