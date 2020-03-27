<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class borrow extends Model
{
    protected $table = "borrowed_items";
    protected $guarded = ['id'];

    public function roomitem()
    {
        return $this->belongsTo('App\Model\RoomItem', 'room_item_id');
    }
    public function returned()
    {
        return $this->hasOne('App\Model\Returned','borrowed_item_id');
    }
}
