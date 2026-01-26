<?php 
require_once('Conexion/conexionBD.php');
/**
 * 
 */
class FlotaPropia
{
	
	public function filtrar($mesInicial, $añoInicial, $mesFinal, $añoFinal, $id_vehiculo){
		$listar = array();
		$con = Conexion::conectar();
		$sql = $con->prepare('SELECT * FROM flota_propia WHERE month(fecha_movimiento) >= :mesInicial AND month(fecha_movimiento) <= :mesFinal AND year(fecha_movimiento) >= :yInicial  AND year(fecha_movimiento) <= :yFinal AND id_vehiculo LIKE :id_vehiculo');

		$sql->bindParam(':mesInicial', $mesInicial);
		$sql->bindParam(':yInicial', $añoInicial);
		$sql->bindParam(':mesFinal', $mesFinal);
		$sql->bindParam(':yFinal', $añoFinal);
		$sql->bindParam(':id_vehiculo', $id_vehiculo);

		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listar[] = $filas;
		}

		return $listar;
	}

	public function listarFlotasPorId($id_flota_propia){
		$flotaId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare('SELECT * FROM flota_propia WHERE id_flota_propia = ?');
		$sql->bindParam(1, $id_flota_propia);

		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$flotaId[] = $filas;
		}

		return $flotaId;
	}


	public function listarDescuentosPorId($id_flota_propia){
		$listarId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare('SELECT * FROM descuentos_flota_propia WHERE id_flota_propia = ?');
		$sql->bindParam(1, $id_flota_propia);

		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarId[] = $filas;
		}

		return $listarId;
	}

	public function listarTotalDescuentosPorId($id_flota_propia){
		$listarId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare('SELECT SUM(valor_descuento) AS total_descuento FROM descuentos_flota_propia WHERE id_flota_propia = ?');
		$sql->bindParam(1, $id_flota_propia);

		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarId[] = $filas;
		}

		return $listarId;
	}

	public function listarTotalAPagarPorFlota($id_flota_propia){
		$total = array();
		$con = Conexion::conectar();
		$sql = $con->prepare('SELECT fp.valor_generado - SUM( dfp.valor_descuento ) AS totalPagar
							FROM descuentos_flota_propia AS dfp INNER JOIN flota_propia AS fp 
							ON fp.id_flota_propia = dfp.id_flota_propia WHERE dfp.id_flota_propia = ?');
		$sql->bindParam(1, $id_flota_propia);

		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$total[] = $filas;
		}

		return $total;
	}

	public function registrarDescuentosFlotaPropia($id_flota_propia, $detalle, $valor_descuento, $fecha){

		try {

			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO descuentos_flota_propia(id_flota_propia, detalle, valor_descuento, fecha) 
				                  VALUES(:id_flota_propia, :detalle, :valor_descuento, :fecha)");

			$sql->bindParam(":id_flota_propia", $id_flota_propia);
			$sql->bindParam(":detalle", $detalle);
			$sql->bindParam(":valor_descuento", $valor_descuento);
			$sql->bindParam(":fecha", $fecha);

			$sql->execute();

			if ($sql) {
				header("Location: ../Vista/filtroFlotaPropia.php");
			}

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function registrarDetalleFlotaPropia($id_vehiculo, $id_contrato_fijo, $id_contrato_ocasional, 
												$numero_recorridos, $dias_laborados, $dias_laborados_gps, 
												$valor_generado, $fecha_creacion, $fecha_movimiento){

		try {

			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO flota_propia(id_vehiculo, id_contrato_fijo, id_contrato_ocasional, numero_recorridos, dias_laborados, dias_laborados_gps, valor_generado, fecha_creacion, fecha_movimiento) VALUES(:id_vehiculo, :id_contrato_fijo, :id_contrato_ocasional, :numero_recorridos, :dias_laborados, :dias_laborados_gps, :valor_generado, :fecha_creacion, :fecha_movimiento)");

			$sql->bindParam(":id_vehiculo", $id_vehiculo);
			$sql->bindParam(":id_contrato_fijo", $id_contrato_fijo);
			$sql->bindParam(":id_contrato_ocasional", $id_contrato_ocasional);
			$sql->bindParam(":numero_recorridos", $numero_recorridos);
			$sql->bindParam(":dias_laborados", $dias_laborados);
			$sql->bindParam(":dias_laborados_gps", $dias_laborados_gps);
			$sql->bindParam(":valor_generado", $valor_generado);
			$sql->bindParam(":fecha_creacion", $fecha_creacion);
			$sql->bindParam(":fecha_movimiento", $fecha_movimiento);

			$sql->execute();

			if ($sql) {
				$id_flota_propia = $con->lastInsertId();
				header('Location: ../Vista/registrarDescuentosFlotaPropia.php?id_flota_propia= ' . $id_flota_propia);
			}

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function actualizar(){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE flota_propia SET id_vehiculo = :id_vehiculo, id_contrato_fijo = :id_contrato_fijo, id_contrato_ocasional = :id_contrato_ocasional, numero_recorridos = :numero_recorridos,  dias_laborados = :dias_laborados, valor_generado = :valor_generado,      
				fecha_creacion = :fecha_creacion, fecha_movimiento = :fecha_movimiento WHERE id_flota_propia = :id_flota_propia");

			$sql->bindParam(":id_flota_propia", $id_flota_propia);
			$sql->bindParam(":id_vehiculo", $id_vehiculo);
			$sql->bindParam(":id_contrato_fijo", $id_contrato_fijo);
			$sql->bindParam(":id_contrato_ocasional", $id_contrato_ocasional);
			$sql->bindParam(":numero_recorridos", $numero_recorridos);
			$sql->bindParam(":dias_laborados", $dias_laborados);
			$sql->bindParam(":valor_generado", $valor_generado);
			$sql->bindParam(":fecha_creacion", $fecha_creacion);
			$sql->bindParam(":fecha_movimiento", $fecha_movimiento);

			$sql->execute();

			if ($sql) {
				header('Location: ../Vista/filtroFlotaPropia.php');
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}
 ?>