<?php
/**
 * File containing the PreviewControllerTest class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Bundle\EzPublishLegacyBundle\Tests\Controller;

use eZ\Bundle\EzPublishLegacyBundle\Controller\PreviewController;
use eZ\Publish\API\Repository\Values\Content\Content;
use eZ\Publish\API\Repository\Values\Content\Location;
use eZ\Publish\Core\MVC\Symfony\Controller\Tests\Controller\Content\PreviewControllerTest as BasePreviewControllerTest;
use eZ\Publish\Core\MVC\Symfony\SiteAccess;

class PreviewControllerTest extends BasePreviewControllerTest
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $configResolver;

    protected function setUp()
    {
        parent::setUp();
        $this->configResolver = $this->getMock( 'eZ\Publish\Core\MVC\ConfigResolverInterface' );
    }

    /**
     * @return \eZ\Bundle\EzPublishLegacyBundle\Controller\PreviewController
     */
    protected function getPreviewController()
    {
        $controller = new PreviewController(
            $this->contentService,
            $this->httpKernel,
            $this->previewHelper,
            $this->securityContext
        );
        $controller->setConfigResolver( $this->configResolver );

        return $controller;
    }

    protected function getDuplicatedRequest( Location $location, Content $content, SiteAccess $previewSiteAccess )
    {
        $request = parent::getDuplicatedRequest(
            $location,
            $content,
            $previewSiteAccess
        );
        $request->attributes->set( '_controller', 'ezpublish_legacy.controller:indexAction' );

        return $request;
    }

    public function testPreview()
    {
        $this->configResolver
            ->expects( $this->any() )
            ->method( 'getParameter' )
            ->with( 'legacy_mode' )
            ->will( $this->returnValue( true ) );
        parent::testPreview();
    }
}
