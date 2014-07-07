<?php
/**
 * File containing the SiteAccessAware class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\MVC\Symfony\SiteAccess;

use eZ\Publish\Core\MVC\Symfony\SiteAccess;

/**
 * Interface for SiteAccess aware services.
 */
interface SiteAccessAware
{
    public function setSiteAccess( SiteAccess $siteAccess = null );
}
