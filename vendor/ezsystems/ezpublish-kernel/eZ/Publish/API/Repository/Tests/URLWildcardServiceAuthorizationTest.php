<?php
/**
 * File containing the URLWildcardServiceTest class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\API\Repository\Tests;

/**
 * Test case for operations in the URLWildcardService.
 *
 * @see eZ\Publish\API\Repository\URLWildcardService
 * @group integration
 * @group authorization
 */
class URLWildcardServiceAuthorizationTest extends BaseTest
{
    /**
     * Test for the create() method.
     *
     * @return \eZ\Publish\API\Repository\Values\Content\URLWildcard
     * @see \eZ\Publish\API\Repository\URLWildcardService::create()
     * @expectedException \eZ\Publish\API\Repository\Exceptions\UnauthorizedException
     * @depends eZ\Publish\API\Repository\Tests\URLWildcardServiceTest::testCreate
     */
    public function testCreateThrowsUnauthorizedException()
    {
        $repository = $this->getRepository();

        $anonymousUserId = $this->generateId( 'user', 10 );
        /* BEGIN: Use Case */
        // $anonymousUserId is the ID of the "Anonymous" user in a eZ
        // Publish demo installation.

        $userService = $repository->getUserService();
        $urlWildcardService = $repository->getURLWildcardService();

        $repository->setCurrentUser( $userService->loadUser( $anonymousUserId ) );

        // This call will fail with an UnauthorizedException
        $urlWildcardService->create( '/articles/*', '/content/{1}' );
        /* END: Use Case */
    }

    /**
     * Test for the remove() method.
     *
     * @return void
     * @see \eZ\Publish\API\Repository\URLWildcardService::remove()
     * @expectedException \eZ\Publish\API\Repository\Exceptions\UnauthorizedException
     * @depends eZ\Publish\API\Repository\Tests\URLWildcardServiceTest::testRemove
     */
    public function testRemoveThrowsUnauthorizedException()
    {
        $repository = $this->getRepository();

        $anonymousUserId = $this->generateId( 'user', 10 );
        /* BEGIN: Use Case */
        // $anonymousUserId is the ID of the "Anonymous" user in a eZ
        // Publish demo installation.
        $userService = $repository->getUserService();
        $urlWildcardService = $repository->getURLWildcardService();

        // Create a new url wildcard
        $urlWildcardId = $urlWildcardService->create( '/articles/*', '/content/{1}' )->id;

        $repository->setCurrentUser( $userService->loadUser( $anonymousUserId ) );

        // Load newly created url wildcard
        $urlWildcard = $urlWildcardService->load( $urlWildcardId );

        // This call will fail with an UnauthorizedException
        $urlWildcardService->remove( $urlWildcard );
        /* END: Use Case */
    }
}
