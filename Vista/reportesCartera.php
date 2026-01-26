<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Vehiculo.php");
require_once ("../Modelo/ConceptosCobro.php");
require_once ("../Modelo/General.php");

$vehiculo = new Vehiculo();
$listarVehiculo = $vehiculo->listarVehiculosVinculados();

$concepto = new ConceptoCobro();
$bancos = $concepto->listarBancos();
$listarConceptos = $concepto->listar();

if($_POST){
    
    if($_POST['id_concepto'] != 0){
        $id_concepto = $_POST['id_concepto'];
    }else{
        $id_concepto = '%%';
    }
    
    if(($_POST['id_concepto'] == 0) && ($_POST['id_vehiculo'] != 0) && ($_POST['id_cuenta'] == 0)){
        if(($_POST['id_vehiculo'] != 0) && ($_POST['mes'] != 0)){
            $mes = explode("/", $_POST['mes']);
            $fecha_mes = $mes[0];
            $id_vehiculo = $_POST['id_vehiculo'];
            $listarFiltroEstadoCuentaVehiculo = $concepto->listarFiltroEstadoCuentaVehiculo($id_vehiculo, $fecha_mes);
        }else if(($_POST['id_vehiculo'] != 0) && ($_POST['mes'] == 0)){
            $id_vehiculo = $_POST['id_vehiculo'];
            $listarFiltroEstadoCuentaVehiculo = $concepto->listarCobrosPorVehiculo($id_vehiculo);
        }
    }else if(($_POST['id_concepto'] != 0) && ($_POST['id_vehiculo'] == 0) && ($_POST['id_cuenta'] == 0)){
        if($_POST['frecuencia_servicio'] == "A"){
            $fecha_anio = $_POST['anio'];
            $listarFiltroServicioFrecuenciaAnual = $concepto->listarFiltroServicioFrecuenciaAnual($id_concepto, $fecha_anio);
            //print_r($listarFiltroServicioFrecuenciaAnual);
        }else if($_POST['frecuencia_servicio'] == "M"){
            $mes = explode("/", $_POST['mes']);
            $fecha_mes = $mes[0];
            $listarFiltroServicioFrecuenciaMensual = $concepto->listarFiltroServicioFrecuenciaMensual($id_concepto, $fecha_mes);
            //print_r($listarFiltroServicioFrecuenciaMensual);
        }else if($_POST['frecuencia_servicio'] == "N"){
            $mes = explode("/", $_POST['mes']);
            $fecha_mes = $mes[0];
            $listarFiltroServicioSinFrecuencia = $concepto->listarFiltroServicioSinFrecuencia($id_concepto, $fecha_mes);
        }
    }else if(($_POST['id_concepto'] == 0) && ($_POST['id_vehiculo'] == 0) && ($_POST['id_cuenta'] != 0)){
        $banco_consignacion = $_POST['id_cuenta'];
        $mes = explode("/", $_POST['mes']);
        $fecha_pago = $mes[0];
        $listarComprobantesPorCuentaBanco = $concepto->listarComprobantesPorCuentaBanco($banco_consignacion, $fecha_pago);
    }else if(($_POST['id_concepto'] == 0) && ($_POST['id_vehiculo'] == 0) && ($_POST['id_cuenta'] == 0)){
        $listarTodosCobros = $concepto->listarCobros();
    }
}

?>

<!DOCTYPE html>
<html>
<head><meta charset="utf-8">
    
	<title>SistemaKV | Reporte Cartera</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- STYLES -->
        <?php include("Template/styles.php") ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
        
        <style type="text/css">
        
            @media (max-width: 760px){
              
                .icono-principal{
                  display: none;
                }
        
                .fa-plus{
                   display: none;
                }
            }
        
            .barra-principal{
                background-color: #5e99b1;
            }
        </style>
    <!-- FIN STYLES -->

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
                 <ol class="breadcrumb" style="background-color: #fff;">
                    <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Reporte</li>
                 </ol>
            </div>
    
            <div class="notice notice-sistemakv">
                <strong><i class="fa fa-file-text mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">REPORTE CARTERA</b></strong>
            </div>

            <div class="notice notice-sistemakv">
                <a href="reporte_general_cartera.php" class="btn mb-2" id="buttonsKV">Exportar Consolidado General <i class="fa fa-download ml-2 mr-2"></i></a>
                        
                <?php if(($_POST['id_concepto'] != 0) && ($_POST['id_vehiculo'] == 0) && ($_POST['id_cuenta'] == 0)){ ?>
                    <form action="exportarExcelReporteCartera.php" method="POST" target="_blank">
                        <input type="hidden" class="form-control" name="concepto" id="concepto" value="<?php echo $_POST['id_concepto'] ?>" />
                        <input type="hidden" class="form-control" name="fechaMes" id="fechaMes" value="<?php echo $fecha_mes; ?>" />
                        <input type="hidden" class="form-control" name="fechaAnio" id="fechaAnio" value="<?php echo $_POST['anio']; ?>" />
                        <input type="hidden" class="form-control" name="frecuenciaS" id="frecuenciaS" value="<?php echo $_POST['frecuencia_servicio']; ?>" />
                        <input type="hidden" class="form-control" name="tipoReporte" id="tipoReporte" value="C" />
                        
                        <button type="submit" class="btn" id="buttonsKV">Exportar<i class="fa fa-download ml-2"></i></button>
                    </form>
                    
                <?php } else if(($_POST['id_concepto'] == 0) && ($_POST['id_vehiculo'] != 0) && ($_POST['id_cuenta'] == 0)){ ?>
                    
                    <form action="exportarExcelReporteCartera.php" method="POST" target="_blank">
                        
                        <input type="hidden" class="form-control" name="vehiculo" id="vehiculo" value="<?php echo $_POST['id_vehiculo']; ?>" />
                        <input type="hidden" class="form-control" name="fechaMes" id="fechaMes" value="<?php echo $fecha_mes; ?>" />
                        <input type="hidden" class="form-control" name="tipoReporte" id="tipoReporte" value="V" />
                        
                        <button type="submit" class="btn" id="buttonsKV">Exportar Excel<i class="fa fa-download ml-2"></i></button>
                        
                    </form>
                    
                    <?php if(($_POST['id_vehiculo'] != 0) && ($_POST['mes'] != 0)){ ?>
                        <form action="PDF/estadoCuenta.php" method="POST" target="_blank">
                            
                            <input type="hidden" class="form-control" name="tipoReporte" id="tipoReporte" value="VM" />
                            <input type="hidden" class="form-control" name="vehiculo" id="vehiculo" value="<?php echo $_POST['id_vehiculo']; ?>" />
                            <input type="hidden" class="form-control" name="fechaMes" id="fechaMes" value="<?php echo $fecha_mes; ?>" />
                            <button type="submit" class="btn" id="buttonsKV"><i class="fa fa-download ml-2 mr-2"></i>Exportar PDF</button>
                    
                        </form>

                    <?php }else if(($_POST['id_vehiculo'] != 0) && ($_POST['mes'] == 0)){ ?>
                        <form action="PDF/estadoCuenta.php" method="POST" target="_blank">
                            
                            <input type="hidden" class="form-control" name="tipoReporte" id="tipoReporte" value="V" />
                            <input type="hidden" class="form-control" name="vehiculo" id="vehiculo" value="<?php echo $_POST['id_vehiculo']; ?>" />
                            <button type="submit" class="btn" id="buttonsKV">Exportar PDF<i class="fa fa-download ml-2"></i></button>
                        
                        </form>

                    <?php } ?>
                    
                <?php } else if(($_POST['id_concepto'] == 0) && ($_POST['id_vehiculo'] == 0) && ($_POST['id_cuenta'] != 0)){ ?>
                
                    <form action="exportarExcelReporteCartera.php" method="POST" target="_blank">
                        <input type="hidden" class="form-control" name="cuentaBanco" id="cuentaBanco" value="<?php echo $_POST['id_cuenta']; ?>" />
                        <input type="hidden" class="form-control" name="frecuenciaS" id="frecuenciaS" value="<?php echo $_POST['frecuencia_servicio']; ?>" />
                        <input type="hidden" class="form-control" name="fechaMes" id="fechaMes" value="<?php echo $_POST['mes']; ?>" />
                        <input type="hidden" class="form-control" name="tipoReporte" id="tipoReporte" value="CB" />
                        <button type="submit" class="btn" id="buttonsKV">Exportar<i class="fa fa-download ml-2"></i></button>
                    </form>

                <?php } else if(($_POST['id_concepto'] == 0) && ($_POST['id_vehiculo'] == 0) && ($_POST['id_cuenta'] == 0)){ ?>
                    <form action="exportarExcelReporteCartera.php" method="POST" target="_blank">
                        <input type="hidden" class="form-control" name="tipoReporte" id="tipoReporte" value="N" />
                        <button type="submit" class="btn" id="buttonsKV">Exportar<i class="fa fa-download ml-2"></i></button>
                    </form>

                <?php } ?>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3 titulo_reporte" style="background-color: #1b2d3b; color: #fff; border-radius: 3px; width: 100%">
                <p>FILTRAR REPORTE</p>
            </div>
            
            <form action="" method="POST" style="background-color: #FFF;">
                <hr style="background-color:#f2f2f2; width: 98%;">
                    <div class="row p-3 m-1 d-flex justify-content-center">

                        <div class="col-sm-12 col-md-3 col-lg-3 m-1">
                            <div class="label" style="width:100%;">
                                <label><b>POR SERVICIO</b></label>
                            </div>
                        </div>
                        
                        <div class="col-sm-12 col-md-3 col-lg-3 m-1">
                            <div class="label" style="width:100%;">
                                <label><b>ESTADO DE CUENTA VEHICULO</b></label>
                            </div>
                        </div>
                        
                        <div class="col-sm-12 col-md-3 col-lg-3 m-1">
                            <div class="label" style="width:100%;margin-left:2px">
                                <label><b>POR BANCO</b></label>
                            </div>
                        </div>
                        
                        <div class="col-sm-12 col-md-2 col-lg-2 m-1">
                            <div class="label" style="width:100%;margin-left:2px">
                                <label id="mes"><b>MES</b></label>
                                <label style="display:none;" id="anio"><b>AÑO</b></label>
                            </div>
                        </div>
                    </div>
                    
                    <div id="servicio"></div>
                    
                    <div class="row p-1 m-1 d-flex justify-content-center">
                        <div class="col-sm-12 col-md-3 col-lg-3 m-1 ">
                            <select class="form-control selectpicker" data-live-search="true" name="id_concepto" id="id_concepto" onchange="validarTiempoServicio(this.value); validarSeleccionFiltroPorConcepto();">
                                <option value="">SELECCIONAR</option>
                                    <?php foreach ($listarConceptos as $lc){ ?>
                                        <option value="<?php echo $lc['id_concepto'] ?>"><?php echo $lc['detalle_concepto'] ?></option>
                                    <?php } ?>
                            </select>
                        </div>
                        
                        <div class="col-sm-12 col-md-3 col-lg-3 m-1">
                            <select class="form-control selectpicker" data-live-search="true" name="id_vehiculo" id="id_vehiculo" onchange="validarSeleccionFiltroPorVehiculo();">
                                <option value="">SELECCIONAR</option>
                                    <?php foreach ($listarVehiculo as $lv){ ?>
                                        <option value="<?php echo $lv['id_vehiculo'] ?>"><?php echo $lv['placa'] ?></option>
                                    <?php } ?>
                            </select>
                        </div>
                        
                        <div class="col-sm-12 col-md-3 col-lg-3 m-1">
                            <select class="form-control selectpicker" data-live-search="true" name="id_cuenta" id="id_cuenta" onchange="validarSeleccionFiltroPorCuentaBanco();">
            	     	    	<option value="">SELECCIONAR</option>
            				 	<?php foreach ($bancos as $bn){ ?>
            				 		<option value="<?php echo $bn['id_cuenta'];?>">
            				 			<?php echo $bn['descripcion']; ?>
            				 		</option>
            				 	<?php } ?>
            				</select>
                        </div>
                        
                        <div class="col-sm-12 col-md-2 col-lg-2 m-1">
                            <input type="text" name="mes" id="datepicker" class="form-control" autocomplete="off">
                            <input type="text" name="anio" id="datepicker1" class="form-control" autocomplete="off" style="display:none;">
                        </div>
                        
                    </div>
                    
                    
                    
                    <div class="row p-1 m-1 d-flex justify-content-center">
                    	<div class="col-lg-3 col-md-3 col-sm-10 col-xs-10">
                    	    <button type="submit" class="btn btn-outline-info btn-block mr-4 mt-4"><span class="fa fa-search ml-2 mr-2"></span>Filtrar</button>
                    	</div>
                    </div>
                    
                    
                <hr style="background-color:#f2f2f2; width: 98%;">
            </form>


            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3 titulo_reporte text-center" style="background-color: #1b2d3b; color: #fff; border-radius: 3px; width: 100%; height: 5px;"></div>
          
            <section class="mt-3 p-4 table-responsive" style="background-color: #fff;">
                <table class="table table-hover text-center table-sm display text-center" id="dataT">
                    <thead style="background-color: #1b2d3b; color: #fff;">
                        <?php if(($_POST['id_concepto'] != 0) && ($_POST['id_vehiculo'] == 0) && ($_POST['id_cuenta'] == 0)){ ?>
                            <tr>
                                <th>CONCEPTO SERVICIO</th>
                                <th>FRECUENCIA</th>
                                <th>VEHICULO</th>
                                <th>VALOR</th>
                                <th>ESTADO</th>
                            </tr>
                        <?php }else if(($_POST['id_concepto'] == 0) && ($_POST['id_vehiculo'] != 0) && ($_POST['id_cuenta'] == 0)){ ?>
                            </tr>
                                <th>VEHICULO</th>
                                <th>CONCEPTO SERVICIO</th>
                                <th>FRECUENCIA</th>
                                <th>FECHA COBRO</th>
                                <th>VALOR</th>
                                <th>ESTADO</th>
                            </tr>
                        <?php }else if(($_POST['id_concepto'] == 0) && ($_POST['id_vehiculo'] == 0) && ($_POST['id_cuenta'] != 0)){ ?>
                            </tr>
                                <th>CUENTA BANCO</th>
                                <th>VEHICULO</th>
                                <th>CONCEPTO SERVICIO</th>
                                <th>FRECUENCIA</th>
                                <th>FECHA PAGO</th>
                                <th>VALOR</th>
                            </tr>
                        <?php } ?>
                    </thead>
                    <tbody>
                        <?php if(($_POST['id_concepto'] != 0) && ($_POST['id_vehiculo'] == 0) && ($_POST['id_cuenta'] == 0)){ 
                            if($_POST['frecuencia_servicio'] == "A"){
                                foreach($listarFiltroServicioFrecuenciaAnual As $lfsfa){ 
                                    $listarConceptosId = $concepto->listarPorId($lfsfa['id_concepto']); 
                                    $listarVehiculoPorId = $vehiculo->listarPorId($lfsfa['id_vehiculo']); ?>
                                    <tr>
                                        <td><?php echo $listarConceptosId[0]['detalle_concepto']; ?></td>
                                        <td>ANUAL</td>
                                        <td><?php echo $listarVehiculoPorId[0]['placa'] . " - " . $listarVehiculoPorId[0]['numero_movil']; ?></td>
                                        <td><?php echo "$ " . number_format($lfsfa['valor']); ?></td>
                                        <td><?php if($lfsfa['estado'] == "P"){ echo "PENDIENTE"; }else{ echo "SALDADO";} ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } else if($_POST['frecuencia_servicio'] == "N"){
                                foreach($listarFiltroServicioSinFrecuencia As $lfssf){ 
                                    $listarConceptosId = $concepto->listarPorId($lfssf['id_concepto']); 
                                    $listarVehiculoPorId = $vehiculo->listarPorId($lfssf['id_vehiculo']); ?>
                                    <tr>
                                        <td><?php echo $listarConceptosId[0]['detalle_concepto']; ?></td>
                                        <td>NINGUNA</td>
                                        <td><?php echo $listarVehiculoPorId[0]['placa'] . " - " . $listarVehiculoPorId[0]['numero_movil']; ?></td>
                                        <td><?php echo "$ " . number_format($lfssf['valor']); ?></td>
                                        <td><?php if($lfssf['estado'] == "P"){ echo "PENDIENTE"; }else{ echo "SALDADO";} ?></td>
                                    </tr>
                                <?php } ?>
                            <?php }else{ 
                                    foreach($listarFiltroServicioFrecuenciaMensual As $lfsfm){
                                    $listarConceptosId = $concepto->listarPorId($lfsfm['id_concepto']); 
                                    $listarVehiculoPorId = $vehiculo->listarPorId($lfsfm['id_vehiculo']); ?>
                                    <tr>
                                        <td><?php echo $listarConceptosId[0]['detalle_concepto']; ?></td>
                                        <td>MENSUAL</td>
                                        <td><?php echo $listarVehiculoPorId[0]['placa'] . " - " . $listarVehiculoPorId[0]['numero_movil']; ?></td>
                                        <td><?php echo "$ " . number_format($lfsfm['valor']); ?></td>
                                        <td><?php if($lfsfm['estado'] == "P"){ echo "PENDIENTE"; }else{ echo "SALDADO";} ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        <?php } else if(($_POST['id_concepto'] == 0) && ($_POST['id_vehiculo'] != 0) && ($_POST['id_cuenta'] == 0)){ ?>
                            <?php foreach($listarFiltroEstadoCuentaVehiculo As $lfecv){
                                $listarConceptosId = $concepto->listarPorId($lfecv['id_concepto']); 
                                $listarVehiculoPorId = $vehiculo->listarPorId($lfecv['id_vehiculo']); ?>
                                <tr>
                                    <td><?php echo $listarVehiculoPorId[0]['placa'] . " - " . $listarVehiculoPorId[0]['numero_movil']; ?></td>
                                    <td><?php echo $listarConceptosId[0]['detalle_concepto']; ?></td>
                                    <td><?php if($listarConceptosId[0]['frecuencia'] == "A"){ echo "ANUAL"; }else{ echo "MENSUAL"; } ?></td>
                                    <td>    
                                        <?php 
                                            $fechaCobroServicio = explode("-", $lfecv['fecha_cobro']); 
                                            echo $fechaCobroServicio[2] . " DE " . strtoupper(mes($fechaCobroServicio[1])) . " DEL " . $fechaCobroServicio[0]; 
                                        ?>
                                    </td>
                                    <td><?php echo "$ " . number_format($lfecv['valor']); ?></td>
                                    <td><?php if($lfecv['estado'] == "P"){ echo "PENDIENTE"; }else{ echo "SALDADO";} ?></td>
                                </tr>
                            <?php } ?>
                        <?php } else if(($_POST['id_concepto'] == 0) && ($_POST['id_vehiculo'] == 0) && ($_POST['id_cuenta'] != 0)){ ?>
                            <?php foreach($listarComprobantesPorCuentaBanco As $lcpcb){
                                $listaCobrosPorId = $concepto->listarPorIdCobrosPropietario($lcpcb['id_cobro_propietario']); 
                                $listarConceptosId = $concepto->listarPorId($listaCobrosPorId[0]['id_concepto']); 
                                $listarVehiculoPorId = $vehiculo->listarPorId($listaCobrosPorId[0]['id_vehiculo']); 
                                $listarBancosId = $concepto->listarBancosId($lcpcb['banco_consignacion']) ?>
                                <tr>
                                    <td><?php echo $listarBancosId[0]['descripcion']; ?></td>
                                    <td><?php echo $listarVehiculoPorId[0]['placa'] . " - " . $listarVehiculoPorId[0]['numero_movil']; ?></td>
                                    <td><?php echo $listarConceptosId[0]['detalle_concepto']; ?></td>
                                    <td><?php if($listarConceptosId[0]['frecuencia'] == "A"){ echo "ANUAL"; }else{ echo "MENSUAL"; } ?></td>
                                    <td>    
                                        <?php 
                                            $fechaPagoServicio = explode("-", $lcpcb['fecha_pago']); 
                                            echo $fechaPagoServicio[2] . " DE " . strtoupper(mes($fechaPagoServicio[1])) . " DEL " . $fechaPagoServicio[0]; 
                                        ?>
                                    </td>
                                    <td><?php echo "$ " . number_format($lcpcb['valor_servicio']); ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </section>

        </section>

    <!-- FIN CONTENIDO -->

    <!--**************************--->
    
    <!-- SCRIPT -->
        <?php include("Template/scripts.php"); ?>
    
        <script type="text/javascript">
        
        		$("#datepicker").MonthPicker({
        		    IsRTL: true,
        		    i18n: {
        		        months: ["Enero", "Feb", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agos", "Sept", "Oct","Nov", "Dic"],
        		        buttonText: "",
        		    }
        	    });
        	    
        	    $('#datepicker1').yearpicker({});
        	    
        	    function validarTiempoServicio(id_servicio){
            	    var parametros = {
                        "id_servicio" : id_servicio
                    };
                    
                    $.ajax({
                      	data:  parametros,
                      	url:   '../Controlador/validarTiempoCobroServicio.php',
                      	type:  'post',
                      	
                      	beforeSend: function () {
                      	},
                      	success:  function (response) {
                          	document.getElementById("servicio").innerHTML = (response);
                          	
                          	var frecuenciaServicio = document.getElementById("frecuencia_servicio").value;
                          	
                          	
                          	if(frecuenciaServicio == "A"){
                          	    document.getElementById("datepicker1").style.display = "flex";
                          	    document.getElementById("datepicker").style.display = "none";
                          	    document.getElementById("anio").style.display = "flex";
                          	    document.getElementById("mes").style.display = "none";
                          	    document.getElementById("MonthPicker_Button_datepicker").style.display = "none";
                          	}else{
                          	    document.getElementById("datepicker1").style.display = "none";
                          	    document.getElementById("datepicker").style.display = "flex";
                          	    document.getElementById("anio").style.display = "none";
                          	    document.getElementById("mes").style.display = "flex";
                          	    document.getElementById("MonthPicker_Button_datepicker").style.display = "flex";
                          	}
                          	
                      	}
                    });
        	    }
        	    
        	    function validarSeleccionFiltroPorConcepto(){
        	           
                    var id_concepto = document.getElementById("id_concepto").value;
                    var frecuenciaServicio = document.getElementById("frecuencia_servicio").value;
                    
        	        if(id_concepto != 0){
        	            $('#id_vehiculo').attr('disabled', 'disabled');
        	            $('#id_cuenta').attr('disabled', 'disabled');
        	        }else{
        	            $('#id_vehiculo').attr('disabled', false);
        	            $('#id_cuenta').attr('disabled', false);
                  	    document.getElementById("anio").style.display = "none";
                  	    document.getElementById("mes").style.display = "flex";
                  	    document.getElementById("datepicker").style.display = "flex";
                        document.getElementById("MonthPicker_Button_datepicker").style.display = "flex";
                  	    document.getElementById("datepicker1").style.display = "none";
        	        }
        	        
        	    }
        	    
        	    function validarSeleccionFiltroPorVehiculo(){
        	        
                    var id_vehiculo = document.getElementById("id_vehiculo").value;
                    
        	        if(id_vehiculo != 0){
        	            $('#id_concepto').attr('disabled', 'disabled');
        	            $('#id_cuenta').attr('disabled', 'disabled');
        	            $('#datepicker1').attr('disabled', 'disabled');
        	        }else{
        	            $('#id_concepto').attr('disabled', false);
        	            $('#id_cuenta').attr('disabled', false);
        	            $('#datepicker1').attr('disabled', false);
        	        }
        	        
        	    }
        	    
        	    function validarSeleccionFiltroPorCuentaBanco(){
        	        
                    var id_cuenta = document.getElementById("id_cuenta").value;
                    
        	        if(id_cuenta != 0){
        	            $('#id_concepto').attr('disabled', 'disabled');
        	            $('#id_vehiculo').attr('disabled', 'disabled');
        	        }else{
        	            $('#id_concepto').attr('disabled', false);
        	            $('#id_vehiculo').attr('disabled', false);
        	        }
        	        
        	    }
        </script>
    <!-- FIN SCRIPT -->

</body>
</html>

