<?php
/**
 * File containing the UserSession class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\REST\Server\Values;

use eZ\Publish\Core\REST\Common\Value as RestValue;
use eZ\Publish\API\Repository\Values\User\User;

/**
 * User list view model
 */
class UserSession extends RestValue
{
    /**
     * User
     *
     * @var \eZ\Publish\API\Repository\Values\User\User
     */
    public $user;

    /**
     * Session name
     *
     * @var string
     */
    public $sessionName;

    /**
     * Session ID
     * @var string
     */
    public $sessionId;

    /**
     * CSRF token value
     * @var string
     */
    public $csrfToken;

    /**
     * True if session exists
     * @var boolean
     */
    public $exists;
    /**
     * @param \eZ\Publish\API\Repository\Values\User\User $user
     * @param string $sessionName
     * @param string $sessionId
     * @param string $csrfToken
     */
    public function __construct( User $user, $sessionName, $sessionId, $csrfToken, $created )
    {
        $this->user = $user;
        $this->sessionName = $sessionName;
        $this->sessionId = $sessionId;
        $this->csrfToken = $csrfToken;
        $this->created = $created;
    }
}
