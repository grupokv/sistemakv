<?php
/*ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log');
error_reporting(E_ALL);*/
/**
 * 
 */
class Conexion
{
	
	public static function conectar()
	{
		try {
			$con = new PDO("mysql:host=localhost;dbname=sistemakv", "root", "");
		} catch (Exception $e) {
			echo "Error al conectar con la base de datos";
			echo $e->getMessage();
		}
		return $con;
	}

	public function iniciarSesion($usuario,$clave){
       $listar = array();
       $con = Conexion::conectar();
       $sql = $con->prepare("SELECT * FROM usuarios WHERE usuario = ? AND clave = ?");
       $sql->bindParam(1, $usuario);
       $sql->bindParam(2, $clave);
       $sql->execute();

       while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
       }
       
       //echo "SELECT * FROM usuarios WHERE usuario = '$usuario' AND clave = '$clave'";

       return $listar;
  }

  

}
 ?>