<?php 

require_once("Conexion/conexionBD.php");

class ClienteProspecto
{
	
	public function listar(){
		$clientes = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM cliente_prospecto ORDER BY razon_social Asc");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$clientes[] = $filas;
		}

		return $clientes;		

	}
	
	public function listarStatus(){
		$clientes = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM status_cliente");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$clientes[] = $filas;
		}

		return $clientes;		

	}
	
	public function listarVolumen(){
		$clientes = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM volumen_venta_cliente");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$clientes[] = $filas;
		}

		return $clientes;		

	}
	
	public function listarFrecuencia(){
		$clientes = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM frecuencia_cliente");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$clientes[] = $filas;
		}

		return $clientes;		

	}

	public function validarPorNitCliente($nit_cliente){
		$validarNit = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM cliente_prospecto WHERE nit = :nit_cliente ");
		$sql->bindParam(":nit_cliente", $nit_cliente);
		$sql->execute();


		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$validarNit[] = $filas;
		}

		return $validarNit;
	}

	public function listarClientePorId($id_cliente){
		$clientes = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM cliente_prospecto WHERE id_prospecto = ?");
		$sql->bindParam(1, $id_cliente);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$clientes[] = $filas;
		}

		return $clientes;		

	}

	public function listarClientePorAsesor($asesor){
		$clientes = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM cliente_asesor WHERE id_asesor = ?");
		$sql->bindParam(1, $id_empresa);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$clientes[] = $filas;
		}

		return $clientes;		

	}

	public function listar_programacion($id_cliente){
		$clientes = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM cliente_asesor WHERE id_cliente = ?");
		$sql->bindParam(1, $id_cliente);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$clientes[] = $filas;
		}

		return $clientes;		

	}

	public function registrar($razon_social, $nit, $direccion, $telefono, $status, $volumen, $frecuencia, $creador, $fecha){

			try {
				$con = Conexion::conectar();
			    $sql = $con->prepare("INSERT INTO cliente_prospecto (razon_social, nit, direccion, telefono, status, volumen_venta, frecuencia_compra, estado, usuario_creador, fecha_creacion) VALUES(:razon_social, :nit, :direccion, :telefono, :status, :volumen, :frecuencia, '1', :creador, :fecha)");
	            
	            $sql->bindParam(":razon_social", $razon_social);
	            $sql->bindParam(":nit", $nit);
	            $sql->bindParam(":direccion", $direccion);
	            $sql->bindParam(":telefono", $telefono);
	            $sql->bindParam(":status", $status);
	            $sql->bindParam(":volumen", $volumen);
	            $sql->bindParam(":frecuencia", $frecuencia);
	            $sql->bindParam(":creador", $creador);
	            $sql->bindParam(":fecha", $fecha);

	            $sql->execute();
				
	            return $id_cliente = $con->lastInsertId();
			} catch (Exception $e) {
				echo $e->getMessage();
			}

		    
	}

	public function actualizar($razon_social, $nit, $direccion, $telefono, $status, $volumen, $frecuencia, $estado, $id_cliente){

            try {
            	
		        $con = Conexion::conectar();
		        $sql = $con->prepare("UPDATE cliente_prospecto SET razon_social = :razon_social, nit = :nit, direccion = :direccion, telefono = :telefono, status = :status, volumen_venta = :volumen, frecuencia_compra = :frecuencia, estado = :estado WHERE id_prospecto = :id_cliente");

		    $sql->bindParam(":razon_social", $razon_social);
			$sql->bindParam(":nit", $nit);
			$sql->bindParam(":direccion", $direccion);
			$sql->bindParam(":telefono", $telefono);
			$sql->bindParam(":status", $status);
			$sql->bindParam(":volumen", $volumen);
			$sql->bindParam(":frecuencia", $frecuencia);
			$sql->bindParam(":estado", $estado);
            $sql->bindParam(":id_cliente", $id_cliente);

            $sql->execute();
                
            } catch (Exception $e) {
            	echo $e->getMessage();
            }
	}

	public function bloquear($id_cliente){

		$con = Conexion::conectar();
		$sql = $con->prepare("UPDATE cliente_prospecto SET estado = 0 WHERE id_prospecto = ? ");
		$sql->bindParam(1, $id_cliente);
		$sql->execute();

		if ($sql) {
			header("Location: ../Vista/clientes_prospecto.php");
		}
	}

	public function desbloquear($id_cliente){

		$con = Conexion::conectar();
		$sql = $con->prepare("UPDATE cliente_prospecto SET estado = 1 WHERE id_prospecto = ? ");
		$sql->bindParam(1, $id_cliente);
		$sql->execute();

		if ($sql) {
			header("Location: ../Vista/clientes_prospecto.php");
		}
	}

}
 ?>