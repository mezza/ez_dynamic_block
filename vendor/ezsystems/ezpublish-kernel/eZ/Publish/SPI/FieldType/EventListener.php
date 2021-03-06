<?php
/**
 * File containing the EventListener interface
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\SPI\FieldType;

/**
 * A field type interface which field types can optionally implement.
 *
 * Field types that implemented this interface will be notified about certain events, both before and after something
 * has happened. This allows the field type to perform certain actions.
 *
 * Note: This is a low level synchronous events, for more generic asynchronous events like sending out notifications,
 * please use the signal slot system instead (create and register a slot to listen to events).
 */
interface EventListener
{
    /**
     * This method is called on occurring events.
     *
     * This method is called on occurring events in the Core to allow
     * FieldTypes to react to such events.
     *
     * @param \eZ\Publish\SPI\FieldType\Event $event
     */
    public function handleEvent( Event $event );
}

