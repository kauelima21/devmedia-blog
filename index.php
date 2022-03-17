<?php

require __DIR__ . "/vendor/autoload.php";

$router = new \Source\Http\Router("http://localhost/devmedia-blog");

$router->namespace("Source\Http\Controllers");

$router->get("/", "Home@handler");
$router->get("/login", "Login@handler");
$router->get("/cadastrar/noticia", "NewsController@register");
$router->get("/cadastrar/categoria", "CategoryController@edit");
$router->get("/noticia/:id", "NewsController@register");
$router->get("/categoria/:id", "CategoryController@edit");

$router->run();

if ($router->error()) {
    echo $router->error();
}
