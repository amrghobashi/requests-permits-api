<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTypeRoute extends Model
{
    protected $table = "USER_TYPE_ROUTES";
    public $timestamps = false;
    protected $primaryKey = "id";
    protected $guarded = [];

    public function route()
    {
        return $this->hasOne('App\Models\Route','route_id','route_id');
    }

    public function user_type()
    {
        return $this->hasOne('App\Models\UserType','user_type_id','id');
    }

}
