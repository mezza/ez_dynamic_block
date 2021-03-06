<?php
/**
 * EnableLanguageSignal class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\SignalSlot\Signal\LanguageService;

use eZ\Publish\Core\SignalSlot\Signal;

/**
 * EnableLanguageSignal class
 * @package eZ\Publish\Core\SignalSlot\Signal\LanguageService
 */
class EnableLanguageSignal extends Signal
{
    /**
     * LanguageId
     *
     * @var mixed
     */
    public $languageId;
}
