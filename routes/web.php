<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DNSController;
use App\Http\Controllers\DomainsController;
use App\Http\Controllers\IPsController;
use App\Http\Controllers\LabelsController;
use App\Http\Controllers\LocationsController;
use App\Http\Controllers\MiscController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\OsController;
use App\Http\Controllers\ProvidersController;
use App\Http\Controllers\ResellerController;
use App\Http\Controllers\SeedBoxesController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SharedController;
use App\Http\Controllers\YabsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('/');

require __DIR__ . '/auth.php';

Route::resource('account', AccountController::class)->middleware(['auth']);

Route::resource('dns', DNSController::class)->middleware(['auth']);

Route::resource('domains', DomainsController::class)->middleware(['auth']);

Route::resource('IPs', IPsController::class)->middleware(['auth']);

Route::resource('labels', LabelsController::class)->middleware(['auth']);

Route::resource('locations', LocationsController::class)->middleware(['auth']);

Route::resource('misc', MiscController::class)->middleware(['auth']);

Route::resource('os', OsController::class)->middleware(['auth']);

Route::resource('providers', ProvidersController::class)->middleware(['auth']);

Route::resource('reseller', ResellerController::class)->middleware(['auth']);

Route::get('servers/public', 'App\Http\Controllers\ServerController@showServersPublic')->name('servers/public');

Route::resource('servers', ServerController::class)->middleware(['auth']);

Route::resource('settings', SettingsController::class)->middleware(['auth']);

Route::resource('seedboxes', SeedBoxesController::class)->middleware(['auth']);

Route::resource('shared', SharedController::class)->middleware(['auth']);

Route::resource('yabs', YabsController::class)->middleware(['auth']);

Route::resource('notes', NoteController::class)->middleware(['auth']);

Route::get('yabs/{yab}/json', 'App\Http\Controllers\YabsController@yabsToJson')->middleware(['auth'])->name('yabs.json');

Route::get('yabs-compare-choose', 'App\Http\Controllers\YabsController@chooseYabsCompare')->middleware(['auth'])->name('yabs.compare-choose');

Route::get('yabs-compare/{yabs1}/{yabs2}', 'App\Http\Controllers\YabsController@compareYabs')->middleware(['auth'])->name('yabs.compare');

Route::get('servers-compare-choose', 'App\Http\Controllers\ServerController@chooseCompare')->middleware(['auth'])->name('servers-compare-choose');

Route::get('servers-compare/{server1}/{server2}', 'App\Http\Controllers\ServerController@compareServers')->middleware(['auth'])->name('servers.compare');
