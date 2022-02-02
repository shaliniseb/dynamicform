<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\GuestController;
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

Route::get('/', [GuestController::class, 'index']);

Auth::routes(['register' => false]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->group(function () {
    //After Login the routes are accept by the loginUsers...
    Route::view('addform', 'addform');
    Route::post('addform', [FormsController::class, 'create']);
    Route::get('allForms', [FormsController::class, 'lists'])->name('allForms');
    Route::get('edit/{formid}', [FormsController::class, 'editform']);
    Route::post('edit/{formid}', [FormsController::class, 'edit']);
    Route::post('deleteItem', [FormsController::class, 'deleteElement'])->name('deleteItem.post');
    Route::post('form/edit}', [FormsController::class, 'updateForm'])->name('form.edit');
});

Route::get('view/{formid}', [GuestController::class, 'view']);
