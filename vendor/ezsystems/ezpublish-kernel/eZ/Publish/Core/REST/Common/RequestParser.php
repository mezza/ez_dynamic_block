<?php
/**
 * File containing the RequestParser interface
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\REST\Common;

/**
 * Interface for Request parsers
 */
interface RequestParser
{
    /**
     * Parse URL and return the IDs contained in the URL
     *
     * @param string $url
     *
     * @return array
     */
    public function parse( $url );

    /**
     * Generate a URL of the given type from the specified values
     *
     * @param string $type
     * @param array $values
     *
     * @return string
     */
    public function generate( $type, array $values = array() );

    /**
     * Tries to match $href as a route, and returns the value of $attribute from the result
     *
     * @param string $href
     * @param string $attribute
     *
     * @return mixed|false
     */
    public function parseHref( $href, $attribute );
}
