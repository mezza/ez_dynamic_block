<?php
/**
 * File containing the Solr\Slot\CreateUser class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\Persistence\Solr\Slot;

use eZ\Publish\Core\SignalSlot\Signal;
use eZ\Publish\Core\Persistence\Solr\Slot;

/**
 * A Solr slot handling CreateUserSignal.
 */
class CreateUser extends Slot
{
    /**
     * Receive the given $signal and react on it
     *
     * @param \eZ\Publish\Core\SignalSlot\Signal $signal
     */
    public function receive( Signal $signal )
    {
        if ( !$signal instanceof Signal\UserService\CreateUserSignal )
            return;

        $userContentInfo = $this->persistenceHandler->contentHandler()->loadContentInfo( $signal->userId );

        $this->enqueueIndexing(
            $this->persistenceHandler->contentHandler()->load(
                $userContentInfo->id,
                $userContentInfo->currentVersionNo
            )
        );
    }
}
