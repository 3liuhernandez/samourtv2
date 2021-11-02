<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{

    /**
     * Inicia la sesión de un usuario
     *
     * @return json response
     */
    public function login(Request $request)
    {

        # Validar datos
        $validator = Validator::make($request->all(), [
            'email'   => 'required|email',
            'password' => 'required',
        ],[
            'required' => 'Este campo es requerido.',
            'email' => 'El correo no tiene un formato válido.',
        ]);

        # En caso de haber errores
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }


        # Datos para oauth
        $data = [
            'grant_type' => 'password',
            'client_id' => config('services.passport.client_id'),
            'client_secret' => config('services.passport.client_secret'),
            'username' => $request->email,
            'password' => $request->password,
        ];


        # Petición para el login
        $req = Request::create('/oauth/token', 'POST', $data);
        $resp = app()->handle($req);

        $r = json_decode($resp->getContent(), true);


        # Credenciales incorrecas
        if(array_key_exists('error', $r)){
            return response()->json([
                'success' => false,
                'error' => 'Credenciales incorrectas.'
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Has iniciado sesion correctamente.',
            'body' => json_decode($resp->getContent()),
        ], 200);
    }

    /**
     * Registra un usuario.
     *
     * @return json response
     */
    public function register(Request $request)
    {
        # Validar datos
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email'   => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ],[
            'required' => 'Este campo es requerido.',
            'email' => 'El correo no tiene un formato válido.',
            'password.confirmed' => 'La contraseña no coincide.',
            'email.unique' => 'Este email ya está registrado.'
        ]);

        # En caso de haber errores
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'error' => $validator->getMessageBag()->toArray()
            ]);
        }

        # Crear usuario
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        # Respuesta
        return response()->json([
            'success' => true,
            'message' => 'Usuario creado correctamente.'
        ], 200);
    }

    /**
     * Cierra la sesión de un usuario
     *
     * @return json response
     */
    public function logout(Request $request)
    {

        if(null != auth()->user() ){
            auth()->user()->tokens->each(function ($token, $key) {
                $token->delete();
            });
        }


        return response()->json('Logged out successfully', 200);
    }


}
