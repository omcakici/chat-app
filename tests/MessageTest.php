<?php

namespace Tests;

use App\Controllers\MessageController;
use App\Models\Group;
use App\Models\Message;
use App\Models\User;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Factory\ResponseFactory;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    protected $messageController;
    protected $user;
    protected $group;

    protected function setUp(): void
    {
        $this->messageController = new MessageController();

        $this->user = new User();
        $this->user->username = 'TestUser';
        $this->user->save();

        $this->group = new Group();
        $this->group->name = 'TestGroup';
        $this->group->created_by = $this->user->id;
        $this->group->save();
    }

    public function testCreateMessage(): void
    {
        // Prepare the request
        $requestFactory = new ServerRequestFactory();
        $request = $requestFactory->createServerRequest('POST', '/group/1/message/create');
        $request = $request->withParsedBody(['user_id' => $this->user->id, 'group_id' => $this->group->id, 'message' => 'Hello, World!']);

        // Prepare the response
        $responseFactory = new ResponseFactory();
        $response = $responseFactory->createResponse();

        // Invoke the create method
        $result = $this->messageController->create($request, $response, []);

        // Assert the response
        $expectedStatusCode = 200;
        $this->assertSame($expectedStatusCode, $result->getStatusCode());

        // Parse the JSON response body
        $responseBody = json_decode($result->getBody(), true);

        // Assert the message was created
        $this->assertSame('Hello, World!', $responseBody['message']);
        $this->assertSame($this->user->id, $responseBody['user_id']);
        $this->assertSame($this->group->id, $responseBody['group_id']);
    }


    public function testListAllMessages(): void
    {
        // Create a message
        $message = new Message();
        $message->user_id = $this->user->id;
        $message->group_id = $this->group->id;
        $message->message = 'Test message';
        $message->save();

        // Prepare the request
        $requestFactory = new ServerRequestFactory();
        $request = $requestFactory->createServerRequest('GET', "/group/{$this->group->id}/messages");

        // Prepare the response
        $responseFactory = new ResponseFactory();
        $response = $responseFactory->createResponse();

        // Invoke the listAll method
        $result = $this->messageController->listAll($request, $response, ['group_id' => $this->group->id]);

        // Assert the response
        $expectedStatusCode = 200;
        $this->assertSame($expectedStatusCode, $result->getStatusCode());

        // Parse the JSON response body
        $responseBody = json_decode($result->getBody(), true);

        // Assert the message is in the response
        $this->assertCount(1, $responseBody);
        $this->assertSame($message->id, $responseBody[0]['id']);
        $this->assertSame($this->group->id, $responseBody[0]['group_id']);
        $this->assertSame($this->user->id, $responseBody[0]['user_id']);
        $this->assertSame('Test message', $responseBody[0]['message']);
    }

    protected function tearDown(): void
    {
        // Clean up the database after testing
        Message::truncate();
        Group::truncate();
        User::truncate();
    }
}
