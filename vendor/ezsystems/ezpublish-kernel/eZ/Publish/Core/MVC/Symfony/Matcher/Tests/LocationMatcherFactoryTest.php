<?php
/**
 * File containing the LocationMatcherFactoryTest class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\MVC\Symfony\Matcher\Tests;

class LocationMatcherFactoryTest extends ContentBasedMatcherFactoryTest
{
    protected $matcherFactoryClass = 'eZ\\Publish\\Core\\MVC\\Symfony\\Matcher\\LocationMatcherFactory';

    /**
     * Returns a valid ValueObject (supported by current MatcherFactory), that will match the test rules.
     * i.e. Should return eZ\Publish\API\Repository\Values\Content\Location for LocationMatcherFactory
     *
     * @return \eZ\Publish\API\Repository\Values\ValueObject
     */
    protected function getMatchableValueObject()
    {
        return $this->getLocationMock( array( 'id' => 456 ) );
    }

    /**
     * Returns a valid ValueObject (supported by current MatcherFactory), that won't match the test rules.
     * i.e. Should return eZ\Publish\API\Repository\Values\Content\Location for LocationMatcherFactory
     *
     * @return \eZ\Publish\API\Repository\Values\ValueObject
     */
    protected function getNonMatchableValueObject()
    {
        return $this->getLocationMock( array( 'id' => 123456789 ) );
    }

    protected function getMatcherClass()
    {
        return 'Id\\Location';
    }
}
