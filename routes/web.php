<?php
declare(strict_types=1);

use App\Http\Controllers\Frontend\QrCodeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return to_route('filament.admin.auth.register');
})->name('frontend.home');

Route::get('/qr-code', QrCodeController::class)->name('frontend.qr-code');

Route::fallback(function () {
   return redirect('/app');
});

