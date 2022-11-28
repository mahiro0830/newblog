<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    use HasFactory;

    protected $table = 'admin_users';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'locked_flg',
        'error_count',
    ];

    protected $hidden = [
        'password',
    ];
}
