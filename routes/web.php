<?php

use App\Http\Controllers\ChatLogsController;
use App\Http\Controllers\CommandLogController;
use App\Http\Controllers\Modules\AnnouncementsController;
use App\Http\Controllers\Modules\CommandBlockerController;
use App\Http\Controllers\Modules\FilterController;
use App\Http\Controllers\Modules\HelpOPController;
use App\Http\Controllers\Modules\PermissionsController;
use App\Http\Controllers\Modules\Punishments\PunishmentsController;
use App\Http\Controllers\Modules\Punishments\PunishmentTemplatesController;
use App\Http\Controllers\Modules\ServersController;
use App\Http\Controllers\Modules\TagsController;
use App\Http\Controllers\Modules\TicketsController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguagesController;
use App\Http\Controllers\MOTDController;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServerStatsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Webpanel\AccountsController;
use App\Http\Controllers\Webpanel\AuthenticationController;
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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::controller(AuthenticationController::class)->group(function () {
    Route::get('/login', 'loginView')->name('auth.login');
    /*Route::get('/logincreatetest', 'logincreatetestView')->name('auth.logincreatetest');
    Route::post('/logincreatetest', 'logincreatetest')->name('logincreatetest');*/
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout');
});

Route::resource('servers', ServersController::class);
Route::resource('announcements', AnnouncementsController::class);
Route::resource('punishments', PunishmentsController::class);
Route::resource('punishment_templates', PunishmentTemplatesController::class);
Route::resource('analytics', AnalyticsController::class);
Route::resource('players', PlayersController::class);
Route::resource('settings', SettingsController::class);
Route::resource('languages', LanguagesController::class);
Route::resource('profile', ProfileController::class);
Route::resource('motd', MOTDController::class);
Route::resource('filter', FilterController::class);
Route::resource('commandblocker', CommandBlockerController::class);
Route::resource('helpop', HelpOPController::class);
Route::resource('accounts', AccountsController::class);
Route::resource('chat', ChatController::class);
Route::resource('tags', TagsController::class);
Route::resource('chatlogs', ChatLogsController::class);
Route::resource('commandlog', CommandLogController::class);
Route::resource('serverstats', ServerStatsController::class);

//Route::resource('permissions', PermissionsController::class);
Route::prefix('permissions')->controller(PermissionsController::class)->group(function () {
    Route::get('/', 'index')->name('permissions');
    Route::prefix('group/{group}')->group(function () {
        Route::get('permissions', 'groupPermissions')->name('permissions.group.permissions');
        Route::get('prefixes', 'groupPrefixes')->name('permissions.group.prefixes');
        Route::get('suffixes', 'groupSuffixes')->name('permissions.group.suffixes');
        Route::get('parents', 'groupParents')->name('permissions.group.parents');
        Route::get('members', 'groupMembers')->name('permissions.group.members');
    });
    Route::prefix('player/{player}')->group(function () {
        Route::get('permissions', 'playerPermissions')->name('permissions.player.permissions');
        Route::get('groups', 'playerGroups')->name('permissions.player.groups');
    });
});
Route::prefix('tickets')->controller(TicketsController::class)->group(function () {
    Route::get('/', 'index')->name('tickets');
    Route::get('/{ticket}', 'ticket')->name('tickets.ticket');
});
