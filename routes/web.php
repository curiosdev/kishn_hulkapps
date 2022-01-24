<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserRegistration;
use App\Http\Controllers\AppointmentController;

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



Route::get('/', [UserRegistration::class,"index"])->name('welcome');

Route::get('/signup', [UserRegistration::class,"signup"])->name('signup');

Route::view('check_appointment','check_appointment')->name('check_appointment');




Route::middleware(['auth'])->group(function () {
    Route::view('dashboard','dashboard')->middleware('auth')->name('dashboard');
    Route::get('logout', [UserRegistration::class,"logout"])->name('logout');
    Route::post('/create_appointment', [AppointmentController::class,"add_update"])->name('create_appointment');
    Route::get('/all_user_data', [UserRegistration::class,"all_user_data"])->name('all_user_data');
    Route::get('/get_all_user_data', [UserRegistration::class,"get_all_user_data"])->name('get_all_user_data');
    Route::post('/delete_user_record/{id}', [UserRegistration::class,"deleteUserRecord"])->name('delete_user_record');
    Route::get('/get_appointment_data', [AppointmentController::class,"getAppointmentData"])->name('get_appointment_data');
    Route::get('/get_record/{id}', [AppointmentController::class,"getRecord"])->name('get_record');
    Route::post('/delete_record/{id}', [AppointmentController::class,"deleteRecord"])->name('delete_record');
    Route::post('/change_status/{id}/{type}', [AppointmentController::class,"changeStatus"])->name('change_status');
    Route::get('appointment', [AppointmentController::class,"index"])->name('appointment');
});

Route::post('/create_registration', [UserRegistration::class,"add_update"])->name('create_registration');

Route::post('/without_login_appointment', [UserRegistration::class,"without_login_appointment"])->name('without_login_appointment');

Route::post('/login', [UserRegistration::class,"login"])->name('login');

