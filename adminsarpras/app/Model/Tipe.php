<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tipe extends Model
{
    protected $table = "tipe";
    protected $fillable = ['tipe'];

    public function item()
    {
        return $this->hasMany('App\Model\Item', 'id', 'tipe_id');
    }
    
}
