<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = "users";
    protected $guarded = ['id'];


    public function room()
    {
        return $this->hasOne('App\Model\Room', 'id', 'room_id');
    }
}
