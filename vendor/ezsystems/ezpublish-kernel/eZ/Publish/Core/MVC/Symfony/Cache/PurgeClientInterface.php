<?php
/**
 * File containing the Cache PurgeClientInterface class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\MVC\Symfony\Cache;

interface PurgeClientInterface
{
    /**
     * Triggers the cache purge $cacheElements.
     *
     * @param mixed $cacheElements Cache resource(s) to purge (e.g. array of URI to purge in a reverse proxy)
     *
     * @return void
     */
    public function purge( $cacheElements );

    /**
     * Purges all content elements currently in cache.
     *
     * @return void
     */
    public function purgeAll();
}
