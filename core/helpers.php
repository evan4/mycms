<?php

use Mycms\Session;

if (! function_exists('redirect')) {
    function redirect($url)
	{
		header('Location: ' . '/login', true, 302);
		die();
	}
}

if (! function_exists('generateToken')) {
    function generateToken()
	{
		if (function_exists('mcrypt_create_iv')) {
			return bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
		}
		
		return extension_loaded('openssl') ? 
			bin2hex(openssl_random_pseudo_bytes(32)) : mt_rand();
	}
}

if (! function_exists('csrf')) {
	function csrf()
	{
		$session = new Session();
		$session->startSession();

		if($session->exists('csrf')){
            $token = $session->get('csrf');
        }else{
            $token = generateToken();
            $session->set('csrf', $token);
        }

        return $token;
	}
}
	