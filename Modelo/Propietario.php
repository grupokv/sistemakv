<?php 
require_once("Conexion/conexionBD.php");

class Propietario
{
	public function listarPropietarios(){
	    $listarProp = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM propietarios WHERE estado = 1 ");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
       	    $listarProp[] = $filas;
        }

        return $listarProp;
	}

	public function listarPropietarioID($id_propietario){
	    $listarPropID = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM propietarios WHERE id_propietario = :id_propietario");
        $sql->bindParam(":id_propietario", $id_propietario);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
       	    $listarPropID[] = $filas;
        }

        return $listarPropID;
	}

	public function registrarPropietario($nombre, $tipo_documento, $numero_documento, $telefono, $correo, $ciudad, $direccion, $entidad_bancaria, $titular_cuenta, $cc_titular, $tipo_cuenta, $num_cuenta, $estado, $fecha_registro, $fecha_ultima_modificacion, $id_usuario_registro, $id_usuario_ultima_modificacion){
        try {
            $con = Conexion::conectar();
            $sql = $con->prepare("INSERT INTO propietarios (nombre, tipo_documento, numero_documento, telefono, correo, ciudad, direccion, entidad_bancaria, titular_cuenta, cc_titular, tipo_cuenta, num_cuenta, estado, fecha_registro, fecha_ultima_modificacion, id_usuario_registro, id_usuario_ultima_modificacion) VALUES(:nombre, :tipo_documento, :numero_documento, :telefono, :correo, :ciudad, :direccion, :entidad_bancaria, :titular_cuenta, :cc_titular, :tipo_cuenta, :num_cuenta, :estado, :fecha_registro, :fecha_ultima_modificacion, :id_usuario_registro, :id_usuario_ultima_modificacion) ");
            $sql->bindParam(":nombre", $nombre);
            $sql->bindParam(":tipo_documento", $tipo_documento);
            $sql->bindParam(":numero_documento", $numero_documento);
            $sql->bindParam(":telefono", $telefono);
            $sql->bindParam(":correo", $correo);
            $sql->bindParam(":ciudad", $ciudad);
            $sql->bindParam(":direccion", $direccion);
            $sql->bindParam(":entidad_bancaria", $entidad_bancaria);
            $sql->bindParam(":titular_cuenta", $titular_cuenta);
            $sql->bindParam(":cc_titular", $cc_titular);
            $sql->bindParam(":tipo_cuenta", $tipo_cuenta);
            $sql->bindParam(":num_cuenta", $num_cuenta);
            $sql->bindParam(":estado", $estado);
            $sql->bindParam(":fecha_registro", $fecha_registro);
            $sql->bindParam(":fecha_ultima_modificacion", $fecha_ultima_modificacion);
            $sql->bindParam(":id_usuario_registro", $id_usuario_registro);
            $sql->bindParam(":id_usuario_ultima_modificacion", $id_usuario_ultima_modificacion);

            $sql->execute();

            if($sql){
                return 1;
            }else{
                return 0;
            }

        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
	    
	}

	public function actualizarPropietario($id_propietario, $nombre, $tipo_documento, $numero_documento, $telefono, $correo, $ciudad, $direccion, $entidad_bancaria, $titular_cuenta, $cc_titular, $tipo_cuenta, $num_cuenta, $estado, $fecha_ultima_modificacion, $id_usuario_ultima_modificacion){
        try {
            $con = Conexion::conectar();
            $sql = $con->prepare("UPDATE propietarios SET nombre = :nombre, tipo_documento = :tipo_documento, numero_documento = :numero_documento, telefono = :telefono, correo = :correo, ciudad = :ciudad, direccion = :direccion, entidad_bancaria = :entidad_bancaria, titular_cuenta = :titular_cuenta, cc_titular = :cc_titular, tipo_cuenta = :tipo_cuenta, num_cuenta = :num_cuenta, estado = :estado, fecha_ultima_modificacion = :fecha_ultima_modificacion, id_usuario_ultima_modificacion = :id_usuario_ultima_modificacion WHERE id_propietario = :id_propietario ");
            
            $sql->bindParam(":nombre", $nombre);
            $sql->bindParam(":tipo_documento", $tipo_documento);
            $sql->bindParam(":numero_documento", $numero_documento);
            $sql->bindParam(":telefono", $telefono);
            $sql->bindParam(":correo", $correo);
            $sql->bindParam(":ciudad", $ciudad);
            $sql->bindParam(":direccion", $direccion);
            $sql->bindParam(":entidad_bancaria", $entidad_bancaria);
            $sql->bindParam(":titular_cuenta", $titular_cuenta);
            $sql->bindParam(":cc_titular", $cc_titular);
            $sql->bindParam(":tipo_cuenta", $tipo_cuenta);
            $sql->bindParam(":num_cuenta", $num_cuenta);
            $sql->bindParam(":estado", $estado);
            $sql->bindParam(":fecha_ultima_modificacion", $fecha_ultima_modificacion);
            $sql->bindParam(":id_usuario_ultima_modificacion", $id_usuario_ultima_modificacion);
            $sql->bindParam(":id_propietario", $id_propietario);

            $sql->execute();

            if($sql){
                return 1;
            }
            //echo "UPDATE propietarios SET nombre = '$nombre', tipo_documento = '$tipo_documento', numero_documento = '$numero_documento', telefono = '$telefono', correo = '$correo', ciudad = '$ciudad', direccion = '$direccion', entidad_bancaria = '$entidad_bancaria', titular_cuenta = '$titular_cuenta', cc_titular = '$cc_titular', tipo_cuenta = '$tipo_cuenta', num_cuenta = '$num_cuenta', estado = '$estado', fecha_ultima_modificacion = '$fecha_ultima_modificacion', id_usuario_ultima_modificacion = '$id_usuario_ultima_modificacion' WHERE id_propietario = '$id_propietario'";

        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
	    
	}

}
 ?>