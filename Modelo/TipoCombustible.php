<?php 
require_once("Conexion/conexionBD.php");

/**
 * 
 */
class TipoCombustible
{
	
	
	public function listar(){
		$listarts = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM tipo_combustible");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarts[] = $filas;
		}
		return $listarts;
	}


	public function listarPorId($id_tipo){

		$TipoPorId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM tipo_combustible WHERE id_tipo = :id_tipo");
		$sql->bindParam("id_tipo", $id_tipo);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$TipoPorId[] = $filas;
		}
		return $TipoPorId;
	}

	public function registrar($detalle){
      try {
          $con = Conexion::conectar();
          $sql = $con->prepare("INSERT INTO tipo_combustible (detalle) VALUES(:detalle)");
          $sql->bindParam(":detalle", $detalle);
          $sql->execute();

          return $id = $con->lastInsertId();

      } catch (Exception $e) {
          echo $e->getMessage();
      }
  }
  
  public function actualizar($id,$detalle){
      try {
          $con = Conexion::conectar();
          $sql = $con->prepare("UPDATE tipo_combustible set detalle = :detalle WHERE id_tipo = :id");
          $sql->bindParam(":detalle", $detalle);
          $sql->bindParam(":id", $id);
          $sql->execute();

      } catch (Exception $e) {
          echo $e->getMessage();
      }
  }
}
 ?>