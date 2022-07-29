<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'user_type'
    ];

    public function attempt($credentials)
    {
        $user = $this->whereEmail($credentials['email'])
            ->first();

        if(!$user) {
            return null;
        }

        $isValid = Hash::check($credentials['password'], $user->getAuthPassword());

        return $isValid
            ? $user
            : null;
    }

    public function byEmail(string $email)
    {
        return $this->whereEmail($email)
            ->first();
    }

    public function getIsAdminAttribute()
    {
        return $this->user_type_id === UserType::ADMIN_ID;
    }

    public function getUserTypeAttribute()
    {
        return $this->userType()->first();
    }

    public function register($data)
    {
        $data['password'] = Hash::make($data['password']);
        $instance = $this->newInstance($data);
        $instance->user_type_id = $data['user_type_id'];
        $instance->save();
        
        return $instance;
    }

    public function userType()
    {
        return $this->belongsTo(UserType::class, 'id');
    }
}
