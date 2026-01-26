<?php 
require_once("Conexion/conexionBD.php");
/**
 * 
 */
class Categoria_Mantenimiento
{
	
	public function listar(){

		$cat = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM categoria_mantenimiento");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$cat[] = $filas;
		}

		return $cat;
	}

	public function listarPorId($id){

		$catPorId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM categoria_mantenimiento WHERE id_categoria = :id");
		$sql->bindParam("id", $id);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$catPorId[] = $filas;
		}

		return $catPorId;
	}
		
	public function registrar($nombre_cat){
	    try {
	        $con = Conexion::conectar();
	        $sql = $con->prepare("INSERT INTO categoria_mantenimiento(detalle_categoria) VALUES(:nombre_cat)");
	        $sql->bindParam(":nombre_cat", $nombre_cat);
	        $sql->execute();
	        return $id_categoria = $con->lastInsertId();

	    } catch (Exception $e) {
	        echo $e->getMessage();
	    }
	}

	  public function actualizar($nombre_cat, $id_cat){
	     try {
	        $con = Conexion::conectar();
	        $sql = $con->prepare("UPDATE categoria_mantenimiento SET detalle_categoria = :nombre_cat WHERE id_categoria = :id_cat");
	        $sql->bindParam("nombre_cat", $nombre_cat);
	        $sql->bindParam("id_cat", $id_cat);

	        $sql->execute();
	        
	     } catch (Exception $e) {
	         echo $e->getMessage();
	     }
	  }
}

?>