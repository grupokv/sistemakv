<?php 
include ("../Controlador/Sesion/autenticar.php");
include ("../Modelo/Vehiculo.php");
include ("../Modelo/TipoVehiculo.php");
include ("../Modelo/Usuario.php");
include ("../Modelo/Conductor.php");
$id = $_GET['id'];
$vehiculo = new Vehiculo();
$usuario = new Usuario();
$tipov = new TipoVehiculo();
$conductor = new Conductor();
$datos = $vehiculo->listarRecorridoId($id);
$datos_ruta = $vehiculo->listarRutaPorId($datos[0]['id_ruta']);
$datos_vehiculo = $vehiculo->listarPorId($datos_ruta[0]['id_vehiculo']);
$datos_tipo = $tipov->listarPorId($datos_vehiculo[0]['id_tipo_vehiculo']);
$datos_conductor = $conductor->listarPorId($datos_ruta[0]['id_conductor']);
$datos_usuario = $usuario->listarUsuarioPorId($datos_ruta[0]['id_monitor']);
?>
<!DOCTYPE html>
<html>
<head>    
<meta charset="utf-8">	
<title>SistemaKV | Recogida</title>    
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">        
<?php include("Template/styles.php"); ?>    
<link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">    
<style type="text/css" media="screen">          
</style>
</head>
<body>    
<?php include("Template/menu.php"); ?>    
<section class="form-usuarios">        
<div class="formulario mb-5">
<table class="table table-condensed table-striped" style="font-size:0.7rem">  
<tr>                   
<th colspan="4">DATOS RUTA</th>
</tr>
<tr>
	<td style="font-weight:bold; color:#989898" width="15%">NUMERO RUTA</td>
	<td><?php echo $datos_ruta[0]['num_ruta'];?></td>
	<td style="font-weight:bold; color:#989898">LIDER DE RUTA</td>
	<td><?php echo $datos_usuario[0]['nombre'];?></td>
</tr>
<tr>
	<td style="font-weight:bold; color:#989898">CONDUCTOR</td>
	<td><?php echo $datos_conductor[0]['nombre_conductor'];?></td>
	<td style="font-weight:bold; color:#989898">TIPO VEHICULO</td>
	<td><?php echo $datos_tipo[0]['nombre_tipo_vehiculo'];?></td>
	
</tr>
<tr>
	<td style="font-weight:bold; color:#989898;">PLACA</td>
	<td><?php echo $datos_vehiculo[0]['placa'];?></td>
	<td style="font-weight:bold; color:#989898">FECHA</td>
	<td><?php echo date('Y-m-d');?></td>
</tr>
<tr>
	<td style="font-weight:bold; color:#989898;">SECTORES</td>
	<td colspan="3"><?php echo $datos_ruta[0]['recorrido'];?></td>
</tr>
</table>                          
<table class="table" style="font-size:0.7rem">                      
<thead>                        
<tr class="text-center">                          
<th colspan="4"  style="border: 0"> LISTADO PASAJEROS</th>                        
</tr>
<tr class="text-center">                          
<th style="border: 0">#</th> 
<th style="border: 0">NOMBRE</th> 
<th style="border: 0">SEDE</th>
<th style="border: 0">ASIST.<br/><label class="switch"><input type="checkbox" id="todos" onclick="todos(this.id)"/><span class="slider"></span>                                
</label>  </th>                        
</tr>                      
</thead>                      
<tbody>
<?php $i=1;?>
<?php $a=0;?>			
<?php foreach($datos as $dt){ ?>                        
<tr align="center">
<td>
<?php echo $datos_ruta[0]['sigla']."-".$i;?>
</td>                         
<td>
<?php 
$det_pas = $vehiculo->buscarPasajeroFijoPorId($dt['id_pasajero']);
$primer_nombre = explode(' ',$det_pas[0]['nombres']);
$primer_apellido = explode(' ',$det_pas[0]['apellidos']); 
echo $primer_nombre[0].' '.$primer_apellido[0];?>
</td>

<td>
<?php echo $det_pas[0]['sucursal'];?>
</td>                            
<td>                                
<label class="switch">          
                       
<input type="checkbox" name="pasajero" id="pasajero_<?php echo $dt['id_detalle'];?>" value="<?php echo $dt['id_detalle'];?>" <?php if($dt['hora_recogida'] != '00:00:00'){ $a++; ?> checked="checked" <?php } ?> onclick="recoger(this.value,this.id)">                                    
<span class="slider"></span>                                
</label>                                
</td>                        
</tr>			
<?php $i++; } ?>

<tr align="center">
	<td ><b>TOTAL</b></td>
	<td ><?php echo ($i-1);?></td>
	<td ><b>ASISTENCIA HOY</b></td>
	<td id="asistencia"><?php echo $a;?></td>
</tr>

<tr align="center">
	<td colspan="4"><button type="button" class="btn btn-lg btn-danger" data-toggle="modal" data-target="#modal">NOVEDADES</button></td>
</tr>                  
</tbody>                    
</table>      
</div>    
</section>    
<?php include("Template/scripts.php"); ?>
<script>
var as = <?php echo $a;?>;
function recoger(pas,id) {  
var checkBox = document.getElementById(id);  
if (checkBox.checked == true){
as = (as+1);
document.getElementById('asistencia').innerHTML = as;
var parametros = {         
"id_detalle" : pas,              
"estado" : 'A',    };    
$.ajax({    data:  parametros,    
url:   '../Controlador/estadoPasajero.php',    
type:  'post',    
beforeSend: function () {},    
success:  function (response) { }    });  
} else {
as = (as-1);
document.getElementById('asistencia').innerHTML = as;  
var parametros = {              
"id_detalle" : pas,              
"estado" : 'D',    };    
$.ajax({    
data:  parametros,    
url:   '../Controlador/estadoPasajero.php',    
type:  'post',    
beforeSend: function () {},    
success:  function (response) {}    
});  
}}

function todos(id) {  
var checkBox1 = document.getElementById(id);  
if (checkBox1.checked == true){
	var checkboxes = document.getElementsByName('pasajero');
	for (var checkbox of checkboxes) {
		checkbox.setAttribute("checked","checked");
	}
	document.getElementById('asistencia').innerHTML = <?php echo ($i-1);?>;
	as = <?php echo ($i-1);?>;
} else {
	var checkboxes = document.getElementsByName('pasajero');
	for (var checkbox of checkboxes) {
		checkbox.removeAttribute("checked");
	}
	document.getElementById('asistencia').innerHTML = 0;
	as = 0;
}
}
</script>

<div class="modal" tabindex="-1" role="dialog" id="modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="" method="post">
      <div class="modal-header">
        <h5 class="modal-title">NOVEDAD RECORRIDO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>
		<textarea name="novedad" required="required" class="form-control" placeholder="Descripcion de la novedad"></textarea>
	</p>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>