<?php 
require_once("../Modelo/General.php");

/*$departamentos = listarDepartamentos();*/

$id_referenciador = base64_decode($_GET['id_referenciador']);



?>
<!DOCTYPE html>
<html>
<head>    
	<meta charset="utf-8">	
	<title>SistemaKV | Data Operativa</title>    
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">        
	<?php include("Template/styles.php"); ?>    

	<link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">   

	<style type="text/css" media="screen">      

		::-webkit-input-placeholder{
			font-size:10px;
		}
		::-moz-placeholder {
			font-size:10px;
		}
		:-ms-input-placeholder { 
			font-size:10px;
		}
		:-moz-placeholder { 
			font-size:10px;
		}


		option {
			color: #6c757d;
		}


		select { 
			color: #6c757d !important;
		}

	</style>

</head>

<body>    
	<section class="form-usuarios">        
		<div class="formulario mb-5">
			<form action="../Controlador/guardar_encuesta_dataOperativa.php" method="post">
				<table class="table table-condensed table-striped" style="font-size:0.7rem; margin-top: 30px;"> 
					<tbody>
						<tr>
							<td style="font-weight:bold; color:#989898;">
									
									<input type="hidden" name="id_referenciador" id="id_referenciador" value="<?php echo $id_referenciador; ?>">
									<div class="form-group">
										<label for="nombresApellidos">Nombres y Apellidos</label>
										<input type="text" class="form-control form-control-sm" id="nombresApellidos" name="nombresApellidos" required="required" placeholder="Nombres y Apellidos">
									</div>
									<div class="form-group">
										<label for="celular">Número de celular</label>
										<input type="number" class="form-control form-control-sm" id="celular" name="celular" required="required" placeholder="Numero de celular">
									</div>
									<div class="form-group">
										<label for="tel_contacto">Teléfono Fijo</label>
										<input type="number" class="form-control form-control-sm" id="tel_fijo" name="tel_fijo" required="required" placeholder="Telefono Fijo">
									</div>
									<div class="form-group">
										<label for="departamento">Departamento o Municipio</label>
										<input type="text" class="form-control form-control-sm" id="departamento" name="departamento" required="required" placeholder="Departamento o Municipio">
									</div>
									<div class="form-group">
										<label for="ciudad">Ciudad</label>
										<input type="text" class="form-control form-control-sm" id="ciudad" name="ciudad" required="required" placeholder="Ciudad">
									</div>
									<div class="form-group">
										<label for="email">Dirección de correo electrónico</label>
										<input type="email" class="form-control form-control-sm" id="email" name="email" required="required" placeholder="Dirección de correo electrónico" value="<?php echo $datos_salud[0]['email'];?>">
									</div>
									<div class="form-group">
										<table width="100%" class="table table-condensed text-center" style="font-weight:bold; color:#989898;">
											<tr>
												<td width="60%">
													<input type="radio" class="form-check-input" id="transporte" value="T" name="tipo_servicio" required="required"  onclick="validarTipoServicio(this.value);">
													<label class="form-check-label" for="transporte">TRANSPORTE</label>
												</td>
												<td width="60%">
													<input type="radio" class="form-check-input" id="logistica" value="L" name="tipo_servicio" required="required" onclick="validarTipoServicio(this.value);">
													<label class="form-check-label" for="logistica">LOGÍSTICA</label>
												</td>
											</tr>
										</table>
									</div>

								<!-- LOGISCA-->
									<div class="form-group" style="display: none;" id="servicioProducto">
										<table width="100%" class="table table-condensed text-center" style="font-weight:bold; color:#989898;">
											<tr>
												<td width="25%">
													<label class="form-check-label" for="propietario">¿Que va a ofrecer?</label>
												</td>
												<td width="25%">
													<input type="radio" class="form-check-input" id="servicio" value="S" name="servicioProductoOfrecer" onclick="validarTipoOfrecer(this.value);">
													<label class="form-check-label" for="servicio">Servicio</label>
												</td>
												<td width="25%">
													<input type="radio" class="form-check-input" id="producto" value="P" name="servicioProductoOfrecer" onclick="validarTipoOfrecer(this.value);">
													<label class="form-check-label" for="producto">Producto</label>
												</td>
												<td width="25%">
													<input type="radio" class="form-check-input" id="ambas" value="A" name="servicioProductoOfrecer" onclick="validarTipoOfrecer(this.value);">
													<label class="form-check-label" for="ambas">Ambas</label>
												</td>
											</tr>
										</table>
									</div>

									<div class="form-group" style="display: none;" id="cualTipo">
										<label for="otro">¿Cúal? (Si son varios porfavor separar con coma)</label>
										<textarea class="form-control form-control-sm" id="cual_tipo" name="cual_tipo" placeholder="¿Cual?" ></textarea>
									</div>


									<div class="form-group" style="display: none;" id="cualServicio">
										<label for="otro">¿Cúal Servicio? (Si son varios porfavor separar por comas)</label>
										<textarea class="form-control form-control-sm" id="cual_servicio" name="cual_servicio" placeholder="¿Cual?" ></textarea>
									</div>

									<div class="form-group" style="display: none;" id="cualProducto">
										<label for="otro">¿Cúal Producto? (Si son varios porfavor separar por comas)</label>
										<textarea class="form-control form-control-sm" id="cual_producto" name="cual_producto" placeholder="¿Cual?" ></textarea>
									</div>


								<!-- TRANSPORTE-->

									<div class="form-group" style="display: none;" id="prop">
										<table width="100%" class="table table-condensed" style="font-weight:bold; color:#989898;">
											<tr>
												<td width="60%">
													<label class="form-check-label" for="propietario">Propietario</label>
												</td>
												<td width="20%">
													<input type="radio" class="form-check-input" id="propietario1" value="S" name="propietario[]" >
													<label class="form-check-label" for="propietario1">SI</label>
												</td>
												<td width="20%">
													<input type="radio" class="form-check-input" id="propietario2" value="N" name="propietario[]">
													<label class="form-check-label" for="propietario2">NO</label>
												</td>
											</tr>
										</table>
									</div>

									<div class="form-group" style="display: none;" id="tipo_veh">
										<label for="tipo_vehiculo">Tipo de Vehiculo</label>
										<select class="custom-select form-control form-control-sm" id="tipo_vehiculo" name="tipo_vehiculo" onchange="validarTipoVehiculo(this.value);" style="font-size: .7rem;">
											<option value="">SELECCIONAR</option>
											<option value="AUTOMOVIL">AUTOMÓVIL</option>
											<option value="DOBLE CABINA">DOBLE CABINA</option>
											<option value="STATION WAGON O 4X2">STATION WAGON O 4X2</option>
											<option value="CAMPERO 4X4">CAMPERO 4X4</option>
											<option value="VANS">VANS</option>
											<option value="MICROBUS">MICROBUS</option>
											<option value="BUSETA">BUSETA</option>
											<option value="BUS">BUS</option>
											<option value="OTRO">OTRO</option>
										</select>
									</div>

									<div class="form-group" style="display: none;" id="cual">
										<label for="otro">Cual</label>
										<input type="text" class="form-control form-control-sm" id="otro" name="otro" placeholder="Cual" >
									</div>

									<div class="form-group" style="display: none;" id="capacidadVeh">
										<label for="capacidad">Capacidad</label>
										<input type="number" class="form-control form-control-sm" id="capacidad" name="capacidad" placeholder="Capacidad">
									</div>

									<div class="form-group" style="display: none;" id="modeloVeh">
										<label for="modelo">Modelo</label>
										<input type="text" class="form-control form-control-sm" id="modelo" name="modelo" placeholder="Modelo" maxlength="4">
									</div>

									<div class="form-group" style="display: none;" id="ubiVeh">
										<table width="100%" class="table table-condensed" style="font-weight:bold; color:#989898;">
											<tr>
												<td width="60%">
													<label class="form-check-label" for="ubicacion">Ubicación del Vehículo</label>
												</td>
												<td width="20%">
													<input type="radio" class="form-check-input" id="ubicacion1" value="SUR" name="ubicacion[]" >
													<label class="form-check-label" for="ubicacion1">SUR</label>
												</td>
												<td width="20%">
													<input type="radio" class="form-check-input" id="ubicacion" value="NORTE" name="ubicacion[]">
													<label class="form-check-label" for="ubicacion2">NORTE</label>
												</td>
											</tr>
										</table>
									</div>


									<div class="form-group" style="display: none;" id="direccionUbi">
										<label for="modelo">Dirección</label>
										<input type="text" class="form-control form-control-sm" id="direccion_ubicacion" name="direccion_ubicacion" placeholder="DIRECCION">
									</div>

									<section class="row form-group" style="display: none;" id="dispoHorario">
										
										<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
											<label for="disponibilidad_horario_inicial">Disponibilidad de Horario (INICIAL)</label>
											<input type="time" class="form-control form-control-sm" id="disponibilidad_horario_inicial" name="disponibilidad_horario_inicial" placeholder="HORARIO (AM - PM)">
										</div>

										<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
											<label for="disponibilidad_horario_final">Disponibilidad de Horario (FINAL)</label>
											<input type="time" class="form-control form-control-sm" id="disponibilidad_horario_final" name="disponibilidad_horario_final" placeholder="HORARIO (AM - PM)">
										</div>

										<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
											<label for="disponibilidadLibre">Disponibilidad Libre</label>
											<input type="radio" class="form-check-input mt-4" id="disponibilidadLibre" value="S" name="disponibilidadLibre[]" >
										</div>

									</section>
									


									<div class="form-group mt-3">
										<label for="observaciones">Observaciones (Referido por)</label>
										<textarea class="form-control form-control-sm" id="observaciones" name="observaciones" placeholder="OBSERVACIONES" ></textarea>
									</div>
							</td>
							
						</tr>

						<tr align="center">
							<td colspan="4"><button type="submit" class="btn btn-sm btn-success">ENVIAR</button></td>
						</tr>   

					</tbody>                    
				</table>
			</form>
		</div>    
	</section>    

<?php include("Template/scripts.php"); ?>

<script>

$(function () {
    $('#datetimepicker').datetimepicker({
        format: 'LT'
    });
});

function validarTipoVehiculo(tipo_vehiculo){
	if (tipo_vehiculo == 'OTRO') {
		document.getElementById('cual').style.display = 'block';
	}else{
		document.getElementById('cual').style.display = 'none';
	}
}

function validarTipoOfrecer(tipo){
	
	if (tipo == 'A') {
		document.getElementById('cualServicio').style.display = 'block';
		document.getElementById('cualProducto').style.display = 'block';
		document.getElementById('cualTipo').style.display = 'none';
	}else{
		document.getElementById('cualTipo').style.display = 'block';
		document.getElementById('cualServicio').style.display = 'none';
		document.getElementById('cualProducto').style.display = 'none';
	}
}



function validarTipoServicio(tipo_servicio){

	if (tipo_servicio == 'T') {

		document.getElementById('prop').style.display = 'block';
		document.getElementById('tipo_veh').style.display = 'block';
		document.getElementById('modeloVeh').style.display = 'block';
		document.getElementById('capacidadVeh').style.display = 'block';
		document.getElementById('ubiVeh').style.display = 'block';
		document.getElementById('direccionUbi').style.display = 'block';
		document.getElementById('dispoHorario').style.display = 'flex';
		document.getElementById('vinculoVeh').style.display = 'block';
		document.getElementById('empresaAfi').style.display = 'block';
		document.getElementById('envioPap').style.display = 'block';

		document.getElementById('servicioProducto').style.display = 'none';
		document.getElementById('cualTipo').style.display = 'none';
		document.getElementById('cualServicio').style.display = 'none';
		document.getElementById('cualProducto').style.display = 'none';
	}else{
		document.getElementById('prop').style.display = 'none';
		document.getElementById('tipo_veh').style.display = 'none';
		document.getElementById('modeloVeh').style.display = 'none';
		document.getElementById('capacidadVeh').style.display = 'none';
		document.getElementById('ubiVeh').style.display = 'none';
		document.getElementById('direccionUbi').style.display = 'none';
		document.getElementById('dispoHorario').style.display = 'none';
		document.getElementById('vinculoVeh').style.display = 'none';
		document.getElementById('empresaAfi').style.display = 'none';
		document.getElementById('envioPap').style.display = 'none';

		document.getElementById('servicioProducto').style.display = 'block';
		document.getElementById('cualTipo').style.display = 'none';
		document.getElementById('cualServicio').style.display = 'none';	
		document.getElementById('cualProducto').style.display = 'none';	
	}
}

function cargar_ciudades(id_departamento){
          //alert(id_departamento); 
  	if(id_departamento != ''){

      	var parametros = {
            "id_departamento" : id_departamento
      	};

      	$.ajax({
          	data:  parametros,
          	url:   '../Controlador/listarCiudades.php',
          	type:  'post',
          	beforeSend: function () {
              	//alert('envio');
              	$("#ciudad").html("<option value='' disabled='disabled' selected='selected'>Cargando datos, por favor espere</option>");
          	},
          	success:  function (response) {
              	//alert(response);
              	$("#ciudad").html(response);
          	}
      	});
  	}
}

</script>

</body>
</html>