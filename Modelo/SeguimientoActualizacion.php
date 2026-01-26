<?php 
require_once 'Conexion/conexionBD.php';
/**
 * 
 */
class Seguimiento_Actualizacion
{

	public function listar(){
		$seguimiento = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM seguimientos_actualizaciones_documentos WHERE estado != 'E' ");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$seguimiento[] = $filas;
		}

		return $seguimiento;
	}

	public function listarPorEstadoPendientes(){
		$estadoPendiente = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM seguimientos_actualizaciones_documentos WHERE estado = 'P'");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$estadoPendiente[] = $filas;
		}

		return $estadoPendiente;
	}

	public function listarPorUsuarioSolicitante($id_usuario, $id_modulo){
		$usuarioSoli = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM seguimientos_actualizaciones_documentos WHERE id_usuario = $id_usuario AND id_modulo IN ($id_modulo) AND estado != 'F' AND estado != 'E' ");
		/*$sql->bindParam(":id_usuario", $id_usuario);
		$sql->bindParam(":id_modulo", $id_modulo);*/
		$sql->execute();

		//echo "SELECT * FROM seguimientos_actualizaciones_documentos WHERE id_usuario = $id_usuario AND id_modulo IN ($id_modulo)";

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$usuarioSoli[] = $filas;
		}

		return $usuarioSoli;
	}

	public function listarPorId($id_seguimiento){
		$seguimientoId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM seguimientos_actualizaciones_documentos WHERE id_seguimiento = :id_seguimiento ");
		$sql->bindParam(":id_seguimiento", $id_seguimiento);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$seguimientoId[] = $filas;
		}

		return $seguimientoId;
	}

	public function registrar($id_usuario, $id_modulo, $columnas, $estado, $documento, $nueva_fecha_vencimiento, $id_registro, $id_revision){

		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO seguimientos_actualizaciones_documentos(id_usuario, id_modulo, columnas, estado, documento, nueva_fecha_vencimiento, id_registro, id_revision) VALUES(:id_usuario, :id_modulo, :columnas, :estado, :documento, :nueva_fecha_vencimiento, :id_registro, :id_revision);");
			$sql->bindParam(":id_usuario", $id_usuario);
			$sql->bindParam(":id_modulo", $id_modulo);
			$sql->bindParam(":columnas", $columnas);
			$sql->bindParam(":estado", $estado);
			$sql->bindParam(":documento", $documento);
			$sql->bindParam(":nueva_fecha_vencimiento", $nueva_fecha_vencimiento);
			$sql->bindParam(":id_registro", $id_registro);
			$sql->bindParam(":id_revision", $id_revision);
			
			//echo "INSERT INTO seguimientos_actualizaciones_documentos(id_usuario, id_modulo, columnas, estado, documento, nueva_fecha_vencimiento, id_registro, id_revision) VALUES('$id_usuario', '$id_modulo', '$columnas', '$estado', '$documento', '$nueva_fecha_vencimiento', '$id_registro', '$id_revision');";
			
			$sql->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		
	}

	public function actualizarEstado($id_seguimiento, $estado, $novedad_rechazo){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE seguimientos_actualizaciones_documentos SET estado = :estado, novedad_rechazo = :novedad_rechazo WHERE id_seguimiento = :id_seguimiento");
			$sql->bindParam(":id_seguimiento", $id_seguimiento);
			$sql->bindParam(":estado", $estado);
			$sql->bindParam(":novedad_rechazo", $novedad_rechazo);
			$sql->execute();

			if ($sql) {
				header("Location: ../Vista/seguimientoActualizaciones.php");
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function eliminarNotificacionSeguimiento($id_seguimiento, $estado){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE seguimientos_actualizaciones_documentos SET estado = :estado WHERE id_seguimiento = :id_seguimiento");
			$sql->bindParam(":id_seguimiento", $id_seguimiento);
			$sql->bindParam(":estado", $estado);
			$sql->execute();

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	
}
 ?>