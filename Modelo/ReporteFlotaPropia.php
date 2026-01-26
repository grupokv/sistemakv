<?php 
require_once("Conexion/conexionBD.php");
/**
 * 
 */
class ReporteFlotaPropia
{
	
	public function listarPorVehiculo($id){
		$listar = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM reporte_fp WHERE id_vehiculo = :id");
		$sql->bindParam("id", $id);
		$sql->execute();

		while ($filas= $sql->fetch(PDO::FETCH_ASSOC)) {
			$listar[] = $filas;
		}
		return $listar;
	}

}
 ?>