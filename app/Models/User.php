<?php

namespace App\Models;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Http\Resources\UserResource;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Str;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use HasApiTokens;

    public $resourceClass = UserResource::class;

    protected $table='users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isVerified()
    {
        return $this->verified == UserStatus::VERIFIED;
    }

    public function isAdmin()
    {
        return $this->admin == UserType::ADMIN;
    }

    public static function generateVerificationCode()
    {
        return Str::random(40);
    }

    public function setPasswordAttribute(string $password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
}
