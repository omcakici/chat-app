<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Group;

class GroupController
{
    /**
     * This function handles the creation of a new group. 
     * It requires the 'name' and 'created_by' fields from the incoming request. 
     * It creates a new group record in the database, then returns the group ID, name, and creator ID in the response.
     */
    public function create(Request $request, Response $response, $args): Response
    {
        $data = json_decode($request->getBody()->getContents(), true);

        // error_log(print_r($request->getHeaders(), true));
        // error_log(print_r($request->getBody()->getContents(), true));


        if (!isset($data['name']) || !isset($data['created_by'])) {
            $response->getBody()->write(json_encode(['error' => 'Group name and creator ID are required']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(422);
        }

        $group = new Group();
        $group->name = $data['name'];
        $group->created_by = $data['created_by'];
        $group->save();

        $response->getBody()->write(json_encode(['id' => $group->id, 'name' => $group->name, 'created_by' => $group->created_by]));

        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * This function handles the joining of a user to a group. 
     * It requires a 'group_id' in the route parameters and a 'user_id' from the incoming request. 
     * It creates a new record in the group_user table, then returns the group ID and user ID in the response.
     */
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

        $groupUser = new GroupUser();
        $groupUser->group_id = $args['group_id'];
        $groupUser->user_id = $data['user_id'];
        $groupUser->save();

        $response->getBody()->write(json_encode(['group_id' => $groupUser->group_id, 'user_id' => $groupUser->user_id]));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
