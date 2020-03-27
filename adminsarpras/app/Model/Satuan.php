<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    protected $fillable = ['satuan'];

    public function item()
    {
    	return $this->hasMany('App\Model\Item', 'id', 'satuan_id');
    }
}
