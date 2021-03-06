<?php
/**
 * File containing the ContentTypeGroup Id matcher class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\MVC\Symfony\Matcher\ContentBased\Id;

use eZ\Publish\Core\MVC\Symfony\Matcher\ContentBased\MultipleValued;
use eZ\Publish\API\Repository\Values\Content\Location as APILocation;
use eZ\Publish\API\Repository\Values\Content\ContentInfo;

class ContentTypeGroup extends MultipleValued
{
    /**
     * Checks if a Location object matches.
     *
     * @param \eZ\Publish\API\Repository\Values\Content\Location $location
     *
     * @return boolean
     */
    public function matchLocation( APILocation $location )
    {
        return $this->matchContentInfo( $location->getContentInfo() );
    }

    /**
     * Checks if a ContentInfo object matches.
     *
     * @param \eZ\Publish\API\Repository\Values\Content\ContentInfo $contentInfo
     *
     * @return boolean
     */
    public function matchContentInfo( ContentInfo $contentInfo )
    {
        $contentTypeGroups = $this->repository
            ->getContentTypeService()
            ->loadContentType( $contentInfo->contentTypeId )
            ->getContentTypeGroups();

        foreach ( $contentTypeGroups as $group )
        {
            if ( isset( $this->values[$group->id] ) )
                return true;
        }

        return false;
    }
}
