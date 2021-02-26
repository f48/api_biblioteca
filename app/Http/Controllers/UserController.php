<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function register(Request $request) 
    {
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required'
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 422);         
        } else {

            $query = DB::table('users')->where('email', $request->get('email'))->first();

            if ($query == null) {
                $user = User::create([
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'password' => bcrypt($request->get('password')),
                ]);
                $token = JWTAuth::fromUser($user);
                $success['id'] =  $user->id;
                $success['name'] =  $user->name;
    
                return response()->json(compact('user','token'),201);
            } else {
                return response()->json(['error'=> "No se puede insertar"], 422);         
            }
        } 
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token'));
    }
}
