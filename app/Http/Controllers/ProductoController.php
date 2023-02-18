<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;


class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::all();
        return response()->json(['data' => $productos]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required',
            'descripcion' => 'required',
            'precio' => 'required',  
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->save();

        return response()->json(['data' => $producto],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        $producto = Producto::find($producto->id);
        return response()->json(['data' => $producto],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        $rules = [
            'nombre' => 'required',
            'descripcion' => 'required',
            'precio' => 'required',  
        ];
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $producto = Producto::find($producto->id);
        if(!$producto){
            return response()->json(['error' => 'No se encuentra el producto'], 400);
        }

        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->save();
        return response()->json(['data' => $producto],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        $producto = Producto::find($producto->id);
        $producto->delete();
        return response()->json(['data' => $producto],200);
    }
}
