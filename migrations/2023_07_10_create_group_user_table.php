<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

Capsule::schema()->create('group_user', function (Blueprint $table) {
    $table->integer('group_id')->unsigned();
    $table->integer('user_id')->unsigned();
    $table->foreign('group_id')->references('id')->on('groups');
    $table->foreign('user_id')->references('id')->on('users');
    $table->primary(['group_id', 'user_id']);
});
