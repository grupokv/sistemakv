<?php 
require_once("Conexion/conexionBD.php");
/**
 * 
 */
class Convenio{

	public function listar($id_convenio){
		$conveniosId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM convenios AS c INNER JOIN vehiculos AS v ON c.id_vehiculo = v.id_vehiculo INNER JOIN empresas AS e ON c.id_empresa = e.id_empresa INNER JOIN tipos_vehiculos AS tv ON v.id_tipo_vehiculo = tv.id_tipo_vehiculo INNER JOIN usuarios AS u ON v.id_propietario = u.id_usuario INNER JOIN clientes AS cl ON c.id_cliente = cl.id_cliente WHERE id_convenio = :id_convenio");
		$sql->bindParam(":id_convenio", $id_convenio);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$conveniosId[] = $filas;
		}

		return $conveniosId;
	}

	public function listarId($id_convenio){
		$cId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM convenios WHERE id_convenio = :id_convenio");
		$sql->bindParam(":id_convenio", $id_convenio);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$cId[] = $filas;
		}

		return $cId;
	}

	public function listarConveniosActivosPorVehiculo($id_vehiculo, $fecha){
		$cId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM convenios WHERE id_vehiculo = :id_vehiculo AND (fecha_inicio_convenio <= :fecha AND fecha_final_convenio >= :fecha)");
		$sql->bindParam(":id_vehiculo", $id_vehiculo);
		$sql->bindParam(":fecha", $fecha);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$cId[] = $filas;
		}

		return $cId;
	}

	public function listarTodos(){
		$listar = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM convenios AS c INNER JOIN empresas AS e ON c.id_empresa = e.id_empresa INNER JOIN clientes_convenios AS cc ON c.id_cliente = cc.id_cliente");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listar[] = $filas;
		}

		return $listar;
	}


	
	public function registrar($id_empresa, $fecha_inicio_convenio, $fecha_final_convenio, $id_ciudad_convenio,$id_vehiculo, $id_conductor, $id_contrato, $objeto, $id_cliente, $fecha_creacion_convenio,$hora_creacion_convenio, $id_responsable){

		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO convenios(id_empresa, fecha_inicio_convenio, fecha_final_convenio, id_ciudad_convenio, id_vehiculo, id_conductor, id_contrato, objeto, id_cliente, fecha_creacion_convenio, hora_creacion_convenio, id_responsable, tipo_registro_conv) VALUES (:id_empresa, :fecha_inicio_convenio, :fecha_final_convenio, :id_ciudad_convenio, :id_vehiculo, :id_conductor, :id_contrato, :objeto, :id_cliente, :fecha_creacion_convenio, :hora_creacion_convenio, :id_responsable, 'E')");

			$sql->bindParam(":id_empresa", $id_empresa);
			$sql->bindParam(":fecha_inicio_convenio", $fecha_inicio_convenio);
			$sql->bindParam(":fecha_final_convenio", $fecha_final_convenio);
			$sql->bindParam(":id_ciudad_convenio", $id_ciudad_convenio);
			$sql->bindParam(":id_vehiculo", $id_vehiculo);
			$sql->bindParam(":id_conductor", $id_conductor);
			$sql->bindParam(":id_contrato", $id_contrato);
			$sql->bindParam(":objeto", $objeto);
			$sql->bindParam(":id_cliente", $id_cliente);
			$sql->bindParam(":fecha_creacion_convenio", $fecha_creacion_convenio);
			$sql->bindParam(":hora_creacion_convenio", $hora_creacion_convenio);
			$sql->bindParam(":id_responsable", $id_responsable);

			$sql->execute();

			if ($sql) {
				$id_convenio = $con->lastInsertId();
				return $id_convenio;
			}

			//echo "INSERT INTO convenios(id_empresa, fecha_inicio_convenio, fecha_final_convenio, id_ciudad_convenio, id_vehiculo, id_conductor, id_contrato, id_cliente, fecha_creacion_convenio, hora_creacion_convenio, id_responsable, tipo_registro_conv) VALUES ('$id_empresa', '$fecha_inicio_convenio', '$fecha_final_convenio', '$id_ciudad_convenio', '$id_vehiculo', '$id_conductor', '$id_contrato', '$id_cliente', '$fecha_creacion_convenio', '$hora_creacion_convenio', '$id_responsable', 'E')";

		} catch (Exception $e) {
			echo $e->getMessage();
		}
		
	}

	public function registrarCargaConvenio($doc_convenio, $id_empresa, $fecha_inicio_convenio, $fecha_final_convenio, $id_ciudad_convenio, $id_vehiculo, $id_cliente, $fecha_creacion_convenio, $hora_creacion_convenio, $id_responsable){

		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO convenios(doc_convenio, id_empresa, fecha_inicio_convenio, fecha_final_convenio, id_ciudad_convenio, id_vehiculo, id_cliente, fecha_creacion_convenio, hora_creacion_convenio, id_responsable, tipo_registro_conv) VALUES (:doc_convenio, :id_empresa, :fecha_inicio_convenio, :fecha_final_convenio, :id_ciudad_convenio, :id_vehiculo, :id_cliente, :fecha_creacion_convenio, :hora_creacion_convenio, :id_responsable, 'T')");

			$sql->bindParam(":doc_convenio", $doc_convenio);
			$sql->bindParam(":id_empresa", $id_empresa);
			$sql->bindParam(":fecha_inicio_convenio", $fecha_inicio_convenio);
			$sql->bindParam(":fecha_final_convenio", $fecha_final_convenio);
			$sql->bindParam(":id_ciudad_convenio", $id_ciudad_convenio);
			$sql->bindParam(":id_vehiculo", $id_vehiculo);
			$sql->bindParam(":id_cliente", $id_cliente);
			$sql->bindParam(":fecha_creacion_convenio", $fecha_creacion_convenio);
			$sql->bindParam(":hora_creacion_convenio", $hora_creacion_convenio);
			$sql->bindParam(":id_responsable", $id_responsable);

			$sql->execute();

			if ($sql) {
				$id_convenio = $con->lastInsertId();
				return $id_convenio;
			}

			

		} catch (Exception $e) {
			echo $e->getMessage();
		}
		
	}

	public function actualizar($id_convenio, $id_empresa, $fecha_inicio_convenio, $fecha_final_convenio, $id_ciudad_convenio, $id_vehiculo, $id_conductor, $id_contrato, $objeto, $id_cliente, $fecha_creacion_convenio, $hora_creacion_convenio, $id_responsable){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE convenios SET id_empresa = :id_empresa, fecha_inicio_convenio = :fecha_inicio_convenio, fecha_final_convenio = :fecha_final_convenio, id_ciudad_convenio = :id_ciudad_convenio, id_vehiculo = :id_vehiculo, id_conductor = :id_conductor, id_contrato = :id_contrato, objeto = :objeto, id_cliente = :id_cliente, fecha_creacion_convenio = :fecha_creacion_convenio, hora_creacion_convenio = :hora_creacion_convenio, id_responsable = :id_responsable WHERE id_convenio = :id_convenio");

			$sql->bindParam(":id_convenio", $id_convenio);
			$sql->bindParam(":id_empresa", $id_empresa);
			$sql->bindParam(":fecha_inicio_convenio", $fecha_inicio_convenio);
			$sql->bindParam(":fecha_final_convenio", $fecha_final_convenio);
			$sql->bindParam(":id_ciudad_convenio", $id_ciudad_convenio);
			$sql->bindParam(":id_vehiculo", $id_vehiculo);
			$sql->bindParam(":id_conductor", $id_conductor);
			$sql->bindParam(":id_contrato", $id_contrato);
			$sql->bindParam(":objeto", $objeto);
			$sql->bindParam(":id_cliente", $id_cliente);
			$sql->bindParam(":fecha_creacion_convenio", $fecha_creacion_convenio);
			$sql->bindParam(":hora_creacion_convenio", $hora_creacion_convenio);
			$sql->bindParam(":id_responsable", $id_responsable);
			$sql->execute();

			//echo "UPDATE convenios SET id_empresa = '$id_empresa', fecha_inicio_convenio = '$fecha_inicio_convenio', fecha_final_convenio = '$fecha_final_convenio', id_ciudad_convenio = '$id_ciudad_convenio', id_vehiculo = '$id_vehiculo', id_conductor = '$id_conductor', id_contrato = '$id_contrato', objeto = '$objeto', id_cliente = '$id_cliente', fecha_creacion_convenio = '$fecha_creacion_convenio', hora_creacion_convenio = '$hora_creacion_convenio', id_responsable = '$id_responsable' WHERE id_convenio = '$id_convenio' ";

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}


	public function cargarConvenioFirmado($id_convenio, $doc_convenio){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE convenios SET doc_convenio = :doc_convenio WHERE id_convenio = :id_convenio");

			$sql->bindParam(":id_convenio", $id_convenio);
			$sql->bindParam(":doc_convenio", $doc_convenio);
			$sql->execute();

			if ($sql) {
				return 1;
			}else{
				return 0;
			}

			//echo "UPDATE convenios SET doc_convenio = '$doc_convenio' WHERE id_convenio = '$id_convenio' ";

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}


}
 ?>