<?php
include_once realpath(__DIR__ . '/src/Autoloader.php');
$autoload = \src\Autoloader::getInstance();
$autoload->registro();
$http = new core\http\HttpHelper();
$http->run();
?>
