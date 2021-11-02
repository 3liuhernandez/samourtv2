<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'name'   => 'required',
            'email' => 'required|unique:users',
            'role'    => 'required|in:0,1',
            'type'   => 'required|in:0,1',
            'password'   => 'required|confirmed',
            'password_confirmation' => 'required',
        ],[
            'required'  => 'Este campo es requerido.',
            'unique'    => 'Este email ya está en uso.',
            'in'  => 'Valor inválido.',
            'confirmed'  => 'La contraseña no coincide.'
        ]);

        # En caso de haber errores
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }

        # Guardar datos
        (new User)->create([
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            'type'      => $request->type,
            'password'  => bcrypt($request->password)
        ]);

        # Devolver respuesta
        return response()->json([
            'success' => true,
            'message' => 'Guardado correctamente.'
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\fr  $fr
     * @return \Illuminate\Http\Response
     */
    public function show(fr $fr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\fr  $fr
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $validator = Validator::make($request->all(), [
            'name'   => 'required',
            'email' => [
                'required',
                Rule::unique('users')->ignore($user->id,'id')
            ],
            'role'    => 'required|in:0,1',
            'type'   => 'required|in:0,1',
            'password'   => 'nullable|confirmed',
            'password_confirmation' => 'nullable',
        ],[
            'required'  => 'Este campo es requerido.',
            'unique'    => 'Este email ya está en uso.',
            'in'  => 'Valor inválido.',
            'confirmed'  => 'La contraseña no coincide.'
        ]);

         

        # En caso de haber errores
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }

        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            'type'      => $request->type
        ];

        if (!Str::of($request->password)->trim()->isEmpty()) {
            $data['password'] = bcrypt($request->password);
        }
        # Guardar datos
        $user->update($data);

        # Devolver respuesta
        return response()->json([
            'success' => true,
            'message' => 'Guardado correctamente.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\fr  $fr
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
    }
}
