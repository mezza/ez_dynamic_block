<?php
/**
* File containing the eZIEImageToolFlipVer class.
* 
* @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
* @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
* @version 5.3.0-beta1
* @package ezie
*/
class eZIEImageToolFlipVertically extends eZIEImageAction
{
    /**
    * Creates a vertical flip filter
    * 
    * @return array( ezcImageFilter )
    */
    static function filter()
    {
        return array(
            new ezcImageFilter( 
                'verticalFlip',
                array()
            )
        );
    }
}

?>
