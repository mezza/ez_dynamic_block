<?php
/**
 * File containing the eZ\Publish\API\Repository\Values\Content\Query\Criterion\Field class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\API\Repository\Values\Content\Query\Criterion;

use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\Operator\Specifications;
use eZ\Publish\API\Repository\Values\Content\Query\CriterionInterface;
use eZ\Publish\API\Repository\Values\Content\Query\CustomFieldInterface;

/**
 * The Field Criterion class.
 *
 * Provides content filtering based on Fields contents & values.
 */
class Field extends Criterion implements CriterionInterface, CustomFieldInterface
{
    /**
     * Custom field definitions to query instead of default field
     *
     * @var array
     */
    protected $customFields = array();

    public function getSpecifications()
    {
        return array(
            new Specifications( Operator::IN, Specifications::FORMAT_ARRAY ),
            new Specifications( Operator::EQ, Specifications::FORMAT_SINGLE ),
            new Specifications( Operator::GT, Specifications::FORMAT_SINGLE ),
            new Specifications( Operator::GTE, Specifications::FORMAT_SINGLE ),
            new Specifications( Operator::LT, Specifications::FORMAT_SINGLE ),
            new Specifications( Operator::LTE, Specifications::FORMAT_SINGLE ),
            new Specifications( Operator::LIKE, Specifications::FORMAT_SINGLE ),
            new Specifications( Operator::BETWEEN, Specifications::FORMAT_ARRAY, null, 2 ),
            new Specifications( Operator::CONTAINS, Specifications::FORMAT_SINGLE ),
        );
    }

    /**
     * Set a custom field to query
     *
     * Set a custom field to query for a defined field in a defined type.
     *
     * @param string $type
     * @param string $field
     * @param string $customField
     * @return void
     */
    public function setCustomField( $type, $field, $customField )
    {
        $this->customFields[$type][$field] = $customField;
    }

    /**
     * Retun custom field
     *
     * If no custom field is set, return null
     *
     * @param string $type
     * @param string $field
     * @return mixed
     */
    public function getCustomField( $type, $field )
    {
        if ( !isset( $this->customFields[$type] ) ||
             !isset( $this->customFields[$type][$field] ) )
        {
            return null;
        }

        return $this->customFields[$type][$field];
    }
}
