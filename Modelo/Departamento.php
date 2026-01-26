<?php 
require_once("Conexion/conexionBD.php");
/**
 * 
 */
class Departamento
{
	public function listar(){
	     $listar = array();
       $con = Conexion::conectar();
       $sql = $con->prepare("SELECT * FROM departamentos");
       $sql->execute();

       while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
       	    $listar[] = $filas;
       }

       return $listar;
	}

    public function listarPorId($id_departamento){
     $listar = array();
       $con = Conexion::conectar();
       $sql = $con->prepare("SELECT * FROM departamentos WHERE id_departamento = ?");
       $sql->bindParam(1, $id_departamento);
       $sql->execute();

       while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
       }

       return $listar;
  }

  public function buscarPorNombre($nombre_departamento, $id_pais){
     $listar = array();
       $con = Conexion::conectar();
       $sql = $con->prepare("SELECT * FROM departamentos WHERE departamento = ? and id_pais = ?");
       $sql->bindParam(1, $nombre_departamento);
       $sql->bindParam(2, $id_pais);
       $sql->execute();

       while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
       }

       return $listar;
  }
	
  public function registrar($nombre_departamento,$id_pais){
      try {
          $con = Conexion::conectar();
          $sql = $con->prepare("INSERT INTO departamentos(id_pais, departamento) VALUES(:id_pais, :nombre_departamento)");
          $sql->bindParam(":id_pais", $id_pais);
          $sql->bindParam(":nombre_departamento", $nombre_departamento);

          $sql->execute();

          return $id_area = $con->lastInsertId();

      } catch (Exception $e) {
          echo $e->getMessage();
      }
  }

  public function actualizar($nombre_departamento, $id_pais, $id_departamento){
     try {
        $con = Conexion::conectar();
        $sql = $con->prepare("UPDATE departamentos SET id_pais = :id_pais, departamento = :nombre_departamento WHERE id_departamento = :id_departamento");
        $sql->bindParam("nombre_departamento", $nombre_departamento);
        $sql->bindParam("id_pais", $id_pais);
        $sql->bindParam("id_departamento", $id_departamento);

        $sql->execute();
        
     } catch (Exception $e) {
         echo $e->getMessage();
     }
  }




}
 ?>