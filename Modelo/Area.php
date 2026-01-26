<?php 
require_once("Conexion/conexionBD.php");
/**
 * 
 */
class Area
{
	public function listar(){
	     $listar = array();
       $con = Conexion::conectar();
       $sql = $con->prepare("SELECT a.*, e.* FROM areas AS a INNER JOIN empresas AS e ON a.id_empresa = e.id_empresa");
       $sql->execute();

       while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
       	    $listar[] = $filas;
       }

       return $listar;
	}

    public function listarPorId($id_area){
     $listar = array();
       $con = Conexion::conectar();
       $sql = $con->prepare("SELECT a.*, e.* FROM areas AS a INNER JOIN empresas AS e ON a.id_empresa = e.id_empresa WHERE id_area = ?");
       $sql->bindParam(1, $id_area);
       $sql->execute();

       while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
       }

       return $listar;
  }

	public function bloquear($id_area){
        try {
        	$con = Conexion::conectar();
        	$sql = $con->prepare("UPDATE areas SET estado_area = 0 WHERE id_area = ? ");
        	$sql->bindParam(1, $id_area);
        	$sql->execute();
        } catch (Exception $e) {
        	echo $e->getMessage();;
        }


        if ($sql) {
             header("Location: ../Vista/areas.php");
        }
	}

	public function desbloquear($id_area){
        try {
        	$con = Conexion::conectar();
        	$sql = $con->prepare("UPDATE areas SET estado_area = 1 WHERE id_area = ? ");
        	$sql->bindParam(1, $id_area);
        	$sql->execute();
        } catch (Exception $e) {
        	echo $e->getMessage();;
        }

        if ($sql) {
             header("Location: ../Vista/areas.php");
        }
	}

  public function registrar($nombre_area, $id_empresa){
      try {
          $con = Conexion::conectar();
          $sql = $con->prepare("INSERT INTO areas(nombre_area, id_empresa, estado_area) VALUES(:nombre_area, :id_empresa, 1)");
          $sql->bindParam(":nombre_area", $nombre_area);
          $sql->bindParam(":id_empresa", $id_empresa);

          $sql->execute();

          return $id_area = $con->lastInsertId();

      } catch (Exception $e) {
          echo $e->getMessage();
      }
  }

  public function actualizar($nombre_area, $id_empresa, $id_area){
     try {
        $con = Conexion::conectar();
        $sql = $con->prepare("UPDATE areas SET nombre_area = '$nombre_area', id_empresa = '$id_empresa' WHERE id_area = '$id_area' ");
        $sql->bindParam("nombre_area", $nombre_area);
        $sql->bindParam("id_empresa", $id_empresa);
        $sql->bindParam("id_area", $id_area);

        $sql->execute();
        
     } catch (Exception $e) {
         echo $e->getMessage();
     }
  }
}
 ?>