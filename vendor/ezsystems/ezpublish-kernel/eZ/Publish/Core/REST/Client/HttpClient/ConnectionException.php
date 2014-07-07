<?php
/**
 * File containing the ContentValidationException class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\REST\Client\HttpClient;

use RuntimeException;

/**
 * HTTPClient connection exception
 */
class ConnectionException extends RuntimeException
{
    /**
     * Constructor
     *
     * @param string $server
     * @param string $path
     * @param string $method
     */
    public function __construct( $server, $path, $method )
    {
        parent::__construct(
            "Could not connect to server '$server' and retrieve '$path' with '$method'."
        );
    }
}
