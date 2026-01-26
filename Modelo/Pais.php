<?php 
require_once("Conexion/conexionBD.php");
/**
 * 
 */
class Pais
{
	public function listar(){
	     $listar = array();
       $con = Conexion::conectar();
       $sql = $con->prepare("SELECT * FROM paises");
       $sql->execute();

       while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
       	    $listar[] = $filas;
       }

       return $listar;
	}

    public function listarPorId($id_pais){
     $listar = array();
       $con = Conexion::conectar();
       $sql = $con->prepare("SELECT * FROM paises WHERE id_pais = ?");
       $sql->bindParam(1, $id_pais);
       $sql->execute();

       while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
       }

       return $listar;
  }

  public function buscarPorNombre($nombre_pais){
     $listar = array();
       $con = Conexion::conectar();
       $sql = $con->prepare("SELECT * FROM paises WHERE pais = ?");
       $sql->bindParam(1, $nombre_pais);
       $sql->execute();

       while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
       }

       return $listar;
  }
	
  public function registrar($nombre_pais){
      try {
          $con = Conexion::conectar();
          $sql = $con->prepare("INSERT INTO paises(pais) VALUES(:nombre_pais)");
          $sql->bindParam(":nombre_pais", $nombre_pais);

          $sql->execute();

          return $id_area = $con->lastInsertId();

      } catch (Exception $e) {
          echo $e->getMessage();
      }
  }

  public function actualizar($nombre_pais, $id_pais){
     try {
        $con = Conexion::conectar();
        $sql = $con->prepare("UPDATE paises SET pais = :nombre_pais WHERE id_pais = :id_pais");
        $sql->bindParam("nombre_pais", $nombre_pais);
        $sql->bindParam("id_pais", $id_pais);

        $sql->execute();
        
     } catch (Exception $e) {
         echo $e->getMessage();
     }
  }




}
 ?>