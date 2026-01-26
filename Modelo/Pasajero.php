<?php 

require_once("Conexion/conexionBD.php");

/**
 * 
 */
class Pasajero
{
	
	public function listar(){
		$pasajeros = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM pasajero");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$pasajeros[] = $filas;
		}

		return $pasajeros;		

	}

	public function listarPasajeroPorId($id_pasajero){
		$pasajeros = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM pasajero WHERE id_pasajero = ?");
		$sql->bindParam(1, $id_pasajero);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$pasajeros[] = $filas;
		}

		return $pasajeros;		

	}

	public function registrar($nombre, $direccion, $hora_subida, $hora_bajada, $id_tipopasajero, $id_curso, $id_colegio){

		    $con = Conexion::conectar();
		    $sql = $con->prepare("INSERT INTO pasajero (nombre, direccion, hora_subida, hora_bajada, id_tipo, id_curso, id_colegio, estado)
			                       VALUES(:nombre, :direccion, :hora_subida, :hora_bajada, :id_tipopasajero, :id_curso, :id_colegio, 1);");
            
            $sql->bindParam(":nombre", $nombre);
            $sql->bindParam(":direccion", $direccion);
            $sql->bindParam(":hora_subida", $hora_subida);
            $sql->bindParam(":hora_bajada", $hora_bajada);
            $sql->bindParam(":id_tipopasajero", $id_tipopasajero);
            $sql->bindParam(":id_curso", $id_curso);
            $sql->bindParam(":id_colegio", $id_colegio);

            $sql->execute();
            
			if ($sql) {	
            	$id_usuario = $con->lastInsertId();
            	header("Location: ../Vista/pasajeros.php");
            }

            return $id_usuario;
	}

	public function actualizar($id_usuario, $nombre_usu, $clave, $id_perfil, $correo_electronico, $nombre, $id_cargo, $estado){


            try {
            	
		        $con = Conexion::conectar();
		        $sql = $con->prepare("UPDATE usuarios SET usuario = '$nombre_usu', clave = '$clave', id_perfil = '$id_perfil', correo_electronico = '$correo_electronico', nombre = '$nombre', id_cargo = '$id_cargo', estado = '$estado' WHERE id_usuario = '$id_usuario'  ");

		        $sql->bindParam(":nombre_usu", $nombre_usu);
                $sql->bindParam(":clave", $clave);
                $sql->bindParam(":id_perfil", $id_perfil);
                $sql->bindParam(":correo_electronico", $correo_electronico);
                $sql->bindParam(":nombre", $nombre);
                $sql->bindParam(":id_cargo", $id_cargo);
                $sql->bindParam(":estado", $estado);
                $sql->bindParam(":id_usuario", $id_usuario);

                $sql->execute();
                
                if ($sql) {
            	    header("Location: ../Vista/actualizarRoles.php?us=".$id_usuario);
                }
            } catch (Exception $e) {
            	echo $e->getMessage();
            }


	}

	public function bloquear($id_pasajero){

		$con = Conexion::conectar();
		$sql = $con->prepare("UPDATE pasajero SET estado = 0 WHERE id_pasajero = ? ");
		$sql->bindParam(1, $id_pasajero);
		$sql->execute();

		if ($sql) {
			header("Location: ../Vista/pasajeros.php");
		}
	}

	public function desbloquear($id_pasajero){

		$con = Conexion::conectar();
		$sql = $con->prepare("UPDATE pasajero SET estado = 1 WHERE id_pasajero = ? ");
		$sql->bindParam(1, $id_pasajero);
		$sql->execute();

		if ($sql) {
			header("Location: ../Vista/pasajeros.php");
		}
	}

	public function borrar_pasajero_ruta($id_pasajero,$id_ruta){

		$con = Conexion::conectar();
		$sql = $con->prepare("DELETE FROM ruta_pasajero WHERE id_pasajero = ? AND id_ruta = ? ");
		$sql->bindParam(1, $id_pasajero);
		$sql->bindParam(2, $id_ruta);
		$sql->execute();

	}

	public function actualizar_pasajero_ruta($id_pasajero,$id_ruta_actual,$id_ruta_nueva){

		$con = Conexion::conectar();
		$sql = $con->prepare("UPDATE ruta_pasajero SET id_ruta = ? WHERE id_pasajero = ? AND id_ruta = ? ");
		$sql->bindParam(1, $id_ruta_nueva);
		$sql->bindParam(2, $id_pasajero);
		$sql->bindParam(3, $id_ruta_actual);
		$sql->execute();

	}

	public function registrarnovedad($tipo, $rutaorigen, $rutadestino, $detalle, $fecha, $pasajero, $usuario){

		    $con = Conexion::conectar();
		    $sql = $con->prepare("INSERT INTO novedad_pasajero (id_tipo, id_ruta_origen, id_ruta_destino, detalle, fecha_novedad, id_pasajero, id_usuario)
			                       VALUES(:tipo, :rutaorigen, :rutadestino, :detalle, :fecha, :pasajero, :usuario);");
            
            $sql->bindParam(":tipo", $tipo);
            $sql->bindParam(":rutaorigen", $rutaorigen);
            $sql->bindParam(":rutadestino", $rutadestino);
            $sql->bindParam(":detalle", $detalle);
            $sql->bindParam(":fecha", $fecha);
            $sql->bindParam(":pasajero", $pasajero);
            $sql->bindParam(":usuario", $usuario);

            $sql->execute();
            
			if ($sql) {

				$id_novedad = $con->lastInsertId();

				if($tipo == '1'){
					$sql = $con->prepare("DELETE FROM ruta_pasajero WHERE id_pasajero = ? AND id_ruta = ? ");
					$sql->bindParam(1, $pasajero);
					$sql->bindParam(2, $rutaorigen);
					$sql->execute();
				} else {
					$sql = $con->prepare("UPDATE ruta_pasajero SET id_ruta = ? WHERE id_pasajero = ? AND id_ruta = ? ");
					$sql->bindParam(1, $rutadestino);
					$sql->bindParam(2, $pasajero);
					$sql->bindParam(3, $rutaorigen);
					$sql->execute();
				}

            	header("Location: ../Vista/novedades_pasajeros.php");
            }

            return $id_usuario;
	}

	public function rutaAsignada($id_pasajero,$id_ruta){
          $vehiculosId = array();
          $con = Conexion::conectar();
          $sql = $con->prepare("SELECT * FROM ruta_pasajero WHERE id_pasajero = ? and id_ruta != ?");
          $sql->bindParam(1, $id_pasajero);
          $sql->bindParam(2, $id_ruta);

          $sql->execute();
          
          while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            
             $vehiculosId[] = $filas;
          }

      return $vehiculosId;
    }

    public function yaAsignados(){
          $vehiculosId = array();
          $con = Conexion::conectar();
          $sql = $con->prepare("SELECT * FROM ruta_pasajero");
          $sql->bindParam(1, $id_pasajero);

          $sql->execute();
          
          while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            
             $vehiculosId[] = $filas;
          }

      return $vehiculosId;
    }

}
 ?>