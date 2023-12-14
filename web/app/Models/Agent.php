<?php

namespace App\Models;

use Laravel\Sanctum\Sanctum;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Agent extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable;
    use Authorizable;
    use HasApiTokens;
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'name',
    ];

    public function lastUsedToken()
    {
        return $this->morphOne(Sanctum::$personalAccessTokenModel, 'tokenable')
            ->ofMany('last_used_at');
    }

    public function isOnline(): bool
    {
        if (! $token = $this->lastUsedToken) {
            return false;
        }

        return $token->last_used_at->isAfter(now()->subMinutes(5));
    }
}
