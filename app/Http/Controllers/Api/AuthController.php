<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        
        
       /* $isExist = User::where('email',$request->email)->first();
        
        if($isExist){
          return response()->json([
            'message' => 'Email already exist',
            'token_type' => 'Bearer',
            ],404);
        }*/

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }
    
    public function login(Request $request){
      $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        $user = User::where('email', $request->email)->first();
        
        if(! $user || ! Hash::check($request->password, $user->password )){
          return response()->json([
            'message' => 'Email or password wrong'
        ], 401);
        }
        
        $token = $user->createToken('auth_token')->plainTextToken;
        
        return response()->json([
        'message' => 'User login successfully',
        'access_token' => $token,
        'token_type' => 'Bearer',
        'user' => $user
    ], 200);
    }
}
