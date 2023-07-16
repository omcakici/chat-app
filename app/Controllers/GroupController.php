<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\GroupUser;
use App\Models\Group;
use App\Models\User;

class GroupController
{
    public function create(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();

        if (!isset($data['name']) || !isset($data['created_by'])) {
            $response->getBody()->write(json_encode(['error' => 'Group name and creator ID are required']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(422);
        }

        // Check if the creator ID exists in the users table
        $creatorExists = User::where('id', $data['created_by'])->exists();
        if (!$creatorExists) {
            $response->getBody()->write(json_encode(['error' => 'Creator ID does not exist']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(422);
        }

        $group = new Group();
        $group->name = $data['name'];
        $group->created_by = $data['created_by'];
        $group->save();

        $response->getBody()->write(json_encode(['id' => $group->id, 'name' => $group->name, 'created_by' => $group->created_by]));

        return $response->withHeader('Content-Type', 'application/json');
    }
    
    public function join(Request $request, Response $response, $args): Response
    {
        if (!isset($args['group_id'])) {
            $response->getBody()->write(json_encode(['error' => 'Group ID is required']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(422);
        }

        $data = $request->getParsedBody();

        if (!isset($data['user_id'])) {
            $response->getBody()->write(json_encode(['error' => 'User ID is required']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(422);
        }

        // Check if the group ID exists in the groups table
        $group = Group::find($args['group_id']);
        if (!$group) {
            $response->getBody()->write(json_encode(['error' => 'Group ID does not exist']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(422);
        }

        // Check if the user ID exists in the users table
        $userExists = User::where('id', $data['user_id'])->exists();
        if (!$userExists) {
            $response->getBody()->write(json_encode(['error' => 'User ID does not exist']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(422);
        }

        // check if the user is already in the group
        if ($group->users()->where('user_id', $data['user_id'])->exists()) {
            // If the user is already in the group, return a message
            $response->getBody()->write(json_encode([
                'message' => 'User is already in the group'
            ]));
            return $response->withHeader('Content-Type', 'application/json');
        }

        // If not, add the user to the group
        $group->users()->attach($data['user_id']);

        $response->getBody()->write(json_encode(['group_id' => $group->id, 'user_id' => $data['user_id']]));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
