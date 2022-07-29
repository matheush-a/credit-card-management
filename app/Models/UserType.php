<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;
    public const ADMIN_ID = 1;
    public const GUEST_ID = 1;

    protected $fillable = [
        'description',
        'user_type_id',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
