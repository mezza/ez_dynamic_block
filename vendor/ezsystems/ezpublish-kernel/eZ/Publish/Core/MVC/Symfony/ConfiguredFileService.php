<?php
/**
 * File containing the ConfiguredFileService class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\MVC\Symfony;

use eZ\Publish\Core\FieldType\FileService\LegacyFileService as BaseFileService;
use eZ\Publish\Core\MVC\ConfigResolverInterface;

/**
 * Configuration aware local file service for BinaryBase FieldTypes storage
 */
class ConfiguredFileService extends BaseFileService
{
    /**
     * Builds the file service based on the dynamic configuration provided by
     * the config resolver
     *
     * @param callable                $kernelClosure
     * @param ConfigResolverInterface $resolver
     * @param string                  $installDir
     */
    public function __construct( \Closure $kernelClosure, ConfigResolverInterface $resolver, $installDir )
    {
        parent::__construct(
            $kernelClosure,
            $installDir,
            sprintf(
                '%s/%s/%s',
                $resolver->getParameter( 'var_dir' ),
                $resolver->getParameter( 'storage_dir' ),
                $resolver->getParameter( 'binary_dir' )
            )
        );
    }
}

