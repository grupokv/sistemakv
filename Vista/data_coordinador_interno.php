<?php 
session_start(); 
require_once("../Modelo/Conexion/conexionBD.php");
require_once("../Modelo/General.php");
require_once("../Modelo/Usuario.php");

$conexion = new Conexion();
$objUsuario = new Usuario();

$id_referenciador = base64_decode($_GET['id_referenciador']);

if (($_POST)) {
	$usuario = $_POST['usuario'];
	$clave = $_POST['clave'];
	$correo = $_POST['correo'];
	$claveEncriptada = base64_encode($clave);
	$login = $conexion->iniciarSesion($usuario, $claveEncriptada);

    if (empty($usuario) || empty($clave)) {
       echo ("<script LANGUAGE='JavaScript'>window.history.back();</script>");
	}else{
        if ($login) {
            
            $_SESSION['id_usuario'] = $login[0]['id_usuario'];
            $_SESSION['sesion'] = $usuario;
            $_SESSION['nombre'] = $login[0]['nombre'];
            $_SESSION['id_perfil'] = $login[0]['id_perfil'];

            $actualizarUltimoIngreso = $objUsuario->actualizarUltimoIngreso($_SESSION['id_usuario'], $login[0]['cant_ingresos'] + 1 , date('Y-m-d H:i:s'));

            echo ("<script LANGUAGE='JavaScript'>window.location.href='". (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}" ."';</script>");
        }else{
        	echo ("<script LANGUAGE='JavaScript'>alert('Usuario o Contraseña incorrectos! por favor intentalo de nuevo.');window.history.back();</script>");
        }
    }
}



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
			<form action="../Controlador/guardar_encuesta_dataOperativa.php" method="post" onsubmit="return validarForm()">
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
									

									<div class="form-group" style="display: none;" id="vinculoVeh">
										<label for="vinculo">Vínculo del Vehículo</label>
										<select class="custom-select form-control form-control-sm" id="vinculo" name="vinculo" onchange="validarTipoVehiculo(this.value);" style="font-size: .7rem;">
											<option value="">SELECCIONAR</option>
											<option value="GERENCIA">VEHÍCULO GERENCIA</option>
											<option value="AFILIADO">VEHÍCULO AFILIADO</option>
										</select>
									</div>



									<div class="form-group" style="display: none;" id="empresaAfi">
										<label for="empresaAfiliada">Empresa Afiliadora</label>
										<input type="text" class="form-control form-control-sm" id="empresaAfiliada" name="empresaAfiliada" placeholder="EMPRESA">
									</div>

									<div class="form-group" style="display: none;" id="envioPap">
										<table width="100%" class="table table-condensed" style="font-weight:bold; color:#989898;">
											<tr>
												<td width="60%">
													<label class="form-check-label" for="envioPapeles">Envío de Papeles</label>
												</td>
												<td width="20%">
													<input type="radio" class="form-check-input" id="envioPapeles1" value="S" name="envioPapeles[]" >
													<label class="form-check-label" for="envioPapeles1">SI</label>
												</td>
												<td width="20%">
													<input type="radio" class="form-check-input" id="envioPapeles2" value="N" name="envioPapeles[]">
													<label class="form-check-label" for="envioPapeles2">NO</label>
												</td>
											</tr>
										</table>
									</div>

									<div class="form-group" style="display: none;" id="statusProp">
										<label for="vinculo">Status Propuesta</label>
										<select class="custom-select form-control form-control-sm" id="status" name="status" onchange="validarTipoVehiculo(this.value);" style="font-size: .7rem;">
											<option value="">SELECCIONAR</option>
											<option value="INDECISO">INDECISO</option>
											<option value="SEGURO">SEGURO</option>
											<option value="FIRMO CONTRATO">FIRMO CONTRATO</option>
										</select>
									</div>

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

	<!-- MENSAJE MODAL NOTIFICACION HORARIO -->
    <div class="modal fade" id="modal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-center">
              	<div class="col-12 " style="height: auto;">
              		<section class="col-12 d-flex justify-content-center">
                 		<a id="sistemaKV" target="_blank" href="https://www.intranetgroupkv.com/"><img src="https://sistemakv.com/Resources/img/kingvision_transparente.png" alt="Logo_King_Vision" width="101" height="65" style="display: block; margin-top: 10px;"></a>
                 	</section>
                	<h4 class="modal-title mt-3" style="color: #a1a1a1; "><strong>INGRESAR AL SISTEMAKV</strong></h4>
              	</div>
              <div class="col-12 mt-3">
                  <form action="" method="POST" >          
                    <div class="login">                          
                        <hr>              
                            <div class="row" style="margin-bottom:15px; margin-top:15px; margin-left: 30px;">                  
                                <div class="col-12">                      
                                    <label for="usuario" style="float:left; color: #404040; font-size:.9rem; font-weight:bolder; text-transform: uppercase;">Usuario</label>                                      
                                </div> 
                                <div class="col-12">
                                    <input type="text" class="form-control mb-3" name="usuario" id="usuario" required="required" style="width: 80%;">  
                                </div>
                            </div>              
                            <div class="row" style="margin-bottom:15px; margin-left: 30px;">                  
                                <section class="col-12">                      
                                    <label for="`password" style="float:left; color:#404040; font-size:.9rem; font-weight:bolder; text-transform:uppercase;">Contraseña</label>                      
                                </section>
                                <section class="col-12">
                                    <input type="password" class="form-control mb-1" name="clave" id="clave" required="required" style="width: 80%;">                  
                                </section>
                            </div>   
                        
                            <section class="row mt-2" style="display: flex; justify-content: center; margin-top: 20px; margin-bottom: 20px;"> 
                                <div class="col-6" style="width: 100%; display: flex; justify-content: center; ">   
                                    <button class="btn btn-block" style="border-radius: 2px; background: #335689; width: 60%; color: #fff;">Ingresar</button>  
                                </div>
                            </section> 
                        
                        <hr>              
                        
                        <div class="mensaje text-center" style="color: #B40404;">                
                            <p><?php echo $mensaje; ?></p>              
                        </div>                          
                    </div>        
                </form>     
             
              </div>
            </div>
            <!-- <div class="col-12 modal-footer d-flex justify-content-center" style="border: 0px;">
              <button type="button" class="col-3 btn btn-danger btn-block" data-dismiss="modal">Cerrar</button>
            </div> -->
        </div>
      </div>
    </div>

<?php include("Template/scripts.php"); ?>

<script>

$(function () {
    $('#datetimepicker').datetimepicker({
        format: 'LT'
    });
});

function validarForm(){
	if(($('#disponibilidad_horario_inicial').val() == '') && ($('#disponibilidad_horario_final').val() == '') && ($('#disponibilidadLibre').prop('checked') == false)) {
		
        alertify.error('¡Error, Datos Faltantes! ingresar la disponibilidad del vehiculo.');
        return false;
	}
}

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
		document.getElementById('statusProp').style.display = 'block';

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
		document.getElementById('statusProp').style.display = 'none';

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


	function modalAviso(){
        $("#modal").modal("show");   
    }

    <?php if(($_SESSION['sesion'] == '')or($_SESSION['nombre'] == '')){ ?>
    	$(window).on("load", modalAviso());
    <?php } ?>

</script>

</body>
</html>