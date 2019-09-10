<?php
define("ROOT", dirname(__DIR__));
define("WWW", ROOT . '/public');
define("APP", ROOT . '/app');
define("VIEWS", ROOT . '/resources/views/');
define("CORE", ROOT . '/core');
define("CONF", ROOT . '/config/');

require_once __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(ROOT);
$dotenv->load();

if(getenv('APP_ENV') === 'local'){
    $whoops = new \Whoops\Run;
    $whoops->prependHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}
