<?php
/**
 * RemoveSignal class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\SignalSlot\Signal\URLWildcardService;

use eZ\Publish\Core\SignalSlot\Signal;

/**
 * RemoveSignal class
 * @package eZ\Publish\Core\SignalSlot\Signal\URLWildcardService
 */
class RemoveSignal extends Signal
{
    /**
     * UrlWildcardId
     *
     * @var mixed
     */
    public $urlWildcardId;
}
