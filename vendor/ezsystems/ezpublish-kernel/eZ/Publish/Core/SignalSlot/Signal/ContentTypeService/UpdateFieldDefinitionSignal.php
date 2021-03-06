<?php
/**
 * UpdateFieldDefinitionSignal class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\SignalSlot\Signal\ContentTypeService;

use eZ\Publish\Core\SignalSlot\Signal;

/**
 * UpdateFieldDefinitionSignal class
 * @package eZ\Publish\Core\SignalSlot\Signal\ContentTypeService
 */
class UpdateFieldDefinitionSignal extends Signal
{
    /**
     * ContentTypeDraftId
     *
     * @var mixed
     */
    public $contentTypeDraftId;

    /**
     * FieldDefinitionId
     *
     * @var mixed
     */
    public $fieldDefinitionId;
}
