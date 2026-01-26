<?php 

require_once("Conexion/conexionBD.php");

class Cliente_Convenio
{
	
	public function listar(){
		$clientes = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM clientes_convenios");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$clientes[] = $filas;
		}

		return $clientes;		

	}

	public function cliente_ID($id_cliente){
		$clientes = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM clientes_convenios WHERE id_cliente = :id_cliente");
		$sql->bindParam(":id_cliente", $id_cliente);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$clientes[] = $filas;
		}

		return $clientes;
	}

	public function listarClientePorId($id_cliente){
		$clientes = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM clientes_convenios WHERE id_cliente = ?");
		$sql->bindParam(1, $id_cliente);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$clientes[] = $filas;
		}

		return $clientes;		

	}

	public function listarClientePorIdCiudad($id_ciudad){
		$clientes = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM clientes_convenios WHERE id_ciudad = ?");
		$sql->bindParam(1, $id_ciudad);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$clientes[] = $filas;
		}

		return $clientes;		

	}

	public function listarClientePorIdDepartamento($id_departamento){
		$clientes = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM clientes_convenios WHERE id_departamento = ?");
		$sql->bindParam(1, $id_departamento);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$clientes[] = $filas;
		}

		return $clientes;		

	}

	public function listarClientePorIdPais($id_pais){
		$clientes = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM clientes_convenios WHERE id_pais = ?");
		$sql->bindParam(1, $id_pais);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$clientes[] = $filas;
		}

		return $clientes;		

	}
	

	public function registrar($razon_social, $nit, $direccion, $telefono, $representante, $ciudad_rl, $num_rl, $fecha_rl, $lugar_rl, $id_ciudad, $id_departamento,$id_pais){

			try {
				$con = Conexion::conectar();
			    $sql = $con->prepare("INSERT INTO clientes_convenios (razon_social, nit_cliente, direccionC, telefonoC, representante_legalC, ciudad_residencia_rl, numero_documentoC, fecha_expedicionC, lugar_expedicionC, id_ciudad, id_departamento, id_pais, estado) VALUES(:razon_social, :nit_cliente, :direccion, :telefono, :representante, :ciudad_rl, :num_rl, :fecha_rl, :lugar_rl, :id_ciudad, :id_departamento, :id_pais, 1)");
	            
	            $sql->bindParam(":razon_social", $razon_social);
	            $sql->bindParam(":nit_cliente", $nit);
	            $sql->bindParam(":direccion", $direccion);
	            $sql->bindParam(":telefono", $telefono);
	            $sql->bindParam(":representante", $representante);
	            $sql->bindParam(":ciudad_rl", $ciudad_rl);
	            $sql->bindParam(":num_rl", $num_rl);
	            $sql->bindParam(":fecha_rl", $fecha_rl);
	            $sql->bindParam(":lugar_rl", $lugar_rl);
	            $sql->bindParam(":id_ciudad", $id_ciudad);
	            $sql->bindParam(":id_departamento", $id_departamento);
	            $sql->bindParam(":id_pais", $id_pais);

	            $sql->execute();

	            //echo "INSERT INTO clientes_convenios (razon_social, nit_cliente, direccionC, telefonoC, representante_legalC, ciudad_residencia_rl, numero_documentoC, fecha_expedicionC, lugar_expedicionC, id_ciudad, id_departamento, id_pais, estado) VALUES('$razon_social', '$nit', '$direccion', '$telefono', '$representante', '$ciudad_rl', '$num_rl', '$fecha_rl', '$lugar_rl', '$id_ciudad', '$id_departamento', '$id_pais', '1')";

	            return $id_cliente = $con->lastInsertId();

			} catch (Exception $e) {
				echo $e->getMessage();
			}

		    
	}

	public function actualizar($razon_social,$nit_cliente,$direccion,$telefono,$nombre_rl,$id_ciudad_rl,$doc_rl,$fecha_doc_rl,$id_ciudad_exp,$id_ciudad,$id_departamento,$id_pais,$id_cliente){


            try {
            	
		        $con = Conexion::conectar();
		        $sql = $con->prepare("UPDATE clientes_convenios SET razon_social = :razon_social, nit_cliente = :nit_cliente, direccionC = :direccion, telefonoC = :telefono, representante_legalC = :nombre_rl, ciudad_residencia_rl = :ciudad_rl, numero_documentoC = :num_rl, fecha_expedicionC = :fecha_rl, lugar_expedicionC = :lugar_rl, id_ciudad = :id_ciudad, id_departamento = :id_departamento, id_pais = :id_pais WHERE id_cliente = :id_cliente");

			    $sql->bindParam(":razon_social", $razon_social);
	            $sql->bindParam(":nit_cliente", $nit_cliente);
	            $sql->bindParam(":direccion", $direccion);
	            $sql->bindParam(":telefono", $telefono);
	            $sql->bindParam(":nombre_rl", $nombre_rl);
	            $sql->bindParam(":ciudad_rl", $id_ciudad_rl);
	            $sql->bindParam(":num_rl", $doc_rl);
	            $sql->bindParam(":fecha_rl", $fecha_doc_rl);
	            $sql->bindParam(":lugar_rl", $id_ciudad_exp);
	            $sql->bindParam(":id_ciudad", $id_ciudad);
	            $sql->bindParam(":id_departamento", $id_departamento);
	            $sql->bindParam(":id_pais", $id_pais);
	            $sql->bindParam(":id_cliente", $id_cliente);

	            $sql->execute();

	            //echo "UPDATE clientes_convenios SET razon_social = '$razon_social', nit_cliente = '$nit_cliente', direccionC = '$direccion', telefonoC = '$telefono', representante_legalC = '$nombre_rl', ciudad_residencia_rl = '$id_ciudad_rl', numero_documentoC = '$num_rl', fecha_expedicionC = '$fecha_doc_rl', lugar_expedicionC = '$id_ciudad_exp', id_ciudad = '$id_ciudad', id_departamento = '$id_departamento', id_pais = '$id_pais' WHERE id_cliente = '$id_cliente' ";
	                
            } catch (Exception $e) {
            	echo $e->getMessage();
            }
	}

	public function bloquear($id_cliente){

		$con = Conexion::conectar();
		$sql = $con->prepare("UPDATE clientes_convenios SET estado = 0 WHERE id_cliente = ? ");
		$sql->bindParam(1, $id_cliente);
		$sql->execute();

		if ($sql) {
			header("Location: ../Vista/clientes_convenios.php");
		}
	}

	public function desbloquear($id_cliente){

		$con = Conexion::conectar();
		$sql = $con->prepare("UPDATE clientes_convenios SET estado = 1 WHERE id_cliente = ? ");
		$sql->bindParam(1, $id_cliente);
		$sql->execute();

		if ($sql) {
			header("Location: ../Vista/clientes_convenios.php");
		}
	}

	public function registrarClienteConvenioVehiculo($id_vehiculo, $id_cliente){
		try {

			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO clientesConvenio_vehiculos (id_vehiculo, id_cliente) VALUES (:id_vehiculo, :id_cliente) ");
			$sql->bindParam(":id_vehiculo", $id_vehiculo);
			$sql->bindParam(":id_cliente", $id_cliente);

			$sql->execute();

			//echo "INSERT INTO clientesConvenio_vehiculos (id_vehiculo, id_cliente) VALUES ('$id_vehiculo', '$id_cliente')";

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function eliminarClienteConvenioVehiculoExistente($id_vehiculo){
		try {

			$con = Conexion::conectar();
			$sql = $con->prepare("DELETE FROM clientesConvenio_vehiculos WHERE id_vehiculo = :id_vehiculo");
			$sql->bindParam(":id_vehiculo", $id_vehiculo);

			$sql->execute();

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function listarEmpresaConvenioPorVehiculo($id_vehiculo){

		$empresaConVehiculo = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM clientesConvenio_vehiculos WHERE id_vehiculo = :id_vehiculo ");
		$sql->bindParam(":id_vehiculo", $id_vehiculo);

		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$empresaConVehiculo[] = $filas;
		}

		return $empresaConVehiculo;	
	}

}
 ?>