<?php

use Slim\Factory\AppFactory;
use Illuminate\Database\Capsule\Manager as Capsule;
use Slim\Middleware\BodyParsingMiddleware;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$capsule = new Capsule;

$capsule->addConnection([
    'driver'   => 'sqlite', 
    'database' => __DIR__.'/../database.sqlite',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

$app->add(new BodyParsingMiddleware());

$routes = require __DIR__ . '/../app/Routes/api.php';
$routes($app);

$app->run();
