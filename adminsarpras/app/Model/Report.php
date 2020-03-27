<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $guarded = ['id'];

    public function roomItem()
    {
        return $this->belongsTo('App\Model\RoomItem', 'room_item_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo('App\Model\Users', 'user_id', 'id');
    }

    public function tipe()
    {
        return $this->belongsTo('App\Model\Tipe', 'tipe_id', 'id');
    }   

    public function satuan()
    {
        return $this->belongsTo('App\Model\Satuan', 'satuan_id', 'id');
    }
}