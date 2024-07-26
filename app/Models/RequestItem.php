<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestItem extends Model
{
    protected $table = "REQUEST_ITEMS";
    public $timestamps = false;
    protected $primaryKey = "item_id";
    protected $guarded = [];

    public function item_parent()
    {
        return $this->hasOne('App\Models\Item','item_parent_id','item_parent_id');
    }

    public function item_unit()
    {
        return $this->hasOne('App\Models\ItemUnit','item_unit_id','item_unit_id');
    }
    public function response()
    {
        return $this->hasOne('App\Models\Responce','responce_id','ceo_response');
    }
}
