<?php
namespace Source\Http\Controllers;

use Source\Core\View;

class Home
{
    private $view;
    
    public function __construct()
    {
        $this->view = new View(__DIR__ . "/../../../views");
    }

    public function handler()
    {
        echo $this->view->render("_base", [
            "linkCss" => loadAsset("css/styles.css"),
            "homeLink" => url("/"),
            "newsRegisterLink" => url("/cadastrar/noticia"),
            "categoryRegisterLink" => url("/cadastrar/categoria"),
            "newsCardLink" => url("/noticia/:id"),
            "loginLink" => url("/login"),
            "content" => $this->view->render("newsCard", [])
        ]);
    }
}
