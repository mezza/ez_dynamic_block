<?php
/**
 * UpdateSectionSignal class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\SignalSlot\Signal\SectionService;

use eZ\Publish\Core\SignalSlot\Signal;

/**
 * UpdateSectionSignal class
 * @package eZ\Publish\Core\SignalSlot\Signal\SectionService
 */
class UpdateSectionSignal extends Signal
{
    /**
     * SectionId
     *
     * @var mixed
     */
    public $sectionId;
}
