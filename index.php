<?php

require __DIR__ . "/vendor/autoload.php";

$router = new \Source\Http\Router("http://localhost/devmedia-blog");

$router->namespace("Source\\Controllers");

$router->get("/", function () {
    echo "Helo World";
});
$router->get("/cadastrar/noticia", "Foo@bar");
$router->get("/cadastrar/categoria", "Foo@bar");
$router->get("/editar/noticia/:id", "Foo@bar");
$router->get("/editar/noticia/:ids/:data", "Foo@bar");
$router->get("/editar/categoria/:id", "Foo@bar");

$router->run();

if ($router->error()) {
    echo $router->error();
}
