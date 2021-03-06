<?php
/**
 * File containing the DoctrineDatabase sort clause handler class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\Persistence\Legacy\Content\Search\Common\Gateway;

use eZ\Publish\Core\Persistence\Database\DatabaseHandler;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause;
use eZ\Publish\Core\Persistence\Database\SelectQuery;

/**
 * Handler for a single sort clause
 */
abstract class SortClauseHandler
{
    /**
     * Database handler
     *
     * @var \eZ\Publish\Core\Persistence\Database\DatabaseHandler
     */
    protected $dbHandler;

    /**
     * Creates a new sort clause handler
     *
     * @param \eZ\Publish\Core\Persistence\Database\DatabaseHandler $dbHandler
     */
    public function __construct( DatabaseHandler $dbHandler )
    {
        $this->dbHandler = $dbHandler;
    }

    /**
     * Check if this sort clause handler accepts to handle the given sort clause.
     *
     * @param \eZ\Publish\API\Repository\Values\Content\Query\SortClause $sortClause
     *
     * @return boolean
     */
    abstract public function accept( SortClause $sortClause );

    /**
     * Apply selects to the query
     *
     * Returns the name of the (aliased) column, which information should be
     * used for sorting.
     *
     * @param \eZ\Publish\Core\Persistence\Database\SelectQuery $query
     * @param \eZ\Publish\API\Repository\Values\Content\Query\SortClause $sortClause
     * @param int $number
     *
     * @return string
     */
    abstract public function applySelect( SelectQuery $query, SortClause $sortClause, $number );

    /**
     * Applies joins to the query
     *
     * @param \eZ\Publish\Core\Persistence\Database\SelectQuery $query
     * @param \eZ\Publish\API\Repository\Values\Content\Query\SortClause $sortClause
     * @param int $number
     */
    public function applyJoin( SelectQuery $query, SortClause $sortClause, $number )
    {
    }

    /**
     * Returns the quoted sort column name
     *
     * @param int $number
     *
     * @return string
     */
    protected function getSortColumnName( $number )
    {
        return $this->dbHandler->quoteIdentifier( 'sort_column_' . $number );
    }

    /**
     * Returns the sort table name
     *
     * @param int $number
     * @param null|string $externalTableName
     *
     * @return string
     */
    protected function getSortTableName( $number, $externalTableName = null )
    {
        return 'sort_table_' . ( $externalTableName !== null ? $externalTableName . "_" : "" ) . $number;
    }
}

