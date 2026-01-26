<?php 

require_once("Conexion/conexionBD.php");

/**
 * 
 */
class TipoPasajero
{
	
	public function listar(){
		$tipospasajeros = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM tipo_pasajero");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$tipospasajeros[] = $filas;
		}

		return $tipospasajeros;		

	}

	public function listarTipoPasajeroPorId($id_tipopasajero){
		$tipopasajero = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM tipo_pasajero WHERE id_tipo = ?");
		$sql->bindParam(1, $id_tipopasajero);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$tipopasajero[] = $filas;
		}

		return $tipopasajero;		

	}

	public function registrar($nombre_tipo){

		    $con = Conexion::conectar();
		    $sql = $con->prepare("INSERT INTO tipo_pasajero (nombre) VALUES(:nombre_tipo);");
            
            $sql->bindParam(":nombre_tipo", $nombre_tipo);

            $sql->execute();
            
            if ($sql) {	
            	header("Location: ../Vista/tipospasajeros.php");
            }

	}

	public function actualizar($id_tipo, $nombre_tipo){


            try {
            	
		        $con = Conexion::conectar();
		        $sql = $con->prepare("UPDATE tipo_pasajero SET nombre = '$nombre_tipo' WHERE id_tipo = '$id_tipo'");

		        $sql->bindParam(":nombre_tipo", $nombre_tipo);
                $sql->bindParam(":id_tipo", $id_tipo);

                $sql->execute();
                
                if ($sql) {
            	   header("Location: ../Vista/tipospasajeros.php");
                }
            } catch (Exception $e) {
            	echo $e->getMessage();
            }


	}

}
 ?>