<?php

use Illuminate\Support\Facades\Route;  
use App\Http\Controllers\UserController;
use App\Http\Controllers\MainController;

// Register New User
Route::get('/register',[UserController::class,'registerpage']);
Route::post('/register',[UserController::class,'saveUser'])->name('auth.register');

// Forgotten Password
Route::get('/forget',[UserController::class,'forgetpage']);
Route::post('/forget',[UserController::class,'forgetPassword'])->name('forget.password');

// Reset Password
Route::get('reset/{email}/{token}',[UserController::class,'resetpage'])->name('reset');
Route::post('/reset-password',[UserController::class,'resetPassword'])->name('reset.password');

// Check User
Route::post('/login',[UserController::class,'checkUser'])->name('auth.login');

// Delete User
Route::post('/users-delete/{id}',[MainController::class,'userDelete'])->name('delete.user');
// Route::match(['get', 'post'], '/users-delete/{id}', [MainController::class, 'userDelete']);

// Account
Route::post('/insert/account',[MainController::class,'accountInsert']);
Route::post('/accountDetailsUpdate/{id}',[MainController::class,'accountDetailsUpdate']);
Route::post('/deactive/{id}',[MainController::class,'accountDeactive']);
Route::post('/active/{id}',[MainController::class,'accountActive']);

// AccountType
Route::post('/insert/accountType',[MainController::class,'accountTypeInsert']);

// City Store
Route::post('/city/insert',[MainController::class,'cityInsert']);
Route::post('/city-delete/{id}',[MainController::class,'cityDelete']);

// Category
Route::post('/category/insert',[MainController::class,'categoryInsert']);
Route::post('/category-deleted/{id}',[MainController::class,'categoryDeleted']);
Route::match(['get', 'post'], '/categoryRestore/{id}', [MainController::class, 'categoryRestore']);

// Product
Route::post('/product/insert',[MainController::class,'productInsert']);
Route::get('/product/getEdit',[MainController::class,'productEdit']);

// Expense Store
Route::post('/expense',[MainController::class,'expenseStore'])->name('store.expense');
Route::match(['get', 'post'], '/expencedeleted/{id}', [MainController::class, 'deleteExpenses']);
Route::match(['get', 'post'], '/expenceRestore/{id}', [MainController::class, 'restoreExpenses']);

// Middleware Checking URLs
Route::group(['middleware' => ['LoginCheck']], function()
    {    
        Route::get('/',[UserController::class,'loginpage']);
        Route::get('/logout',[UserController::class,'logoutUser'])->name('auth.logout');
        // Profile
        Route::get('/profile',[UserController::class,'profilepage'])->name('profile');
        Route::post('/profile-image',[UserController::class,'profileImageUpdate'])->name('profile.image');
        Route::post('/profile-update',[UserController::class,'profileUpdate'])->name('profile.update');
        // Dashboard
        Route::get('/dashboard',[MainController::class,'dashboardpage'])->name('dashboard');
        // Accounts
        Route::get('/account',[MainController::class,'accountPage']);
        // Account Details
        Route::get('/account-details/{id}',[MainController::class,'accountDetailsPage']);
        // Account Type
        Route::get('/account-type',[MainController::class,'accountTypePage']);
        // City
        Route::get('/city',[MainController::class,'cityPage']);
        // Category
        Route::get('/category',[MainController::class,'categoryPage']);
        // Product
        Route::get('/products',[MainController::class,'Productpage']);
        // Expense
        Route::get('/expense',[MainController::class,'expensePage'])->name('expense');
        // Users
        Route::get('/users',[MainController::class,'usersPage']);
        Route::get('/user-details/{id}',[MainController::class,'userDetailsPage']);
        //  Customization
        Route::get('/customize',[MainController::class,'customizePage']);
        // Trash
        Route::get('/trash',[MainController::class,'trashPage']);
    });

// Customize
Route::post('customize/Insert',[MainController::class,'customizeInsert']);
Route::match(['get', 'post'], 'customize/Edit/{id}', [MainController::class, 'customizeEdit']);
Route::post('/update/customize', [MainController::class, 'customizeUpdate'])->name('customize.update');


// Trash Permenantly Deleted
Route::match(['get', 'post'], '/expencePermenantDeleteExpense/{id}', [MainController::class, 'permenantTrashDeleteExpense']);
Route::match(['get', 'post'], '/categoryPermenantDeleteCategory/{id}', [MainController::class, 'permenantTrashDeleteCategory']);
