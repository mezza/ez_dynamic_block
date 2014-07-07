<?php
/**
 * File containing the MultipleStringMapper class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\Persistence\Solr\Content\Search\FieldValueMapper;

use eZ\Publish\SPI\Persistence\Content\Search\Field;
use eZ\Publish\SPI\Persistence\Content\Search\FieldType\MultipleStringField;

/**
 * Maps raw document field values to something Solr can index.
 */
class MultipleStringMapper extends StringMapper
{
    /**
     * Check if field can be mapped
     *
     * @param Field $field
     *
     * @return bool
     */
    public function canMap( Field $field )
    {
        return $field->type instanceof MultipleStringField;
    }

    /**
     * Map field value to a proper Solr representation
     *
     * @param Field $field
     *
     * @return array
     */
    public function map( Field $field )
    {
        $values = array();

        foreach ( (array)$field->value as $value )
        {
            $values[] = $this->convert( $value );
        }

        return $values;
    }
}

