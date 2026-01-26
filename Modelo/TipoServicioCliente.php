<?php
require_once("Conexion/conexionBD.php");
class TipoServicioCliente
{
	
	
	public function listar(){
		$listarts = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM tipo_servicio_solicitud");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarts[] = $filas;
		}

		return $listarts;
	}


	public function listarPorId($id_tipo){

		$TipoPorId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM tipo_servicio_solicitud WHERE id_tipo_servicio = :id_tipo");
		$sql->bindParam("id_tipo", $id_tipo);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$TipoPorId[] = $filas;
		}
		return $TipoPorId;
	}
	public function listarPorCliente($id_cliente){

		$TipoPorId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM tipo_servicio_solicitud WHERE id_cliente = :id_cliente");
		$sql->bindParam("id_cliente", $id_cliente);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$TipoPorId[] = $filas;
		}
		return $TipoPorId;
	}
	public function registrar($detalle, $id_tipo_vehiculo, $id_cliente){            
try {                $con = Conexion::conectar();                $sql = $con->prepare("INSERT INTO tipo_servicio_solicitud (detalle, id_tipo_vehiculo, id_cliente) VALUES(:detalle, :id_tipo_vehiculo, :id_cliente)");                $sql->bindParam(":detalle", $detalle);		$sql->bindParam(":id_tipo_vehiculo", $id_tipo_vehiculo);                $sql->bindParam(":id_cliente", $id_cliente);                $sql->execute();                                return $id_cargo = $con->lastInsertId();            } catch (Exception $e) {                echo $e->getMessage();            }                        }        public function actualizar($id, $detalle, $id_tipo_vehiculo, $id_cliente){            try {                $con = Conexion::conectar();                $sql = $con->prepare("UPDATE tipo_servicio_solicitud SET detalle = '$detalle', id_tipo_vehiculo = '$id_tipo_vehiculo', id_cliente = '$id_cliente' WHERE id_tipo_servicio = '$id' ");                $sql->bindParam(":detalle", $detalle);		$sql->bindParam(":id_tipo_vehiculo", $id_tipo_vehiculo);                $sql->bindParam(":id_cliente", $id_cliente);		$sql->bindParam(":id", $id);                $sql->execute();                            } catch (Exception $e) {                echo $e->getMessage();            }                       }
}
 ?>