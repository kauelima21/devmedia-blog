<?php

namespace Source\Http;

class Router
{
    private $routes;

    private $route;

    private $httpMethod;

    private $args;

    private $namespace;

    private $error;

    public function __construct(private string $baseUrl, private string $separator = "@")
    {
        $this->separator = $separator;
        $this->httpMethod = $_SERVER["REQUEST_METHOD"];
        $this->route = str_replace(explode("/", $this->baseUrl), "", $_SERVER["REQUEST_URI"]);
        // remove a primeira "/" para dar certo em apache e servidor embutido php
        $this->route = (substr($this->route, 0, 2) == "//" ? substr($this->route, 1) : $this->route);
    }

    public function namespace(string $namespace)
    {
        $this->namespace = ucwords($namespace);
    }

    public function get(string $path, $handler)
    {
        $this->addRoute("GET", $path, $handler);
    }

    public function post(string $path, $handler)
    {
        $this->addRoute("POST", $path, $handler);
    }

    public function run()
    {
        $routes = array_map(function ($value) {
            $value["route"] = $this->setDinamicPath($value["route"]);
            return $value;
        }, $this->routes[$this->httpMethod]);

        $res = array_map(function ($value) {
            if (preg_match_all($value["route"], $this->route, $matchs)) {
                array_shift($matchs);
                $this->resolveArgs($value["route"], $matchs);
                $this->execute($value);
                return "ok";
            }
        }, $routes);

        if (! in_array("ok", $res)) {
            $this->error = 404;
        }
    }

    public function error()
    {
        return $this->error;
    }

    private function execute($route)
    {
        if ($route["controller"] instanceof \Closure) {
            call_user_func($route["controller"], $this->args);
            return;
        }

        $controller = $this->namespace . "\\" . $route["controller"];
        $method = $route["method"];

        if (! class_exists($controller)) {
            return throw new \Exception("O namespace informado nao e valido.");
        }
        
        $controller = new $controller;
        if (! method_exists($controller, $method)) {
            $this->error = 405;
            return;
        }

        $controller->$method($this->args);
    }

    private function resolveArgs($route, $matchs)
    {
        //normaliza o array $matchs
        foreach ($matchs as $key => $match) {
            $matchs[$key] = $match[0];
        }

        //prepara o array args
        foreach ($this->routes[$this->httpMethod] as $key => $value) {
            $key = strstr($value["route"], ":");
            if (preg_match_all($route, $value["route"]) && $key) {
                $key = str_replace(":", "", $key);
                $key = (strstr($key, "/") ? explode("/", $key) : [$key]);
                $this->args = array_map(fn($value) => $value, $key);
            }
        }

        if ($this->args) {
            $this->args = array_combine(array_values($this->args), array_values($matchs));
        }

        $this->args = [];
    }

    private function addRoute(string $method, string $path, $handler)
    {
        $this->routes[$method][$path] = [
            "route" => $path,
            "controller" => (is_string($handler) ? strstr($handler, $this->separator, true) : $handler),
            "method" => (is_string($handler) ? substr(strstr($handler, $this->separator, false), 1) : "")
        ];
    }

    private function setDinamicPath(string $paths)
    {
        $paths = explode("/", $paths);
        foreach ($paths as $key => $path) {
            $paths[$key] = (strstr($path, ":") ? preg_replace("/^:(.*)/", "([^\/]*)", $path) : $path);
        }

        return "/^" . implode("\/", $paths) . "$/";
    }
}
