<?php

use Illuminate\Support\Facades\Route;

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
    return redirect('/customers');
})->middleware('auth');

Auth::routes([
  'register' => false, // Registration Routes...
  'reset' => false, // Password Reset Routes...
  'verify' => false, // Email Verification Routes...
]);

Route::get('/privacyPolicy', [App\Http\Controllers\HomeController::class, 'privacyPolicy'])->name('privacyPolicy');
Route::get('/changePassword', [App\Http\Controllers\HomeController::class, 'showChangePasswordGet'])->name('changePasswordGet')->middleware('auth');;
Route::post('/changePassword', [App\Http\Controllers\HomeController::class, 'changePasswordPost'])->name('changePasswordPost')->middleware('auth');;

Route::middleware(['auth'])->group(function() {

  Route::get('/home', 'App\Http\Controllers\CustomersController@index')->name('home');

  Route::get('/dashboard', function () {
      return view('dashboard');
  });


  Route::get('/customers'                       , 'App\Http\Controllers\CustomersController@index'   )->name('customer.view' );
  Route::get('/customer/create'                 , 'App\Http\Controllers\CustomersController@create'  )->name('customer.create' );
  Route::post('/customer'                       , 'App\Http\Controllers\CustomersController@store'   )->name('customer.add'  );
  Route::get('/customers/{customer}/edit'       , 'App\Http\Controllers\CustomersController@edit'    )->name('customer.edit' );
  Route::post('/customers/{customer}'           , 'App\Http\Controllers\CustomersController@update'  )->name('customer.update' );
  Route::post('/customers/{customer}/delete'    , 'App\Http\Controllers\CustomersController@destroy' )->name('customer.delete' );
  Route::get('/customers/getTableData'          , 'App\Http\Controllers\CustomersController@getTableData'    )->name('customer.table_data'  );
  Route::get('/customers/{customer}/messages'   , 'App\Http\Controllers\CustomerMessagesController@index'    )->name('customer.messages'  );
  Route::get('/customers/{customer}/contacts'   , 'App\Http\Controllers\CustomerContactsController@index'    )->name('customer.contacts'  );
  Route::get('/customers/{customer}/calls'   , 'App\Http\Controllers\CustomerCallsController@index'    )->name('customer.calls'  );
  Route::get('/customers/{customer}/files'      , 'App\Http\Controllers\CustomerFilesController@index'       )->name('customer.files'  );
  Route::get('/customers/{customer}/transactions'      , 'App\Http\Controllers\TransactionsController@index'       )->name('customer.transactions'  );

  Route::get('/customers_messages/{customer}'                    , 'App\Http\Controllers\CustomerMessagesController@index'        )->name('customer_messages.view'  );
  Route::get('/customersmessages/getTableData'                  , 'App\Http\Controllers\CustomerMessagesController@getTableData'   )->name('customer_messages.threads'  );
  Route::post('/customer_messages/{customer_message}/delete'    , 'App\Http\Controllers\CustomerMessagesController@destroy'  )->name('customer_messages.delete'  );

  Route::get('/customer_contacts/{customer}'             , 'App\Http\Controllers\CustomerContactsController@index'    )->name('admin.customer_contacts.view'  );
  Route::get('/customerscontacts/getTableData'          , 'App\Http\Controllers\CustomerContactsController@getTableData'   )->name('admin.customer_contacts.table_data'  );
  Route::post('/customer_contacts/{customer_contacts}/delete'   , 'App\Http\Controllers\CustomerContactsController@destroy'  )->name('admin.customer_contacts.delete'  );

  Route::get('/customer_calls/{customer}'             , 'App\Http\Controllers\CustomerCallsController@index'    )->name('admin.customer_calls.view'  );
  Route::get('/customerscalls/getTableData'          , 'App\Http\Controllers\CustomerCallsController@getTableData'   )->name('admin.customer_calls.table_data'  );
  Route::post('/customer_calls/{customer_call}/delete'   , 'App\Http\Controllers\CustomerCallsController@destroy'  )->name('admin.customer_calls.delete'  );

  Route::get('/customer_files/{customer}'             , 'App\Http\Controllers\CustomerFilesController@index'    )->name('admin.customer_files.view'  );
  Route::get('/customersfiles/getTableData'          , 'App\Http\Controllers\CustomerFilesController@getTableData'   )->name('admin.customer_files.table_data'  );
  Route::post('/customer_files/{customer_contacts}/delete'   , 'App\Http\Controllers\CustomerFilesController@destroy'  )->name('admin.customer_files.delete'  );


  Route::get('/notifications'                       , 'App\Http\Controllers\NotificationController@index'   )->name('notification.view' );
  Route::post('/notification'                       , 'App\Http\Controllers\NotificationController@store'   )->name('notification.add'  );
  Route::post('/notifications/{notification}'           , 'App\Http\Controllers\NotificationController@update'  )->name('notification.update' );
  Route::post('/notifications/{notification}/delete'    , 'App\Http\Controllers\NotificationController@destroy' )->name('notification.delete' );
  Route::get('/notifications/getTableData'          , 'App\Http\Controllers\NotificationController@getTableData'    )->name('notification.table_data'  );

  Route::get('/customer_transactions/{customer}'                       , 'App\Http\Controllers\TransactionsController@index'   )->name('transaction.view' );
  Route::post('/customer_transactions'                       , 'App\Http\Controllers\TransactionsController@store'   )->name('transaction.add'  );
  Route::post('/customer_transactions/{transaction}/delete'    , 'App\Http\Controllers\TransactionsController@destroy' )->name('transaction.delete' );
  Route::get('/customerstransactions/getTableData'          , 'App\Http\Controllers\TransactionsController@getTableData'    )->name('transaction.table_data'  );

});

Route::get('/storage', function(){
    Artisan::call('storage:link');
    return "link process successfully completed";
});
Route::get('artisan/config', function () {
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    return Artisan::output();
});
Route::get('artisan/cache', function () {
    Artisan::call('cache:clear');
    return Artisan::output();
});
Route::get('artisan/view', function () {
    Artisan::call('view:clear');
    return Artisan::output();
});