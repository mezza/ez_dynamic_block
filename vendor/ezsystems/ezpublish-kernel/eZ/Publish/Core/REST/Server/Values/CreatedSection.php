<?php
/**
 * File containing the CreatedSection class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\REST\Server\Values;

use eZ\Publish\API\Repository\Values\ValueObject;

/**
 * Struct representing a freshly created section.
 */
class CreatedSection extends ValueObject
{
    /**
     * The created section
     *
     * @var \eZ\Publish\API\Repository\Values\Content\Section
     */
    public $section;
}
