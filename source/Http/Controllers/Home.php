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
        echo $this->view->render("home", []);
    }
}
