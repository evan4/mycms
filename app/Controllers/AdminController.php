<?php

namespace App\Controllers;

use Mycms\Session;
use Mycms\View;
use Mycms\Controller;
use App\Models\User;

class AdminController extends Controller
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

    public function login()
    {
        //if($this->session->exists('user')) redirect('/');
        $meta = [
            'title' => 'Login'
        ];

        $data =[
           'csrf' => $this->csrfExists()
        ];
        $home = new View('admin@login', 'admin');
        $home->render(compact('meta', 'data'));
    }

    public function auth()
    {
        $PostArgs = filter_input_array(INPUT_POST);
        $data = [];
        $error = [];
        
        if(isset($PostArgs['csrf']) && !empty($PostArgs['csrf'])){
            if ( !hash_equals($this->session->get('csrf'), $PostArgs['csrf']) ) {
                $error['token'] = 'Ошибка токена';
            }
        }else{
            $error['token'] = 'Ошибка токена';
        }

        $data['email'] = $this->checkEmail($PostArgs['email']);

        if(!$data['email']){
            $error['email'] = 'Email некорректен';
        }

        $password = $this->password($PostArgs['password']);

        if(!$password){
            $error['password'] = 'Пароль некорректен';
        }

        if( $error ){
            echo json_encode($error);
            die();
        }

        $user = new User();
        
        $res = $user->getUser($data);
        
        if($res){
            
            if(!password_verify( $password, $res['password'] )){
                $error['password'] = 'Неверные логин или пароль';
            }else{
                $this->session->set('user', $res['name']);
            }
            
        }else{
            $error['password'] = 'Неверные логин или пароль';
        }
        
        echo json_encode($error);
        die();
        
    }

    public function register()
    {
        $meta = [
            'title' => 'Sing up'
        ];
        
        $data =[
           'csrf' => $this->csrfExists()
        ];

        $home = new View('admin@register', 'admin');
        $home->render(compact('meta', 'data'));
    }

    public function singup()
    {

        //password_hash("rasmuslerdorf", PASSWORD_DEFAULT);
    }

    public function forgoPassword()
    {
        $meta = [
            'title' => 'Recovery password'
        ];
        $data =[
            'csrf' => $this->csrfExists()
        ];
        $home = new View('admin@forgot', 'admin');
        $home->render(compact('meta', 'data'));
    }

    public function logout()
    {
        $this->session->destroy();
        redirect('/');
    }
    
    private function csrfExists()
    {
        if($this->session->exists('csrf')){
            $token = $this->session->get('csrf');
         }else{
             $token = token();
             $this->session->set('csrf', $token);
         }
         return $token;
    }
}
