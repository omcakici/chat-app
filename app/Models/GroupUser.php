<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Represents the relationship between a group and a user in the chat application.
 * 
 * The GroupUser class defines the model for the "group_user" table in the database.
 * It represents the many-to-many relationship between groups and users, indicating
 * which users are members of which groups.
 */
class GroupUser extends Model
{
    protected $table = 'group_user';

    protected $fillable = [
        'group_id',
        'user_id',
    ];
}
