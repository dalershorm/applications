<?php

use App\Http\Requests\ApplicationRequest;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/applications', function (ApplicationRequest $request) {
    $file = '';
    if ($request->hasFile('file')) {
        $file = $request->file('file')->store('applications', ['disk' => 'public']);
    }

    $app = Application::create($request->all() + ['upload_path' => $file]);

    return $app;
});
