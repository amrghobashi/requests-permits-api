<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    protected $table = "ITEM_TYPE";
    public $timestamps = false;
    protected $primaryKey = "item_type_id";
    protected $guarded = [];
}
