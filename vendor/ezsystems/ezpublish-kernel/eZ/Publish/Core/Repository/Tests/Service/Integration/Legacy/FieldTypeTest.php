<?php
/**
 * File contains: eZ\Publish\Core\Repository\Tests\Service\Integration\Legacy\FieldTypeTest class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\Repository\Tests\Service\Integration\Legacy;

use eZ\Publish\Core\Repository\Tests\Service\Integration\FieldTypeBase as BaseFieldTypeTest;

/**
 * Test case for FieldType Service using Legacy storage class
 */
class FieldTypeTest extends BaseFieldTypeTest
{
    protected function getRepository()
    {
        return Utils::getRepository();
    }
}
