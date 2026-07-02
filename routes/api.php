<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('ciudad/listar/{id_region}', function($id_region)
{
    $ciudades = App\Models\Ciudad::where('id_region', '=', $id_region)->orderBy('nombre')->get();
    return response()->json($ciudades);
});

Route::get('comuna/listar/{id_ciudad}', function($id_ciudad)
{
    $comunas = App\Models\Comuna::where('id_ciudad', '=', $id_ciudad)->orderBy('nombre')->get();
    return response()->json($comunas);
});

Route::get('medida/listar/{id_producto}', function($id_producto)
{
    $medidas = App\Models\Medida::where('activo',1)->where('id_producto', '=', $id_producto)->orderBy('nombre')->get();
    return response()->json($medidas);
});