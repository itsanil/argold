<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AdminRegisterController;
use App\Http\Controllers\Auth\AdminResetPasswordController;
use App\Http\Controllers\Auth\AdminForgotPasswordController;
use App\Http\Controllers\backend\HomeController;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/*
|----------------------------------------------------------------
|	Admin Login Routes
|----------------------------------------------------------------
 */
Route::get('/', [AdminLoginController::class, 'showLoginForm'])->name('login');
Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [AdminLoginController::class, 'login'])->name('submit.login');
// Route::get('register', [AdminRegisterController::class, 'showRegisterForm'])->name('register');
// Route::post('register', [AdminRegisterController::class, 'register'])->name('submit.register');
// Route::view('/forgot', 'admin-auth.passwords.email')->name('forgot');
// Route::get('/reset/{token}', [AdminResetPasswordController::class, 'showResetForm'])->name('reset');
// Route::post('/forgot', [AdminForgotPasswordController::class,'sendResetLinkEmail'])->name('forgot.submit');
// Route::post('/reset', [AdminResetPasswordController::class,'reset'])->name('password.reset');
/*
|----------------------------------------------------------------
|	Admin Routes
|----------------------------------------------------------------
 */
Route::get('/', function (){
if(Auth::guard('admin')->check()) {
      return AdminLoginController::redirectBasedOnUser();
    } else {
      return view('admin-auth.login');
   }
});

Route::get('/giveAccessTosuperAdmin', function (){
    $permissions = Permission::where('status',1)->get();
    $role = Role::find(1);
    $role->syncPermissions($permissions);
    dd('Accomplished');
});

Route::get('/config-cache', function() {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    dd('Cleared config cache route.');
});

Route::group(['middleware' => ['auth:admin']], function () {
    /*ARTISAN CALL*/
    Route::get('migrate',function(){
       Artisan::call('migrate');
    });

    Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');
    // Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::get('/profile/edit/{id}', [HomeController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/update/{id}', [HomeController::class, 'updateProfile'])->name('profile.update');

    /*BRANCH*/
    Route::group(['as'=>'dashboard.','prefix'=>'dashboard', 'namespace'=>'backend'], function(){
        Route::get('/view', 'BranchController@view')->name('view')->middleware(['can:branch-view']);
        Route::get('/branchView', 'ClientController@branchView')->name('branchView')->middleware(['can:branch-dashboard']);
        Route::get('/userView', 'ClientController@userView')->name('userView')->middleware(['can:user-dashboard']);
    });

    /*BRANCH*/
    Route::group(['as'=>'branch.','prefix'=>'branch', 'namespace'=>'backend'], function(){
        // Route::get('/view', 'BranchController@view')->name('view');
        Route::get('/add', 'BranchController@add')->name('add')->middleware(['can:branch-add']);
        Route::post('/store', 'BranchController@store')->name('store')->middleware(['can:branch-add']);
        Route::get('/edit/{id}', 'BranchController@edit')->name('edit')->middleware(['can:branch-update']);
        Route::post('/update/{id}', 'BranchController@update')->name('update')->middleware(['can:branch-update']);
        Route::get('/delete/{id}', 'BranchController@delete')->name('delete')->middleware(['can:branch-delete']);
        Route::post('/addNewBank', 'BranchController@addNewBank')->name('addNewBank');
    });

    /*BANK*/
    Route::group(['as'=>'bank.','prefix'=>'bank', 'namespace'=>'backend'], function(){
        Route::get('/show/{id}', 'BankController@show')->name('show')->middleware(['can:bank-view']);
        Route::get('/view', 'BankController@view')->name('view')->middleware(['can:bank-view']);
        Route::get('/add', 'BankController@add')->name('add')->middleware(['can:bank-add']);
        Route::post('/store', 'BankController@store')->name('store')->middleware(['can:bank-add']);
        Route::get('/edit/{id}', 'BankController@edit')->name('edit')->middleware(['can:bank-update']);
        Route::post('/update/{id}', 'BankController@update')->name('update')->middleware(['can:bank-update']);
        Route::get('/delete/{id}', 'BankController@delete')->name('delete')->middleware(['can:bank-delete']);
        Route::post('/getBankData', 'BankController@getBankData')->name('getBankData');
        
    });

    /*CATEGORY*/
    Route::group(['as'=>'category.','prefix'=>'category', 'namespace'=>'backend'], function(){
        Route::get('/view', 'CategoryController@view')->name('view')->middleware(['can:category-view']);
        Route::get('/add', 'CategoryController@add')->name('add')->middleware(['can:category-add']);
        Route::post('/store', 'CategoryController@store')->name('store')->middleware(['can:category-add']);
        Route::get('/edit/{id}', 'CategoryController@edit')->name('edit')->middleware(['can:category-update']);
        Route::post('/update/{id}', 'CategoryController@update')->name('update')->middleware(['can:category-update']);
        Route::get('/delete/{id}', 'CategoryController@delete')->name('delete')->middleware(['can:category-delete']);
    });

    /*MODE*/
    Route::group(['as'=>'mode.','prefix'=>'mode', 'namespace'=>'backend'], function(){
        Route::get('/view', 'ModeController@view')->name('view')->middleware(['can:mode-view']);
        Route::get('/add', 'ModeController@add')->name('add')->middleware(['can:mode-add']);
        Route::post('/store', 'ModeController@store')->name('store')->middleware(['can:mode-add']);
        Route::get('/edit/{id}', 'ModeController@edit')->name('edit')->middleware(['can:mode-update']);
        Route::post('/update/{id}', 'ModeController@update')->name('update')->middleware(['can:mode-update']);
        Route::get('/delete/{id}', 'ModeController@delete')->name('delete')->middleware(['can:mode-delete']);
    });

    /*MODE*/
    Route::group(['as'=>'user.','prefix'=>'user', 'namespace'=>'backend'], function(){
        Route::get('/view', 'UserController@view')->name('view')->middleware(['can:user-view']);
        Route::get('/add', 'UserController@add')->name('add')->middleware(['can:user-add']);
        Route::post('/store', 'UserController@store')->name('store')->middleware(['can:user-add']);
        Route::get('/edit/{id}', 'UserController@edit')->name('edit')->middleware(['can:user-update']);
        Route::post('/update/{id}', 'UserController@update')->name('update')->middleware(['can:user-update']);
        Route::get('/delete/{id}', 'UserController@delete')->name('delete')->middleware(['can:user-delete']);
        Route::post('/checkEmailExists', 'UserController@checkEmailExists')->name('checkEmailExists');
    });

    /*CLIENT*/
    Route::group(['as'=>'client.','prefix'=>'client', 'namespace'=>'backend'], function(){
        Route::get('/view/{bank_id?}', 'ClientController@view')->name('view')->middleware(['can:client-view']);
        Route::get('/add', 'ClientController@add')->name('add')->middleware(['can:client-add']);
        Route::post('/store', 'ClientController@store')->name('store')->middleware(['can:client-add']);
        Route::get('/edit/{id}', 'ClientController@edit')->name('edit')->middleware(['can:client-update']);
        Route::post('/update/{id}', 'ClientController@update')->name('update')->middleware(['can:client-update']);
        Route::get('/delete/{id}', 'ClientController@delete')->name('delete')->middleware(['can:client-delete']);
        Route::get('/clientDetails/{id}', 'ClientController@clientDetails')->name('clientDetails')->middleware(['can:client-view']);
        Route::post('/getClientFromBranch', 'ClientController@getClientFromBranch')->name('getClientFromBranch');
        Route::post('/checkClientExchange', 'ClientController@checkClientExchange')->name('checkClientExchange');
    });

    /*FUND*/
    Route::group(['as'=>'fund.','prefix'=>'fund', 'namespace'=>'backend'], function(){
        Route::get('/view', 'FundController@view')->name('view')->middleware(['can:fund-view']);
        Route::get('/add', 'FundController@add')->name('add')->middleware(['can:fund-add']);
        Route::post('/store', 'FundController@store')->name('store')->middleware(['can:fund-add']);
        Route::get('/edit/{id}', 'FundController@edit')->name('edit')->middleware(['can:fund-update']);
        Route::post('/update/{id}', 'FundController@update')->name('update')->middleware(['can:fund-update']);
        Route::get('/approve/{id}/{type}', 'FundController@approve')->name('approve')->middleware(['can:fund-approve']);
        Route::get('/delete/{id}', 'FundController@delete')->name('delete')->middleware(['can:fund-delete']);
        Route::post('/approve-fund', 'FundController@approveFund')->name('approve-fund')->middleware(['can:fund-delete']);
        Route::post('/addFund', 'FundController@addFund')->name('addFund');

    });

    /*EXPENSE*/
    Route::group(['as'=>'expense.','prefix'=>'expense', 'namespace'=>'backend'], function(){
        Route::get('/view', 'ExpenseController@view')->name('view')->middleware(['can:expense-view']);
        Route::get('/add', 'ExpenseController@add')->name('add')->middleware(['can:expense-add']);
        Route::post('/store', 'ExpenseController@store')->name('store')->middleware(['can:expense-add']);
        Route::get('/edit/{id}', 'ExpenseController@edit')->name('edit')->middleware(['can:expense-update']);
        Route::post('/update/{id}', 'ExpenseController@update')->name('update')->middleware(['can:expense-update']);
        Route::get('/delete/{id}', 'ExpenseController@delete')->name('delete')->middleware(['can:expense-delete']);
    });

    /*WITHDRAWAL*/
    Route::group(['as'=>'withdrawal.','prefix'=>'withdrawal', 'namespace'=>'backend'], function(){
        Route::get('/view', 'WithdrawalController@view')->name('view')->middleware(['can:withdrawal-view']);
        Route::get('/add/{id?}', 'WithdrawalController@add')->name('add')->middleware(['can:withdrawal-add']);
        Route::post('/store', 'WithdrawalController@store')->name('store')->middleware(['can:withdrawal-add']);
        Route::get('/edit/{id}', 'WithdrawalController@edit')->name('edit')->middleware(['can:withdrawal-update']);
        Route::post('/update/{id}', 'WithdrawalController@update')->name('update')->middleware(['can:withdrawal-update']);
        Route::get('/delete/{id}', 'WithdrawalController@delete')->name('delete')->middleware(['can:withdrawal-delete']);
        Route::get('/fetchWithdrawalList', 'WithdrawalController@fetchWithdrawalList')->name('fetchWithdrawalList');
    });

    /*DEPOSIT*/
    Route::group(['as'=>'deposit.','prefix'=>'deposit', 'namespace'=>'backend'], function(){
        Route::get('/view', 'DepositController@view')->name('view')->middleware(['can:deposit-view']);
        Route::get('/add/{id?}', 'DepositController@add')->name('add')->middleware(['can:deposit-add']);
        Route::post('/store', 'DepositController@store')->name('store')->middleware(['can:deposit-add']);
        Route::get('/edit/{id}', 'DepositController@edit')->name('edit')->middleware(['can:deposit-update']);
        Route::post('/update/{id}', 'DepositController@update')->name('update')->middleware(['can:deposit-update']);
        Route::get('/delete/{id}', 'DepositController@delete')->name('delete')->middleware(['can:deposit-delete']);
        Route::get('/fetchDepositList', 'DepositController@fetchDepositList')->name('fetchDepositList');
    });

    /*COMMON GET FUNCTIONS*/
    Route::group(['as'=>'get.','prefix'=>'get', 'namespace'=>'backend'], function(){
        Route::get('/exchangeDetailsFromId', 'ClientController@exchangeDetailsFromId')->name('exchangeDetailsFromId');
    });

    /*Role*/
    Route::group(['as'=>'role.','prefix'=>'role', 'namespace'=>'backend'], function(){
        Route::get('/view', 'RoleController@view')->name('view')->middleware(['can:role-view']);
        Route::get('/add', 'RoleController@add')->name('add')->middleware(['can:role-add']);
        Route::post('/store', 'RoleController@store')->name('store')->middleware(['can:role-add']);
        Route::get('/edit/{id}', 'RoleController@edit')->name('edit')->middleware(['can:role-update']);
        Route::post('/update/{id}', 'RoleController@update')->name('update')->middleware(['can:role-update']);
        Route::get('/delete/{id}', 'RoleController@delete')->name('delete')->middleware(['can:role-delete']);
        Route::get('/permission/{id}', 'RoleController@permission')->name('permission');
        Route::post('/updateRolePermission/{id}', 'RoleController@updateRolePermission')->name('updateRolePermission')->middleware(['role:Super-Admin']);
        Route::get('/allPermissionToSuperAdmin', 'RoleController@allPermissionToSuperAdmin')->name('allPermissionToSuperAdmin')->middleware(['role:Super-Admin']);
    });

    /*Permission*/
    Route::group(['as'=>'permission.','prefix'=>'permission', 'namespace'=>'backend', 'middleware' => 'role:Super-Admin'], function(){
        Route::get('/view', 'PermissionController@view')->name('view');
        Route::get('/add', 'PermissionController@add')->name('add');
        Route::post('/store', 'PermissionController@store')->name('store');
        Route::get('/edit/{id}', 'PermissionController@edit')->name('edit');
        Route::post('/update/{id}', 'PermissionController@update')->name('update');
        Route::get('/delete/{id}', 'PermissionController@delete')->name('delete');
    });


});
