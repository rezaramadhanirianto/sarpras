<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class returned extends Model
{
    protected $table = "returned_items";
    protected $guarded = ['id'];

    public function borrowed()
    {
        return $this->hasOne('App\Model\Borrow','id', 'borrowed_item_id');
    }
}
