<?php
/**
 * File containing the URLAliasList class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\REST\Server\Values;

use eZ\Publish\Core\REST\Common\Value as RestValue;

/**
 * URLAlias list view model
 */
class URLAliasList extends RestValue
{
    /**
     * URL aliases
     *
     * @var \eZ\Publish\API\Repository\Values\Content\URLAlias[]
     */
    public $urlAliases;

    /**
     * Path used to load the list of URL aliases
     *
     * @var string
     */
    public $path;

    /**
     * Construct
     *
     * @param \eZ\Publish\API\Repository\Values\Content\URLAlias[] $urlAliases
     * @param string $path
     */
    public function __construct( array $urlAliases, $path )
    {
        $this->urlAliases = $urlAliases;
        $this->path = $path;
    }
}
