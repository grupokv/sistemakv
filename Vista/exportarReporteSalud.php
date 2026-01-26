<?php
date_default_timezone_set('America/Bogota');
$hoy = date('Ymd_His');
$filename = $hoy.'_reporte_salud.xls';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename='.$filename);

require ("../Modelo/Salud.php");
require ("../Modelo/Usuario.php");
require_once "../Modelo/Contrato.php";
require_once "../Modelo/Cliente.php";

$fechai = $_POST['fecha_inicial'];
$fechaf = $_POST['fecha_final'];
$id_contrato = $_POST['contrato'];

$salud = new Salud();
$usuario = new Usuario();
$contrato = new Contrato();
$cliente = new Cliente();

$listarC = $salud->listarPorRangoFecha($fechai,$fechaf,$id_contrato);

?>

<table  id="dataT" class="table table-hover table-sm display" style="width:100%">
          <thead>
            <tr>
			  <th>FECHA</th>
			  <th>CEDULA</th>
			  <th>NOMBRE</th>
              <th>EMAIL</th>
              <th>CELULAR</th>
              <th>DIRECCION</th>
              <th>EMPRESA</th>
			  <th>FECHA NAC.</th>
	          <th>EPS</th>
              <th>ARL</th>
              <th>CARGO</th>
              <th>CONTRATO</th>
              <th>MEDIO TRANSPORTE</th>
              <th>CONTACTO</th>
              <th>TEL. CONTACTO</th>
              <th>HIPERTENSION</th>
              <th>EPOC</th>
              <th>CANCER</th>
              <th>DIABETES</th>
              <th>VIH</th>
              <th>CARDIACA</th>
              <th>RENAL</th>
              <th>ASMA</th>
              <th>NINGUNA</th>
              <th>MEDICAMENTOS</th>
              <th>MAYOR 60 AÑOS</th>
			  <th>DOLOR GARGANTA</th>
			  <th>MALESTAR GENERAL</th>
			  <th>FIEBRE</th>
			  <th>TOS SECA</th>
			  <th>DIFICULTAD RESPIRAR</th>
			  <th>PERDIDA OLFATO</th>
			  <th>SE ENCUENTRA EN AISLAMIENTO</th>
			  <th>SE ENCUENTRA EN AISLAMIENTO POR DIAGNOSTICO</th>
			  <th>VIVE CON PERSONA CON CASO CONFIRMADO</th>
			  <th>CONTACTO ESTRECHO CON CASO CONFIRMADO</th>
			  <th>VIVE CON PERSONAS VULNERABLES</th>
			  <th>TEMPERATURA ACTUAL</th>
			  <th>EXAMEN COVID</th>
			  <th>FECHA PRUEBA</th>
			  <th>RESULTADO</th>
			  <th>FECHA RESULTADO</th>
			  <th>TERMINOS Y CONDICIONES</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($listarC as $lc){ ?>
				<tr>
					<?php $datos_usu = $usuario->listarUsuarioPorId($lc['id_usuario']); ?>
					<td><?php echo $lc['fecha_diligenciamiento']; ?></td>
					<td><?php echo $datos_usu[0]['usuario']; ?></td>
					<td><?php echo utf8_decode($datos_usu[0]['nombre']); ?></td>
					<td><?php echo $lc['email'];?></td>
					<td><?php echo $lc['celular'];?></td>
					<td><?php echo $lc['direccion'];?></td>
					<td><?php echo $lc['empresa'];?></td>
					<td><?php echo $lc['fechanac'];?></td>
					<td><?php echo $lc['eps'];?></td>
					<td><?php echo $lc['arl'];?></td>
					<td><?php echo $lc['cargo'];?></td>
					<td>
					<?php 
						if($lc['contrato'] == 0){
							$det_contrato = 'ADMINISTRATIVO';
						} else {
							$datos_contrato = $contrato->listarId($lc['contrato']);
							$datos_cliente = $cliente->cliente_ID($datos_contrato[0]['id_cliente']);
							$det_contrato = $lc['contrato'].' - '. utf8_decode($datos_cliente[0]['razon_social']);
						}
						echo $det_contrato;
					?>
					</td>
					<td><?php echo $lc['transporte'];?></td>
					<td><?php echo $lc['nombre_contacto'];?></td>
					<td><?php echo $lc['tel_contacto'];?></td>
					<td><?php echo $lc['hipertension'];?></td>
					<td><?php echo $lc['epoc'];?></td>
					<td><?php echo $lc['cancer'];?></td>
					<td><?php echo $lc['diabetes'];?></td>
					<td><?php echo $lc['vih'];?></td>
					<td><?php echo $lc['cardiaca'];?></td>
					<td><?php echo $lc['renal'];?></td>
					<td><?php echo $lc['asma'];?></td>
					<td><?php echo $lc['ninguna'];?></td>
					<td><?php echo $lc['medicamentos'];?></td>
					<td><?php echo $lc['edad'];?></td>
					<td><?php echo $lc['dolor_garganta'];?></td>
					<td><?php echo $lc['malestar_general'];?></td>
					<td><?php echo $lc['fiebre'];?></td>
					<td><?php echo $lc['tos'];?></td>
					<td><?php echo $lc['respirar'];?></td>
					<td><?php echo $lc['olfato'];?></td>
					<td><?php echo $lc['aislamiento_sin'];?></td>
					<td><?php echo $lc['aislamiento_con'];?></td>
					<td><?php echo $lc['caso_confirmado'];?></td>
					<td><?php echo $lc['contacto_estrecho'];?></td>
					<td><?php echo $lc['vulnerables'];?></td>
					<td><?php echo $lc['temperatura'];?></td>
					<td><?php echo $lc['prueba_covid'];?></td>
					<td><?php echo $lc['fecha_prueba'];?></td>
					<td><?php if($lc['resultado'] == 'P'){ $resultado = 'PENDIENTE'; } else if ($lc['resultado'] == 'S'){ $resultado = 'POSITIVO'; } else if ($lc['resultado'] == 'N'){ $resultado = 'NEGATIVO'; } echo $resultado;?>
					</td>
					<td><?php echo $lc['fecha_resultado'];?></td>
					<td><?php echo $lc['terminos'];?></td>
				</tr>
            <?php } ?>
          </tbody>
        </table>