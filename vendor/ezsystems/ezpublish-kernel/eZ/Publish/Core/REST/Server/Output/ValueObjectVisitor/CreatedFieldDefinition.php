<?php
/**
 * File containing the CreatedFieldDefinition ValueObjectVisitor class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\REST\Server\Output\ValueObjectVisitor;

use eZ\Publish\Core\REST\Common\Output\Generator;
use eZ\Publish\Core\REST\Common\Output\Visitor;

/**
 * CreatedFieldDefinition value object visitor
 *
 * @todo coverage add test
 */
class CreatedFieldDefinition extends RestFieldDefinition
{
    /**
     * Visit struct returned by controllers
     *
     * @param \eZ\Publish\Core\REST\Common\Output\Visitor $visitor
     * @param \eZ\Publish\Core\REST\Common\Output\Generator $generator
     * @param \eZ\Publish\Core\REST\Server\Values\CreatedFieldDefinition $data
     */
    public function visit( Visitor $visitor, Generator $generator, $data )
    {
        $restFieldDefinition = $data->fieldDefinition;

        parent::visit( $visitor, $generator, $restFieldDefinition );

        $draftUriPart = $this->getUrlTypeSuffix( $restFieldDefinition->contentType->status );
        $visitor->setHeader(
            'Location',
            $this->router->generate(
                "ezpublish_rest_loadContentType{$draftUriPart}FieldDefinition",
                array(
                    'contentTypeId' => $restFieldDefinition->contentType->id,
                    'fieldDefinitionId' => $restFieldDefinition->fieldDefinition->id
                )
            )
        );
        $visitor->setStatus( 201 );
    }
}
