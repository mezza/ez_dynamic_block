<?php
/**
 * File containing the Legacy\HideLocationSlot class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\SignalSlot\Slot;

use eZ\Publish\Core\SignalSlot\Signal;
use eZContentObject;
use eZContentObjectTreeNode;
use eZSearch;

/**
 * A legacy slot handling HideLocationSignal.
 */
class LegacyHideLocationSlot extends AbstractLegacySlot
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
        if ( !$signal instanceof Signal\LocationService\HideLocationSignal )
            return;

        $kernel = $this->getLegacyKernel();
        $kernel->runCallback(
            function () use ( $signal )
            {
                $node = eZContentObjectTreeNode::fetch( $signal->locationId );
                eZContentObjectTreeNode::clearViewCacheForSubtree( $node );
                eZSearch::updateNodeVisibility( $signal->locationId, 'hide' );
                eZContentObject::clearCache();// Clear all object memory cache to free memory
            },
            false
        );
    }
}
