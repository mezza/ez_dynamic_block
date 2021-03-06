<?php
/**
 * File containing an interface for the Zeta Database abstractions
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\Persistence\Legacy;

/**
 * This interface is added in Doctrine DBAL introduction for Legacy Storage
 * and exists only to prevent breakages in the external storage Gateways of
 * user implemented FieldTypes that might rely on its existence for setting
 * data storage connection.
 *
 * @see \eZ\Publish\Core\FieldType\StorageGateway::setConnection()
 * @see \eZ\Publish\Core\Persistence\Database\DatabaseHandler
 */
interface EzcDbHandler
{
}
