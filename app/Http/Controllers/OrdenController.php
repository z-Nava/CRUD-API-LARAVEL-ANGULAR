<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class OrdenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ordenes = Orden::all();
        return response()->json(['data' => $ordenes]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'cliente_id' => 'required',
            'fecha' => 'required',
            'total' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $orden = new Orden();
        $orden->cliente_id = $request->cliente_id;
        $orden->fecha = $request->fecha;
        $orden->total = $request->total;
        $orden->save();

        return response()->json(['data' => $orden],200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Orden $orden)
    {
        $orden = Orden::find($orden->id);
        return response()->json(['data' => $orden],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Orden $orden)
    {
        $rules = [
            'cliente_id' => 'required',
            'fecha' => 'required',
            'total' => 'required',
        ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
    
            $orden = Orden::find($orden->id);
            if(!$orden){
                return response()->json(['error' => 'Orden no encontrada'], 404);
            }

            $orden->cliente_id = $request->cliente_id;
            $orden->fecha = $request->fecha;
            $orden->total = $request->total;
            $orden->save();
    
            return response()->json(['data' => $orden],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orden $orden)
    {
        $orden = Orden::find($orden->id);
        $orden -> delete();
        return response()->json(['data' => $orden],200);
    }
}
