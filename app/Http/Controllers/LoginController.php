<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Vista del login
     */
    public function index(){
        return view('auth/login');
    }

    /**
     * Logea a un usuario mediante el token
     */
    public function loginToken(Request $request, $token) {
        # Petición al usuario segun el token
        $api_url = url('api') . '/user';
        $response = Http::withToken($token)->get($api_url);
        $result = json_decode($response->body());



        # En caso de haber resultado
        if(null != $result) {
            $user = User::findOrFail($result->id);
            $user->access_token = $token;
            $user->save();
            Auth::loginUsingId($result->id);

        }

        return redirect()->intended('/');
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request){

        if(null != auth()->user()) {
            auth()->user()->tokens->each(function ($token, $key) {
                $token->delete();
            });

            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();
        }


        return redirect('/');
    }
}
