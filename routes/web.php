<?php

use App\Livewire\Order\EditOrder;
use App\Livewire\Order\OrderList;
use App\Livewire\Order\CreateOrder;
use App\Livewire\Salary\SalaryList;
use Illuminate\Support\Facades\Route;
use App\Livewire\Customer\CustomerList;
use App\Livewire\Expenses\ExpensesList;
use App\Livewire\Order\OrderByCustomer;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OverviewController;
use App\Http\Controllers\ItemServiceController;
use App\Http\Controllers\CustomerProfileController;

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

Route::middleware(['auth:web', 'check-status'])->group(function () {
    Route::redirect('/', 'overview');

    Route::get('overview', OverviewController::class)->name('overview');

    Route::get('customers', CustomerList::class)->name('customers.index');
    Route::get('customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::get('customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');

    Route::get('orders', OrderList::class)->name('orders.index');
    Route::get('orders/ordered-by-customer', OrderByCustomer::class)->name('orders.customer.index');
    Route::get('orders/create', CreateOrder::class)->name('orders.create');
    Route::get('orders/{order}/edit', EditOrder::class)->name('orders.edit');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

    ###################################### Start Admins & SuperAdmin Routes #####################################
    Route::middleware('is-admin')->group(function () {
        Route::get('item-prices/{item}', [ItemServiceController::class, 'show'])->name('itemPrices.show');
        Route::resource('itemServices', ItemServiceController::class)->except('show');
        Route::resource('services', ServiceController::class)->except('show');
        Route::resource('items', ItemController::class)->except('show');

        Route::post('customers/reset-default-password/{customer}', [CustomerController::class, 'resetPassword'])->name('customers.password-reset');

        Route::post('users/toggle-suspension/{user}', [UserController::class, 'toggleSuspension'])->name('users.toggle-suspension');
        Route::post('users/reset-default-password/{user}', [UserController::class, 'resetPassword'])->name('users.password-reset');
        Route::resource('users', UserController::class);
    });

    Route::middleware('is-superAdmin')->group(function () {
        Route::get('expenses', ExpensesList::class)->name('expenses.index');
        Route::resource('expenses', ExpenseController::class)->except('index');
        Route::get('salaries', SalaryList::class)->name('salaries.index');
        Route::resource('salaries', SalaryController::class)->except('index');
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::get('settings/{setting:key}/edit', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings/{setting:key}', [SettingController::class, 'update'])->name('settings.update');
    });
    ##################################### End Admins & SuperAdmin Routes ########################################

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware('auth:customer')->as('customer.')->prefix('customer')->group(function () {
    Route::get('profile', [CustomerProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [CustomerProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile/update', [CustomerProfileController::class, 'updateProfileInfo'])->name('profile.info.update');
    Route::put('profile/password', [CustomerProfileController::class, 'updateProfilePassword'])->name('profile.password.update');
});

require __DIR__ . '/auth.php';
