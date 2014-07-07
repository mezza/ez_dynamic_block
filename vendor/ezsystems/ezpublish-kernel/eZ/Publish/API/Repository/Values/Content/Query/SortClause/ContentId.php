<?php
/**
 * File containing the eZ\Publish\API\Repository\Values\Content\Query\SortClause\ContentId class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\API\Repository\Values\Content\Query\SortClause;

use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause;

/**
 * Sets sort direction on Content ID for a content query
 *
 * Especially useful to get reproducible search results in tests.
 */
class ContentId extends SortClause
{
    /**
     * Constructs a new ContentId SortClause
     * @param string $sortDirection
     */
    public function __construct( $sortDirection = Query::SORT_ASC )
    {
        parent::__construct( 'content_id', $sortDirection );
    }
}
