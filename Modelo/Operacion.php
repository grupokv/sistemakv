<?php 

require_once("Conexion/conexionBD.php");

class Operacion
{
	
	public $listar = array();

    public function listar(){
    	$con = Conexion::conectar();
 	    $sql = $con->query("SELECT * FROM operaciones");
	    while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
		    $this->listar[] = $filas;
	    }
	    return $this->listar;
    }


     public function registrarOperacion($nombre_operacion, $descripcion){
    	try {
    		$con = Conexion::conectar();
    	    $sql = $con->prepare("INSERT INTO operaciones(nombre_operacion, descripcion) VALUES(:nombre_operacion, :descripcion)");
            $sql->bindParam(":nombre_operacion", $nombre_operacion);
    	    $sql->bindParam(":descripcion", $descripcion);

    	    $sql->execute();
    	   
    	} catch (Exception $ex) {
    		echo $ex->getMessage();
    	}
    }

    public function eliminarOperacion($id){

        try {
            $con = Conexion::conectar();
            $sql = $con->prepare("DELETE FROM operaciones WHERE id_operacion = ?");
            $sql->bindParam(1, $id);
            $sql->execute();
            if ($sql) {
                header('Location: ../Vista/operaciones.php');
            }
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }

    public function actualizarOperacion($id, $nombre_operacion, $descripcion){
         try {
             $con = Conexion::conectar();
             $sql = $con->prepare("UPDATE operaciones SET nombre_operacion = :nombre_operacion, descripcion = :descripcion WHERE id_operacion = :id ");
             $sql->bindParam(":nombre_operacion", $nombre_operacion);
             $sql->bindParam(":descripcion", $descripcion);
             $sql->bindParam(":id", $id);
             $sql->execute();
             
         } catch (Exception $ex) {
             
         }
    }

    public function listarPorId($id_operacion){
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM operaciones WHERE id_operacion = :id_operacion ");
        $sql->bindParam(":id_operacion", $id_operacion);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $this->listarId[] = $filas;
        }
        return $this->listarId;
    }
}
 ?>