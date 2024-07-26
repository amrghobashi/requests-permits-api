<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = "ITEM_PARENT";
    public $timestamps = false;
    protected $primaryKey = "item_parent_id";
    protected $guarded = [];

    public function item_type()
    {
        return $this->hasOne('App\Models\ItemType', 'item_type_id', 'item_type_id');
    }
}
