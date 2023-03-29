<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        // try {
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)){
                return response()->json(['message' => 'Email or Password Incorrect'], 401);
            }

            if($user->role == 'Admin'){
                $token = $user->createToken($request['email'], ['admin'])->plainTextToken;
            }

            else{
                $token = $user->createToken($request['email'], ['approver'])->plainTextToken;
            }

            return response()->json([
                'message' => 'success login',
                'data' => $user,
                'token' => $token
                ], 200);
        // } catch (\Throwable $th) {
        //     return response()->json(['message' => $th], 400);
        // }
    }

    public function logout(Request $request){
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json(['message' => 'Berhasil Logout'], 200);
    }
}
