<?php
namespace Source\Http\Controllers;

use Source\Core\View;

class NewsController
{
    private $view;
    
    public function __construct()
    {
        $this->view = new View(__DIR__ . "/../../../views");
    }

    public function register()
    {
        echo $this->view->render("formNews", []);
    }
}
