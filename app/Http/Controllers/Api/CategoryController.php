<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::get();
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
            'name'   => 'required|unique:categories',
            'description' => 'nullable'
        ],[
            'required'  => 'Este campo es requerido.',
            'unique'    => 'Esta categoría ya está registrada.',
        ]);

        # En caso de haber errores
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }

        # Guardar datos
        (new Category)->create([
            'name'          => $request->name,
            'description'   => $request->description,
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('categories')->ignore($category->id,'id')
            ],
            'description'    => 'nullable'
        ],[
            'required'  => 'Este campo es requerido.',
            'unique'    => 'Esta categoría ya está registrada.',
        ]);

         

        # En caso de haber errores
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }


        # Guardar datos
        $category->update([
            'name'          => $request->name,
            'description'   => $request->description
        ]);

        # Devolver respuesta
        return response()->json([
            'success' => true,
            'message' => 'Guardado correctamente.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
    }
}
