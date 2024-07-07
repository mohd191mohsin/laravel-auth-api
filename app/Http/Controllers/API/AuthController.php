<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        // dd($request->all());
        $request->validate([
            "name"=>"required",
            "email"=> "email|required",
            "password"=> "required|confirmed",
        ]);
        User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>bcrypt($request->password),
        ]);
        return response()->json([
            "status"=>true,
            "message"=>"user created successfully!!",
            "data"=>[]
        ]);
    }
    public function login(Request $request){
        $request->validate([
            "email"=> "required|email",
            "password"=>"required"
        ]);
        $user = User::where("email",$request->email)->first();
        if(!empty($user)){
            if(Hash::check($request->password,$user->password)){
                $token = $user->createToken('mytoken')->plainTextToken;

            return response()->json([
                "status"=>true,
                "message"=>"user logged in",
                "token"=>$token,
                "data"=>[]
            ]);
            }else{
                return response()->json([
                    "status"=>false,
                    "message"=>"please enter a valid password!!",
                    "data"=>[]
                ]);

            }
        }
        else{
            return response()->json([
                "status"=>false,
                "message"=>"please enter a valid email and password!!",
                "data"=>[]
            ]);
        }
    }

    public function profile(){
        $userData = auth()->user();
        return response()->json([
            "status"=>true,
            "message"=>"Profile Info",
            "data"=>$userData
        ]);

    }
    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
            "status"=>true,
            "message"=>"logged out",
            "data"=>[]
        ]);
    }
}
