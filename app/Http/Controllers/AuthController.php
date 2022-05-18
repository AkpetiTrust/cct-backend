<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        $password = $request->password;

        if(isset($request->registration_number)){
            $registration_number = $request->registration_number;
            $credentials = [
                "registration_number" => $registration_number,
                "password" => $password,
            ];
            if(Auth::guard("students")->attempt($credentials)){
                $student = Auth::guard("students")->user();
                $response = [
                    "name" => $student->name,
                    "email" => $student->email,
                    "registration_number" => $student->registration_number,
                    "token" => $student->createToken("access_token")->plainTextToken,
                ];
                return response()->json($response);
            }else{
                return response()->json([
                    "response" => "Invalid credentials"
                ], 401);
            }
            
        }else if(isset($request->staff_id)){
            $staff_id = $request->staff_id;
            $credentials = [
                "staff_id" => $staff_id,
                "password" => $password,
            ];
            if(Auth::guard("staff")->attempt($credentials)){
                $staff = Auth::guard("staff")->user();
                $is_admin = $staff->is_admin;
                if($is_admin){
                    $token = $staff->createToken("access_token", ["admin-abilities", "staff-abilities"])->plainTextToken;
                }else{
                    $token = $staff->createToken("access_token", ["staff-abilities"])->plainTextToken;
                }
                $response = [
                    "name" => $staff->name,
                    "email" => $staff->email,
                    "staff_id" => $staff->staff_id,
                    "is_admin" => $is_admin,
                    "token" => $token
                ];
                return response()->json($response);
            }else{
                return response()->json([
                    "response" => "Invalid credentials"
                ], 401);
            }
        }
        
    }


    public function logout(){
        Auth::user()->tokens()->delete();

        return [
            'response' => 'Logged out'
        ];
    }
}

