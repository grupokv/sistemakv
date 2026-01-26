<?php 
require_once("Conexion/conexionBD.php");
/**
 * 
 */
class OrdenServicio
{
	 public function listar($fecha){
	 	$listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM orden_servicio WHERE MONTH(fecha_creacion) = :fecha AND estado != 'F' AND estado != 'E' ");
        $sql->bindParam(":fecha", $fecha);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listar[] = $filas;
        }

        return $listar;
	 }

    public function listarOrdenesPendientes($fecha){
        $listarPendientes = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM orden_servicio WHERE MONTH(fecha_creacion) = :fecha AND estado = 'P' ");
        $sql->bindParam(":fecha", $fecha);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listarPendientes[] = $filas;
        }

        return $listarPendientes;
    }

	  public function listarPorId($id_orden){
	 	$listarOSId = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM orden_servicio WHERE id_orden = :id_orden");
        $sql->bindParam(":id_orden", $id_orden);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listarOSId[] = $filas;
        }

        return $listarOSId;
	 }

     public function listarPorIdVehiculo($id_veh){
        $listarPorId = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM orden_servicio WHERE id_vehiculo = ? and (fecha_ejecucion != '' or fecha_ejecucion != '0000-00-00') order by fecha_ejecucion Desc");
        $sql->bindParam(1, $id_empresa);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listarPorId[] = $filas;
        }

        return $listarPorId;
     }

     public function detallePorIdOrden($id){
        $listarDetallePorId = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM detalle_orden_servicio WHERE id_orden_servicio = :id");
        $sql->bindParam(":id", $id);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listarDetallePorId[] = $filas;
        }

        return $listarDetallePorId;
     }

    public function eliminarDetallePorId($id_orden_servicio){
        
            $con = Conexion::conectar();
            $sql = $con->prepare("DELETE FROM detalle_orden_servicio WHERE id_servicio = :id_orden_servicio");
            $sql->bindParam(":id_orden_servicio", $id_orden_servicio);

            //echo "DELETE FROM detalle_orden_servicio WHERE id_servicio = '$id_servicio' ";
            $sql->execute();

    }
    public function actualizarValorTotal($id_orden_servicio, $nuevo_valor){
        try {
            $con = Conexion::conectar();
            $sql = $con->prepare("UPDATE orden_servicio SET valor_total = :nuevo_valor WHERE id_orden = :id_orden_servicio");
            $sql->bindParam(":id_orden_servicio", $id_orden_servicio);
            $sql->bindParam(":nuevo_valor", $nuevo_valor);

            $sql->execute(); 

            //echo "UPDATE orden_servicio SET valor_total = '$nuevo_valor' WHERE id_orden = '$id_orden_servicio'";
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

	public function registrar($id_empresa, $id_vehiculo, $tipo_combustible, $id_proveedor, $id_tipo_servicio, $solicitadopor, $fechai, $fechaf, $detalle, $fecha_creacion, $id_usuario){
            try {
                $con = Conexion::conectar();
                $sql = $con->prepare("INSERT INTO orden_servicio (id_empresa, id_vehiculo, tipo_combustible, id_proveedor, id_tipo_servicio, solicitado_por, fecha_inicial, fecha_final, detalle, valor_total, estado, fecha_creacion, id_usuario) VALUES (:id_empresa, :id_vehiculo, :tipo_combustible, :id_proveedor, :id_tipo_servicio, :solicitadopor, :fechai, :fechaf,  :detalle, '0', 'P', :fecha_creacion, :id_usuario)");

                $sql->bindParam(":id_empresa", $id_empresa);
                $sql->bindParam(":id_vehiculo", $id_vehiculo);
                $sql->bindParam(":tipo_combustible", $tipo_combustible);
                $sql->bindParam(":id_proveedor", $id_proveedor);
                $sql->bindParam(":id_tipo_servicio", $id_tipo_servicio);
                $sql->bindParam(":solicitadopor", $solicitadopor);
                $sql->bindParam(":fechai", $fechai);
                $sql->bindParam(":fechaf", $fechaf);
                $sql->bindParam(":detalle", $detalle);
                $sql->bindParam(":fecha_creacion", $fecha_creacion);
                $sql->bindParam(":id_usuario", $id_usuario);

                $sql->execute();    
                
                $id_orden = $con->lastInsertId();

                //echo "INSERT INTO orden_servicio (id_empresa, id_vehiculo, tipo_combustible, id_proveedor, id_tipo_servicio, solicitado_por, fecha_inicial, fecha_final, detalle, valor_total, estado, fecha_creacion, id_usuario) VALUES ('$id_empresa', '$id_vehiculo', '$tipo_combustible', '$id_proveedor', '$id_tipo_servicio', '$solicitadopor', '$fechai', '$fechaf',  '$detalle', '0', 'A', '$fecha_creacion', '$id_usuario')";

                return $id_orden;

            } catch (Exception $e) {
                echo $e->getMessage();
            }
        
	}

    public function actualizar($id_orden, $id_empresa, $id_vehiculo, $tipo_combustible, $id_proveedor, $id_tipo_servicio, $solicitado_por, $fecha_inicial, $fecha_final, $detalle, $fecha_creacion, $id_usuario){
            try {
                $con = Conexion::conectar();
                $sql = $con->prepare("UPDATE orden_servicio SET id_empresa = :id_empresa, id_vehiculo = :id_vehiculo, tipo_combustible = :tipo_combustible, id_proveedor = :id_proveedor, id_tipo_servicio = :id_tipo_servicio, solicitado_por = :solicitado_por, fecha_inicial = :fecha_inicial, fecha_final = :fecha_final, detalle = :detalle, valor_total = :valor_total, estado = :estado, fecha_creacion = :fecha_creacion, id_usuario = :id_usuario WHERE id_orden = :id_orden");

                $sql->bindParam(":id_orden", $id_orden);
                $sql->bindParam(":id_empresa", $id_empresa);
                $sql->bindParam(":id_vehiculo", $id_vehiculo);
                $sql->bindParam(":tipo_combustible", $tipo_combustible);
                $sql->bindParam(":id_proveedor", $id_proveedor);
                $sql->bindParam(":id_tipo_servicio", $id_tipo_servicio);
                $sql->bindParam(":solicitado_por", $solicitado_por);
                $sql->bindParam(":fecha_inicial", $fecha_inicial);
                $sql->bindParam(":fecha_final", $fecha_final);
                $sql->bindParam(":detalle", $detalle);
                $sql->bindParam(":valor_total", $valor_total);
                $sql->bindParam(":estado", $estado);
                $sql->bindParam(":fecha_creacion", $fecha_creacion);
                $sql->bindParam(":id_usuario", $id_usuario);

                $sql->execute();    

                //echo "UPDATE orden_servicio SET id_empresa = '$id_empresa', id_vehiculo = '$id_vehiculo', tipo_combustible = '$tipo_combustible', id_proveedor = '$id_proveedor', id_tipo_servicio = '$id_tipo_servicio', solicitado_por = '$solicitado_por', fecha_inicial = '$fecha_inicial', fecha_final = '$fecha_final', detalle = '$detalle', valor_total = '$valor_total', estado = '$estado', fecha_creacion = '$fecha_creacion', id_usuario = '$id_usuario' WHERE id_orden = '$id_orden'";


            } catch (Exception $e) {
                echo $e->getMessage();
            }
        
    }

     public function registrarDetalle($id_orden_servicio, $id_categoria, $id_subcategoria, $cantidad, $valor, $nuevo_valor){
            try {
                    $con = Conexion::conectar();
                    $sql = $con->prepare("INSERT INTO detalle_orden_servicio (id_orden_servicio, id_categoria, id_subcategoria, cantidad, valor) VALUES (:id_orden_servicio, :id_categoria, :id_subcategoria, :cantidad, :valor)");

                    $sql->bindParam(":id_orden_servicio", $id_orden_servicio);
                    $sql->bindParam(":id_categoria", $id_categoria);
                    $sql->bindParam(":id_subcategoria", $id_subcategoria);
                    $sql->bindParam(":cantidad", $cantidad);
                    $sql->bindParam(":valor", $valor);

                    //echo "INSERT INTO detalle_orden_servicio (id_orden_servicio, id_categoria, id_subcategoria, cantidad, valor) VALUES ('$id_orden_servicio', '$id_categoria', '$id_subcategoria', '$cantidad', '$valor')";

                    $sql->execute();    
                    
                    $id_orden = $con->lastInsertId();

                    $sql1 = $con->prepare("UPDATE orden_servicio SET valor_total = :nuevo_valor WHERE id_orden = :id_orden_servicio");

                    $sql1->bindParam(":id_orden_servicio", $id_orden_servicio);
                    $sql1->bindParam(":nuevo_valor", $nuevo_valor);

                    //echo "UPDATE orden_servicio SET valor_total = '$nuevo_valor' WHERE id_orden = '$id_orden_servicio'";

                    $sql1->execute();    
                    
                    return $id_orden;

            } catch (Exception $e) {
                echo $e->getMessage();
            }
        
     }

     public function cancelar($id_orden_servicio, $motivo){
            try {
                    $con = Conexion::conectar();
                    $sql = $con->prepare("UPDATE orden_servicio SET estado = 'C', motivo_cancelacion = :motivo  WHERE id_orden = :id_orden_servicio");

                    $sql->bindParam(":id_orden_servicio", $id_orden_servicio);
                    $sql->bindParam(":motivo", $motivo);

                    $sql->execute();    
                    
                    //echo "UPDATE orden_servicio SET estado = 'C', motivo_cancelacion = '$motivo'  WHERE id_orden = '$id_orden_servicio' ";

            } catch (Exception $e) {
                echo $e->getMessage();
            }
        
     }

     public function finalizar($id_orden_servicio, $valor, $factura, $fecha){
            try {
                    $con = Conexion::conectar();
                    $sql1 = $con->prepare("UPDATE orden_servicio SET estado = 'F', comprobante = :factura, valor_final = :valor, fecha_ejecucion = :fecha WHERE id_orden = :id_orden_servicio");

                    $sql1->bindParam(":id_orden_servicio", $id_orden_servicio);
                    $sql1->bindParam(":factura", $factura);
                    $sql1->bindParam(":valor", $valor);
                    $sql1->bindParam(":fecha", $fecha);
                    $sql1->execute();

            } catch (Exception $e) {
                echo $e->getMessage();
            }
        
    }

    public function rechazar($id_orden_servicio, $motivo){
            try {
                    $con = Conexion::conectar();
                    $sql = $con->prepare("UPDATE orden_servicio SET estado = 'R', motivo_cancelacion = :motivo  WHERE id_orden = :id_orden_servicio");

                    $sql->bindParam(":id_orden_servicio", $id_orden_servicio);
                    $sql->bindParam(":motivo", $motivo);

                    $sql->execute();    

            } catch (Exception $e) {
                echo $e->getMessage();
            }
        
    }

    public function aprobar($id_orden_servicio){
        try {
            $con = Conexion::conectar();
            $sql = $con->prepare("UPDATE orden_servicio SET estado = 'A' WHERE id_orden = :id_orden_servicio");

            $sql->bindParam(":id_orden_servicio", $id_orden_servicio);

            $sql->execute();    

            if ($sql) {
                return 1;
            }else{
                return 2;
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function eliminar($id_orden_servicio){
            try {
                    $con = Conexion::conectar();
                    $sql = $con->prepare("UPDATE orden_servicio SET estado = 'E' WHERE id_orden = :id_orden_servicio");

                    $sql->bindParam(":id_orden_servicio", $id_orden_servicio);

                    $sql->execute();    

            } catch (Exception $e) {
                echo $e->getMessage();
            }
        
    }


}
 ?>