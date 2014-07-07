<?php
/**
 * File containing the FieldTypeProcessor base class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\REST\Common;

/**
 * FieldTypeProcessor
 */
abstract class FieldTypeProcessor
{
    /**
     * Perform manipulations on a received $incomingValueHash
     *
     * This method is called by the REST input parsers to allow a field
     * type to pre process the given $incomingValueHash before it is handled by
     * {@link eZ\Publish\SPI\FieldType\FieldType::fromHash()}. The
     * $incomingValueHash can be expected to conform to the rules that need to
     * apply to hashes accepted by fromHash(). The return value of this method
     * replaces the $incomingValueHash.
     *
     * @see \eZ\Publish\Core\REST\Common\Input\FieldTypeParser
     *
     * @param mixed $incomingValueHash
     *
     * @return mixed Pre processed hash
     */
    public function preProcessValueHash( $incomingValueHash )
    {
        return $incomingValueHash;
    }

    /**
     * Perform manipulations on an a generated $outgoingValueHash
     *
     * This method is called by the REST output visitors to allow a field type to
     * post process the given $outgoingValueHash, which was previously generated
     * using {@link eZ\Publish\SPI\FieldType\FieldType::toHash()}, before it is
     * sent to the client. The return value of this method replaces
     * $outgoingValueHash and must obey to the same rules as the original
     * $outgoingValueHash.
     *
     * @see \eZ\Publish\Core\REST\Common\Output\FieldTypeSerializer
     *
     * @param mixed $outgoingValueHash
     *
     * @return mixed Post processed hash
     */
    public function postProcessValueHash( $outgoingValueHash )
    {
        return $outgoingValueHash;
    }

    /**
     * Perform manipulations on a received $incomingSettingsHash
     *
     * This method is called by the REST input parsers to allow a field type to
     * pre process the given $incomingSettingsHash before it is handled by
     * {@link eZ\Publish\SPI\FieldType\FieldType::fieldSettingsFromHash()}. The
     * $incomingSettingsHash can be expected to conform to the rules that
     * need to apply to hashes accepted by fieldSettingsFromHash(). The return
     * value of this method replaces the $incomingSettingsHash.
     *
     * @see \eZ\Publish\Core\REST\Common\Input\FieldTypeParser
     *
     * @param mixed $incomingSettingsHash
     *
     * @return mixed Pre processed hash
     */
    public function preProcessFieldSettingsHash( $incomingSettingsHash )
    {
        return $incomingSettingsHash;
    }

    /**
     * Perform manipulations on a received $outgoingSettingsHash
     *
     * This method is called by the REST output visitors to allow a field type to post
     * process the given $outgoingSettingsHash, which was previously generated
     * using {@link eZ\Publish\SPI\FieldType\FieldType::fieldSettingsToHash()},
     * before it is sent to the client. The return value of this method replaces
     * $outgoingSettingsHash and must obey to the same rules as the original
     * $outgoingSettingsHash.
     *
     * @see \eZ\Publish\Core\REST\Common\Output\FieldTypeSerializer
     *
     * @param mixed $outgoingSettingsHash
     *
     * @return mixed Post processed hash
     */
    public function postProcessFieldSettingsHash( $outgoingSettingsHash )
    {
        return $outgoingSettingsHash;
    }

    /**
     * Perform manipulations on a received $incomingValidatorConfigurationHash
     *
     * This method is called by the REST input parsers to allow a field type to pre
     * process the given $incomingValidatorConfigurationHash before it is handled
     * by {@link eZ\Publish\SPI\FieldType\FieldType::validatorConfigurationFromHash()}.
     * The $incomingValidatorConfigurationHash can be expected to conform to the
     * rules that need to apply to hashes accepted by validatorConfigurationFromHash().
     * The return value of this method replaces the $incomingValidatorConfigurationHash.
     *
     * @see \eZ\Publish\Core\REST\Common\Input\FieldTypeParser
     *
     * @param mixed $incomingValidatorConfigurationHash
     *
     * @return mixed Pre processed hash
     */
    public function preProcessValidatorConfigurationHash( $incomingValidatorConfigurationHash )
    {
        return $incomingValidatorConfigurationHash;
    }

    /**
     * Perform manipulations on a received $outgoingValidatorConfigurationHash
     *
     * This method is called by the REST output visitors to allow a field type to post
     * process the given $outgoingValidatorConfigurationHash, which was previously generated
     * using {@link eZ\Publish\SPI\FieldType\FieldType::validatorConfigurationToHash()},
     * before it is sent to the client. The return value of this method replaces
     * $outgoingValidatorConfigurationHash and must obey to the same rules as the original
     * $outgoingValidatorConfigurationHash.
     *
     * @see \eZ\Publish\Core\REST\Common\Output\FieldTypeSerializer
     *
     * @param mixed $outgoingValidatorConfigurationHash
     *
     * @return mixed Post processed hash
     */
    public function postProcessValidatorConfigurationHash( $outgoingValidatorConfigurationHash )
    {
        return $outgoingValidatorConfigurationHash;
    }
}
