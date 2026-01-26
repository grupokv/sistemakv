<?php 
require_once 'BD/conexion.php';
/**
 * 
 */
class Agenda
{

	public function listarAgendaPorIdActa($id_acta){
		$listarPorId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM agenda WHERE id_acta = :id_acta");
		$sql->bindParam(":id_acta" , $id_acta);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarPorId[] = $filas;
		}
		return $listarPorId;
	}

	public function registrarAgenda($id_acta, $tema, $descripcion){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO agenda(id_acta, tema, descripcion) VALUES(:id_acta, :tema, :descripcion)");
			$sql->bindParam(":tema", $tema);
			$sql->bindParam(":descripcion", $descripcion);
			$sql->bindParam(":id_acta", $id_acta);
			$sql->execute();

			if ($sql) {
				header('Location: ../Vista/registrarSituacion.php?id_acta=' .$id_acta);
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}	

	public function registrarSituacion($id_acta, $descripcion_situacion, $actividades_soluciones, $id_responsable, $id_reportado_a, $fecha_limite){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO situaciones(id_acta, descripcion_situacion, actividades_soluciones, id_responsable, id_reportado_a, fecha_limite) VALUES(:id_acta, :descripcion_situacion, :actividades_soluciones, :id_responsable, :id_reportado_a, :fecha_limite )");
			$sql->bindParam(":id_acta", $id_acta);
			$sql->bindParam(":descripcion_situacion", $descripcion_situacion);
			$sql->bindParam(":actividades_soluciones", $actividades_soluciones);
			$sql->bindParam(":id_responsable", $id_responsable);
			$sql->bindParam(":id_reportado_a", $id_reportado_a);
			$sql->bindParam(":fecha_limite", $fecha_limite);
			$sql->execute();

			/*echo "INSERT INTO situaciones(id_acta, descripcion_situacion, actividades_soluciones, id_responsable, id_reportado_a, fecha_limite) VALUES('$id_acta','$descripcion_situacion','$actividades_soluciones','$id_responsable','$id_reportado_a', '$fecha_limite' )";*/

			if ($sql) {
				header('Location: ../Vista/mostrarInformacionActa.php');
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function listarSituacionesPorIdActa($id_acta){
		$listarSituacionesPorIdActa = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM situaciones WHERE id_acta = :id_acta");
		$sql->bindParam(":id_acta" , $id_acta);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarSituacionesPorIdActa[] = $filas;
		}
		return $listarSituacionesPorIdActa;
	}
}

 ?>