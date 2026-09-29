<?php



use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/signup', [AuthController::class, 'signup']);
//Route::get('/users', [AuthController::class, 'get_users']);
Route::post('/login', [AuthController::class, 'login']);

//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
