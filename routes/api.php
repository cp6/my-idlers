<?php

use Illuminate\Http\JsonResponse;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('dns/', 'App\Http\Controllers\ApiController@getAllDns');
Route::middleware('auth:api')->get('dns/{id}', 'App\Http\Controllers\ApiController@getDns');

Route::middleware('auth:api')->get('domains/', 'App\Http\Controllers\ApiController@getAllDomains');
Route::middleware('auth:api')->get('domains/{id}', 'App\Http\Controllers\ApiController@getDomains');

Route::middleware('auth:api')->get('servers', 'App\Http\Controllers\ApiController@getAllServers');
Route::middleware('auth:api')->get('servers/{id}', 'App\Http\Controllers\ApiController@getServer');

Route::middleware('auth:api')->get('IPs/', 'App\Http\Controllers\ApiController@getAllIPs');
Route::middleware('auth:api')->get('IPs/{id}', 'App\Http\Controllers\ApiController@getIP');

Route::middleware('auth:api')->get('labels/', 'App\Http\Controllers\ApiController@getAllLabels');
Route::middleware('auth:api')->get('labels/{id}', 'App\Http\Controllers\ApiController@getLabel');

Route::middleware('auth:api')->get('locations/', 'App\Http\Controllers\ApiController@getAllLocations');
Route::middleware('auth:api')->get('locations/{id}', 'App\Http\Controllers\ApiController@getLocation');

Route::middleware('auth:api')->get('misc/', 'App\Http\Controllers\ApiController@getAllMisc');
Route::middleware('auth:api')->get('misc/{id}', 'App\Http\Controllers\ApiController@getMisc');

Route::middleware('auth:api')->get('networkSpeeds/', 'App\Http\Controllers\ApiController@getAllNetworkSpeeds');
Route::middleware('auth:api')->get('networkSpeeds/{id}', 'App\Http\Controllers\ApiController@getNetworkSpeeds');

Route::middleware('auth:api')->get('os/', 'App\Http\Controllers\ApiController@getAllOs');
Route::middleware('auth:api')->get('os/{id}', 'App\Http\Controllers\ApiController@getOs');

Route::middleware('auth:api')->get('pricing/', 'App\Http\Controllers\ApiController@getAllPricing');
Route::middleware('auth:api')->get('pricing/{id}', 'App\Http\Controllers\ApiController@getPricing');

Route::middleware('auth:api')->get('providers/', 'App\Http\Controllers\ApiController@getAllProviders');
Route::middleware('auth:api')->get('providers/{id}', 'App\Http\Controllers\ApiController@getProvider');

Route::middleware('auth:api')->get('reseller/', 'App\Http\Controllers\ApiController@getAllReseller');
Route::middleware('auth:api')->get('reseller/{id}', 'App\Http\Controllers\ApiController@getReseller');

Route::middleware('auth:api')->get('settings/', 'App\Http\Controllers\ApiController@getAllSettings');

Route::middleware('auth:api')->get('shared/', 'App\Http\Controllers\ApiController@getAllShared');
Route::middleware('auth:api')->get('shared/{id}', 'App\Http\Controllers\ApiController@getShared');

//Route::get('providers', 'App\Http\Controllers\ApiController@getAllProvidersTable')->name('get-all-providers');

Route::middleware('auth:api')->get('online/{hostname}', 'App\Http\Controllers\ApiController@checkHostIsUp');

Route::middleware('auth:api')->get('dns/{domainName}/{type}', 'App\Http\Controllers\ApiController@getIpForDomain');
