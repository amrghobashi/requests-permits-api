<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $table = "ROUTES";
    public $timestamps = false;
    protected $primaryKey = "route_id";
    protected $guarded = [];
}
