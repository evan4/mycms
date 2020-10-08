<?php

namespace Mycms;

class Controller
{
    public function sanitizeText($text)
    {
       return filter_var( $text, FILTER_SANITIZE_SPECIAL_CHARS);
    }
    
    public function checkEmail($email)
    {
        $filteredEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
        
        if ($filteredEmail) {
            return filter_var($filteredEmail, FILTER_SANITIZE_EMAIL);
        }

        return null;
    }

    public function sanitizePassword($text)
    {
        $pass = $this->sanitizeText( $text );

        if(strlen($pass) >= 4 ){
            return $pass;
        }

        return false;
    }

    public function checkAjax(): bool
    {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            return true;
        }
        
        return false;
    }

    public function validation(array $data): array
    {
        $result = [
            'data' => [],
            'errors' => []
        ];
        
        foreach ($data as $key => $value) {
            switch ($key) {
                case 'csrf':
                    if($this->checkToken($value)){
                        $result['errors'][$key] = $this->checkToken($value);
                    }
                    break;
                case 'email':
                    if($this->checkEmail($value)){
                        $result['data'][$key] = $value;
                    }else {
                        $result['errors'][$key] = 'Email некорректен';
                    }
                    break;
                case 'password':
                    if($this->sanitizePassword($value)){
                        $result['data'][$key] = $value;
                    }else{
                        $result['errors'][$key] = 'Пароль некорректен';
                    }
                    break;
                default:
                    
                    if(is_int($value)) {
                        $result['data'][$key] = intval($value);
                    }else {
                        $result['data'][$key] = $this->sanitizeText($value);
                    }
                   
                    break;
            }
        }
        
        return $result;
        
    }

    private function checkToken($token)
    {
        $error = null;

        if(isset($token) && !empty($token)){
            if ( !hash_equals($this->session->get('csrf'), $token) ) {
                $error = 'Ошибка токена';
            }
        }else{
            $error = 'Ошибка токена';
        }

        return $error;
    }
}
