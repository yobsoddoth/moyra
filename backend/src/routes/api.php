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

Route::get('/read', function () {
    return response()->json([
        [
            "id" => "00000000-0001-0000-0000-000000000000",
            "language" => [
                "id" => 1,
                "code" => "en",
            ],
            "title" => "Scroll of Trials",
            "annotation" => "Test book to FAFO",
        ],
        [
            "id" => "00000000-0002-0000-0000-000000000000",
            "language" => [
                "id" => 1,
                "code" => "en",
            ],
            "title" => "Scroll of Extras",
            "annotation" => "Test book to take up space in lists",
        ],
    ]);
});

Route::get('/write/schema/{id}', function (string $id) {
    return response()->json(
        (new \App\Repos\Sql\BookSchemaRepo())->asGraphviz($id)
    );
});
