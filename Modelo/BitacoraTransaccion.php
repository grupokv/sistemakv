<?php 
require_once ("Conexion/conexionBD.php");

class Transacciones
{


	public function listarHistorialTransacciones(){

		$historialTransacciones = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM bitacora_transacciones");

		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$historialTransacciones[] = $filas;
		}

		return $historialTransacciones;
	}
	
	public function registrarTransaccion($referencia, $requestID, $id_usuario, $data, $fecha, $estado, $extraGeneralInfo){
		try {
        	$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO bitacora_transacciones (referencia, requestID, id_usuario, data, fecha, estado, extraGeneralInfo) VALUES (:referencia, :requestID, :id_usuario, :data, :fecha, :estado, :extraGeneralInfo)");

			$sql->bindParam(":referencia", $referencia);
			$sql->bindParam(":requestID", $requestID);
			$sql->bindParam(":id_usuario", $id_usuario);
			$sql->bindParam(":data", $data);
			$sql->bindParam(":fecha", $fecha);
			$sql->bindParam(":estado", $estado);
			$sql->bindParam(":extraGeneralInfo", $extraGeneralInfo);

			$sql->execute();

			//echo "INSERT INTO bitacora_transacciones (referencia, requestID, id_usuario, data, fecha, estado, resultado) VALUES ('$referencia', '$requestID', '$id_usuario', '$data', '$fecha', '$estado', '$resultado')";

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function actualizarTransaccion($fecha, $estado, $resultado, $requestID){
		try {
			
        	$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE bitacora_transacciones SET fecha = :fecha, estado = :estado, resultado = :resultado WHERE requestID = :requestID");

			$sql->bindParam(":fecha", $fecha);
			$sql->bindParam(":estado", $estado);
			$sql->bindParam(":resultado", $resultado);
			$sql->bindParam(":requestID", $requestID);

			$sql->execute();


		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function actualizarEstadoTransaccion($id_transaccion, $estado){
		try {
			
        	$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE bitacora_transacciones SET estado = :estado WHERE id_transaccion = :id_transaccion");

			$sql->bindParam(":id_transaccion", $id_transaccion);
			$sql->bindParam(":estado", $estado);

			$sql->execute();


		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function actualizarRequestIDTransaccionReintentoPago($requestID, $id_transaccion){
		try {
			
        	$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE bitacora_transacciones SET requestID = :requestID WHERE id_transaccion = :id_transaccion");

			$sql->bindParam(":id_transaccion", $id_transaccion);
			$sql->bindParam(":requestID", $requestID);

			$sql->execute();


		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}



	public function actualizarExtraGeneralInfoTransaccion($extraGeneralInfo, $referencia){
		try {
			
        	$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE bitacora_transacciones SET extraGeneralInfo = :extraGeneralInfo WHERE referencia = :referencia");

			$sql->bindParam(":extraGeneralInfo", $extraGeneralInfo);
			$sql->bindParam(":referencia", $referencia);

			$sql->execute();

			//echo "UPDATE bitacora_transacciones SET extraGeneralInfo = '$extraGeneralInfo' WHERE referencia = '$referencia' ";


		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function listarBitacoraTransaccion(){

		$transaccion = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM bitacora_transacciones WHERE estado = 'PENDING' ");

		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$transaccion[] = $filas;
		}

		return $transaccion;
	}

	public function listarBitacoraTransaccionID($id_transaccion){

		$transaccionID = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM bitacora_transacciones WHERE id_transaccion = :id_transaccion ");
		$sql->bindParam(":id_transaccion", $id_transaccion);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$transaccionID[] = $filas;
		}

		return $transaccionID;
	}


	public function listarTransaccionReferencia($referencia){

		$transaccionReferencia = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM bitacora_transacciones WHERE referencia = :referencia ");
		$sql->bindParam(":referencia", $referencia);

		$sql->execute();

		//echo "SELECT * FROM bitacora_transacciones WHERE id_transaccion = '$id_transaccion' ";

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$transaccionReferencia[] = $filas;
		}

		return $transaccionReferencia;
	}

	public function historialTransaccionesUsuario($id_usuario){

		$historialTransacciones = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM bitacora_transacciones WHERE id_usuario = :id_usuario AND estado != 'SUSPENDED' ");
		
		$sql->bindParam(":id_usuario", $id_usuario);

		$sql->execute();

		//echo "SELECT * FROM bitacora_transacciones WHERE id_transaccion = '$id_transaccion' ";

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$historialTransacciones[] = $filas;
		}

		return $historialTransacciones;
	}

	public function historialTransaccionesPendientesPorUsuario($id_usuario){

		$historialTransaccionesPend = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM bitacora_transacciones WHERE id_usuario = :id_usuario AND estado = 'PENDING' ");
		$sql->bindParam(":id_usuario", $id_usuario);

		$sql->execute();

		//echo "SELECT * FROM bitacora_transacciones WHERE id_transaccion = '$id_transaccion' ";

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$historialTransaccionesPend[] = $filas;
		}

		return $historialTransaccionesPend;
	}

	public function listarTransaccionPorIdRegistro($registroID){

		$listarRegistroID = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM bitacora_transacciones WHERE extraGeneralInfo LIKE '%$registroID%' ");

		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarRegistroID[] = $filas;
		}

		return $listarRegistroID;
	}
	

	public function validarPaquetesPlusPorUsuario($id_usuario){
        $paquetes_plusUsuario = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM paquetes_plus_vehiculos  WHERE id_usuario_activacion = :id_usuario AND estado = 'ACTIVO' ");
        $sql->bindParam(':id_usuario', $id_usuario);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $paquetes_plusUsuario[] = $filas;
        }

        return $paquetes_plusUsuario;
  	}

	public function validarPaquetesPlusPorVehiculo($id_vehiculo){
        $paquetes_plusVehiculo = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM paquetes_plus_vehiculos  WHERE id_vehiculo = :id_vehiculo AND estado = 'ACTIVO' ");
        $sql->bindParam(':id_vehiculo', $id_vehiculo);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $paquetes_plusVehiculo[] = $filas;
        }

        return $paquetes_plusVehiculo;
  	}

  	public function registrarPaquetePlusVehiculo($id_vehiculo, $id_transaccion, $id_usuario, $fecha_inicial , $fecha_final, $estado){
		try {
			
        	$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO paquetes_plus_vehiculos (id_vehiculo, id_transaccion, id_usuario_activacion, fecha_inicial , fecha_final, estado) VALUES(:id_vehiculo, :id_transaccion, :id_usuario, :fecha_inicial , :fecha_final, :estado)");

			$sql->bindParam(":id_vehiculo", $id_vehiculo);
			$sql->bindParam(":id_transaccion", $id_transaccion);
			$sql->bindParam(":id_usuario", $id_usuario);
			$sql->bindParam(":fecha_inicial", $fecha_inicial);
			$sql->bindParam(":fecha_final", $fecha_final);
			$sql->bindParam(":estado", $estado);

			$sql->execute();
			
			if($sql){
		    	return $idPaquetePlus = $con->lastInsertId();
			}

			//echo "INSERT INTO paquetes_plus_vehiculos (id_vehiculo, id_transaccion, id_usuario, fecha_inicial , fecha_final, estado) VALUES('$id_vehiculo', '$id_transaccion', '$id_usuario', '$fecha_inicial' , '$fecha_final', '$estado')";

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}





}
	
?>