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

        if(!$session->exists('user')) redirect('/login');

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
        $error = [];
        
        if(isset($PostArgs['csrf'])){
            if ( !hash_equals($session->get('csrf'), $PostArgs['csrf']) ) {
                $error['token'] = 'Ошибка токена';
            }
        }else{
            $error['token'] = 'Ошибка токена';
        }
        
        if( $error ){
            echo json_encode($error);
            die();
        }

        $data['email'] = $this->email($PostArgs['email']);

        if(!$data['email']){
            $error['email'] = 'Email некоректен';
            die();
        }

        $data['password'] = $this->password($PostArgs['password']);

        //echo json_encode($data);

        $user = new User();
        
        $res = $user->getUser($data);

        if($res){
           $session->set('user', 'john'); 
           redirect('/admin');
        }else{
            
        }
        
    }

    public function logout()
    {
        $session = new Session();
        $session->destroy();
        redirect('/');
    }
    
}