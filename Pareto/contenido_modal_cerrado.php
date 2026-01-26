<?php
session_start();
require('bd/datos.php');
$idp = $_GET["id"];

$querys = new consultas;
$actividadid = $querys->actividad_id($_SESSION['idus'],$idp);
$actipareto = $querys->actividadespadre($idp);
$cantact = count($actipareto);
$tipos = $querys->tiposact();

$hoy = date("Y-m-d");
$fecha = date("Y-m-d"); 
$rangomin = (30 * 60);//cantidad minutos * 60 segundos;
$timestamp = strtotime($fecha.' 00:00:00')-$rangomin; 
$timestamp_limite = strtotime($fecha.' 23:30:00'); 

$fecha1 = new DateTime($hoy);
$fecha2 = new DateTime($actividadid[0]['fecha']);
$resultado = $fecha1->diff($fecha2);
$diasrestantes = $resultado->format('%a');
?>
<html lang="es">
<?php include('head.php');?>
<script>
$(document).ready(function() {
  $(function() {
    $('#fechap').datepicker({
      dateFormat: 'yy-mm-dd',
      showButtonPanel: false,
      changeMonth: true,
      changeYear: true,
      minDate: '-0D',
	  maxDate: '+<?php echo $diasrestantes;?>D',
      inline: true
    });
  });
  $.datepicker.regional['es'] = {
    closeText: 'Cerrar',
    prevText: '<Ant',
    nextText: 'Sig>',
    currentText: 'Hoy',
    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
    weekHeader: 'Sm',
    dateFormat: 'yy-mm-dd',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
  };
  $.datepicker.setDefaults($.datepicker.regional['es']);
});

function valor(id,campo){
	if(document.getElementById(campo).checked==true){
		var parametros = {
                "id" : id,
				"estado" : 1
        };
		$.ajax({
                data:  parametros,
                url:   'act_estado.php',
                type:  'post',
                beforeSend: function () {
                        //$("#semana").html("Procesando, espere por favor...");
                },
                success:  function (response) {
					//alert(response);
                    //$("#semana").html(response);
                }
        });
	} else {
		var parametros = {
                "id" : id,
				"estado" : 0
        };
		$.ajax({
                data:  parametros,
                url:   'act_estado.php',
                type:  'post',
                beforeSend: function () {
                        //$("#semana").html("Procesando, espere por favor...");
                },
                success:  function (response) {
					//alert(response);
                    //$("#semana").html(response);
                }
        });
	}
}
function modal2(id){
	$('#modal2').modal({show:true});
}
function cerrarmodal(idmodal){
	$('#modal2').modal({show:false});
	document.getElementById(idmodal).style.display = "none";
	document.getElementById('nuevo').reset();

}
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script><!-- date picker -->
  
  <script>
  

function rangohora(hora){
	//alert(hora);
	var parametros = {
			"hora" : hora
	};
	$.ajax({
			data:  parametros,
			url:   'select_horas.php',
			type:  'post',
			beforeSend: function () {
					$("#horaf").html("Procesando, espere por favor...");
			},
			success:  function (response) {
				//alert(response);
					$("#horaf").html(response);
			}
	});
}
</script>
<div class="col-lg-12">
<section class="panel">
<header align="right">
</header>
<div class="table-responsive">
<table class="table">

<thead>
<tr>
<th>#</th>
<th>Descripción</th>
<th>Fecha</th>
<th>Estado</th>
</tr>
</thead>
<tbody>
<?php if ($cantact > 0){ $i = 1; ?>
<?php foreach($actipareto as $acti1){?>
<tr>

<td><?php echo $i;?></td>
<td><?php echo $acti1['descripcion'];?></td>
<td><?php echo $acti1['fecha'];?></td>
<td>
<label class="switch">
<input type="checkbox" value="<?php echo $acti1['id'];?>" id="<?php echo $acti1['id'];?>" onclick="valor(this.value,this.id)" <?php if ($acti1['estado'] == 1){ ?> checked="checked" <?php } ?>>
<span class="slider round"></span>
</label>
</td>
</tr>
<?php $i++; } ?>
<?php } else { ?>
<tr><td colspan="5" align="center">sin registros</td></tr>
<?php } ?>
</tbody>
</table>
</div>


</section>
</div>
<div class="modal2 fade" id="modal2" role="dialog" style="display:none; padding:5px">
	<div class="modal-dialog2" style="width:100%">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" onclick="cerrarmodal('modal2')">×</button>
				<h4 class="modal-title">NUEVA ACTIVIDAD INTERNA</h4>
			</div>
			<div class="modal-body2" style="padding:8px">
				<form class="form-validate form-horizontal " id="nuevo" method="post" action="guardar_subactividad.php">
                    <input type="hidden" value="<?php echo $idp;?>" name="padre" id="padre"/>
					<div class="form-group ">
                      <label for="descripcion" class="control-label col-lg-2">Descripcion <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class=" form-control" id="descripcion" name="descripcion" type="text" required />
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="tipo" class="control-label col-lg-2">Tipo Actividad <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <select class=" form-control" id="tipo" name="tipo" required >
							<?php foreach ($tipos as $tp){?>
							<option value="<?php echo $tp['id'];?>"><?php echo $tp['detalle'];?></option>
							<?php } ?>
						</select>
                      </div>
                    </div>
					<div class="form-group ">
                      <label for="fechap" class="control-label col-lg-2">Fecha <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input type='text' class="form-control" id='fechap' name="fechap" required autocomplete="off" />
                      </div>
                    </div>
					<div class="form-group ">
                      <label for="horai" class="control-label col-lg-2">Hora Inicio <span class="required">*</span></label>
                      <div class="col-lg-10">
						<select name="horai" id="horai" class=" form-control" required onchange="rangohora(this.value)">
						<option value="">SELECCIONE HORA DE INICIO</option>
						<?php			
						$timestamp1 = strtotime($fecha.' 00:00:00')-$rangomin; 
						$timestamp_limite1 = strtotime($fecha.' 23:30:00'); 
						while ($timestamp < $timestamp_limite){
							$timestamp += $rangomin; 
							$hora1 = strtoupper(date("H:i:s", $timestamp));
							$hora2 = strtoupper(date("h:i a", $timestamp));							
							echo "<option value=".$hora1.">".$hora2."</option>"; 
						} 
						?>
						</select>                        
                      </div>
                    </div>
					<div class="form-group ">
                      <label for="horaf" class="control-label col-lg-2">Hora Fin <span class="required">*</span></label>
                      <div class="col-lg-10">
						<select name="horaf" id="horaf" class="form-control" required="required"></select>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <button class="btn btn-primary" type="submit">Guardar</button>
                        <button class="btn btn-default" type="button" onclick="cerrarmodal('modal2')">Cancelar</button>
                      </div>
                    </div>
                  </form>
			</div>
		</div>
	</div>
</div>
</html>