<?php
/**
 * File containing the LegacyStorageEngineFactory class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Bundle\EzPublishCoreBundle\ApiLoader;

use eZ\Publish\Core\Persistence\Doctrine\ConnectionHandler;
use eZ\Publish\Core\Persistence\Legacy\Content\FieldValue\ConverterRegistry;
use eZ\Publish\Core\Persistence\FieldTypeRegistry;
use eZ\Publish\Core\Persistence\Legacy\Content\StorageRegistry;
use Symfony\Component\DependencyInjection\ContainerAware;

class LegacyStorageEngineFactory extends ContainerAware
{
    /**
     * Collection of converters with identifier as key and FQN class name as value
     *
     * @var array
     */
    protected $converters = array();

    protected $fieldTypes = array();

    /**
     * Registers a field type converter as expected in legacy storage engine.
     * $className must implement eZ\Publish\Core\Persistence\Legacy\Content\FieldValue\Converter interface.
     *
     * @param string $typeIdentifier Field type identifier the converter will be used for
     * @param string $className FQN of the converter class
     */
    public function registerFieldTypeConverter( $typeIdentifier, $className )
    {
        $this->converters[$typeIdentifier] = $className;
    }

    /**
     * Registers an eZ Publish field type.
     * Field types are being registered as a closure so that they will be lazy loaded.
     *
     * @param string $fieldTypeServiceId The field type service Id
     * @param string $fieldTypeAlias The field type alias (e.g. "ezstring")
     *
     * @todo Refactor since it seems to duplicate RepositoryFactory::registerFieldType()
     */
    public function registerFieldType( $fieldTypeServiceId, $fieldTypeAlias )
    {
        $container = $this->container;
        $this->fieldTypes[$fieldTypeAlias] = function () use ( $container, $fieldTypeServiceId )
        {
            return $container->get( $fieldTypeServiceId );
        };
    }

    /**
     * Builds the Legacy Storage Engine
     *
     * @param \eZ\Publish\Core\Persistence\Doctrine\ConnectionHandler $dbhandler
     * @param boolean $deferTypeUpdate
     *
     * @return \eZ\Publish\Core\Persistence\Legacy\Handler
     */
    public function buildLegacyEngine( ConnectionHandler $dbhandler, $deferTypeUpdate )
    {
        $legacyEngineClass = $this->container->getParameter( 'ezpublish.api.storage_engine.legacy.class' );
        return new $legacyEngineClass(
            $dbhandler,
            new FieldTypeRegistry(
                $this->container->get( 'ezpublish.api.repository.factory' )->getFieldTypes()
            ),
            new ConverterRegistry( $this->converters ),
            new StorageRegistry(
                $this->container->get( 'ezpublish.api.repository.factory' )->getExternalStorageHandlers()
            ),
            $this->container->get( 'ezpublish.api.storage_engine.transformation_processor' ),
            array(
                'defer_type_update' => (bool)$deferTypeUpdate,
                'field_type' => $this->fieldTypes,
            )
        );
    }
}
