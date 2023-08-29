<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;
use App\Models\Reservation;

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
/**
 * definition des routes pour la table des utilisateurs
 */
Route::post("/utilisateur/inscription", [UserController::class, "inscription"]);
Route::post("/utilisateur/connexion", [UserController::class, "connexion"]);


/**
 * Definition des differents route protege
 */
Route::group(['middleware' => ['auth:sanctum']], function(){

    /**
     * Definition des routes pour la table des utilisateurs
     */
    Route::get("/utilisateur/index", [UserController::class, "index"]);
    Route::put("/utilisateur/update/{id}", [UserController::class, "update"]);
    Route::get("/utilisateur/detail/{id}", [UserController::class, "show"]);
    Route::delete("/utilisateur/delete/{id}", [UserController::class, "destroy"]);
    Route::post("/utilisateur/deconnexion", [UserController::class, "logout"]);


    /**
     * Definition des routes de sauvegarde des reservations
     */

     Route::post("/reservation/store", [ReservationController::class, "store"]);
     Route::get("/reservation/index", [ReservationController::class, "index"]);
     Route::put("/reservation/update/{id}", [ReservationController::class, "update"]);
     Route::get("/reservation/detail/{id}", [ReservationController::class, "show"]);
     Route::delete("/reservation/delete/{id}", [ReservationController::class, "delete"]);
});

