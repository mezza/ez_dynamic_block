<?php
/**
 * File containing the DateAndTimeProcessor class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\REST\Common\FieldTypeProcessor;

use eZ\Publish\Core\REST\Common\FieldTypeProcessor;
use eZ\Publish\Core\FieldType\DateAndTime\Type;

class DateAndTimeProcessor extends FieldTypeProcessor
{
    /**
     * {@inheritDoc}
     */
    public function preProcessFieldSettingsHash( $incomingSettingsHash )
    {
        if ( isset( $incomingSettingsHash["defaultType"] ) )
        {
            switch ( $incomingSettingsHash["defaultType"] )
            {
                case 'DEFAULT_EMPTY':
                    $incomingSettingsHash["defaultType"] = Type::DEFAULT_EMPTY;
                    break;
                case 'DEFAULT_CURRENT_DATE':
                    $incomingSettingsHash["defaultType"] = Type::DEFAULT_CURRENT_DATE;
                    break;
                case 'DEFAULT_CURRENT_DATE_ADJUSTED':
                    $incomingSettingsHash["defaultType"] = Type::DEFAULT_CURRENT_DATE_ADJUSTED;
            }
        }

        return $incomingSettingsHash;
    }

    /**
     * {@inheritDoc}
     */
    public function postProcessFieldSettingsHash( $outgoingSettingsHash )
    {
        if ( isset( $outgoingSettingsHash["defaultType"] ) )
        {
            switch ( $outgoingSettingsHash["defaultType"] )
            {
                case Type::DEFAULT_EMPTY:
                    $outgoingSettingsHash["defaultType"] = 'DEFAULT_EMPTY';
                    break;
                case Type::DEFAULT_CURRENT_DATE:
                    $outgoingSettingsHash["defaultType"] = 'DEFAULT_CURRENT_DATE';
                    break;
                case Type::DEFAULT_CURRENT_DATE_ADJUSTED:
                    $outgoingSettingsHash["defaultType"] = 'DEFAULT_CURRENT_DATE_ADJUSTED';
            }
        }

        return $outgoingSettingsHash;
    }
}
