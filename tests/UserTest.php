<?php

namespace Tests;

use App\Controllers\UserController;
use App\Models\User;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\RequestFactory;
use Slim\Psr7\Factory\ResponseFactory;

class UserTest extends TestCase
{
    public function testCreateNewUser()
    {
        // Arrange
        $requestFactory = new RequestFactory();
        $responseFactory = new ResponseFactory();

        $request = $requestFactory->createRequest('POST', '/user/create');
        $request = $request->withParsedBody(['username' => 'test_user']);

        $response = $responseFactory->createResponse();

        // Act
        $userController = new UserController();
        $response = $userController->create($request, $response, []);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        $responseData = json_decode((string)$response->getBody(), true);
        $this->assertEquals('test_user', $responseData['username']);

        // Cleanup
        User::where('username', 'test_user')->delete();
    }

    public function testCreateExistingUser()
    {
        // Arrange
        $user = new User();
        $user->username = 'existing_user';
        $user->save();

        $requestFactory = new RequestFactory();
        $responseFactory = new ResponseFactory();

        $request = $requestFactory->createRequest('POST', '/user/create');
        $request = $request->withParsedBody(['username' => 'existing_user']);

        $response = $responseFactory->createResponse();

        // Act
        $userController = new UserController();
        $response = $userController->create($request, $response, []);

        // Assert
        $this->assertEquals(409, $response->getStatusCode());
        $responseData = json_decode((string)$response->getBody(), true);
        $this->assertEquals('Username is already in use', $responseData['error']);

        // Cleanup
        User::where('username', 'existing_user')->delete();
    }
}
