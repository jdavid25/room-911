<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Room911Controller;

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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/users/create',[UserController::class, 'create'])->name('users.create');
Route::post('/users',[UserController::class, 'store']);

Route::get('/auth',[AuthController::class, 'index'])->name('auth.login');
Route::post('/auth',[AuthController::class, 'login']);
Route::get('/auth/logout',[AuthController::class, 'logout'])->name('auth.logout');

Route::get('/employees',[EmployeeController::class, 'index'])->name('employees.index');
Route::get('/employees/create',[EmployeeController::class, 'create'])->name('employees.create');
Route::post('/employees',[EmployeeController::class, 'store']);
Route::get('/employees/create/massive',[EmployeeController::class, 'create_massive'])->name('employees.create.massive');
Route::post('/employees/massive',[EmployeeController::class, 'store_massive'])->name('employees.store.massive');
Route::get('/employees/{employee}/edit',[EmployeeController::class, 'edit'])->name('employees.edit');
Route::put('/employees/{employee}',[EmployeeController::class, 'update'])->name('employees.update');
Route::delete('/employees/{employee}',[EmployeeController::class, 'destroy'])->name('employees.delete');
Route::get('/employees/change/{employee}',[EmployeeController::class, 'change'])->name('employees.change');
Route::get('/employees/pdf/{employee}', [EmployeeController::class, 'create_pdf'])->name('employees.pdf');
Route::get('/employees/pdf', [EmployeeController::class, 'create_pdf_all'])->name('employees.pdf.all');
Route::post('/employees/filter', [EmployeeController::class, 'filter'])->name('employees.filter');

Route::get('/room_911/access',[Room911Controller::class, 'access'])->name('room_911.access');
Route::post('/room_911',[Room911Controller::class, 'validate_access'])->name('room_911.validate_access');
