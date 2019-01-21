<?php

Route::get('/', function () {
    return redirect('/admin/home');
});

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login')->name('auth.login');
$this->post('logout', 'Auth\LoginController@logout')->name('auth.logout');

// Change Password Routes...
$this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
$this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/{any}', 'HomeController@index')->where('any', '.*');
});

Route::get('/ponto', function () {
    $retorno = '[{"data":"14\/01\/2019","entrada":"10:27:00","saida":"19:35:00"},{"data":"15\/01\/2019","entrada":"09:42:00","saida":"19:20:00"},{"data":"16\/01\/2019","entrada":"09:10:00","saida":"20:23:00"},{"data":"17\/01\/2019","entrada":"10:34:00","saida":"20:28:00"},{"data":"18\/01\/2019","entrada":"11:48:00"}]';
    return $retorno;
});
