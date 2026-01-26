<?php 
require_once("Conexion/conexionBD.php");

/**
 * 
 */
class TipoServicioMantenimiento
{
	
	public function listar(){
		$listarts = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM tipo_servicio_mantenimiento");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarts[] = $filas;
		}

		return $listarts;
	}

	public function listarPorId($id_tipo){

		$TipoPorId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM tipo_servicio_mantenimiento WHERE id_tipo_servicio = :id_tipo");
		$sql->bindParam("id_tipo", $id_tipo);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$TipoPorId[] = $filas;
		}

		return $TipoPorId;
	}

}
 ?>