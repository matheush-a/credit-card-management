<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected Category $category;

    public function __construct(User $user, Category $category)
    {
        $this->user = $user;
        $this->category = $category;
    }

    public function index()
    {
        return $this->category->select([
            'id',
            'name'
        ])->orderBy('id')
        ->get();
    }
}
