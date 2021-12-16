<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleCollection;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(): RoleCollection
    {
        \Gate::authorize('view', 'roles');
        return RoleCollection::make(Role::query()->get());
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        \Gate::authorize('edit', 'roles');
        $this->validate($request, [
            'name' => 'required|string|max:100'
        ]);

        $role = Role::create($request->only('name'));

        if ($permissions = $request->input('permissions')) {
            foreach ($permissions as $permissionId) {
                \DB::table('role_permission')->insert([
                    'role_id' => $role->id,
                    'permission_id' => $permissionId
                ]);
            }
        }

        return response(RoleResource::make($role), Response::HTTP_CREATED);
    }

    /**
     * @throws AuthorizationException
     */
    public function show($id)
    {
        \Gate::authorize('view', 'roles');
        return response(RoleResource::make(Role::findOrFail($id)));
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function update(Request $request, $id)
    {
        \Gate::authorize('edit', 'roles');
        $this->validate($request, [
            'name' => 'required|string|max:100'
        ]);

        $role = Role::find($id);

        $role->update($request->only('name'));

        \DB::table('role_permission')->where('role_id', $role->id)->delete();

        if ($permissions = $request->input('permissions')) {
            foreach ($permissions as $permissionId) {
                \DB::table('role_permission')->insert([
                    'role_id' => $role->id,
                    'permission_id' => $permissionId
                ]);
            }
        }

        return response(RoleResource::make($role), Response::HTTP_ACCEPTED);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy($id)
    {
        \Gate::authorize('edit', 'roles');
        \DB::table('role_permission')->where('role_id', $id)->delete();
        Role::destroy($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
