<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionCollection;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(): PermissionCollection
    {
        return PermissionCollection::make(Permission::all());
    }
}
