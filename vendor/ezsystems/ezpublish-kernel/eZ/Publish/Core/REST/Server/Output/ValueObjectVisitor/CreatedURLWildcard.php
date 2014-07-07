<?php
/**
 * File containing the CreatedURLWildcard ValueObjectVisitor class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\REST\Server\Output\ValueObjectVisitor;

use eZ\Publish\Core\REST\Common\Output\Generator;
use eZ\Publish\Core\REST\Common\Output\Visitor;

/**
 * CreatedURLWildcard value object visitor
 * @todo coverage add unit test
 */
class CreatedURLWildcard extends URLWildcard
{
    /**
     * Visit struct returned by controllers
     *
     * @param \eZ\Publish\Core\REST\Common\Output\Visitor $visitor
     * @param \eZ\Publish\Core\REST\Common\Output\Generator $generator
     * @param \eZ\Publish\Core\REST\Server\Values\CreatedURLWildcard $data
     */
    public function visit( Visitor $visitor, Generator $generator, $data )
    {
        parent::visit( $visitor, $generator, $data->urlWildcard );
        $visitor->setHeader(
            'Location',
            $this->router->generate(
                'ezpublish_rest_loadURLWildcard',
                array( 'urlWildcardId' => $data->urlWildcard->id )
            )
        );
        $visitor->setStatus( 201 );
    }
}
