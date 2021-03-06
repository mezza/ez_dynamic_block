<?php
/**
 * File containing the ContentSearchHitAdapter class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\Pagination\Pagerfanta;

use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\SearchService;
use Pagerfanta\Adapter\AdapterInterface;

/**
 * Pagerfanta adapter for eZ Publish content search.
 * Will return results as SearchHit objects.
 */
class ContentSearchHitAdapter implements AdapterInterface
{
    /**
     * @var \eZ\Publish\API\Repository\Values\Content\Query
     */
    private $query;

    /**
     * @var \eZ\Publish\API\Repository\SearchService
     */
    private $searchService;

    /**
     * @var int
     */
    private $nbResults;

    public function __construct( Query $query, SearchService $searchService )
    {
        $this->query = $query;
        $this->searchService = $searchService;
    }

    /**
     * Returns the number of results.
     *
     * @return integer The number of results.
     */
    public function getNbResults()
    {
        if ( isset( $this->nbResults ) )
        {
            return $this->nbResults;
        }

        $countQuery = clone $this->query;
        $countQuery->limit = 0;
        return $this->nbResults = $this->searchService->findContent( $countQuery )->totalCount;
    }

    /**
     * Returns a slice of the results, as SearchHit objects.
     *
     * @param integer $offset The offset.
     * @param integer $length The length.
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Search\SearchHit[]
     */
    public function getSlice( $offset, $length )
    {
        $query = clone $this->query;
        $query->offset = $offset;
        $query->limit = $length;

        $searchResult = $this->searchService->findContent( $query );
        if ( !isset( $this->nbResults ) )
        {
            $this->nbResults = $searchResult->totalCount;
        }

        return $searchResult->searchHits;
    }
}
