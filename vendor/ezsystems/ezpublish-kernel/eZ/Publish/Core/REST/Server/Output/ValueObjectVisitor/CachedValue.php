<?php
/**
 * File containing the ContentList ValueObjectVisitor class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\REST\Server\Output\ValueObjectVisitor;

use eZ\Publish\Core\MVC\ConfigResolverInterface;
use eZ\Publish\Core\REST\Common\Output\ValueObjectVisitor;
use eZ\Publish\Core\REST\Common\Output\Generator;
use eZ\Publish\Core\REST\Common\Output\Visitor;
use Symfony\Component\HttpFoundation\Request;

/**
 * CachedValue value object visitor
 */
class CachedValue extends ValueObjectVisitor
{
    /** @var ConfigResolverInterface */
    protected $configResolver;

    protected $request;

    public function __construct( ConfigResolverInterface $configResolver )
    {
        $this->configResolver = $configResolver;
    }

    public function setRequest( Request $request = null )
    {
        return $this->request = $request;
    }

    /**
     * @param Visitor   $visitor
     * @param Generator $generator
     * @param \eZ\Publish\Core\REST\Server\Values\CachedValue $data
     */
    public function visit( Visitor $visitor, Generator $generator, $data )
    {
        $visitor->visitValueObject( $data->value );

        if ( $this->getParameter( 'content.view_cache' ) !== true )
        {
            return;
        }

        $response = $visitor->getResponse();
        $response->setPublic();
        $response->setVary( 'Accept' );

        if ( $this->getParameter( 'content.ttl_cache' ) === true )
        {
            $response->setSharedMaxAge( $this->getParameter( 'content.default_ttl' ) );
            if ( isset( $this->request ) && $this->request->headers->has( 'X-User-Hash' ) )
            {
                $response->setVary( 'X-User-Hash', false );
            }
        }

        if ( isset( $data->cacheTags['locationId'] ) )
        {
            $visitor->getResponse()->headers->set( 'X-Location-Id', $data->cacheTags['locationId'] );
        }
    }

    public function getParameter( $parameterName, $defaultValue = null )
    {
        if ( $this->configResolver->hasParameter( $parameterName ) )
            return $this->configResolver->getParameter( $parameterName );

        return $defaultValue;
    }
}
