<?php
/**
 * File containing the eZ\Publish\API\Repository\Values\Content\Query\Criterion\LogicalOr class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\API\Repository\Values\Content\Query\Criterion;

/**
 * This criterion implements a logical OR criterion and will only match
 * if AT LEAST ONE of the given criteria match
 */
class LogicalOr extends LogicalOperator
{
}
