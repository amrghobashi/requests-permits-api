<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $table = "USER_TYPE";
    public $timestamps = false;
    protected $primaryKey = "user_type_id";
    protected $guarded = [];
}
