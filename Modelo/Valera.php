<?php 
require_once("Conexion/conexionBD.php");
/**
 * 
 */
class Valera
{
	public function listar(){
	     $listar = array();
       $con = Conexion::conectar();
       $sql = $con->prepare("SELECT * FROM vales_generados order by id Desc");
       $sql->execute();

       while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
       	    $listar[] = $filas;
       }

       return $listar;
	}

	public function listarPorId($id){
     $listar = array();
       $con = Conexion::conectar();
       $sql = $con->prepare("SELECT * FROM vales_generados WHERE id = ? order by id Desc");
       $sql->bindParam(1, $id);
       $sql->execute();

       while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
       }

       return $listar;
  }
  
  public function listarUltimo($empresa){
     $listar = array();
       $con = Conexion::conectar();
       $sql = $con->prepare("SELECT * FROM vales_generados WHERE empresa = ? order by id Desc limit 1");
	   $sql->bindParam(1, $empresa);
       $sql->execute();

       while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
       }

       return $listar;
  }

	public function listarPorEmpresa($empresa){
     $listar = array();
       $con = Conexion::conectar();
       $sql = $con->prepare("SELECT * FROM vales_generados WHERE empresa = ? order by id Desc");
       $sql->bindParam(1, $empresa);
       $sql->execute();

       while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
       }

       return $listar;
  }

    public function listarPorIdUsuario($id){
     $listar = array();
       $con = Conexion::conectar();
       $sql = $con->prepare("SELECT * FROM vales_generados WHERE id_usuario = ? order by id Desc");
       $sql->bindParam(1, $id);
       $sql->execute();

       while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
       }

       return $listar;
  }

  public function registrar($empresa, $num_inicial, $num_final, $cantidad, $fecha, $usuario){
      try {
          $con = Conexion::conectar();
          $sql = $con->prepare("INSERT INTO vales_generados (empresa, num_inicial, num_final, cantidad, fecha, id_usuario) VALUES(:empresa, :num_inicial, :num_final, :cantidad, :fecha, :id_usuario)");
          $sql->bindParam(":empresa", $empresa);
          $sql->bindParam(":num_inicial", $num_inicial);
		  $sql->bindParam(":num_final", $num_final);
		  $sql->bindParam(":cantidad", $cantidad);
		  $sql->bindParam(":fecha", $fecha);
		  $sql->bindParam(":usuario", $usuario);
          $sql->execute();

          return $id_area = $con->lastInsertId();

      } catch (Exception $e) {
          echo $e->getMessage();
      }
  }

}
 ?>