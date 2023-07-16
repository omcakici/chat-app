<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

Capsule::schema()->create('messages', function (Blueprint $table) {
    $table->increments('id');
    $table->integer('group_id')->unsigned();
    $table->integer('user_id')->unsigned();
    $table->text('message');
    $table->foreign('group_id')->references('id')->on('groups');
    $table->foreign('user_id')->references('id')->on('users');
    $table->timestamps();
});
