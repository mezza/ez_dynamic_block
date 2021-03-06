<?php
/**
 * File containing the content updater action class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\Persistence\Legacy\Content\Type\ContentUpdater;

use eZ\Publish\SPI\Persistence\Content;
use eZ\Publish\Core\Persistence\Legacy\Content\Gateway as ContentGateway;

/**
 * Updater action base class
 */
abstract class Action
{
    /**
     * Content gateway
     *
     * @var \eZ\Publish\Core\Persistence\Legacy\Content\Gateway
     */
    protected $contentGateway;

    /**
     * Creates a new action
     *
     * @param \eZ\Publish\Core\Persistence\Legacy\Content\Gateway $contentGateway
     */
    public function __construct( ContentGateway $contentGateway )
    {
        $this->contentGateway = $contentGateway;
    }

    /**
     * Applies the action to the given $content
     *
     * @param \eZ\Publish\SPI\Persistence\Content $content
     *
     * @return void
     */
    abstract public function apply( Content $content );
}
