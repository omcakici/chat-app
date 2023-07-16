<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

Capsule::schema()->create('groups', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name');
    $table->integer('created_by')->unsigned();
    $table->foreign('created_by')->references('id')->on('users');
    $table->timestamps();
});
