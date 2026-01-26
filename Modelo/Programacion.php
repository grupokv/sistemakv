<?php 



require_once("Conexion/conexionBD.php");



class Programacion

{

	
	public function listar_solicitudes(){
		$clientes = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM solicitud_cliente where estado != 'C'");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$clientes[] = $filas;
		}

		return $clientes;
	}
	
	public function listar_solicitudes_fecha($fecha){

		$clientes = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM solicitud_cliente where estado != 'C' and date(fecha_solicitud) >= :fecha");
		$sql->bindParam(":fecha", $fecha);
		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$clientes[] = $filas;

		}



		return $clientes;

	}


	public function listarNovedades(){

		$clientes = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM tipo_novedad order by posicion Asc");

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$clientes[] = $filas;

		}



		return $clientes;		



	}


	public function listar_solicitudes_todas(){

		$clientes = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM solicitud_cliente");

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$clientes[] = $filas;

		}



		return $clientes;		



	}



	public function listar_solicitudes_usuario($id_usuario){
		$clientes = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM solicitud_cliente WHERE id_usuario = :id_usuario and estado != 'C'");
		$sql->bindParam(":id_usuario", $id_usuario);
		$sql->execute();
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$clientes[] = $filas;
		}
		return $clientes;
	}
	
	public function listar_solicitudes_usuario_fecha($id_usuario,$fecha){
		$clientes = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM solicitud_cliente WHERE id_usuario = :id_usuario and estado != 'C' and MONTH(fecha_solicitud) >= :fecha");
		$sql->bindParam(":id_usuario", $id_usuario);
		$sql->bindParam(":fecha", $fecha);
		$sql->execute();

		//echo "SELECT * FROM solicitud_cliente WHERE id_usuario = :id_usuario and estado != 'C' and MONTH(fecha_solicitud) >= '$fecha' ";

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$clientes[] = $filas;
		}
		return $clientes;
	}

	public function serviciosPorClienteFecha($id_cliente,$fecha){

		$clientes = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM detalle_solicitud WHERE id_cliente = :id_cliente and fecha_servicio >= :fecha");

		$sql->bindParam(":id_cliente", $id_cliente);
		$sql->bindParam(":fecha", $fecha);
		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$clientes[] = $filas;

		}



		return $clientes;

	}
	
	public function buscarServicioFiltro($columna,$dato){

		$clientes = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM detalle_solicitud WHERE $columna like '%$dato%'");

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$clientes[] = $filas;

		}



		return $clientes;

	}

	public function consultaReporte1($cliente,$tipo_servicio,$fechai,$fechaf){

		$clientes = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM detalle_solicitud WHERE id_cliente like :cliente and id_tiposervicio like :tipo_servicio and (fecha_servicio >= :fechai and fecha_servicio <= :fechaf) order by fecha_servicio Asc, hora_servicio Asc");

		$sql->bindParam(":cliente", $cliente);

		$sql->bindParam(":tipo_servicio", $tipo_servicio);

		$sql->bindParam(":fechai", $fechai);

		$sql->bindParam(":fechaf", $fechaf);

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$clientes[] = $filas;

		}

		//echo "SELECT * FROM detalle_solicitud WHERE id_cliente like '$cliente' and id_tiposervicio like '$tipo_servicio' and (fecha_servicio >= '$fechai' and fecha_servicio <= '$fechaf')";

		return $clientes;

	}



	public function consultaReporte2($cliente,$tipo_servicio,$listado_servicios,$fechai,$fechaf){

		$clientes = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM detalle_solicitud WHERE id_cliente like :cliente and id_tiposervicio like :tipo_servicio and id_detalle in (:listado_servicios) and (fecha_servicio >= :fechai and fecha_servicio <= :fechaf) order by fecha_servicio Asc, hora_servicio Asc");

		$sql->bindParam(":cliente", $cliente);

		$sql->bindParam(":tipo_servicio", $tipo_servicio);

		$sql->bindParam(":listado_servicios", $listado_servicios);

		$sql->bindParam(":fechai", $fechai);

		$sql->bindParam(":fechaf", $fechaf);

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$clientes[] = $filas;

		}

		//echo "SELECT * FROM detalle_solicitud WHERE id_cliente like '$cliente' and id_tiposervicio like '$tipo_servicio' and id_detalle in ('$listado_servicios') and (fecha_servicio >= '$fechai' and fecha_servicio <= '$fechaf')";

		return $clientes;

	}



	public function serviciosPorIdSolicitud($id_solicitud){

		$clientes = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM detalle_solicitud WHERE id_solicitud = :id_solicitud and estado != 'C' order by fecha_servicio Asc, hora_servicio Asc");

		$sql->bindParam(":id_solicitud", $id_solicitud);

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$clientes[] = $filas;

		}



		return $clientes;

	}



	public function serviciosActivo(){

		$clientes = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM detalle_solicitud WHERE estado != 'C' order by fecha_servicio Asc, hora_servicio Asc");

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$clientes[] = $filas;

		}



		return $clientes;

	}



	public function serviciosActivoFecha($fecha){

		$clientes = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM detalle_solicitud WHERE fecha_servicio >= :fecha order by fecha_servicio Asc, hora_servicio Asc");

		$sql->bindParam(":fecha", $fecha);

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$clientes[] = $filas;

		}



		return $clientes;

	}



	public function serviciosActivoPorUsuario($id,$fecha){

		$clientes = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM detalle_solicitud WHERE estado != 'C' and fecha_servicio >= :fecha and id_usuario = :usuario order by fecha_servicio Asc, hora_servicio Asc");

		$sql->bindParam(":usuario", $id);

		$sql->bindParam(":fecha", $fecha);

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$clientes[] = $filas;

		}



		return $clientes;

	}



	public function serviciosPorIdDetalle($id_detalle){

		$clientes = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM detalle_solicitud WHERE id_detalle = :id_detalle");

		$sql->bindParam(":id_detalle", $id_detalle);

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$clientes[] = $filas;

		}



		return $clientes;

	}





	public function serviciosPorTipoIdSolicitud($id_solicitud,$tipo){

		$TipoIdSolicitud = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM detalle_solicitud WHERE id_solicitud = :id_solicitud and tipo = :tipo and estado != 'C'");

		$sql->bindParam(":id_solicitud", $id_solicitud);

		$sql->bindParam(":tipo", $tipo);

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$TipoIdSolicitud[] = $filas;

		}



		return $TipoIdSolicitud;

	}



	public function serviciosPorTipoIdSolicitudTodos($id_solicitud,$tipo){

		$clientes = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM detalle_solicitud WHERE id_solicitud = :id_solicitud and tipo = :tipo");

		$sql->bindParam(":id_solicitud", $id_solicitud);

		$sql->bindParam(":tipo", $tipo);

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$clientes[] = $filas;

		}



		return $clientes;

	}



	public function solicitudPorId($id_solicitud){

		$clientes = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM solicitud_cliente WHERE id_solicitud = :id_solicitud");

		$sql->bindParam(":id_solicitud", $id_solicitud);

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$clientes[] = $filas;

		}



		return $clientes;

	}
	
	public function contactosPorCliente($id_cliente){

		$clientes = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT distinct(contacto) FROM detalle_solicitud WHERE id_cliente = :id_cliente");

		$sql->bindParam(":id_cliente", $id_cliente);

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$clientes[] = $filas;

		}



		return $clientes;

	}
	
	public function telefonoContacto($nombre){

		$clientes = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT telefono_contacto FROM detalle_solicitud WHERE contacto like :nombre order by id_detalle Desc limit 1");

		$sql->bindParam(":nombre", $nombre);

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$clientes[] = $filas;

		}

        //echo "SELECT telefono_contacto FROM detalle_solicitud WHERE contacto like '$nombre' order by id_detalle Desc limit 1";

		return $clientes;

	}



	public function asignadoActivoPorServicio($id_servicio){

		$clientes = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM asignaciones WHERE id_servicio = :id_servicio and (estado = 'A' or estado = 'I')");

		$sql->bindParam(":id_servicio", $id_servicio);

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$clientes[] = $filas;

		}



		return $clientes;

	}



	public function asignadoFinalizadoPorServicio($id_servicio){

		$clientes = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM asignaciones WHERE id_servicio = :id_servicio and estado = 'F'");

		$sql->bindParam(":id_servicio", $id_servicio);

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$clientes[] = $filas;

		}



		return $clientes;

	}



	public function buscarServiciosPorVehiculo($id_vehiculo){

		$clientes = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM asignaciones WHERE id_vehiculo = :id_vehiculo and estado = 'A'");

		$sql->bindParam(":id_vehiculo", $id_vehiculo);

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$clientes[] = $filas;

		}



		return $clientes;

	}



	public function buscarServiciosPorVehiculoTodos($id_vehiculo){

		$clientes = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM asignaciones WHERE id_vehiculo = :id_vehiculo");

		$sql->bindParam(":id_vehiculo", $id_vehiculo);

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$clientes[] = $filas;

		}



		return $clientes;

	}



	public function buscarVehiculosPorServicio($id_servicio,$tipo_asignacion){

		$clientes = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM asignaciones WHERE id_servicio = :id_servicio and tipo_asignacion = :tipo_asignacion");

		$sql->bindParam(":id_servicio", $id_servicio);

		$sql->bindParam(":tipo_asignacion", $tipo_asignacion);

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$clientes[] = $filas;

		}



		return $clientes;

	}



	public function buscarServiciosFecha($servicios,$fecha){

		$clientes = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM detalle_solicitud WHERE id_detalle in(:servicios) and fecha_servicio = :fecha");

		$sql->bindParam(":servicios", $servicios);

		$sql->bindParam(":fecha", $fecha);

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$clientes[] = $filas;

		}



		return $clientes;

	}



	public function registrar($idas, $retornos, $fecha, $cliente, $usuario, $estado){



			try {

				$con = Conexion::conectar();

			    $sql = $con->prepare("INSERT INTO solicitud_cliente (servicios_ida, servicios_retorno, fecha_solicitud, id_cliente, id_usuario, estado) VALUES(:idas, :retornos, :fecha, :cliente, :usuario, :estado);");

	            

	            $sql->bindParam(":idas", $idas);

	            $sql->bindParam(":retornos", $retornos);

	            $sql->bindParam(":fecha", $fecha);

	            $sql->bindParam(":cliente", $cliente);

	            $sql->bindParam(":usuario", $usuario);

	            $sql->bindParam(":estado", $estado);



	            $sql->execute();



	            return $id_solicitud = $con->lastInsertId();

			} catch (Exception $e) {

				echo $e->getMessage();

			}



		    

	}



	public function guardarDetalle($id_solicitud,$id_servicio,$detalle,$usuario,$fecha){



			try {

				$con = Conexion::conectar();

			    $sql = $con->prepare("INSERT INTO finalizacion_servicio (id_solicitud, id_servicio, detalle, id_usuario, fecha) VALUES(:id_solicitud, :id_servicio, :detalle, :usuario, :fecha);");

	            

	            $sql->bindParam(":id_solicitud", $id_solicitud);

	            $sql->bindParam(":id_servicio", $id_servicio);

	            $sql->bindParam(":detalle", $detalle);

	            $sql->bindParam(":usuario", $usuario);

	            $sql->bindParam(":fecha", $fecha);



	            $sql->execute();



	            return $id_solicitud = $con->lastInsertId();

			} catch (Exception $e) {

				echo $e->getMessage();

			}



		    

	}





	public function actualizar($idas, $retornos, $id_solicitud){





            try {

            	

		        $con = Conexion::conectar();

		        $sql = $con->prepare("UPDATE solicitud_cliente SET servicios_ida = :idas, servicios_retorno = :retornos WHERE id_solicitud = :id_solicitud");



		    $sql->bindParam(":idas", $idas);

	        $sql->bindParam(":retornos", $retornos);

            $sql->bindParam(":id_solicitud", $id_solicitud);



            $sql->execute();

                

            } catch (Exception $e) {

            	echo $e->getMessage();

            }

	}



	public function actualizarCantidadIdas($id_solicitud,$cantidad){

            try {

            	

		        $con = Conexion::conectar();

		        $sql = $con->prepare("UPDATE solicitud_cliente SET servicios_ida = :cantidad WHERE id_solicitud = :id_solicitud");



			    $sql->bindParam(":cantidad", $cantidad);

	            $sql->bindParam(":id_solicitud", $id_solicitud);



	            $sql->execute();

                

                //echo "UPDATE solicitud_cliente SET servicios_ida = '$cantidad' WHERE id_solicitud = '$id_solicitud'";

            } catch (Exception $e) {

            	echo $e->getMessage();

            }

	}



	public function actualizarCantidadRetornos($id_solicitud,$cantidad){

            try {

            	

		        $con = Conexion::conectar();

		        $sql = $con->prepare("UPDATE solicitud_cliente SET servicios_retorno = :cantidad WHERE id_solicitud = :id_solicitud");



			    $sql->bindParam(":cantidad", $cantidad);

	            $sql->bindParam(":id_solicitud", $id_solicitud);



	            $sql->execute();

                

            } catch (Exception $e) {

            	echo $e->getMessage();

            }

	}



	public function cambiarEstado($id_solicitud){





            try {

            	

		        $con = Conexion::conectar();

		        $sql = $con->prepare("UPDATE solicitud_cliente SET estado = 'C' WHERE id_solicitud = :id_solicitud");



            $sql->bindParam(":id_solicitud", $id_solicitud);



            $sql->execute();

                

            } catch (Exception $e) {

            	echo $e->getMessage();

            }

	}



	public function cambiarEstadoServicio($id_servicio){





            try {

            	

		        $con = Conexion::conectar();

		        $sql = $con->prepare("UPDATE detalle_solicitud SET estado = 'C' WHERE id_detalle = :id_servicio");



            $sql->bindParam(":id_servicio", $id_servicio);



            $sql->execute();

                

            } catch (Exception $e) {

            	echo $e->getMessage();

            }

	}



	public function cambiarValorServicio($id_servicio,$valor){





            try {

            	

		        $con = Conexion::conectar();

		        $sql = $con->prepare("UPDATE detalle_solicitud SET valor = :valor WHERE id_detalle = :id_servicio");

 	    $sql->bindParam(":valor", $valor);

            $sql->bindParam(":id_servicio", $id_servicio);



            $sql->execute();

                

            } catch (Exception $e) {

            	echo $e->getMessage();

            }

	}



	public function cambiarEstadoServicioAsignado($id_servicio){





            try {

            	

		        $con = Conexion::conectar();

		        $sql = $con->prepare("UPDATE detalle_solicitud SET estado = 'A' WHERE id_detalle = :id_servicio");



            $sql->bindParam(":id_servicio", $id_servicio);



            $sql->execute();

                

            } catch (Exception $e) {

            	echo $e->getMessage();

            }

	}



	public function finalizarServicio($id_servicio){





            try {

            	

		        $con = Conexion::conectar();

		        $sql = $con->prepare("UPDATE detalle_solicitud SET estado = 'F' WHERE id_detalle = :id_servicio");



            $sql->bindParam(":id_servicio", $id_servicio);



            $sql->execute();

                

            } catch (Exception $e) {

            	echo $e->getMessage();

            }

	}

	public function finalizarAsignacion($id_asignacion,$fecha,$kms){
        try {
	        $con = Conexion::conectar();
	        $sql = $con->prepare("UPDATE asignaciones SET estado = 'F', fecha_final = :fecha, kms_final = :kms WHERE id_asignacion = :id_asignacion");
		    $sql->bindParam(":fecha", $fecha);
		    $sql->bindParam(":kms", $kms);
            $sql->bindParam(":id_asignacion", $id_asignacion);

            $sql->execute();

        } catch (Exception $e) {
        	echo $e->getMessage();
        }
	}

	public function registrarAdicionalesServicio($id_asignacion, $fecha_inicio, $kms_inicio, $fecha_final, $kms_final, $combustible, $galones_combustible, $valor_total_combustible, $peajes, $cant_peajes, $valor_total_peajes, $soportes_peajes, $parqueadero, $valor_total_parqueadero, $pernoctada, $valor_total_pernoctada, $funcionario_transportado){
        try {
	        $con = Conexion::conectar();
	        $sql = $con->prepare("UPDATE asignaciones SET fecha_inicio = :fecha_inicio, kms_inicio = :kms_inicio, fecha_final = :fecha_final, kms_final = :kms_final, combustible = :combustible, galones_combustible = :galones_combustible, valor_total_combustible = :valor_total_combustible, peajes = :peajes, cant_peajes = :cant_peajes, valor_total_peajes = :valor_total_peajes, soportes_peajes = :soportes_peajes, parqueadero = :parqueadero, valor_total_parqueadero = :valor_total_parqueadero, pernoctada = :pernoctada, valor_total_pernoctada = :valor_total_pernoctada, funcionario_transportado = :funcionario_transportado, estado_adicionales = 'R'  WHERE id_asignacion = :id_asignacion");

		    $sql->bindParam(":id_asignacion", $id_asignacion);
		    $sql->bindParam(":fecha_inicio", $fecha_inicio);
		    $sql->bindParam(":kms_inicio", $kms_inicio);
		    $sql->bindParam(":fecha_final", $fecha_final);
		    $sql->bindParam(":kms_final", $kms_final);
		    $sql->bindParam(":combustible", $combustible);
		    $sql->bindParam(":galones_combustible", $galones_combustible);
		    $sql->bindParam(":valor_total_combustible", $valor_total_combustible);
            $sql->bindParam(":peajes", $peajes);
		    $sql->bindParam(":cant_peajes", $cant_peajes);
		    $sql->bindParam(":valor_total_peajes", $valor_total_peajes);
            $sql->bindParam(":soportes_peajes", $soportes_peajes);
		    $sql->bindParam(":parqueadero", $parqueadero);
		    $sql->bindParam(":valor_total_parqueadero", $valor_total_parqueadero);
		    $sql->bindParam(":pernoctada", $pernoctada);
		    $sql->bindParam(":valor_total_pernoctada", $valor_total_pernoctada);
            $sql->bindParam(":funcionario_transportado", $funcionario_transportado);

            $sql->execute();

            if ($sql) {
            	return 1;
            }else{
            	return 0;
            }

            //echo "UPDATE asignaciones SET fecha_inicio = '$fecha_inicio', kms_inicio = '$kms_inicio', fecha_final = '$fecha_final', kms_final = '$kms_final', combustible = '$combustible', galones_combustible = '$galones_combustible', peajes = '$peajes', cant_peajes = '$cant_peajes', valor_total_peajes = '$valor_total_peajes', soportes_peajes = '$soportes_peajes', parqueadero = '$parqueadero', valor_total_parqueadero = '$valor_total_parqueadero', funcionario_transportado = '$funcionario_transportado' WHERE id_asignacion = '$id_asignacion'";

        } catch (Exception $e) {
        	echo $e->getMessage();
        }
	}


	public function iniciarServicio($id_servicio){

        try {

	        $con = Conexion::conectar();
	        $sql = $con->prepare("UPDATE detalle_solicitud SET estado = 'I' WHERE id_detalle = :id_servicio");
            $sql->bindParam(":id_servicio", $id_servicio);
            $sql->execute();                

        } catch (Exception $e) {
        	echo $e->getMessage();
        }

	}

	public function iniciarAsignacion($id_asignacion, $fecha, $kms){

            try {
          	
	    $con = Conexion::conectar();
            $sql = $con->prepare("UPDATE asignaciones SET estado = 'I', fecha_inicio = :fecha, kms_inicio = :kms WHERE id_asignacion = :id_asignacion");

	    $sql->bindParam(":fecha", $fecha);
	    $sql->bindParam(":kms", $kms);
            $sql->bindParam(":id_asignacion", $id_asignacion);

            $sql->execute();
             
            } catch (Exception $e) {

            	echo $e->getMessage();

            }

	}



	public function cambiarEstadoAsignacionRelevo($id_asignacion){



            try {

            	

		        $con = Conexion::conectar();

		        $sql = $con->prepare("UPDATE asignaciones SET estado = 'R' WHERE id_asignacion = :id_asignacion");



            $sql->bindParam(":id_asignacion", $id_asignacion);



            $sql->execute();

                

            } catch (Exception $e) {

            	echo $e->getMessage();

            }

	}



	public function registrarSeguimientoPre($id_servicio,$id_asignacion,$detalle,$hoy,$id_usuario){



            try {

            	

		        $con = Conexion::conectar();

		        $sql = $con->prepare("UPDATE asignaciones SET seguimiento_pre = :detalle, id_usuario_seg_pre = :id_usuario, fecha_seg_pre = :hoy WHERE id_asignacion = :id_asignacion and id_servicio = :id_servicio");



            $sql->bindParam(":id_servicio", $id_servicio);

            $sql->bindParam(":id_asignacion", $id_asignacion);

            $sql->bindParam(":detalle", $detalle);

            $sql->bindParam(":hoy", $hoy);

            $sql->bindParam(":id_usuario", $id_usuario);



            $sql->execute();

                

            } catch (Exception $e) {

            	echo $e->getMessage();

            }

	}



	public function registrarSeguimientoPost($id_servicio,$id_asignacion,$detalle,$hoy,$id_usuario){



            try {

            	

		        $con = Conexion::conectar();

		        $sql = $con->prepare("UPDATE asignaciones SET seguimiento_pos = :detalle, id_usuario_seg_pos = :id_usuario, fecha_seg_pos = :hoy WHERE id_asignacion = :id_asignacion and id_servicio = :id_servicio");



            $sql->bindParam(":id_servicio", $id_servicio);

            $sql->bindParam(":id_asignacion", $id_asignacion);

            $sql->bindParam(":detalle", $detalle);

            $sql->bindParam(":hoy", $hoy);

            $sql->bindParam(":id_usuario", $id_usuario);



            $sql->execute();

                

            } catch (Exception $e) {

            	echo $e->getMessage();

            }

	}



	public function registrarServicio($id_solicitud, $creador, $id_cliente, $tipo_servicio, $fecha, $fecha_servicio, $hora_servicio, $nombre_contacto, $telefono_contacto, $cant_pax, $listado_pax, $id_tipovehiculo, $id_tiposervicio, $ciudad, $origen, $destino, $centro_costo, $solicitante, $estado){



			try {

				$con = Conexion::conectar();

			    $sql = $con->prepare("INSERT INTO detalle_solicitud (id_solicitud, id_usuario, id_cliente, tipo, fecha_solicitud, fecha_servicio, hora_servicio, contacto, telefono_contacto, cantidad, listado, id_tipovehiculo, id_tiposervicio, ciudad, origen, destino, centro_costo, solicitante, estado) VALUES(:id_solicitud, :id_usuario, :id_cliente, :tipo_servicio, :fecha, :fecha_servicio, :hora_servicio, :nombre_contacto, :telefono_contacto, :cant_pax, :listado_pax, :id_tipovehiculo, :id_tiposervicio, :ciudad, :origen, :destino, :centro_costo, :solicitante, :estado);");

	            

	            $sql->bindParam(":id_solicitud", $id_solicitud);

	            $sql->bindParam(":id_usuario", $creador);

	            $sql->bindParam(":id_cliente", $id_cliente);

	            $sql->bindParam(":tipo_servicio", $tipo_servicio);

	            $sql->bindParam(":fecha", $fecha);

	            $sql->bindParam(":fecha_servicio", $fecha_servicio);

	            $sql->bindParam(":hora_servicio", $hora_servicio);

	            $sql->bindParam(":nombre_contacto", $nombre_contacto);

	            $sql->bindParam(":telefono_contacto", $telefono_contacto);

	            $sql->bindParam(":cant_pax", $cant_pax);

	            $sql->bindParam(":listado_pax", $listado_pax);

	            $sql->bindParam(":id_tipovehiculo", $id_tipovehiculo);

	            $sql->bindParam(":id_tiposervicio", $id_tiposervicio);

	            $sql->bindParam(":ciudad", $ciudad);

	            $sql->bindParam(":origen", $origen);

	            $sql->bindParam(":destino", $destino);

	            $sql->bindParam(":centro_costo", $centro_costo);

	            $sql->bindParam(":solicitante", $solicitante);

	            $sql->bindParam(":estado", $estado);



	            $sql->execute();



	            /*$sql1 =  "INSERT INTO detalle_solicitud (id_solicitud, id_usuario, id_cliente, tipo, fecha_solicitud, fecha_servicio, hora_servicio, contacto, telefono_contacto, cantidad, listado, id_tipovehiculo, id_tiposervicio, ciudad, origen, destino, centro_costo, solicitante, estado) VALUES('$id_solicitud', '$creador', '$id_cliente', '$tipo_servicio', '$fecha', '$fecha_servicio', '$hora_servicio', '$nombre_contacto', '$telefono_contacto', '$cant_pax', '$listado_pax', '$id_tipovehiculo', '$id_tiposervicio', '$ciudad', '$origen', '$destino', '$centro_costo', '$solicitante', '$estado');";*/



	            //return $sql1;

	            return $id_solicitud = $con->lastInsertId();

			} catch (Exception $e) {

				echo $e->getMessage();

			}



		    

	}



	public function listarAsignacionPorId($id_servicio){

		$listarAsignaciones = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM asignaciones WHERE id_servicio = :id_servicio");

		$sql->bindParam(":id_servicio", $id_servicio);

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$listarAsignaciones[] = $filas;

		}



		return $listarAsignaciones;

	}



	public function listarAsignacionIdAsignacion($id_asignacion){

		$listarAsignacionesID = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM asignaciones WHERE id_asignacion = :id_asignacion");
		$sql->bindParam(":id_asignacion", $id_asignacion);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarAsignacionesID[] = $filas;
		}

		return $listarAsignacionesID;

	}



	public function registrarAsignacion($id_servicio, $id_contrato, $id_proyecto, $id_tarifa_proyecto, $id_vehiculo, $id_conductor, $estado, $hoy, $tipo, $costo){
			try {
				$con = Conexion::conectar();
			    $sql = $con->prepare("INSERT INTO asignaciones (id_servicio, id_contrato, id_proyecto, id_tarifa_proyecto, id_vehiculo, id_conductor, estado, fecha_asignacion, tipo_asignacion, costo, fecha_seg_pre, fecha_seg_pos, fecha_inicio, fecha_final) VALUES(:id_servicio, :id_contrato, :id_proyecto, :id_tarifa_proyecto, :id_vehiculo, :id_conductor, :estado, :hoy, :tipo, :costo, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00');");
	            
	            $sql->bindParam(":id_servicio", $id_servicio);
	            $sql->bindParam(":id_contrato", $id_contrato);
	            $sql->bindParam(":id_proyecto", $id_proyecto);
	            $sql->bindParam(":id_tarifa_proyecto", $id_tarifa_proyecto);
	            $sql->bindParam(":id_vehiculo", $id_vehiculo);
	            $sql->bindParam(":id_conductor", $id_conductor);
	            $sql->bindParam(":estado", $estado);
	            $sql->bindParam(":hoy", $hoy);
	            $sql->bindParam(":tipo", $tipo);
	            $sql->bindParam(":costo", $costo);

	            $sql->execute();
	            
	            //echo "INSERT INTO asignaciones (id_servicio, id_contrato, id_proyecto, id_tarifa_proyecto, id_vehiculo, id_conductor, estado, fecha_asignacion, tipo_asignacion, costo, fecha_seg_pre, fecha_seg_pos, fecha_inicio, fecha_final) VALUES('$id_servicio', '$id_contrato', '$id_proyecto', '$id_tarifa_proyecto', '$id_vehiculo', '$id_conductor', '$estado', '$hoy', '$tipo', '$costo', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00');";

	            return $id_solicitud = $con->lastInsertId();
			} catch (Exception $e) {
				echo $e->getMessage();
			}
	}



	public function actualizarServicio($id_servicio, $fecha_servicio, $hora_servicio, $nombre_contacto, $telefono_contacto, $cant_pax, $listado_pax, $id_tipovehiculo, $id_tiposervicio, $ciudad, $origen, $destino, $centro_costo, $solicitante){



			try {

				$con = Conexion::conectar();

			    $sql = $con->prepare("UPDATE detalle_solicitud set fecha_servicio = :fecha_servicio, hora_servicio = :hora_servicio, contacto = :nombre_contacto, telefono_contacto = :telefono_contacto, cantidad = :cant_pax, listado = :listado_pax, id_tipovehiculo = :id_tipovehiculo, id_tiposervicio = :id_tiposervicio, ciudad = :ciudad, origen = :origen, destino = :destino, centro_costo = :centro_costo, solicitante = :solicitante WHERE id_detalle = :id_servicio");

	            

	            $sql->bindParam(":id_servicio", $id_servicio);

	            $sql->bindParam(":fecha_servicio", $fecha_servicio);

	            $sql->bindParam(":hora_servicio", $hora_servicio);

	            $sql->bindParam(":nombre_contacto", $nombre_contacto);

	            $sql->bindParam(":telefono_contacto", $telefono_contacto);

	            $sql->bindParam(":cant_pax", $cant_pax);

	            $sql->bindParam(":listado_pax", $listado_pax);

	            $sql->bindParam(":id_tipovehiculo", $id_tipovehiculo);

	            $sql->bindParam(":id_tiposervicio", $id_tiposervicio);

	            $sql->bindParam(":ciudad", $ciudad);

	            $sql->bindParam(":origen", $origen);

	            $sql->bindParam(":destino", $destino);

	            $sql->bindParam(":centro_costo", $centro_costo);

	            $sql->bindParam(":solicitante", $solicitante);



	            $sql->execute();



			} catch (Exception $e) {

				echo $e->getMessage();

			}



		    

	}



	public function serviciosPorConductor($id_conductor){

		$serviciosFConductor = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM vehiculo_servicio WHERE id_conductor = :id_conductor AND estado = 'F'");

		$sql->bindParam(":id_conductor", $id_conductor);

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$serviciosFConductor[] = $filas;

		}

		

		return $serviciosFConductor;	

	}



	public function serviciosPorVehiculo($id_vehiculo){

		$serviciosFConductor = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM vehiculo_servicio WHERE id_vehiculo = :id_vehiculo");

		$sql->bindParam(":id_vehiculo", $id_vehiculo);

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$serviciosFConductor[] = $filas;

		}

		

		return $serviciosFConductor;	

	}



	public function serviciosAsignadosPorConductor($id_conductor, $fecha_inicial, $fecha_final){

		$serviciosAConductor = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM asignaciones AS a INNER JOIN detalle_solicitud AS ds ON a.id_servicio = ds.id_detalle WHERE a.id_conductor = :id_conductor AND (ds.fecha_servicio >= :fecha_inicial AND ds.fecha_servicio <= :fecha_final) ORDER BY ds.fecha_servicio ASC, ds.hora_servicio ASC");

		$sql->bindParam(":id_conductor", $id_conductor);
		$sql->bindParam(":fecha_inicial", $fecha_inicial);
		$sql->bindParam(":fecha_final", $fecha_final);
		$sql->execute();


		//echo "SELECT * FROM asignaciones AS a INNER JOIN detalle_solicitud AS ds ON a.id_servicio = ds.id_detalle WHERE a.id_conductor = '$id_conductor' AND (ds.fecha_servicio >= '$fecha_inicial' AND ds.fecha_servicio <= '$fecha_final') ORDER BY ds.fecha_servicio ASC, ds.hora_servicio ASC";


		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$serviciosAConductor[] = $filas;

		}

        //echo "SELECT * FROM asignaciones WHERE id_conductor = '$id_conductor' AND estado = 'A' order by id_servicio Asc";		

		return $serviciosAConductor;	

	}


	public function serviciosFinalizadosPorConductor($id_conductor){

		$serviciosAConductor = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM asignaciones INNER JOIN detalle_solicitud ON asignaciones.id_servicio = detalle_solicitud.id_detalle WHERE asignaciones.id_conductor = :id_conductor AND asignaciones.estado = 'F' order by detalle_solicitud.fecha_servicio Asc, detalle_solicitud.hora_servicio Asc");

		$sql->bindParam(":id_conductor", $id_conductor);

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$serviciosAConductor[] = $filas;

		}

        //echo "SELECT * FROM asignaciones WHERE id_conductor = '$id_conductor' AND estado = 'A' order by id_servicio Asc";		

		return $serviciosAConductor;	

	}


	public function listarDetallesServiciosPorId($id_detalle){

		$detalleServiciosId = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM detalle_solicitud WHERE id_detalle = :id_detalle");

		$sql->bindParam(":id_detalle", $id_detalle);

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$detalleServiciosId[] = $filas;

		}



		return $detalleServiciosId;

	}



	public function listarTiposServiciosClientesPorId($id_tipo_servicio){

		$tiposervicios = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM tipo_servicio_cliente WHERE id_tipo_servicio = :id_tipo_servicio");

		$sql->bindParam(":id_tipo_servicio", $id_tipo_servicio);

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$tiposervicios[] = $filas;

		}



		return $tiposervicios;

	}

	/* --------------------------------------------------- */
	/* --------------------------------------------------- */
	/* --------------------------------------------------- */

/*	public function listar_programacion_servicios(){

		$programacionServ = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM programacion_servicios ORDER BY fecha, horario ASC");
		$sql->bindParam(":id_tipo_servicio", $id_tipo_servicio);

		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$programacionServ[] = $filas;
		}

		return json_encode($programacionServ);
	}*/

	public function listar_programaciones(){

		$programacionServ = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM programacion_servicios WHERE programacion = 'S' ORDER BY fecha, horario ASC ");
		$sql->bindParam(":id_tipo_servicio", $id_tipo_servicio);

		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$programacionServ[] = $filas;
		}

		return $programacionServ;
	}

	public function listarUnidadOperativaId($id_unidad){

		$unidadID = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM unidades_operativas_programacion WHERE id_unidad = :id_unidad ");
		$sql->bindParam(":id_unidad", $id_unidad);

		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$unidadID[] = $filas;
		}

		return $unidadID;
	}


	public function listarUnidadOperativaLIKE($unidad_operativa){

		$unidadLIKE = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM unidades_operativas_programacion WHERE unidad_operativa LIKE :unidad_operativa ");
		$sql->bindParam(":unidad_operativa", $unidad_operativa);

		$sql->execute();

		//echo "SELECT * FROM unidades_operativas_programacion WHERE unidad_operativa LIKE '$unidad_operativa' ";

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$unidadLIKE[] = $filas;
		}

		return $unidadLIKE;
	}


	public function validarCodigoIdentificativoProgramacion($proyecto, $unidad_operativa){

		$codigoProgramacion = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT codigo_identificativo FROM programacion_servicios WHERE unidad_operativa = :unidad_operativa AND proyecto = :proyecto AND programacion = 'S' ORDER BY codigo_identificativo ASC ");
		$sql->bindParam(":proyecto", $proyecto);
		$sql->bindParam(":unidad_operativa", $unidad_operativa);

		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$codigoProgramacion[] = $filas;
		}

		return $codigoProgramacion;
	}



	public function listarFiltroServicioProgramaciones($fecha_inicial, $fecha_final, $proyecto, $unidad_operativa){

		$filtroProgramacion = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM programacion_servicios WHERE proyecto LIKE :proyecto AND unidad_operativa LIKE :unidad_operativa AND (fecha >= :fecha_inicial AND fecha <= :fecha_final) ORDER BY fecha, horario ASC ");
		$sql->bindParam(":fecha_inicial", $fecha_inicial);
		$sql->bindParam(":fecha_final", $fecha_final);
		$sql->bindParam(":proyecto", $proyecto);
		$sql->bindParam(":unidad_operativa", $unidad_operativa);

		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$filtroProgramacion[] = $filas;
		}

		return $filtroProgramacion;
	}


	public function listarServiciosProgramadosPorFecha($fecha){

		$programacionServ = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM programacion_servicios WHERE programacion = 'N' AND fecha = :fecha");
		$sql->bindParam(":fecha", $fecha);

		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$programacionServ[] = $filas;
		}

		return $programacionServ;
	}

	public function listar_programacion_serviciosID($id_programacion){

		$programacionServID = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM programacion_servicios WHERE id_programacion = ?");
		$sql->bindParam(1, $id_programacion);

		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$programacionServID[] = $filas;
		}

		return $programacionServID;
	}

	public function buscarProgramacionPorMes($mes){

		$ProgramacionPorFrecuencia = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM programacion_servicios WHERE MONTH(fecha) = :mes AND programacion = 'N' ");
		$sql->bindParam(':mes', $mes);
		$sql->execute();

		//echo "SELECT * FROM programacion_servicios WHERE frecuencia LIKE '%$dia%'";

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$ProgramacionPorFrecuencia[] = $filas;
		}

		return $ProgramacionPorFrecuencia;
	}

	public function finalizarServicioProgramacion($id_programacion){

		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE programacion_servicios SET estado = 'F' WHERE id_programacion = :id_programacion");
			$sql->bindParam(':id_programacion', $id_programacion);
			$sql->execute();

			if ($sql) {
				return 1;
			}else{
				return 0;
			}
			

			//echo "UPDATE programacion_servicios SET estado = 'F' WHERE id_programacion = '$id_programacion' ";

		} catch (Exception $e) {
			echo $e->getMessage();
		}

	}


	public function buscarProgramacionServiciosFecha($fecha, $id_padre_programacion){

		$ProgramacionPorFrecuencia = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM programacion_servicios WHERE fecha >= :fecha AND id_padre_programacion = :id_padre_programacion ");
		$sql->bindParam(':fecha', $fecha);
		$sql->bindParam(':id_padre_programacion', $id_padre_programacion);
		$sql->execute();

		//echo "SELECT * FROM programacion_servicios WHERE frecuencia LIKE '%$dia%'";

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$ProgramacionPorFrecuencia[] = $filas;
		}

		return $ProgramacionPorFrecuencia;
	}

	public function listarUnidadesOperativasProgramacion(){
		try {
			$unOperativa = array();
			$con = Conexion::conectar();
			$sql = $con->prepare("SELECT * FROM unidades_operativas_programacion ORDER BY id_unidad ASC");

			$sql->execute();

			while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
				$unOperativa[] = $filas;
			}

			return $unOperativa;

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function eliminarServicioProgramacion($id_programacion){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("DELETE FROM programacion_servicios WHERE id_programacion = :id_programacion");
			$sql->bindParam(":id_programacion", $id_programacion);

			$sql->execute();

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function registrarProgramacion($localidad, $codigo_identificativo, $proyecto, $unidad_operativa, $punto_inicio, $punto_final, $entrada_salida, $horario, $frecuencia, $observaciones, $capacidad_servicio, $nombre_monitora, $telefono_monitora, $id_vehiculo_facturacion, $id_vehiculo_liquidacion, $id_conductor, $valor_pagar, $valor_pagar_monitora, $valor_facturar){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO programacion_servicios (localidad, codigo_identificativo, proyecto, unidad_operativa, punto_inicio, punto_final, entrada_salida, horario, frecuencia, observaciones, capacidad_servicio, nombre_monitora, telefono_monitora, id_vehiculo_facturacion, id_vehiculo_liquidacion, id_conductor, valor_pagar, valor_pagar_monitora, valor_facturar, programacion, id_padre_programacion, estado) VALUES(:localidad, :codigo_identificativo, :proyecto, :unidad_operativa, :punto_inicio, :punto_final, :entrada_salida, :horario, :frecuencia, :observaciones, :capacidad_servicio, :nombre_monitora, :telefono_monitora, :id_vehiculo_facturacion, :id_vehiculo_liquidacion, :id_conductor, :valor_pagar, :valor_pagar_monitora, :valor_facturar, 'S', 0, 'A') ");

			$sql->bindParam(":localidad", $localidad);
			$sql->bindParam(":codigo_identificativo", $codigo_identificativo);
			$sql->bindParam(":proyecto", $proyecto);
			$sql->bindParam(":unidad_operativa", $unidad_operativa);
			$sql->bindParam(":punto_inicio", $punto_inicio);
			$sql->bindParam(":punto_final", $punto_final);
			$sql->bindParam(":entrada_salida", $entrada_salida);
			$sql->bindParam(":horario", $horario);
			$sql->bindParam(":frecuencia", $frecuencia);
			$sql->bindParam(":observaciones", $observaciones);
			$sql->bindParam(":capacidad_servicio", $capacidad_servicio);
			$sql->bindParam(":nombre_monitora", $nombre_monitora);
			$sql->bindParam(":telefono_monitora", $telefono_monitora);
			$sql->bindParam(":id_vehiculo_facturacion", $id_vehiculo_facturacion);
			$sql->bindParam(":id_vehiculo_liquidacion", $id_vehiculo_liquidacion);
			$sql->bindParam(":id_conductor", $id_conductor);
			$sql->bindParam(":valor_pagar", $valor_pagar);
			$sql->bindParam(":valor_pagar_monitora", $valor_pagar_monitora);
			$sql->bindParam(":valor_facturar", $valor_facturar);

			$sql->execute();

			//echo "INSERT INTO programacion_servicios (localidad, codigo_identificativo, proyecto, unidad_operativa, punto_inicio, punto_final, entrada_salida, horario, frecuencia, observaciones, capacidad_servicio, nombre_monitora, telefono_monitora, id_vehiculo_facturacion, id_vehiculo_liquidacion, id_conductor, valor_pagar, valor_pagar_monitora, valor_facturar, programacion, id_padre_programacion, estado) VALUES('$localidad', '$codigo_identificativo', '$proyecto', '$unidad_operativa', '$punto_inicio', '$punto_final', '$entrada_salida', '$horario', '$frecuencia', '$observaciones', '$capacidad_servicio', '$nombre_monitora', '$telefono_monitora', '$id_vehiculo_facturacion', '$id_vehiculo_liquidacion', '$id_conductor', '$valor_pagar', '$valor_pagar_monitora', '$valor_facturar', 'S', 0, 'A'); ";

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function actualizarProgramacion($id_programacion, $localidad, $proyecto, $unidad_operativa, $punto_inicio, $punto_final, $entrada_salida, $horario, $frecuencia, $observaciones, $capacidad_servicio, $nombre_monitora, $telefono_monitora, $id_vehiculo_facturacion, $id_vehiculo_liquidacion, $id_conductor, $valor_pagar, $valor_pagar_monitora, $valor_facturar){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE programacion_servicios SET localidad = :localidad, proyecto = :proyecto, unidad_operativa = :unidad_operativa, punto_inicio = :punto_inicio, punto_final = :punto_final, entrada_salida =:entrada_salida, horario = :horario, frecuencia = :frecuencia, observaciones = :observaciones, capacidad_servicio = :capacidad_servicio, nombre_monitora = :nombre_monitora, telefono_monitora = :telefono_monitora, id_vehiculo_facturacion = :id_vehiculo_facturacion, id_vehiculo_liquidacion = :id_vehiculo_liquidacion, id_conductor = :id_conductor, valor_pagar = :valor_pagar, valor_pagar_monitora = :valor_pagar_monitora, valor_facturar = :valor_facturar WHERE id_programacion = :id_programacion");

			$sql->bindParam(":id_programacion", $id_programacion);
			$sql->bindParam(":localidad", $localidad);
			$sql->bindParam(":proyecto", $proyecto);
			$sql->bindParam(":unidad_operativa", $unidad_operativa);
			$sql->bindParam(":punto_inicio", $punto_inicio);
			$sql->bindParam(":punto_final", $punto_final);
			$sql->bindParam(":entrada_salida", $entrada_salida);
			$sql->bindParam(":horario", $horario);
			$sql->bindParam(":frecuencia", $frecuencia);
			$sql->bindParam(":observaciones", $observaciones);
			$sql->bindParam(":capacidad_servicio", $capacidad_servicio);
			$sql->bindParam(":nombre_monitora", $nombre_monitora);
			$sql->bindParam(":telefono_monitora", $telefono_monitora);
			$sql->bindParam(":id_vehiculo_facturacion", $id_vehiculo_facturacion);
			$sql->bindParam(":id_vehiculo_liquidacion", $id_vehiculo_liquidacion);
			$sql->bindParam(":id_conductor", $id_conductor);
			$sql->bindParam(":valor_pagar", $valor_pagar);
			$sql->bindParam(":valor_pagar_monitora", $valor_pagar_monitora);
			$sql->bindParam(":valor_facturar", $valor_facturar);

			$sql->execute();

			//echo "UPDATE programacion_servicios SET localidad = '$localidad', proyecto = '$proyecto', unidad_operativa = '$unidad_operativa', punto_inicio = '$punto_inicio', punto_final = '$punto_final', entrada_salida ='$entrada_salida', horario = '$horario', frecuencia = '$frecuencia', observaciones = '$observaciones', capacidad_servicio = '$capacidad_servicio', nombre_monitora = '$nombre_monitora', telefono_monitora = '$telefono_monitora', id_vehiculo_facturacion = '$id_vehiculo_facturacion', id_vehiculo_liquidacion = '$id_vehiculo_liquidacion', id_conductor = '$id_conductor', valor_pagar = '$valor_pagar', valor_pagar_monitora = '$valor_pagar_monitora', valor_facturar = '$valor_facturar' WHERE id_programacion = '$id_programacion'";

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function registrarServiciosProgramacion($fecha, $localidad, $codigo_identificativo, $proyecto, $unidad_operativa, $punto_inicio, $punto_final, $entrada_salida, $horario, $frecuencia, $observaciones, $capacidad_servicio, $nombre_monitora, $telefono_monitora, $id_vehiculo_facturacion, $id_vehiculo_liquidacion, $id_conductor, $valor_pagar, $valor_pagar_monitora, $valor_facturar, $id_padre_programacion){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO programacion_servicios (fecha, localidad, codigo_identificativo, proyecto, unidad_operativa, punto_inicio, punto_final, entrada_salida, horario, frecuencia, observaciones, capacidad_servicio, programado, nombre_monitora, telefono_monitora, id_vehiculo_facturacion, id_vehiculo_liquidacion, id_conductor, valor_pagar, valor_pagar_monitora, valor_facturar, programacion, id_padre_programacion, estado) VALUES(:fecha, :localidad, :codigo_identificativo, :proyecto, :unidad_operativa, :punto_inicio, :punto_final, :entrada_salida, :horario, :frecuencia, :observaciones, :capacidad_servicio, 'OK', :nombre_monitora, :telefono_monitora, :id_vehiculo_facturacion, :id_vehiculo_liquidacion, :id_conductor, :valor_pagar, :valor_pagar_monitora, :valor_facturar, 'N', :id_padre_programacion, 'A') ");

			$sql->bindParam(":fecha", $fecha);
			$sql->bindParam(":localidad", $localidad);
			$sql->bindParam(":codigo_identificativo", $codigo_identificativo);
			$sql->bindParam(":proyecto", $proyecto);
			$sql->bindParam(":unidad_operativa", $unidad_operativa);
			$sql->bindParam(":punto_inicio", $punto_inicio);
			$sql->bindParam(":punto_final", $punto_final);
			$sql->bindParam(":entrada_salida", $entrada_salida);
			$sql->bindParam(":horario", $horario);
			$sql->bindParam(":frecuencia", $frecuencia);
			$sql->bindParam(":observaciones", $observaciones);
			$sql->bindParam(":capacidad_servicio", $capacidad_servicio);
			$sql->bindParam(":nombre_monitora", $nombre_monitora);
			$sql->bindParam(":telefono_monitora", $telefono_monitora);
			$sql->bindParam(":id_vehiculo_facturacion", $id_vehiculo_facturacion);
			$sql->bindParam(":id_vehiculo_liquidacion", $id_vehiculo_liquidacion);
			$sql->bindParam(":id_conductor", $id_conductor);
			$sql->bindParam(":valor_pagar", $valor_pagar);
			$sql->bindParam(":valor_pagar_monitora", $valor_pagar_monitora);
			$sql->bindParam(":valor_facturar", $valor_facturar);
			$sql->bindParam(":id_padre_programacion", $id_padre_programacion);

			$sql->execute();

			if ($sql) {
				return 1;
			}else{
				return 0;
			}

			//echo "INSERT INTO programacion_servicios (fecha, localidad, codigo_identificativo, proyecto, unidad_operativa, punto_inicio, punto_final, entrada_salida, horario, frecuencia, observaciones, capacidad_servicio, programado, nombre_monitora, telefono_monitora, id_vehiculo_facturacion, id_vehiculo_liquidacion, id_conductor, valor_pagar, valor_pagar_monitora, valor_facturar, programacion, id_padre_programacion, estado) VALUES('$fecha', '$localidad', '$codigo_identificativo', '$proyecto', '$unidad_operativa', '$punto_inicio', '$punto_final', '$entrada_salida', '$horario', '$frecuencia', '$observaciones', '$capacidad_servicio', 'OK', '$nombre_monitora', '$telefono_monitora', '$id_vehiculo_facturacion', '$id_vehiculo_liquidacion', '$id_conductor', '$valor_pagar', '$valor_pagar_monitora', '$valor_facturar', 'N', '$id_padre_programacion', 'A') ";

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function actualizarServiciosProgramacion($id_programacion, $fecha, $localidad, $proyecto, $unidad_operativa, $punto_inicio, $punto_final, $entrada_salida, $horario, $frecuencia, $observaciones, $capacidad_servicio, $nombre_monitora, $telefono_monitora, $novedades, $id_vehiculo_facturacion, $id_vehiculo_liquidacion, $id_conductor, $valor_pagar, $valor_pagar_monitora, $valor_facturar, $estado){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE programacion_servicios SET fecha = :fecha, localidad = :localidad, proyecto = :proyecto, unidad_operativa = :unidad_operativa, punto_inicio = :punto_inicio, punto_final = :punto_final, entrada_salida = :entrada_salida, horario = :horario, frecuencia = :frecuencia, observaciones = :observaciones, capacidad_servicio = :capacidad_servicio, nombre_monitora = :nombre_monitora, telefono_monitora = :telefono_monitora, novedades = :novedades, id_vehiculo_facturacion = :id_vehiculo_facturacion, id_vehiculo_liquidacion = :id_vehiculo_liquidacion, id_conductor = :id_conductor, valor_pagar = :valor_pagar, valor_pagar_monitora = :valor_pagar_monitora, valor_facturar = :valor_facturar, estado = :estado WHERE id_programacion = :id_programacion");

			$sql->bindParam(":id_programacion", $id_programacion);
			$sql->bindParam(":fecha", $fecha);
			$sql->bindParam(":localidad", $localidad);
			$sql->bindParam(":proyecto", $proyecto);
			$sql->bindParam(":unidad_operativa", $unidad_operativa);
			$sql->bindParam(":punto_inicio", $punto_inicio);
			$sql->bindParam(":punto_final", $punto_final);
			$sql->bindParam(":entrada_salida", $entrada_salida);
			$sql->bindParam(":horario", $horario);
			$sql->bindParam(":frecuencia", $frecuencia);
			$sql->bindParam(":observaciones", $observaciones);
			$sql->bindParam(":capacidad_servicio", $capacidad_servicio);
			$sql->bindParam(":nombre_monitora", $nombre_monitora);
			$sql->bindParam(":telefono_monitora", $telefono_monitora);
			$sql->bindParam(":novedades", $novedades);
			$sql->bindParam(":id_vehiculo_facturacion", $id_vehiculo_facturacion);
			$sql->bindParam(":id_vehiculo_liquidacion", $id_vehiculo_liquidacion);
			$sql->bindParam(":id_conductor", $id_conductor);
			$sql->bindParam(":valor_pagar", $valor_pagar);
			$sql->bindParam(":valor_pagar_monitora", $valor_pagar_monitora);
			$sql->bindParam(":valor_facturar", $valor_facturar);
			$sql->bindParam(":estado", $estado);

			$sql->execute();

		
			//echo "UPDATE programacion_servicios SET fecha = '$fecha', localidad = '$localidad', proyecto = '$proyecto', unidad_operativa = '$unidad_operativa', punto_inicio = '$punto_inicio', punto_final = '$punto_final', entrada_salida = '$entrada_salida', horario = '$horario', frecuencia = '$frecuencia', observaciones = '$observaciones', capacidad_servicio = '$capacidad_servicio', nombre_monitora = '$nombre_monitora', telefono_monitora = '$telefono_monitora', novedades = '$novedades', id_vehiculo_facturacion = '$id_vehiculo_facturacion', id_vehiculo_liquidacion = '$id_vehiculo_liquidacion', id_conductor = '$id_conductor', valor_pagar = '$valor_pagar', valor_pagar_monitora = '$valor_pagar_monitora', valor_facturar = '$valor_facturar', estado = '$estado' WHERE id_programacion = '$id_programacion' ";

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}


	/* SOLICITUD SERVICIOS VARIABLES */

	public function listarServiciosVariables(){

		$serviciosVariables = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM servicios_variables");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$serviciosVariables[] = $filas;
		}

		return $serviciosVariables;

	}
	public function listarServiciosVariablesID($id_Servicio){

		$serviciosVariablesID = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM servicios_variables WHERE id_servicio = :id_Servicio");
		$sql->bindParam(":id_Servicio", $id_Servicio);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$serviciosVariablesID[] = $filas;
		}

		return $serviciosVariablesID;

	}


	public function listarTiposServiciosVariables(){

		$tiposServiciosVariables = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM tipos_servicios_variables");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$tiposServiciosVariables[] = $filas;
		}

		return $tiposServiciosVariables;

	}


	public function listarTiposServiciosVariablesID($id){

		$tiposServiciosVariables = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM tipos_servicios_variables WHERE id = :id");
			$sql->bindParam(":id", $id);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$tiposServiciosVariables[] = $filas;
		}

		return $tiposServiciosVariables;

	}

	public function listarporCodigoTiposServiciosVariables($codigo){

		$codigoTSV = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM tipos_servicios_variables WHERE codigo LIKE :codigo");
			$sql->bindParam(":codigo", $codigo);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$codigoTSV[] = $filas;
		}

		return $codigoTSV;

	}

	public function registrarSolicitudesVariables($id_solicitante, $unidad_operativa, $fecha_inicial, $fecha_final, $direccion, $lugar_destino, $hora_encuentro, $hora_regreso, $capacidad, $cant_pax, $observaciones, $tipo_servicio, $num_buses, $fecha_registro){

		try {
				
			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO servicios_variables (id_solicitante, unidad_operativa, fecha_inicial, fecha_final, direccion, lugar_destino, hora_encuentro, hora_regreso, capacidad, cant_pax, observaciones, tipo_servicio, num_buses, estado, fecha_registro) VALUES(:id_solicitante, :unidad_operativa, :fecha_inicial, :fecha_final, :direccion, :lugar_destino, :hora_encuentro, :hora_regreso, :capacidad, :cant_pax, :observaciones, :tipo_servicio, :num_buses, 'P', :fecha_registro); ");

			$sql->bindParam(":id_solicitante", $id_solicitante);
			$sql->bindParam(":unidad_operativa", $unidad_operativa);
			$sql->bindParam(":fecha_inicial", $fecha_inicial);
			$sql->bindParam(":fecha_final", $fecha_final);
			$sql->bindParam(":direccion", $direccion);
			$sql->bindParam(":lugar_destino", $lugar_destino);
			$sql->bindParam(":hora_encuentro", $hora_encuentro);
			$sql->bindParam(":hora_regreso", $hora_regreso);
			$sql->bindParam(":capacidad", $capacidad);
			$sql->bindParam(":cant_pax", $cant_pax);
			$sql->bindParam(":observaciones", $observaciones);
			$sql->bindParam(":tipo_servicio", $tipo_servicio);
			$sql->bindParam(":num_buses", $num_buses);
			$sql->bindParam(":fecha_registro", $fecha_registro);

			$sql->execute();

	        return $id_solicitud_variable = $con->lastInsertId();

	        //echo "INSERT INTO servicios_variables (id_solicitante, unidad_operativa, fecha_inicial, fecha_final, direccion, lugar_destino, hora_encuentro, hora_regreso, capacidad, cant_pax, observaciones, tipo_servicio, num_buses, estado, fecha_registro) VALUES('$id_solicitante', '$unidad_operativa', '$fecha_inicial', '$fecha_final', '$direccion', '$lugar_destino', '$hora_encuentro', '$hora_regreso', '$capacidad', '$cant_pax', '$observaciones', '$tipo_servicio', '$num_buses', 'P', '$fecha_registro');";

		} catch (Exception $e) {
			echo $e->getMessage();
		}

	}

	public function actualizarSolicitudesVariables($id_servicio, $id_solicitante, $unidad_operativa, $fecha_inicial, $fecha_final, $direccion, $lugar_destino, $hora_encuentro, $hora_regreso, $capacidad, $cant_pax, $observaciones, $tipo_servicio, $num_buses){

		try {
				
			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE servicios_variables SET id_solicitante = :id_solicitante, unidad_operativa = :unidad_operativa, fecha_inicial = :fecha_inicial, fecha_final = :fecha_final, direccion = :direccion, lugar_destino = :lugar_destino, hora_encuentro = :hora_encuentro, hora_regreso = :hora_regreso, capacidad = :capacidad, cant_pax = :cant_pax, observaciones = :observaciones, tipo_servicio = :tipo_servicio, num_buses = :num_buses WHERE id_servicio = :id_servicio");

			$sql->bindParam(":id_servicio", $id_servicio);
			$sql->bindParam(":id_solicitante", $id_solicitante);
			$sql->bindParam(":unidad_operativa", $unidad_operativa);
			$sql->bindParam(":fecha_inicial", $fecha_inicial);
			$sql->bindParam(":fecha_final", $fecha_final);
			$sql->bindParam(":direccion", $direccion);
			$sql->bindParam(":lugar_destino", $lugar_destino);
			$sql->bindParam(":hora_encuentro", $hora_encuentro);
			$sql->bindParam(":hora_regreso", $hora_regreso);
			$sql->bindParam(":capacidad", $capacidad);
			$sql->bindParam(":cant_pax", $cant_pax);
			$sql->bindParam(":observaciones", $observaciones); 
			$sql->bindParam(":tipo_servicio", $tipo_servicio);
			$sql->bindParam(":num_buses", $num_buses);

			$sql->execute();

			//echo "UPDATE servicios_variables SET unidad_operativa = '$unidad_operativa', fecha = '$fecha', direccion = '$direccion', lugar_destino = '$lugar_destino', hora_encuentro = '$hora_encuentro', hora_regreso = '$hora_regreso', capacidad = '$capacidad', observaciones = '$observaciones', tipo_servicio = '$tipo_servicio', num_buses = '$num_buses' WHERE id_servicio = '$id_servicio'";

		} catch (Exception $e) {
			echo $e->getMessage();
		}

	}

	public function cambiarEstadoSolicitud($id_servicio, $estado, $obsEstado){
		try {
				
			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE servicios_variables SET estado = :estado, obsEstado = :obsEstado WHERE id_servicio = :id_servicio");

			$sql->bindParam(":estado", $estado);
			$sql->bindParam(":obsEstado", $obsEstado);
			$sql->bindParam(":id_servicio", $id_servicio);

			$sql->execute();

			//echo "UPDATE servicios_variables SET estado = '$estado', obsEstado = '$obsEstado' WHERE id_servicio = '$id_servicio'";

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}




}

 ?>