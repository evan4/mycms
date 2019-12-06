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

        $home = new View('admin@login', 'admin');

        $home->render(compact('meta'));
    }

    public function auth()
    {
        if(!$this->checkAjax()) redirect('/');

        $validation = $this->validation(filter_input_array(INPUT_POST));
        
        if( $validation['errors'] ){
            echo json_encode($validation['errors']);
            die();
        }

        $user = new User();
        
        $res = $user->getUser([ 'email' => $validation['data']['email'] ]);
        
        $error = [];

        if($res){
            
            if(!password_verify( $validation['data']['password'], $res['password'] )){
                $error['password'] = 'Неверные логин или пароль';
            }else{
                $this->session->set('user', $res['username']);
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

        $home = new View('admin@register', 'admin');

        $home->render(compact('meta'));
    }

    /**
     * register new user via ajax
     *
     */
    public function singup()
    {
        if(!$this->checkAjax()) redirect('/');

        $PostArgs = filter_input_array(INPUT_POST);
        $data = [];
        $error = [];
        
        $token = $this->csrfError($PostArgs['csrf']);
        
        if($token){
            $error['token'] = $token;
        }

        $data['username'] = $this->sanitizeText($PostArgs['username']);

        $data['email'] = $this->checkEmail($PostArgs['email']);

        if(!$data['email']){
            $error['email'] = 'Email некорректен';
        }

        $password = $this->sanitizePassword($PostArgs['password']);

        if(!$password){
            $error['password'] = 'Пароль некорректен';
        }

        if( $error ){
            echo json_encode($error);
            die();
        }

        $user = new User();
        
        $res = $user->saveUser($data);

        //password_verify("rasmuslerdorf", PASSWORD_DEFAULT);

        echo json_encode($error);
        die();
    }

    public function forgot()
    {
        $meta = [
            'title' => 'Recovery password'
        ];

        $home = new View('admin@forgot', 'admin');

        $home->render(compact('meta'));
    }

    public function recoveryPassword()
    {
        if(!$this->checkAjax()) redirect('/');

        $PostArgs = filter_input_array(INPUT_POST);
        $data = [];
        $error = [];
        
        $token = $this->csrfError($PostArgs['csrf']);
        
        if($token){
            $error['token'] = $token;
        }

        $data['email'] = $this->checkEmail($PostArgs['email']);

        if(!$data['email']){
            $error['email'] = 'Email некорректен';
        }

        if( $error ){
            echo json_encode($error);
            die();
        }
        
        $user = new User();
        
        $res = $user->getUser($data);
        
        if($res){
            
            
            
        }else{
            $error['password'] = 'Данного email нет в базе';
        }

        echo json_encode($error);
        die();
    }

    public function logout()
    {
        $this->session->destroy();
        redirect('/');
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
