<?php
/**
 * File containing the URIFixerTest class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\MVC\Legacy\Tests;

use eZ\Publish\Core\MVC\Legacy\Kernel\URIHelper;
use eZURI;
use Symfony\Component\HttpFoundation\Request;

class URIHelperTest extends LegacyBasedTestCase
{
    public function testFixUpInternalURI()
    {
        $initialURI = '/foo/bar/baz';
        $modifiedURI = '/bar/baz';
        eZURI::instance()->setURIString( $initialURI );
        $request = Request::create( $initialURI );
        $request->attributes->set( 'semanticPathinfo', $modifiedURI );

        $helper = new URIHelper();
        $helper->updateLegacyURI( $request );
        $this->assertSame( $modifiedURI, eZURI::instance()->uriString( true ) );
    }

    public function testFixupInternalURIPathinfo()
    {
        $initialURI = '/foo/bar/baz';
        $request = Request::create( $initialURI );

        $helper = new URIHelper();
        $helper->updateLegacyURI( $request );
        $this->assertSame( $initialURI, eZURI::instance()->uriString( true ) );
    }
}
