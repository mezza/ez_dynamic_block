<?php
/**
 * File containing the Section controller class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\REST\Server\Controller;

use eZ\Publish\Core\REST\Common\Message;
use eZ\Publish\Core\REST\Server\Values;
use eZ\Publish\Core\REST\Server\Controller as RestController;

use eZ\Publish\API\Repository\SectionService;
use eZ\Publish\API\Repository\Values\Content\SectionCreateStruct;
use eZ\Publish\API\Repository\Values\Content\SectionUpdateStruct;
use eZ\Publish\Core\REST\Server\Values\NoContent;

use eZ\Publish\API\Repository\Exceptions\InvalidArgumentException;
use eZ\Publish\Core\REST\Server\Exceptions\ForbiddenException;

/**
 * Section controller
 */
class Section extends RestController
{
    /**
     * Section service
     *
     * @var \eZ\Publish\API\Repository\SectionService
     */
    protected $sectionService;

    /**
     * Construct controller
     *
     * @param \eZ\Publish\API\Repository\SectionService $sectionService
     */
    public function __construct( SectionService $sectionService )
    {
        $this->sectionService  = $sectionService;
    }

    /**
     * List sections
     *
     * @return \eZ\Publish\Core\REST\Server\Values\SectionList
     */
    public function listSections()
    {
        if ( $this->request->query->has( 'identifier' ) )
        {
            $sections = array(
                $this->loadSectionByIdentifier()
            );
        }
        else
        {
            $sections = $this->sectionService->loadSections();
        }

        return new Values\SectionList( $sections, $this->request->getPathInfo() );
    }

    /**
     * Loads section by identifier
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Section
     */
    public function loadSectionByIdentifier()
    {
        return $this->sectionService->loadSectionByIdentifier(
            // GET variable
            $this->request->query->get( 'identifier' )
        );
    }

    /**
     * Create new section
     *
     * @throws \eZ\Publish\Core\REST\Server\Exceptions\ForbiddenException
     * @return \eZ\Publish\Core\REST\Server\Values\CreatedSection
     */
    public function createSection()
    {
        try
        {
            $createdSection = $this->sectionService->createSection(
                $this->inputDispatcher->parse(
                    new Message(
                        array( 'Content-Type' => $this->request->headers->get( 'Content-Type' ) ),
                        $this->request->getContent()
                    )
                )
            );
        }
        catch ( InvalidArgumentException $e )
        {
            throw new ForbiddenException( $e->getMessage() );
        }

        return new Values\CreatedSection(
            array(
                'section' => $createdSection
            )
        );
    }

    /**
     * Loads a section
     *
     * @param $sectionId
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Section
     */
    public function loadSection( $sectionId )
    {
        return $this->sectionService->loadSection( $sectionId );
    }

    /**
     * Updates a section
     *
     * @param $sectionId
     *
     * @throws \eZ\Publish\Core\REST\Server\Exceptions\ForbiddenException
     * @return \eZ\Publish\API\Repository\Values\Content\Section
     */
    public function updateSection( $sectionId )
    {
        $createStruct = $this->inputDispatcher->parse(
            new Message(
                array( 'Content-Type' => $this->request->headers->get( 'Content-Type' ) ),
                $this->request->getContent()
            )
        );

        try
        {
            return $this->sectionService->updateSection(
                $this->sectionService->loadSection( $sectionId ),
                $this->mapToUpdateStruct( $createStruct )
            );
        }
        catch ( InvalidArgumentException $e )
        {
            throw new ForbiddenException( $e->getMessage() );
        }
    }

    /**
     * Delete a section by ID
     *
     * @param $sectionId
     *
     * @return \eZ\Publish\Core\REST\Server\Values\NoContent
     */
    public function deleteSection( $sectionId )
    {
        $this->sectionService->deleteSection(
            $this->sectionService->loadSection( $sectionId )
        );

        return new NoContent();
    }

    /**
     * Maps a SectionCreateStruct to a SectionUpdateStruct.
     *
     * Needed since both structs are encoded into the same media type on input.
     *
     * @param \eZ\Publish\API\Repository\Values\Content\SectionCreateStruct $createStruct
     *
     * @return \eZ\Publish\API\Repository\Values\Content\SectionUpdateStruct
     */
    protected function mapToUpdateStruct( SectionCreateStruct $createStruct )
    {
        return new SectionUpdateStruct(
            array(
                'name'       => $createStruct->name,
                'identifier' => $createStruct->identifier,
            )
        );
    }
}
