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

        // Check if the request body is empty or not parsed as JSON
        // if (empty($data)) {
        //     $response = $response->withHeader('Content-Type', 'application/json')->withStatus(422);
        //     $response->getBody()->write(json_encode(['error' => 'Invalid JSON data']));
        //     return $response;
        // }
        
        // error_log($data);

        // Validation should be here.
        error_log(print_r($request->getParsedBody(), true));
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
