<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('gettoken/{captcha}', [
    'as' => 'gettoken', 'uses' => 'CaptchaController@getToken'
]);
$router->post('solvecaptcha', [
    'as' => 'solvecaptcha', 'uses' => 'CaptchaController@solve'
]);
$router->get('geocode', [
  'as' => 'geocode', 'uses' => 'GeocodeController@geocode'
]);
