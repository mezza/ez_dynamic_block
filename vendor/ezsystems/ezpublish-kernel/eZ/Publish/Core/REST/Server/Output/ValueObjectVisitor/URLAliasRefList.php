<?php
/**
 * File containing the URLAliasRefList ValueObjectVisitor class
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
 * URLAliasRefList value object visitor
 */
class URLAliasRefList extends ValueObjectVisitor
{
    /**
     * Visit struct returned by controllers
     *
     * @param \eZ\Publish\Core\REST\Common\Output\Visitor $visitor
     * @param \eZ\Publish\Core\REST\Common\Output\Generator $generator
     * @param \eZ\Publish\Core\REST\Server\Values\URLAliasRefList $data
     */
    public function visit( Visitor $visitor, Generator $generator, $data )
    {
        $generator->startObjectElement( 'UrlAliasRefList' );
        $visitor->setHeader( 'Content-Type', $generator->getMediaType( 'UrlAliasRefList' ) );

        $generator->startAttribute( 'href', $data->path );
        $generator->endAttribute( 'href' );

        $generator->startList( 'UrlAlias' );
        foreach ( $data->urlAliases as $urlAlias )
        {
            $generator->startObjectElement( 'UrlAlias' );

            $generator->startAttribute(
                'href',
                $this->router->generate( 'ezpublish_rest_loadURLAlias', array( 'urlAliasId' => $urlAlias->id ) )
            );
            $generator->endAttribute( 'href' );

            $generator->endObjectElement( 'UrlAlias' );
        }
        $generator->endList( 'UrlAlias' );

        $generator->endObjectElement( 'UrlAliasRefList' );
    }
}
