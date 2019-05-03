<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    /**
     * Login
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function login(Request $request){
        $credentials = $request->only("email", "password");

        $count = User::where('email', $request->input('email') )->count();
        if($count == 1){
            if((User::where('email',$request->input('email'))->first()->api_token == $request->input('api_token'))){
                return User::where('email', $request->input('email') )->first();
            }else{
                return response(['message' => 'Unauthorized'], 403);
            }
            
        }else{
            return response(['message' => 'Email not found'], 404);
        }
     
            
        

        
     }

     /**
     * Register
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request){

        $api_token = Str::random(60);

        $user = new User;
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->api_token = $api_token;
        $user->save();

        return (new UserResource($user))->additional(['access_token' => $api_token]);
 
         
      }


}
