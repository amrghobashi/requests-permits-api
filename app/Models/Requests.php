<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
    protected $table = "request_permitS";
    public $timestamps = false;
    protected $primaryKey = "request_id";
    protected $guarded = [];

    public function company()
    {
        return $this->hasOne('App\Models\Company','company_id','company_id');
    }

    public function status()
    {
        return $this->hasOne('App\Models\RequestStatus','request_status_id','request_status_id');
    }

    public function response()
    {
        return $this->hasOne('App\Models\Responce','responce_id','response_id');
    }

    public function gate()
    {
        return $this->hasOne('App\Models\Gate','gate_id','gate_id');
    }
}
