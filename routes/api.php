<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

use Illuminate\Http\Request;
 
Route::post('/test-api', function (Request $request) {

    // Get headers
    $header1 = $request->header('x-client-id');
    $header2 = $request->header('x-api-key');

    // Get body params
    $body1 = $request->input('name');
    $body2 = $request->input('email');

    return response()->json([
        'header1' => $header1,
        'header2' => $header2,
        'body1' => $body1,
        'body2' => $body2,
        'message' => 'Data received successfully',
    ]);
});
Route::get('/ping', function () {
    return response()->json(['message' => 'API is working']);
});
Route::post('/receive-data', [ApiController::class, 'receiveData']);