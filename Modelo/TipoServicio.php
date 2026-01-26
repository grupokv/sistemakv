<?php 
require_once("Conexion/conexionBD.php");

/**
 * 
 */
class TipoServicio
{
	
	
	public function listar(){
		$listarts = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM tipos_servicios");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarts[] = $filas;
		}

		return $listarts;
	}


	public function listarPorId($id_tipo){

		$TipoPorId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM tipos_servicios WHERE id_tipo_servicio = :id_tipo");
		$sql->bindParam("id_tipo", $id_tipo);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$TipoPorId[] = $filas;
		}
		return $TipoPorId;
	}

	public function listarCliente(){
		$listarts = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM tipo_servicio_cliente");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarts[] = $filas;
		}

		return $listarts;
	}


	public function listarPorIdCliente($id_tipo){

		$TipoPorId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM tipo_servicio_cliente WHERE id_tipo_servicio = :id_tipo");
		$sql->bindParam("id_tipo", $id_tipo);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$TipoPorId[] = $filas;
		}
		return $TipoPorId;
	}

}
 ?>