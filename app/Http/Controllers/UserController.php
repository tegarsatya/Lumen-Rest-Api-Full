<?php

namespace App\Http\Controllers;
Use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'email'     => 'required|unique:users,email',
            'password'  => 'required|min:6',

        ]);

        $email          = $request->input('email');
        $password       = $request->input('password');
        $hasPassword    = Hash::make($password);

        $user           = User::create([
            'email'     => $email,
            'password'  => $hasPassword

        ]);

        return response()->json(['message'=> 'Success Register'], 201);

    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'     => 'required|email',
            'password'  => 'required|min:6',

        ]);

        $email          = $request->input('email');
        $password       = $request->input('password');

        $user = User::where('email', $email)->first();
            if (!$user) {
                return response()->json(['message' => 'Success Failed!'], 401);
            }
        $isValidPassword = Hash::check($password, $user->password);
            if (!$isValidPassword) {
                return response()->json(['message' => 'Success Failed!'], 401);
            }

        $generatorToken = bin2hex(random_bytes(40));
        $user->update([
            'token'     => $generatorToken
        ]);

        return response()->json($user);

    }
}
