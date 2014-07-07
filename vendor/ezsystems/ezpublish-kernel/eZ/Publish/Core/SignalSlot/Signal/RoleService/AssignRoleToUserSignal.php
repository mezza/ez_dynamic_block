<?php
/**
 * AssignRoleToUserSignal class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\SignalSlot\Signal\RoleService;

use eZ\Publish\Core\SignalSlot\Signal;

/**
 * AssignRoleToUserSignal class
 * @package eZ\Publish\Core\SignalSlot\Signal\RoleService
 */
class AssignRoleToUserSignal extends Signal
{
    /**
     * RoleId
     *
     * @var mixed
     */
    public $roleId;

    /**
     * UserId
     *
     * @var mixed
     */
    public $userId;

    /**
     * RoleLimitation
     *
     * @var \eZ\Publish\API\Repository\Values\User\Limitation\RoleLimitation
     */
    public $roleLimitation;
}
