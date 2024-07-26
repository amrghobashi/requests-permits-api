<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = "COMPANY";
    public $timestamps = false;
    protected $primaryKey = "company_id";
    protected $guarded = [];

}
