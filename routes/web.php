<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DNSController;
use App\Http\Controllers\DomainsController;
use App\Http\Controllers\HomeController;
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


Route::get('/', [HomeController::class, 'index'])->name('/');

require __DIR__ . '/auth.php';

Route::get('servers/public', [ServerController::class, 'showServersPublic'])->name('servers/public');

Route::middleware(['auth'])->group(function () {
    Route::resource('account', AccountController::class);

    Route::resource('dns', DNSController::class);

    Route::resource('domains', DomainsController::class);

    Route::resource('IPs', IPsController::class);

    Route::resource('labels', LabelsController::class);

    Route::resource('locations', LocationsController::class);

    Route::resource('misc', MiscController::class);

    Route::resource('os', OsController::class);

    Route::resource('providers', ProvidersController::class);

    Route::resource('reseller', ResellerController::class);

    Route::resource('servers', ServerController::class);

    Route::resource('settings', SettingsController::class);

    Route::resource('seedboxes', SeedBoxesController::class);

    Route::resource('shared', SharedController::class);

    Route::resource('yabs', YabsController::class);

    Route::resource('notes', NoteController::class);

    Route::get('yabs/{yab}/json', [YabsController::class, 'yabsToJson'])->name('yabs.json');
    Route::get('yabs-compare-choose', [YabsController::class, 'chooseYabsCompare'])->name('yabs.compare-choose');
    Route::get('yabs-compare/{yabs1}/{yabs2}', [YabsController::class, 'compareYabs'])->name('yabs.compare');

    Route::get('servers-compare-choose', [ServerController::class, 'chooseCompare'])->name('servers-compare-choose');
    Route::get('servers-compare/{server1}/{server2}', [ServerController::class, 'compareServers'])->name('servers.compare');
});
