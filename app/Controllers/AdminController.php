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
        if(!$this->session->exists('username')) redirect('/login');
        $username = $this->session->get('username');
        $role = $this->session->get('role');
        
        $meta = [
            'title' => 'Dashboard'
        ];

        $home = new View('admin@index', 'dashboard');
        
        $home->render(compact('meta', 'username', 'role'));
    }

    public function login()
    {
        $meta = [
            'title' => 'Login'
        ];

        $home = new View('admin@login', 'admin');

        $home->render(compact('meta'));
    }

    public function auth()
    {
        //if(!$this->checkAjax()) redirect('/');
        $validation = $this->validation(filter_input_array(INPUT_POST));
        
        if( $validation['errors'] ){
            echo json_encode($validation['errors']);
            die();
        }

        $user = new User();
        
        $res = $user->getUser(
            ['username','email', 'role', 'password'],
            [ 'email' => $validation['data']['email'] ]
        );
       
        $error = [];
        
        if($res){
            
            if(password_verify( $validation['data']['password'], $res['password'] )){
                $this->session->set('username', $res['username']);
                $this->session->set('role', $res['role']);
                redirect('/admin');
            }else{
                $error['password'] = 'Неверные логин или пароль';
            }
            
        }else{
            $error['password'] = 'Неверные логин или пароль';
        }
        redirect('/login');
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
        
        $validation = $this->validation(filter_input_array(INPUT_POST));
        
        $user = new User();

        $result = $user->getUser(
            ['username','email', 'role', 'password'],
            [ 'email' => $validation['data']['email'] ]
        );

        if($result){
            $validation['errors']['email_unique'] = 'There is same email in db';
        }

        if( $validation['errors'] ){
            echo json_encode($validation['errors']);
            die();
        }

        $validation['data']['password'] = password_hash( 
            $validation['data']['password'],  
            PASSWORD_DEFAULT
        );
        
        $res = $user->saveUser($validation['data']);
        
        $error = [];

        if($res){
            $this->session->set('username', $validation['data']['username']);
            $this->session->set('role', $validation['data']['role']);

        }else {
            $error['registration'] = 'Произошла ошибка.';
        }

        echo json_encode($error);
        die();
    }

    public function userExists()
    {
        if(!$this->checkAjax()) redirect('/');
        
        $validation = $this->validation(filter_input_array(INPUT_POST));
        
        $user = new User();

        $result = $user->getUser(
            ['username','email', 'password'],
            [ 'email' => $validation['data']['email'] ]
        );

        if($result){
            $validation['errors']['email_unique'] = 'There is same email in db';
        }

        if( $validation['errors'] ){
            echo json_encode($validation['errors']);
        }
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
        
        $res = $user->getUser(
            ['username','email', 'password'], $data);
        
        if($res){
            
        }else{
            $error['password'] = 'Данного email нет в базе';
        }

        echo json_encode($error);
        die();
    }

    public function logout()
    {
        $this->session->delete('username');
        $this->session->delete('role');
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
