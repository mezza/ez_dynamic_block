<?php
/**
 * AssignSectionSignal class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\SignalSlot\Signal\SectionService;

use eZ\Publish\Core\SignalSlot\Signal;

/**
 * AssignSectionSignal class
 * @package eZ\Publish\Core\SignalSlot\Signal\SectionService
 */
class AssignSectionSignal extends Signal
{
    /**
     * ContentId
     *
     * @var mixed
     */
    public $contentId;

    /**
     * SectionId
     *
     * @var mixed
     */
    public $sectionId;
}
