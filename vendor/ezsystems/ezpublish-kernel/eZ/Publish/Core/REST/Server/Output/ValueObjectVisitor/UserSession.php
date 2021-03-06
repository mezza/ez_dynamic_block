<?php
/**
 * File containing the UserSession ValueObjectVisitor class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\REST\Server\Output\ValueObjectVisitor;

use eZ\Publish\Core\REST\Common\Output\ValueObjectVisitor;
use eZ\Publish\Core\REST\Common\Output\Generator;
use eZ\Publish\Core\REST\Common\Output\Visitor;

/**
 * UserSession value object visitor
 */
class UserSession extends ValueObjectVisitor
{
    /**
     * Visit struct returned by controllers
     *
     * @param \eZ\Publish\Core\REST\Common\Output\Visitor $visitor
     * @param \eZ\Publish\Core\REST\Common\Output\Generator $generator
     * @param \eZ\Publish\Core\REST\Server\Values\UserSession $data
     */
    public function visit( Visitor $visitor, Generator $generator, $data )
    {
        $status = $data->created ? 201 : 200;
        $visitor->setStatus( $status );

        $visitor->setHeader( 'Content-Type', $generator->getMediaType( 'Session' ) );

        $sessionHref = $this->router->generate( 'ezpublish_rest_deleteSession', array( 'sessionId' => $data->sessionId ) );

        //@todo Needs refactoring, disabling certain headers should not be done this way
        $visitor->setHeader( 'Accept-Patch', false );

        $generator->startObjectElement( 'Session' );

        $generator->startAttribute( 'href', $sessionHref );
        $generator->endAttribute( 'href' );

        $generator->startValueElement( 'name', $data->sessionName );
        $generator->endValueElement( 'name' );

        $generator->startValueElement( 'identifier', $data->sessionId );
        $generator->endValueElement( 'identifier' );

        $generator->startValueElement( 'csrfToken', $data->csrfToken );
        $generator->endValueElement( 'csrfToken' );

        $generator->startObjectElement( 'User', 'User' );
        $generator->startAttribute(
            'href',
            $this->router->generate( 'ezpublish_rest_loadUser', array( 'userId' => $data->user->id ) )
        );
        $generator->endAttribute( 'href' );
        $generator->endObjectElement( 'User' );

        $generator->endObjectElement( 'Session' );
    }
}
