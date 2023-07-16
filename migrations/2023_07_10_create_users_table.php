<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

Capsule::schema()->create('users', function (Blueprint $table) {
    $table->increments('id');
    $table->string('username')->unique();
    $table->timestamps();
});
