<?php
/**
 * File containing the Xhtml5ToDocbook conversion test
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\FieldType\Tests\RichText\Converter\Xslt;

/**
 * Tests conversion from xhtml5 edit format to docbook
 */
class Xhtml5ToDocbookTest extends BaseTest
{
    /**
     * Returns subdirectories for input and output fixtures.
     *
     * The test will try to match each XML file in input directory with
     * the file of the same name in the output directory.
     *
     * It is possible to test lossy conversion as well (say legacy ezxml).
     * To use this file name of the fixture that is converted with data loss
     * needs to end with `.lossy.xml`. As input test with this fixture will
     * be skipped, but as output fixture it will be matched to the input
     * fixture file of the same name but without `.lossy` part.
     *
     * Comments in fixtures are removed before conversion, so be free to use
     * comments inside fixtures for documentation as needed.
     *
     * @return array
     */
    public function getFixtureSubdirectories()
    {
        return array(
            "input" => "xhtml5/edit",
            "output" => "docbook"
        );
    }

    /**
     * Return the absolute path to conversion transformation stylesheet.
     *
     * @return string
     */
    protected function getConversionTransformationStylesheet()
    {
        return __DIR__ . "/../../../../RichText/Resources/stylesheets/xhtml5/edit/docbook.xsl";
    }

    /**
     * Return custom XSLT stylesheets configuration.
     *
     * Stylesheet paths must be absolute.
     *
     * Code example:
     *
     * <code>
     *  array(
     *      array(
     *          "path" => __DIR__ . "/core.xsl",
     *          "priority" => 100
     *      ),
     *      array(
     *          "path" => __DIR__ . "/custom.xsl",
     *          "priority" => 99
     *      ),
     *  )
     * </code>
     *
     * @return array
     */
    protected function getCustomConversionTransformationStylesheets()
    {
        return array(
            array(
                "path" => __DIR__ . "/_fixtures/xhtml5/edit/custom_stylesheets/youtube_docbook.xsl",
                "priority" => 99
            ),
        );
    }

    /**
     * Return an array of absolute paths to conversion result validation schemas.
     *
     * @return string[]
     */
    protected function getConversionValidationSchema()
    {
        return array(
            __DIR__ . "/_fixtures/docbook/custom_schemas/youtube.rng"
        );
    }
}
