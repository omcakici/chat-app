<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use App\Controllers\UserController;
use App\Controllers\GroupController;
use App\Controllers\MessageController;

// Using Slim\App instead of Slim\Factory\AppFactory
// So we don't need to create $app and call $app->run() here

return function (App $app) {
    // Ignore the request for favicon.ico
    $app->get('/favicon.ico', function (Request $request, Response $response) {
        return $response->withStatus(204);
    });

    // User routes
    $app->post('/user/create', UserController::class . ':create');

    $app->post('/debug', function (Request $request, Response $response, $args) {
        $body = $request->getBody();
        $response->getBody()->write($body);
        return $response->withHeader('Content-Type', 'text/plain');
    });
    
    // Group routes
    $app->post('/group/create', GroupController::class . ':create');
    $app->put('/group/{group_id}/join', GroupController::class . ':join');

    // Message routes
    $app->post('/group/{group_id}/message/create', MessageController::class . ':create');
    $app->get('/group/{group_id}/messages', MessageController::class . ':listAll');
};

