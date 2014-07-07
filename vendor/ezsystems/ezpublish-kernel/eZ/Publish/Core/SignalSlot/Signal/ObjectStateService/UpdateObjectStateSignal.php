<?php
/**
 * UpdateObjectStateSignal class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\SignalSlot\Signal\ObjectStateService;

use eZ\Publish\Core\SignalSlot\Signal;

/**
 * UpdateObjectStateSignal class
 * @package eZ\Publish\Core\SignalSlot\Signal\ObjectStateService
 */
class UpdateObjectStateSignal extends Signal
{
    /**
     * ObjectStateId
     *
     * @var mixed
     */
    public $objectStateId;
}
