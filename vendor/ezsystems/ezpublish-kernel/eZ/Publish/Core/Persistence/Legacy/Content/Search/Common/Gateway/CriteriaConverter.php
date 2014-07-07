<?php
/**
 * File containing the DoctrineDatabase criteria converter class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\Persistence\Legacy\Content\Search\Common\Gateway;

use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\Core\Persistence\Database\SelectQuery;
use eZ\Publish\API\Repository\Exceptions\NotImplementedException;

/**
 * Content locator gateway implementation using the DoctrineDatabase.
 */
class CriteriaConverter
{
    /**
     * Criterion handlers
     *
     * @var \eZ\Publish\Core\Persistence\Legacy\Content\Search\Common\Gateway\CriterionHandler[]
     */
    protected $handler;

    /**
     * Construct from an optional array of Criterion handlers
     *
     * @param \eZ\Publish\Core\Persistence\Legacy\Content\Search\Common\Gateway\CriterionHandler[] $handler
     */
    public function __construct( array $handler )
    {
        $this->handler = $handler;
    }

    /**
     * Generic converter of criteria into query fragments
     *
     * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException if Criterion is not applicable to its target
     *
     * @param \eZ\Publish\Core\Persistence\Database\SelectQuery $query
     * @param \eZ\Publish\API\Repository\Values\Content\Query\Criterion $criterion
     *
     * @return \eZ\Publish\Core\Persistence\Database\Expression
     */
    public function convertCriteria( SelectQuery $query, Criterion $criterion )
    {
        foreach ( $this->handler as $handler )
        {
            if ( $handler->accept( $criterion ) )
            {
                return $handler->handle( $this, $query, $criterion );
            }
        }

        throw new NotImplementedException(
            "No visitor available for: " . get_class( $criterion ) . ' with operator ' . $criterion->operator
        );
    }
}

