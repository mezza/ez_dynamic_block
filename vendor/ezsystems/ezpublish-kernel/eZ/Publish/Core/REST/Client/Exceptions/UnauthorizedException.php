<?php
/**
 * File containing the UnauthorizedException class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\REST\Client\Exceptions;

use eZ\Publish\API\Repository\Exceptions\UnauthorizedException as APIUnauthorizedException;

/**
 * Implementation of the {@link \eZ\Publish\API\Repository\Exceptions\UnauthorizedException}
 * interface.
 *
 * @see \eZ\Publish\API\Repository\Exceptions\UnauthorizedException
 */
class UnauthorizedException extends APIUnauthorizedException
{
}
