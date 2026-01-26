<?php 
require_once 'BD/conexion.php';
/**
 * 
 */
class Usuario
{
	
	public function listarTodos(){
		$usuarios = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM usuario");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$usuarios[] = $filas;
		}

		return $usuarios;
	}

	public function listarUsuariosPorId($id){
		$usuariosPorId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM usuario WHERE id = :id");
		$sql->bindParam(":id", $id);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$usuariosPorId[] = $filas;
		}

		return $usuariosPorId;
	}

	public function listarCargoPorUsuario($id){
		$usuarioCargo = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM cargo WHERE id = :id");
		$sql->bindParam(":id", $id);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$usuarioCargo[] = $filas;
		}

		return $usuarioCargo;
	}

}

 ?>