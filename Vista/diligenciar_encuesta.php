<?php
session_start();
require_once "../Modelo/Encuesta.php";

$id = $_GET['id'];
$encuesta = new Encuesta();

$preguntas = $encuesta->listarPreguntasPorIdEncuesta($id);
$cant = count($preguntas);
$datos = $encuesta->listarPorId($id);
?>
<!DOCTYPE html>
<html>
<head>
	<title>SistemaKV | Encuesta</title>
	    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<link href="https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c&display=swap" rel="stylesheet"> 

	  <!-- styles -->
	  <?php include("Template/styles.php") ?>
	  <style type="text/css" media="screen">
			
	  	    body{
	  	    	margin: 0 auto;
	  	    	padding: 0px;
	  	    	background-color: #f6f6f6;
				text-align: center;
				width: 100%;
				font-size: 0.7rem;
	  	    }

	  	    #titulo{
	  	    	font-family: 'M PLUS Rounded 1c', sans-serif;
	  	    	font-size: 1rem;
	  	    } 


	  		@media screen and (max-width: 750px) {
	  			.img-error{
	  				width: 100%;
	  				height: auto;
	  			}
	  		}
			.caja{
				position: absolute; 
				overflow: hidden;
				background-image: url('../Resources/img/kingvision_transparente.png');
				filter: grayscale(100%); 
				background-repeat: repeat;
				width: 100%;
				height: 100vh;
				background-size: 200px;
				left: 0;
				right: 0;
				z-index: -1;
				-webkit-filter: grayscale(100%) opacity(0.1);
				-moz-filter: grayscale(100%) opacity(0.1);
				-o-filter: grayscale(100%) opacity(0.1);
				-ms-filter: grayscale(100%) opacity(0.1);
				filter: grayscale(100%) opacity(0.1);
			}
			.cont{
				float:left;
				width:100%;
				height:auto;
				text-align: center;
				display: table-cell;
				vertical-align: middle
			}
			.encuesta{
				background-color:rgba(255,255,255,0.7);
				border-radius:20px;
				width:100%;
				height:auto;
				max-width:900px;
				min-width:320px;
				position: relative;
				padding:1%;
				border: 1px solid #007bff;
			}
			input {
				vertical-align: middle !important;
			}
			.pregunta{
				margin-top:5px;
			}
	  </style>
	  <!--fin  styles -->
</head>
<body >
	<div class="caja"></div>
	<div class="cont d-flex justify-content-center pt-4">
	<div class="encuesta">
	<p id="titulo" class="text-center" style="position: relative;"><strong><?php echo $datos[0]['nombre_encuesta'];?></strong></p>
	<p class="text-center" style="position: relative; font-size: 0.8rem; font-family: 'M PLUS Rounded 1c'"><strong><?php echo $datos[0]['descripcion'];?></strong></p>
	<form action="../Controlador/guardarRespuestaEncuesta.php" enctype="multipart/form-data" method="post">
	<input type="hidden" name="ide" value="<?php echo $id;?>"/>
	<table align="center" width="100%">
	<?php if($cant > 0){ ?>
		<?php foreach($preguntas as $preg){ ?>
			<tr><td colspan="4" height="5px"></td></tr>
			<tr><td colspan="4" align="center" ><b><i><?php echo $preg['detalle'];?></i></b></td></tr>
		
		<?php
		$respuestas = $encuesta->listarRespuestasPorIdPregunta($preg['id_pregunta']);
		$cant1 = count($respuestas);
		?>
		
		<?php if($preg['id_tipo_pregunta'] == '1'){ ?>
			<?php if($cant1 > 0){ ?>
				<?php foreach($respuestas as $resp){ ?>
				<tr>
					<td width="20%"></td>
					<td width="55%"><?php echo $resp['detalle'];?></td>
					<td width="5%"><input type="checkbox" id="checkbox_<?php echo $preg['id_pregunta'];?>" name="checkbox_<?php echo $preg['id_pregunta'];?>[]" required="required" value="<?php echo $resp['id_respuesta'];?>" onclick="validar_checkbox(this.id)" /></td>
					<td width="20%"></td>
				</tr>
				<?php } ?>
			<?php } else { ?>
				<tr><td colspan="4" align="center">NO EXISTEN RESPUESTAS</td></tr>
			<?php } ?>
		<?php } ?>
		
		<?php if($preg['id_tipo_pregunta'] == '2'){ ?>
			<?php if($cant1 > 0){ ?>
				<?php foreach($respuestas as $resp){ ?>
				<tr>
					<td width="20%"></td>
					<td width="55%"><?php echo $resp['detalle'];?></td>
					<td width="5%"><input type="radio" id="radio_<?php echo $preg['id_pregunta'];?>" name="radio_<?php echo $preg['id_pregunta'];?>" required="required" value="<?php echo $resp['id_respuesta'];?>" /></td>
					<td width="20%"></td>
				</tr>
				<?php } ?>
			<?php } else { ?>
				<tr><td colspan="4" align="center">NO EXISTEN RESPUESTAS</td></tr>
			<?php } ?>
		<?php } ?>
		
		<?php if($preg['id_tipo_pregunta'] == '3'){ ?>
				<tr>
					<td width="20%"></td>
					<td width="60%" colspan="2"><textarea style="width:100%;height:50px; border-radius:10px" required="required" name="detalle_<?php echo $preg['id_pregunta'];?>" id="detalle_<?php echo $preg['id_pregunta'].'_'.$resp['id_respuesta'];?>"></textarea></td>
					<td width="20%"></td>
				</tr>
		<?php } ?>
		
		<?php if($preg['id_tipo_pregunta'] == '4'){ ?>
			<?php if($cant1 > 0){ ?>
				<?php foreach($respuestas as $resp){ ?>
				<tr>
					<td width="20%"></td>
					<td width="55%"><?php echo $resp['detalle'];?></td>
					<td width="5%"><input type="checkbox" id="checkbox_<?php echo $preg['id_pregunta'];?>" name="checkbox_<?php echo $preg['id_pregunta'];?>[]" required="required" value="<?php echo $resp['id_respuesta'];?>" onclick="validar_checkbox(this.id); mostrar_campo(this,<?php echo $preg['id_pregunta'];?>,<?php echo $resp['id_respuesta'];?>)" /></td>
					<td width="20%"></td>
				</tr>
				<?php if($resp['ampliacion'] == 'S'){ ?>
				<tr>
					<td width="20%"></td>
					<td width="60%" colspan="2"><textarea style="width:100%;height:50px; border-radius:10px; display:none" name="detalle_<?php echo $preg['id_pregunta'].'_'.$resp['id_respuesta'];?>" id="detalle_<?php echo $preg['id_pregunta'].'_'.$resp['id_respuesta'];?>" ></textarea></td>
					<td width="20%"></td>
				</tr>
				<?php } ?>
				<?php } ?>
			<?php } else { ?>
				<tr><td colspan="4" align="center">NO EXISTEN RESPUESTAS</td></tr>
			<?php } ?> 
		<?php } ?>
		
		<?php if($preg['id_tipo_pregunta'] == '5'){ ?>
			<?php if($cant1 > 0){ ?>
				<?php foreach($respuestas as $resp){ ?>
				<tr>
					<td width="20%"></td>
					<td width="55%"><?php echo $resp['detalle'];?></td>
					<td width="5%"><input type="radio" id="radio_<?php echo $preg['id_pregunta'];?>" name="radio_<?php echo $preg['id_pregunta'];?>" required="required" value="<?php echo $resp['id_respuesta'];?>" onclick="mostrar_campo(this,<?php echo $preg['id_pregunta'];?>,<?php echo $resp['id_respuesta'];?>)"/></td>
					<td width="20%"></td>
				</tr>
				<?php if($resp['ampliacion'] == 'S'){ ?>
				<tr>
					<td width="20%"></td>
					<td width="60%" colspan="2"><textarea style="width:100%;height:50px; border-radius:10px; display:none" name="detalle_<?php echo $preg['id_pregunta'].'_'.$resp['id_respuesta'];?>" id="detalle_<?php echo $preg['id_pregunta'].'_'.$resp['id_respuesta'];?>"></textarea></td>
					<td width="20%"></td>
				</tr>
				<?php } ?>
				<?php } ?>
			<?php } else { ?>
				<tr><td colspan="4" align="center">NO EXISTEN RESPUESTAS</td></tr>
			<?php } ?>
		<?php } ?>
		
		<?php if($preg['id_tipo_pregunta'] == '6'){ ?>
				<tr>
					<td width="20%"></td>
					<td width="60%" colspan="2"><input type="file" style="width:100%" required="required" name="file_<?php echo $preg['id_pregunta'];?>" /></td>
					<td width="20%"></td>
				</tr>
		<?php } ?>
		
		<?php } ?>
	<?php } else { ?>
	<tr><td align="center">NO HAY PREGUNTAS EN ESTA ENCUESTA</td></tr>
	<?php } ?>
	</table>
	<section class=" d-flex justify-content-center mt-5">
		<div class="col-5">
			<button type="submit" class="btn btn-outline-primary btn-block" style="border-radius: 10px">ENVIAR <span class="fa fa-sign-out"></span></button>
		</div>
	</section>
	</form>
	
	</div>
	</div>
    <?php include("Template/scripts.php"); ?>
	 <script>
	 function validar_checkbox(id){
		var checkboxes = document.getElementsByName(id+'[]');
		var cont = 0;
		for (var x=0; x < checkboxes.length; x++) {
		 if (checkboxes[x].checked) {
		  cont = cont + 1;
		 }
		}
		if(cont > 0){
			for (var x=0; x < checkboxes.length; x++) {
				checkboxes[x].required = false;
			}
		} else {
			for (var x=0; x < checkboxes.length; x++) {
				checkboxes[x].required = true;
			}
		}
	 }
	 function mostrar_campo(campo,preg,resp){
		 var checkboxes1 = document.getElementsByName(campo.id+'[]');
		 for (var x=0; x < checkboxes1.length; x++) {
			 var texto = 'detalle_'+preg+'_'+checkboxes1[x].value;
			 //alert(texto);
			 if(document.getElementById(texto)){
				var split = checkboxes1[x].id.split('_');
				if(split[0] == 'radio'){
					document.getElementById(texto).style.display = 'none';
					document.getElementById(texto).required = false;
				}
			 }
		 }
		 if(campo.checked){
			 if(document.getElementById('detalle_'+preg+'_'+resp)){
			 document.getElementById('detalle_'+preg+'_'+resp).style.display = 'block';
			 document.getElementById('detalle_'+preg+'_'+resp).required = true;
			 }
			 //alert('seleccionado');
		 } else {
			 //alert('no seleccionado');
			 if(document.getElementById('detalle_'+preg+'_'+resp)){
			 document.getElementById('detalle_'+preg+'_'+resp).style.display = 'none';
			 document.getElementById('detalle_'+preg+'_'+resp).required = false;
			 }
		 }
	 }
	</script>
</body>
</html>