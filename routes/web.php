<?php

use Mycms\Router;

$router = new Router();

$router->add('/','HomeController@index');
$router->add('/admin','AdminController@index');
$router->add('/login','AdminController@login');

$router->add('/auth','AdminController@auth', 'post');

$router->dispatch();