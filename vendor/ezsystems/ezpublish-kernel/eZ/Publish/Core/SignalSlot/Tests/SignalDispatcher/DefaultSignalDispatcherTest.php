<?php
/**
 * File containing a test class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\SignalSlot\Tests\SignalDispatcher;

use eZ\Publish\Core\SignalSlot;
use PHPUnit_Framework_TestCase;

/**
 * @group signalSlot
 */
class DefaultSignalDispatcherTest extends PHPUnit_Framework_TestCase
{
    public function testEmitSignalNoSlot()
    {
        $signal = $this->getMock( '\\eZ\\Publish\\Core\\SignalSlot\\Signal' );

        $dispatcher = new SignalSlot\SignalDispatcher\DefaultSignalDispatcher();
        $dispatcher->emit( $signal );
    }

    public function testEmitSignalSingleSlot()
    {
        $signal = $this->getMock( '\\eZ\\Publish\\Core\\SignalSlot\\Signal' );
        $slot = $this->getMock( '\\eZ\\Publish\\Core\\SignalSlot\\Slot' );
        $slot
            ->expects( $this->once() )
            ->method( 'receive' )
            ->with( $signal );

        $dispatcher = new SignalSlot\SignalDispatcher\DefaultSignalDispatcher();
        $dispatcher->attach( '\\' . get_class( $signal ), $slot );
        $dispatcher->emit( $signal );
    }

    public function testEmitSignalSingleSlotRelative()
    {
        $signal = new SignalSlot\Signal\ContentService\PublishVersionSignal();
        $slot = $this->getMock( '\\eZ\\Publish\\Core\\SignalSlot\\Slot' );
        $slot
            ->expects( $this->once() )
            ->method( 'receive' )
            ->with( $signal );

        $dispatcher = new SignalSlot\SignalDispatcher\DefaultSignalDispatcher();
        $dispatcher->attach( 'ContentService\\PublishVersionSignal', $slot );
        $dispatcher->emit( $signal );
    }

    public function testEmitSignalMultipleSlots()
    {
        $signal = $this->getMock( '\\eZ\\Publish\\Core\\SignalSlot\\Signal' );
        $slot = $this->getMock( '\\eZ\\Publish\\Core\\SignalSlot\\Slot' );
        $slot
            ->expects( $this->once() )
            ->method( 'receive' )
            ->with( $signal );
        $slot2 = $this->getMock( '\\eZ\\Publish\\Core\\SignalSlot\\Slot' );
        $slot2
            ->expects( $this->once() )
            ->method( 'receive' )
            ->with( $signal );
        $slot3 = $this->getMock( '\\eZ\\Publish\\Core\\SignalSlot\\Slot' );
        $slot3
            ->expects( $this->once() )
            ->method( 'receive' )
            ->with( $signal );

        $dispatcher = new SignalSlot\SignalDispatcher\DefaultSignalDispatcher();
        $dispatcher->attach( '\\' . get_class( $signal ), $slot );
        $dispatcher->attach( '\\' . get_class( $signal ), $slot2 );
        // Registering a wildcard slot. It is supposed to receive all the signals, whatever they are.
        $dispatcher->attach( '*', $slot3 );
        $dispatcher->emit( $signal );
    }
}
