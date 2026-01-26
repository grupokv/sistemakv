<?php 

require_once("Conexion/conexionBD.php");

/**
 * 
 */
class Menu
{

	public function Subnivel($id_padre){
		$menu2 = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM modulos WHERE id_padre = ? AND menu = 'S' AND estado = 1 ORDER BY nombre_modulo ASC");
		$sql->bindParam(1, $id_padre);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$menu2[] = $filas;
		}

		return $menu2;		

	}

	public function Permisos($id_usuario,$id_modulo){
		$menu2 = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM roles WHERE id_usuario = :id_usuario AND id_modulo = :id_modulo ");
		$sql->bindParam(":id_usuario", $id_usuario);
		$sql->bindParam(":id_modulo", $id_modulo);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$menu2[] = $filas;
		}

		return $menu2;		

	}
    
    public function listarOpcionesBotones(){
        $menu3 = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM modulos WHERE menu = 'N' ");
        $sql->execute();
        
        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $menu3[] = $filas;
        }
        
        return $menu3;
    }

	


}
 ?>