<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RulesController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\ChecksheetController;
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

// Authentication Routes
// Route::get('/', [AuthController::class, 'login'])->name('login');
// Route::get('/auth/login', [AuthController::class, 'postLogin']);
// Route::get('/auth/callback', [AuthController::class, 'handleAzureCallback']);
// Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/auth/login', [AuthController::class, 'postLogin']);
Route::get('/logout', [AuthController::class, 'logout']);


Route::middleware(['auth'])->group(function () {
    //Home Controller
    Route::get('/home', [HomeController::class, 'index'])->name('checksheet');

    //Dropdown Controller
    Route::get('/dropdown', [DropdownController::class, 'index'])->middleware(['checkRole:IT']);
    Route::post('/dropdown/store', [DropdownController::class, 'store'])->middleware(['checkRole:IT']);
    Route::patch('/dropdown/update/{id}', [DropdownController::class, 'update'])->middleware(['checkRole:IT']);
    Route::delete('/dropdown/delete/{id}', [DropdownController::class, 'delete'])->middleware(['checkRole:IT']);

    //Rules Controller
    Route::get('/rule', [RulesController::class, 'index'])->middleware(['checkRole:IT']);
    Route::post('/rule/store', [RulesController::class, 'store'])->middleware(['checkRole:IT']);
    Route::patch('/rule/update/{id}', [RulesController::class, 'update'])->middleware(['checkRole:IT']);
    Route::delete('/rule/delete/{id}', [RulesController::class, 'delete'])->middleware(['checkRole:IT']);

    //User Controller
    Route::get('/user', [UserController::class, 'index'])->middleware(['checkRole:IT']);
    Route::post('/user/store', [UserController::class, 'store'])->middleware(['checkRole:IT']);
    Route::post('/user/store-partner', [UserController::class, 'storePartner'])->middleware(['checkRole:IT']);
    Route::patch('/user/update/{user}', [UserController::class, 'update'])->middleware(['checkRole:IT']);
    Route::get('/user/revoke/{user}', [UserController::class, 'revoke'])->middleware(['checkRole:IT']);
    Route::get('/user/access/{user}', [UserController::class, 'access'])->middleware(['checkRole:IT']);

    //Master Mechine
    Route::get('/master/mechine', [MachineController::class, 'index'])->middleware(['checkRole:IT,Super Admin']);
    Route::post('/master/mechine/store', [MachineController::class, 'store'])->middleware(['checkRole:IT,Super Admin']);
    Route::get('/master/mechine/detail/{id}', [MachineController::class, 'detail'])->name('machine.detail')->middleware(['checkRole:IT,Super Admin']);
    Route::post('/master/checksheet/type/store', [MachineController::class, 'storeChecksheet'])->middleware(['checkRole:IT,Super Admin']);
    Route::post('/master/checksheet/item/store', [MachineController::class, 'storeItemChecksheet'])->middleware(['checkRole:IT,Super Admin']);
    Route::delete('/master/delete/checksheet/{id}', [MachineController::class, 'deleteChecksheet'])->middleware(['checkRole:IT,Super Admin']);
    Route::delete('/master/delete/checksheet/item/{id}', [MachineController::class, 'deleteChecksheetItem'])->middleware(['checkRole:IT,Super Admin']);
    Route::patch('/master/checksheet/update/{id}', [MachineController::class, 'updateChecksheet'])->middleware(['checkRole:IT,Super Admin']);
    Route::patch('/master/checksheet/item/update/{id}', [MachineController::class, 'updateChecksheetItem'])->middleware(['checkRole:IT,Super Admin']);

    //Master Checksheet form/checksheet/scan
    Route::get('/checksheet', [ChecksheetController::class, 'index'])->middleware(['checkRole:IT,Super Admin,Approval,Checker,User'])->name('machine');
    Route::post('/checksheet/scan', [ChecksheetController::class, 'checksheetScan'])->middleware(['checkRole:IT,Super Admin,User']);
    Route::post('/checksheet/store', [ChecksheetController::class, 'storeHeadForm'])->middleware(['checkRole:IT,Super Admin,User']);
    Route::get('/checksheet/fill/{id}', [ChecksheetController::class, 'checksheetfill'])->middleware(['checkRole:IT,Super Admin,User'])->name('fill');
    Route::post('/checksheet/store/detail', [ChecksheetController::class, 'storeDetailForm'])->middleware(['checkRole:IT,Super Admin,User']);
    Route::get('/checksheet/detail/{id}', [ChecksheetController::class, 'checksheetDetail'])->middleware(['checkRole:IT,Approval,Checker,Super Admin,User']);
    Route::post('/checksheet/signature', [ChecksheetController::class, 'checksheetSignature'])->middleware(['checkRole:IT,Super Admin,User']);

    Route::get('/checksheet/approve/{id}', [ChecksheetController::class, 'checksheetApprove'])->middleware(['checkRole:IT,Super Admin,Approval']);
    Route::post('/checksheet/approve/store', [ChecksheetController::class, 'checksheetApproveStore'])->middleware(['checkRole:IT,Super Admin,Approval']);
    Route::get('checksheet/update/{id}', [ChecksheetController::class, 'checksheetUpdate'])->middleware(['checkRole:IT,Super Admin,User']);
    Route::post('/checksheet/update/detail', [ChecksheetController::class, 'checksheetUpdateDetail'])->middleware(['checkRole:IT,Super Admin,User']);

    Route::get('/checksheet/checkher/{id}', [ChecksheetController::class, 'checksheetChecker'])->middleware(['checkRole:IT,Super Admin,Checker']);
    Route::post('/checksheet/checker/store', [ChecksheetController::class, 'checksheetCheckerStore'])->middleware(['checkRole:IT,Super Admin,Checker']);

    Route::get('checksheet/generate-pdf/{id}', [ChecksheetController::class, 'generatePdf'])->middleware(['checkRole:IT,Super Admin,Approval,Checker,User']);

});
