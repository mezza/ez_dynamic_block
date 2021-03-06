<?php
/**
 * File containing the abstract Limitation handler
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\Persistence\Legacy\User\Role;

use eZ\Publish\SPI\Persistence\User\Policy;

/**
 * Limitation Handler
 *
 * Takes care of Converting a Policy limitation from Legacy value to spi value accepted by API.
 */
class LimitationConverter
{
    /**
     * @var \eZ\Publish\Core\Persistence\Legacy\User\Role\LimitationHandler[]
     */
    protected $limitationHandlers;

    /**
     * Construct from LimitationConverter
     *
     * @param \eZ\Publish\Core\Persistence\Legacy\User\Role\LimitationHandler[] $limitationHandlers
     */
    public function __construct( array $limitationHandlers )
    {
        $this->limitationHandlers = $limitationHandlers;
    }

    /**
     * @param Policy $policy
     */
    public function toLegacy( Policy $policy )
    {
        foreach ( $this->limitationHandlers as $limitationHandler )
        {
            $limitationHandler->toLegacy( $policy );
        }
    }

    /**
     * @param Policy $policy
     */
    public function toSPI( Policy $policy )
    {
        foreach ( $this->limitationHandlers as $limitationHandler )
        {
            $limitationHandler->toSPI( $policy );
        }
    }
}
