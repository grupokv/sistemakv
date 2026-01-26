<?php 

require_once 'Conexion/conexionBD.php';

class ReferenciasPropietario
{

	public function listarPorIdVehiculo($id_vehiculo){
		$listarPorIdVehiculo = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM referencias_propietarioVehiculo WHERE id_vehiculo = :id_vehiculo AND estado = 'V'");
		$sql->bindParam(":id_vehiculo", $id_vehiculo);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarPorIdVehiculo[] = $filas;
		}

		return $listarPorIdVehiculo;
	}


	public function listarPorTipoReferenciaComercial($id_vehiculo){
		$listarComercial = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM referencias_propietarioVehiculo WHERE id_vehiculo = :id_vehiculo AND tipo_referencia = 'COMERCIAL' AND estado = 'V'");
		$sql->bindParam(":id_vehiculo", $id_vehiculo);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarComercial[] = $filas;
		}

		return $listarComercial;
	}

	public function listarPorTipoReferenciaLaboral($id_vehiculo){
		$listarLaboral = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM referencias_propietarioVehiculo WHERE id_vehiculo = :id_vehiculo AND tipo_referencia = 'LABORAL' AND estado = 'V'");
		$sql->bindParam(":id_vehiculo", $id_vehiculo);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarLaboral[] = $filas;
		}

		return $listarLaboral;
	}

	public function listarPorTipoReferenciaFamiliar($id_vehiculo){
		$listarFamiliar = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM referencias_propietarioVehiculo WHERE id_vehiculo = :id_vehiculo AND tipo_referencia = 'FAMILIAR' AND estado = 'V'");
		$sql->bindParam(":id_vehiculo", $id_vehiculo);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarFamiliar[] = $filas;
		}

		return $listarFamiliar;
	}

	public function listarPorTipoReferenciaPersonal($id_vehiculo){
		$listarPersonal = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM referencias_propietarioVehiculo WHERE id_vehiculo = :id_vehiculo AND tipo_referencia = 'PERSONAL' AND estado = 'V'");
		$sql->bindParam(":id_vehiculo", $id_vehiculo);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarPersonal[] = $filas;
		}

		return $listarPersonal;
	}

	public function listarPorEstadoVisible(){
		$listarPorEstadoVisible = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM referencias_propietarioVehiculo WHERE estado = 'V'");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarPorEstadoVisible[] = $filas;
		}

		return $listarPorEstadoVisible;
	}


	public function listarPorEstadoNoVisible(){
		$listarPorEstadoNoVisible = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM referencias_propietarioVehiculo WHERE estado = 'NV'");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarPorEstadoNoVisible[] = $filas;
		}

		return $listarPorEstadoNoVisible;
	}

	public function registrar($id_vehiculo, $tipo_referencia, $nombre_referencia, $telefono_referencia, $direccion_referencia){

		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO referencias_propietarioVehiculo(id_vehiculo, tipo_referencia, nombre_referencia, telefono_referencia, direccion_referencia, estado)  VALUES(:id_vehiculo, :tipo_referencia, :nombre_referencia, :telefono_referencia, :direccion_referencia, 'V')");
			$sql->bindParam(':id_vehiculo', $id_vehiculo);
			$sql->bindParam(':tipo_referencia', $tipo_referencia);
			$sql->bindParam(':nombre_referencia', $nombre_referencia);
			$sql->bindParam(':telefono_referencia', $telefono_referencia);
			$sql->bindParam(':direccion_referencia', $direccion_referencia);
			$sql->execute();
/*
			echo "INSERT INTO referencias_propietarioVehiculo(id_vehiculo, tipo_referencia, nombre_referencia, telefono_referencia, direccion_referencia, estado)  VALUES('$id_vehiculo', '$tipo_referencia', '$nombre_referencia', '$telefono_referencia', '$direccion_referencia', 'V')";*/
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function actualizar($id_referencia, $id_vehiculo, $tipo_referencia, $nombre_referencia, $telefono_referencia, $direccion_referencia, $estado){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE referencias_propietarioVehiculo SET id_vehiculo = :id_vehiculo, tipo_referencia = :tipo_referencia, nombre_referencia = :nombre_referencia, telefono_referencia = :telefono_referencia, direccion_referencia = :direccion_referencia, estado = :estado WHERE id_referencia = :id_referencia");
			$sql->bindParam(':id_referencia', $id_referencia);
			$sql->bindParam(':id_vehiculo', $id_vehiculo);
			$sql->bindParam(':tipo_referencia', $tipo_referencia);
			$sql->bindParam(':nombre_referencia', $nombre_referencia);
			$sql->bindParam(':telefono_referencia', $telefono_referencia);
			$sql->bindParam(':direccion_referencia', $direccion_referencia);
			$sql->bindParam(':estado', $estado);
			$sql->execute();

			/*echo "UPDATE referencias_propietarioVehiculo SET id_vehiculo = '$id_vehiculo', tipo_referencia = '$tipo_referencia', nombre_referencia = '$nombre_referencia', telefono_referencia = '$telefono_referencia', direccion_referencia = '$direccion_referencia', estado = '$estado' WHERE id_referencia = '$id_referencia'";*/
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	
}
 ?>