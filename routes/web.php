<?php



Route::get('/', 'Auth\LoginController@showLoginForm');
Route::get('/home1',  'HomeController@index')->name('home');




Auth::routes();


Route::get('/home', function(){
 return view('map');
})->middleware('auth');

Route::post('/geoUpdate','geoController@geoUpdate');

Route::post('/bookRegister','geoController@bookRegister');

Route::post('/bookCancell','geoController@bookCancell');

Route::post('/bookReject','geoController@bookReject');

Route::post('/passengerConfirmCancell','geoController@passengerConfirmCancell');

Route::post('/bookAccept','geoController@bookAccept');

Route::post('/driverConfirmCancell','geoController@driverConfirmCancell');

Route::get('/connect',function (){
    return view('connect_driver');
});




Route::group(['namespace' => 'Admin'],function(){

    Route::get('/admin-login','Auth\LoginController@showLoginForm')->name('admin.login');

    Route::post('/admin-login','Auth\LoginController@login');

    Route::get('/admin-logout','Auth\LoginController@logout')->name('admin.logout');

    Route::get('/admin/home','driverController@show');

    Route::get('/driver/edit/{id}','driverController@edit');

    Route::post('driver/suspect/{id}','driverController@suspect')->name('driver.suspect');

    Route::post('/driver/terminate/{id}','driverController@terminate')->name('driver.terminate');

    Route::post('/driver/update/{id}','driverController@update')->name('driver.update');

    Route::get('/admin/driver/edit/{id}','driverController@edit');

    Route::get('/admin/passenger','passengerController@show');

    Route::get('/admin/notification','notificationController@show');

    Route::get('/admin/readNotification','notificationController@readNotification');

    Route::get('/admin/markAsRead','notificationController@markAsRead');
});









