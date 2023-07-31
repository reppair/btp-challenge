<?php

use App\Http\Controllers\GetUsersController;
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

Route::get('/', function (Request $request) {
    $query = \App\Models\User::with('weather');

    if ($request->missing('ids')) {
        return response()->json(['users' => $query->get()]);
    }

    $validated = $request->validate([
        'ids' => 'nullable|array',
        'ids.*' => 'int',
    ]);

    $query->whereIn('id', $validated['ids']);

    return response()->json(['users' => $query->get()]);
});

Route::get('users', GetUsersController::class)->name('users.index');
