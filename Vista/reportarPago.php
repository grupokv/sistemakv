<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/ConceptosCobro.php");
require_once '../Modelo/Vehiculo.php';

$concepto = new ConceptoCobro();
$vehiculo = new Vehiculo();

$buscarVehiculoPorPropietario = $vehiculo->buscarVehiculoPorPropietario($_SESSION['id_usuario']);
$listado_veh = '';

$i=1;
foreach($buscarVehiculoPorPropietario as $vp){
	if($i==count($buscarVehiculoPorPropietario)){
		$listado_veh .= $vp['id_vehiculo'];
	} else {
		$listado_veh .= $vp['id_vehiculo'].',';
	}	
$i++; 
}

$pagos_pendientes = $concepto->pagosPendientes($listado_veh);
$cant_pp = count($pagos_pendientes);

/* VARIABLES MENU*/
$redireccion = 'pagos_pendientes_propietario.php';

$bancos = $concepto->listarBancos();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Enviar Comprobante</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- STYLES -->
        <?php include("Template/styles.php"); ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
    <!-- FIN STYLES -->

</head>
<body>

    <!-- MENU -->
        <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!-- FIN MENU -->

    <!-- ************************************ -->

    <!-- CONTENIDO -->

        <section class="home_content">
    
            <div aria-label="breadcrumb" class="mt-1"> 
                 <ol class="breadcrumb" style="background-color: #fff;">
                    <li class="breadcrumb-item" aria-current="page"><a href="inicio.php">Inicio</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="pagos_pendientes_propietario.php">Pagos Pendientes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Enviar Comprobante</li>
                 </ol>
            </div>

            <div class="notice notice-sistemakv">
                <strong><i class="fa fa-dollar mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">ENVIAR COMPROBANTE DE PAGO</b></strong>
            </div>


            <section class="form-usuarios mt-1">
                <div class="formulario mb-5">
                    <!--FORMULARIO -->

        	            <form method="POST" action="../Controlador/enviarComprobante.php" enctype="multipart/form-data">

        						<input type="hidden" value="<?php echo $cant_pp;?>" name="cant_pendientes"/>
        						<?php if($cant_pp > 0){ ?>
        						
        						<div class="row mt-3 d-flex justify-content-center">
        						    <section class="col-11">
            							<table class="table table-hover table-sm display" width="auto" align="center" border="0">
            								<thead style="background-color:#1b2d3b; color:#fff;">
                								<tr align="center">
                									<th></th>
                									<th>PLACA</th>
                									<th>SERVICIO</th>
                									<th>FECHA</th>
                									<th>VALOR</th>
                								</tr>
            								</thead>
            								<tbody>
                								<?php foreach($pagos_pendientes as $pp){
                    								$datos_v = $vehiculo->listarPorId($pp['id_vehiculo']);
                        							$datos_c = $concepto->listarPorId($pp['id_concepto']); ?>	
                        							
                								    <tr align="center">
                								        <td style='border: inset 0pt'><input type="checkbox" name="pagos[]" value="<?php echo $pp['id_cobro'].'|'.$pp['valor'];?>" id="checkbox_<?php echo $pp['id_cobro'];?>" onchange="sumar(this.value,this.id)"/></td>
                								        <td style='border: inset 0pt'><?php echo $datos_v[0]['placa']; ?></td>		
                        								<td style='border: inset 0pt'><?php echo $datos_c[0]['detalle_concepto']; ?></td>
                        								<td style='border: inset 0pt'><?php echo $pp['fecha_cobro']; ?></td>
                        								<td style='border: inset 0pt'><?php echo '$ '.number_format($pp['valor'],0,',','.'); ?></td>
                								    </tr>
            								    <?php } ?>
            								    
                								<tr align="center">								
                								    <td style='border: inset 0pt' colspan="4"><b>TOTAL</td>								
                								    <td style='border: inset 0pt'><b id="valor_total"></b></td>								
                								</tr>
            								</body>
            							</table>
            						</section>
        						</div>
        						<?php } ?>
        	                    
                                <!-- FECHA DE PAGO -->
        		                    <div class="row mt-3 ">
        		                    	<section class="label">
        		                    	 	<label>Fecha de Pago</label>
        		                    	</section>
        		                    	<section class="input">
        		                    	 	<input type="text" name="fecha_pago" id="datepicker" class="form-control" required="required" onblur="comparar()">
        		                    	</section>
        		                    </div>
                                
                                <!-- VALOR PAGADO -->
        		     	   			<div class="row mt-3 " id="fechaFinal">
        		                    	<section class="label">
        		     	                    <label>Valor Pagado </label>
        		     	                </section>
        		                    	<section class="input">
        		     	                    <input type="text" name="valor_pago" id="valor_pago" class="form-control" required="required" onblur="comparar()">
        		     	                </section>
        		                    </div>
                                
                                <!-- BANCO DE CONSIGNACIÓN -->
        		                    <div class="row mt-3" id="ciudad">
        		                    	<section class="label">
        				     	            <label>Banco donde consigno</label>
        				     	        </section>
        		                    	<section class="input">
        						     	    <select class="form-control selectpicker" data-live-search="true" name="id_cuenta" id="id_cuenta" required="required" onchange="comparar()">
        						     	    	<option value="">SELECCIONAR</option>
        									 	<?php foreach ($bancos as $bn){ ?>
        									 		<option value="<?php echo $bn['id_cuenta'];?>">
        									 			<?php echo $bn['descripcion']; ?>
        									 		</option>
        									 	<?php } ?>
        									</select>
        				     	        </section>
        		                    </div>

                    			<!-- COMPROBANTE-->
                    				<div class="row mt-3">
        		                    	<section class="label">
        		     	                    <label>Comprobante <b>(Doc Soporte)</b></label>
        		     	                </section>
        		                    	<section class="input">
        		                    		<input type="file" name="comprobante" id="comprobante" class="form-control" required="required" onchange="comparar();">
        		     	                    
        		     	                </section>
        		               	 	</div>

        				            <div class="row mt-3"  id="detalle_diferencia" style="display:none;">
        		                    	<section class="label">
        		     	                    <label>Detalle de la diferencia de valores</label>
        		     	                </section>
        		                    	<section class="input">
        		                    		<textarea name="detalle" id="detalle" class="form-control" required="required"></textarea>
        		     	                    
        		     	                </section>
        		               	 	</div>

                                <hr>
                                <?php include("Template/bottom-form.php"); ?>
        	            </form> 
                </div>
            </section>



    <?php include("Template/scripts.php"); ?>

	<script type="text/javascript">

        $( function() {
	        $( "#datepicker" ).datepicker({
	        	dateFormat: "yy-mm-dd",
	        	maxDate: 0
	        });
	    } );

	    var total = 0;
        function sumar(datos,id){
		    var split = datos.split('|');
		    if (document.getElementById(id).checked){
			    total = (Number(total) + Number(split[1]));
		    } else {
    			if(total > 0){
    				total = (Number(total) - Number(split[1]));
    			}
		    }
		    
        	document.getElementById('valor_total').innerHTML = '$ ' + new Intl.NumberFormat("es-ES").format(total);
        	
		    comparar();
        }
        
    	function comparar(){
    		var valor_consignado = document.getElementById('valor_pago').value;
    		valor_consignado = valor_consignado.replace(".", "");
    		
    		if(valor_consignado == total){
                document.getElementById("detalle_diferencia").style.display = "none";
        	    $('#detalle').prop("required", false);
    		} else {
                document.getElementById("detalle_diferencia").style.display = "flex";
        	    $('#detalle').prop('required', true);
    		}	
    	}
    	
        $("#valor_pago").on({
            "focus": function(event) {
                $(event.target).select();
            },
            "keyup": function(event) {
                $(event.target).val(function(index, value) {
                  return value.replace(/\D/g, "").replace(/([0-9])([0-9]{0})$/, '$1$2').replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
                });
            }
        });
	</script>

</body>
</html>