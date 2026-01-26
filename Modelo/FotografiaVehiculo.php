<?php 

require_once 'Conexion/conexionBD.php';
/**
 * 
 */
class FotografiaVehiculo{
	
	public function listarPorIdVehiculo($id_vehiculo){
		$listarFotos = array();
		$con = Conexion::Conectar();
		$sql = $con->prepare("SELECT * FROM fotografias_vehiculos WHERE id_vehiculo = :id_vehiculo");
		$sql->bindParam(":id_vehiculo", $id_vehiculo);

		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarFotos[] =  $filas;
		}

		return $listarFotos;
	}

	public function registrar($id_vehiculo, $fotografia_frontal, $fotografia_trasera, $fotografia_lateral_izq, $fotografia_lateral_der){
		try {
			$con = Conexion::Conectar();
			$sql = $con->prepare("INSERT INTO fotografias_vehiculos (id_vehiculo, fotografia_frontal, fotografia_trasera, fotografia_lateral_izq, fotografia_lateral_der) VALUES(:id_vehiculo, :fotografia_frontal, :fotografia_trasera , :fotografia_lateral_izq, :fotografia_lateral_der); ");
			$sql->bindParam(":id_vehiculo", $id_vehiculo);
			$sql->bindParam(":fotografia_frontal", $fotografia_frontal);
			$sql->bindParam(":fotografia_trasera", $fotografia_trasera);
			$sql->bindParam(":fotografia_lateral_izq", $fotografia_lateral_izq);
			$sql->bindParam(":fotografia_lateral_der", $fotografia_lateral_der);

			$sql->execute();


			//echo "INSERT INTO fotografias_vehiculos (id_vehiculo, fotografia_frontal, fotografia_trasera, fotografia_lateral_izq, fotografia_lateral_der) VALUES('$id_vehiculo', '$fotografia_frontal', '$fotografia_trasera' , '$fotografia_lateral_izq', '$fotografia_lateral_der');";
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function actualizar($id_fotografia, $id_vehiculo, $fotografia_frontal, $fotografia_trasera, $fotografia_lateral_izq, $fotografia_lateral_der){
		try {
			$con = Conexion::Conectar();
			$sql = $con->prepare("UPDATE fotografias_vehiculos SET id_vehiculo = :id_vehiculo, fotografia_frontal = :fotografia_frontal, fotografia_trasera = :fotografia_trasera, fotografia_lateral_izq = :fotografia_lateral_izq,  fotografia_lateral_der = :fotografia_lateral_der WHERE id_fotografia = :id_fotografia ");
			$sql->bindParam(":id_fotografia", $id_fotografia);
			$sql->bindParam(":id_vehiculo", $id_vehiculo);
			$sql->bindParam(":fotografia_frontal", $fotografia_frontal);
			$sql->bindParam(":fotografia_trasera", $fotografia_trasera);
			$sql->bindParam(":fotografia_lateral_izq", $fotografia_lateral_izq);
			$sql->bindParam(":fotografia_lateral_der", $fotografia_lateral_der);

			$sql->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function actualizarPorFotografia($id_vehiculo, $nombre_fotografia, $fotografia_documento){
		try {
			$con = Conexion::Conectar();
			$sql = $con->prepare("UPDATE fotografias_vehiculos SET :nombre_fotografia = :fotografia_documento WHERE id_vehiculo = :id_vehiculo ");

			$sql->bindParam(":id_vehiculo", $id_vehiculo);
			$sql->bindParam(":nombre_fotografia", $nombre_fotografia);
			$sql->bindParam(":fotografia_documento", $fotografia_documento);

			$sql->execute();

			//echo "UPDATE fotografias_vehiculos SET '$nombre_fotografia' = '$fotografia_documento' WHERE id_vehiculo = '$id_vehiculo' ";


		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

}


?>