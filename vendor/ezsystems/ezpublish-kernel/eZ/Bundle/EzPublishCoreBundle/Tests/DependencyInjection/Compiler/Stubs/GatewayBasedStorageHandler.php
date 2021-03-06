<?php
/**
 * File containing the GatewayBasedStorageHandler class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Bundle\EzPublishCoreBundle\Tests\DependencyInjection\Compiler\Stubs;

use eZ\Publish\Core\FieldType\GatewayBasedStorage;
use eZ\Publish\SPI\Persistence\Content\Field;
use eZ\Publish\SPI\Persistence\Content\VersionInfo;

/**
 * Stub implementation of GatewayBasedStorage.
 */
class GatewayBasedStorageHandler extends GatewayBasedStorage
{
    public function storeFieldData( VersionInfo $versionInfo, Field $field, array $context )
    {

    }

    public function getFieldData( VersionInfo $versionInfo, Field $field, array $context )
    {

    }

    public function deleteFieldData( VersionInfo $versionInfo, array $fieldIds, array $context )
    {

    }

    public function hasFieldData()
    {

    }

    public function getIndexData( VersionInfo $versionInfo, Field $field, array $context )
    {

    }
}
