<?php
/**
 * File containing the CreatedContentTypeGroup ValueObjectVisitor class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\REST\Server\Output\ValueObjectVisitor;

use eZ\Publish\Core\REST\Common\Output\Generator;
use eZ\Publish\Core\REST\Common\Output\Visitor;

/**
 * CreatedContentTypeGroup value object visitor
 * @todo coverage add test
 */
class CreatedContentTypeGroup extends ContentTypeGroup
{
    /**
     * Visit struct returned by controllers
     *
     * @param \eZ\Publish\Core\REST\Common\Output\Visitor $visitor
     * @param \eZ\Publish\Core\REST\Common\Output\Generator $generator
     * @param \eZ\Publish\Core\REST\Server\Values\CreatedContentTypeGroup $data
     */
    public function visit( Visitor $visitor, Generator $generator, $data )
    {
        parent::visit( $visitor, $generator, $data->contentTypeGroup );
        $visitor->setHeader(
            'Location',
            $this->router->generate(
                'ezpublish_rest_loadContentTypeGroup',
                array( 'contentTypeGroupId' => $data->contentTypeGroup->id )
            )
        );
        $visitor->setStatus( 201 );
    }
}
