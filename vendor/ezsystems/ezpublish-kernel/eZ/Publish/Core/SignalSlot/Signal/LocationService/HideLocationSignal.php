<?php
/**
 * HideLocationSignal class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\SignalSlot\Signal\LocationService;

use eZ\Publish\Core\SignalSlot\Signal;

/**
 * HideLocationSignal class
 * @package eZ\Publish\Core\SignalSlot\Signal\LocationService
 */
class HideLocationSignal extends Signal
{
    /**
     * Location ID
     *
     * @var mixed
     */
    public $locationId;

    /**
     * Content ID
     *
     * @var mixed
     */
    public $contentId;

    /**
     * Content current version number
     *
     * @var int
     */
    public $currentVersionNo;
}
