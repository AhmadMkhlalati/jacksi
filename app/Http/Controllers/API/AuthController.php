<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->userRepo = $userRepo;

    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        $token = $this->userRepo->create_token($credentials);

        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }


        $user = Auth::guard('api')->user();
        $user->authorization = [
        'token' => $token,
        'type' => 'bearer',
        ];
        return response()->json([
            'user' => $user,

        ]);
    }

    public function register(UserRegisterRequest $request)
    {
        $user = $this->userRepo->create_record($request->validated());
        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
        ]);
    }

    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'user' => Auth::guard('api')->user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
