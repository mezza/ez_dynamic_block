<?php
/**
 * File containing the eZ\Publish\API\Repository\Values\User\Limitation\SubtreeLimitation class.
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
use eZ\Publish\API\Repository\Values\Content\Location;
use eZ\Publish\API\Repository\Values\Content\LocationCreateStruct;
use eZ\Publish\Core\Base\Exceptions\InvalidArgumentException;
use eZ\Publish\Core\Base\Exceptions\InvalidArgumentType;
use eZ\Publish\API\Repository\Values\User\Limitation\SubtreeLimitation as APISubtreeLimitation;
use eZ\Publish\API\Repository\Values\User\Limitation as APILimitationValue;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\SPI\Limitation\Type as SPILimitationTypeInterface;
use eZ\Publish\Core\FieldType\ValidationError;
use eZ\Publish\SPI\Persistence\Content\Location as SPILocation;

/**
 * SubtreeLimitation is a Content Limitation & a Role Limitation
 */
class SubtreeLimitationType extends AbstractPersistenceLimitationType implements SPILimitationTypeInterface
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
        if ( !$limitationValue instanceof APISubtreeLimitation )
        {
            throw new InvalidArgumentType( "\$limitationValue", "APISubtreeLimitation", $limitationValue );
        }
        else if ( !is_array( $limitationValue->limitationValues ) )
        {
            throw new InvalidArgumentType( "\$limitationValue->limitationValues", "array", $limitationValue->limitationValues );
        }

        foreach ( $limitationValue->limitationValues as $key => $path )
        {
            if ( !is_string( $path ) )
            {
                throw new InvalidArgumentType( "\$limitationValue->limitationValues[{$key}]", "string", $path );
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
        foreach ( $limitationValue->limitationValues as $key => $path )
        {
            try
            {
                $pathArray = explode( '/', trim( $path, '/' ) );
                $subtreeRootLocationId = end( $pathArray );
                $spiLocation = $this->persistence->locationHandler()->load( $subtreeRootLocationId );
            }
            catch ( APINotFoundException $e )
            {
            }

            if ( !isset( $spiLocation ) || strpos( $spiLocation->pathString, $path ) !== 0 )
            {
                $validationErrors[] = new ValidationError(
                    "limitationValues[%key%] => '%value%' does not exist in the backend",
                    null,
                    array(
                        "value" => $path,
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
        return new APISubtreeLimitation( array( 'limitationValues' => $limitationValues ) );
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
        if ( !$value instanceof APISubtreeLimitation )
        {
            throw new InvalidArgumentException( '$value', 'Must be of type: APISubtreeLimitation' );
        }

        if ( $object instanceof ContentCreateStruct )
        {
            return $this->evaluateForContentCreateStruct( $value, $targets );
        }
        else if ( $object instanceof Content )
        {
            $object = $object->getVersionInfo()->getContentInfo();
        }
        else if ( $object instanceof VersionInfo )
        {
            $object = $object->getContentInfo();
        }
        else if ( !$object instanceof ContentInfo )
        {
            throw new InvalidArgumentException(
                '$object',
                'Must be of type: ContentCreateStruct, Content, VersionInfo or ContentInfo'
            );
        }

        // Load locations if no specific placement was provided
        if ( $targets === null )
        {
            if ( $object->published )
                $targets = $this->persistence->locationHandler()->loadLocationsByContent( $object->id );
            else// @todo Need support for draft locations to to work correctly
                $targets = $this->persistence->locationHandler()->loadParentLocationsForDraftContent( $object->id );
        }

        foreach ( $targets as $target )
        {
            if ( !$target instanceof Location && !$target instanceof SPILocation )
            {
                // Since this limitation is used as role limitation, "wrong" $target simply returns false
                return false;
            }

            foreach ( $value->limitationValues as $limitationPathString )
            {
                if ( $target->pathString === $limitationPathString )
                {
                    return true;
                }
                if ( strpos( $target->pathString, $limitationPathString ) === 0 )
                {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Evaluate permissions for ContentCreateStruct against LocationCreateStruct placements.
     *
     * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException If $targets does not contain
     *         objects of type LocationCreateStruct
     *
     * @param \eZ\Publish\API\Repository\Values\User\Limitation $value
     * @param array $targets
     *
     * @return bool
     */
    protected function evaluateForContentCreateStruct( APILimitationValue $value, array $targets )
    {
        // If targets is empty/null return false as user does not have access
        // to content w/o location with this limitation
        if ( empty( $targets ) )
        {
            return false;
        }

        foreach ( $targets as $target )
        {
            if ( !$target instanceof LocationCreateStruct )
            {
                throw new InvalidArgumentException(
                    '$targets',
                    'If $object is ContentCreateStruct must contain objects of type: LocationCreateStruct'
                );
            }

            $target = $this->persistence->locationHandler()->load( $target->parentLocationId );

            // For ContentCreateStruct all placements must match
            foreach ( $value->limitationValues as $limitationPathString )
            {
                if ( $target->pathString === $limitationPathString )
                {
                    continue 2;
                }
                if ( strpos( $target->pathString, $limitationPathString ) === 0 )
                {
                    continue 2;
                }
            }

            return false;
        }

        return true;
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
            return new Criterion\Subtree( $value->limitationValues[0] );

        // several limitation values: IN operation
        return new Criterion\Subtree( $value->limitationValues );
    }

    /**
     * Returns info on valid $limitationValues
     *
     * @return mixed[]|int In case of array, a hash with key as valid limitations value and value as human readable name
     *                     of that option, in case of int on of VALUE_SCHEMA_ constants.
     */
    public function valueSchema()
    {
        return self::VALUE_SCHEMA_LOCATION_PATH;
    }
}
