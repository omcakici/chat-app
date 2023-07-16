<?php

require 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'sqlite',
    'database'  => 'database.sqlite',
    'prefix'    => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

require 'migrations/2023_07_10_create_users_table.php';
require 'migrations/2023_07_10_create_groups_table.php';
require 'migrations/2023_07_10_create_group_user_table.php';
require 'migrations/2023_07_10_create_messages_table.php';
