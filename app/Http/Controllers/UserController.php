<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index(): UserCollection
    {
        return new UserCollection(User::query()->orderByDesc('id')->paginate(10));
    }

    public function show($id): UserResource
    {
        $user = User::query()->findOrFail($id);

        return new UserResource($user);
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::query()->create($request->only('first_name', 'last_name', 'email') + [
            'password' => Hash::make('pass@123')
        ]);

        return response(UserResource::make($user), Response::HTTP_CREATED);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::query()->findOrFail($id);

        $user->update($request->only('first_name', 'last_name', 'email'));

        return response(UserResource::make($user), Response::HTTP_ACCEPTED);
    }

    public function destroy($id)
    {
        $user = User::query()->findOrFail($id);

        if ($user) $user->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function user(): ?User
    {
        return Auth::user();
    }

    public function updateInfo(Request $request)
    {
        $user = Auth::user();

        $user->update($request->only('first_name', 'last_name', 'email'));

        return response(UserResource::make($user), Response::HTTP_ACCEPTED);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = Auth::user();

        $user->update([
            'password' => Hash::make($request->get('new_password'))
        ]);
        return response(UserResource::make($user), Response::HTTP_ACCEPTED);
    }
}
