<?php
/**
 * File containing the eZ\Publish\API\Repository\Exceptions\ContentValidationException class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\API\Repository\Exceptions;

/**
 * This Exception is thrown on create or update content one or more given fields are not valid
 */
abstract class ContentValidationException extends ForbiddenException
{
}
