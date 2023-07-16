<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\User;

class UserController
{
    /**
     * This function handles the creation of a new user.
     * It requires the 'username' field from the incoming request.
     * It creates a new user record in the database, then returns the user ID and username in the response.
     */
    public function create(Request $request, Response $response, $args): Response
    {
        error_log('UserController create method was called');
        $data = $request->getParsedBody();

        // Log the incoming data
        error_log("Data: ", $data);

        // Validation should be here.
        if (!isset($data['username'])) {
            $response = $response->withHeader('Content-Type', 'application/json')->withStatus(422);
            $response->getBody()->write(json_encode(['error' => 'Username is required']));
            return $response;
        }

        $user = new User();
        $user->username = $data['username'];
        $user->save();

        $response->getBody()->write(json_encode(['id' => $user->id, 'username' => $user->username]));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
