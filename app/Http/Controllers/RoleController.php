<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    public function index(): Collection
    {
        return Role::query()->get();
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100'
        ]);

        $role = Role::create($request->only('name'));

        return response($role, Response::HTTP_CREATED);
    }

    public function show($id)
    {
        return Role::findOrFail($id);
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100'
        ]);

        $role = Role::find($id);

        $role->update($request->only('name'));

        return response($role, Response::HTTP_ACCEPTED);
    }

    public function destroy($id)
    {
        Role::destroy($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
