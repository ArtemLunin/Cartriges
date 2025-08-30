<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    protected $fillable = ['name', 'email', 'password', 'refresh_token'];

    // Реализация интерфейса JWTSubject
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Возвращает id пользователя
    }

    public function getJWTCustomClaims()
    {
        return []; // Кастомные claims, например, ['roles' => $this->roles]
    }
}
