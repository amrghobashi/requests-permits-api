<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gate extends Model
{
    protected $table = "GATE";
    public $timestamps = false;
    protected $primaryKey = "gate_id";
    protected $guarded = [];
}
