<?php
/**
 * File contains: eZ\Publish\Core\Repository\Tests\Service\Integration\Legacy\LocationTest class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\Repository\Tests\Service\Integration\Legacy;

use eZ\Publish\Core\Repository\Tests\Service\Integration\LocationBase as BaseLocationServiceTest;
use Exception;

/**
 * Test case for Location Service using Legacy storage class
 */
class LocationTest extends BaseLocationServiceTest
{
    protected function getRepository()
    {
        try
        {
            return Utils::getRepository();
        }
        catch ( Exception $e )
        {
            $this->markTestIncomplete(  $e->getMessage() );
        }
    }
}
