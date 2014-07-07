<?php
/**
 * File containing the eZ\Publish\API\Repository\Values\Content\SearchResult class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\API\Repository\Values\Content;

use eZ\Publish\API\Repository\Values\ValueObject;

/**
 * @deprecated
 * This class is returned by find methods providing a result of a search.
 */
class SearchResult extends ValueObject
{
    /**
     * the query this result is based on
     *
     * @var Query
     */
    public $query;

    /**
     * Number of results found by the search
     *
     * @var int
     */
    public $count;

    /**
     * The found items by the search
     *
     * @var \eZ\Publish\API\Repository\Values\ValueObject[]
     */
    public $items = array();
}
