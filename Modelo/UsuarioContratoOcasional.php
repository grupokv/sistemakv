<?php 

require_once("Conexion/conexionBD.php");
/**
  * 
  */
 class UsuarioContratoOcasional
 {
 	
 	public function registrar($id_contrato, $nombre_usuario, $numero_documento){
           try {
           	  $con = Conexion::conectar();
           	  	$sql = $con->prepare("INSERT INTO usuarios_contratos_ocasionales(id_contrato, nombre_usuario, numero_documento) VALUES(:id_contrato, :nombre_usuario, :numero_documento)");
                
                $sql->bindParam(":id_contrato", $id_contrato);
                $sql->bindParam(":nombre_usuario", $nombre_usuario);
           	  	$sql->bindParam(":numero_documento", $numero_documento);

           	  	$sql->execute();

                //echo "INSERT INTO usuarios_contratos_ocasionales(id_contrato, nombre_usuario, numero_documento) VALUES('$id_contrato', '$nombre_usuario', '$numero_documento')";
                
                
           } catch (Exception $e) {
           	    echo $e->getMessage();;
           }
 	}

  public function listarUsuariosPorContrato($id_contrato_ocasional){
      $listarCO = array();
      $con = Conexion::conectar();
      $sql = $con->prepare("SELECT * FROM usuarios_contratos_ocasionales WHERE id_contrato = :id_contrato_ocasional");
      $sql->bindParam(":id_contrato_ocasional", $id_contrato_ocasional);
      $sql->execute();

      while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        $listarCO[] = $filas;
      }

      return $listarCO;
  }

 } 


 ?>