<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\User;

class UserController
{
    public function create(Request $request, Response $response, $args): Response
    {
        error_log('UserController create method was called');
        $data = $request->getParsedBody();

        if (!isset($data['username'])) {
            $response = $response->withHeader('Content-Type', 'application/json')->withStatus(422);
            $response->getBody()->write(json_encode(['error' => 'Username is required']));
            return $response;
        }

        // Check if the username already exists
        if (User::exists($data['username'])) {
            $response = $response->withHeader('Content-Type', 'application/json')->withStatus(409);
            $response->getBody()->write(json_encode(['error' => 'Username is already in use']));
            return $response;
        }

        $user = new User();
        $user->username = $data['username'];
        $user->save();

        $response->getBody()->write(json_encode(['id' => $user->id, 'username' => $user->username]));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
