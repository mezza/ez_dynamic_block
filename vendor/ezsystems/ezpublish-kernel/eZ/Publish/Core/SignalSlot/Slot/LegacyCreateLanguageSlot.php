<?php
/**
 * File containing the LegacyCreateLanguageSlot class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\SignalSlot\Slot;

use eZ\Publish\Core\SignalSlot\Signal;
use eZContentLanguage;

/**
 * A legacy slot handling CreateLanguageSignal.
 */
class LegacyCreateLanguageSlot extends AbstractLegacySlot
{
    /**
     * Receive the given $signal and react on it
     *
     * @param \eZ\Publish\Core\SignalSlot\Signal $signal
     *
     * @return void
     */
    public function receive( Signal $signal )
    {
        if ( !$signal instanceof Signal\LanguageService\CreateLanguageSignal )
        {
            return;
        }

        $kernel = $this->getLegacyKernel();
        $kernel->runCallback(
            function ()
            {
                eZContentLanguage::expireCache();
            },
            false
        );
    }
}
