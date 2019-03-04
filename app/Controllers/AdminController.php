<?php

namespace App\Controllers;

use Mycms\Session;
use Mycms\View;
use Mycms\Controller;
use App\Models\User;

class AdminController extends Controller
{
    private $base;

    public function index()
    {
        $session = new Session();

        $session->startSession();

        if(!$this->session->exists('user')) redirect('/login');

        $meta = [
            'title' => 'Dashboard'
        ];

        $home = new View('admin@index', 'dashboard');

        $home->render(compact('meta'));
    }

    public function login()
    {
        $user = new user();
        $meta = [
            'title' => 'Login'
        ];
        $session = new Session();

        $session->startSession();
        
        if($session->exists('csrf')){
           $token = $session->get('csrf');
        }else{
            $token = token();
            $session->set('csrf', $token);
        }

        $data =[
           'csrf' => $token
        ];
        $home = new View('admin@login', 'admin');
        $home->render(compact('meta', 'data'));
    }

    public function auth()
    {
        $session = new Session();

        $session->startSession();
        $PostArgs = filter_input_array(INPUT_POST);
        $data = [];
        $error = '';
        
        if(isset($PostArgs['csrf'])){
            if ( !hash_equals($session->get('csrf'), $PostArgs['csrf']) ) {
                $error = 'Ошибка токена';
            }
        }else{
            $error = 'Ошибка токена';
        }
        
        if( $error  ){
            echo $error;
            die();
        }

        
        $data['email'] = $this->email($PostArgs['email']);
        $data['password'] = $this->password($PostArgs['password']);
        
        echo json_encode($data);
      
        //$this->session->set('user', 'john');
        
    }

    public function logout()
    {
        $session = new Session();
        $session->destroy();
        redirect('/');
    }
    
}