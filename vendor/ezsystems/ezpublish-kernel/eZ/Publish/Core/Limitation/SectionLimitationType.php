<?php
/**
 * File containing the eZ\Publish\API\Repository\Values\User\Limitation\SectionLimitation class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\Limitation;

use eZ\Publish\API\Repository\Exceptions\NotFoundException as APINotFoundException;
use eZ\Publish\API\Repository\Values\ValueObject;
use eZ\Publish\API\Repository\Values\User\User as APIUser;
use eZ\Publish\API\Repository\Values\Content\Content;
use eZ\Publish\API\Repository\Values\Content\ContentInfo;
use eZ\Publish\API\Repository\Values\Content\ContentCreateStruct;
use eZ\Publish\API\Repository\Values\Content\VersionInfo;
use eZ\Publish\Core\Base\Exceptions\InvalidArgumentException;
use eZ\Publish\Core\Base\Exceptions\InvalidArgumentType;
use eZ\Publish\API\Repository\Values\User\Limitation\SectionLimitation as APISectionLimitation;
use eZ\Publish\API\Repository\Values\User\Limitation as APILimitationValue;
use eZ\Publish\SPI\Limitation\Type as SPILimitationTypeInterface;
use eZ\Publish\Core\FieldType\ValidationError;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;

/**
 * SectionLimitation is a Content Limitation & a Role Limitation
 */
class SectionLimitationType extends AbstractPersistenceLimitationType implements SPILimitationTypeInterface
{
    /**
     * Accepts a Limitation value and checks for structural validity.
     *
     * Makes sure LimitationValue object and ->limitationValues is of correct type.
     *
     * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException If the value does not match the expected type/structure
     *
     * @param \eZ\Publish\API\Repository\Values\User\Limitation $limitationValue
     */
    public function acceptValue( APILimitationValue $limitationValue )
    {
        if ( !$limitationValue instanceof APISectionLimitation )
        {
            throw new InvalidArgumentType( "\$limitationValue", "APISectionLimitation", $limitationValue );
        }
        else if ( !is_array( $limitationValue->limitationValues ) )
        {
            throw new InvalidArgumentType( "\$limitationValue->limitationValues", "array", $limitationValue->limitationValues );
        }

        foreach ( $limitationValue->limitationValues as $key => $id )
        {
            if ( !is_string( $id ) && !is_int( $id ) )
            {
                throw new InvalidArgumentType( "\$limitationValue->limitationValues[{$key}]", "int|string", $id );
            }
        }
    }

    /**
     * Makes sure LimitationValue->limitationValues is valid according to valueSchema().
     *
     * Make sure {@link acceptValue()} is checked first!
     *
     * @param \eZ\Publish\API\Repository\Values\User\Limitation $limitationValue
     *
     * @return \eZ\Publish\SPI\FieldType\ValidationError[]
     */
    public function validate( APILimitationValue $limitationValue )
    {
        $validationErrors = array();
        foreach ( $limitationValue->limitationValues as $key => $id )
        {
            try
            {
                $this->persistence->sectionHandler()->load( $id );
            }
            catch ( APINotFoundException $e )
            {
                $validationErrors[] = new ValidationError(
                    "limitationValues[%key%] => '%value%' does not exist in the backend",
                    null,
                    array(
                        "value" => $id,
                        "key" => $key
                    )
                );
            }
        }
        return $validationErrors;
    }

    /**
     * Create the Limitation Value
     *
     * @param mixed[] $limitationValues
     *
     * @return \eZ\Publish\API\Repository\Values\User\Limitation
     */
    public function buildValue( array $limitationValues )
    {
        return new APISectionLimitation( array( 'limitationValues' => $limitationValues ) );
    }

    /**
     * Evaluate permission against content & target(placement/parent/assignment)
     *
     * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException If any of the arguments are invalid
     *         Example: If LimitationValue is instance of ContentTypeLimitationValue, and Type is SectionLimitationType.
     * @throws \eZ\Publish\API\Repository\Exceptions\BadStateException If value of the LimitationValue is unsupported
     *         Example if OwnerLimitationValue->limitationValues[0] is not one of: [ 1,  2 ]
     *
     * @param \eZ\Publish\API\Repository\Values\User\Limitation $value
     * @param \eZ\Publish\API\Repository\Values\User\User $currentUser
     * @param \eZ\Publish\API\Repository\Values\ValueObject $object
     * @param \eZ\Publish\API\Repository\Values\ValueObject[]|null $targets The context of the $object, like Location of Content, if null none where provided by caller
     *
     * @return boolean
     */
    public function evaluate( APILimitationValue $value, APIUser $currentUser, ValueObject $object, array $targets = null )
    {
        if ( !$value instanceof APISectionLimitation )
        {
            throw new InvalidArgumentException( '$value', 'Must be of type: APISectionLimitation' );
        }

        if ( $object instanceof Content )
        {
            $object = $object->getVersionInfo()->getContentInfo();
        }
        else if ( $object instanceof VersionInfo )
        {
            $object = $object->getContentInfo();
        }
        else if ( !$object instanceof ContentInfo && !$object instanceof ContentCreateStruct )
        {
            throw new InvalidArgumentException(
                '$object',
                'Must be of type: ContentCreateStruct, Content, VersionInfo or ContentInfo'
            );
        }

        if ( empty( $value->limitationValues ) )
        {
            return false;
        }

        /**
         * @var $object ContentInfo|ContentCreateStruct
         */
        return in_array( $object->sectionId, $value->limitationValues );
    }

    /**
     * Returns Criterion for use in find() query
     *
     * @param \eZ\Publish\API\Repository\Values\User\Limitation $value
     * @param \eZ\Publish\API\Repository\Values\User\User $currentUser
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Query\CriterionInterface
     */
    public function getCriterion( APILimitationValue $value, APIUser $currentUser )
    {
        if ( empty( $value->limitationValues )  )// no limitation values
            throw new \RuntimeException( "\$value->limitationValues is empty, it should not have been stored in the first place" );

        if ( !isset( $value->limitationValues[1] ) )// 1 limitation value: EQ operation
            return new Criterion\SectionId( $value->limitationValues[0] );

        // several limitation values: IN operation
        return new Criterion\SectionId( $value->limitationValues );
    }

    /**
     * Returns info on valid $limitationValues
     *
     * @return mixed[]|int In case of array, a hash with key as valid limitations value and value as human readable name
     *                     of that option, in case of int on of VALUE_SCHEMA_ constants.
     */
    public function valueSchema()
    {
        throw new \eZ\Publish\API\Repository\Exceptions\NotImplementedException( __METHOD__ );
    }
}
