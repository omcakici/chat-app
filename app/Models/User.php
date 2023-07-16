<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Represents a user in the chat application.
 *
 * The User class defines the model for the "users" table in the database.
 * It stores information about users registered in the chat application.
 * The class provides attributes for the username and relationships to retrieve associated groups and messages.
 */
class User extends Model {

    protected $table = 'users';

    protected $fillable = [
        'username',
    ];
}
