<?php
/**
 * File containing the Role class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\SPI\Persistence\User;

use eZ\Publish\SPI\Persistence\ValueObject;

/**
 */
class Role extends ValueObject
{
    /**
     * ID of the user rule
     *
     * @var mixed
     */
    public $id;

    /**
     * Identifier of the role
     *
     * Legacy note: Maps to name in 4.x.
     *
     * @var string
     */
    public $identifier;

    /**
     * Name of the role
     *
     * @since 5.0
     * @var string[]
     */
    public $name;

    /**
     * Name of the role
     *
     * @since 5.0
     * @var string[]
     */
    public $description = array();

    /**
     * Policies associated with the role
     *
     * @var \eZ\Publish\SPI\Persistence\User\Policy[]
     */
    public $policies = array();
}
