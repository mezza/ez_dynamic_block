<?php
/**
 * File containing the CreatedURLAlias class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\REST\Server\Values;

use eZ\Publish\API\Repository\Values\ValueObject;

/**
 * Struct representing a freshly created URLAlias.
 */
class CreatedURLAlias extends ValueObject
{
    /**
     * The created URL alias
     *
     * @var \eZ\Publish\API\Repository\Values\Content\URLAlias
     */
    public $urlAlias;
}
