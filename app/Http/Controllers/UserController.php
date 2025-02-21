<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $user = new User([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password)
        ]);
        
        $user->save();
        $token = JWTAuth::fromUser($user);
        
        return response()->json(compact('user','token'), 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($data)) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to authenticate.',
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('appToken')->accessToken;
        //$tokenResult = $user->createToken('Personal Access Token');
        //$token = $tokenResult->token;
        if($request->remember_me){
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        //$token->save();

        return response()->json(compact('user','token'), 201);
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
    public function logout(Request $request)
    {
        //$request->token->revoke();
        //$user = Auth::user()->token();
       // $user->revoke();
       Auth::logout();

        return response()->json(['message' => Auth::user()]);
    }

    public function Users()
    {
        $users = User::get();
        return response()->json(['users' => $users]);
    }
}
