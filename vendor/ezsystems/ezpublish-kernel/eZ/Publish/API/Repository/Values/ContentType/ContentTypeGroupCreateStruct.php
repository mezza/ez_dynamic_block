<?php
/**
 * File containing the eZ\Publish\API\Repository\Values\ContentType\ContentTypeGroupCreateStruct class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\API\Repository\Values\ContentType;

use eZ\Publish\API\Repository\Values\ValueObject;

/**
 * This class is used for creating a content type group
 */
class ContentTypeGroupCreateStruct extends ValueObject
{
    /**
     * Readable & unique string identifier of a group
     *
     * @required
     *
     * @var string
     */
    public $identifier;

    /**
     * If set this value overrides the current user as creator
     *
     * @var mixed
     */
    public $creatorId = null;

    /**
     * If set this value overrides the current time for creation
     *
     * @var \DateTime
     */
    public $creationDate = null;
}
