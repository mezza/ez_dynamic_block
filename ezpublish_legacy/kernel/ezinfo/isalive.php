<?php
/**
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2014.3
 * @package kernel
 */

header( "Content-Type: text/plain;" );

$db = eZDB::instance();

if ( $db->isConnected() === true )
    print( "eZ Publish is alive" );
else
    print( "No connection" );

eZExecution::cleanExit();
?>
