<?php

use Mycms\Router;

$router = new Router();

$router->add('/','HomeController@index');
$router->add('/admin','AdminController@index');
$router->add('/login','AdminController@login');
$router->add('/register','AdminController@register');
$router->add('/logout','AdminController@logout');

$router->add('/auth','AdminController@auth', 'post');
$router->add('/singup','AdminController@singup', 'post');

$router->dispatch();
