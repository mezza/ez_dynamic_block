<?php
/**
 * File containing the CachedValue class.
 *
 * @copyright Copyright (C) 2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */
namespace eZ\Publish\Core\REST\Server\Values;

use eZ\Publish\Core\Base\Exceptions\InvalidArgumentException;
use eZ\Publish\Core\REST\Common\Value as RestValue;

class CachedValue extends RestValue
{
    /**
     * Actual value object
     * @var mixed
     */
    public $value;

    /**
     * Associative array of cache tags.
     * Example: array( 'locationId' => 59 )
     * @var mixed[]
     */
    public $cacheTags;

    /**
     * @param mixed $value The value that gets cached
     * @param array $cacheTags Tags to add to the cache (supported: locationId)
     * @throw InvalidArgumentException If invalid cache tags are provided
     */
    public function __construct( $value, array $cacheTags = array() )
    {
        $this->value = $value;
        $this->cacheTags = $this->checkCacheTags( $cacheTags );
    }

    protected function checkCacheTags( $tags )
    {
        $invalidTags = array_diff( array_keys( $tags ), array( 'locationId' ) );
        if ( count( $invalidTags ) > 0 )
        {
            throw new InvalidArgumentException(
                'cacheTags',
                "Unknown cache tag(s): " . implode( ', ', $invalidTags  )
            );
        }
        return $tags;
    }
}
