<?php

namespace App\Repositories;



use App\Models\User;
use Auth;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function create_record($data)
    {
        // Mail::to($request->email)->send(new VerifyEmail($pin));

        $credentials = Arr::only($data,['email', 'password']);
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);
        $user->authorization = [
        'token' => $this->create_token($credentials),
        'type' => 'bearer',
    ];
        return $user;
    }

    public function create_token($user)
    {
        return  Auth::guard('api')->attempt($user);
    }

}
