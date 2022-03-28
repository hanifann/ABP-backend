<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
   public function register(Request $request)
   {    
       //data inputan
       $data = $request->only('name', 'password', 'address', 'email', 'role');

       //validator untuk melakukan pengecekan
       $validator = Validator::make($data, [
           'name' => 'required|string',
           'password' => 'required|string',
           'address' => 'required|string|min:6',
           'email' => 'required|string|email',
           'role' => 'string'
       ]);
       
        //cek kondisi apakah valid
       if($validator->fails()){
           return response()->json([
               'success' => false,
               'message' => $validator->messages()
            ],
               400
           );
       }

       //create user
       $user = User::create([
           'name' => $request->name,
           'password' => bcrypt($request->password),
           'address' => $request->address,
           'email' => $request->email,
           'role' => $request->role

       ]);

       //response success
       return response()->json([
           'success' => true,
           'message' => 'user created',
           'data' => $user
       ], Response::HTTP_OK);
   }

   public function authenticate(Request $request)
   {
       $credentials = $request->only('email', 'password');

       //validator untuk melakukan pengecekan
       $validator = Validator::make($credentials,[
           'email' => 'required|email',
           'password' => 'required|string|min:6'
       ]);
       //cek apakah valid
       if($validator->fails()){
           return response()->json([
               'success' => false,
               'message' => $validator->messages()
           ], 400);
       }

       //create jwt token
       try {
           if(! $token = auth()->attempt($credentials)){
               return response()->json([
                   'success' => false,
                   'message' => 'login credentials invalid'
               ], 400);
           }
       } catch (JWTException $e) {
           return $credentials;
           return response()->json([
               'success' => false,
               'message' => 'could not create token'
           ], 500);
       }

       return response()->json([
           'success' => true,
           'token' => $token
       ], 200);
   }

   public function logout()
   {
       auth()->logout();

       return response()->json(['message' => 'Successfully logged out']);
   }

   public function me()
    {
        return response()->json(auth()->user());
    }
}
