<?php
include('../Controlador/Sesion/autenticar.php');
include('../Modelo/Contrato.php');
include('../Modelo/Cliente.php');
require_once("../Modelo/Salud.php");
$contrato = new Contrato;
$cliente = new Cliente;
$salud = new Salud;
$hoy = date('Y-m-d H:i:s');
$listado = $contrato->listarContratosHabiles($hoy);

$fecha = date('Y-m-d');
$usuario = $_SESSION['id_usuario'];
$busqueda = $salud->buscarPorUsuarioVulnerabilidad($usuario,$fecha);
$cant = count($busqueda);

if($cant > 0){

    /*echo "<script>
    alert('Usted ya ingreso la informacion correspondiente');
    window.location.href = '../Vista/inicio.php';
    </script>";
    exit;*/
	$datos_salud = $salud->listarUltimaPorUsuarioVulnerabilidad($usuario);
	if(count($datos_salud) < 1){
		$datos_salud = array();
	}

} else {
	
	$datos_salud = $salud->listarUltimaPorUsuarioVulnerabilidad($usuario);
	if(count($datos_salud) < 1){
		$datos_salud = array();
	}
}
?>
<!DOCTYPE html>
<html>
<head>    
<meta charset="utf-8">	
<title>SistemaKV | Encuesta Vulnerabilidad</title>    
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">        
<?php include("Template/styles.php"); ?>    
<link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">    
<style type="text/css" media="screen">          
</style>
<style>
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
</style>
</head>
<body>    
<section class="form-usuarios">        
<div class="formulario mb-5">
<form action="../Controlador/guardar_encuesta_vulnerabilidad.php" method="post">
<table class="table table-condensed table-striped" style="font-size:0.7rem"> 
<tr>
	<td style="font-weight:bold; color:#989898;">
		<form>
		<div class="form-group">
			<label for="email">Dirección de correo electrónico</label>
			<input type="email" class="form-control form-control-sm" id="email" name="email" required="required" placeholder="Dirección de correo electrónico" value="<?php echo $datos_salud[0]['email'];?>">
		</div>
		<div class="form-group">
			<label for="celular">Número de celular</label>
			<input type="text" class="form-control form-control-sm" id="celular" name="celular" required="required" placeholder="Numero de celular" value="<?php echo $datos_salud[0]['celular'];?>">
		</div>
		<div class="form-group">
			<label for="direccion">Dirección de vivienda</label>
			<input type="text" class="form-control form-control-sm" id="direccion" name="direccion" required="required" placeholder="Direccion de vivienda" value="<?php echo $datos_salud[0]['direccion'];?>">
		</div>
		<div class="form-group">
			<label for="empresa">Empresa en la cual labora</label>
			<input type="text" class="form-control form-control-sm" id="empresa" name="empresa" required="required" placeholder="Empresa en la cual labora" value="<?php echo $datos_salud[0]['empresa'];?>">
		</div>
		<div class="form-group">
			<label for="fechanac">Fecha de nacimiento (aaaa/mm/dd)</label>
			<input type="text" class="form-control form-control-sm" id="fechanac" name="fechanac" required="required" placeholder="Fecha de nacimiento (aaaa/mm/dd)" value="<?php echo $datos_salud[0]['fechanac'];?>" onblur="validarFecha(this.value)" >
		</div>
		<div class="form-group">
			<label for="eps">EPS</label>
			<input type="text" class="form-control form-control-sm" id="eps" name="eps" required="required" placeholder="EPS" value="<?php echo $datos_salud[0]['eps'];?>">
		</div>
		<div class="form-group">
			<label for="arl">ARL</label>
			<input type="text" class="form-control form-control-sm" id="arl" name="arl" required="required" placeholder="ARL" value="<?php echo $datos_salud[0]['arl'];?>">
		</div>
		<div class="form-group">
			<label for="cargo">Cargo que ocupa en la empresa</label>
			<input type="text" class="form-control form-control-sm" id="cargo" name="cargo" required="required" placeholder="Cargo que ocupa en la empresa" value="<?php echo $datos_salud[0]['cargo'];?>">
		</div>
		<div class="form-group">
			<label for="contrato">En cual contrato labora</label>
			<select class="form-control form-control-sm selectpicker" data-live-search="true" id="contrato" name="contrato" required="required" placeholder="En cual contrato labora">
				<option value="">Seleccione opción</option> 
				<option value="0" <?php if($datos_salud[0]['contrato'] == 0){ ?> selected="selected" <?php } ?> >ADMINISTRATIVO</option>
				<?php foreach($listado as $ls){ ?>
				<option value="<?php echo $ls['id_contrato'];?>" <?php if($datos_salud[0]['contrato'] == $ls['id_contrato']){ ?> selected="selected" <?php } ?> ><?php $det_cliente = $cliente->cliente_ID($ls['id_cliente']); echo $ls['id_contrato'].' - '.$det_cliente[0]['razon_social'];?></option>
				<?php } ?>
			</select>
		</div>
		<div class="form-group">
			<label for="transporte">Medio de transporte utilizado para llegar al trabajo</label>
			<input type="text" class="form-control form-control-sm" id="transporte" name="transporte" required="required" placeholder="Medio de transporte utilizado para llegar al trabajo" value="<?php echo $datos_salud[0]['transporte'];?>">
		</div>
		<div class="form-group">
			<label for="nombre_contacto">Nombre persona de contacto en caso de emergencia</label>
			<input type="text" class="form-control form-control-sm" id="nombre_contacto" name="nombre_contacto" required="required" placeholder="Nombre persona de contacto" value="<?php echo $datos_salud[0]['nombre_contacto'];?>">
		</div>
		<div class="form-group">
			<label for="tel_contacto">Teléfono persona de contacto en caso de emergencia</label>
			<input type="text" class="form-control form-control-sm" id="tel_contacto" name="tel_contacto" required="required" placeholder="Telefono persona de contacto" value="<?php echo $datos_salud[0]['tel_contacto'];?>">
		</div>
		<div class="form-group options1">
			<label for="enfermedad">Le han diagnosticado alguna de estas enfermedades</label>
			<div class="form-check">
				<input type="checkbox" class="form-check-input" id="hipertension" name="enfermedad[]" value="hipertension" required="required" <?php if($datos_salud[0]['hipertension'] == 'S'){ ?> checked="checked" <?php } ?> >
				<label class="form-check-label" for="hipertension">Hipertensión</label>
			</div>
			<div class="form-check">
				<input type="checkbox" class="form-check-input" id="epoc" name="enfermedad[]" value="epoc" required="required" <?php if($datos_salud[0]['epoc'] == 'S'){ ?> checked="checked" <?php } ?> >
				<label class="form-check-label" for="epoc">Epoc</label>
			</div>
			<div class="form-check">
				<input type="checkbox" class="form-check-input" id="cancer" name="enfermedad[]" value="cancer" required="required" <?php if($datos_salud[0]['cancer'] == 'S'){ ?> checked="checked" <?php } ?> >
				<label class="form-check-label" for="cancer">Cancer</label>
			</div>
			<div class="form-check">
				<input type="checkbox" class="form-check-input" id="diabetes" name="enfermedad[]" value="diabetes" required="required" <?php if($datos_salud[0]['diabetes'] == 'S'){ ?> checked="checked" <?php } ?> >
				<label class="form-check-label" for="diabetes">Diabetes</label>
			</div>
			<div class="form-check">
				<input type="checkbox" class="form-check-input" id="vih" name="enfermedad[]" value="vih" required="required" <?php if($datos_salud[0]['vih'] == 'S'){ ?> checked="checked" <?php } ?> >
				<label class="form-check-label" for="vih">VIH</label>
			</div>
			<div class="form-check">
				<input type="checkbox" class="form-check-input" id="cardiaca" name="enfermedad[]" value="cardiaca" required="required" <?php if($datos_salud[0]['cardiaca'] == 'S'){ ?> checked="checked" <?php } ?> >
				<label class="form-check-label" for="cardiaca">Cardiaca</label>
			</div>
			<div class="form-check">
				<input type="checkbox" class="form-check-input" id="renal" name="enfermedad[]" value="renal" required="required" <?php if($datos_salud[0]['renal'] == 'S'){ ?> checked="checked" <?php } ?> >
				<label class="form-check-label" for="renal">Renal</label>
			</div>
			<div class="form-check">
				<input type="checkbox" class="form-check-input" id="asma" name="enfermedad[]" value="asma" required="required" <?php if($datos_salud[0]['asma'] == 'S'){ ?> checked="checked" <?php } ?> >
				<label class="form-check-label" for="asma">Asma</label>
			</div>
			<div class="form-check" >
				<input type="checkbox" class="form-check-input" id="otra" name="enfermedad[]" value="otra"  >
				<label class="form-check-label" for="otra" <?php if($datos_salud[0]['otra_enfermedad'] == 'S'){ ?> checked="checked" <?php } ?> >Otra enfermedad</label>
			</div>
			<div class="form-check">
				<input type="text" class="form-control form-control-sm" id="otra_enfermedad" name="otra_enfermedad" placeholder="Otra enfermedad" value="<?php echo $datos_salud[0]['cual'];?>">
			</div>
			<div class="form-check">
				<input type="checkbox" class="form-check-input" id="ninguna" name="enfermedad[]" value="ninguna" required="required" <?php if($datos_salud[0]['ninguna'] == 'S'){ ?> checked="checked" <?php } ?> >
				<label class="form-check-label" for="ninguna">Ninguna de las anteriores</label>
			</div>
		</div>
		<div class="form-group">
			<table width="100%" class="table table-condensed" style="font-weight:bold; color:#989898;">
				<tr>
					<td width="60%">
						<label class="form-check-label" for="embarazo">Se encuentra en estado de embarazo</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="embarazo1" value="S" name="embarazo[]" required="required" <?php if($datos_salud[0]['embarazo'] == 'S'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="embarazo1" SI</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="embarazo2" value="N" name="embarazo[]" required="required" <?php if($datos_salud[0]['embarazo'] == 'N'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="embarazo2">NO</label>
					</td>
				</tr>
			</table>
		</div>
		<div class="form-group">
			<table width="100%" class="table table-condensed" style="font-weight:bold; color:#989898;">
				<tr>
					<td width="60%">
						<label class="form-check-label" for="obesidad">Sufre de obesidad</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="obesidad1" value="S" name="obesidad[]" required="required" <?php if($datos_salud[0]['obesidad'] == 'S'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="obesidad1">SI</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="obesidad2" value="N" name="obesidad[]" required="required" <?php if($datos_salud[0]['obesidad'] == 'N'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="obesidad2">NO</label>
					</td>
				</tr>
			</table>
		</div>
		
		<div class="form-group">
			<table width="100%" class="table table-condensed" style="font-weight:bold; color:#989898;">
				<tr>
					<td width="60%">
						<label class="form-check-label" for="medicamentos">Actualmente toma medicamentos</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="medicamento1" value="S" name="medicamentos[]" required="required"  <?php if($datos_salud[0]['medicamentos'] == 'S'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="medicamento1">SI</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="medicamento2" value="N" name="medicamentos[]" required="required"  <?php if($datos_salud[0]['medicamentos'] == 'N'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="medicamento2">NO</label>
					</td>
				</tr>
			</table>
		</div>
		<div class="form-group">
			<table width="100%" class="table table-condensed" style="font-weight:bold; color:#989898;">
				<tr>
					<td width="60%">
						<label class="form-check-label" for="tercera_edad">Tiene mas de 60 años</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="tercera_edad1" value="S" name="edad[]" required="required" <?php if($datos_salud[0]['edad'] == 'S'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="tercera_edad1">SI</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="tercera_edad2" value="N" name="edad[]" required="required" <?php if($datos_salud[0]['edad'] == 'N'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="tercera_edad2">NO</label>
					</td>
				</tr>
			</table>
		</div>
		<div class="form-group">
			<label class="form-check-label" for="exampleCheck1">Ha tenido alguno de los siguientes sintomas en las ultimas 24 horas</label>
			<table width="100%" class="table table-condensed" style="font-weight:bold; color:#989898;">
				<tr>
					<td width="60%">
						<label class="form-check-label" for="dolor_garganta">Dolor de garganta</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="dolor_garganta1" value="S" name="dolor_garganta[]" required="required" <?php if($datos_salud[0]['dolor_garganta'] == 'S'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="dolor_garganta1">SI</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="dolor_garganta2" value="N" name="dolor_garganta[]" required="required" <?php if($datos_salud[0]['dolor_garganta'] == 'N'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="dolor_garganta2">NO</label>
					</td>
				</tr>
				<tr>
					<td width="60%">
						<label class="form-check-label" for="malestar_general">Malestar general y dolor muscular que le limite las actividades de la vida diaria</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="malestar_general1" value="S" name="malestar_general[]" required="required" <?php if($datos_salud[0]['malestar_general'] == 'S'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="malestar_general1">SI</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="malestar_general2" value="N" name="malestar_general[]" required="required" <?php if($datos_salud[0]['malestar_general'] == 'N'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="malestar_general2">NO</label>
					</td>
				</tr>
				<tr>
					<td width="60%">
						<label class="form-check-label" for="fiebre">Fiebre igual o mayor a 38 grados medida con termometro</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="fiebre1" value="S" name="fiebre[]" required="required" <?php if($datos_salud[0]['fiebre'] == 'S'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="fiebre1">SI</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="fiebre2" value="N" name="fiebre[]" required="required" <?php if($datos_salud[0]['fiebre'] == 'N'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="fiebre2">NO</label>
					</td>
				</tr>
				<tr>
					<td width="60%">
						<label class="form-check-label" for="tos">Tos seca y persistente de inicio reciente</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="tos1" value="S" name="tos[]" required="required" <?php if($datos_salud[0]['tos'] == 'S'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="tos1">SI</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="tos2" value="N" name="tos[]" required="required" <?php if($datos_salud[0]['tos'] == 'N'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="tos2">NO</label>
					</td>
				</tr>
				<tr>
					<td width="60%">
						<label class="form-check-label" for="respirar">Dificultad para respirar de inicio reciente</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="respirar1" value="S" name="respirar[]" required="required" <?php if($datos_salud[0]['respirar'] == 'S'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="respirar1">SI</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="respirar2" value="N" name="respirar[]" required="required" <?php if($datos_salud[0]['respirar'] == 'N'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="respirar2">NO</label>
					</td>
				</tr>
				<tr>
					<td width="60%">
						<label class="form-check-label" for="olfato">Perdida del olfato y/o el gusto</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="olfato1" value="S" name="olfato[]" required="required" <?php if($datos_salud[0]['olfato'] == 'S'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="olfato1">SI</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="olfato2" value="N" name="olfato[]" required="required" <?php if($datos_salud[0]['olfato'] == 'N'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="olfato2">NO</label>
					</td>
				</tr>
				<tr>
					<td width="60%">
						<label class="form-check-label" for="aislamiento_sin">Actualmente esta en aislamiento y en espera del resultado de una prueba para COVID-19</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="aislamiento_sin1" value="S" name="aislamiento_sin[]" required="required" <?php if($datos_salud[0]['aislamiento_sin'] == 'S'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="aislamiento_sin1">SI</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="aislamiento_sin2" value="N" name="aislamiento_sin[]" required="required" <?php if($datos_salud[0]['aislamiento_sin'] == 'N'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="aislamiento_sin2">NO</label>
					</td>
				</tr>
				<tr>
					<td width="60%">
						<label class="form-check-label" for="aislamiento_con">Actualmente esta en aislamiento luego de haber sido diagnosticado con prueba positiva para COVID-19</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="aislamiento_con1" value="S" name="aislamiento_con[]" required="required" <?php if($datos_salud[0]['aislamiento_con'] == 'S'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="aislamiento_con1">SI</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="aislamiento_con2" value="N" name="aislamiento_con[]" required="required" <?php if($datos_salud[0]['aislamiento_con'] == 'N'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="aislamiento_con2">NO</label>
					</td>
				</tr>
				<tr>
					<td width="60%">
						<label class="form-check-label" for="caso_confirmado">Vive con alguien en proceso de diagnostico o confirmado de tener COVID-19</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="caso_confirmado1" value="S" name="caso_confirmado[]" required="required" <?php if($datos_salud[0]['caso_confirmado'] == 'S'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="caso_confirmado1">SI</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="caso_confirmado2" value="N" name="caso_confirmado[]" required="required" <?php if($datos_salud[0]['caso_confirmado'] == 'N'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="caso_confirmado2">NO</label>
					</td>
				</tr>
				<tr>
					<td width="60%">
						<label class="form-check-label" for="contacto_estrecho">En los ultimos 14 dias ha tenido contacto estrecho (por mas de 15 minutos, a menos de 2 metrosy sin usar elementos de proteccion personal) con alguien en proceso de diagnostico o confirmado de COVID-19</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="contacto_estrecho1" value="S" name="contacto_estrecho[]" required="required" <?php if($datos_salud[0]['contacto_estrecho'] == 'S'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="contacto_estrecho1">SI</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="contacto_estrecho2" value="N" name="contacto_estrecho[]" required="required" <?php if($datos_salud[0]['contacto_estrecho'] == 'N'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="contacto_estrecho2">NO</label>
					</td>
				</tr>
				<tr>
					<td width="60%">
						<label class="form-check-label" for="vulnerables">Convive con personas vulnerables al COVID-19</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="vulnerables1" value="S" name="vulnerables[]" required="required" <?php if($datos_salud[0]['vulnerables'] == 'S'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="vulnerables1">SI</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="vulnerables2" value="N" name="vulnerables[]" required="required" <?php if($datos_salud[0]['vulnerables'] == 'N'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="vulnerables2">NO</label>
					</td>
				</tr>
			</table>
		</div>
		<div class="form-group">
			<label for="temperatura">Toma de temperatura corporal el día de hoy cuánto marco? Ej: 36.5</label>
			<input type="number" step="0.1" min="34.0" max="38.9" lang="es" class="form-control form-control-sm" id="temperatura" name="temperatura" required="required" <?php if(isset($datos_salud[0]['temperatura'])){ ?> value="<?php echo $datos_salud[0]['temperatura'];?>" <?php } else { ?> value="36.0" <?php } ?> >
		</div>
		<div class="form-group">
			<table width="100%" class="table table-condensed" style="font-weight:bold; color:#989898;">
				<tr>
					<td width="60%">
						<label class="form-check-label" for="prueba_covid">Se ha realizo examen de COVID-19</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="prueba_covid1" onchange="prueba(this.value)" value="S" name="prueba_covid[]" required="required" <?php if($datos_salud[0]['prueba_covid'] == 'S'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="prueba_covid1">SI</label>
					</td>
					<td width="20%">
						<input type="radio" class="form-check-input" id="prueba_covid2" onchange="prueba(this.value)" value="N" name="prueba_covid[]" required="required" <?php if($datos_salud[0]['prueba_covid'] == 'N'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="prueba_covid2">NO</label>
					</td>
				</tr>
			</table>
		</div>
		
		<div class="form-group" id="covid1" style="display:none">
			<label for="fecha_prueba">Fecha en la que se realizo la prueba</label>
			<input type="text" class="form-control form-control-sm" id="fecha_prueba" name="fecha_prueba" required="required" placeholder="Fecha de la prueba" value="<?php echo $datos_salud[0]['fecha_prueba'];?>">
		</div>
		<div class="form-group" id="covid2" style="display:none">
			<label for="resultado">Resultado</label>
			<select class="form-control form-control-sm" id="resultado" name="resultado" onchange="validar_prueba(this.value)">
				<option value="">Seleccione opción</option>
				<option value="P" <?php if($datos_salud[0]['resultado'] == 'P'){ ?> selected="selected" <?php } ?>>Pendiente</option>
				<option value="N" <?php if($datos_salud[0]['resultado'] == 'N'){ ?> selected="selected" <?php } ?>>Negativa</option>
				<option value="S" <?php if($datos_salud[0]['resultado'] == 'S'){ ?> selected="selected" <?php } ?>>Positiva</option>
			</select>
		</div>
		<div class="form-group" id="covid3" style="display:none">
			<label for="fecha_resultado">Fecha de los resultados</label>
			<input type="text" class="form-control form-control-sm" id="fecha_resultado" name="fecha_resultado" required="required" placeholder="Fecha de los resultados" value="<?php echo $datos_salud[0]['fecha_resultado'];?>">
		</div>
		<div class="form-group">
			<table width="100%" class="table table-condensed" style="color:#989898;">
				<tr>
					<td colspan="2" style="text-align:justify">
						<label class="form-check-label" for="exampleCheck1"><b>CONSENTIMIENTO INFORMADO Ley 1581 de 2012: de protección de datos personales,  es una ley que complementa la regulación vigente para la protección del derecho fundamental que tienen todas las personas naturales a autorizar la información personal que es almacenada en bases de datos o archivos, así como su posterior actualización y rectificación.</b><label>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:justify">
						<label class="form-check-label" for="exampleCheck1">
						Declaro que la información sobre las condiciones de salud consignadas en este documento es veraz, en consecuencia cualquier omisión o falsedad que se comprobare al respecto será considerado como un riesgo para el manejo de la salud del personal de obra en general y acepto las consecuencias jurídicas que se deriven de dicha omisión y autorizo expresamente a la empresa el manejo de la información contemplada en este documento, para uso y fines contemplados en la resolucion 666 de 2020 
						</label>
					</td>
				</tr>
				<tr align="center">
					<td width="50%">
						<input type="radio" class="form-check-input" id="terminos1" required="required" name="terminos[]" value="S" <?php if($datos_salud[0]['terminos'] == 'S'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="terminos1">SI</label>
					</td>
					<td width="50%">
						<input type="radio" class="form-check-input" id="terminos2" required="required" name="terminos[]" value="N" <?php if($datos_salud[0]['terminos'] == 'N'){ ?> checked="checked" <?php } ?> >
						<label class="form-check-label" for="terminos2">NO</label>
					</td>
				</tr>
			</table>
		</div>
		</form>
	</td>
	
</tr>

<tr align="center">
	<td colspan="4"><button type="submit" class="btn btn-sm btn-success" >ENVIAR</button></td>
</tr>                  
</tbody>                    
</table>
</form>
</div>    
</section>    
<?php include("Template/scripts.php"); ?>
<script>
$( function() {

            $( "#fechanac" ).datepicker({ 
            	dateFormat:'yy/mm/dd',
            	changeMonth:true,
            	changeYear:true,
            	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá']

            });
			$( "#fecha_prueba" ).datepicker({ 
            	dateFormat:'yy/mm/dd',
            	changeMonth:true,
            	changeYear:true,
            	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá']

            });
			$( "#fecha_resultado" ).datepicker({ 
            	dateFormat:'yy/mm/dd',
            	changeMonth:true,
            	changeYear:true,
            	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá']

            });
});
$( function(){
	$("#contratoA").chosen(); 
});
$(function(){
    var requiredCheckboxes = $('.options1 :checkbox[required]');
    requiredCheckboxes.change(function(){
        if(requiredCheckboxes.is(':checked')) {
			requiredCheckboxes.removeAttr('required');
        } else {
            requiredCheckboxes.attr('required', 'required');
        }	
    });
});

function prueba(valor){
	if(valor == 'S'){
		document.getElementById('covid1').style.display = 'block';
		document.getElementById('covid2').style.display = 'block';
		document.getElementById('covid3').style.display = 'block';
		document.getElementById('fecha_prueba').required = true;
		document.getElementById('resultado').required = true;
		document.getElementById('fecha_resultado').required = true;
	} else {
		document.getElementById('covid1').style.display = 'none';
		document.getElementById('covid2').style.display = 'none';
		document.getElementById('covid3').style.display = 'none';
		document.getElementById('fecha_prueba').required = false;
		document.getElementById('resultado').required = false;
		document.getElementById('fecha_resultado').required = false;
	}
}
function validar_prueba(estado){
	if(estado == 'P'){
		document.getElementById('fecha_resultado').required = false;
	} else {
		document.getElementById('fecha_resultado').required = true;
	}
}
</script>
<?php if($datos_salud[0]['prueba_covid'] == 'S'){ ?>
<script>prueba('S');</script>
<?php } ?>
<?php if(($datos_salud[0]['hipertension'] == 'S')or($datos_salud[0]['epoc'] == 'S')or($datos_salud[0]['cancer'] == 'S')or($datos_salud[0]['diabetes'] == 'S')or($datos_salud[0]['vih'] == 'S')or($datos_salud[0]['cardiaca'] == 'S')or($datos_salud[0]['renal'] == 'S')or($datos_salud[0]['asma'] == 'S')or($datos_salud[0]['ninguna'] == 'S')){ ?>
<script>var requiredCheckboxes = $('.options1 :checkbox[required]'); requiredCheckboxes.removeAttr('required'); </script>
<?php } ?>
</body>
</html>