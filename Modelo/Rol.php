<?php 

require_once("Conexion/conexionBD.php");

/**
 * 
 */
class Rol
{
	public function listar(){
		$listar = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM roles AS r INNER JOIN modulos AS m ON r.id_modulo = m.id_modulo");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listar[] = $filas;
		}

		return $listar;
	}

	public function listarPorId($id_usuario){
		$listarId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM roles AS r INNER JOIN modulos AS m ON r.id_modulo = m.id_modulo WHERE id_usuario = ? ORDER BY m.nombre_modulo ASC");
		$sql->bindParam(1, $id_usuario);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarId[] = $filas;
		}

		return $listarId;
	}
	
	

	public function listarPorIdModulo($id_usuario,$id_modulo){
		$listarId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM roles WHERE id_usuario = ? and id_modulo = ?");
		$sql->bindParam(1, $id_usuario);
		$sql->bindParam(2, $id_modulo);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarId[] = $filas;
		}

		return $listarId;
	}

	public function registrar($id_modulo, $id_usuario, $consulta, $edicion, $agregacion, $eliminacion){
		try {
		    $con = Conexion::conectar();
		    $sql = $con->prepare("INSERT INTO roles(id_modulo, id_usuario, consulta, edicion, agregacion, eliminacion) VALUES(:id_modulo, :id_usuario, :consulta, :edicion, :agregacion, :eliminacion)");

		    $sql->bindParam(":id_modulo", $id_modulo);
		    $sql->bindParam(":id_usuario", $id_usuario);
		    $sql->bindParam(":consulta", $consulta);
		    $sql->bindParam(":edicion", $edicion);
		    $sql->bindParam(":agregacion", $agregacion);
		    $sql->bindParam(":eliminacion", $eliminacion);

		    $sql->execute();

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}


	public function actualizar($id_rol, $id_modulo, $id_usuario, $consulta, $edicion, $agregacion, $eliminacion){
		try {
		    $con = Conexion::conectar();
		    $sql = $con->prepare("UPDATE roles SET id_modulo = '$id_modulo', consulta = '$consulta', edicion = '$edicion', agregacion = '$agregacion', eliminacion = '$eliminacion' WHERE  id_usuario = '$id_usuario' ");

		    $sql->bindParam(":id_rol", $id_rol);
		    $sql->bindParam(":id_modulo", $id_modulo);
		    $sql->bindParam(":id_usuario", $id_usuario);
		    $sql->bindParam(":consulta", $consulta);
		    $sql->bindParam(":edicion", $edicion);
		    $sql->bindParam(":agregacion", $agregacion);
		    $sql->bindParam(":eliminacion", $eliminacion);

		    $sql->execute();

		    if ($sql) {
            	header("Location: ../Vista/usuarios.php");
            }

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function eliminarPorId($id_usuario){
         
        try {
        	$con = Conexion::conectar();
		    $sql = $con->prepare("DELETE FROM roles WHERE id_usuario = ?");
		    $sql->bindParam(1, $id_usuario);
		    $sql->execute();

        } catch (Exception $e) {
        	echo $e->getMessage();
        }
		    
	}
	
	
}


 ?>