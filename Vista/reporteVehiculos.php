<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once ('../Modelo/Vehiculo.php');
require_once ('../Modelo/TipoVehiculo.php');
require_once ('../Modelo/Contrato.php');
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Cliente.php");

$vehiculo = new Vehiculo();
$contrato = new Contrato();
$cliente = new Cliente();
$empresa = new Empresa();
$tipoVehiculo = new TipoVehiculo();

$listarTodos = $contrato->listarTodosActivos(date('Y-m-d'));

$listarTiposVehiculos = $tipoVehiculo->listar();


$hoy = date('Y-m-d');

$fecha1 = strtotime('+3 days',strtotime(date('Y-m-d')));
$notificarFecha = date('Y-m-d',$fecha1);

$fecha2 = strtotime('-1 year',strtotime(date('Y-m-d')));
$notificarFecha2 = date('Y-m-d',$fecha2);


if($_POST){

    $flota_propia = '%%';
    if($_POST['id_propia'] != ''){
        $flota_propia = $_POST['id_propia'];
    }

    $empresa = "numero_movil LIKE '%%' ";

    if($_POST['id_filtro'] == 1){
        $empresa = "(numero_movil < 1000 AND numero_movil != 0)";
    }else if($_POST['id_filtro'] == 2){
        $empresa = "(numero_movil >= 1000 AND numero_movil != 0 )";
    }else if($_POST['id_filtro'] == 3){
        $empresa = "numero_movil != 0";
    }
    
    $id_tipo_vehiculo = '%%';
    if($_POST['id_tipo_vehiculo'] != ''){
        $id_tipo_vehiculo = $_POST['id_tipo_vehiculo'];
    }
  
} else {
    $flota_propia = '%%';
    $id_tipo_vehiculo = '%%';
    $empresa = "numero_movil LIKE '%%' ";
}


$reporte = $vehiculo->listarTodosFiltroVehiculos($flota_propia, $empresa, $id_tipo_vehiculo);
//print_r($reporte);
//count($reporte);


$vacios = 0;
$vehiculosDocsVacios = array();
$vehiculosDocsVaciosTipo = array();
$vehiculosDocsVaciosPlaca = array();

/*VACIOS*/

foreach($reporte as $rv){
    if($rv['fotocopia_cedula_propietario'] == ''){
        $vacios = $vacios + 1;
        array_push($vehiculosDocsVacios, $rv['id_vehiculo']);
        array_push($vehiculosDocsVaciosTipo, "CEDULA PROPIETARIO");
        array_push($vehiculosDocsVaciosPlaca, $rv['placa']);
    }

    if(($rv['fecha_vencimiento_to'] == '0000-00-00') || ($rv['tarjeta_operacion'] == '')){
        $vacios = $vacios + 1;
        array_push($vehiculosDocsVacios, $rv['id_vehiculo']);
        array_push($vehiculosDocsVaciosTipo, "TARJETA OPERACIÓN");
        array_push($vehiculosDocsVaciosPlaca, $rv['placa']);
    }

    if($rv['licencia_transito'] == ''){
        $vacios = $vacios + 1;
        array_push($vehiculosDocsVacios, $rv['id_vehiculo']);
        array_push($vehiculosDocsVaciosTipo, "LICENCIA TRANSITO");
        array_push($vehiculosDocsVaciosPlaca, $rv['placa']);
    }

    if(($rv['fecha_vencimiento_soat'] == '0000-00-00') || ($rv['soat'] == '')){
        $vacios = $vacios + 1;
        array_push($vehiculosDocsVacios, $rv['id_vehiculo']);
        array_push($vehiculosDocsVaciosTipo, "SOAT");
        array_push($vehiculosDocsVaciosPlaca, $rv['placa']);
    }

    if(($rv['fecha_vencimiento_rt'] == '0000-00-00') || ($rv['revision_tecnomecanica'] == '')){
        $vacios = $vacios + 1;
        array_push($vehiculosDocsVacios, $rv['id_vehiculo']);
        array_push($vehiculosDocsVaciosTipo, "TECNOMECANICA");
        array_push($vehiculosDocsVaciosPlaca, $rv['placa']);
    }

    if(($rv['fecha_vencimiento_rp'] == '0000-00-00') || ($rv['revision_preventiva'] == '')){
        $vacios = $vacios + 1;
        array_push($vehiculosDocsVacios, $rv['id_vehiculo']);
        array_push($vehiculosDocsVaciosTipo, "PREVENTIVA");
        array_push($vehiculosDocsVaciosPlaca, $rv['placa']);
    }

    if(($rv['fecha_vencimiento_contra'] == '0000-00-00') || ($rv['poliza_contra'] == '')){
        $vacios = $vacios + 1;
        array_push($vehiculosDocsVacios, $rv['id_vehiculo']);
        array_push($vehiculosDocsVaciosTipo, "CONTRACTUAL");
        array_push($vehiculosDocsVaciosPlaca, $rv['placa']);
    }

    if(($rv['fecha_vencimiento_extra'] == '0000-00-00') || ($rv['poliza_extra'] == '')){
        $vacios = $vacios + 1;
        array_push($vehiculosDocsVacios, $rv['id_vehiculo']);
        array_push($vehiculosDocsVaciosTipo, "EXTRA CONTRACTUAL");
        array_push($vehiculosDocsVaciosPlaca, $rv['placa']);
    }

    if(($rv['fecha_exp_disp_velocidad'] == '0000-00-00') || ($rv['disp_velocidad'] == '')){
        $vacios = $vacios + 1;
        array_push($vehiculosDocsVacios, $rv['id_vehiculo']);
        array_push($vehiculosDocsVaciosTipo, "DISPOSITIVO VELOCIDAD");
        array_push($vehiculosDocsVaciosPlaca, $rv['placa']);
    }
}

$vencidos = 0;
$vehiculosDocsVencidos = array();
$vehiculosDocsVencidosTipo = array();
$vehiculosDocsVencidosPlaca = array();

$to = 0; 
$soat = 0; 
$rt = 0; 
$rp = 0; 
$contra = 0; 
$extra = 0; 
$disp_v = 0; 



/*VENCIDOS*/
foreach($reporte as $rv){
    
    if(($rv['fecha_vencimiento_to'] < $hoy)and($rv['fecha_vencimiento_to'] != '0000-00-00')){
        $vencidos = $vencidos + 1;
        $to = $to + 1;
        array_push($vehiculosDocsVencidos, $rv['id_vehiculo']);
        array_push($vehiculosDocsVencidosTipo, "TARJETA OPERACIÓN");
        array_push($vehiculosDocsVencidosPlaca, $rv['placa']);
    }

    if(($rv['fecha_vencimiento_soat'] < $hoy)and($rv['fecha_vencimiento_soat'] != '0000-00-00')){
        $vencidos = $vencidos + 1;
        $soat = $soat + 1;
        array_push($vehiculosDocsVencidos, $rv['id_vehiculo']);
        array_push($vehiculosDocsVencidosTipo, "SOAT");
        array_push($vehiculosDocsVencidosPlaca, $rv['placa']);
    }

    if(($rv['fecha_vencimiento_rt'] < $hoy)and($rv['fecha_vencimiento_rt'] != '0000-00-00')){
        $vencidos = $vencidos + 1;
        $rt = $rt + 1;
        array_push($vehiculosDocsVencidos, $rv['id_vehiculo']);
        array_push($vehiculosDocsVencidosTipo, "TECNOMECANICA");
        array_push($vehiculosDocsVencidosPlaca, $rv['placa']);
    }

    if(($rv['fecha_vencimiento_rp'] < $hoy)and($rv['fecha_vencimiento_rp'] != '0000-00-00')){        
        $vencidos = $vencidos + 1;
        $rp = $rp + 1;
        array_push($vehiculosDocsVencidos, $rv['id_vehiculo']);
        array_push($vehiculosDocsVencidosTipo, "PREVENTIVA");
        array_push($vehiculosDocsVencidosPlaca, $rv['placa']);
    }

    if(($rv['fecha_vencimiento_contra'] < $hoy)and($rv['fecha_vencimiento_contra'] != '0000-00-00')){ 
        $vencidos = $vencidos + 1;
        $contra = $contra + 1;
        array_push($vehiculosDocsVencidos, $rv['id_vehiculo']);
        array_push($vehiculosDocsVencidosTipo, "CONTRACTUAL");
        array_push($vehiculosDocsVencidosPlaca, $rv['placa']);
    }

    if(($rv['fecha_vencimiento_extra'] < $hoy)and($rv['fecha_vencimiento_extra'] != '0000-00-00')){
        $vencidos = $vencidos + 1;
        $extra = $extra + 1;
        array_push($vehiculosDocsVencidos, $rv['id_vehiculo']);
        array_push($vehiculosDocsVencidosTipo, "EXTRA CONTRACTUAL");
        array_push($vehiculosDocsVencidosPlaca, $rv['placa']);
    }

    $fecha2 = strtotime('-1 year',strtotime(date('Y-m-d')));
    $notificarFecha2 = date('Y-m-d',$fecha2);

    if(($rv['fecha_exp_disp_velocidad'] < $notificarFecha2)and($rv['fecha_exp_disp_velocidad'] != '0000-00-00')){
        $vencidos = $vencidos + 1;
        $disp_v = $disp_v + 1;
        array_push($vehiculosDocsVencidos, $rv['id_vehiculo']);
        array_push($vehiculosDocsVencidosTipo, "DISPOSITIVO VELOCIDAD");
        array_push($vehiculosDocsVencidosPlaca, $rv['placa']);
    }
}


$to; 
$soat; 
$rt; 
$rp; 
$contra; 
$extra; 
$disp_v; 

$cantidad_documento = (count($reporte) * 9);
$total = $vencidos + $vacios;

$porcentaje = (($total * 100)/$cantidad_documento);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Reporte Vehiculos</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- styles -->
  <?php include("Template/styles.php") ?>
  <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

    <style type="text/css" media="screen">

    </style>                  
  <!--fin  styles -->

</head>
<body>

    <!--MENU-->
        <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->
    
    <!-- CONTENIDO -->

    <section class="home_content">

        <div aria-label="breadcrumb" class="mt-1"> 
           <ol class="breadcrumb" style="background: #fff;">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="vehiculos.php">Vehiculos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reporte Vehiculos</li>
           </ol>
        </div>
        
        <div class="notice notice-sistemakv">
          <strong><i class="fa fa-file-text-o mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">REPORTE VEHÍCULOS</b></strong>
        </div>
   
    <!-- FILTRO REPORTE -->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3 titulo_reporte" style="background-color: #1b2d3b; color: #fff; border-radius: 3px; width: 100%">
            <p style="margin: 10px; margin-top: 10px;">FILTRAR REPORTE</p>
        </div>

        <div class="col-sm-12 col-md-12 mt-3 formulario_reporte p-4" style="height: auto; width: 100%; border-radius: 4px; background-color: #fff; ">
            
            <form method="POST" action="">
                <div class="row mt-2 d-flex justify-content-between p-3" style="border: 1px dashed #bfbfbf;">
                   
                    <!-- FLOTA PROPIA -->
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 formulario">
                            <label><b style="color: #5e99b1;">FLOTA PROPIA</b></label>
                            <select class="form-control display selectpicker" data-live-search="true" name="id_propia" id="id_propia" onchange="validarFlotaFiltroReporte();">
                                <option value="">SELECCIONAR</option>
                                <option value="S">SI</option>
                                <option value="N">NO</option>
                            </select>
                        </div>

                    <!-- EMPRESA -->

                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 formulario">
                        <label><b style="color: #5e99b1;">EMPRESA</b></label>
                        <select class="form-control display selectpicker" data-live-search="true" name="id_filtro">
                            <option value="">SELECCIONAR</option>
                            <option value="1">ORT</option>
                            <option value="2">LINEAS PREMIUM</option>
                            <option value="3">ORT Y LINEAS PREMIUM</option>
                        </select>
                    </div>

                    <!-- TIPO VEHICULO -->

                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 formulario">
                        <label><b style="color: #5e99b1;">TIPO VEHICULO</b></label>
                        <select class="form-control display selectpicker" data-live-search="true" name="id_tipo_vehiculo">
                            <option value="">SELECCIONAR</option>
                            <?php foreach ($listarTiposVehiculos as $ltv){ ?>
                                <option value="<?php echo $ltv['id_tipo_vehiculo'] ?>"><?php echo $ltv['nombre_tipo_vehiculo'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                </div>

            
                <div class="row mt-2 d-flex justify-content-center">
                    <div class="col-sm-6 col-md-3">
                        <label>&nbsp;</label>
                        <button name="consultar" class="btn btn-block" style="background-color: #1b2d3b; color: #fff;">Filtrar</button>
                    </div>
                </div>

            </form>
            
            <form action="ReporteExportarExcelVehiculos.php" method="post" target="_blank">
        		<div class="row mt-2 d-flex justify-content-center">
                    <div class="col-3">

                        <input type="hidden" name="filtro_flota_propia" id="filtro_flota_propia" value="<?php echo $_POST['id_propia']; ?>">
                        <input type="hidden" name="filtro_empresa" id="filtro_empresa" value="<?php echo $_POST['id_filtro']; ?>">
                        <input type="hidden" name="filtro_tipo_vehiculo" id="filtro_tipo_vehiculo" value="<?php echo $_POST['id_tipo_vehiculo']; ?>">
    	                
                        <button type="submit" class="btn mr-4 btn-block" style="background-color: #4caf50; height: 40px; margin-top: 10px; color: #fff;">Excel <span class="fa fa-file-excel-o"></span></button>
        
        		     </div>
        		</div>
    	    </form>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3 linea_reporte" style="background-color: #1b2d3b; color: #fff; border-radius: 3px; height: 3px; width: 100%;"></div>
        
        <!-- TABLA INFORMACION BASICA-->
            <div class="mt-2 p-4 table-responsive" style="background-color: #FFF">
                <table  id="dataT" class="table table-hover text-center table-sm display" style="width:100%">
                        <thead>
                            <tr style="background-color: #1b2d3b; color: #fff;">
                                <th colspan="4" style="text-align:center; border-bottom: 2px solid #fff;">TOTAL DE VEHICULOS: <?php echo count($reporte);?></th>
                            </tr>
                            <tr style="background-color: #1b2d3b; color: #fff;">
                                <th>TOTAL DE DOCUMENTOS</th>
                                <th>DOCUMENTOS VACIOS</th>
                                <th>DOCUMENTOS VENCIDOS</th>
                                <th>PORCENTAJE CUMPLIMIENTO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $cantidad_documento;?></td>
                                <td><a href="javascript:void(0)" data-toggle="modal" data-target="#vacios"><strong><?php echo $vacios;?></strong></td>
                                <td><a href="javascript:void(0)" data-toggle="modal" data-target="#vencidos"><strong><?php echo $vencidos;?></strong></a></td>
                                <td>
                                    <?php 
                                    $cumplimiento = 100-$porcentaje; 
                                    echo "<strong>" . number_format($cumplimiento, 2, ",", "."). "% </strong>"; 
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                </table>
            </div>
        <!-- FIN CONTENIDO -->
    </section>
        
    <!-- MODAL DOCUMENTACION VACIA-->
            <div class="modal fade" id="vacios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-body">

                    <h5 class="modal-title text-center mb-4 mt-3" id="exampleModalLabel"><strong>DOCUMENTOS VACIOS</strong></h5>
                    <?php $cant = count($vehiculosDocsVacios);?>
                    <table  id="dataT2" class="table">
                    <?php if($cant > 0){ ?>
                    <tr>
                        <td align="center">ID VEHICULO</td>
                        <td align="center">PLACA</td>
                        <td align="center">DOCUMENTO</td>
                        <td align="center">OPCION</td>
                    </tr>
                    <?php for($i=0;$i<$cant;$i++){ ?>
                    <tr >
                        <td align="center"><?php echo $vehiculosDocsVacios[$i]; ?></td>
                        <td align="center"><?php echo $vehiculosDocsVaciosPlaca[$i]; ?></td>
                        <td align="center"><?php echo $vehiculosDocsVaciosTipo[$i]; ?></td>
                        <td align="center">
                            <a class="btn btn-outline-primary" style="margin: 0px; padding: 0px 4px 0px 3px;" href="actualizarVehiculo.php?id_vehiculo=<?php echo $vehiculosDocsVacios[$i];?>" target="_blank"><span class="fa fa-edit"></span></a>
                        </td>
                        <td align="center"><?php echo $tipo_vacios[$i];?></td>
                    </tr>   
                    <?php } ?>
                    <?php } else { ?>
                    <tr>
                        <td>NO HAY DOCUMENTACION VACIA</td>
                    </tr>
                    <?php } ?>
                    </table>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  </div>
                </div>
              </div>
            </div>

    <!-- MODAL DOCUMENTACION VENCIDA -->
            <div class="modal fade" id="vencidos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-body">
                    <h5 class="modal-title text-center mb-4 mt-3" id="exampleModalLabel"><strong>DOCUMENTOS VENCIDOS</strong></h5>
                    <?php $cant = count($vehiculosDocsVencidos);?>
                    <table  id="dataT3" class="table">
                    <?php if($cant > 0){ ?>
                    <tr>
                        <td align="center">ID VEHICULO</td>
                        <td align="center">PLACA</td>
                        <td align="center">DOCUMENTO</td>
                        <td align="center">OPCION</td>
                    </tr>
                    <?php for($i=0;$i<$cant;$i++){ ?>
                    <tr >
                        <td align="center"><?php echo $vehiculosDocsVencidos[$i]; ?></td>
                        <td align="center"><?php echo $vehiculosDocsVencidosPlaca[$i]; ?></td>
                        <td align="center"><?php echo $vehiculosDocsVencidosTipo[$i]; ?></td>
                        <td align="center">
                            <a class="btn btn-outline-primary" style="margin: 0px; padding: 0px 4px 0px 3px;" href="actualizarVehiculo.php?id_vehiculo=<?php echo $vehiculosDocsVencidos[$i];?>" target="_blank"><span class="fa fa-edit"></span></a>
                        </td>
                    </tr>   
                    <?php } ?>
                    <?php } else { ?>
                    <tr>
                        <td>NO HAY DOCUMENTACION VENCIDA</td>
                    </tr>
                    <?php } ?>
                    </table>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  </div>
                </div>
              </div>
            </div>

    <!-- script -->
        <?php include("Template/scripts.php"); ?>

        <script type="text/javascript">


            $('#modelo').keypress(function (tecla) {
                if (tecla.charCode < 48 || tecla.charCode > 57) return false;
            });
            
            function validarFlotaFiltroReporte(){
                var flota = $('#id_propia').val();
                var apoyo = $('#contratoApoyo').val();
                var base = $('#contratoBase').val();

                if((flota != 0) && (apoyo == 0) && (base == 0)){
                    $("#contratoBase").prop("disabled", true);
                    $("#contratoApoyo").prop("disabled", true);
                }else{
                    $("#contratoBase").prop("disabled", false);
                    $("#contratoApoyo").prop("disabled", false);
                }

            }

            function validarBaseFiltroReporte(){
                var flota = $('#id_propia').val();
                var apoyo = $('#contratoApoyo').val();
                var base = $('#contratoBase').val();

                if((flota == 0) && (apoyo == 0) && (base != 0)){
                    $("#id_propia").prop("disabled", true);
                    $("#contratoApoyo").prop("disabled", true);
                }else{
                    $("#id_propia").prop("disabled", false);
                    $("#contratoApoyo").prop("disabled", false);
                }

            }

            function validarApoyoFiltroReporte(){
                var flota = $('#id_propia').val();
                var apoyo = $('#contratoApoyo').val();
                var base = $('#contratoBase').val();

                if((flota == 0) && (apoyo != 0) && (base == 0)){
                    $("#contratoBase").prop("disabled", true);
                    $("#id_propia").prop("disabled", true);
                }else{
                    $("#contratoBase").prop("disabled", false);
                    $("#id_propia").prop("disabled", false);
                }

            }
        </script>
</body>
</html>