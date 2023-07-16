<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Message;

class MessageController
{
    /**
     * This function handles the creation of a new message.
     * It requires the 'user_id', 'group_id', and 'message' fields from the incoming request.
     * It creates a new message record in the database, then returns the message ID, user ID, group ID, and message text in the response.
     */
    public function create(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();

        if (!isset($data['user_id']) || !isset($data['group_id']) || !isset($data['message'])) {
            $response->getBody()->write(json_encode(['error' => 'User ID, Group ID, and message are required']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(422);
        }

        $message = new Message();
        $message->user_id = $data['user_id'];
        $message->group_id = $data['group_id'];
        $message->message = $data['message'];
        $message->save();

        $response->getBody()->write(json_encode(['id' => $message->id, 'user_id' => $message->user_id, 'group_id' => $message->group_id, 'message' => $message->message]));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    /**
     * This function handles the listing of all messages in a specific group.
     * It requires a 'group_id' in the route parameters. 
     * It retrieves all messages for the specified group from the database, then returns the messages in the response.
     */
    public function listAll(Request $request, Response $response, $args): Response
    {
        if (!isset($args['group_id'])) {
            $response->getBody()->write(json_encode(['error' => 'Group ID is required']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(422);
        }

        $messages = Message::where('group_id', $args['group_id'])->get();

        $response->getBody()->write(json_encode($messages));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
