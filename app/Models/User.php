<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id'; 
    public $timestamps = true;

    protected $fillable = [
        'full_name',
        'email',
        'phone_number',
        'password_hash',
        'gender',
        'role_id',
        'branch_id',
        'status',
        'created_at',
    ];

    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}
