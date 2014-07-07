<?php
/**
 * File containing the eZ\Publish\API\Repository\Values\Content\Query\SortClause\MapLocationDistance class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\API\Repository\Values\Content\Query\SortClause;

use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause\Target\MapLocationTarget;
use eZ\Publish\API\Repository\Values\Content\Query\CustomFieldInterface;

/**
 * Sets sort direction on the MapLocation distance for a content query
 */
class MapLocationDistance extends SortClause implements CustomFieldInterface
{
    /**
     * Custom fields to sort by instead of the default field
     *
     * @var array
     */
    protected $customFields = array();

    /**
     * Constructs a new MapLocationDistance SortClause on Type $typeIdentifier and Field $fieldIdentifier
     *
     * @param string $typeIdentifier ContentType identifier
     * @param string $fieldIdentifier FieldDefinition identifier
     * @param float $latitude Latitude of the location that distance is calculated from
     * @param float $longitude Longitude of the location that distance is calculated from
     * @param string $sortDirection
     * @param null|string $languageCode
     */
    public function __construct(
        $typeIdentifier,
        $fieldIdentifier,
        $latitude,
        $longitude,
        $sortDirection = Query::SORT_ASC,
        $languageCode = null
    )
    {
        parent::__construct(
            'maplocation_distance',
            $sortDirection,
            new MapLocationTarget(
                $latitude,
                $longitude,
                $typeIdentifier,
                $fieldIdentifier,
                $languageCode
            )
        );
    }

    /**
     * Set a custom field to sort by
     *
     * Set a custom field to sort by for a defined field in a defined type.
     *
     * @param string $type
     * @param string $field
     * @param string $customField
     *
     * @return void
     */
    public function setCustomField( $type, $field, $customField )
    {
        $this->customFields[$type][$field] = $customField;
    }

    /**
     * Return custom field
     *
     * If no custom field is set, return null
     *
     * @param string $type
     * @param string $field
     *
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
