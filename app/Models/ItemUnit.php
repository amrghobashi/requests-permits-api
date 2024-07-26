<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemUnit extends Model
{
    protected $table = "ITEM_UNIT";
    public $timestamps = false;
    protected $primaryKey = "item_unit_id";
    protected $guarded = [];
}
