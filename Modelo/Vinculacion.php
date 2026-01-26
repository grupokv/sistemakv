<?php
require_once("Conexion/conexionBD.php");    
    
class Vinculacion{
    
    public function listarSolicitudes(){
        
        $listarSolicitudesVinculaciones = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM  solicitudes_vinculaciones");
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $listarSolicitudesVinculaciones[] = $filas;
        }
        
        return $listarSolicitudesVinculaciones;
    }
    
    public function listarSolicitudesId($id_solicitud_vinculacion){
        
        $listarSolicitudesVinculacionesId = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM  solicitudes_vinculaciones WHERE id_solicitud_vinculacion = :id_solicitud_vinculacion");
        $sql->bindParam(":id_solicitud_vinculacion", $id_solicitud_vinculacion);
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $listarSolicitudesVinculacionesId[] = $filas;
        }
        
        return $listarSolicitudesVinculacionesId;
    }
 
    
    public function registrarSolicitudVinculacion($nombres_apellidos, $num_documento, $telefono, $correo_electronico, $ciudad_residencia, $placa, $tipo_vehiculo, $marca, $modelo, $motivo, $fecha){
        try{
            $con = Conexion::conectar();
            $sql = $con->prepare("INSERT INTO solicitudes_vinculaciones (nombres_apellidos, num_documento, telefono, correo_electronico, ciudad_residencia, placa, tipo_vehiculo, marca, modelo, motivo, fecha, estado) VALUES(:nombres_apellidos, :num_documento, :telefono, :correo_electronico, :ciudad_residencia, :placa, :tipo_vehiculo, :marca, :modelo, :motivo, :fecha, 'P')");
            $sql->bindParam(":nombres_apellidos", $nombres_apellidos);
            $sql->bindParam(":num_documento", $num_documento);
            $sql->bindParam(":telefono", $telefono);
            $sql->bindParam(":correo_electronico", $correo_electronico);
            $sql->bindParam(":ciudad_residencia", $ciudad_residencia);
            $sql->bindParam(":placa", $placa);
            $sql->bindParam(":tipo_vehiculo", $tipo_vehiculo);
            $sql->bindParam(":marca", $marca);
            $sql->bindParam(":modelo", $modelo);
            $sql->bindParam(":motivo", $motivo);
            $sql->bindParam(":fecha", $fecha);
            $sql->execute();
            
            echo "INSERT INTO solicitudes_vinculaciones (nombres_apellidos, num_documento, telefono, correo_electronico, ciudad_residencia, placa, tipo_vehiculo, marca, modelo, motivo, fecha, estado) VALUES('$nombres_apellidos', '$num_documento', '$telefono', '$correo_electronico', '$ciudad_residencia', '$placa', '$tipo_vehiculo', '$marca', '$modelo', '$motivo', '$fecha', 'P')";
            
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    
    public function actualizarEstadoSolicitudVinculacion($id_revisado_por){
        try{
            $con = Conexion::conectar();
            $sql = $con->prepare("UPDATE solicitudes_vinculaciones SET estado= 'R' AND id_revisado_por = :id_revisado_por");
            $sql->bindParam(":id_revisado_por", $id_revisado_por);
            $sql->execute();
            
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    
}

?>