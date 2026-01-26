<?php
require_once("Conexion/conexionBD.php");

class ConceptoCobro{		
	
	public function listar(){		
		$ciudades = array();		
		$con = Conexion::conectar();		
		$sql = $con->prepare("SELECT * FROM conceptos_cobro");		
		$sql->execute();		
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {			
			$ciudades[] = $filas;		
		}		return $ciudades;	
	}		
	
	
	public function listarPagosComprobantesPorNumIdComprobante($num_id_comprobante){
	    $Comprobantes = array();
	    $con = Conexion::conectar();
	    $sql = $con->prepare("SELECT * FROM comprobantes_pagos_propietarios WHERE num_id_comprobante = :num_id_comprobante");
        $sql->bindParam(":num_id_comprobante", $num_id_comprobante);
        
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $Comprobantes[] = $filas; 
        }
        
        return $Comprobantes;
	}

	public function listarActivos(){		
		$ciudaPorId = array();		
		$con = Conexion::conectar();		
		$sql = $con->prepare("SELECT * FROM conceptos_cobro WHERE estado = '1'");		
		$sql->execute();		
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {			
			$ciudaPorId[] = $filas;		
		}		
		return $ciudaPorId;	
	}

	public function listarBancos(){		
		$ciudaPorId = array();		
		$con = Conexion::conectar();		
		$sql = $con->prepare("SELECT * FROM cuentas_bancos");		
		$sql->execute();		
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {			
			$ciudaPorId[] = $filas;		
		}		
		return $ciudaPorId;	
	}	

	public function listarBancosId($id_cuenta){		
		$bancoId = array();		
		$con = Conexion::conectar();		
		$sql = $con->prepare("SELECT * FROM cuentas_bancos WHERE id_cuenta = :id_cuenta");        
		$sql->bindParam(":id_cuenta", $id_cuenta);            		
		$sql->execute();		
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {			
			$bancoId[] = $filas;		
		}		
		return $bancoId;	
	}
	
	public function listarCobros(){
	    $cobros = array();
	    $con = Conexion::conectar();
	    $sql = $con->prepare("SELECT * FROM cobro_propietario");
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $cobros[] = $filas; 
        }
        
        return $cobros;
	}

	public function listarCobrosPorIdConcepto($id_concepto, $id_vehiculo){
	    $cobrosConceptos = array();
	    $con = Conexion::conectar();
	    $sql = $con->prepare("SELECT * FROM cobro_propietario WHERE id_concepto = :id_concepto AND id_Vehiculo in($id_vehiculo) AND estado = 'P' ORDER BY fecha_cobro ASC");       
		$sql->bindParam(":id_concepto", $id_concepto);            	       
		/*$sql->bindParam(":id_vehiculo", $id_vehiculo);    */        	
        $sql->execute();

        //echo "SELECT * FROM cobro_propietario WHERE id_concepto = '$id_concepto' AND id_Vehiculo in('$id_vehiculo') AND estado = 'P' ";vist
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $cobrosConceptos[] = $filas; 
        }
        
        return $cobrosConceptos;
	}

	public function listarTotalPorConceptoYVehiculos($id_concepto, $id_vehiculo){
		$TotalConceptos = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT SUM(valor) As total FROM cobro_propietario WHERE id_concepto = $id_concepto AND id_vehiculo in($id_vehiculo) AND estado = 'P' ");    
		/*$sql->bindParam(":id_concepto", $id_concepto);            	       
		$sql->bindParam(":id_vehiculo", $id_vehiculo);*/            	
        $sql->execute();

        //echo "SELECT SUM(valor) As total FROM cobro_propietario WHERE id_concepto = '$id_concepto' AND id_vehiculo in($id_vehiculo) AND estado = 'P' ";
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $TotalConceptos[] = $filas; 
        }
        
        return $TotalConceptos;

	}

	public function listarPorId($id){        
		$listarConceptoId = array();            
		$con = Conexion::conectar();            
		$sql = $con->prepare("SELECT * FROM conceptos_cobro WHERE id_concepto = :id_concepto");            
		$sql->bindParam(":id_concepto", $id);            
		$sql->execute();            
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
			$listarConceptoId[] = $filas;            
		}        
		return $listarConceptoId;    
	}	

	public function listarPorIdCobrosPropietario($id_cobro_propietario){        
		$listarCobrosPropietarioId = array();            
		$con = Conexion::conectar();            
		$sql = $con->prepare("SELECT * FROM cobro_propietario WHERE id_cobro = :id_cobro");            
		$sql->bindParam(":id_cobro", $id_cobro_propietario);            
		$sql->execute();            
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
			$listarCobrosPropietarioId[] = $filas;            
		}        
		return $listarCobrosPropietarioId;    
	}	

	public function listarCobrosPropietarioID($id_cobro){        
		$listarCobrosPropietario = array();            
		$con = Conexion::conectar();            
		$sql = $con->prepare("SELECT * FROM cobro_propietario WHERE id_cobro IN ($id_cobro)");            
		$sql->bindParam(":id_cobro", $id_cobro);            
		$sql->execute();            

		//echo "SELECT * FROM cobro_propietario WHERE id_cobro IN (id_cobro)";

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
			$listarCobrosPropietario[] = $filas;            
		}        
		return $listarCobrosPropietario;    
	}		

	public function buscarPorDetalle($detalle){        
		$listar = array();            
		$con = Conexion::conectar();            
		$sql = $con->prepare("SELECT * FROM conceptos_cobro WHERE detalle_concepto = ?");            
		$sql->bindParam(1, $detalle);            
		$sql->execute();            
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
			$listar[] = $filas;            
		}        
		return $listar;    
	}	

	public function buscarValor($concepto,$tipovehiculo){        
		$listar = array();            
		$con = Conexion::conectar();            
		$sql = $con->prepare("SELECT * FROM cobro_tipo_vehiculo WHERE id_concepto = ? and id_tipo_vehiculo = ?");            
		$sql->bindParam(1, $concepto);	    
		$sql->bindParam(2, $tipovehiculo);            
		$sql->execute();            
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
			$listar[] = $filas;            
		}        
		return $listar;    
	}

	public function pagosPendientes($vehiculos){        
		$listar = array();            
		$con = Conexion::conectar();            
		$sql = $con->prepare("SELECT * FROM cobro_propietario WHERE id_vehiculo in($vehiculos) and estado = 'P'");                      
		$sql->execute();            
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
			$listar[] = $filas;            
		}        
		return $listar;    
	}
	
	public function pagosPendientesPorVehiculo($id_vehiculo){        
		$listarPV = array();            
		$con = Conexion::conectar();            
		$sql = $con->prepare("SELECT * FROM cobro_propietario WHERE id_vehiculo = :id_vehiculo and estado = 'P'");         
		$sql->bindParam(":id_vehiculo", $id_vehiculo);                    
		$sql->execute();            
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
			$listarPV[] = $filas;            
		}        
		return $listarPV;    
	}
	
	public function registrarComprobantePagoPropietario($id_cobro_propietario, $valor_servicio, $fecha_pago, $valor_pagado, $banco_consignacion, $num_id_comprobante, $comprobante_pago, $detalle, $fecha_registro_comprobante, $usuario_registro){
	    try{
	        $con = Conexion::conectar();                
			$sql = $con->prepare("INSERT INTO comprobantes_pagos_propietarios (id_cobro_propietario, valor_servicio, fecha_pago, valor_pagado, banco_consignacion, num_id_comprobante, comprobante_pago, detalle, fecha_registro_comprobante, usuario_registro) VALUES (:id_cobro_propietario, :valor_servicio, :fecha_pago, :valor_pagado, :banco_consignacion, :num_id_comprobante, :comprobante_pago, :detalle, :fecha_registro_comprobante, :usuario_registro);");
			$sql->bindParam(":id_cobro_propietario", $id_cobro_propietario);
			$sql->bindParam(":valor_servicio", $valor_servicio);
			$sql->bindParam(":fecha_pago", $fecha_pago);
			$sql->bindParam(":valor_pagado", $valor_pagado);
			$sql->bindParam(":banco_consignacion", $banco_consignacion);
			$sql->bindParam(":num_id_comprobante", $num_id_comprobante);
			$sql->bindParam(":comprobante_pago", $comprobante_pago);
			$sql->bindParam(":detalle", $detalle);
			$sql->bindParam(":fecha_registro_comprobante", $fecha_registro_comprobante);
			$sql->bindParam(":usuario_registro", $usuario_registro);
			        
			$sql->execute();                
			
            $id_comprobante_pago = $con->lastInsertId();

            return $id_comprobante_pago; 
			//echo "INSERT INTO comprobantes_pagos_propietarios(id_cobro_propietario, valor_servicio, fecha_pago, valor_pagado, banco_consignacion, num_id_comprobante, comprobante_pago, detalle, fecha_registro_comprobante, usuario_registro) VALUES('$id_cobro_propietario', '$valor_servicio', '$fecha_pago', '$valor_pagado', '$banco_consignacion', '$num_id_comprobante', '$comprobante_pago', '$detalle', '$fecha_registro_comprobante', '$usuario_registro')";
	    
	        
	    }catch(Exception $e){
	        echo $e->getMessage();
	    }
	}

	public function registrarComprobanteTransaccion($id_cobro_propietario, $valor_servicio, $fecha_pago, $valor_pagado, $num_id_comprobante, $referencia_transaccion, $fecha_registro_comprobante, $usuario_registro, $fecha_revision){
	    try{
	        $con = Conexion::conectar();                
			$sql = $con->prepare("INSERT INTO comprobantes_pagos_propietarios (id_cobro_propietario, valor_servicio, fecha_pago, valor_pagado, num_id_comprobante, referencia_transaccion, fecha_registro_comprobante, usuario_registro, estado, fecha_revision) VALUES (:id_cobro_propietario, :valor_servicio, :fecha_pago, :valor_pagado, :num_id_comprobante, :referencia_transaccion, :fecha_registro_comprobante, :usuario_registro, 'A', :fecha_revision);");

			$sql->bindParam(":id_cobro_propietario", $id_cobro_propietario);
			$sql->bindParam(":valor_servicio", $valor_servicio);
			$sql->bindParam(":fecha_pago", $fecha_pago);
			$sql->bindParam(":valor_pagado", $valor_pagado);
			$sql->bindParam(":num_id_comprobante", $num_id_comprobante);
			$sql->bindParam(":referencia_transaccion", $referencia_transaccion);
			$sql->bindParam(":fecha_registro_comprobante", $fecha_registro_comprobante);
			$sql->bindParam(":usuario_registro", $usuario_registro);
			$sql->bindParam(":fecha_revision", $fecha_revision);
			        
			$sql->execute();                
			
			//echo "INSERT INTO comprobantes_pagos_propietarios (id_cobro_propietario, valor_servicio, fecha_pago, valor_pagado, num_id_comprobante, referencia_transaccion, fecha_registro_comprobante, usuario_registro, estado, fecha_revision) VALUES ('$id_cobro_propietario', '$valor_servicio', '$fecha_pago', '$valor_pagado', '$num_id_comprobante', '$referencia_transaccion', '$fecha_registro_comprobante', '$usuario_registro', 'A', '$fecha_revision');";
	    
	        
	    }catch(Exception $e){
	        echo $e->getMessage();
	    }
	}
	
	public function listarComprobantesPagosPropietario($num_id_comprobante){
	    $listarComprobantesPagos = array();
	    $con = Conexion::conectar();                
		$sql = $con->prepare("SELECT * FROM comprobantes_pagos_propietarios WHERE num_id_comprobante = :num_id_comprobante");
		$sql->bindParam(":num_id_comprobante", $num_id_comprobante);
		$sql->execute();   
		
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
			$listarComprobantesPagos[] = $filas;            
		}        
		return $listarComprobantesPagos;
	}

	public function listarComprobantesPagosFecha($fecha_registro){
	    $listarComprobantesPagosFecha = array();
	    $con = Conexion::conectar();                
		$sql = $con->prepare("SELECT * FROM comprobantes_pagos_propietarios WHERE DATE(fecha_registro_comprobante) = :fecha_registro");
		$sql->bindParam(":fecha_registro", $fecha_registro);
		$sql->execute();   
		
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
			$listarComprobantesPagosFecha[] = $filas;            
		}        
		return $listarComprobantesPagosFecha;
	}

	public function listarComprobantesPagosSemanales($fecha_inicial, $fecha_final){
	    $listarComprobantesPagosSemanal = array();
	    $con = Conexion::conectar();                
		$sql = $con->prepare("SELECT * FROM comprobantes_pagos_propietarios WHERE (DATE(fecha_registro_comprobante) >= '$fecha_inicial'AND DATE(fecha_registro_comprobante) <= '$fecha_final')");
		$sql->bindParam(":fecha_inicial", $fecha_inicial);
		$sql->bindParam(":fecha_inicial", $fecha_inicial);
		$sql->execute();  
		
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
			$listarComprobantesPagosSemanal[] = $filas;            
		}        
		return $listarComprobantesPagosSemanal;
	}

	public function actualizarComprobantePagoPropietario($id_comprobante, $estado, $novedad, $revisado_por, $fecha_revision){
	    try{
	        $con = Conexion::conectar();                
			$sql = $con->prepare("UPDATE comprobantes_pagos_propietarios SET estado = :estado, novedad = :novedad, revisado_por = :revisado_por, fecha_revision = :fecha_revision WHERE id_comprobante = :id_comprobante");
			$sql->bindParam(":id_comprobante", $id_comprobante);
			$sql->bindParam(":estado", $estado);
			$sql->bindParam(":novedad", $novedad);
			$sql->bindParam(":revisado_por", $revisado_por);
			$sql->bindParam(":fecha_revision", $fecha_revision);
			        
			$sql->execute();                
		
	    }catch(Exception $e){
	        echo $e->getMessage();
	    }
	}
	

	public function registrar($detalle,$cuenta,$contra,$estado,$frecuencia,$fecha){            
		try {                
			$con = Conexion::conectar();                
			$sql = $con->prepare("INSERT INTO conceptos_cobro (detalle_concepto, cuenta_puc, contra_cuenta_puc, estado, frecuencia, siguiente_fecha) VALUES (:detalle, :cuenta, :contra, :estado, :frecuencia, :fecha)");              
			$sql->bindParam(":detalle", $detalle);                
			$sql->bindParam(":cuenta", $cuenta);                
			$sql->bindParam(":contra", $contra);		
			$sql->bindParam(":estado", $estado);		
			$sql->bindParam(":frecuencia", $frecuencia);		
			$sql->bindParam(":fecha", $fecha);                
			$sql->execute();                
			return $id_concepto = $con->lastInsertId();            
		} catch (Exception $e) {                
			echo $e->getMessage();            
		}                        
	}	

	public function registrarValor($id,$tipo_vehiculo,$valor){            
		try {                
			$con = Conexion::conectar();                
			$sql = $con->prepare("INSERT INTO cobro_tipo_vehiculo (id_concepto, id_tipo_vehiculo, valor) VALUES (:id, :tipo_vehiculo, :valor)");                
			$sql->bindParam(":id", $id);                
			$sql->bindParam(":tipo_vehiculo", $tipo_vehiculo);                
			$sql->bindParam(":valor", $valor);                
			$sql->execute();                
			return $id_concepto = $con->lastInsertId();            
		} catch (Exception $e) {                
			echo $e->getMessage();            
		}                        
	}

	public function registrarReciboCaja($nombre_documento,$fecha_creacion){            
		try {                
			$con = Conexion::conectar();                
			$sql = $con->prepare("INSERT INTO recibosCaja (nombre_documento, fecha_creacion) VALUES (:nombre_documento, :fecha_creacion)");                
			$sql->bindParam(":nombre_documento", $nombre_documento);                
			$sql->bindParam(":fecha_creacion", $fecha_creacion);                
			$sql->execute();                
			return $id_reciboCaja = $con->lastInsertId(); 
			
		} catch (Exception $e) {                
			echo $e->getMessage();            
		}                        
	}
	
	public function actualizarEstadoCobroPropietario($estado, $id_cobro){            
		try {                
			$con = Conexion::conectar();                
			$sql = $con->prepare("UPDATE cobro_propietario SET estado = :estado WHERE id_cobro = :id_cobro");   
			$sql->bindParam(":id_cobro", $id_cobro);              
			$sql->bindParam(":estado", $estado);              
			$sql->execute();              
			
			//echo "UPDATE cobro_propietario SET estado = '$estado' WHERE id_cobro = '$id_cobro'";

		} catch (Exception $e) {                
			echo $e->getMessage();            
		}                        
	}	

	public function registrarCobro($id_vehiculo,$concepto, $valor,$estado,$fecha_cobro){            
		try {                
			$con = Conexion::conectar();                
			$sql = $con->prepare("INSERT INTO cobro_propietario (id_vehiculo, id_concepto, valor, estado, fecha_cobro) VALUES (:id_vehiculo, :concepto, :valor, :estado, :fecha_cobro)");                
			$sql->bindParam(":id_vehiculo", $id_vehiculo);                
			$sql->bindParam(":concepto", $concepto);                               
			$sql->bindParam(":valor", $valor);
			$sql->bindParam(":estado", $estado);  
			$sql->bindParam(":fecha_cobro", $fecha_cobro);             
			$sql->execute();                

			//echo "INSERT INTO cobro_propietario (id_vehiculo, id_concepto, valor, estado, fecha_cobro) VALUES ('$id_vehiculo', '$concepto', '$valor', '$estado', '$fecha_cobro')";
			return $id_concepto = $con->lastInsertId();            
		} catch (Exception $e) {                
			echo $e->getMessage();            
		}                        
	}	


	public function actualizarValor($id,$tipo_vehiculo,$valor){            
		try {                
			$con = Conexion::conectar();                
			$sql = $con->prepare("UPDATE cobro_tipo_vehiculo SET  valor = :valor WHERE id_concepto = :id and id_tipo_vehiculo = :tipo_vehiculo");                
			$sql->bindParam(":id", $id);                
			$sql->bindParam(":tipo_vehiculo", $tipo_vehiculo);                
			$sql->bindParam(":valor", $valor);                
			$sql->execute();            
		} catch (Exception $e) {                
			echo $e->getMessage();            
		}                        
	}

	public function actualizarFechaConcepto($id, $fecha){            
		try {                
			$con = Conexion::conectar();                
			$sql = $con->prepare("UPDATE conceptos_cobro SET siguiente_fecha = :fecha WHERE id_concepto = :id");                		
			$sql->bindParam(":fecha", $fecha);
			$sql->bindParam(":id", $id);                               
			                
			$sql->execute();  
			
			if($sql){
			    return 1;
			}else{
			    return 0;
			}
			
		} catch (Exception $e) {                
			echo $e->getMessage();            
		}                        
	}  

	public function actualizar($id,$detalle,$cuenta,$contra,$estado,$frecuencia,$fecha){            
		try {                
			$con = Conexion::conectar();                
			$sql = $con->prepare("UPDATE conceptos_cobro SET detalle_concepto = :detalle, cuenta_puc = :cuenta, contra_cuenta_puc = :contra, estado = :estado, frecuencia = :frecuencia, siguiente_fecha = :fecha WHERE id_concepto = :id ");                
			$sql->bindParam(":detalle", $detalle);                
			$sql->bindParam(":cuenta", $cuenta);                
			$sql->bindParam(":contra", $contra);		
			$sql->bindParam(":estado", $estado);		
			$sql->bindParam(":frecuencia", $frecuencia);		
			$sql->bindParam(":fecha", $fecha);                
			$sql->bindParam(":id", $id);                
			$sql->execute();                            
		} catch (Exception $e) {                
			echo $e->getMessage();            
		}                       
	}
	
	/*NOTIFICACIONES*/
	
	
	public function registrarNotificacionComprobante($comunicado, $num_id_comprobante, $id_usuario_comprobante, $fecha_registro, $id_usuario_notificacion, $estado){
	    try{
	        $con = Conexion::conectar();
	        $sql = $con->prepare("INSERT INTO notificaciones_comprobantesPagos (comunicado, num_id_comprobante, id_usuario_comprobante, fecha_registro, id_usuario_notificacion, estado) VALUES(:comunicado, :num_id_comprobante, :id_usuario_comprobante, :fecha_registro, :id_usuario_notificacion, :estado)");
	        $sql->bindParam(":comunicado", $comunicado);
	        $sql->bindParam(":num_id_comprobante", $num_id_comprobante);
	        $sql->bindParam(":id_usuario_comprobante", $id_usuario_comprobante);
	        $sql->bindParam(":fecha_registro", $fecha_registro);
	        $sql->bindParam(":id_usuario_notificacion", $id_usuario_notificacion);
	        $sql->bindParam(":estado", $estado);
	        
	        $sql->execute();
	        
	    }catch(Exception $e){
	        echo $e->getMessage();
	    }
	}
	
	public function listarNotificacionesComprobante($id_usuario_comprobante){
	    $notificacionesComprobantes = array();
	    $con = Conexion::conectar();
	    $sql = $con->prepare("SELECT * FROM notificaciones_comprobantesPagos WHERE id_usuario_comprobante = :id_usuario_comprobante AND estado != 'E' ");
        $sql->bindParam(":id_usuario_comprobante", $id_usuario_comprobante);
        
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $notificacionesComprobantes[] = $filas; 
        }
        
        return $notificacionesComprobantes;
	}
	
	
	public function eliminarNotificacionComprobante($id_notificacion_comprobante){
	    try{
	        $con = Conexion::conectar();
	        $sql = $con->prepare("UPDATE notificaciones_comprobantesPagos SET estado = 'E' WHERE id_notificacion_comprobante = :id_notificacion_comprobante");
	        $sql->bindParam(":id_notificacion_comprobante", $id_notificacion_comprobante);
	        
	        $sql->execute();
	        
	    }catch(Exception $e){
	        echo $e->getMessage();
	    }
	}
	
	/*REPORTE*/
	
	public function listarFiltroServicioFrecuenciaAnual($id_concepto, $fecha_anio){
	    $FiltroFrecuenciaAnual = array();
	    $con = Conexion::conectar();
	    $sql = $con->prepare("SELECT * FROM cobro_propietario WHERE id_concepto LIKE :id_concepto AND YEAR(fecha_cobro) = :fecha_anio ");
        $sql->bindParam(":id_concepto", $id_concepto);
        $sql->bindParam(":fecha_anio", $fecha_anio);
        
        $sql->execute();
        
       // echo "SELECT * FROM cobro_propietario WHERE id_concepto LIKE '$id_concepto' AND YEAR(fecha_cobro) = '$fecha_anio'";
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $FiltroFrecuenciaAnual[] = $filas; 
        }
        
        return $FiltroFrecuenciaAnual;
	}
	
	public function listarFiltroServicioFrecuenciaMensual($id_concepto, $fecha_mes){
	    $FiltroFrecuenciaMensual = array();
	    $con = Conexion::conectar();
	    $sql = $con->prepare("SELECT * FROM cobro_propietario WHERE id_concepto LIKE :id_concepto AND MONTH(fecha_cobro) = :fecha_mes ");
        $sql->bindParam(":id_concepto", $id_concepto);
        $sql->bindParam(":fecha_mes", $fecha_mes);
        
        $sql->execute();
        
        //echo "SELECT * FROM cobro_propietario WHERE id_concepto LIKE '$id_concepto' AND MONTH(fecha_cobro) = '$fecha_mes' ";
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $FiltroFrecuenciaMensual[] = $filas; 
        }
        
        return $FiltroFrecuenciaMensual;
	}
	
	public function listarFiltroServicioSinFrecuencia($id_concepto, $fecha_cobro){
	    $FiltroSinFrecuencia = array();
	    $con = Conexion::conectar();
	    $sql = $con->prepare("SELECT * FROM cobro_propietario WHERE id_concepto LIKE :id_concepto AND MONTH(fecha_cobro) = :fecha_cobro");
        $sql->bindParam(":id_concepto", $id_concepto);
        $sql->bindParam(":fecha_cobro", $fecha_cobro);
        
        $sql->execute();
        
        //echo "SELECT * FROM cobro_propietario As cp INNER JOIN conceptos_cobro As cc ON cp.id_concepto = cc.id_concepto WHERE cp.id_concepto LIKE '$id_concepto' AND cc.frecuencia = 'N'";
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $FiltroSinFrecuencia[] = $filas; 
        }
        
        return $FiltroSinFrecuencia;
	}
	
	public function listarFiltroEstadoCuentaVehiculo($id_vehiculo, $fecha_cobro){
	    $FiltroFrecuenciaMensual = array();
	    $con = Conexion::conectar();
	    $sql = $con->prepare("SELECT * FROM cobro_propietario WHERE id_vehiculo LIKE :id_vehiculo AND MONTH(fecha_cobro) = :fecha_cobro");
        $sql->bindParam(":id_vehiculo", $id_vehiculo);
        $sql->bindParam(":fecha_cobro", $fecha_cobro);
        
        $sql->execute();
        
        //echo "SELECT * FROM cobro_propietario WHERE id_vehiculo LIKE '$id_vehiculo' ";
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $FiltroFrecuenciaMensual[] = $filas; 
        }
        
        return $FiltroFrecuenciaMensual;
	}
	
	public function listarCobrosPorVehiculo($id_vehiculo){
	    $CobroPorVehiculo = array();
	    $con = Conexion::conectar();
	    $sql = $con->prepare("SELECT * FROM cobro_propietario WHERE id_vehiculo LIKE :id_vehiculo AND estado = 'P' ORDER BY id_concepto ASC, fecha_cobro ASC");
        $sql->bindParam(":id_vehiculo", $id_vehiculo);
        
        $sql->execute();
        
        //echo "SELECT * FROM cobro_propietario WHERE id_vehiculo LIKE '$id_vehiculo' AND estado = 'P' GROUP BY id_concepto ";
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $CobroPorVehiculo[] = $filas; 
        }
        
        return $CobroPorVehiculo;
	}
	
	
	
	public function listarTotalCobrosPorVehiculo($id_vehiculo){
	    $TotalCobroVehiculo = array();
	    $con = Conexion::conectar();
	    $sql = $con->prepare("SELECT COUNT(*) As total_concepto, cc.id_concepto FROM cobro_propietario AS cp INNER JOIN conceptos_cobro AS cc ON cp.id_concepto = cc.id_concepto WHERE cp.id_vehiculo LIKE :id_vehiculo AND cp.estado = 'P' GROUP BY cp.id_concepto Asc order by cc.id_concepto Asc ");
        $sql->bindParam(":id_vehiculo", $id_vehiculo);
        
        $sql->execute();
        
        //echo "SELECT COUNT(*) As total_concepto, cc.id_concepto FROM cobro_propietario AS cp INNER JOIN conceptos_cobro AS cc ON cp.id_concepto = cc.id_concepto WHERE cp.id_vehiculo LIKE '18' AND cp.estado = 'P' GROUP BY cp.id_concepto Asc order by cc.id_concepto Asc  ";
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $TotalCobroVehiculo[] = $filas; 
        }
        
        return $TotalCobroVehiculo;
	}
	
		
	public function listarComprobantesPorCuentaBanco($banco_consignacion, $fecha_pago){
	    $listarComprobantesCuentaBanco = array();
	    $con = Conexion::conectar();                
		$sql = $con->prepare("SELECT * FROM comprobantes_pagos_propietarios WHERE banco_consignacion = :banco_consignacion AND MONTH(fecha_pago) = :fecha_pago AND estado = 'A' ");
		$sql->bindParam(":banco_consignacion", $banco_consignacion);
		$sql->bindParam(":fecha_pago", $fecha_pago);
		$sql->execute();   
		
		//echo "SELECT * FROM comprobantes_pagos_propietarios WHERE banco_consignacion = '$banco_consignacion' AND MONTH(fecha_pago) = '$fecha_pago' AND estado = 'A' ";
		
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
			$listarComprobantesCuentaBanco[] = $filas;            
		}        
		return $listarComprobantesCuentaBanco;
	}

	public function ListarComprobantes(){
	    $listarComprobantes = array();
	    $con = Conexion::conectar();                
		$sql = $con->prepare("SELECT * FROM comprobantes_pagos_propietarios ORDER BY id_comprobante DESC");
		$sql->execute();   

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarComprobantes[] = $filas;
		}

		return $listarComprobantes;
	}
}


?>