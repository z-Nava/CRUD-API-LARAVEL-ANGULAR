<?php

namespace App\Http\Controllers;

use App\Models\DetalleDeOrden;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;


class DetalleDeOrdenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $detalleDeOrdenes = DetalleDeOrden::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cantidad' => 'required|integer|min:1',
            'precio' => 'required,|integer|min:0',
            'orden_id' => 'required|exists:ordenes,id',
            'producto_id' => 'required|exists:productos,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $detalleDeOrden = new DetalleDeOrden();
        $detalleDeOrden->cantidad = $request->cantidad;
        $detalleDeOrden->precio = $request->precio;
        $detalleDeOrden->orden_id = $request->orden_id;
        $detalleDeOrden->producto_id = $request->producto_id;
        $detalleDeOrden->save();

        return response()->json(['data' => $detalleDeOrden]);
    }

    /**
     * Display the specified resource.
     */
    public function show(DetalleDeOrden $detalleDeOrden)
    {
        $detalleDeOrden = DetalleDeOrden::find($detalleDeOrden->id);
        return response()->json(['data' => $detalleDeOrden]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetalleDeOrden $detalleDeOrden)
    {
        $validator = Validator::make($request->all(), [
            'cantidad' => 'required|integer|min:1',
            'precio' => 'required|numeric|min:0',
            'producto_id' => 'required|exists:productos,id',
            'orden_id' => 'required|exists:ordenes,id',
            'id' => 'required|exists:detalles_orden,id'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $detalleDeOrden = DetalleDeOrden::find($request->id);
        if(!$detalleDeOrden) {
            return response()->json(['errors' => 'Detalle de orden no encontrada'], 404);
        }

        $detalleDeOrden->cantidad = $request->cantidad;
        $detalleDeOrden->precio = $request->precio;
        $detalleDeOrden->producto_id = $request->producto_id;
        $detalleDeOrden->orden_id = $request->orden_id;
        $detalleDeOrden->save();

        return response()->json(['data' => $detalleDeOrden]);
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetalleDeOrden $detalleDeOrden)
    {
        $detalleDeOrden = DetalleDeOrden::find($detalleDeOrden->id);
        $detalleDeOrden->delete();
        return response()->json(['data' => 'Detalle de orden eliminada']);
    }
}
