<?php

namespace Tests;

use App\Controllers\GroupController;
use App\Models\Group;
use App\Models\User;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Factory\ResponseFactory;
use PHPUnit\Framework\TestCase;

class GroupTest extends TestCase
{
    protected $groupController;
    protected $group;
    protected $user1;
    protected $user2;

    protected function setUp(): void
    {
        $this->groupController = new GroupController();

        $this->user1 = new User();
        $this->user1->username = 'User1'; // add necessary properties
        $this->user1->save();

        $this->user2 = new User();
        $this->user2->username = 'User2'; // add necessary properties
        $this->user2->save();

        // Create another user
        $this->user3 = new User();
        $this->user3->username = 'User3'; // add necessary properties
        $this->user3->save();
    }

    public function testCreateGroup(): void
    {
        // Prepare the request
        $requestFactory = new ServerRequestFactory();
        $request = $requestFactory->createServerRequest('POST', '/groups');
        $request = $request->withParsedBody(['name' => 'Test Group', 'created_by' => $this->user1->id]);

        // Prepare the response
        $responseFactory = new ResponseFactory();
        $response = $responseFactory->createResponse();

        // Invoke the create method
        $result = $this->groupController->create($request, $response, []);

        // Assert the response
        $expectedStatusCode = 200;
        $this->assertSame($expectedStatusCode, $result->getStatusCode());

        // Parse the JSON response body
        $responseBody = json_decode($result->getBody(), true);

        // Assert the group was created
        $this->assertSame('Test Group', $responseBody['name']);
        $this->assertSame($this->user1->id, $responseBody['created_by']);
    }
    public function testJoinGroup(): void
    {
        // Create a group
        $group = new Group();
        $group->name = 'Test Group';
        $group->created_by = $this->user1->id;
        $group->save();

        // Check if the user is already in the group
        $isUserAlreadyInGroup = $group->users()->where('id', $this->user3->id)->exists();

        if ($isUserAlreadyInGroup) {
            $this->fail('User is already in the group');
        }

        // Prepare the request
        $requestFactory = new ServerRequestFactory();
        $request = $requestFactory->createServerRequest('PUT', "/group/1/join");
        $request = $request->withParsedBody(['user_id' => $this->user3->id]);

        // Prepare the response
        $responseFactory = new ResponseFactory();
        $response = $responseFactory->createResponse();

        // Invoke the join method
        $result = $this->groupController->join($request, $response, ['group_id' => 1]);

        // Assert the response
        $expectedStatusCode = 200;
        $this->assertSame($expectedStatusCode, $result->getStatusCode());

        // Parse the JSON response body
        $responseBody = json_decode($result->getBody(), true);

        // Assert the user has joined the group
        $this->assertArrayHasKey('group_id', $responseBody);
        $this->assertSame(1, $responseBody['group_id']);

        // Verify the group membership in the database
        $group = Group::find(1);
        $users = $group->users;
        $userIds = $users->pluck('id')->all();

        $this->assertContains($this->user3->id, $userIds);
    }



    protected function tearDown(): void
    {
        // Clean up the database after testing
        Group::truncate();
        User::truncate();
    }
}
