<?php

require_once __DIR__.'/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'sqlite',
    'database'  => __DIR__.'/database.sqlite',
]);

$capsule->setAsGlobal();

$capsule->bootEloquent();

use App\Models\Group;
use App\Models\User;
use App\Models\Message;

// Create a new user
$user = new User;
$user->username = 'test_user';
$user->save();

// Create a new group
$group = new Group;
$group->name = 'test_group';
$group->created_by = $user->id;
$group->save();

// Post a message to the group
$message = new Message;
$message->group_id = $group->id;
$message->user_id = $user->id;
$message->message = 'Hello, World!';
$message->save();

// Retrieve the message and display
$retrieved_message = Message::find(1);
echo $retrieved_message->message;
