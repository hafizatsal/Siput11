<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'nama',
        'username',
        'email',
        'instansi',
        'password',
        'id_role',
        'blocked_date',
        'pass_default',
        'pass_stat',
        'api_token',
        'remember_token',
        'last_login',
        'logout_time',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 🔹 Yang ini TIDAK BOLEH ada:
    // public function getAuthIdentifierName()
    // {
    //     return 'username';
    // }

    // 🔹 Fungsi yang benar untuk login pakai username:
   

}
