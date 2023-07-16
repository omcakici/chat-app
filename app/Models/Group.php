<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Overall, the "Group" class encapsulates the behavior and properties related to groups in the chat application. 
 * It allows for easy database interaction, defines relationships with other models, 
 * and provides access to the user who created the group.
 */
class Group extends Model {

    protected $table = 'groups';

    protected $fillable = [
        'name', 'created_by'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User', 'created_by');
    }
}
