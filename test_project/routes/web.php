<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;

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

Route::get('/', [MailController::class, 'mailList']);
Route::get('/mail/new', [MailController::class, 'mailNew']);
Route::get('/mail/show/{id}', [MailController::class, 'mailShow']);
Route::post('/mail/resist', [MailController::class, 'mailResist']);
Route::post('/mail/edit/{id}', [MailController::class, 'mailEdit']);
Route::post('/mail/delete/{id}', [MailController::class, 'mailDelete']);
Route::post('/mail/send', [MailController::class, 'mailSend']);
