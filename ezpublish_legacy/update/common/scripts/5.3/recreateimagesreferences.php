<?php
/**
 * File containing the ${NAME} class.
 *
 * @copyright Copyright (C) 2013 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2014.3
 */

require_once 'autoload.php';
$cli = eZCLI::instance();

$script = eZScript::instance(
    array(
        'description' => "Re-creates missing references to image files in ezimagefile. See issue EZP-21324\n",
        'use-session' => true,
        'use-modules' => false,
        'use-extensions' => true
    )
);
$script->startup();

$options = $script->getOptions( "[dry-run]", "", array( 'n' => 'Dry run' ) );
$optDryRun = (bool)$options['dry-run'];

$script->initialize();

$imageAttributes = eZPersistentObject::fetchObjectList(
    eZContentObjectAttribute::definition(),
    array( 'id', 'contentobject_id', 'version', 'data_text' ),
    array( 'data_type_string' => 'ezimage' ),
    null,
    null, // @todo Implement batch fetch
    false
);

$cli->output( "Re-creating missing ezcontentobject_attribute / ezimagefile references" );
if ( $optDryRun )
    $cli->warning( "dry-run mode" );

foreach ( $imageAttributes as $imageAttribute )
{
    if ( ( $doc = simplexml_load_string( $imageAttribute["data_text"] ) ) === false )
        continue;

    // Creates ezimagefile entries
    foreach ( $doc->xpath( "//*/@url" ) as $url )
    {
        $url = (string)$url;
        echo "Processing {$imageAttribute['contentobject_id']}#{$imageAttribute['version']} ($url)\n";

        if ( $url === "" )
            continue;

        if ( eZImageFile::appendFilepath( $imageAttribute['id'], $url ) )
            $cli->output( "Restored link from $url to {$imageAttribute['id']}" );
    }
}

$script->shutdown();
