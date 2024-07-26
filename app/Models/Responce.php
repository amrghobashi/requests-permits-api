<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Responce extends Model
{
    protected $table = "RESPONSE";
    public $timestamps = false;
    protected $primaryKey = "responce_id";
    protected $guarded = [];
}
