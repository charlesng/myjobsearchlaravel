<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


/*
 * CRUD for job result
 * 
 */
Route::get('job/{id}', 'Jobs\JobController@show');

Route::middleware('auth:api', 'throttle:10|60,1')->group(
    function () {
        Route::post('job', function (Request $request) {
            return "Not implemented yets";
        });

        Route::put('job', function (Request $request) {
            return "Not implemented yet";
        });

        Route::delete('job', function (Request $request) {
            return "Not implemented yet";
        });
    }
);
