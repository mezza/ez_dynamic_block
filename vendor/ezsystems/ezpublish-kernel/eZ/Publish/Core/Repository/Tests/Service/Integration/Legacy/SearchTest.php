<?php
/**
 * File contains: eZ\Publish\Core\Repository\Tests\Service\Integration\Legacy\SearchTest class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\Repository\Tests\Service\Integration\Legacy;

use eZ\Publish\Core\Repository\Tests\Service\Integration\SearchBase as BaseSearchServiceTest;
use Exception;

/**
 * Test case for Search Service using Legacy storage class
 */
class SearchTest extends BaseSearchServiceTest
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
