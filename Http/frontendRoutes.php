<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' => 'auth'], function (Router $router) {
    # Login
    $router->get('login', ['middleware' => 'auth.guest', 'as' => 'login', 'uses' => 'AuthController@getLogin']);
    $router->post('login', ['as' => 'login.post', 'uses' => 'AuthController@postLogin']);
    # Register
    if (config('asgard.user.config.allow_user_registration', true)) {
        $router->get('register', ['middleware' => 'auth.guest', 'as' => 'register', 'uses' => 'AuthController@getRegister']);
        $router->post('register', ['as' => 'register.post', 'uses' => 'AuthController@postRegister']);
    }
    # Account Activation
    $router->get('activate/{userId}/{activationCode}', 'AuthController@getActivate');
    # Reset password
    $router->get('reset', ['as' => 'reset', 'uses' => 'AuthController@getReset']);
    $router->post('reset', ['as' => 'reset.post', 'uses' => 'AuthController@postReset']);
    $router->get('reset/{id}/{code}', ['as' => 'reset.complete', 'uses' => 'AuthController@getResetComplete']);
    $router->post('reset/{id}/{code}', ['as' => 'reset.complete.post', 'uses' => 'AuthController@postResetComplete']);
    # Logout
    $router->get('logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout']);
});

Route::get('/oauth/{type}', 'OauthController@redirectToProvider');
Route::get('/oauth/cb/{type}', 'OauthController@handleProviderCallback');

$router->group(['middleware' => 'logged.in'],function(Router $router){
    $router->get('/usercenter', ['as' => 'usercenter', 'uses' => 'PublicController@usercenter']);
    $router->get('/account', ['as' => 'account', 'uses' => 'PublicController@account']);
    $router->post('/reset_password',['as' => 'user.front.resetpassword', 'uses' => 'ResetPasswordController@updatePassword' ]);

    $router->resource('/address','AddressController');
    $router->post('/address/{address}/setDefault',['as'=>'address.setDefault','uses'=>'AddressController@setDefault']);

    //$router->get('/order', ['as' => 'orders', 'uses' => 'PublicController@order']);
    $router->get('/reviews', ['as' => 'reviews', 'uses' => 'PublicController@reviews']);
    $router->get('/favorites', ['as' => 'favorites', 'uses' => 'PublicController@favorites']);
    $router->get('/notifications', ['as' => 'notifications', 'uses' => 'PublicController@notifications']);
    $router->get('/notifications/{notification}', ['as' => 'notification', 'uses' => 'PublicController@notification']);

    $router->get('/inbox/{dialogId}','InboxController@show');

    $router->get('/getAllCountries', ['as' => 'getAllCountries', 'uses' => 'RegionController@getAllCountries']);
    $router->get('/getAllProvinces/{countryId}', ['as' => 'getAllProvinces', 'uses' => 'RegionController@getAllProvinces']);
    $router->get('/getAllCities/{provinceId}', ['as' => 'getAllCities', 'uses' => 'RegionController@getAllCities']);
});

Route::post('/customer/newsletter', ['as' => 'newsletter.submit' , 'uses' => 'PublicController@newsletter' ]  );
Route::get('/customer/newsletter_detail', ['as' => 'newsletter.detail' , 'uses' => 'PublicController@newsletter_detail' ]  );
