<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function verusuarios(){
        $usuarios = User::all();
        return response()->json(['data'=>$usuarios]);
    }


    function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|'
        ]);
        $credentials = $request->only('email', 'password');
        

        if (Auth::attempt($credentials)) {
          
            $request->session()->regenerate();
            return response()->json([
                'data' => Auth::user(), 'code'=>200

            ]);
        }
    
        
        return response()->json(['data'=>'El email o la contraseña no son correctas.', 'code'=>422]);
        
    }

    public function get_user(Request $request){
        $id = $request->user()->id;
        $user = User::with('direcciones')->find($id);

        return response()->json($user);

    }
    
}
