<?php 
require_once("Conexion/conexionBD.php");

    class Administracion{

        public function listarPermisosModVehiculos(){
            $permisosModVeh = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM permisos_usuarios_mod_vehiculos ORDER BY id DESC");
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                $permisosModVeh[] = $filas;
            }
            
            return $permisosModVeh;
        }

        public function listarPermisosModVehiculosIdUsuario($id_usuario){
            $permisosModVehID = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM permisos_usuarios_mod_vehiculos WHERE id_usuario = :id_usuario");
            $sql->bindParam(":id_usuario", $id_usuario);
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                $permisosModVehID[] = $filas;
            }
            
            return $permisosModVehID;
        }

    }

?>