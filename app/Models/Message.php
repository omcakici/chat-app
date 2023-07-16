<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Represents a message in the chat application.
 *
 * The Message class defines the model for the "messages" table in the database.
 * It stores information about messages sent by users within groups.
 * The class provides relationships to retrieve the associated user and group for each message.
 */

class Message extends Model {

    protected $table = 'messages';

    protected $fillable = [
        'group_id', 'user_id', 'message', 'created_at'
    ];
    
    /**
     * Get the user who sent the message.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * Get the group in which the message was sent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function group(){
        return $this->belongsTo('App\Models\Group', 'group_id');
    }
}
