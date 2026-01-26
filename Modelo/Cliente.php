<?php 

require_once("Conexion/conexionBD.php");

class Cliente
{
	
	public function listar(){
		$clientes = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM clientes WHERE estado = 1");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$clientes[] = $filas;
		}

		return $clientes;		

	}

	public function validarPorNitCliente($nit_cliente){
		$validarNit = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM clientes WHERE nit_cliente = :nit_cliente ");
		$sql->bindParam(":nit_cliente", $nit_cliente);
		$sql->execute();

		//echo "SELECT * FROM clientes WHERE nit_cliente  = '$nit_cliente' ";

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$validarNit[] = $filas;
		}

		return $validarNit;
	}

	public function cliente_ID($id_cliente){
		$clientes = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM clientes WHERE id_cliente = :id_cliente");
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
		$sql = $con->prepare("SELECT * FROM clientes WHERE id_cliente = ?");
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
		$sql = $con->prepare("SELECT * FROM clientes WHERE id_ciudad = ?");
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
		$sql = $con->prepare("SELECT * FROM clientes WHERE id_departamento = ?");
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
		$sql = $con->prepare("SELECT * FROM clientes WHERE id_pais = ?");
		$sql->bindParam(1, $id_pais);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$clientes[] = $filas;
		}

		return $clientes;		

	}

	public function listarClientePorIdSegmento($id_segmento){
		$clientes = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM clientes WHERE id_segmento = ?");
		$sql->bindParam(1, $id_segmento);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$clientes[] = $filas;
		}

		return $clientes;		

	}

	public function listarClientePorIdEmpresa($id_empresa){
		$clientes = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM clientes WHERE contrato_por = ?");
		$sql->bindParam(1, $id_empresa);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$clientes[] = $filas;
		}

		return $clientes;		

	}

	public function listar_programacion($id_usuario){
		$clientes = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM usuario_cliente WHERE id_usuario = ?");
		$sql->bindParam(1, $id_usuario);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$clientes[] = $filas;
		}

		return $clientes;		

	}

	

	public function registrar($razon_social, $sigla, $nit_cliente, $direccion, $correo_electronico, $telefono, $representante, $ciudad_rl, $num_rl, $fecha_rl, $lugar_rl, $id_ciudad, $id_departamento,$id_pais,$id_segmento, $id_usuario_registro){

			try {
				$con = Conexion::conectar();
			    $sql = $con->prepare("INSERT INTO clientes (razon_social, sigla, nit_cliente, direccionC, correo_electronico, telefonoC, representante_legalC, ciudad_residencia_rl, numero_documentoC, fecha_expedicionC, lugar_expedicionC, id_ciudad, id_departamento, id_pais, id_segmento, estado, id_usuario_registro) VALUES(:razon_social, :sigla, :nit_cliente, :direccion, :correo_electronico, :telefono, :representante, :ciudad_rl, :num_rl, :fecha_rl, :lugar_rl, :id_ciudad, :id_departamento, :id_pais, :id_segmento, 1, :id_usuario_registro)");
	            
	            $sql->bindParam(":razon_social", $razon_social);
	            $sql->bindParam(":sigla", $sigla);
	            $sql->bindParam(":nit_cliente", $nit_cliente);
	            $sql->bindParam(":direccion", $direccion);
	            $sql->bindParam(":correo_electronico", $correo_electronico);
	            $sql->bindParam(":telefono", $telefono);
	            $sql->bindParam(":representante", $representante);
	            $sql->bindParam(":ciudad_rl", $ciudad_rl);
	            $sql->bindParam(":num_rl", $num_rl);
	            $sql->bindParam(":fecha_rl", $fecha_rl);
	            $sql->bindParam(":lugar_rl", $lugar_rl);
	            $sql->bindParam(":id_ciudad", $id_ciudad);
	            $sql->bindParam(":id_departamento", $id_departamento);
	            $sql->bindParam(":id_pais", $id_pais);
	            $sql->bindParam(":id_segmento", $id_segmento);
	            $sql->bindParam(":id_usuario_registro", $id_usuario_registro);

	            $sql->execute();

	            //echo "INSERT INTO clientes (razon_social, nit_cliente, direccionC, telefonoC, representante_legalC, ciudad_residencia_rl, numero_documentoC, fecha_expedicionC, lugar_expedicionC, id_ciudad, id_departamento, id_pais, id_segmento, estado) VALUES('$razon_social', '$nit_cliente', '$direccion', '$telefono', '$representante', '$ciudad_rl', '$num_rl', '$fecha_rl', '$lugar_rl', '$id_ciudad', '$id_departamento','$id_pais','$id_segmento', 1)";

	            return $id_cliente = $con->lastInsertId();
	            
			} catch (Exception $e) {
				echo $e->getMessage();
			}

		    
	}

	public function actualizar($razon_social, $sigla, $nit_cliente, $direccion, $correo_electronico, $telefono, $nombre_rl, $id_ciudad_rl, $doc_rl, $fecha_doc_rl, $id_ciudad_exp, $id_ciudad, $id_departamento, $id_pais, $tipo_cliente, $id_cliente){

            try {
            	
		        $con = Conexion::conectar();
		        $sql = $con->prepare("UPDATE clientes SET razon_social = :razon_social, sigla = :sigla, nit_cliente = :nit_cliente, direccionC = :direccion, correo_electronico = :correo_electronico, telefonoC = :telefono, representante_legalC = :nombre_rl, ciudad_residencia_rl = :ciudad_rl, numero_documentoC = :num_rl, fecha_expedicionC = :fecha_rl, lugar_expedicionC = :lugar_rl, id_ciudad = :id_ciudad, id_departamento = :id_departamento, id_pais = :id_pais, id_segmento = :id_segmento WHERE id_cliente = :id_cliente");

    		    $sql->bindParam(":razon_social", $razon_social);
    	        $sql->bindParam(":sigla", $sigla);
                $sql->bindParam(":nit_cliente", $nit_cliente);
                $sql->bindParam(":direccion", $direccion);
    	        $sql->bindParam(":correo_electronico", $correo_electronico);
                $sql->bindParam(":telefono", $telefono);
                $sql->bindParam(":nombre_rl", $nombre_rl);
                $sql->bindParam(":ciudad_rl", $id_ciudad_rl);
                $sql->bindParam(":num_rl", $doc_rl);
                $sql->bindParam(":fecha_rl", $fecha_doc_rl);
                $sql->bindParam(":lugar_rl", $id_ciudad_exp);
                $sql->bindParam(":id_ciudad", $id_ciudad);
                $sql->bindParam(":id_departamento", $id_departamento);
                $sql->bindParam(":id_pais", $id_pais);
                $sql->bindParam(":id_segmento", $tipo_cliente);
                $sql->bindParam(":id_cliente", $id_cliente);
    
                $sql->execute();
                    
            } catch (Exception $e) {
            	echo $e->getMessage();
            }
	}

	public function bloquear($id_cliente){

		$con = Conexion::conectar();
		$sql = $con->prepare("UPDATE clientes SET estado = 0 WHERE id_cliente = ? ");
		$sql->bindParam(1, $id_cliente);
		$sql->execute();

		if ($sql) {
			header("Location: ../Vista/clientes.php");
		}
	}

	public function desbloquear($id_cliente){

		$con = Conexion::conectar();
		$sql = $con->prepare("UPDATE clientes SET estado = 1 WHERE id_cliente = ? ");
		$sql->bindParam(1, $id_cliente);
		$sql->execute();

		if ($sql) {
			header("Location: ../Vista/clientes.php");
		}
	}

	public function listarClientePorUsuarioRegistro($id_usuario_registro){

		$listarUsuarioRegistro = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM clientes WHERE id_usuario_registro = :id_usuario_registro");
		$sql->bindParam(":id_usuario_registro", $id_usuario_registro);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarUsuarioRegistro[] = $filas;
		}

		return $listarUsuarioRegistro;
	}

	public function registrarClientePorPropieario($id_cliente, $id_usuario){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO clientes_propietarios (id_cliente, id_usuario, estado) VALUES(:id_cliente, :id_usuario, 1)");
			$sql->bindParam(":id_cliente", $id_cliente);
			$sql->bindParam(":id_usuario", $id_usuario);
			$sql->execute();

			if ($sql == true) {
		      return 1; 
		    }else {
		      return 0;
		    }

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function listarClientesAncladosPorPropietario($id_usuario){
		$clientesPropietario = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM clientes_propietarios WHERE id_usuario = :id_usuario");
		$sql->bindParam(":id_usuario", $id_usuario);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$clientesPropietario[] = $filas;
		}

		return $clientesPropietario;
	}

	public function validarClientesPorPropietario($id_usuario, $id_cliente){
		$clientesPorPropietario = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM clientes_propietarios WHERE id_usuario = :id_usuario AND id_cliente = :id_cliente");
		$sql->bindParam(":id_usuario", $id_usuario);
		$sql->bindParam(":id_cliente", $id_cliente);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$clientesPorPropietario[] = $filas;
		}

		return $clientesPorPropietario;
	}

	
	public function clientesAgrupadosPorId($listClientes){
		$clientesA = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM clientes WHERE id_cliente IN ($listClientes) ORDER BY razon_social ASC");
		$sql->bindParam(":listClientes", $listClientes);
		$sql->execute();


		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$clientesA[] = $filas;
		}

		return $clientesA;
	}

}
 ?>