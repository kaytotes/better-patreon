<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Builds a Laravel Passport token and returns it.
     *
     * @return string
     */
    public function buildPassportToken(): string
    {
        $token = $this->createToken('Better Patreon Grant Client')->accessToken;

        return $token;
    }

    /**
     * Logs out the User by revoking tokens.
     * Can be a single token or all of them.
     *
     * @param boolean $all
     * @return boolean
     */
    public function logout(bool $all = false): bool
    {
        /* Remove Singular Token */
        if (! $all) {
            $this->token()->revoke();

            return true;
        }

        /* Remove All Tokens */
        foreach ($this->tokens as $token) {
            $token->revoke();
        }

        return true;
    }

    /**
     * Whether or not the User has a verified email address.
     *
     * @return boolean
     */
    public function isVerified(): bool
    {
        return ! is_null($this->email_verified_at);
    }

    /**
     * Always Hash the password field when it gets updated.
     *
     * @param string $value
     */
    public function setPasswordAttribute(string $value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
