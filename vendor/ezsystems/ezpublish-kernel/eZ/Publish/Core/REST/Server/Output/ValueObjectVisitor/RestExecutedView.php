<?php
/**
 * File containing the Section ValueObjectVisitor class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\REST\Server\Output\ValueObjectVisitor;

use eZ\Publish\Core\REST\Common\Output\ValueObjectVisitor;
use eZ\Publish\Core\REST\Common\Output\Generator;
use eZ\Publish\Core\REST\Common\Output\Visitor;
use eZ\Publish\Core\REST\Server\Values\RestContent as RestContentValue;
use eZ\Publish\API\Repository\ContentService;
use eZ\Publish\API\Repository\ContentTypeService;
use eZ\Publish\API\Repository\LocationService;

/**
 * Section value object visitor
 */
class RestExecutedView extends ValueObjectVisitor
{
    /**
     * Location service
     *
     * @var \eZ\Publish\API\Repository\LocationService
     */
    protected $locationService;

    /**
     * Content service
     *
     * @var \eZ\Publish\API\Repository\ContentService
     */
    protected $contentService;

    /**
     * ContentType service
     *
     * @var \eZ\Publish\API\Repository\ContentTypeService
     */
    protected $contentTypeService;

    /**
     * @param \eZ\Publish\API\Repository\LocationService $locationService
     * @param \eZ\Publish\API\Repository\ContentService $contentService
     * @param \eZ\Publish\API\Repository\ContentTypeService $contentTypeService
     */
    public function __construct(
        LocationService $locationService,
        ContentService $contentService,
        ContentTypeService $contentTypeService
    )
    {
        $this->locationService = $locationService;
        $this->contentService = $contentService;
        $this->contentTypeService = $contentTypeService;
    }

    /**
     * Visit struct returned by controllers
     *
     * @param \eZ\Publish\Core\REST\Common\Output\Visitor $visitor
     * @param \eZ\Publish\Core\REST\Common\Output\Generator $generator
     * @param \eZ\Publish\Core\REST\Server\Values\RestExecutedView $data
     */
    public function visit( Visitor $visitor, Generator $generator, $data )
    {
        $generator->startObjectElement( 'View' );
        $visitor->setHeader( 'Content-Type', $generator->getMediaType( 'View' ) );

        $generator->startAttribute(
            'href',
            $this->router->generate( 'ezpublish_rest_loadView', array( 'viewId' => $data->identifier ) )
        );
        $generator->endAttribute( 'href' );

        $generator->startValueElement( 'identifier', $data->identifier );
        $generator->endValueElement( 'identifier' );

        // BEGIN Query
        $generator->startObjectElement( 'Query' );
        $generator->endObjectElement( 'Query' );
        // END Query

        // BEGIN Result
        $generator->startObjectElement( 'Result', 'ViewResult' );
        $generator->startAttribute(
            'href',
            $this->router->generate( 'ezpublish_rest_loadViewResults', array( 'viewId' => $data->identifier ) )
        );
        $generator->endAttribute( 'href' );

        // BEGIN searchHits
        $generator->startHashElement( 'searchHits' );
        $generator->startList( 'searchHit' );

        foreach ( $data->searchResults->searchHits as $searchHit )
        {
            $generator->startObjectElement( 'searchHit' );

            $generator->startAttribute( 'score', 0 );
            $generator->endAttribute( 'score' );

            $generator->startAttribute( 'index', 0 );
            $generator->endAttribute( 'index' );

            $generator->startObjectElement( 'value' );

            /** @var \eZ\Publish\API\Repository\Values\Content\ContentInfo $contentInfo */
            $contentInfo = $searchHit->valueObject->contentInfo;
            $restContent = new RestContentValue(
                $contentInfo,
                $this->locationService->loadLocation( $contentInfo->mainLocationId ),
                $searchHit->valueObject,
                $this->contentTypeService->loadContentType( $contentInfo->contentTypeId ),
                $this->contentService->loadRelations( $searchHit->valueObject->getVersionInfo() )
            );
            $visitor->visitValueObject( $restContent );
            $generator->endObjectElement( 'value' );
            $generator->endObjectElement( 'searchHit' );
        }

        $generator->endList( 'searchHit' );

        $generator->endHashElement( 'searchHits' );
        // END searchHits

        $generator->endObjectElement( 'Result' );
        // END Result

        $generator->endObjectElement( 'View' );
    }
}

