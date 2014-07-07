<?php
/**
 * File containing the ContentObjectStates ValueObjectVisitor class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\REST\Common\Output\ValueObjectVisitor;

use eZ\Publish\Core\REST\Common\Output\ValueObjectVisitor;
use eZ\Publish\Core\REST\Common\Output\Generator;
use eZ\Publish\Core\REST\Common\Output\Visitor;

/**
 * ContentObjectStates value object visitor
 */
class ContentObjectStates extends ValueObjectVisitor
{
    /**
     * Visit struct returned by controllers
     *
     * @param \eZ\Publish\Core\REST\Common\Output\Visitor $visitor
     * @param \eZ\Publish\Core\REST\Common\Output\Generator $generator
     * @param \eZ\Publish\Core\REST\Common\Values\ContentObjectStates $data
     */
    public function visit( Visitor $visitor, Generator $generator, $data )
    {
        $generator->startObjectElement( 'ContentObjectStates' );
        $visitor->setHeader( 'Content-Type', $generator->getMediaType( 'ContentObjectStates' ) );
        $visitor->setHeader( 'Accept-Patch', $generator->getMediaType( 'ContentObjectStates' ) );

        $generator->startList( 'ObjectState' );

        foreach ( $data->states as $state )
        {
            $generator->startObjectElement( 'ObjectState' );
            $generator->startAttribute(
                'href',
                $this->router->generate(
                    'ezpublish_rest_loadObjectState',
                    array(
                        'objectStateGroupId' => $state->groupId,
                        'objectStateId' => $state->objectState->id
                    )
                )
            );
            $generator->endAttribute( 'href' );
            $generator->endObjectElement( 'ObjectState' );
        }

        $generator->endList( 'ObjectState' );

        $generator->endObjectElement( 'ContentObjectStates' );
    }
}
