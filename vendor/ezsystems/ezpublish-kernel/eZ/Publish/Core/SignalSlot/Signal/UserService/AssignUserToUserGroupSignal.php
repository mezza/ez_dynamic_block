<?php
/**
 * AssignUserToUserGroupSignal class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\SignalSlot\Signal\UserService;

use eZ\Publish\Core\SignalSlot\Signal;

/**
 * AssignUserToUserGroupSignal class
 * @package eZ\Publish\Core\SignalSlot\Signal\UserService
 */
class AssignUserToUserGroupSignal extends Signal
{
    /**
     * UserId
     *
     * @var mixed
     */
    public $userId;

    /**
     * UserGroupId
     *
     * @var mixed
     */
    public $userGroupId;
}
