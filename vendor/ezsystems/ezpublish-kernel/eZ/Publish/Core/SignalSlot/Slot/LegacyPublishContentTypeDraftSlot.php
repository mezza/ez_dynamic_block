<?php
/**
 * File containing the Legacy\PublishContentTypeDraft class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\SignalSlot\Slot;

use eZ\Publish\Core\SignalSlot\Signal;
use eZExpiryHandler;

/**
 * A legacy slot handling PublishContentTypeDraftSignal.
 */
class LegacyPublishContentTypeDraftSlot extends AbstractLegacySlot
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
        if ( !$signal instanceof Signal\ContentTypeService\PublishContentTypeDraftSignal )
            return;

        $kernel = $this->getLegacyKernel();
        $kernel->runCallback(
            function () use ( $signal )
            {
                eZExpiryHandler::registerShutdownFunction();
                $handler = eZExpiryHandler::instance();
                $time = time();
                $handler->setTimestamp( 'user-class-cache', $time );
                $handler->setTimestamp( 'class-identifier-cache', $time );
                $handler->setTimestamp( 'sort-key-cache', $time );
                $handler->store();
            },
            false
        );
    }
}
