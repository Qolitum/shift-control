<?php

use App\Http\Controllers\Shifts\ShiftsController;
use App\Http\Controllers\Users\UserController;

// Сотрудники
Route::get("users", [UserController::class, "getList"]);
Route::post("users", [UserController::class, "create"]);
Route::get("users/{id}", [UserController::class, "getById"]);
Route::put("users/{id}", [UserController::class, "edit"]);
Route::delete("users/{id}", [UserController::class, "delete"]);
Route::get("users-with-shift-status", [UserController::class, "getUsersWithShifts"]);
// Смены
Route::get("shifts", [ShiftsController::class, "getList"]);
Route::post("shifts/open/{id}", [ShiftsController::class, "open"]);
Route::post("shifts/stop/{id}", [ShiftsController::class, "stop"]);
