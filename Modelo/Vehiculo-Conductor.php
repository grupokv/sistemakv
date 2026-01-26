<?php 
require_once("Conexion/conexionBD.php");
/**
 * 
 */
class Vehiculo_Conductor
{

		public function listarPorId($id_conductor){

				$vehiculos_conductores = array();
				$con = Conexion::conectar();
				$sql = $con->prepare("SELECT * FROM vehiculos_conductores AS vc INNER JOIN vehiculos AS v ON vc.id_vehiculo = v.id_vehiculo INNER JOIN conductores AS c ON vc.id_conductor = c.id_conductor WHERE vc.id_conductor = :id_conductor");
				$sql->bindParam(':id_conductor', $id_conductor);

				$sql->execute();

				while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
					$vehiculos_conductores[] = $filas;
				}
				//echo "SELECT * FROM vehiculos_conductores AS vc INNER JOIN vehiculos AS v ON vc.id_vehiculo = v.id_vehiculo INNER JOIN conductores AS c ON vc.id_conductor = c.id_conductor WHERE vc.id_conductor = '$id_conductor'";
				return $vehiculos_conductores;

		}
		
		public function listarConductoresPorVehiculos($vehiculos){

				$vehiculos_conductores = array();
				$con = Conexion::conectar();
				$sql = $con->prepare("SELECT distinct(id_conductor) FROM vehiculos_conductores WHERE id_vehiculo IN ($vehiculos)");

				$sql->execute();

				while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
					$vehiculos_conductores[] = $filas;
				}
				
				return $vehiculos_conductores;

		}
       

		public function registrar($id_vehiculo, $id_conductor){
			try {

				$con = Conexion::conectar();
			    $sql = $con->prepare("INSERT INTO vehiculos_conductores(id_vehiculo, id_conductor) VALUES (:id_vehiculo, :id_conductor)");
			    $sql->bindParam(":id_vehiculo", $id_vehiculo);
			    $sql->bindParam(":id_conductor", $id_conductor);

			    $sql->execute();

			    /*if ($sql) {
				    header("Location: ../Vista/conductores.php");
			    }*/

			} catch (Exception $e) {
				echo $e->getMessage();
			}
			
		}

		public function eliminarPorId($id_conductor){
			try {
				$con = Conexion::conectar();
				$sql = $con->prepare("DELETE FROM vehiculos_conductores WHERE id_conductor = ?");
				$sql->bindParam(1, $id_conductor);

				$sql->execute();
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}

}
 ?>