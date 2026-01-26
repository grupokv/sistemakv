<?php 

require_once("Conexion/conexionBD.php");
/**
 * 
 */
class Modulo
{
	
	public function listar(){
		$listar = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM modulos ORDER BY nombre_modulo ASC");
		$sql->execute();

		while ( $filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
		}

		return $listar;
	}



	public function listarPorId($id_modulo){
		$listarId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM modulos WHERE id_modulo = ?");
		$sql->bindParam(1, $id_modulo);
		$sql->execute();

		while ( $filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listarId[] = $filas;
		}

		return $listarId;
	}

	public function listarPorIdUsuarioYModulo($id_usuario, $id_modulo){
		$listarIdUsuario = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM modulos WHERE id_modulo = :id_modulo AND id_usuario = :id_usuario ");
		$sql->bindParam(":id_usuario", $id_usuario);
		$sql->bindParam(":id_modulo", $id_modulo);
		$sql->execute();

		echo "SELECT * FROM modulos WHERE id_modulo = '$id_modulo' AND id_usuario = '$id_usuario' ";

		while ( $filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listarIdUsuario[] = $filas;
		}

		return $listarIdUsuario;
	}


	public function bloquear($id_modulo){
        try {
		    $con = Conexion::conectar();
		    $sql = $con->prepare("UPDATE modulos SET estado = 0 WHERE id_modulo = ?");
		    $sql->bindParam(1, $id_modulo);
		    $sql->execute();

		    if ($sql) {
		    	header("Location: ../Vista/modulos.php");
		    }
        } catch (Exception $e) {
         	echo $e->getMessage();
        }
	}

	public function desbloquear($id_modulo){
        try {
		    $con = Conexion::conectar();
		    $sql = $con->prepare("UPDATE modulos SET estado = 1 WHERE id_modulo = ?");
		    $sql->bindParam(1, $id_modulo);
		    $sql->execute();


		    if ($sql) {
		    	header("Location: ../Vista/modulos.php");
		    }
        } catch (Exception $e) {
         	echo $e->getMessage();
        }
	}

	public function registrar($nombre_modulo, $id_padre, $link, $menu){
        try {
		    $con = Conexion::conectar();
		    $sql = $con->prepare("INSERT INTO modulos (nombre_modulo, estado, id_padre, link, menu) VALUES (:nombre_modulo, 1, :id_padre, :link, :menu)");
		    $sql->bindParam(":nombre_modulo", $nombre_modulo);
		    $sql->bindParam(":id_padre", $id_padre);
		    $sql->bindParam(":link", $link);
		    $sql->bindParam(":menu", $menu);
		    $sql->execute();

		    return $id_modulo = $con->lastInsertId();


        } catch (Exception $e) {
         	echo $e->getMessage();
        }
	}


	public function actualizar($id_modulo, $nombre_modulo, $id_padre, $link, $estado){
        try {
		    $con = Conexion::conectar();
		    $sql = $con->prepare("UPDATE modulos SET nombre_modulo = :nombre_modulo, estado = :estado, id_padre =  :id_padre, link = :link WHERE id_modulo = :id_modulo ");
		    
		    $sql->bindParam(":id_modulo", $id_modulo);
		    $sql->bindParam(":nombre_modulo", $nombre_modulo);
		    $sql->bindParam(":estado", $estado);
		    $sql->bindParam(":id_padre", $id_padre);
		    $sql->bindParam(":link", $link);
		    $sql->execute();

		   
        } catch (Exception $e) {
         	echo $e->getMessage();
        }
	}
}
 ?>