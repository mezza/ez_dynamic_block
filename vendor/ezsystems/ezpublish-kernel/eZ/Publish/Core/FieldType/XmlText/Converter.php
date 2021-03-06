<?php
/**
 * File containing the converter interface.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\FieldType\XmlText;

use DOMDocument;

/**
 * Interface for rich text conversion from internal XML representation to a string to display.
 */
interface Converter
{
    /**
     * Converts $xmlDoc (internal XML representation) to a string.
     * Returned value can :
     *  - The rendered string
     *  - null if a partial work is done on $xmlDoc (useful for pre-conversion).
     *
     * @param \DOMDocument $xmlDoc
     *
     * @return string|null
     */
    public function convert( DOMDocument $xmlDoc );
}
