<?php 
require_once("Conexion/conexionBD.php");
/**
 * 
 */
class Ciudad
{
	
	public function listar(){

		$ciudades = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM ciudades ORDER BY ciudad ASC");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$ciudades[] = $filas;
		}

		return $ciudades;
	}

	public function listarCiudadPorId($id_ciudad){

		$ciudaPorId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM ciudades WHERE id_ciudad = :id_ciudad");
		$sql->bindParam("id_ciudad", $id_ciudad);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$ciudaPorId[] = $filas;
		}

		return $ciudaPorId;
	}

	public function buscarPorNombre($nombre_ciudad,$id_departamento, $id_pais){
     $listar = array();
       $con = Conexion::conectar();
       $sql = $con->prepare("SELECT * FROM ciudades WHERE ciudad = ? and id_departamento = ? and id_pais = ?");
       $sql->bindParam(1, $nombre_ciudad);
       $sql->bindParam(2, $id_departamento);
       $sql->bindParam(3, $id_pais);
       $sql->execute();

       while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
       }

       return $listar;
	  }
		
	  public function registrar($nombre_ciudad,$id_departamento,$id_pais){
	      try {
	          $con = Conexion::conectar();
	          $sql = $con->prepare("INSERT INTO ciudades(id_departamento, id_pais, ciudad) VALUES(:id_departamento, :id_pais, :nombre_ciudad)");
	          $sql->bindParam(":id_departamento", $id_departamento);
	          $sql->bindParam(":id_pais", $id_pais);
	          $sql->bindParam(":nombre_ciudad", $nombre_ciudad);

	          $sql->execute();

	          return $id_area = $con->lastInsertId();

	      } catch (Exception $e) {
	          echo $e->getMessage();
	      }
	  }

	  public function actualizar($nombre_ciudad, $id_departamento, $id_pais, $id_ciudad){
	     try {
	        $con = Conexion::conectar();
	        $sql = $con->prepare("UPDATE ciudades SET id_departamento = :id_departamento, id_pais = :id_pais, ciudad = :nombre_ciudad WHERE id_ciudad = :id_ciudad");
	        $sql->bindParam("nombre_ciudad", $nombre_ciudad);
	        $sql->bindParam("id_pais", $id_pais);
	        $sql->bindParam("id_departamento", $id_departamento);
	        $sql->bindParam("id_ciudad", $id_ciudad);

	        $sql->execute();
	        
	     } catch (Exception $e) {
	         echo $e->getMessage();
	     }
	  }
}

?>