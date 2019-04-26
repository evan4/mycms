<?php

namespace Mycms;

class Controller
{
    public function text($text)
    {
       return filter_var( $text, FILTER_SANITIZE_SPECIAL_CHARS);
    }
    
    public function checkEmail($email)
    {
        $filteredEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
        if ($filteredEmail) {
            return filter_var($filteredEmail, FILTER_SANITIZE_EMAIL);
        }else{
            return null;
        }
    }

    public function password($text)
    {
        $pass = $this->text( $text );

        if(strlen($pass) >= 4 ){
            return $pass;
        }

      /*   elseif(!preg_match("#[0-9]+#",$password)) {
            $passwordErr = "Your Password Must Contain At Least 1 Number!";
        }
        elseif(!preg_match("#[A-Z]+#",$password)) {
            $passwordErr = "Your Password Must Contain At Least 1 Capital Letter!";
        } */

        return false;
    }

}