<?php
/**
 * File containing the DoctrineDatabase Composite field value handler class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\Persistence\Legacy\Content\Search\Common\Gateway\CriterionHandler\FieldValue\Handler;

use eZ\Publish\Core\Persistence\Legacy\Content\Search\Common\Gateway\CriterionHandler\FieldValue\Handler;

/**
 * Content locator gateway implementation using the DoctrineDatabase.
 *
 * Composite value handler is used for creating a filter on a value that can be partially matched.
 * Eg. TextLine string, where it makes sense to match only a part of the sentence.
 */
class Composite extends Handler
{
}