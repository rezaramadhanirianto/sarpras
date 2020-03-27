<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded = ['id'];
    public function user()
    {
        return $this->hasOne('App\Model\Users', 'room_id', 'id');
    }
    public function roomitem()
    {
        return $this->hasMany('App\Model\RoomItem', 'room_id', 'id');
    }
}
