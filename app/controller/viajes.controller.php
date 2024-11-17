<?php
require_once 'app/model/viajes.model.php';
require_once 'app/view/json.view.php';

class viajesController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new viajesModel();
        $this->view = new JSONView();
    }

    // /api/viajes
    public function getViajes($req, $res) {

         // Obtener los parámetros de la consulta (si existen)
        $orderBy = isset($req->query->orderBy) ? $req->query->orderBy : false;
        $orderDir = isset($req->query->orderDir) ? strtoupper($req->query->orderDir) : 'ASC'; // 'ASC' por defecto
        $limit = isset($req->query->limit) ? (int)$req->query->limit : 10; // 10 por defecto
        $page = isset($req->query->page) ? (int)$req->query->page : 1; // Página 1 por defecto

         // Calcular el OFFSET
        $offset = ($page - 1) * $limit;

        if (!in_array($orderDir, ['ASC', 'DESC'])) {
            $orderDir = 'ASC'; // Si no es válido, usar 'ASC'
        }

        $viajes = $this->model->getViajes($orderBy, $orderDir, $limit, $offset);
    
        return $this->view->response($viajes);
    }

     // /api/viajes/:id
     public function getViaje($req, $res) {
        $id = $req->params->id;

        $viaje = $this->model->getViaje($id);

        if(!$viaje) {
            return $this->view->response("El viaje con el id=$id no existe", 404);
        }

        return $this->view->response($viaje);
    }


    // api/viajes/:id (PUT)
    public function editar($req, $res) {
        $id = $req->params->id;

        // verifico que exista
        $viaje = $this->model->getViaje($id);
        if (!$viaje) {
            return $this->view->response("El viaje con el id=$id no existe", 404);
        }

         // valido los datos
         if (empty($req->body->origen) || empty($req->body->destino) || empty($req->body->FechaDeSalida) || empty($req->body->FechaDeLlegada)) {
            return $this->view->response('Faltan completar datos', 400);
        }

        // obtengo los datos
        $origen = $req->body->origen;       
        $destino = $req->body->destino;       
        $FechaDeSalida = $req->body->FechaDeSalida;
        $FechaDeLlegada = $req->body->FechaDeLlegada;

        // actualiza la tarea
        $this->model->editar($id, $origen, $destino, $FechaDeSalida, $FechaDeLlegada);

        // obtengo la tarea modificada y la devuelvo en la respuesta
        $viaje = $this->model->getViaje($id);
        $this->view->response($viaje, 200);
    }
}

