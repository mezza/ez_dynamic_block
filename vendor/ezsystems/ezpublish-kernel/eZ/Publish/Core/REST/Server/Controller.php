<?php
/**
 * File containing the REST Server Controller class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\REST\Server;

use eZ\Publish\API\Repository\Repository;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Routing\RouterInterface;
use eZ\Publish\Core\REST\Common\Input\Dispatcher as InputDispatcher;
use Symfony\Component\HttpFoundation\Request;
use eZ\Publish\Core\REST\Common\RequestParser as RequestParser;

abstract class Controller extends ContainerAware
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * @var \eZ\Publish\Core\REST\Common\Input\Dispatcher
     */
    protected $inputDispatcher;

    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    protected $router;

    /**
     * @var \eZ\Publish\Core\REST\Common\RequestParser
     */
    protected $requestParser;

    /**
     * Repository
     *
     * @var \eZ\Publish\API\Repository\Repository
     */
    protected $repository;

    public function setInputDispatcher( InputDispatcher $inputDispatcher )
    {
        $this->inputDispatcher = $inputDispatcher;
    }

    public function setRouter( RouterInterface $router )
    {
        $this->router = $router;
    }

    public function setRequest( Request $request = null )
    {
        $this->request = $request;
    }

    public function setRepository( Repository $repository )
    {
        $this->repository = $repository;
    }

    public function setRequestParser( RequestParser $requestParser )
    {
        $this->requestParser = $requestParser;
    }

    /**
     * Extracts the requested media type from $request
     * @todo refactor, maybe to a REST Request with an accepts('content-type') method
     *
     * @return string
     */
    protected function getMediaType()
    {
        foreach ( $this->request->getAcceptableContentTypes() as $mimeType )
        {
            if ( preg_match( '(^([a-z0-9-/.]+)\+.*$)', strtolower( $mimeType ), $matches ) )
            {
                return $matches[1];
            }
        }

        return 'unknown/unknown';
    }
}
