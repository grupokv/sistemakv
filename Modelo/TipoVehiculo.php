<?php 
require_once("Conexion/conexionBD.php");
/**
 * 
 */
class TipoVehiculo
{
	
	public function listar(){
		$listar = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM tipos_vehiculos");
		$sql->execute();

		while ($filas= $sql->fetch(PDO::FETCH_ASSOC)) {
			$listar[] = $filas;
		}
		return $listar;
	}

	public function listarPorId($id_tipo){

		$TipoPorId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM tipos_vehiculos WHERE id_tipo_vehiculo = :id_tipo");
		$sql->bindParam("id_tipo", $id_tipo);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$TipoPorId[] = $filas;
		}

		return $TipoPorId;
	}

}
 ?>