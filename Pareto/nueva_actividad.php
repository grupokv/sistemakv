<?php
session_start();
if (($_SESSION['user'] == '')or($_SESSION['pass'] == '')){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
	window.location.href='index.php';
	</SCRIPT>");
}
require('bd/datos.php');
$querys = new consultas;
$fecha = date('Y-m-d');
$paretos=$querys->pareto_activo($_SESSION['idus'],$fecha);
$cantidad = count($paretos);
$idpareto = $paretos[0]['id'];
$tipos = $querys->tiposact();
$objetivos = $querys->obj_especificos($_SESSION['idus']);
$frecuencia = $querys->frecuencia();
//echo count($frecuencia);
$invitados = $querys->usuarios();

if($_POST){
	$pareto = $_POST['pareto'];
	$descripc = $_POST['descripcion'];
	$tipo = $_POST['tipo'];
	$fechap = $_POST['fechap'];
	$fechalimite = $_POST['fechalimite'];
	
	
	if($fechap > $fechalimite){
		$pareto = 0;
	}
	$horai = $_POST['horai'];
	$horaf = $_POST['horaf'];
	$idusuario = $_SESSION['idus'];
	$id_invitados = '';
	if($_POST['invitar_id'] != ''){
		$id_invitados = $_POST['invitar_id'];
	}
	
	if($id_invitados != ''){
		
		$aplica = $_POST['aplica'];
		if ($aplica == 'S'){ $id_objetivo = $_POST['objetivo']; } else { $id_objetivo = '0'; }
		$frecuencia = '1';
		$hoy = date('Y-m-d H:i:s');
		$sql = "insert into pareto_actividades(id_usuario,id_pareto,id_padre,descripcion,id_tipoactividad,estado,fecha,hora,fecha_fin,hora_fin,fecha_creacion,fecha_modificacion,activo,id_creador,id_frecuencia,aplica_objetivo,id_objetivo) values ('$idusuario','$pareto','0','$descripc','$tipo','0','$fechap','$horai','$fechap','$horaf','$hoy','$hoy','A','$idusuario','$frecuencia','$aplica','$id_objetivo')";
		$insert = new base_datos;
		$insert->connect();
		$insert->query($sql);
		
		$idcreado = mysql_insert_id();
		
		$invit = explode(",",$id_invitados);
		$cantinv = count($invit);
		
		for($i=0;$i<$cantinv;$i++){
		
		$id_inv = $invit[$i];
		
			if($id_inv != ''){
				$sql = "insert into invitaciones (id_anfitrion,id_invitado,id_actividad,estado,respuesta) values ('$idusuario','$id_inv','$idcreado','P','')";
				$insert = new base_datos;
				$insert->connect();
				$insert->query($sql);
			}
		
		}
	
	} else {
		
	$aplica = $_POST['aplica'];
	if ($aplica == 'S'){ $id_objetivo = $_POST['objetivo']; } else { $id_objetivo = '0'; }
		
	$frecuencia = $_POST['frecuencia'];	
	$hoy = date('Y-m-d H:i:s');

    if($frecuencia == 1){
  	$sql = "insert into pareto_actividades(id_usuario,id_pareto,id_padre,descripcion,id_tipoactividad,estado,fecha,hora,fecha_fin,hora_fin,fecha_creacion,fecha_modificacion,activo,id_creador,id_frecuencia,aplica_objetivo,id_objetivo) values ('$idusuario','$pareto','0','$descripc','$tipo','0','$fechap','$horai','$fechap','$horaf','$hoy','$hoy','A','$idusuario','$frecuencia','$aplica','$id_objetivo')";
  	$insert = new base_datos;
  	$insert->connect();
  	$insert->query($sql);
    } else {
      $repeticion = $_POST['repeticion'];
      for($i=1;$i<=$repeticion;$i++){
        if($fechap > $fechalimite){
          $pareto = 0;
        }
        $sql = "insert into pareto_actividades(id_usuario,id_pareto,id_padre,descripcion,id_tipoactividad,estado,fecha,hora,fecha_fin,hora_fin,fecha_creacion,fecha_modificacion,activo,id_creador,id_frecuencia,aplica_objetivo,id_objetivo) values ('$idusuario','$pareto','0','$descripc','$tipo','0','$fechap','$horai','$fechap','$horaf','$hoy','$hoy','A','$idusuario','$frecuencia','$aplica','$id_objetivo')";
        $insert = new base_datos;
        $insert->connect();
        $insert->query($sql);

        if($frecuencia == 2){
          $fechap = date("Y-m-d",strtotime($fechap."+ 1 days"));
        } else if($frecuencia == 3){
          $fechap = date("Y-m-d",strtotime($fechap."+ 1 week"));
        } else if($frecuencia == 4){
          $fechap = date("Y-m-d",strtotime($fechap."+ 2 week"));
        } else if($frecuencia == 5){
          $fechap = date("Y-m-d",strtotime($fechap."+ 1 month"));
        }

      }
    }
	
	}
	
	echo ("<SCRIPT LANGUAGE='JavaScript'>
	alert('Actividad Agregada Correctamente');
	window.location.href='pareto_activo.php';
	</SCRIPT>");
	
}

$fecha = date("Y-m-d"); 
$rangomin = (30 * 60);//cantidad minutos * 60 segundos;
$timestamp = strtotime($fecha.' 00:00:00')-$rangomin; 
$timestamp_limite = strtotime($fecha.' 23:30:00'); 

?>
<!DOCTYPE html>
<html lang="es">
<?php include('head.php');?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	
<style>
.dropdown {
  position: relative;
}

.dropdown dd,
.dropdown dt {
  margin: 0px;
  padding: 0px;
}

.dropdown ul {
  margin: -1px 0 0 0;
  overflow:auto;
}

.dropdown dd {
  position: relative;
}

.dropdown a,
.dropdown a:visited {
  color: #fff;
  text-decoration: none;
  outline: none;
  font-size: 12px;
}

.dropdown dt a {
  display: block;
  padding: 8px 20px 5px 10px;
  min-height: 25px;
  line-height: 24px;
  border: 0;
  width: 272px;
}

.dropdown dt a span,
.multiSel span {
  cursor: pointer;
  display: inline-block;
  padding: 0 3px 2px 0;
}

.dropdown dd ul {
  border: 0;
  display: none;
  left: 0px;
  padding: 2px 15px 2px 5px;
  position: absolute;
  top: 2px;
  width: 100%;
  list-style: none;
  height: 100px;
  z-index:9999;
  overflow: auto;
}

.dropdown span.value {
  display: none;
}

.dropdown dd ul li a {
  padding: 5px;
  display: block;
}

.dropdown dd ul li a:hover {
  background-color: #ccc;
}
#invit{
	overflow:auto !important;
}
</style>
  
  <!-- date picker -->
  
  <script>
  $(document).ready(function() {
	  
  $(function() {
	  
    $('#fechap').datepicker({
      dateFormat: 'yy-mm-dd',
      showButtonPanel: false,
      changeMonth: true,
      changeYear: true,
      minDate: '-2D',
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
</script>
<script type="text/javascript">
function abrir(){
  $(".dropdown dd ul").slideToggle('slow',function(){$('.dropdown dd ul').css('overflow','auto')});
};

$(".dropdown dd ul li a").on('click', function() {
  //$(".dropdown dd ul").hide();
  document.getElementById('inv').style.display = "block";
  document.getElementById('inv').add.className = "invit";
});

$(document).bind('click', function(e) {
  var $clicked = $(e.target);
  if (!$clicked.parents().hasClass("dropdown")) $(".dropdown dd ul").hide();
});

function mostrar(idinv,id){
	var act = document.getElementById('invitar').value;
	var act1 = document.getElementById('invitar_id').value;
	var e = document.getElementById(id).checked;
	if(e == true){
		act = act + (idinv+", ");
		act1 = act1 + (id+",");
	} else {
		act = act.replace(idinv+', ',"");
		act1 = act1.replace(id+',',"");
	}
	document.getElementById('invitar').value = act;
	document.getElementById('invitar_id').value = act1;
	//alert(act);
}
</script>

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

function objetivos(value){
	if(value == 'S'){
		document.getElementById('aplicar_objetivo').style.display = "block";
	} else {
		document.getElementById('aplicar_objetivo').style.display = "none";
	}
}
</script>

<body>
  <!-- container section start -->
  <section id="container" class="">

	<?php include('header.php');?>

    <?php include('menu.php');?>

    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <!--overview start-->
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-icon_document_alt"></i> Nueva Actividad Pareto</h3>
           </div>
        </div>

        <!-- project team & activity start -->
        <div class="row">
          <div class="col-md-12 portlets">
            <!-- Widget -->
            <div class="panel panel-default">
              <div class="panel-heading">
                <div class="pull-left"></div>
                <div class="clearfix"></div>
              </div>

			  <div class="panel-body">
                <div class="form">
                  <form class="form-validate form-horizontal " id="register_form" method="post" action="">
					<input type="hidden" value="<?php echo $idpareto;?>" name="pareto"/>
					<input type="hidden" value="<?php echo $paretos[0]['fecha_final'];?>" name="fechalimite"/>
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
                      <label for="tipo" class="control-label col-lg-2">Aplica Objetivo <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <select class=" form-control" id="aplica" name="aplica" required onchange="objetivos(this.value)" >
							<option value="S" selected="selected">SI</option>
							<option value="N">NO</option>
						</select>
                      </div>
                    </div>
					<div class="form-group" id="aplicar_objetivo">
                      <label for="tipo" class="control-label col-lg-2">Objetivo</label>
                      <div class="col-lg-10">
                        <select class=" form-control" id="objetivo" name="objetivo" >
							<?php foreach ($objetivos as $tp){?>
							<option value="<?php echo $tp['id'];?>"><?php echo $tp['descripcion'];?></option>
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
						<label class="control-label col-lg-2">Listado Invitados</label>
						<div class="col-lg-10">
							<textarea class="form-control" id="invitar" name="invitar"></textarea>
							<input type="hidden" value="" name="invitar_id" id="invitar_id"/>
						</div>
					</div>
					
					<div class="form-group">
                      <label for="tipo" class="control-label col-lg-2">Invitados</label>
                      <div class="col-lg-10">
						
						<!--INICIO SELECT-->
						<div class="dropdown"> 
							<dt>
							<a href="javascript:void(0)" onclick="abrir()">
							  <input type="button" value="Seleccionar invitados" class="btn btn-success btn-xs"/> 
							  
							</a>
							</dt>
						  
							<dd>
								<div class="mutliSelect">
									<ul style="background-color:#ccc; border: solid 1px #000" id="inv">
										<?php foreach ($invitados as $tp){?>
										<?php if($tp['id'] != $_SESSION['idus']){ ?>
										<li>
											<input type="checkbox" name="invitados[]" value="<?php echo $tp['nombre'];?>" id="<?php echo $tp["id"];?>" onclick="mostrar(this.value,this.id)" /><?php echo $tp['nombre'];?>
										</li>
										<?php } ?>
										<?php } ?>
										
									</ul>
								</div>
							</dd>
						</div>
						<!--FIN SELECT-->
					  
                      </div>
                    </div>
					
					
										
					<div class="form-group" id="aplicar_objetivo">
                      <label for="tipo" class="control-label col-lg-2">Frecuencia </label>
                      <div class="col-lg-10">
                        <select class=" form-control" id="frecuencia" name="frecuencia" required onchange="cantidad(this.value)">
			
							<?php foreach ($frecuencia as $tp2){?>
							<option value="<?php echo $tp2['id_frecuencia'];?>"><?php echo $tp2['descripcion'];?></option>
							<?php } ?>
						</select>
                      </div>
                    </div>
					
                    <div class="form-group" id="cantidad" style="display: none">
                      <label for="repeticion" class="control-label col-lg-2">Cantidad Repeticiones <span class="required">*</span></label>
                      <div class="col-lg-10">
              <input type='number' class="form-control" id='repeticion' name="repeticion" autocomplete="off" />
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <button class="btn btn-primary" type="submit">Guardar</button>
                        <button class="btn btn-default" type="button" onclick="window.history.go(-1); return false;">Cancelar</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>

            </div>
          </div>

        </div>
        <!-- project team & activity end -->

      </section>
    </section>
    <!--main content end-->
  </section>
  <!-- container section start -->

  <!-- javascripts -->
  <script src="js/jquery.js"></script>
  <script src="js/jquery-ui-1.10.4.min.js"></script>
  <script src="js/jquery-1.8.3.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script>
  <!-- bootstrap -->
  <script src="js/bootstrap.min.js"></script>
  <!-- nice scroll -->
  <script src="js/jquery.scrollTo.min.js"></script>
  <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
  <!-- charts scripts -->
  <script src="assets/jquery-knob/js/jquery.knob.js"></script>
  <script src="js/jquery.sparkline.js" type="text/javascript"></script>
  <script src="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
  <script src="js/owl.carousel.js"></script>
  
    <!-- custom select -->
    <script src="js/jquery.customSelect.min.js"></script>
    <script src="assets/chart-master/Chart.js"></script>
	

  <!--custom checkbox & radio-->
  <script type="text/javascript" src="js/ga.js"></script>
  <!--custom switch-->
  <script src="js/bootstrap-switch.js"></script>
  <!--custom tagsinput-->
  <script src="js/jquery.tagsinput.js"></script>
	
    <!--custome script for all page-->
    <script src="js/scripts.js"></script>
    <!-- custom script for this page-->
    <script src="js/sparkline-chart.js"></script>
    <script src="js/easy-pie-chart.js"></script>
    <script src="js/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="js/jquery-jvectormap-world-mill-en.js"></script>
    <script src="js/xcharts.min.js"></script>
    <script src="js/jquery.autosize.min.js"></script>
    <script src="js/jquery.placeholder.min.js"></script>
    <script src="js/gdp-data.js"></script>
    <script src="js/morris.min.js"></script>
    <script src="js/sparklines.js"></script>
    <script src="js/charts.js"></script>
    <script src="js/jquery.slimscroll.min.js"></script>
    <script>
      $(function() {
        $('select.styled').customSelect();
      });
      function cantidad(cant){
        if(cant == 1){
          document.getElementById('cantidad').style.display = 'none';
          document.getElementById('repeticion').required =  false;
        } else {
          document.getElementById('cantidad').style.display = 'flex';
          document.getElementById('repeticion').required = true;
        }
      }
    </script>
</body>

</html>
