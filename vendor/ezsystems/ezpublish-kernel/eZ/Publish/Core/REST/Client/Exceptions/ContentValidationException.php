<?php
/**
 * File containing the ContentValidationException class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\REST\Client\Exceptions;

use eZ\Publish\API\Repository\Exceptions\ContentValidationException as APIContentValidationException;

/**
 * Implementation of the {@link \eZ\Publish\API\Repository\Exceptions\ContentValidationException}
 * interface.
 *
 * @see \eZ\Publish\API\Repository\Exceptions\ContentValidationException
 */
class ContentValidationException extends APIContentValidationException
{
}
