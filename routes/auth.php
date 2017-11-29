<?php
/**
 * Created by PhpStorm.
 * User: USUARIO
 * Date: 28/11/2017
 * Time: 8:40 PM
 */

// Rutas que requieren autenticacion

// Posts

Route::get('posts/create', [
    'uses' => 'CreatePostController@create',
    'as' => 'posts.create'
]);

Route::post('posts/create', [
    'uses' => 'CreatePostController@store',
    'as' => 'posts.store'
]);