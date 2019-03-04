<?php

namespace App\Controllers;

use Mycms\View;

class HomeController
{

    public function index()
    {
        $meta = [
            'title' => 'Home'
        ];

        $home = new View('home@index');

        $home->render(compact('meta'));
    }
}