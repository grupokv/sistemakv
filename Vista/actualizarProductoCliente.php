<?php

include ("../Controlador/Sesion/autenticar.php");

require_once("../Modelo/TipoVehiculo.php");
require_once("../Modelo/Operativo.php");
require_once("../Modelo/Contrato.php");
require_once("../Modelo/Cliente.php");

$tipoVehiculo = new TipoVehiculo();
$operativo = new Operativo();
$cliente = new Cliente();

$id_producto = $_GET['id_producto'];
$listarProductoClietePorId = $operativo->listarProductosPorID($id_producto);

$listadoClientes = $cliente->listar();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar Producto</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
    <style>

        @import url('https://fonts.googleapis.com/css2?family=Hind&display=swap');

        .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active{
            background: #5e99b1 !important;
            border: #fff;
        }

        #tabs-2{
            overflow-y: auto;
            overflow-x: auto;
        }

        table{
            font-size: .9rem;
        }
        
        th{
            border-radius: 13px;
            border: 3px solid #fff;
            background-color: #274054; 
            color: #fff;
            padding: 10px;
        }

        td{
            padding: 2px;
        }

        .input_tarifas{  
            border-radius: 4px;
            margin: 3px;
            background-color: #f5f7ff;
            border: 1px dashed #e3e3e3;
        }

        .input_tarifas::placeholder {
            color: #a1a1a1; 
            font-family: 'Hind', sans-serif;
        }
        
        .bootstrap-select {
            font-size: .9rem;
        }

    </style>

</head>
<body>

    <?php include("Template/header.php"); ?>
    <?php include("Template/newMenu.php"); ?>



    <section class="home_content">  
    	<div aria-label="breadcrumb" class="mt-1"> 
            <ol class="breadcrumb" style="background: #fff;">
                <li class="breadcrumb-item"><a href="inicio.php">Inicio</a></li>
                <li class="breadcrumb-item"><a href="productosClientes.php">Productos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Actualizar Producto</li>
            </ol>
        </div>
        
        <div class="notice notice-sistemakv">
            <strong><i class="fa fa-car mr-3" style="font-size: 2rem;"></i>ACTUALIZAR PRODUCTO CLIENTE</strong>
        </div>

        <section class="form-usuarios mt-1 p-3 mb-2">
            <div class="formulario mt-3 mb-3" style="width: 100%;">
    	        <form action="../Controlador/actualizarProductoCliente.php" method="POST" enctype="multipart/form-data">
    	        	<div id="tabs">

                        <ul>
                          <li><a href="#tabs-1">Información </a></li>
                          <li><a href="#tabs-2">Tarifas</a></li>
                        </ul>

                        <!-- INFORMACION BASICA-->
                            <div id="tabs-1" class="p-3">
                                <?php foreach ($listarProductoClietePorId as $lpci){ ?>
                                    
                                    <!-- PRODUCTO -->
                                        <input type="hidden" class="form-control form-control-sm" name="id_producto" id="id_producto" value="<?php echo $lpci['id_producto']; ?>" >

                                	<!-- CLIENTE -->
                                        <div class="row mt-4">
                                            <div class="label">
                                                <label>Cliente</label>
                                            </div>
                                            <div class="input">
                                                <select class="form-control selectpicker" data-live-search="true" name="id_cliente" id="id_cliente" required="required" onchange="validarContratosCliente(this.value);">
                                                    <option value="">SELECCIONAR</option>
                                                    <?php foreach ($listadoClientes as $lc){ ?>
                                                        <option value="<?php echo $lc['id_cliente']; ?>" <?php if($lpci['id_cliente'] == $lc['id_cliente']){ ?> selected="selected"<?php } ?>>
                                                            <?php echo $lc['razon_social'] . ' - Nit: ' . $lc['nit_cliente'];  ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>              
                                        </div>
                                        
                                	<!-- PRODUCTO -->
                                        <div class="row mt-4">
                                            <div class="label">
                                                <label>Producto</label>
                                            </div>
                                            <div class="input">
                                                <input class="form-control" name="detalle_producto" id="detalle_producto" style="border-style: dashed;" required="required" value="<?php echo $lpci['detalle_producto'] ?>">
                                            </div>              
                                        </div>

                                	<!-- TIPO PRODUCTO -->
                                        <div class="row mt-4">
                                            <div class="label">
                                                <label>Tipo Producto</label>
                                            </div>
                                            <div class="input">
                                                <select class="form-control selectpicker" data-live-search="true" name="tipo_producto" id="tipo_producto" required="required" >
                                                    <option value="">SELECCIONAR</option>
                                                    <option value="URBANO" <?php if ($lpci['tipo_producto'] == 'URBANO'){ ?> selected = "selected" <?php } ?>>URBANO</option>
                                                    <option value="INTERMUNICIPAL" <?php if ($lpci['tipo_producto'] == 'INTERMUNICIPAL'){ ?> selected = "selected" <?php } ?>>INTERMUNICIPAL</option>
                                                </select>
                                            </div>              
                                        </div>

                                	<!-- DIAS APLICADOS EN MENSUALIDAD -->
                                        <div class="row mt-4">
                                            <div class="label">
                                                <label>Días aplicados en mensualidad</label>
                                            </div>
                                            <div class="input">
                                                <select class="form-control selectpicker" data-live-search="true" name="dias_aplicados_mensualidad" id="dias_aplicados_mensualidad">
                                                    <option value="">SELECCIONAR</option>
                                                    <option value="TODOS" <?php if ($lpci['dias_aplicados_mensualidad'] == 'TODOS'){ ?> selected = "selected" <?php } ?>>TODOS</option>
                                                    <option value="DIAS_HABILES" <?php if ($lpci['dias_aplicados_mensualidad'] == 'DIAS_HABILES'){ ?> selected = "selected" <?php } ?>>DÍAS HÁBILES</option>
                                                    <option value="DIAS_HABILES_SABADOS" <?php if ($lpci['dias_aplicados_mensualidad'] == 'DIAS_HABILES_SABADOS'){ ?> selected = "selected" <?php } ?>>DÍAS HÁBILES + SABADOS</option>
                                                    <option value="DIAS_ALEATORIOS" <?php if ($lpci['dias_aplicados_mensualidad'] == 'DIAS_ALEATORIOS'){ ?> selected = "selected" <?php } ?>>DÍAS ALEATORIOS</option>
                                                </select>
                                            </div>              
                                        </div>
                                         
                                	<!-- DIA DE CORTE -->
                                        <div class="row mt-4">
                                            <div class="label">
                                                <label>Día de Corte</label>
                                            </div>
                                            <div class="input">
                                                <input class="form-control" name="dia_corte" id="dia_corte" style="border-style: dashed;" value="<?php echo $lpci['dia_corte'] ?>">
                                            </div>              
                                        </div>

                                	<!-- OBSERVACIONES -->
                                        <div class="row mt-4">
                                            <div class="label">
                                                <label>Observaciones</label>
                                            </div>
                                            <div class="input">
                                                <textarea class="form-control" id="observaciones" name="observaciones" style="border-style: dashed;"><?php echo $lpci['observaciones'] ?></textarea>
                                            </div>              
                                        </div>

                                <?php } ?>  
                            </div>

                        <!-- TARIFAS-->
                            <div id="tabs-2">
                                
                            </div>


                    </div>

                    <!-- BOTONES -->
                    
                        <section class="col-12 mt-4 d-flex justify-content-center">
                          
                            <!-- CANCELAR REGISTRO -->
                                <a href="productosClientes.php" class="btn btn-outline-danger col-xs-12 col-sm-12 col-md-3 mr-3">Cancelar</a>
                          
                            <!-- REGISTRAR -->
                                <button type="submit" id="Registrar" class="btn btn-outline-success col-xs-12 col-sm-12 col-md-3">Actualizar</button>
                      
                        </section>

    	        </form>
            <!--FIN FORMULARIO-->


            </div>
        </section>
    </section>


    <?php include("Template/scripts.php"); ?>
    <script type="text/javascript">

    	$(function() {
            $("#datepicker").datepicker({dateFormat:'yy-mm-dd'});
            $("#datepicker1").datepicker({dateFormat:'yy-mm-dd'});
        });

        $(function() {
          $("#tabs").tabs();
        }); 
        
        $('.clockpicker').clockpicker({
		    placement: 'top',
		    align: 'left',
		    donetext: 'Aplicar'
		});

		$('.clockpicker1').clockpicker({
		    placement: 'top',
		    align: 'left',
		    donetext: 'Aplicar'
		});
		
		function validarContratosCliente(value){
		    var parametros = {
                "id_cliente" : value,
            };
            $.ajax({
                data:  parametros, 
                url:   '../Controlador/listarContratosPorCliente.php',
                type:  'POST', 
                beforeSend: function () {
                    $("#id_contrato").html("<option>Procesando, espere por favor...</option>");
                },
                success:  function (response) { 
                    //alert(response);
                    $("#id_contrato").html(response);
                }
            });
		}


        $(document).ready(function(){
            
            var value = $("#id_cliente").val();
            var value2 = $("#id_producto").val();

            var parametros = {
                "id_cliente" : value,
                "id_producto" : value2
            };

            $.ajax({
                data:  parametros, 
                url:   '../Controlador/listarClasesMovilClientesIdActualizacion.php',
                type:  'POST', 
                beforeSend: function () {
                    $("#tabs-2").html("Procesando, espere por favor...");
                },
                success:  function (response) { 
                    //alert(response);
                    $("#tabs-2").html(response);
                }
            });
        });

    </script>
    
</body>
</html>