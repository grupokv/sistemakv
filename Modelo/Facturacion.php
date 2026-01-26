<?php 
require_once 'Conexion/conexionBD.php';


class Facturacion
{
	
	public function listarTodos(){
		$listarTodos = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM facturaciones");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarTodos[] = $filas;
		}

		return $listarTodos;
	}

	public function listarPorId($id_facturacion){
		$listarContratosPorId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM facturaciones WHERE id_facturacion = :id_facturacion");
		$sql->bindParam(":id_facturacion", $id_facturacion);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarContratosPorId[] = $filas;
		}

		return $listarContratosPorId;
	}

	public function registrar($id_vehiculo, $mes, $dias_facturados, $valor_total_facturado, $valor_total_pagar_terceros, $fecha_factura, 
							  $fecha_recibo_pago, $id_contrato){
		
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO facturaciones(id_vehiculo, mes, dias_facturados, valor_total_facturado, valor_total_pagar_terceros, fecha_factura, fecha_recibo_pago, id_contrato, estado) VALUES(:id_vehiculo, :mes, :dias_facturados, :valor_total_facturado, :valor_total_pagar_terceros, :fecha_factura, :fecha_recibo_pago, :id_contrato, 0)");
			$sql->bindParam(":id_vehiculo", $id_vehiculo);
			$sql->bindParam(":mes", $mes);
			$sql->bindParam(":dias_facturados", $dias_facturados);
			$sql->bindParam(":valor_total_facturado", $valor_total_facturado);
			$sql->bindParam(":valor_total_pagar_terceros", $valor_total_pagar_terceros);
			$sql->bindParam(":fecha_factura", $fecha_factura);
			$sql->bindParam(":fecha_recibo_pago", $fecha_recibo_pago);
			$sql->bindParam(":id_contrato", $id_contrato);
			$sql->execute();	

/*
			echo "INSERT INTO facturaciones(id_vehiculo, mes, dias_facturados, valor_total_facturado, valor_total_pagar_terceros, fecha_factura, fecha_recibido_pago) VALUES('$id_vehiculo', '$mes', '$dias_facturados', '$valor_total_facturado', '$valor_total_pagar_terceros', '$fecha_factura', '$fecha_recibo_pago')";*/
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		
	}

	public function actualizar($id_facturacion, $id_vehiculo, $mes, $dias_facturados, $valor_total_facturado, $valor_total_pagar_terceros,
							   $fecha_factura, $fecha_recibo_pago, $id_contrato, $estado){
		
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE facturaciones SET id_vehiculo = :id_vehiculo, mes = :mes, dias_facturados = :dias_facturados, valor_total_facturado = :valor_total_facturado, valor_total_pagar_terceros = :valor_total_pagar_terceros, fecha_factura = :fecha_factura, fecha_recibo_pago = :fecha_recibo_pago, id_contrato = :id_contrato, estado = :estado WHERE id_facturacion = :id_facturacion");
			$sql->bindParam(":id_facturacion", $id_facturacion);
			$sql->bindParam(":id_vehiculo", $id_vehiculo);
			$sql->bindParam(":mes", $mes);
			$sql->bindParam(":dias_facturados", $dias_facturados);
			$sql->bindParam(":valor_total_facturado", $valor_total_facturado);
			$sql->bindParam(":valor_total_pagar_terceros", $valor_total_pagar_terceros);
			$sql->bindParam(":fecha_factura", $fecha_factura);
			$sql->bindParam(":fecha_recibo_pago", $fecha_recibo_pago);
			$sql->bindParam(":id_contrato", $id_contrato);
			$sql->bindParam(":estado", $estado);
			$sql->execute();	

			/*echo "UPDATE facturaciones SET id_vehiculo = '$id_vehiculo', mes = '$mes', dias_facturados = '$dias_facturados', valor_total_facturado = '$valor_total_facturado', valor_total_pagar_terceros ='$valor_total_pagar_terceros', fecha_factura ='$fecha_factura', fecha_recibo_pago ='$fecha_recibo_pago', id_contrato = '$id_contrato', estado = '$estado' WHERE id_facturacion = '$id_facturacion' ";*/
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		
	}

	public function eliminar($id_facturacion){
		$con = Conexion::conectar();
		$sql = $con->prepare("DELETE FROM facturaciones WHERE id_facturacion = ?");
		$sql->bindParam(1, $id_facturacion);			
		$sql->execute();
	}

	public function culminarFacturacion($id_facturacion){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE facturaciones SET estado = 1 WHERE id_facturacion = ?");
			$sql->bindParam(1, $id_facturacion);
			$sql->execute();

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function filtrarCulminaciones($id_vehiculo, $mes_inicial, $mes_final, $id_contrato, $estado, $dias_facturados, $valor_total_inicial, $valor_total_final, $fecha_inicial_factura, $fecha_final_factura){
		$filtrar = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM facturaciones WHERE id_vehiculo LIKE :id_vehiculo AND mes >= :mes_inicial AND mes <= :mes_final AND id_contrato LIKE :id_contrato AND estado LIKE :estado AND dias_facturados LIKE :dias_facturados AND  valor_total_facturado >= :valor_total_inicial AND valor_total_facturado <= :valor_total_final AND fecha_factura >= :fecha_inicial_factura AND fecha_factura <= :fecha_final_factura ");

		// echo "SELECT * FROM facturaciones WHERE id_vehiculo LIKE '$id_vehiculo' AND mes >= '$mes_inicial' AND mes <= '$mes_final' AND id_contrato LIKE '$id_contrato' AND estado LIKE '$estado' AND dias_facturados LIKE '$dias_facturados' AND  valor_total_facturado >= '$valor_total_inicial' AND valor_total_facturado <= '$valor_total_final' AND fecha_factura >= '$fecha_inicial_factura' AND fecha_factura <= '$fecha_final_factura'";
		

		$sql->bindParam(":id_vehiculo", $id_vehiculo);
		$sql->bindParam(":mes_inicial", $mes_inicial);
		$sql->bindParam(":mes_final", $mes_final);
		$sql->bindParam(":id_contrato", $id_contrato);
		$sql->bindParam(":estado", $estado);
		$sql->bindParam(":dias_facturados", $dias_facturados);
		$sql->bindParam(":valor_total_inicial", $valor_total_inicial);
		$sql->bindParam(":valor_total_final", $valor_total_final);
		$sql->bindParam(':fecha_inicial_factura', $fecha_inicial_factura);
		$sql->bindParam(":fecha_final_factura", $fecha_final_factura);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$filtrar[] = $filas;
		}

		return $filtrar;
	}
}
 ?>