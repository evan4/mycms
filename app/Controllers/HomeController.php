<?php

namespace App\Controllers;

use Mycms\Controller;
use Mycms\View;
use App\Models\User;

class HomeController extends Controller
{

    public function index()
    {
        $meta = [
            'title' => 'Home'
        ];

        $user = new User();
        $users = $user->getUsers(['username', 'email'], []);
       
        $home = new View('home@index');

        $home->render(compact('meta', 'users'));
    }
}
