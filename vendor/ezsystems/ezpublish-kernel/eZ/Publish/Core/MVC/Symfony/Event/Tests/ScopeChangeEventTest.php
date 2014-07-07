<?php
/**
 * File containing the ScopeChangeEventTest class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\MVC\Symfony\Event\Tests;

use eZ\Publish\Core\MVC\Symfony\Event\ScopeChangeEvent;
use eZ\Publish\Core\MVC\Symfony\SiteAccess;
use PHPUnit_Framework_TestCase;

class ScopeChangeEventTest extends PHPUnit_Framework_TestCase
{
    public function testGetSiteAccess()
    {
        $siteAccess = new SiteAccess( 'foo', 'test' );
        $event = new ScopeChangeEvent( $siteAccess );
        $this->assertSame( $siteAccess, $event->getSiteAccess() );
    }
}
