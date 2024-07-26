<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestStatus extends Model
{
    protected $table = "request_permitS_STATUS";
    public $timestamps = false;
    protected $primaryKey = "request_status_id";
    protected $guarded = [];
}
