<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Validator;

class UserController extends Controller
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email:rfc', 'unique:users'],
            'name' => ['required', 'min:3'],
            'password' => ['required', 'min:8'],
            'user_type_id' => ['required', 'exists:user_types,id'],
        ]);

        $user = $this->user->register($request->all());

        return $user;
    }

    public function update(Request $request)
    {
        return $request;
    }
}
