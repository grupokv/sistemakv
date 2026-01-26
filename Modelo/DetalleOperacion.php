<?php 
require_once('Conexion/conexionBD.php');

class DetalleOperacion
{
    public $total = array();
    public $total1 = array();
    public $listarId = array();

    public function registrarDetalle($precio, $id_vehiculo, $id_operacion, $fecha){
    	try {
    		$con = Conexion::conectar();
    	    $sql = $con->prepare("INSERT INTO detalles_operaciones(precio, id_vehiculo, id_operacion, fecha, estado, novedad) 
    		                  VALUES(:precio, :id_vehiculo, :id_operacion, :fecha, 1, '')");
    	    $sql->bindParam(":precio", $precio);
    	    $sql->bindParam(":id_vehiculo", $id_vehiculo);
    	    $sql->bindParam(":id_operacion", $id_operacion);
    	    $sql->bindParam(":fecha", $fecha);
            $sql->execute();

    	} catch (Exception $ex) {
    		echo $ex->getMessage();
    	}
    	
    }

    public function listarDetallesFinalizados(){
            $listarDetallesFinalizados = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM detalles_operaciones AS do INNER JOIN vehiculos AS v ON do.id_vehiculo = v.id_vehiculo INNER JOIN operaciones AS o ON do.id_operacion = o.id_operacion WHERE do.estado = 0");
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                $listarDetallesFinalizados[] = $filas;
            }

            return $listarDetallesFinalizados;
        
    }

    public function listarDetallesFinalizadosPDF($fecha_inicio, $fecha_final){
        $listarDetallesFPDF = array();
        $con = Conexion::conectar();
        $sql = $con->prepare('SELECT * FROM detalles_operaciones AS do INNER JOIN vehiculos AS v ON do.id_vehiculo = v.id_vehiculo INNER JOIN operaciones AS o ON do.id_operacion = o.id_operacion WHERE do.fecha >= :fecha_inicio AND do.fecha <= :fecha_final AND do.estado = 0');
        $sql->bindParam(":fecha_inicio", $fecha_inicio);
        $sql->bindParam(":fecha_final", $fecha_final);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listarDetallesFPDF[] = $filas;
        }

        return $listarDetallesFPDF;
    }

    public function filtrar($fecha_inicio, $fecha_final, $id_vehiculo, $id_operacion){

            $listarDetallesFiltrados = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT v.*, d.*, o.* FROM vehiculos AS v INNER JOIN detalles_operaciones AS d
                                  ON v.id_vehiculo = d.id_vehiculo INNER JOIN operaciones AS o ON d.id_operacion = o.id_operacion
                                  WHERE fecha >= :fecha_inicio AND fecha <= :fecha_final AND d.id_vehiculo LIKE :id_vehiculo AND d.id_operacion LIKE :id_operacion AND d.estado = '1' ;");
            $sql->bindParam(":fecha_inicio", $fecha_inicio);
            $sql->bindParam(":fecha_final", $fecha_final);
            $sql->bindParam(":id_vehiculo", $id_vehiculo);
            $sql->bindParam(":id_operacion", $id_operacion);
            $sql->execute();
            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                  $listarDetallesFiltrados[] = $filas;
            }
            return $listarDetallesFiltrados; 
    }


    public function filtrarDetallesCumplidos($fecha_inicio, $fecha_final, $id_vehiculo, $id_operacion){

            $filtrar = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT v.*, d.*, o.* FROM vehiculos AS v INNER JOIN detalles AS d
                                  ON v.id = d.id_vehiculo INNER JOIN operaciones AS o ON d.id_operacion = o.id_operacion
                                  WHERE fecha >= '$fecha_inicio' AND fecha <= '$fecha_final' AND id_vehiculo LIKE '$id_vehiculo' AND d.id_operacion LIKE '$id_operacion' AND estado = 0;");
            $sql->bindParam(":fecha_inicio", $fecha_inicio);
            $sql->bindParam(":fecha_final", $fecha_final);
            $sql->bindParam(":id_vehiculo", $id_vehiculo);
            $sql->bindParam(":id_operacion", $id_operacion);
            $sql->execute();
            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                  $filtrar[] = $filas;
            }
            return $filtrar; 
    }


    public function valorTotalFiltroDetallesCumplidos($fecha_inicio, $fecha_final, $id_vehiculo, $id_operacion){


            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT SUM(precio) AS total FROM detalles WHERE fecha >= '$fecha_inicio' AND fecha <= '$fecha_final' AND id_vehiculo LIKE '$id_vehiculo' AND id_operacion LIKE '$id_operacion' AND estado = '0';");
            $sql->bindParam(":fecha_inicio", $fecha_inicio);
            $sql->bindParam(":fecha_final", $fecha_final);
            $sql->bindParam(":id_vehiculo", $id_vehiculo);
            $sql->bindParam(":id_operacion", $id_operacion);
            $sql->execute();
            while ($filas1 = $sql->fetch(PDO::FETCH_ASSOC)) {
                  $this->total1[] = $filas1;
            }
            return $this->total1; 
         
    }

    public function valorTotalFiltro($fecha_inicio, $fecha_final, $id_vehiculo, $id_operacion){


            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT SUM(precio) AS total FROM detalles WHERE fecha >= '$fecha_inicio' AND fecha <= '$fecha_final' AND id_vehiculo LIKE '$id_vehiculo' AND id_operacion LIKE '$id_operacion' AND estado = '1';");
            $sql->bindParam(":fecha_inicio", $fecha_inicio);
            $sql->bindParam(":fecha_final", $fecha_final);
            $sql->bindParam(":id_vehiculo", $id_vehiculo);
            $sql->bindParam(":id_operacion", $id_operacion);
            $sql->execute();
            while ($filas1 = $sql->fetch(PDO::FETCH_ASSOC)) {
                  $this->total[] = $filas1;
            }
            return $this->total; 
         
    }

    public function eliminar($id_detalle){
          try {
            $con = Conexion::conectar();
            $sql = $con->prepare("DELETE FROM detalles_operaciones WHERE id_detalle = :id_detalle");
            $sql->bindParam(':id_detalle', $id_detalle);
            $sql->execute();
    
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }

     public function actualizarDetalle($id_detalle, $id_operacion, $id_vehiculo, $fecha, $precio){
        try {
            $con = Conexion::conectar();
            $sql = $con->prepare("UPDATE detalles_operaciones SET id_operacion = :id_operacion, id_vehiculo = :id_vehiculo, fecha = :fecha, precio = :precio WHERE id_detalle = :id_detalle");
            
            $sql->bindParam(":id_operacion", $id_operacion);
            $sql->bindParam(":id_vehiculo", $id_vehiculo);
            $sql->bindParam(":fecha", $fecha);
            $sql->bindParam(":precio", $precio);
            $sql->bindParam(":id_detalle", $id_detalle);

            $sql->execute();

            /*echo "UPDATE detalles_operaciones SET id_operacion = '$id_operacion', id_vehiculo = '$id_vehiculo', fecha = '$fecha', precio = '$precio' WHERE id_detalle = '$id_detalle'";*/


        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

    public function listarPorId($id_detalle){
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM detalles_operaciones WHERE id_detalle = :id_detalle");
        $sql->bindParam(':id_detalle', $id_detalle);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $this->listarId[] = $filas;
        }
        return $this->listarId;
    }

    public function cambiarEstadoDetalle($id_detalle, $novedad){
        $con = Conexion::conectar();
        $sql = $con->prepare("UPDATE detalles_operaciones SET estado = 0, novedad =  :novedad WHERE id_detalle = :id_detalle ");
        $sql->bindParam(":novedad", $novedad);
        $sql->bindParam(":id_detalle", $id_detalle);
        $sql->execute();
        if ($sql) {
            header("Location: ../Vista/consultar.php");       
        }
    }

    public function notificarFechaEjecucion(){

        $fechaEjecucion = array();
        $fecha = strtotime('+3 days', strtotime(date('Y-m-d')));
        $notificarFecha = date('Y-m-d', $fecha);

        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM vehiculos AS v INNER JOIN detalles AS d ON d.id_vehiculo = v.id INNER JOIN operaciones AS o ON d.id_operacion = o.id_operacion WHERE d.fecha <= '$notificarFecha' AND d.estado = '1' ORDER BY d.fecha;");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $fechaEjecucion[] = $filas;
        }
        return $fechaEjecucion;
    }

    public function filtrarPDF($fecha_inicio, $fecha_final){

        $filtrarPDF = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT v.*, d.*, o.* FROM detalles_operaciones AS d INNER JOIN vehiculos AS v
                              ON v.id_vehiculo = d.id_vehiculo INNER JOIN operaciones AS o ON d.id_operacion = 
                              o.id_operacion WHERE d.fecha >= :fecha_inicio AND d.fecha <= :fecha_final AND d.estado = 1 ");
        $sql->bindParam(":fecha_inicio", $fecha_inicio);
        $sql->bindParam(":fecha_final", $fecha_final);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $filtrarPDF[] = $filas;
        }
           return $filtrarPDF; 
    }

    public function valorTotalFiltroPDF($fecha_inicio, $fecha_final){

            $precioTotal = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT SUM(precio) AS total FROM detalles_operaciones WHERE fecha >= :fecha_inicio AND fecha <= :fecha_final AND estado = 1 ");
            $sql->bindParam(":fecha_inicio", $fecha_inicio);
            $sql->bindParam(":fecha_final", $fecha_final);
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                  $precioTotal[] = $filas;
            }
            return $precioTotal; 
         
    }

}
 ?>