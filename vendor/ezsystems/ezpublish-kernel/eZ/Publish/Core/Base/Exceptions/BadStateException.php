<?php
/**
 * Contains BadState Exception implementation
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\Base\Exceptions;

use eZ\Publish\API\Repository\Exceptions\BadStateException as APIBadStateException;
use Exception;

/**
 * BadState Exception implementation
 *
 * @use: throw new BadState( 'nodes', 'array' );
 */
class BadStateException extends APIBadStateException
{
    /**
     * Generates: "Argument '{$argumentName}' has a bad state: {$whatIsWrong}"
     *
     * @param string $argumentName
     * @param string $whatIsWrong
     * @param \Exception|null $previous
     */
    public function __construct( $argumentName, $whatIsWrong, Exception $previous = null )
    {
        parent::__construct(
            "Argument '{$argumentName}' has a bad state: {$whatIsWrong}",
            0,
            $previous
        );
    }
}
