<?php

use Mycms\Router;

$router = new Router();

$router->add('/','HomeController@index');
$router->add('/admin','AdminController@index');
$router->add('/login','AdminController@login');
$router->add('/forgot','AdminController@forgot');
$router->add('/register','AdminController@register');
$router->add('/logout','AdminController@logout');

// ajax requsets
$router->add('/auth','AdminController@auth', 'post');
$router->add('/singup','AdminController@singup', 'post');
$router->add('/recovery','AdminController@recoveryPassword', 'post');

$router->dispatch();
