<?php

namespace Mycms;

class Controller
{
    public function text(String $text)
    {
       return filter_var( $text, FILTER_SANITIZE_SPECIAL_CHARS);
    }
    public function email($email)
    {

        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        if ($email) {
            return filter_var($email, FILTER_SANITIZE_EMAIL);
        }else{
            return null;
        }
    }

    public function password(String $text)
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
        }
        elseif(!preg_match("#[a-z]+#",$password)) {
            $passwordErr = "Your Password Must Contain At Least 1 Lowercase Letter!";
        } */

        return false;
    }
}