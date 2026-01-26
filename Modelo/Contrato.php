<?php 
require_once("Conexion/conexionBD.php");

class Contrato
{
	
	public function listarId($id_contrato){
        $contratos = array();
        $con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM contratos WHERE id_contrato = :id_contrato");
        $sql->bindParam(":id_contrato", $id_contrato);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$contratos[] = $filas;
        }

        return $contratos;
	}

    public function listarUsuariosPorContrato($id_contrato){
        $contratos = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM usuarios_contratos_fijos WHERE id_contrato = :id_contrato");
        $sql->bindParam(":id_contrato", $id_contrato);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $contratos[] = $filas;
        }

        return $contratos;
    }

	public function listarTodos(){
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM contratos AS c INNER JOIN empresas AS e ON c.id_empresa = e.id_empresa INNER JOIN clientes AS cl ON c.id_cliente = cl.id_cliente  order by c.id_contrato ASC");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listar[] = $filas;
        }

        return $listar;
	}

	public function listarContratos(){
        $listarContratos = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM contratos ORDER BY id_contrato ASC");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listarContratos[] = $filas;
        }

        return $listarContratos;
	}

    public function listarTodosActivos($fecha){
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM contratos AS c INNER JOIN empresas AS e ON c.id_empresa = e.id_empresa INNER JOIN clientes AS cl ON c.id_cliente = cl.id_cliente WHERE fecha_final_contrato >= :fecha order by c.id_contrato ASC");
        $sql->bindParam(":fecha", $fecha);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }

        return $listar;
    }

	public function registrar($numero_contrato, $id_tipo_contrato, $id_empresa, $id_cliente, $objeto_contrato, $fecha_inicial_contrato, $fecha_final_contrato, $fecha_creacion_contrato, $hora_creacion_contrato, $id_ciudad, $id_responsable, $doc_fotocopia_contrato, $nombre_responsable, $numero_documento_responsable, $direccion_responsable, $telefono_responsable){
            try {
                        $con = Conexion::conectar();
                        $sql = $con->prepare("INSERT INTO contratos(numero_contrato, id_tipo_contrato, id_empresa, id_cliente, objeto_contrato, fecha_inicial_contrato, fecha_final_contrato, fecha_creacion_contrato, hora_creacion_contrato, id_ciudad, id_responsable, doc_fotocopia_contrato, nombre_responsable, numero_documento_responsable, direccion_responsable, telefono_responsable) VALUES (:numero_contrato, :id_tipo_contrato, :id_empresa, :id_cliente, :objeto_contrato, :fecha_inicial_contrato, :fecha_final_contrato, :fecha_creacion_contrato, :hora_creacion_contrato, :id_ciudad, :id_responsable, :doc_fotocopia_contrato, :nombre_responsable, :numero_documento_responsable, :direccion_responsable, :telefono_responsable) ");

                $sql->bindParam(":numero_contrato", $numero_contrato);
                $sql->bindParam(":id_tipo_contrato", $id_tipo_contrato);
                $sql->bindParam(":id_empresa", $id_empresa);
                $sql->bindParam(":id_cliente", $id_cliente);
                $sql->bindParam(":objeto_contrato", $objeto_contrato);
                $sql->bindParam(":fecha_inicial_contrato", $fecha_inicial_contrato);
                $sql->bindParam(":fecha_final_contrato", $fecha_final_contrato);
                $sql->bindParam(":fecha_creacion_contrato", $fecha_creacion_contrato);
                $sql->bindParam(":hora_creacion_contrato", $hora_creacion_contrato);
                $sql->bindParam(":id_ciudad", $id_ciudad);
                $sql->bindParam(":id_responsable", $id_responsable);
                $sql->bindParam(":doc_fotocopia_contrato", $doc_fotocopia_contrato);
                $sql->bindParam(":nombre_responsable", $nombre_responsable);
                $sql->bindParam(":numero_documento_responsable", $numero_documento_responsable);
                $sql->bindParam(":direccion_responsable", $direccion_responsable);
                $sql->bindParam(":telefono_responsable", $telefono_responsable);

                $sql->execute();

                //echo "INSERT INTO contratos(numero_contrato, id_tipo_contrato, id_empresa, id_cliente, objeto_contrato, fecha_inicial_contrato, fecha_final_contrato, fecha_creacion_contrato, hora_creacion_contrato, id_ciudad, id_responsable, doc_fotocopia_contrato, nombre_responsable, numero_documento_responsable, direccion_responsable, telefono_responsable) VALUES ('$numero_contrato', '$id_tipo_contrato', '$id_empresa', '$id_cliente', '$objeto_contrato', '$fecha_inicial_contrato', '$fecha_final_contrato', '$fecha_creacion_contrato', '$hora_creacion_contrato', '$id_ciudad', '$id_responsable', '$doc_fotocopia_contrato', '$nombre_responsable', '$numero_documento_responsable', '$direccion_responsable', '$telefono_responsable')";

                if ($sql) {
                        $id_contrato = $con->lastInsertId();
                        return $id_contrato;

                }

        } catch (Exception $e) {
                        echo $e->getMessage();
                }       
        }

    public function actualizarContrato($id_contrato, $numero_contrato, $id_tipo_contrato, $id_empresa, $id_cliente, $objeto_contrato, $fecha_inicial_contrato, $fecha_final_contrato, $fecha_creacion_contrato, $hora_creacion_contrato, $id_ciudad, $id_responsable, $doc_fotocopia_contrato, $nombre_responsable, $numero_documento_responsable, $direccion_responsable, $telefono_responsable){
        try {
            $con = Conexion::conectar();
            $sql = $con->prepare("UPDATE contratos SET numero_contrato = :numero_contrato, id_tipo_contrato = :id_tipo_contrato, id_empresa = :id_empresa, id_cliente = :id_cliente, objeto_contrato = :objeto_contrato, fecha_inicial_contrato = :fecha_inicial_contrato, fecha_final_contrato = :fecha_final_contrato, fecha_creacion_contrato = :fecha_creacion_contrato, hora_creacion_contrato = :hora_creacion_contrato, id_ciudad = :id_ciudad, id_responsable = :id_responsable, doc_fotocopia_contrato = :doc_fotocopia_contrato, nombre_responsable = :nombre_responsable, numero_documento_responsable = :numero_documento_responsable, direccion_responsable = :direccion_responsable, telefono_responsable = :telefono_responsable WHERE id_contrato = :id_contrato");

            $sql->bindParam(":id_contrato", $id_contrato);
            $sql->bindParam(":numero_contrato", $numero_contrato);
            $sql->bindParam(":id_tipo_contrato", $id_tipo_contrato);
            $sql->bindParam(":id_empresa", $id_empresa);
            $sql->bindParam(":id_cliente", $id_cliente);
            $sql->bindParam(":objeto_contrato", $objeto_contrato);
            $sql->bindParam(":fecha_inicial_contrato", $fecha_inicial_contrato);
            $sql->bindParam(":fecha_final_contrato", $fecha_final_contrato);
            $sql->bindParam(":fecha_creacion_contrato", $fecha_creacion_contrato);
            $sql->bindParam(":hora_creacion_contrato", $hora_creacion_contrato);
            $sql->bindParam(":id_ciudad", $id_ciudad);
            $sql->bindParam(":id_responsable", $id_responsable);
            $sql->bindParam(":doc_fotocopia_contrato", $doc_fotocopia_contrato);
            $sql->bindParam(":nombre_responsable", $nombre_responsable);
            $sql->bindParam(":numero_documento_responsable", $numero_documento_responsable);
            $sql->bindParam(":direccion_responsable", $direccion_responsable);
            $sql->bindParam(":telefono_responsable", $telefono_responsable);

            $sql->execute();

            //echo "UPDATE contratos SET numero_contrato = '$numero_contrato', id_tipo_contrato = '$id_tipo_contrato', id_empresa = '$id_empresa', id_cliente = '$id_cliente', objeto_contrato = '$objeto_contrato', fecha_inicial_contrato = '$fecha_inicial_contrato', fecha_final_contrato = '$fecha_final_contrato', fecha_creacion_contrato = '$fecha_creacion_contrato, hora_creacion_contrato = '$hora_creacion_contrato', id_ciudad = '$id_ciudad', id_responsable = '$id_responsable', doc_fotocopia_contrato = '$doc_fotocopia_contrato', nombre_responsable = '$nombre_responsable', numero_documento_responsable = '$numero_documento_responsable', direccion_responsable = '$direccion_responsable', telefono_responsable = '$telefono_responsable' WHERE id_contrato = '$id_contrato'";

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

	public function listarPorCliente($id_cliente){
        $contratos = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM contratos WHERE id_cliente = :id_cliente");
        $sql->bindParam(":id_cliente", $id_cliente);
        $sql->execute();

        //echo "SELECT * FROM contratos WHERE id_cliente = '$id_cliente'";

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$contratos[] = $filas;
        }

        return $contratos;
	}

	public function listarPorEmpresa($id_empresa){
        $contratos = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM contratos WHERE id_empresa = :id_empresa");
        $sql->bindParam(":id_empresa", $id_empresa);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$contratos[] = $filas;
        }

        return $contratos;
	}

	public function listarPorEmpresaCliente($id_empresa,$id_cliente){
        $contratos = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM contratos WHERE id_empresa = :id_empresa and id_cliente = :id_cliente");
        $sql->bindParam(":id_empresa", $id_empresa);
        $sql->bindParam(":id_cliente", $id_cliente);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$contratos[] = $filas;
        }

        return $contratos;
	}
	
	public function listarPorClienteActivo($id_cliente,$fecha){
        $contratos = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM contratos WHERE id_cliente = :id_cliente and fecha_final_contrato >= :fecha");
        $sql->bindParam(":id_cliente", $id_cliente);
        $sql->bindParam(":fecha", $fecha);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$contratos[] = $filas;
        }

        return $contratos;
	}
	
	public function listarActivosPorClientes($clientes,$fecha){
        $contratos = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM contratos WHERE id_cliente IN ($clientes) and fecha_final_contrato >= :fecha");
        $sql->bindParam(":fecha", $fecha);
        $sql->execute();
		 
        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$contratos[] = $filas;
        }
		//echo "SELECT * FROM contratos WHERE id_cliente IN ('$clientes') and fecha_final_contrato >= '$fecha'";
		
        return $contratos;
	}

    public function listarTiposContratos(){
        $tipoContrato = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM tipo_contrato");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $tipoContrato[] = $filas;
        }

        return $tipoContrato;
    }

    public function listarTiposContratosId($id_tipo_contrato){
        $tipoContratoId = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM tipo_contrato WHERE id_tipo_contrato = :id_tipo_contrato");
        $sql->bindParam(":id_tipo_contrato", $id_tipo_contrato);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $tipoContratoId[] = $filas;
        }

        return $tipoContratoId;
    }


    public function listarContratosVencidos($fecha){
        $contratosVencidos = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM contratos WHERE fecha_final_contrato <= :fecha");
        $sql->bindParam(":fecha", $fecha);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $contratosVencidos[] = $filas;
        }

        return $contratosVencidos;
    }

    public function listarContratosHabiles($fecha){
        $contratosVencidos = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM contratos WHERE fecha_final_contrato >= :fecha ORDER BY id_contrato DESC");
        $sql->bindParam(":fecha", $fecha);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $contratosVencidos[] = $filas;
        }

        return $contratosVencidos;
    }

    public function listarContratosProximosVencer($fecha1, $fecha2){
        $contratosProximosVencer = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM contratos WHERE fecha_final_contrato > :fecha1 AND fecha_final_contrato < :fecha2 ");
        $sql->bindParam(":fecha1", $fecha1);
        $sql->bindParam(":fecha2", $fecha2);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $contratosProximosVencer[] = $filas;
        }

        return $contratosProximosVencer;
    }
    
    public function filtrarRangoFechas($fecha1, $fecha2){
        $contratosProximosVencer = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM contratos AS c INNER JOIN empresas AS e ON c.id_empresa = e.id_empresa INNER JOIN clientes AS cl ON c.id_cliente = cl.id_cliente WHERE c.fecha_inicial_contrato > :fecha1 AND c.fecha_final_contrato < :fecha2 ");
        $sql->bindParam(":fecha1", $fecha1);
        $sql->bindParam(":fecha2", $fecha2);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $contratosProximosVencer[] = $filas;
        }

        return $contratosProximosVencer;
    }

    public function renovarContrato($id_contrato, $doc_fotocopia_contrato, $fecha_inicial_contrato, $fecha_final_contrato){
        try {
            $con = Conexion::conectar();
            $sql = $con->prepare("UPDATE contratos SET doc_fotocopia_contrato = :doc_fotocopia_contrato, fecha_inicial_contrato = :fecha_inicial_contrato, fecha_final_contrato = :fecha_final_contrato WHERE id_contrato = :id_contrato");
            $sql->bindParam(":id_contrato", $id_contrato);
            $sql->bindParam(":doc_fotocopia_contrato", $doc_fotocopia_contrato);
            $sql->bindParam(":fecha_inicial_contrato", $fecha_inicial_contrato);
            $sql->bindParam(":fecha_final_contrato", $fecha_final_contrato);
            $sql->execute();

            /*if ($sql) {
                echo "UPDATE contratos SET doc_fotocopia_contrato = '$doc_fotocopia_contrato', fecha_inicial_contrato = '$fecha_inicial_contrato', fecha_final_contrato = '$fecha_final_contrato' WHERE id_contrato = '$id_contrato'";
            }*/

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function eliminarContratosPorVehiculo($id_vehiculo){
        try {
            $con = Conexion::conectar();
            $sql = $con->prepare("DELETE FROM vehiculos_contratos WHERE id_vehiculo = :id_vehiculo");
            $sql->bindParam(":id_vehiculo", $id_vehiculo);
            $sql->execute();

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

     public function listarContratosVencidosPorVehiculo($id_contrato, $fecha){
        $conVencidosIdV = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM contratos WHERE id_contrato = :id_contrato AND fecha_final_contrato <= :fecha");
        $sql->bindParam(":fecha", $fecha);
        $sql->bindParam(":id_contrato", $id_contrato);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $conVencidosIdV[] = $filas;
        }

        return $conVencidosIdV;
    }

    public function listarProyectosContratos($id_contrato){
        $proyectos = array();
        $con = Conexion::conectar();    
        $sql = $con->prepare("SELECT * FROM proyectos_contratos WHERE id_contrato = :id_contrato");
        $sql->bindParam(":id_contrato", $id_contrato);
        $sql->execute();

        //echo "SELECT * FROM proyectos_contratos WHERE id_contrato = '$id_contrato' ";

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $proyectos[] = $filas;
        }

        return $proyectos;
    }


    public function listarProyectosPorId($id_proyecto){
        $proyectosId = array();
        $con = Conexion::conectar();    
        $sql = $con->prepare("SELECT * FROM proyectos_contratos WHERE id_proyecto = :id_proyecto");
        $sql->bindParam(":id_proyecto", $id_proyecto);
        $sql->execute();

        //echo "SELECT * FROM proyectos_contratos WHERE id_contrato = '$id_contrato' ";

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $proyectosId[] = $filas;
        }

        return $proyectosId;
    }

    public function listarTarifasProyectosId($id_proyecto){
        $tarifas = array();
        $con = Conexion::conectar();    
        $sql = $con->prepare("SELECT * FROM tarifas_proyectos WHERE id_proyecto = :id_proyecto");
        $sql->bindParam(":id_proyecto", $id_proyecto);
        $sql->execute();

        //echo "SELECT * FROM proyectos_contratos WHERE id_contrato = '$id_contrato' ";

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $tarifas[] = $filas;
        }

        return $tarifas;
    }


    public function listarIdTarifas($id_tarifa_proyecto){
        $Idtarifas = array();
        $con = Conexion::conectar();    
        $sql = $con->prepare("SELECT * FROM tarifas_proyectos WHERE id_tarifa_proyecto = :id_tarifa_proyecto");
        $sql->bindParam(":id_tarifa_proyecto", $id_tarifa_proyecto);
        $sql->execute();

        //echo "SELECT * FROM tarifas_proyectos WHERE id_tarifa_proyecto = '$id_tarifa_proyecto' ";

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $Idtarifas[] = $filas;
        }

        return $Idtarifas;
    }


    public function registrarProyectosContratos($id_contrato, $nombre_proyecto){
        try {
            $con = Conexion::conectar();
            $sql = $con->prepare("INSERT INTO proyectos_contratos (id_contrato, nombre_proyecto) VALUES(:id_contrato, :nombre_proyecto)");
            $sql->bindParam(":id_contrato", $id_contrato);
            $sql->bindParam(":nombre_proyecto", $nombre_proyecto);
            $sql->execute();

            if ($sql) {
                $id_proyecto = $con->lastInsertId();
                return $id_proyecto;
            }


        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }


    public function registrarTarifasProyectos($id_proyecto, $detalle, $id_tipo_vehiculo, $tiempo_cobro, $costo_servicio){
        try {
            $con = Conexion::conectar();
            $sql = $con->prepare("INSERT INTO tarifas_proyectos (id_proyecto, detalle, id_tipo_vehiculo, tiempo_cobro, costo_servicio) VALUES (:id_proyecto, :detalle, :id_tipo_vehiculo, :tiempo_cobro, :costo_servicio);");
            $sql->bindParam(":id_proyecto", $id_proyecto);
            $sql->bindParam(":detalle", $detalle);
            $sql->bindParam(":id_tipo_vehiculo", $id_tipo_vehiculo);
            $sql->bindParam(":tiempo_cobro", $tiempo_cobro);
            $sql->bindParam(":costo_servicio", $costo_servicio);

            $sql->execute();

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }


    public function actualizarProyectosContratos($id_proyecto, $id_contrato, $nombre_proyecto){
        try {
            $con = Conexion::conectar();
            $sql = $con->prepare("UPDATE proyectos_contratos SET id_contrato = :id_contrato, nombre_proyecto = :nombre_proyecto WHERE id_proyecto = :id_proyecto");
            $sql->bindParam(":id_proyecto", $id_proyecto);
            $sql->bindParam(":id_contrato", $id_contrato);
            $sql->bindParam(":nombre_proyecto", $nombre_proyecto);
            $sql->execute();

            //echo "UPDATE proyectos_contratos SET id_contrato = '$id_contrato', nombre_proyecto = '$nombre_proyecto' WHERE id_proyecto = '$id_proyecto'";


        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function actualizaTarifas($id_tarifa_proyecto, $id_proyecto, $detalle, $id_tipo_vehiculo, $tiempo_cobro, $costo_servicio){
        try {
            $con = Conexion::conectar();
            $sql = $con->prepare("UPDATE tarifas_proyectos SET id_proyecto = :id_proyecto, detalle = :detalle, id_tipo_vehiculo = :id_tipo_vehiculo, tiempo_cobro = :tiempo_cobro, costo_servicio = :costo_servicio WHERE id_tarifa_proyecto = :id_tarifa_proyecto");
            $sql->bindParam(":id_tarifa_proyecto", $id_tarifa_proyecto);
            $sql->bindParam(":id_proyecto", $id_proyecto);
            $sql->bindParam(":detalle", $detalle);
            $sql->bindParam(":id_tipo_vehiculo", $id_tipo_vehiculo);
            $sql->bindParam(":tiempo_cobro", $tiempo_cobro);
            $sql->bindParam(":costo_servicio", $costo_servicio);
            $sql->execute();

            //echo "UPDATE tarifas_proyectos SET id_proyecto =  '$id_proyecto', detalle = '$detalle', id_tipo_vehiculo = '$id_tipo_vehiculo', tiempo_cobro = '$tiempo_cobro', costo_servicio = '$costo_servicio' WHERE id_tarifa_proyecto = '$id_tarifa_proyecto'";


        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }


    public function eliminarTarifa($id_tarifa_proyecto){
        try {
            $con = Conexion::conectar();
            $sql = $con->prepare("DELETE FROM tarifas_proyectos WHERE id_tarifa_proyecto = :id_tarifa_proyecto");
            $sql->bindParam(":id_tarifa_proyecto", $id_tarifa_proyecto);
            $sql->execute();

            echo "DELETE FROM tarifas_proyectos WHERE id_tarifa_proyecto = '$id_tarifa_proyecto'";

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

   
    
    public function registrarTarifasTerceros($id_proyecto, $id_tarifa, $valor){
        try{
            $con = Conexion::conectar();
            $sql = $con->prepare("INSERT INTO tarifas_terceros_proyectos (id_proyecto, id_tarifa, valor) VALUES(:id_proyecto, :id_tarifa, :valor)");
            $sql->bindParam(":id_proyecto", $id_proyecto);
            $sql->bindParam(":id_tarifa", $id_tarifa);
            $sql->bindParam(":valor", $valor);
            $sql->execute();
            
            echo "INSERT INTO tarifas_terceros_proyectos (id_proyecto, id_tarifa, valor) VALUES('$id_proyecto', '$id_tarifa', '$valor')";
            
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function listarTarifasTerceros($id_tarifa){
        $terceros = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM tarifas_terceros_proyectos WHERE id_tarifa = :id_tarifa");
        $sql->bindParam(":id_tarifa", $id_tarifa);
        $sql->execute();
        
        //echo "SELECT * FROM tarifas_terceros_proyectos WHERE id_tarifa = '$id_tarifa' ";

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$terceros[] = $filas;
        }

        return $terceros;
	}
    
}
 ?>