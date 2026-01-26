<?php 
session_start();

include ("Sesion/autenticar.php");
require_once ("../Modelo/ConceptosCobro.php");
require_once ("../Modelo/Cartera.php");

$cartera = new Cartera();
$concepto = new ConceptoCobro();

$id_vehiculo = $_POST['id_vehiculo'];
$hoy = "Y-m-d";
$num_id_comprobante = date('YmdHis');

$listarAnticiposPorVehiculo = $cartera->listarAnticiposPorVehiculo($id_vehiculo);
$valor_total = $_POST['total'];
$saldo_a_favor = $listarAnticiposPorVehiculo[0]['valor_anticipo'];
$diferencia_valores = $_POST['diferencia_valores'];
$valor_pagado = str_replace ( ".", "", $_POST['valor_pago']);


foreach($_POST['pagos'] As $pagos){
    
    $cobros_servicios = explode('|', $pagos);
    $id_cobro_propietario =  $cobros_servicios[0];
    $valor_servicio = $cobros_servicios[1];
    
    $fecha_pago = $_POST['fecha_pago'];
    $banco_consignacion = $_POST['id_cuenta'];
    
    $comprobante_pago = $_FILES['comprobante']['name'];
    
    date_default_timezone_set('America/Bogota');
    $fecha = date('YmdHis');
    
        if (!empty($comprobante_pago)) {
            $carpeta = '../Documentos/Comprobantes';
            $ruta = $carpeta .'/'. $fecha .'-'. $comprobante_pago;
            $comprobante_pago = $fecha .'-'. $comprobante_pago;

            $ruta_temp = $_FILES['comprobante']['tmp_name'];
            move_uploaded_file($ruta_temp, $ruta);
        }
    
    $detalle = $_POST['detalle'];
    $fecha_registro_comprobante = date('Y-m-d H:i:s');
    $usuario_registro = $_SESSION['id_usuario'];
    
    if($_SESSION['id_perfil'] == 2){ 
        $registrarComprobantePagoPropietario = $concepto->registrarComprobantePagoPropietario($id_cobro_propietario, $valor_servicio, $fecha_pago, $valor_pagado, $banco_consignacion, $num_id_comprobante, $comprobante_pago, $detalle, $fecha_registro_comprobante, $usuario_registro);
    }else{
        if($valor_total > $saldo_a_favor){
            $registrarComprobantePagoPropietario = $concepto->registrarComprobantePagoPropietario($id_cobro_propietario, $valor_servicio, $fecha_pago, ($valor_total - $saldo_a_favor), $banco_consignacion, $num_id_comprobante, $comprobante_pago, $detalle, $fecha_registro_comprobante, $usuario_registro);
        }else{
            $registrarComprobantePagoPropietario = $concepto->registrarComprobantePagoPropietario($id_cobro_propietario, $valor_servicio, $fecha_pago, 0, $banco_consignacion, $num_id_comprobante, $comprobante_pago, $detalle, $fecha_registro_comprobante, $usuario_registro);
        }
        
        $novedad = "";
        $estado = "A";
        $revisado_por = $_SESSION['id_usuario'];
        $actualizarEstadoComprobante = $concepto->actualizarComprobantePagoPropietario($registrarComprobantePagoPropietario, $estado, $novedad, $revisado_por, $fecha);
        
        $estadoCobroProp = "S";
        $actualizarEstadoCobroPropietario = $concepto->actualizarEstadoCobroPropietario($estadoCobroProp, $id_cobro_propietario);
        
    }
    
}


if(count($listarAnticiposPorVehiculo) > 0){
    if($valor_total > $saldo_a_favor){
        $valor_actual = 0;
        $estado = 'I';
        
        if($diferencia_valores > 0){
            $valor_actual_anticipo = $valor_actual + $diferencia_valores;
            $actualizarValorAnticipoCartera = $cartera->actualizarValorAnticipoCartera($listarAnticiposPorVehiculo[0]['id_anticipo'], $valor_actual_anticipo);
        }else{
            $actualizarEstadoAnticipoCartera = $cartera->actualizarEstadoAnticipoCartera($listarAnticiposPorVehiculo[0]['id_anticipo'], $estado);
        }
            
        
    }else{
        if($diferencia_valores > 0){
            $valor_actual_anticipo = ($saldo_a_favor - $valor_total) + $diferencia_valores;
        }else{
            $valor_actual_anticipo = ($saldo_a_favor - $valor_total);
        }
        
        $actualizarValorAnticipoCartera = $cartera->actualizarValorAnticipoCartera($listarAnticiposPorVehiculo[0]['id_anticipo'], $valor_actual_anticipo);
    }
}else if(count($listarAnticiposPorVehiculo) == 0){
    if($_POST['diferencia_valores'] > 0){
        $valor_actual_anticipo = $_POST['diferencia_valores'];
        $id_concepto = 0;
        $estado = "A";
    
        //$registrarAnticipoCartera = $cartera->registrarAnticipoCartera($id_vehiculo, $valor_actual_anticipo, $num_id_comprobante, $id_concepto, $estado);
        
    }
}


$fecha_cruce = date("Y-m-d H:i:s");

if($valor_total > $saldo_a_favor){
    $registrarCruceSaldosCartera = $cartera->registrarCruceSaldosCartera($listarAnticiposPorVehiculo[0]['id_anticipo'], $saldo_a_favor, $valor_total, ($valor_total - $saldo_a_favor), $num_id_comprobante, $fecha_cruce);
}else{
    $registrarCruceSaldosCartera = $cartera->registrarCruceSaldosCartera($listarAnticiposPorVehiculo[0]['id_anticipo'], $saldo_a_favor, $valor_total, 0, $num_id_comprobante, $fecha_cruce);
}


include '../Vista/Template/styles.php';

?>

<style type="text/css" media="screen">
	@import url('https://fonts.googleapis.com/css?family=Poppins&display=swap');

body{
    background: #eeeeee;
    font-family: 'Poppins', sans-serif;
}

#registrar:hover{
	background-color: #18ad13;
	color: #fff !important;
}

#continuar:hover{
	background-color: #c40c0c;
	color: #fff !important;

}

</style>

<div style="display: flex; justify-content: center; margin-top: 60px;">
	<div class="mb-2" style="border-bottom: 4px solid #fff; height: 1px; width: 50%;"></div>
</div>

<div style="display: flex; justify-content: center;">
	<div class="row" style="background: #fff; width: 50%; height: 170px; border-radius: 2px;">
		<section class="col-8">
			<div class="row d-flex justify-content-center mt-4">
                <p class="ml-4 logo" id="k" style="font-size: 1.6rem; font-weight: bold;">KING</p>  
                <p class="ml-1 mr-3 logo" id="v" style="font-size: 1.6rem; font-weight: bolder;">VISION</p>
			    <?php if($_SESSION['id_perfil'] == 2){ ?> 
				    <p class="text-center" style="font-family: 'Raleway', sans-serif;">Se ha registrado y enviado correctamente su comprobante de pago/s</p>
				<?php } else { ?>
			        <p class="text-center" style="font-family: 'Raleway', sans-serif;">Se ha registrado correctamente su comprobante de pago/s</p>
			    <?php } ?>
            </div>
		</section>
		<section class="col-4" style="border-left: 4px solid #eee">
			<div class="mt-5">
			    <?php if($_SESSION['id_perfil'] == 2){ ?>
				    <a href="../Controlador/enviarCorreoComprobante.php?num_id=<?php echo $num_id_comprobante ?>" type="button" class="btn btn-block" id="volver" style="border: 1px solid #c40c0c; border-radius: 18px; color: #c40c0c; ">Volver</a>
			    <?php } else { ?>
			        <a href="../Vista/activar_cobro.php" type="button" class="btn btn-block" id="volver" style="border: 1px solid #22a33f; border-radius: 18px; color: #22a33f; ">Volver</a>
			        <a target="_blank" href="../Vista/PDF/reciboCaja.php?num_id_comprobante=<?php echo $num_id_comprobante . "-" . $_SESSION['id_usuario']; ?>" type="button" class="btn btn-block" id="PDF" style="border: 1px solid #c40c0c; border-radius: 18px; color: #c40c0c; ">PDF Recibo Caja</a>
			    <?php } ?>
			    
			</div>
		</section>
	</div>
</div>

<div style="display: flex; justify-content: center;">
	<div class="mt-2" style="border-bottom: 4px solid #fff; height: 1px; width: 50%;"></div>
</div>

<?php include '../Vista/Template/scripts.php'; ?>