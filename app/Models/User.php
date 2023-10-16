<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $appends = ['full_name'];

    protected $guarded = ['id'];

    public function role()
    {
        return $this->belongsTo(Role::class,'idRol');
    }

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class,'idDependencia');
    }

    public function getFullNameAttribute()
    {
        return "{$this->apellidoPaterno} {$this->apellidoMaterno} {$this->nombres}";
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
}
