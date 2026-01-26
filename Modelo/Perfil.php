<?php 

require_once("Conexion/conexionBD.php");

/**
 * 
 */
class Perfil
{
	public function listar(){
		$perfiles = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM perfiles");
                $sql->execute();
        
                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                	$perfiles[] = $filas;
                }

                return $perfiles;
	}

        public function listarPerfilesPorId($id_perfil){
                $perfiles = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM perfiles WHERE id_perfil = ? ");
                $sql->bindParam(1, $id_perfil);
                $sql->execute();
        
                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                        $perfiles[] = $filas;
                }

                return $perfiles;
        }

        public function registrarPerfil($nombre_perfil){
            try {
                $con = Conexion::conectar();
                $sql = $con->prepare("INSERT INTO perfiles(nombre_perfil) VALUES(:nombre_perfil)");
                $sql->bindParam(":nombre_perfil", $nombre_perfil);
                $sql->execute();

                return $id_perfil = $con->lastInsertId();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
                

        }

        public function actualizarPerfil($id_perfil, $nombre_perfil){
                $con = Conexion::conectar();
                $sql = $con->prepare("UPDATE perfiles SET nombre_perfil = '$nombre_perfil' WHERE id_perfil = '$id_perfil'");
                $sql->bindParam(":nombre_perfil", $nombre_perfil);
                $sql->bindParam(":id_perfil", $id_perfil);
                $sql->execute();

                if ($sql) {
                    header("Location: ../Vista/perfiles.php");
                }


        }


}
 ?>