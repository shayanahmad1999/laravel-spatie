<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});


Route::group(['middleware' => 'guest'], function(){
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::post('register/authenticate', [AuthController::class, 'registerAuthenticate'])->name('register.authenticate');

});

    //we define role here as well and in controller as well and in blade as well define it where you want

// Route::group(['middleware' => ['auth','role:Super Admin|admin']], function(){
Route::group(['middleware' => ['auth']], function(){
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    Route::get('permission/{permission?}', [PermissionController::class, 'index'])->name('permission.index')->middleware('role:Super Admin');
    Route::post('permission/store', [PermissionController::class, 'store'])->name('permission.store');
    Route::post('permission/update/{permission}', [PermissionController::class, 'update'])->name('permission.update');
    Route::delete('permission/delete/{permission}', [PermissionController::class, 'destroy'])->name('permission.destroy');

    Route::get('role/{role?}', [RoleController::class, 'index'])->name('role.index')->middleware('role:Super Admin');
    Route::post('role/store', [RoleController::class, 'store'])->name('role.store');
    Route::post('role/update/{role}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('role/delete/{role}', [RoleController::class, 'destroy'])
    // ->middleware('permission:delete role')
    ->name('role.destroy');


    Route::post('role/assign/permission/{role}', [RoleController::class, 'assignPermissionToRole'])->name('role.assign.permission');
    Route::post('user/assign/role/{user}', [RoleController::class, 'assignRoleToUser'])->name('user.assign.role');
});
