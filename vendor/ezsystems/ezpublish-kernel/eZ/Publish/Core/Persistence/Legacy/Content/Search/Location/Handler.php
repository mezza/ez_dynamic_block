<?php
/**
 * File containing the Location Search Handler class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\Persistence\Legacy\Content\Search\Location;

use eZ\Publish\API\Repository\Values\Content\LocationQuery;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\SPI\Persistence\Content\Location\Search\Handler as LocationSearchHandler;
use eZ\Publish\Core\Persistence\Legacy\Content\Location\Mapper as LocationMapper;
use eZ\Publish\API\Repository\Values\Content\Search\SearchResult;
use eZ\Publish\API\Repository\Values\Content\Search\SearchHit;
use eZ\Publish\API\Repository\Exceptions\NotImplementedException;

/**
 * The Location Search handler retrieves sets of of Location objects, based on a
 * set of criteria.
 */
class Handler implements LocationSearchHandler
{
    /**
     * Gateway for handling location data
     *
     * @var \eZ\Publish\Core\Persistence\Legacy\Content\Location\Gateway
     */
    protected $locationGateway;

    /**
     * Location locationMapper
     *
     * @var \eZ\Publish\Core\Persistence\Legacy\Content\Location\Mapper
     */
    protected $locationMapper;

    /**
     * Construct from search gateway and mapper
     *
     * @param \eZ\Publish\Core\Persistence\Legacy\Content\Search\Location\Gateway $locationGateway
     * @param \eZ\Publish\Core\Persistence\Legacy\Content\Location\Mapper $locationMapper
     */
    public function __construct( Gateway $locationGateway, LocationMapper $locationMapper )
    {
        $this->locationGateway = $locationGateway;
        $this->locationMapper = $locationMapper;
    }

    /**
     * @see \eZ\Publish\SPI\Persistence\Content\Location\Search\Handler::findLocations
     */
    public function findLocations( LocationQuery $query )
    {
        $start = microtime( true );
        $query->filter = $query->filter ?: new Criterion\MatchAll();
        $query->query = $query->query ?: new Criterion\MatchAll();

        if ( count( $query->facetBuilders ) )
        {
            throw new NotImplementedException( "Facets are not supported by the legacy search engine." );
        }

        // The legacy search does not know about scores, so we just
        // combine the query with the filter
        $data = $this->locationGateway->find(
            new Criterion\LogicalAnd( array( $query->query, $query->filter ) ),
            $query->offset,
            $query->limit,
            $query->sortClauses
        );

        $result = new SearchResult();
        $result->time = microtime( true ) - $start;
        $result->totalCount = $data['count'];

        foreach ( $this->locationMapper->createLocationsFromRows( $data['rows'] ) as $location )
        {
            $result->searchHits[] = new SearchHit( array( "valueObject" => $location ) );
        }

        return $result;
    }
}
