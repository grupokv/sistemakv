<?php
require_once("Conexion/conexionBD.php");
class DestinoCliente
{
	
	
	public function listar(){
		$listarts = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM destino_cliente");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarts[] = $filas;
		}

		return $listarts;
	}


	public function listarPorId($id){

		$TipoPorId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM destino_cliente WHERE id_destino = :id");
		$sql->bindParam("id", $id);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$TipoPorId[] = $filas;
		}
		return $TipoPorId;
	}
	public function listarPorCliente($id_cliente){

		$TipoPorId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM destino_cliente WHERE id_cliente = :id_cliente");
		$sql->bindParam("id_cliente", $id_cliente);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$TipoPorId[] = $filas;
		}
		return $TipoPorId;
	}

	public function listarPorCentroCosto($id_centro_costo){

		$TipoPorId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM destino_cliente WHERE id_centro_costo = :id_centro_costo");
		$sql->bindParam("id_centro_costo", $id_centro_costo);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$TipoPorId[] = $filas;
		}
		return $TipoPorId;
	}

	public function registrar($detalle, $id_cliente, $id_centro_costo){            
		try {                
		$con = Conexion::conectar();                
		$sql = $con->prepare("INSERT INTO destino_cliente (detalle, id_cliente, id_centro_costo) VALUES(:detalle, :id_cliente, :id_centro_costo)");                
		$sql->bindParam(":detalle", $detalle);		
		$sql->bindParam(":id_centro_costo", $id_centro_costo);                
		$sql->bindParam(":id_cliente", $id_cliente);                
		$sql->execute();                                
		return $id_cargo = $con->lastInsertId();            
		} catch (Exception $e) {                
		echo $e->getMessage();            
		}                        
	}        

	public function actualizar($id, $detalle, $id_cliente, $id_centro_costo){            
		try {                
		$con = Conexion::conectar();                
		$sql = $con->prepare("UPDATE destino_cliente SET detalle = '$detalle', id_centro_costo = '$id_centro_costo', id_cliente = '$id_cliente' WHERE id_destino = '$id' ");                
		$sql->bindParam(":detalle", $detalle);		
		$sql->bindParam(":id_centro_costo", $id_centro_costo);                
		$sql->bindParam(":id_cliente", $id_cliente);		
		$sql->bindParam(":id", $id);                
		$sql->execute();                            
		} catch (Exception $e) {                
			echo $e->getMessage();            
		}                       
	}
}
?>