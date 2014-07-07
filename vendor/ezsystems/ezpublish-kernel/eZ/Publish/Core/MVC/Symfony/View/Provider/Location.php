<?php
/**
 * File containing the View\Provider\Location interface.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\MVC\Symfony\View\Provider;

use eZ\Publish\API\Repository\Values\Content\Location as APIContentLocation;

/**
 * Interface for location view providers.
 *
 * Location view providers select a view for a given location, depending on its own internal rules.
 */
interface Location
{
    /**
     * Returns a ContentView object corresponding to $location, or null if not applicable
     *
     * @param \eZ\Publish\API\Repository\Values\Content\Location $location
     * @param string $viewType Variation of display for your content.
     *
     * @return \eZ\Publish\Core\MVC\Symfony\View\ContentView|null
     */
    public function getView( APIContentLocation $location, $viewType );
}
