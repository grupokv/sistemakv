<?php 
require_once 'BD/conexion.php';
/**
 * 
 */
class Acta
{
	public function listarTodos(){
		$listarTodos = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM acta");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarTodos [] = $filas;
		}
		return $listarTodos ;
	}


	public function listarPorId($id_acta){
		$listarActaPorId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM acta WHERE id_acta = :id_acta");
		$sql->bindParam(":id_acta" , $id_acta);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarActaPorId[] = $filas;
		}
		return $listarActaPorId;
	}

	public function listarActasPorUsuario($id_responsable){
		$listarActaPorUsuario = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM acta WHERE id_responsable = :id_responsable");
		$sql->bindParam(":id_responsable" , $id_responsable);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarActaPorUsuario[] = $filas;
		}
		return $listarActaPorUsuario;
	}

	public function registrarActas($titulo_reunion, $fecha_acta, $hora_inicial_acta, $hora_final_acta, $id_responsable, $fecha_creacion, $hora_creacion){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO acta(titulo_reunion, fecha_acta, hora_inicial_acta, hora_final_acta, id_responsable, fecha_creacion, hora_creacion) VALUES(:titulo_reunion, :fecha_acta ,:hora_inicial_acta , :hora_final_acta, :id_responsable, :fecha_creacion, :hora_creacion)");
			$sql->bindParam(":titulo_reunion", $titulo_reunion);
			$sql->bindParam(":fecha_acta", $fecha_acta);
			$sql->bindParam(":hora_inicial_acta", $hora_inicial_acta);
			$sql->bindParam(":hora_final_acta", $hora_final_acta);
			$sql->bindParam(":id_responsable", $id_responsable);
			$sql->bindParam(":fecha_creacion", $fecha_creacion);
			$sql->bindParam(":hora_creacion", $hora_creacion);
			$sql->execute();
			/*echo "INSERT INTO acta(titulo_reunion, fecha_acta, hora_inicial_acta, hora_final_acta, id_responsable, fecha_creacion, hora_creacion) VALUES('$titulo_reunion', '$fecha_acta' ,'$hora_inicial_acta' , '$hora_final_acta', '$id_responsable', '$fecha_creacion', '$hora_creacion')";
*/
			if ($sql) {
				$id_acta = $con->lastInsertId();
				header('Location: ../Vista/registrarInvitados.php?id_acta=' .$id_acta);
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function registrarInvitadosActas($id_acta, $id_invitado){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO acta_invitados(id_acta, id_invitado) VALUES(:id_acta, :id_invitado)");
			$sql->bindParam(":id_acta", $id_acta);
			$sql->bindParam(":id_invitado", $id_invitado);
			$sql->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function listarInvitadosPorActa($id_acta){
		$listarInvitados = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM acta_invitados WHERE id_acta = :id_acta");
		$sql->bindParam(":id_acta" , $id_acta);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarInvitados[] = $filas;
		}
		return $listarInvitados;
	}
}
 ?>