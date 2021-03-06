<?php
/**
 * File containing the User Value class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\FieldType\User;

use eZ\Publish\Core\FieldType\Value as BaseValue;

/**
 * Value for User field type
 */
class Value extends BaseValue
{
    /**
     * Has stored login
     *
     * @var boolean
     */
    public $hasStoredLogin;

    /**
     * Contentobject id
     *
     * @var mixed
     */
    public $contentId;

    /**
     * Login
     *
     * @var string
     */
    public $login;

    /**
     * Email
     *
     * @var string
     */
    public $email;

    /**
     * Password hash
     *
     * @var string
     */
    public $passwordHash;

    /**
     * Password hash type
     *
     * @var mixed
     */
    public $passwordHashType;

    /**
     * Is enabled
     *
     * @var boolean
     */
    public $enabled;

    /**
     * Max login
     *
     * @var int
     */
    public $maxLogin;

    /**
     * @see \eZ\Publish\Core\FieldType\Value
     */
    public function __toString()
    {
        return (string)$this->login;
    }
}

