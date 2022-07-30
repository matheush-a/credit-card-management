<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    protected Brand $brand;

    public function __construct(User $user, Brand $brand)
    {
        $this->user = $user;
        $this->brand = $brand;
    }

    public function index()
    {
        $this->authorize('interact', Brand::class);

        return $this->brand->select([
            'id',
            'name'
        ])->orderBy('id')
        ->get();
    }
}
