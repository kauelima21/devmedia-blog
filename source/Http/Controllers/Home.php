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
        echo $this->view->render("newsCard.html", [
            "linkCss" => loadAsset("css/styles.css"),
            "homeLink" => url("/"),
            "newsRegisterLink" => url("/cadastrar/noticia"),
            "categoryRegisterLink" => url("/cadastrar/categoria"),
            "loginLink" => url("/login"),
            "newsCardLink" => url("/noticia/:id")
        ]);
    }
}
