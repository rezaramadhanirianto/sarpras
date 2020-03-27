<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RoomItem extends Model
{
    protected $table = "roomitem";
    protected $guarded = ['id'];

    

    public function room()
    {
        return $this->hasOne('App\Model\Room', 'id', 'room_id');
    }
    public function item()
    {
        return $this->hasOne('App\Model\Item', 'id', 'item_id');
    }   
    
}
