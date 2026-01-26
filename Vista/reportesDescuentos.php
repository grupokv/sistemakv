<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/ConceptosCobro.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/Cartera.php");

$cartera = new Cartera();

$vehiculo = new Vehiculo();
$listarVehiculo = $vehiculo->listarVehiculosVinculados();

$cliente = new Cliente();
$listarClientes = $cliente->listar();

$concepto = new ConceptoCobro();
$listarConceptos = $concepto->listar();

if($_POST){
    if(($_POST['id_vehiculo'] != 0) && ($_POST['id_cliente'] == 0) && ($_POST['id_concepto'] == 0)){
        $id_vehiculo = $_POST['id_vehiculo'];
        $listarReporteDescuentosPorVehiculo = $cartera->listarReporteDescuentosPorVehiculo($id_vehiculo);
    }else if(($_POST['id_vehiculo'] == 0) && ($_POST['id_cliente'] != 0) && ($_POST['id_concepto'] == 0)){
        $id_cliente = $_POST['id_cliente'];
        $listarReporteDescuentosPorNomina = $cartera->listarReporteDescuentosPorNomina($id_cliente);
    }else if(($_POST['id_vehiculo'] == 0) && ($_POST['id_cliente'] == 0) && ($_POST['id_concepto'] != 0)){
        if(($_POST['id_concepto'] != 0) && ($_POST['mes'] != "")){
            
            $id_concepto = $_POST['id_concepto'];
            $fecha_cruce = explode("/", $_POST['mes']);
            $fecha_mes_cruce = $fecha_cruce[0];
            $listarReporteDescuentosCruzadosFiltro1 = $cartera->listarReporteDescuentosCruzadosFiltro1($id_concepto, $fecha_mes_cruce);
            
        }else if(($_POST['id_concepto'] != 0) && ($_POST['mes'] == "")){
            if($_POST['id_concepto'] == 0.1){
                $listarTodosDescuentosCruzados = $cartera->listarReporteTodosDescuentosCruzados();
            }else{
                $id_concepto = $_POST['id_concepto'];
                $listarReporteDescuentosCruzadosFiltro2 = $cartera->listarReporteDescuentosCruzadosFiltro2($id_concepto);
            }
            
        }
        
    }else{
        $listarTodosDescuentos = $cartera->listarDescuentosCartera();
    }
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    
	<title>SistemaKV | Reporte Cartera</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
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
</head>
<body>

    <?php include("Template/menu.php"); ?>

	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="descuentosCartera.php">Descuentos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reporte</li>
         </ol>
    </div>
    
    
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3 titulo_reporte" style="background-color: #1b2d3b; color: #fff; border-radius: 3px; width: 96%">
        <p>FILTRAR REPORTE</p>
    </div>
    
    <form action="" method="POST">
        <hr style="background-color:#f2f2f2; width: 98%;">
        
            <div class="row p-1 m-1 d-flex justify-content-center ml-3" style="background-color: #f7f7f7; width: 98%;">
                <div class="col-sm-12 col-md-3 col-lg-3 m-1">
                    <div class="label" style="width:100%;">
                        <label><strong>POR VEHICULO</strong></label>
                    </div>
                </div>
                
                
                <div class="col-sm-12 col-md-3 col-lg-3 m-1">
                    <div class="label" style="width:100%;">
                        <label><strong>POR NOMINA</strong></label>
                    </div>
                </div>
                
                <div class="col-sm-12 col-md-3 col-lg-3 m-1">
                    <div class="label" style="width:100%;margin-left:2px">
                        <label><strong>CRUZADOS</strong></label>
                    </div>
                </div>
                
                <div class="col-sm-12 col-md-2 col-lg-2 m-1">
                    <div class="label" style="width:100%;margin-left:2px">
                        <label id="mes"><strong>MES</strong></label>
                    </div>
                </div>
            </div>
            
            <div id="servicio"></div>
            
            <div class="row p-1 m-1 d-flex justify-content-center">
                <div class="col-sm-12 col-md-3 col-lg-3 m-1 ">
                    <select class="form-control selectpicker" data-live-search="true" name="id_vehiculo" id="id_vehiculo" onchange="validarSeleccionFiltroPorVehiculo();">
                        <option value="0">SELECCIONAR </option>
                            <?php foreach ($listarVehiculo as $lv){ ?>
                                <option value="<?php echo $lv['id_vehiculo'] ?>"><?php echo $lv['placa'] ?></option>
                            <?php } ?>
                    </select>
                </div>
                
                <div class="col-sm-12 col-md-3 col-lg-3 m-1">
                    <select class="form-control selectpicker" data-live-search="true" name="id_cliente" id="id_cliente" onchange="validarSeleccionFiltroPorNomina();">
                        <option value="0">SELECCIONAR </option>
                            <?php foreach ($listarClientes as $lc){ ?>
                                <option value="<?php echo $lc['id_cliente']; ?>"><?php echo $lc['razon_social']; ?></option>
                            <?php } ?>
                    </select>
                </div>
                
                <div class="col-sm-12 col-md-3 col-lg-3 m-1">
                    <select class="form-control selectpicker" data-live-search="true" name="id_concepto" id="id_concepto" onchange="validarSeleccionFiltroPorCruceDescuentos();">
    	     	    	<option value="0">SELECCIONAR</option>
    	     	    	<option value="0.1">TODOS</option>
    				 	<?php foreach ($listarConceptos as $lc){ ?>
    				 		<option value="<?php echo $lc['id_concepto'];?>">
    				 			<?php echo $lc['detalle_concepto']; ?>
    				 		</option>
    				 	<?php } ?>
    				</select>
                </div>
                
                <div class="col-sm-12 col-md-2 col-lg-2 m-1">
                    <input type="text" name="mes" id="datepicker" class="form-control" autocomplete="off">
                </div>
                
            </div>
            
            
            
            <div class="row p-1 m-1 d-flex justify-content-center">
            	<div class="col-lg-3 col-md-3 col-sm-10 col-xs-10">
            	    <button type="submit" class="btn btn-outline-info btn-block mr-4 mt-4"><span class="fa fa-search ml-2 mr-2"></span>Filtrar</button>
            	</div>
            </div>
            
            
        <hr style="background-color:#f2f2f2; width: 98%;">
        
    </form>
    
        
    <hr style="background-color:#5e99b1;">
    
    <div class="row barra-principal">
    	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-6">
    		  <h2 class="ml-4 mt-2" style="color: #fff; line-height: 25px;"><span class="fa fa-file-text" style="border: 2px solid #fff; border-radius: 50%;  font-size:0.8em; padding: 9px;"></span> Resultado Reporte</h2>
    	</div>
    	<div class="col-lg-6 col-md-6 col-sm-4 col-xs-6 d-flex justify-content-end">
	        <?php  if(($_POST['id_vehiculo'] != 0) && ($_POST['id_cliente'] == 0) && ($_POST['id_concepto'] == 0)){ ?>
	            <form action="exportarExcelReporteDescuentosCartera.php" method="POST">
	                <input type="hidden" class="form-control" name="filtro" id="filtro" value="V"/>
	                <input type="hidden" class="form-control" name="vehiculo" id="vehiculo" value="<?php echo $_POST['id_vehiculo']; ?>"/>
    	            <button type="submit" class="btn mr-4 boton-registro" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;"><span class="fa fa-download ml-2 mr-2"></span>Exportar</button>
    	        </form>
    	    <?php }else if(($_POST['id_vehiculo'] == 0) && ($_POST['id_cliente'] != 0) && ($_POST['id_concepto'] == 0)){ ?>
	            <form action="exportarExcelReporteDescuentosCartera.php" method="POST">
	                <input type="hidden" class="form-control" name="filtro" id="filtro" value="NC"/>
	                <input type="hidden" class="form-control" name="cliente" id="cliente" value="<?php echo $_POST['id_cliente']; ?>"/>
	                
    	            <button type="submit" class="btn mr-4 boton-registro" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;"><span class="fa fa-download ml-2 mr-2"></span>Exportar</button>
    	        </form>
    	    <?php }else if(($_POST['id_vehiculo'] == 0) && ($_POST['id_cliente'] == 0) && ($_POST['id_concepto'] != 0)){ 
    	        if($_POST['id_concepto'] == 0.1) { ?>
    	            <form action="exportarExcelReporteDescuentosCartera.php" method="POST">
    	                <input type="hidden" class="form-control" name="filtro" id="filtro" value="TC"/>
    	                <input type="hidden" class="form-control" name="concepto" id="concepto" value="<?php echo $_POST['id_concepto']; ?>"/>
        	            <button type="submit" class="btn mr-4 boton-registro" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;"><span class="fa fa-download ml-2 mr-2"></span>Exportar</button>
        	        </form>
    	        <?php }else{ ?>
    	            <form action="exportarExcelReporteDescuentosCartera.php" method="POST">
    	                <input type="hidden" class="form-control" name="filtro" id="filtro" value="DC"/>
    	                <input type="hidden" class="form-control" name="concepto" id="concepto" value="<?php echo $_POST['id_concepto']; ?>"/>
    	                <input type="hidden" class="form-control" name="fecha_mes" id="fecha_mes" value="<?php echo $_POST['mes']; ?>"/>
    	                
        	            <button type="submit" class="btn mr-4 boton-registro" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;"><span class="fa fa-download ml-2 mr-2"></span>Exportar</button>
        	        </form>
    	        <?php } ?>
    	    <?php }else{ ?>
    	        <form action="exportarExcelReporteDescuentosCartera.php" method="POST">
	                <input type="hidden" class="form-control" name="filtro" id="filtro" value="GD"/>
    	            <button type="submit" class="btn mr-4 boton-registro" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;"><span class="fa fa-download ml-2 mr-2"></span>Exportar</button>
    	        </form>
    	    <?php } ?>
    	</div>
    </div>
    
    <hr style="background-color:#5e99b1;">
    
    <div class="mt-2 p-4 table-responsive">
    	<table  id="dataT" class="table table-hover table-sm display text-center" style="width:100%">
    		<thead>
    		    <?php if((($_POST['id_concepto'] != 0) & ($_POST['mes'] != "")) || (($_POST['id_concepto'] != 0) & ($_POST['mes'] == ""))){ ?>
    		        <tr>
                        <th>ID DESCUENTO</th>
                        <th>VEHICULO</th>
        				<th>CONCEPTO</th>
                        <th>DESCUENTO</th>
                        <th>PERIODO VALIDO DEL DESCUENTO</th>
                        <th>DESCUENTO DE NOMINA</th>
                        <th>CLIENTE</th>
                        <th>ESTADO</th>
                        <th>FECHA CRUCE</th>
        			</tr>
    		    <?php } else { ?>
    		        <tr>
                        <th>ID DESCUENTO</th>
                        <th>VEHICULO</th>
        				<th>CONCEPTO</th>
                        <th>DESCUENTO</th>
                        <th>PERIODO VALIDO DEL DESCUENTO</th>
                        <th>DESCUENTO DE NOMINA</th>
                        <th>CLIENTE</th>
                        <th>ESTADO</th>
        			</tr>
    		    <?php } ?>
    		    
    		</thead>
    		<tbody>
    		    <?php if(($_POST['id_vehiculo'] != 0) && ($_POST['id_cliente'] == 0) && ($_POST['id_concepto'] == 0)){
    		        foreach($listarReporteDescuentosPorVehiculo As $lrdpb){ ?>
        				<tr>   
                            <td><?php echo $lrdpb['id_descuento']; ?></td>
                            <td>
                                <?php 
                                    $listarVehiculoPorId = $vehiculo->listarPorId($lrdpb['id_vehiculo']);
                                    echo $listarVehiculoPorId[0]['placa'] . " - " . $listarVehiculoPorId[0]['numero_movil']; 
                                ?>
                            </td>
                            <td>
                                <?php 
                                    $listarConceptosPorId = $concepto->listarPorId($lrdpb['id_concepto']);
                                    echo $listarConceptosPorId[0]['detalle_concepto']; 
                                ?>
                            </td>
                            <td><?php if($lrdpb['tipo_descuento'] == "PORCENTAJE"){ echo "%" . $lrdpb['descuento']; }else{ echo "$ " . number_format($lrdpb['descuento']); } ?></td>
                            <td>
                                <?php 
                                    $datetime1 = date_create($lrdpb['fecha_inicial_valido']); 
                                    $datetime2 = date_create($lrdpb['fecha_final_valido']); 
                                    $diferencia = date_diff($datetime1, $datetime2);
                                    echo $diferencia->format('%R%a Dias validos.') . " | " . $lrdpb['fecha_inicial_valido'] . " - " . $lrdpb['fecha_final_valido']; 
                                
                                ?>
                            </td>
                            <td><?php echo $lrdpb['descuento_nomina']; ?></td>
                            <td>
                                <?php 
                                    $listarClienteId = $cliente->cliente_ID($lrdpb['id_cliente']);
                                    echo $listarClienteId[0]['id_cliente'] . " - " . $listarClienteId[0]['razon_social']; 
                                ?>
                            </td>
                            <td>
                                <?php if($lrdpb['estado'] == "A"){ ?>
                                    <span style="color: green; font-size:1.4rem;" class="fa fa-check-circle-o "></span> ACTIVO</p>
                                <?php }else{ ?>
                                    <p><span style="color: red; font-size:1.4rem;" class="fa fa-times-circle "></span> INACTIVO</p>
                                <?php } ?>
                            </td>
                        </tr>    
                    <?php } ?>
                <?php } else if(($_POST['id_vehiculo'] == 0) && ($_POST['id_cliente'] != 0) && ($_POST['id_concepto'] == 0)){
                    foreach($listarReporteDescuentosPorNomina As $lrdpn){ ?>
                        <tr>   
                            <td><?php echo $lrdpn['id_descuento']; ?></td>
                            <td>
                                <?php 
                                    $listarVehiculoPorId = $vehiculo->listarPorId($lrdpn['id_vehiculo']);
                                    echo $listarVehiculoPorId[0]['placa'] . " - " . $listarVehiculoPorId[0]['numero_movil']; 
                                ?>
                            </td>
                            <td>
                                <?php 
                                    $listarConceptosPorId = $concepto->listarPorId($lrdpn['id_concepto']);
                                    echo $listarConceptosPorId[0]['detalle_concepto']; 
                                ?>
                            </td>
                            <td><?php if($lrdpn['tipo_descuento'] == "PORCENTAJE"){ echo "%" . $lrdpn['descuento']; }else{ echo "$ " . number_format($lrdpn['descuento']); } ?></td>
                            <td>
                                <?php 
                                    $datetime1 = date_create($lrdpn['fecha_inicial_valido']); 
                                    $datetime2 = date_create($lrdpn['fecha_final_valido']); 
                                    $diferencia = date_diff($datetime1, $datetime2);
                                    echo $diferencia->format('%R%a Dias validos.') . " | " . $lrdpn['fecha_inicial_valido'] . " - " . $lrdpn['fecha_final_valido']; 
                                
                                ?>
                            </td>
                            <td><?php echo $lrdpn['descuento_nomina']; ?></td>
                            <td>
                                <?php 
                                    $listarClienteId = $cliente->cliente_ID($lrdpn['id_cliente']);
                                    echo $listarClienteId[0]['id_cliente'] . " - " . $listarClienteId[0]['razon_social']; 
                                ?>
                            </td>
                            <td>
                                <?php if($lrdpn['estado'] == "A"){ ?>
                                    <span style="color: green; font-size:1.4rem;" class="fa fa-check-circle-o "></span> ACTIVO</p>
                                <?php }else{ ?>
                                    <p><span style="color: red; font-size:1.4rem;" class="fa fa-times-circle "></span> INACTIVO</p>
                                <?php } ?>
                            </td>
                        </tr> 
                    <?php } ?>
                <?php } else if(($_POST['id_vehiculo'] == 0) && ($_POST['id_cliente'] == 0) && ($_POST['id_concepto'] != 0)){ 
                    if(($_POST['id_concepto'] != 0) & ($_POST['mes'] != "")){ 
                        foreach($listarReporteDescuentosCruzadosFiltro1 As $lrdcf1){ ?>
                            <tr>   
                                <td><?php echo $lrdcf1['id_descuento']; ?></td>
                                <td>
                                    <?php 
                                        $listarVehiculoPorId = $vehiculo->listarPorId($lrdcf1['id_vehiculo']);
                                        echo $listarVehiculoPorId[0]['placa'] . " - " . $listarVehiculoPorId[0]['numero_movil']; 
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        $listarConceptosPorId = $concepto->listarPorId($lrdcf1['id_concepto']);
                                        echo $listarConceptosPorId[0]['detalle_concepto']; 
                                    ?>
                                </td>
                                <td><?php if($lrdcf1['tipo_descuento'] == "PORCENTAJE"){ echo "%" . $lrdcf1['descuento']; }else{ echo "$ " . number_format($lrdcf1['descuento']); } ?></td>
                                <td>
                                    <?php 
                                        $datetime1 = date_create($lrdcf1['fecha_inicial_valido']); 
                                        $datetime2 = date_create($lrdcf1['fecha_final_valido']); 
                                        $diferencia = date_diff($datetime1, $datetime2);
                                        echo $diferencia->format('%R%a Dias validos.') . " | " . $lrdcf1['fecha_inicial_valido'] . " - " . $lrdcf1['fecha_final_valido']; 
                                    
                                    ?>
                                </td>
                                <td><?php echo $lrdcf1['descuento_nomina']; ?></td>
                                <td>
                                    <?php 
                                        $listarClienteId = $cliente->cliente_ID($lrdcf1['id_cliente']);
                                        echo $listarClienteId[0]['id_cliente'] . " - " . $listarClienteId[0]['razon_social']; 
                                    ?>
                                </td>
                                <td>
                                    <?php if($lrdcf1['estado'] == "A"){ ?>
                                        <span style="color: green; font-size:1.4rem;" class="fa fa-check-circle-o "></span> ACTIVO</p>
                                    <?php }else{ ?>
                                        <p><span style="color: red; font-size:1.4rem;" class="fa fa-times-circle "></span> INACTIVO</p>
                                    <?php } ?>
                                </td>
                                <td><?php echo $lrdcf1['fecha_cruce']; ?></td>
                            </tr> 
                        <?php } ?>
                    <?php } else if(($_POST['id_concepto'] != 0) & ($_POST['mes'] == "")){ 
                        if($_POST['id_concepto'] != 0.1){
                            foreach($listarReporteDescuentosCruzadosFiltro2 As $lrdcf2){ ?>
                                <tr>   
                                    <td><?php echo $lrdcf2['id_descuento']; ?></td>
                                    <td>
                                        <?php 
                                            $listarVehiculoPorId = $vehiculo->listarPorId($lrdcf2['id_vehiculo']);
                                            echo $listarVehiculoPorId[0]['placa'] . " - " . $listarVehiculoPorId[0]['numero_movil']; 
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            $listarConceptosPorId = $concepto->listarPorId($lrdcf2['id_concepto']);
                                            echo $listarConceptosPorId[0]['detalle_concepto']; 
                                        ?>
                                    </td>
                                    <td><?php if($lrdcf2['tipo_descuento'] == "PORCENTAJE"){ echo "%" . $lrdcf2['descuento']; }else{ echo "$ " . number_format($lrdcf2['descuento']); } ?></td>
                                    <td>
                                        <?php 
                                            $datetime1 = date_create($lrdcf2['fecha_inicial_valido']); 
                                            $datetime2 = date_create($lrdcf2['fecha_final_valido']); 
                                            $diferencia = date_diff($datetime1, $datetime2);
                                            echo $diferencia->format('%R%a Dias validos.') . " | " . $lrdcf2['fecha_inicial_valido'] . " - " . $lrdcf2['fecha_final_valido']; 
                                        
                                        ?>
                                    </td>
                                    <td><?php echo $lrdcf2['descuento_nomina']; ?></td>
                                    <td>
                                        <?php 
                                            $listarClienteId = $cliente->cliente_ID($lrdcf2['id_cliente']);
                                            echo $listarClienteId[0]['id_cliente'] . " - " . $listarClienteId[0]['razon_social']; 
                                        ?>
                                    </td>
                                    <td>
                                        <?php if($lrdcf2['estado'] == "A"){ ?>
                                            <span style="color: green; font-size:1.4rem;" class="fa fa-check-circle-o "></span> ACTIVO</p>
                                        <?php }else{ ?>
                                            <p><span style="color: red; font-size:1.4rem;" class="fa fa-times-circle "></span> INACTIVO</p>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo $lrdcf2['fecha_cruce'] . " a las " . $lrdcf2['hora_cruce']; ?></td>
                                </tr> 
                            <?php }
                        } else { 
                            foreach($listarTodosDescuentosCruzados As $ltdc){
                    
                                $listaCobrosPorId = $concepto->listarPorIdCobrosPropietario($ltdc['id_cobro']); 
                                $listarDescuentosPorId = $cartera->listarDescuentosCarteraPorId($ltdc['id_descuento']);
                                $listarVehiculoPorId = $vehiculo->listarPorId($listaCobrosPorId[0]['id_vehiculo']);
                                $listarConceptosPorId = $concepto->listarPorId($listaCobrosPorId[0]['id_concepto']);?>
                        
                                <tr>   
                                    <td><?php echo $ltdc['id_descuento']; ?></td>
                                    <td>
                                        <?php 
                                            echo $listarVehiculoPorId[0]['placa'] . " - " . $listarVehiculoPorId[0]['numero_movil']; 
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            echo $listarConceptosPorId[0]['detalle_concepto']; 
                                        ?>
                                    </td>
                                    <td><?php if($listarDescuentosPorId[0]['tipo_descuento'] == "PORCENTAJE"){ echo "%" . $listarDescuentosPorId[0]['descuento']; }else{ echo "$ " . number_format($listarDescuentosPorId[0]['descuento']); } ?></td>
                                    <td>
                                        <?php 
                                            $datetime1 = date_create($listarDescuentosPorId[0]['fecha_inicial_valido']); 
                                            $datetime2 = date_create($listarDescuentosPorId[0]['fecha_final_valido']); 
                                            $diferencia = date_diff($datetime1, $datetime2);
                                            echo $diferencia->format('%R%a Dias validos.') . " | " . $listarDescuentosPorId[0]['fecha_inicial_valido'] . " - " . $listarDescuentosPorId[0]['fecha_final_valido']; 
                                        
                                        ?>
                                    </td>
                                    <td><?php echo $listarDescuentosPorId[0]['descuento_nomina']; ?></td>
                                    <td>
                                        <?php 
                                            $listarClienteId = $cliente->cliente_ID($listarDescuentosPorId[0]['id_cliente']);
                                            echo $listarClienteId[0]['id_cliente'] . " - " . $listarClienteId[0]['razon_social']; 
                                        ?>
                                    </td>
                                    <td>
                                        <?php if($listarDescuentosPorId[0]['estado'] == "A"){ ?>
                                            <span style="color: green; font-size:1.4rem;" class="fa fa-check-circle-o "></span> ACTIVO</p>
                                        <?php }else{ ?>
                                            <p><span style="color: red; font-size:1.4rem;" class="fa fa-times-circle "></span> INACTIVO</p>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php }
                        }
                    } 
                }else{ 
                    foreach($listarTodosDescuentos As $ltd){ ?>
        				<tr>   
                            <td><?php echo $ltd['id_descuento']; ?></td>
                            <td>
                                <?php 
                                    $listarVehiculoPorId = $vehiculo->listarPorId($ltd['id_vehiculo']);
                                    echo $listarVehiculoPorId[0]['placa'] . " - " . $listarVehiculoPorId[0]['numero_movil']; 
                                ?>
                            </td>
                            <td>
                                <?php 
                                    $listarConceptosPorId = $concepto->listarPorId($ltd['id_concepto']);
                                    echo $listarConceptosPorId[0]['detalle_concepto']; 
                                ?>
                            </td>
                            <td><?php if($ltd['tipo_descuento'] == "PORCENTAJE"){ echo "%" . $ltd['descuento']; }else{ echo "$ " . number_format($ltd['descuento']); } ?></td>
                            <td>
                                <?php 
                                    $datetime1 = date_create($ltd['fecha_inicial_valido']); 
                                    $datetime2 = date_create($ltd['fecha_final_valido']); 
                                    $diferencia = date_diff($datetime1, $datetime2);
                                    echo $diferencia->format('%R%a Dias validos.') . " | " . $ltd['fecha_inicial_valido'] . " - " . $ltd['fecha_final_valido']; 
                                
                                ?>
                            </td>
                            <td><?php echo $ltd['descuento_nomina']; ?></td>
                            <td>
                                <?php 
                                    $listarClienteId = $cliente->cliente_ID($ltd['id_cliente']);
                                    echo $listarClienteId[0]['id_cliente'] . " - " . $listarClienteId[0]['razon_social']; 
                                ?>
                            </td>
                            <td>
                                <?php if($ltd['estado'] == "A"){ ?>
                                    <span style="color: green; font-size:1.4rem;" class="fa fa-check-circle-o "></span> ACTIVO</p>
                                <?php }else{ ?>
                                    <p><span style="color: red; font-size:1.4rem;" class="fa fa-times-circle "></span> INACTIVO</p>
                                <?php } ?>
                            </td>
                        </tr>    
                    <?php }
                } ?>
                
    		</tbody>
    	</table>
    </div>
    
    
    <?php include("Template/scripts.php"); ?>
    
    <script type="text/javascript">
        $("#datepicker").MonthPicker({
		    IsRTL: true,
		    i18n: {
		        months: ["Enero", "Feb", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agos", "Sept", "Oct","Nov", "Dic"],
		        buttonText: "",
		    }
	    });
	    
	    function validarSeleccionFiltroPorVehiculo(){
    	        
            var id_vehiculo = document.getElementById("id_vehiculo").value;
            
	        if(id_vehiculo != 0){
	            $('#id_concepto').attr('disabled', 'disabled');
	            $('#id_cliente').attr('disabled', 'disabled');
	            $('#datepicker').attr('disabled', 'disabled');
          	    document.getElementById("MonthPicker_Button_datepicker").style.display = "none";
	        }else{
	            $('#id_concepto').attr('disabled', false);
	            $('#id_cliente').attr('disabled', false);
	            $('#datepicker').attr('disabled', false);
          	    document.getElementById("MonthPicker_Button_datepicker").style.display = "flex";
	        }
	        
	    }
	    
	    function validarSeleccionFiltroPorNomina(){
    	        
            var id_cliente = document.getElementById("id_cliente").value;
            
	        if(id_cliente != 0){
	            $('#id_concepto').attr('disabled', 'disabled');
	            $('#id_vehiculo').attr('disabled', 'disabled');
	            $('#datepicker').attr('disabled', 'disabled');
          	    document.getElementById("MonthPicker_Button_datepicker").style.display = "none";
	        }else{
	            $('#id_concepto').attr('disabled', false);
	            $('#id_vehiculo').attr('disabled', false);
	            $('#datepicker').attr('disabled', false);
          	    document.getElementById("MonthPicker_Button_datepicker").style.display = "flex";
	        }
	        
	    }
	    
	    function validarSeleccionFiltroPorCruceDescuentos(){
    	        
            var id_concepto = document.getElementById("id_concepto").value;
            
	        if(id_concepto != 0){
	            $('#id_cliente').attr('disabled', 'disabled');
	            $('#id_vehiculo').attr('disabled', 'disabled');
	        }else{
	            $('#id_cliente').attr('disabled', false);
	            $('#id_vehiculo').attr('disabled', false);
	        }
	        
	    }
	    
	    
    </script>
</body>
</html>
