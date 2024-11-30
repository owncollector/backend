<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class ApiController extends Controller
{
    public function register(Request $request)
    {
       $name = $request->name ;
       $email = $request->email;
       $password =Hash::make($request->password); 

       $user = User::create([
        'name'=> $name,
        'email'=> $email,
        'password'=>Hash::make($password),
       ]);

       return repose()->json([
        'message'=>'Usuario registrado exitosamente',
        'data'=> $user
       ],200);


    }
}
