<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class UserController extends Controller
{
    public function index(): Collection
    {
        return User::query()->get();
    }

    public function show()
    {

    }
}
