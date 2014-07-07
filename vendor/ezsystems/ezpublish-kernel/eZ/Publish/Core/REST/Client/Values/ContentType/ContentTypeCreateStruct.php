<?php
/**
 * File containing the ContentTypeCreateStruct class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\REST\Client\Values\ContentType;

use eZ\Publish\API\Repository\Values\ContentType\FieldDefinitionCreateStruct;
use eZ\Publish\API\Repository\Values\ContentType\ContentTypeCreateStruct as APIContentTypeCreateStruct;

class ContentTypeCreateStruct extends APIContentTypeCreateStruct
{
    protected $fieldDefinitions = array();

    function __construct( array $data = array() )
    {
        foreach ( $data as $propertyName => $propertyValue )
        {
            $this->$propertyName = $propertyValue;
        }
    }

    /**
     * Adds a new field definition
     *
     * @param FieldDefinitionCreate $fieldDef
     */
    public function addFieldDefinition( FieldDefinitionCreateStruct $fieldDef )
    {
        $this->fieldDefinitions[] = $fieldDef;
    }
}
