<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlacklistSourceController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SourceDestinationController;
use App\Http\Controllers\DlrController;
use App\Http\Controllers\GatewayConnectionController;
use App\services\GatewayConnectionService;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    /*
|--------------------------------------------------------------------------
|                       SOURCE  "Black List"  
|--------------------------------------------------------------------------
*/
    Route::get('/source', [BlacklistSourceController::class, 'listall']);
    Route::post('/createSource', [BlacklistSourceController::class, 'create']);
    Route::delete('/source/{sender_id}', [BlacklistSourceController::class, 'destroy']);

    /*
|--------------------------------------------------------------------------
|                            Messages
|--------------------------------------------------------------------------
*/
    Route::post('/message/filter', [MessageController::class, 'filter']);
    Route::post('/message/create', [MessageController::class, 'store']);
    Route::post('/message/createMessageObject', [MessageController::class, 'createMessage']);

    /*
|--------------------------------------------------------------------------
|                            Destinations
|--------------------------------------------------------------------------
*/
    Route::post('/createDestination', [SourceDestinationController::class, 'store']);
    /*
|--------------------------------------------------------------------------
|                            DLR
|--------------------------------------------------------------------------
*/
    Route::post('/vendor/setDlr', [DlrController::class, 'setMessageDlr']);

    /*
|--------------------------------------------------------------------------
|                            Gateway Connection
|--------------------------------------------------------------------------
*/
    Route::post('/gatewayConnection', [GatewayConnectionController::class, 'store']);
    // Route::get('/checkGatewayConnection/{username}/{password}', function(
    //     $username, $password   ){
    //     return GatewayConnectionService::checkGatewayConnection($username, $password);
    //     });
    Route::get('/getConnectionId/{username}/{password}', function(
        $username, $password   ){
        return GatewayConnectionService::getConnectionId($username, $password);
        });
        /*
|--------------------------------------------------------------------------
|                            Gateway Connection
|--------------------------------------------------------------------------
*/
Route::post('/client', [BlacklistSourceController::class, 'sendmessage']);
});
