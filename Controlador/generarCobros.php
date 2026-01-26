<?php
date_default_timezone_set('America/Bogota');
include 'Sesion/autenticar.php';
require_once("../Modelo/ConceptosCobro.php");
require_once("../Modelo/TipoVehiculo.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Cartera.php");


$hoy = date('Y-m-d');
$fecha = date('Y-m-d H:i:s');

$cartera = new Cartera();
$concepto = new ConceptoCobro();
$tv = new TipoVehiculo();
$vehiculo = new Vehiculo();

$id_concepto = $_POST['id_concepto'];

if($_POST['cobroPorVehiculo'] == "N"){
    if($_POST['inhabilitar_cobro'] == 1){
        if($_POST['opcion_cobro'] == "VE"){
            
            $id_vehiculo = $_POST['id_vehiculo'];
            $listado_vehiculos = $vehiculo->listarVehiculosVinculados();
                
            $vehiculos = array();
            
            foreach($listado_vehiculos As $lv){
                array_push($vehiculos, $lv['id_vehiculo']);
            }
            
            
            for($i = 0; $i < count($id_vehiculo); $i++){
                if (($clave = array_search($id_vehiculo[$i], $vehiculos)) !== false) {
                    unset($vehiculos[$clave]);
                }
            }
        
        
            for($i = 0; $i < count($vehiculos); $i++){
                
                $listarVehiculoPorId = $vehiculo->listarPorId($vehiculos[$i]);
                $listarDescuentosCarteraPorIdVehiculo = $cartera->listarDescuentosCarteraPorIdVehiculo($listarVehiculoPorId[0]['id_vehiculo'], $id_concepto);
                
                $tipo_vehiculo = $listarVehiculoPorId[0]['id_tipo_vehiculo'];
        		$estado = 'P';
        		$busqueda = $concepto->buscarValor($id_concepto, $tipo_vehiculo);
                $fecha_cobro = date('Y-m-d');
        		
        		if(count($busqueda) > 0){
        		    if(count($listarDescuentosCarteraPorIdVehiculo) > 0){
        		        if(($hoy >= $listarDescuentosCarteraPorIdVehiculo[0]['fecha_inicial_valido']) && ($hoy <= $listarDescuentosCarteraPorIdVehiculo[0]['fecha_final_valido'])){
        		            
        		            if($listarDescuentosCarteraPorIdVehiculo[0]['tipo_descuento'] == "PORCENTAJE"){
        		                $registrar = $concepto->registrarCobro($listarVehiculoPorId[0]['id_vehiculo'], $id_concepto, $busqueda[0]['valor'] - ($busqueda[0]['valor'] * $listarDescuentosCarteraPorIdVehiculo[0]['descuento'] / 100),$estado, $fecha_cobro);
        		                
        		            }else if($listarDescuentosCarteraPorIdVehiculo[0]['tipo_descuento'] == "FIJO"){
        		                $registrar = $concepto->registrarCobro($listarVehiculoPorId[0]['id_vehiculo'], $id_concepto, ($busqueda[0]['valor'] - $listarDescuentosCarteraPorIdVehiculo[0]['descuento']),$estado, $fecha_cobro);
        		            }
    		
            		        $fecha_cruce = date('Y-m-d');
                            $hora_cruce = date('H:i:s');
                            $registrarCrucesDescuentos = $cartera->registrarCruceDescuento($registrar, $listarDescuentosCarteraPorIdVehiculo[0]['id_descuento'], $fecha_cruce, $hora_cruce); 
                                
        		        }
        		    }else{
        			    $registrar = $concepto->registrarCobro($listarVehiculoPorId[0]['id_vehiculo'], $id_concepto, $busqueda[0]['valor'],$estado, $fecha_cobro);
        		    }
        		}
            
            }
                
                
        }else if($_POST['opcion_cobro'] == "FP"){
            if($_POST['id_empresa'] == "TFP"){
                
                $listarVehiculoFlotaPropia = $vehiculo->listarVehiculoFlotaPropia();
                
                $listado_vehiculos = $vehiculo->listarVehiculosVinculados();
                
                $vehiculos = array();
                
                foreach($listado_vehiculos As $lv){
                    array_push($vehiculos, $lv['id_vehiculo']);
                }
                
                
                for($i = 0; $i < count($listarVehiculoFlotaPropia); $i++){
                    if (($clave = array_search($listarVehiculoFlotaPropia[$i]['id_vehiculo'], $vehiculos)) !== false) {
                        unset($vehiculos[$clave]);
                    }
                }
            
            
                for($i = 0; $i < count($vehiculos); $i++){
                    
                    $listarVehiculoPorId = $vehiculo->listarPorId($vehiculos[$i]);
                    $listarDescuentosCarteraPorIdVehiculo = $cartera->listarDescuentosCarteraPorIdVehiculo($listarVehiculoPorId[0]['id_vehiculo'], $id_concepto);
                    
                    $tipo_vehiculo = $listarVehiculoPorId[0]['id_tipo_vehiculo'];
            		$estado = 'P';
            		$busqueda = $concepto->buscarValor($id_concepto, $tipo_vehiculo);
                    $fecha_cobro = date('Y-m-d');
            		
            		if(count($busqueda) > 0){
            		    if(count($listarDescuentosCarteraPorIdVehiculo) > 0){
            		        if(($hoy >= $listarDescuentosCarteraPorIdVehiculo[0]['fecha_inicial_valido']) && ($hoy <= $listarDescuentosCarteraPorIdVehiculo[0]['fecha_final_valido'])){
            		            
            		            if($listarDescuentosCarteraPorIdVehiculo[0]['tipo_descuento'] == "PORCENTAJE"){
            		                $registrar = $concepto->registrarCobro($listarVehiculoPorId[0]['id_vehiculo'], $id_concepto, $busqueda[0]['valor'] - ($busqueda[0]['valor'] * $listarDescuentosCarteraPorIdVehiculo[0]['descuento'] / 100),$estado,$fecha_cobro);
            		            }else if($listarDescuentosCarteraPorIdVehiculo[0]['tipo_descuento'] == "FIJO"){
            		                $registrar = $concepto->registrarCobro($listarVehiculoPorId[0]['id_vehiculo'], $id_concepto, ($busqueda[0]['valor'] - $listarDescuentosCarteraPorIdVehiculo[0]['descuento']),$estado,$fecha_cobro);
            		            }
    		
            		            $fecha_cruce = date('Y-m-d');
                                $hora_cruce = date('H:i:s');
                                $registrarCrucesDescuentos = $cartera->registrarCruceDescuento($registrar, $listarDescuentosCarteraPorIdVehiculo[0]['id_descuento'], $fecha_cruce, $hora_cruce); 
                                
            		        }
            		    }else{
            			    $registrar = $concepto->registrarCobro($listarVehiculoPorId[0]['id_vehiculo'], $id_concepto, $busqueda[0]['valor'],$estado,$fecha_cobro);
            		    }
            		}
                
                }
                
            }else{
                
                $id_empresa = $_POST['id_empresa'];
                
                $listarVehiculoPorFlotaPropiaYEmpresa = $vehiculo->listarVehiculoPorFlotaPropiaYEmpresa($id_empresa);
                $listado_vehiculos = $vehiculo->listarVehiculosVinculados();
                
                $vehiculos = array();
                
                foreach($listado_vehiculos As $lv){
                    array_push($vehiculos, $lv['id_vehiculo']);
                }
                
                
                for($i = 0; $i < count($listarVehiculoPorFlotaPropiaYEmpresa); $i++){
                    if (($clave = array_search($listarVehiculoPorFlotaPropiaYEmpresa[$i]['id_vehiculo'], $vehiculos)) !== false) {
                        unset($vehiculos[$clave]);
                    }
                }
            
            
                for($i = 0; $i < count($vehiculos); $i++){
                    
                    $listarVehiculoPorId = $vehiculo->listarPorId($vehiculos[$i]);
                    //print_r($listarVehiculoPorId);
                    $listarDescuentosCarteraPorIdVehiculo = $cartera->listarDescuentosCarteraPorIdVehiculo($listarVehiculoPorId[0]['id_vehiculo'], $id_concepto);
                    
                    $tipo_vehiculo = $listarVehiculoPorId[0]['id_tipo_vehiculo'];
            		$estado = 'P';
            		$busqueda = $concepto->buscarValor($id_concepto, $tipo_vehiculo);
                    $fecha_cobro = date('Y-m-d');
            		
            		if(count($busqueda) > 0){
            		    if(count($listarDescuentosCarteraPorIdVehiculo) > 0){
            		        if(($hoy >= $listarDescuentosCarteraPorIdVehiculo[0]['fecha_inicial_valido']) && ($hoy <= $listarDescuentosCarteraPorIdVehiculo[0]['fecha_final_valido'])){
            		            if($listarDescuentosCarteraPorIdVehiculo[0]['tipo_descuento'] == "PORCENTAJE"){
            		                $registrar = $concepto->registrarCobro($listarVehiculoPorId[0]['id_vehiculo'], $id_concepto, $busqueda[0]['valor'] - ($busqueda[0]['valor'] * $listarDescuentosCarteraPorIdVehiculo[0]['descuento'] / 100),$estado,$fecha_cobro);
            		            }else if($listarDescuentosCarteraPorIdVehiculo[0]['tipo_descuento'] == "FIJO"){
            		                
            		                $registrar = $concepto->registrarCobro($listarVehiculoPorId[0]['id_vehiculo'], $id_concepto, ($busqueda[0]['valor'] - $listarDescuentosCarteraPorIdVehiculo[0]['descuento']),$estado,$fecha_cobro);
            		            }
            		            
            		            $fecha_cruce = date('Y-m-d');
                                $hora_cruce = date('H:i:s');
                                $registrarCrucesDescuentos = $cartera->registrarCruceDescuento($registrar, $listarDescuentosCarteraPorIdVehiculo[0]['id_descuento'], $fecha_cruce, $hora_cruce); 
                               
            		        }
            		    }else{
            			    $registrar = $concepto->registrarCobro($listarVehiculoPorId[0]['id_vehiculo'], $id_concepto, $busqueda[0]['valor'],$estado,$fecha_cobro);
            		    }
            		}
                }
                
            }
            
        }
    }else{
        
        $listado_vehiculos = $vehiculo->listarVehiculosVinculados();
        if(count($listado_vehiculos) > 0){
        	foreach($listado_vehiculos as $lv){
        	    $listarDescuentosCarteraPorIdVehiculo = $cartera->listarDescuentosCarteraPorIdVehiculo($lv['id_vehiculo'], $id_concepto);
        	   
        		$tipo_vehiculo = $lv['id_tipo_vehiculo'];
        		$estado = 'P';
        		$busqueda = $concepto->buscarValor($id_concepto, $tipo_vehiculo);
                $fecha_cobro = date('Y-m-d');
        		
        		if(count($busqueda) > 0){
        		    if(count($listarDescuentosCarteraPorIdVehiculo) > 0){
        		        if(($hoy >= $listarDescuentosCarteraPorIdVehiculo[0]['fecha_inicial_valido']) && ($hoy <= $listarDescuentosCarteraPorIdVehiculo[0]['fecha_final_valido'])){
        		            if($listarDescuentosCarteraPorIdVehiculo[0]['tipo_descuento'] == "PORCENTAJE"){
        		                $registrar = $concepto->registrarCobro($lv['id_vehiculo'], $id_concepto, $busqueda[0]['valor'] - ($busqueda[0]['valor'] * $listarDescuentosCarteraPorIdVehiculo[0]['descuento'] / 100),$estado,$fecha_cobro);
        		            }else if($listarDescuentosCarteraPorIdVehiculo[0]['tipo_descuento'] == "FIJO"){
        		                $registrar = $concepto->registrarCobro($lv['id_vehiculo'], $id_concepto, ($busqueda[0]['valor'] - $listarDescuentosCarteraPorIdVehiculo[0]['descuento']),$estado,$fecha_cobro);
        		            }
            		            
        		            $fecha_cruce = date('Y-m-d');
        		            $hora_cruce = date('H:i:s');
    		                $registrarCrucesDescuentos = $cartera->registrarCruceDescuento($registrar, $listarDescuentosCarteraPorIdVehiculo[0]['id_descuento'], $fecha_cruce, $hora_cruce); 
            		            
        		        }
        		    }else{
        			    $registrar = $concepto->registrarCobro($lv['id_vehiculo'],$id_concepto, $busqueda[0]['valor'],$estado,$fecha_cobro);
        		    }
        		}
        	}	
        }
    
    }
}else{
    
    $detalle_servicio = $_POST['detalle_servicio'];
    $id_vehiculo = $_POST['id_vehiculo'];
    $estado = 'P';
    $cobro = $_POST['cobro'];
    $fecha_cobro = date('Y-m-d');
    
    $listarDescuentosCarteraPorIdVehiculo = $cartera->listarDescuentosCarteraPorIdVehiculo($id_vehiculo, $detalle_servicio);
    
    if(count($listarDescuentosCarteraPorIdVehiculo) > 0){
    	if(($hoy >= $listarDescuentosCarteraPorIdVehiculo[0]['fecha_inicial_valido']) && ($hoy <= $listarDescuentosCarteraPorIdVehiculo[0]['fecha_final_valido'])){
    		if($listarDescuentosCarteraPorIdVehiculo[0]['tipo_descuento'] == "PORCENTAJE"){
                $registrar = $concepto->registrarCobro($id_vehiculo, $detalle_servicio, $cobro - ($cobro * $listarDescuentosCarteraPorIdVehiculo[0]['descuento'] / 100), $estado, $fecha_cobro);
    		}else if($listarDescuentosCarteraPorIdVehiculo[0]['tipo_descuento'] == "FIJO"){
    		    $registrar = $concepto->registrarCobro($id_vehiculo, $detalle_servicio, ($cobro - $listarDescuentosCarteraPorIdVehiculo[0]['descuento']), $estado, $fecha_cobro);
    		}
            		            
            $fecha_cruce = date('Y-m-d');
            $hora_cruce = date('H:i:s');
            $registrarCrucesDescuentos = $cartera->registrarCruceDescuento($registrar, $listarDescuentosCarteraPorIdVehiculo[0]['id_descuento'], $fecha_cruce, $hora_cruce); 
           		           		         		           
    	}
    }else{
        $registrar = $concepto->registrarCobro($id_vehiculo, $detalle_servicio, $cobro, $estado, $fecha_cobro);
    }
}

$datos = $concepto->listarPorId($id_concepto);

if($datos[0]['frecuencia'] == 'M'){
	$nueva_fecha = date('Y-m-d',strtotime($datos[0]['siguiente_fecha']."+ 1 month"));
} else if($datos[0]['frecuencia'] == 'A'){
	$nueva_fecha = date('Y-m-d',strtotime($datos[0]['siguiente_fecha']."+ 1 year"));
}


$act = $concepto->actualizarFechaConcepto($id_concepto, $nueva_fecha);	

if($act == 1){
    echo "<script> alert('Cobros generados exitosamente'); window.location.href = '../Vista/activar_cobro.php'; </script>";    
    exit;
} else {
    echo "<script>alert('Ocurrio un error al intentar activar los cobros'); window.location.href = '../Vista/activar_cobro.php'; </script>";    
    exit;
}

?>