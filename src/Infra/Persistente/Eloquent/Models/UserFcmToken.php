<?php

namespace Infra\Persistente\Eloquent\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserFcmToken extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $table = 'user_fcm_tokens';

    protected $fillable = [
        'user_id',
        'user_agent',
        'token'
    ];
}
