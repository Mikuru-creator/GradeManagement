<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'user_name', 'email', 'password',
    ];

    //今は使用してない
    protected $hidden = [
        'password', 'remember_token',
    ];
}
