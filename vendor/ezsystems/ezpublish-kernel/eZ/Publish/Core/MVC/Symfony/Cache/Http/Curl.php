<?php
/**
 * File containing the Http Curl client class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\MVC\Symfony\Cache\Http;

use Buzz\Client\Curl as BaseCurl;
use Buzz\Message\RequestInterface;
use Buzz\Message\MessageInterface;
use Psr\Log\LoggerInterface;
use RuntimeException;

class Curl extends BaseCurl
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    public function __construct( $timeout, LoggerInterface $logger = null )
    {
        $this->logger = $logger;
        $this->setTimeout( $timeout );
        $this->setOption( CURLOPT_NOBODY, true );
    }

    public function send( RequestInterface $request, MessageInterface $response, array $options = array() )
    {
        try
        {
            parent::send( $request, $response, $options );
        }
        catch ( RuntimeException $e )
        {
            // Catch but do not do anything as we consider the request to be ~ asynchronous
            if ( isset( $this->logger ) )
            {
                $this->logger->notice( "An issue occurred while handling HttpCache purge: {$e->getMessage()}." );
            }
        }
    }
}
