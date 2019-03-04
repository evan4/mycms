<?php

if (! function_exists('redirect')) {
    function redirect($url)
	{
		header('Location: ' . '/login', true, 302);
		die();
	}
}

if (! function_exists('token')) {
    function token()
	{
		$token = '';
		if (function_exists('mcrypt_create_iv')) {
			$token = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
		} else {
			$token = extension_loaded('openssl') ? bin2hex(openssl_random_pseudo_bytes(32)) : mt_rand();
		}
		return $token;
	}
}