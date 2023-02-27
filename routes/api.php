<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\DetalleDeOrdenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

use function PHPSTORM_META\map;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

<<<<<<< Updated upstream


Route::prefix('/v1')->group(function()
{

    //AUTENTICACION
    Route::post("/registro",[AuthController::class,'register'])->middleware('auth:sanctum');
    Route::post("/login",[AuthController::class,'login']);
    Route::get("/logout",[AuthController::class,'logout'])->middleware('auth:sanctum');
    //TEST
    Route::get('/test',[ClienteController::class,'index'])->middleware('auth:sanctum','verify.role.email:1');
    //CLIENTES
    Route::get("/clientes",[ClienteController::class,'index'])->middleware('auth:sanctum','verify.role.email:2');
=======
Route::post("/registro",[AuthController::class,'register']);
Route::post("/login",[AuthController::class,'login']);
Route::get("/logout",[AuthController::class,'logout']);

Route::prefix('/v1')->middleware('auth:sanctum')->group(function()
{
    //CLIENTES
    Route::get("/clientes",[ClienteController::class,'index']);
>>>>>>> Stashed changes
    Route::post("/clientes",[ClienteController::class,'store']);
    Route::get("/clientes/{cliente}",[ClienteController::class,'show']);
    Route::put("/clientes/{cliente}",[ClienteController::class,'update']);
    Route::delete("/clientes/{cliente}",[ClienteController::class,'destroy']);

    //PRODUCTOS
    Route::get("/productos",[ProductoController::class,'index']);
    Route::post("/productos",[ProductoController::class,'store']);
    Route::get("/productos/{producto}",[ProductoController::class,'show']);
    Route::put("/productos/{producto}",[ProductoController::class,'update']);
    Route::delete("/productos/{producto}",[ProductoController::class,'destroy']);

    //ORDENES
    Route::get("/ordenes",[OrdenController::class,'index']);
    Route::post("/ordenes",[OrdenController::class,'store']);
    Route::get("/ordenes/{orden}",[OrdenController::class,'show']);
    Route::put("/ordenes/{orden}",[OrdenController::class,'update']);
    Route::delete("/ordenes/{orden}",[OrdenController::class,'destroy']);

    //DETALLES DE ORDEN
    Route::get("/detalles",[DetalleDeOrdenController::class,'index']);
    Route::post("/detalles",[DetalleDeOrdenController::class,'store']);
    Route::get("/detalles/{detalle}",[DetalleDeOrdenController::class,'show']);
    Route::put("/detalles/{detalle}",[DetalleDeOrdenController::class,'update']);
    Route::delete("/detalles/{detalle}",[DetalleDeOrdenController::class,'destroy']);
<<<<<<< Updated upstream

    //VERIFICAR URL FIRMADA
    Route::get('/verify-email/{id}/{hash}', [AuthController::class, 'verify'])->name('verification.verify');

     //TEST
     Route::get('/test',[ClienteController::class,'index'])->middleware('auth:sanctum','verify.role.email:1');

=======
>>>>>>> Stashed changes
});
