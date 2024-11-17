<?php
    
    require_once 'libs/routerMain.php';

    require_once 'app/controller/viajes.controller.php';
    
    $router = new Router();

    #                 endpoint        verbo      controller              metodo
    $router->addRoute('viajes'      , 'GET',     'viajesController',   'getViajes');
    $router->addRoute('viajes/:id'  , 'GET',     'viajesController',   'getViaje'   );
    $router->addRoute('viajes/:id'  , 'PUT',     'viajesController',   'editar');

    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
