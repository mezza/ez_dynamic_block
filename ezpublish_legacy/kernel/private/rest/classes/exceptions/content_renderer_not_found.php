<?php
/**
 * File containing the ezpRestContentRendererNotfoundException class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2014.3
 * @package kernel
 */

class ezpRestContentRendererNotFoundException extends ezpRestException
{
    public function __construct( $renderer )
    {
        parent::__construct( "The output content renderer '{$renderer}' could not be found." );
    }
}
