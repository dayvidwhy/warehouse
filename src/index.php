<?php
// load our dependencies
require_once('../vendor/autoload.php');
spl_autoload_register(function($className) {
	include_once $_SERVER['DOCUMENT_ROOT'] . '/utils/' . $className . '.php';
});

// load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// server for testing
return call_user_func(function () {
    // grab the url they're after
    $uri = urldecode(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));

    // load our configuration
    $configs = include(__DIR__ . '/utils/settings.php');
 
    if ($uri === "/") {
        require_once __DIR__ . "/views/wares.php";
        return;
    }

    if (strpos($uri, "/". $configs["stockType"] . "/") === 0) {
        require_once __DIR__ . "/views/items.php";
        return;
    }

    if ($uri === "/generate") {
        require_once __DIR__ . "/utils/generate.php";
        return;
    }
 
    require_once __DIR__ . "/views/error.php";
    return;
});

?>