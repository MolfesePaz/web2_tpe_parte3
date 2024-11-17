<?php 

class viajesModel{
    private $db;

    function __construct(){
        $this->db = new PDO('mysql:host=localhost;dbname=viajeslupa;charset=utf8', 'root', '');
    }

    public function getViajes($orderBy = false, $orderDir = 'ASC', $limit = 10, $offset = 0){
        $sql= "SELECT * FROM viajes";

        if($orderBy) {
            $orderDir = strtoupper($orderDir) === 'DESC' ? 'DESC' : 'ASC';  // Predeterminado es 'ASC'
            switch($orderBy) {
                case 'id':
                    $sql .= ' ORDER BY id_viaje '. $orderDir;
                    break;
                case 'origen':
                    $sql .= ' ORDER BY origen ' . $orderDir;
                    break;
                case 'destino':
                    $sql .= ' ORDER BY destino ' . $orderDir;
                    break;
                case 'FechaDeSalida':
                    $sql .= ' ORDER BY FechaDeSalida ' . $orderDir;
                    break;
                case 'FechaDeLlegada':
                    $sql .= ' ORDER BY FechaDeLlegada ' . $orderDir;
                    break;
            }
        }
        // Agregar LIMIT y OFFSET para la paginación
        $sql .= " LIMIT :limit OFFSET :offset";

        $query = $this->db->prepare($sql);

        // Vincular los parámetros de LIMIT y OFFSET
        $query->bindParam(':limit', $limit, PDO::PARAM_INT);
        $query->bindParam(':offset', $offset, PDO::PARAM_INT);

        $query->execute();
        $viajes = $query->fetchAll(PDO::FETCH_OBJ); 
    
        return $viajes;
    }

    public function getViaje($id) {    
        $query = $this->db->prepare('SELECT * FROM viajes WHERE id_viaje = ?');
        $query->execute([$id]);   

        $viaje = $query->fetch(PDO::FETCH_OBJ);
    
        return $viaje;
    }

    public function editar($id, $origen, $destino, $FechaDeSalida, $FechaDeLlegada ){
        $query = $this->db->prepare('UPDATE viajes SET origen = ?, destino = ?, FechaDeSalida = ?, FechaDeLlegada = ? WHERE id_viaje = ?');
        $query->execute([$origen, $destino, $FechaDeSalida, $FechaDeLlegada,$id]);
    }

}