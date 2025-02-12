<?php

namespace catalyst\StarterKitRestApi\Http\Controllers\Auth;

use catalyst\StarterKitRestApi\Http\Controllers\Controller;
use catalyst\StarterKitRestApi\Http\Requests\Auth\RegisterValidation;
use catalyst\StarterKitRestApi\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use catalyst\StarterKitRestApi\Repositories\CrudRepository;

class AuthController extends Controller
{
    protected $crudRepository;

    public function __construct(CrudRepository $crudRepository)
    {
        $this->crudRepository = $crudRepository;
    }

    // User registration
    public function register(RegisterValidation $request)
    {
        $data = $request->validated();
        $user = $this->crudRepository->store(new User, $data, $request, null, null, null, ['password' => $data['password']]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    // User login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            // Get the authenticated user.
            $user = auth()->user();

            // (optional) Attach the role to the token.
            $token = JWTAuth::claims(['role' => $user->role])->fromUser($user);

            return response()->json(compact('token'));
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
    }

    // Get authenticated user
    public function getUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 400);
        }

        return response()->json(compact('user'));
    }

    // User logout
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }
}
