<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ResumoController;
use App\Http\Controllers\Api\DespesasController;
use App\Http\Controllers\Api\ReceitasController;

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

Route::middleware('auth:sanctum')->group(function () {

Route::apiResource('/despesas', DespesasController::class);
Route::apiResource('/receitas', ReceitasController::class);

Route::get('/despesas/{ano}/{mes}', [DespesasController::class, 'listByMonth']);
Route::get('/receitas/{ano}/{mes}', [ReceitasController::class, 'listByMonth']);

Route::get('/resumo/{ano}/{mes}', [ResumoController::class, 'resumoDoMes']);

});

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', function (Request $request) {

    $credentials = $request->only(['email', 'password']);
    if(Auth::attempt($credentials) === false) { return response()->json('Unauthorized', 401); }

    /** @var \App\Models\User|null $user */
    $user = Auth::user();
    $user->tokens()->delete();
    $token = $user->createToken('token');

    return response()->json($token->plainTextToken);
});