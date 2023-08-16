<?php

use App\Http\Controllers\Account\ProfileController;
use App\Http\Controllers\Ajax\RemoveImageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Ajax\Payments\PaypalController;
use App\Http\Controllers\Callbacks\TelegramController;
use App\Http\Controllers\Orders\ThankYouPageController;
use App\Http\Controllers\ProductsController;
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

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/', HomeController::class)->name('home');

Route::get('invoice',function() {
    $order = \App\Models\Order::all()->last();
    // $invoiceService = app()->make(\App\Services\Contracts\InvoicesServiceContract::class);

    // dd($invoiceService->generate($order)->url());
    \App\Events\OrderCreated::dispatch($order);
});

Route::name('callbacks.')->prefix('callback')
->middleware(['role:admin|moderator|customer'])->group(function() {
    Route::get('telegram', TelegramController::class)->name('telegram');
});

Route::resource('categories', CategoriesController::class)->only(['index', 'show']);
Route::resource('products', ProductsController::class)->only(['index', 'show']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('checkout', CheckoutController::class)->name('checkout');
    Route::get('orders/{order}/paypal/thank-you', [ThankYouPageController::class, 'paypal'])->name('payment.thankyou');
});

require __DIR__.'/auth.php';

//domain.com/admin/...
Route::name('admin.')->prefix('admin')->middleware(['role:admin|moderator'])->group(function() {
    Route::get('dashboard', \App\Http\Controllers\Admin\DashboardController::class)->name('dashboard');
    Route::resource('products', \App\Http\Controllers\Admin\ProductsController::class)->except(['show']);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoriesController::class)->except(['show']);
 });

 Route::name('ajax.')->middleware('auth')->prefix('ajax')->group(function() {
    Route::group(['role:admin|moderator'], function() {
        Route::delete('images/{image}', RemoveImageController::class)->name('images.delete');
    });
    Route::prefix('paypal')->name('paypal.')->group(function() {
        Route::post('order/create', [PaypalController::class, 'create'])->name('orders.create');
        Route::post('order/{orderId}/capture', [PaypalController::class, 'capture'])->name('orders.capture');
    });
 });

 Route::name('cart.')->prefix('cart')->group(function() {
    // /cart
    Route::get('/', [CartController::class, 'index'])->name('index');
    // /cart/product_id
    Route::post('{product}', [CartController::class, 'add'])->name('add');
    Route::delete('/', [CartController::class, 'remove'])->name('remove');
    // /cart/product_id/count
    Route::post('{product}/count', [CartController::class, 'countUpdate'])->name('count.update');
 });
