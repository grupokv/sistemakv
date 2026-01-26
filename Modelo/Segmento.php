<?php 

require_once("Conexion/conexionBD.php");

/**
 * 
 */
class Segmento 
{

	public function listar(){
		$listar = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM segmentos");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listar[] = $filas;
		}

		return $listar;
	}

	public function listarPorId($id_segmento){
		$listar = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM segmentos Where id_segmento = ?");
		$sql->bindParam(1, $id_segmento);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listar[] = $filas;
		}

		return $listar;
	}

	public function registrar($detalle){
        try {
        	
		    $con = Conexion::conectar();
		    $sql = $con->prepare("INSERT INTO segmentos (detalle) VALUES(:detalle);");
		    $sql->bindParam(":detalle", $detalle);
		    $sql->execute();

		    return $id_segmento = $con->lastInsertId();

        } catch (Exception $e) {
        	echo $e->getMessage();
        }
	}

	public function actualizar($id_segmento, $detalle){
        try {
        	
		    $con = Conexion::conectar();
		    $sql = $con->prepare("UPDATE segmentos SET detalle = '$detalle' WHERE id_segmento = '$id_segmento'");
		    $sql->bindParam(":id_segmento", $id_segmento);
		    $sql->bindParam(":detalle", $detalle);
		    $sql->execute();

        } catch (Exception $e) {
        	echo $e->getMessage();
        }
	}
}


 ?>