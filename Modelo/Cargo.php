<?php 

require_once("Conexion/conexionBD.php");

/**
 * 
 */
class Cargo
{

	public function listarCargos(){
		$listar = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM cargos AS c INNER JOIN areas AS a ON
                                      c.id_area = a.id_area INNER JOIN empresas AS e ON
                                      c.id_empresa = e.id_empresa");
                $sql->execute();

                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                	$listar[] = $filas;
                }

                return $listar;
	}

    public function listarCargosPorId($id_cargo){
        $listar = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM cargos WHERE id_cargo = ?");
            $sql->bindParam(1, $id_cargo);
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $listar[] = $filas;
            }

        return $listar;
    }

        public function registrarCargos($nombre_cargo, $id_area, $id_empresa){

            try {
                $con = Conexion::conectar();
                $sql = $con->prepare("INSERT INTO cargos(nombre_cargo, id_area, id_empresa) VALUES(:nombre_cargo, :id_area, :id_empresa)");
                $sql->bindParam(":nombre_cargo", $nombre_cargo);
                $sql->bindParam(":id_area", $id_area);
                $sql->bindParam(":id_empresa", $id_empresa);

                $sql->execute();
                
                return $id_cargo = $con->lastInsertId();

            } catch (Exception $e) {
                echo $e->getMessage();
            }
                
        }

        public function actualizarCargos($id_cargo, $nombre_cargo, $id_area, $id_empresa){

            try {
                $con = Conexion::conectar();
                $sql = $con->prepare("UPDATE cargos SET nombre_cargo = '$nombre_cargo', id_area = '$id_area', id_empresa = '$id_empresa' WHERE id_cargo = '$id_cargo' ");
                $sql->bindParam(":nombre_cargo", $nombre_cargo);
                $sql->bindParam(":id_area", $id_area);
                $sql->bindParam(":id_empresa", $id_empresa);
                $sql->bindParam(":id_cargo", $id_cargo);

                $sql->execute();
                
            } catch (Exception $e) {
                echo $e->getMessage();
            }
               
        }
	
}

 ?>