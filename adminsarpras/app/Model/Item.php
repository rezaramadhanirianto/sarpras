<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    protected $guarded = ['id'];

    public function tipe()
    {
        return $this->belongsTo('App\Model\Tipe', 'tipe_id', 'id');
    }   

    public function satuan()
    {
        return $this->belongsTo('App\Model\Satuan', 'satuan_id', 'id');
    }

    public function roomItem()
    {
        return $this->hasOne('App\Model\RoomItem', 'item_id', 'id');
    }

}
