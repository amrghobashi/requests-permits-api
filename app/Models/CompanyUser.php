<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class CompanyUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = "COMPANY_USERS";
    public $timestamps = false;
    protected $primaryKey = "company_id";
    protected $guarded = [];

    protected $fillable = [
        'user_name',
        'user_pass',
        'record_date',
        'active',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}