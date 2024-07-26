<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = "NOTIFICATION";
    public $timestamps = false;
    protected $primaryKey = "notification_id";
    protected $guarded = [];
}
