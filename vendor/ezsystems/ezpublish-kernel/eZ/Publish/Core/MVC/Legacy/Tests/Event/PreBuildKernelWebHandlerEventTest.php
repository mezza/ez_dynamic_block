<?php
/**
 * File containing the PreBuildKernelWebHandlerEventTest class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\MVC\Legacy\Tests\Event;

use eZ\Publish\Core\MVC\Legacy\Event\PreBuildKernelWebHandlerEvent;
use PHPUnit_Framework_TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class PreBuildKernelWebHandlerEventTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $parameterBag = new ParameterBag();
        $request = new Request();
        $event = new PreBuildKernelWebHandlerEvent( $parameterBag, $request );
        $this->assertSame( $parameterBag, $event->getParameters() );
        $this->assertSame( $request, $event->getRequest() );
    }
}
