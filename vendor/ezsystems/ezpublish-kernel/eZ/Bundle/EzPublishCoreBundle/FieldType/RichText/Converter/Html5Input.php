<?php
/**
 * File containing the Html5Input class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Bundle\EzPublishCoreBundle\FieldType\RichText\Converter;

use eZ\Publish\Core\FieldType\RichText\Converter\Xslt as XsltConverter;
use eZ\Publish\Core\MVC\ConfigResolverInterface;

/**
 * Adds ConfigResolver awareness to the Xslt converter.
 */
class Html5Input extends XsltConverter
{
    public function __construct( $stylesheet, ConfigResolverInterface $configResolver )
    {
        $customStylesheets = $configResolver->getParameter( 'fieldtypes.ezrichtext.input_custom_xsl' );
        $customStylesheets = $customStylesheets ?: array();
        parent::__construct( $stylesheet, $customStylesheets );
    }
}
