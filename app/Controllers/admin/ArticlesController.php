<?php

namespace App\Controllers\admin;

use Mycms\Session;
use Mycms\View;
use Mycms\Controller;
use App\Models\User;

class ArticlesController extends Controller
{
    public $session;

    public function __construct()
    {
        $this->session = new Session();
        $this->session->startSession();
    }

    public function index()
    {
        if(!$this->session->exists('user')) redirect('/login');

        $meta = [
            'title' => 'Dashboard'
        ];

        $home = new View('admin@index', 'dashboard');

        $home->render(compact('meta'));
    }


    private function csrfError($token)
    {
        $error = null;

        if(isset($token) && !empty($token)){
            if ( !hash_equals($this->session->get('csrf'), $csrf) ) {
                $error = 'Ошибка токена';
            }
        }else{
            $error = 'Ошибка токена';
        }

        return $error;
    }
}
