<?php
/**
 * File containing the ContentTypeList parser class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\REST\Client\Input\Parser;

use eZ\Publish\Core\REST\Common\Input\BaseParser;
use eZ\Publish\Core\REST\Common\Input\ParsingDispatcher;

/**
 * Parser for ContentTypeList
 */
class ContentTypeList extends BaseParser
{
    /**
     * Parse input structure
     *
     * @param array $data
     * @param \eZ\Publish\Core\REST\Common\Input\ParsingDispatcher $parsingDispatcher
     *
     * @todo Error handling
     *
     * @return \eZ\Publish\API\Repository\Values\ContentType\ContentType[]
     */
    public function parse( array $data, ParsingDispatcher $parsingDispatcher )
    {
        $contentTypes = array();
        foreach ( $data['ContentType'] as $rawContentTypeData )
        {
            $contentTypes[] = $parsingDispatcher->parse(
                $rawContentTypeData,
                $rawContentTypeData['_media-type']
            );
        }
        return $contentTypes;
    }
}
