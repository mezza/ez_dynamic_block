<?php
/**
 * File containing the eZ\Publish\API\Repository\Values\Content\Query\SortClause\Location\Visibility class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\API\Repository\Values\Content\Query\SortClause\Location;

use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause\Location;

/**
 * Sets sort direction on the Location visibility for a Location query
 */
class Visibility extends Location
{
    /**
     * Constructs a new Location Visibility SortClause
     *
     * @param string $sortDirection
     */
    public function __construct( $sortDirection = Query::SORT_ASC )
    {
        parent::__construct( 'location_visibility', $sortDirection );
    }
}
