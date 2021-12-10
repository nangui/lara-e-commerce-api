<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Contracts\IUserRepository;
use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    const DEFAULT_COLUMN = ['*'];
    const DEFAULT_RELATIONS = ['role'];
    const DEFAULT_PASSWORD = 'passer@123';

    const KEY_FIRSTNAME = 'first_name';
    const KEY_LASTNAME = 'last_name';
    const KEY_EMAIL = 'email';
    const KEY_ROLE_ID = 'role_id';
    const KEY_PASSWORD = 'password';
    const KEY_NEW_PASSWORD = 'new_password';

    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return UserCollection
     */
    public function index(): UserCollection
    {
        return new UserCollection($this->userRepository->paginate(self::DEFAULT_COLUMN, self::DEFAULT_RELATIONS));
    }

    /**
     * @param int $id
     * @return UserResource
     */
    public function show(int $id): UserResource
    {
        $user = $this->userRepository->findById($id, self::DEFAULT_COLUMN, self::DEFAULT_RELATIONS);

        return new UserResource($user);
    }

    /**
     * @param StoreUserRequest $request
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $user = $this->userRepository->create($request->only(
            self::KEY_FIRSTNAME,
            self::KEY_LASTNAME,
            self::KEY_EMAIL,
            self::KEY_ROLE_ID
        ) + [
            self::KEY_PASSWORD => Hash::make(self::DEFAULT_PASSWORD)
        ]);

        return response(UserResource::make($user), Response::HTTP_CREATED);
    }

    /**
     * @param UpdateUserRequest $request
     * @param $id
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $result = $this->userRepository->update($id, $request->only(
            self::KEY_FIRSTNAME,
            self::KEY_LASTNAME,
            self::KEY_EMAIL,
            self::KEY_ROLE_ID
        ));

        return response($result, Response::HTTP_ACCEPTED);
    }

    /**
     * @param $id
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->userRepository->deleteById($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @return User|null
     */
    public function user(): ?User
    {
        return Auth::user();
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     */
    public function updateInfo(Request $request)
    {
        $this->userRepository->update(Auth::id(), $request->only(
            self::KEY_FIRSTNAME,
            self::KEY_LASTNAME,
            self::KEY_EMAIL
        ));

        return response(UserResource::make(Auth::user()), Response::HTTP_ACCEPTED);
    }

    /**
     * @param UpdatePasswordRequest $request
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = Auth::user();

        $this->userRepository->update(Auth::id(), [
            self::KEY_PASSWORD => Hash::make($request->get(self::KEY_NEW_PASSWORD))
        ]);
        return response(UserResource::make(Auth::user()), Response::HTTP_ACCEPTED);
    }
}
