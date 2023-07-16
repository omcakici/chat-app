<!-- This file sets up the application, including setting up database connections and loading the routes. -->

<?php

use Slim\Factory\AppFactory;
use Illuminate\Database\Capsule\Manager as Capsule;
use Slim\Middleware\BodyParsingMiddleware;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create(); // Create a new Slim application

$capsule = new Capsule; // Create a new instance of the Capsule class for database management

$capsule->addConnection([
    'driver'   => 'sqlite', 
    'database' => __DIR__.'/database.sqlite',
]);

$capsule->setAsGlobal(); // Make the database manager instance globally accessible
$capsule->bootEloquent(); // Initialize the Eloquent ORM

// Add body parsing middleware
$app->add(new BodyParsingMiddleware());

require __DIR__ . '/app/Routes/api.php'; // Load the API routes

$app->addErrorMiddleware(true, true, true);

$app->run(); // Start the Slim application and handle incoming HTTP requests