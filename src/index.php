<?php
// server for testing
return call_user_func(function () {
    $uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    $publicDir = __DIR__ ;
    $uri = urldecode($uri);
    $configs = include(__DIR__ . '/scripts/settings.php');
 
    $requested = $publicDir . "/" . $uri;
 
    if ($uri !== "/" && file_exists($requested)) {
        return false;
    }

    if ($uri === "/") {
        require_once $publicDir . "/views/categories.php";
        return;
    }


    if (strpos($uri, "/". $configs["stockType"] . "/") === 0) {
        require_once $publicDir . "/views/items.php";
        return;
    }

    if ($uri === "/generate") {
        require_once $publicDir . "/scripts/generate.php";
        return;
    }

    if ($uri === "/sitemap.xml") {
        header("Content-Type: text/xml");
        require_once $publicDir . "/views/sitemap.php";
        return;
    }
 
    require_once $publicDir . "/views/error.php";
    return;
});

?>