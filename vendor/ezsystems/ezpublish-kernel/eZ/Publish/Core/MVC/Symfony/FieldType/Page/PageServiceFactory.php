<?php
/**
 * File containing the PageServiceFactory class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\MVC\Symfony\FieldType\Page;

use eZ\Publish\Core\MVC\ConfigResolverInterface;
use eZ\Publish\Core\FieldType\Page\PageStorage\Gateway as PageGateway;

class PageServiceFactory
{
    /**
     * Builds the page service
     *
     * @param string $serviceClass the class of the page service
     * @param ConfigResolverInterface $resolver
     * @param \eZ\Publish\Core\FieldType\Page\PageStorage\Gateway $storageGateway
     *
     * @return \eZ\Publish\Core\FieldType\Page\PageService
     */
    public function buildService( $serviceClass, ConfigResolverInterface $resolver, PageGateway $storageGateway )
    {
        $pageSettings = $resolver->getParameter( 'ezpage' );
        /** @var $pageService \eZ\Publish\Core\FieldType\Page\PageService */
        $pageService = new $serviceClass( $pageSettings['layouts'], $pageSettings['blocks'] );
        $pageService->setStorageGateway( $storageGateway );
        return $pageService;
    }

}
