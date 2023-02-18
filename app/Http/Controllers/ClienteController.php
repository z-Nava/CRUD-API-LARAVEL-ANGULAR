<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $clientes = Cliente::all();
        return response()->json(['data' => $clientes]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required',
            'direccion' => 'required',
            'correo_electronico' => 'required|email',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        
        $cliente = new Cliente();
        $cliente->nombre = $request->nombre;
        $cliente->direccion = $request->direccion;
        $cliente->correo_electronico = $request->correo_electronico;
        $cliente->save();

        return response()->json(['data' => $cliente]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        $cliente = Cliente::find($cliente->id);
        return response()->json(['data' => $cliente]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $rules = [
            'nombre' => 'required',
            'direccion' => 'required',
            'correo_electronico' => 'required|email',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        
        $cliente = Cliente::find($cliente->id);
        if(!$cliente){
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        $cliente->nombre = $request->nombre;
        $cliente->direccion = $request->direccion;
        $cliente->correo_electronico = $request->correo_electronico;
        $cliente->save();
        return response()->json(['data' => $cliente],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente = Cliente::find($cliente->id);
        $cliente->delete();
        return response()->json(['data' => $cliente]); 
    }
}
