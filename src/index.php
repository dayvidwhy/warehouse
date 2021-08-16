<?php
// load our dependencies
require_once('../vendor/autoload.php');

// load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// server for testing
return call_user_func(function () {
    $uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    $uri = urldecode($uri);
    $configs = include(__DIR__ . '/utils/settings.php');
 
    $requested = __DIR__ . "/" . $uri;
 
    if ($uri !== "/" && file_exists($requested)) {
        return false;
    }

    if ($uri === "/") {
        require_once __DIR__ . "/views/categories.php";
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

    if ($uri === "/sitemap.xml") {
        header("Content-Type: text/xml");
        require_once __DIR__ . "/views/sitemap.php";
        return;
    }
 
    require_once __DIR__ . "/views/error.php";
    return;
});

?>