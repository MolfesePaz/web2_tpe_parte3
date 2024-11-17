<?php

require_once './libs/request.php';
require_once './libs/response.php';

class Route {
    private $url;
    private $verbo;
    private $controller;
    private $metodo;
    private $params;

    public function __construct($url, $verbo, $controller, $metodo){
        $this->url = $url;
        $this->verbo = $verbo;
        $this->controller = $controller;
        $this->metodo = $metodo;
        $this->params = [];
    }
    public function match($url, $verbo) {
        if($this->verbo != $verbo){
            return false;
        }
        $partsURL = explode("/", trim($url,'/'));
        $partsRoute = explode("/", trim($this->url,'/'));
        if(count($partsRoute) != count($partsURL)){
            return false;
        }
        foreach ($partsRoute as $key => $part) {
            if($part[0] != ":"){
                if($part != $partsURL[$key])
                return false;
            } 
            else
            $this->params[''.substr($part,1)] = $partsURL[$key];
        }
        return true;
    }
    public function run($request, $response){
        $controller = $this->controller;  
        $metodo = $this->metodo;
        $request->params = (object) $this->params;
       
        (new $controller())->$metodo($request, $response);
    }
}

class Router {
    private $routeTable = [];
    private $middlewares = [];
    private $defaultRoute;
    private $request;
    private $response;

    public function __construct() {
        $this->defaultRoute = null;
        $this->request = new request();
        $this->response = new response();
    }

    public function route($url, $verb) {
        foreach ($this->middlewares as $middleware) {
            $middleware->run($this->request, $this->response);
        }

        foreach ($this->routeTable as $route) {
            if($route->match($url, $verb)){
                $route->run($this->request, $this->response);
                return;
            }
        }
        
        if ($this->defaultRoute !== null) {
            $this->defaultRoute->run($this->request, $this->response);
        } 
        else {
            echo "Error: No hay ruta por defecto configurada.";
        }
    }

    public function addMiddleware($middleware) {
        $this->middlewares[] = $middleware;
    }
    
    public function addRoute ($url, $verbo, $controller, $metodo) {
        $this->routeTable[] = new Route($url, $verbo, $controller, $metodo);
    }

    public function setDefaultRoute($controller, $metodo) {
        $this->defaultRoute = new Route("", "", $controller, $metodo);
    }
}
