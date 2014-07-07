<?php
/**
 * File containing the ParameterNotFoundException class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\MVC\Exception;

use InvalidArgumentException;

/**
 * This exception is thrown when a dynamic parameter could not be found in any scope.
 */
class ParameterNotFoundException extends InvalidArgumentException
{
    public function __construct( $paramName, $namespace, array $triedScopes = array() )
    {
        $this->message = "Parameter '$paramName' with namespace '$namespace' could not be found.";
        if ( !empty( $triedScopes ) )
            $this->message .= " Tried scopes: " . implode( ', ', $triedScopes );
    }
}