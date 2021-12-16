<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            $token = $user->createToken('admin')->accessToken;

            if ($request->has('withCookie')) {
                $cookie = \cookie('jwt', $token, 3600);

                return response()->json(['token' => $token])->withCookie($cookie);
            }

            return response()->json([
                'token' => $token,
            ]);
        }

        return new JsonResponse([
            'error' => 'Invalid Credentials'
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::query()->create($request->only('first_name', 'last_name', 'email') + [
            'password' => Hash::make($request->get('password'))
        ]);

        return response()->json(UserResource::make($user),Response::HTTP_CREATED);
    }

    public function logout(): JsonResponse
    {
        $cookie = cookie()->forget('jwt');

        return response()->json(['message' => 'success'])->withCookie($cookie);
    }
}
