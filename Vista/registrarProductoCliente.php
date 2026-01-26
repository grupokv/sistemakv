<?php

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Contrato.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/TipoVehiculo.php");


$cliente = new Cliente();
$listadoClientes = $cliente->listar();

$tipoVehiculo = new TipoVehiculo();
$listarTV = $tipoVehiculo->listar();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Producto</title>
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
        
    </style>

</head>
<body>

    <?php include("Template/header.php"); ?>
    <?php include("Template/newMenu.php"); ?>



    <section class="home_content">  
    	<div aria-label="breadcrumb" class="mt-1"> 
            <ol class="breadcrumb" style="background: #fff;">
                <li class="breadcrumb-item"><a href="inicio.php">Inicio</a></li>
                <li class="breadcrumb-item"><a href="productosClientes.php">Base Servicios</a></li>
                <li class="breadcrumb-item active" aria-current="page">Nuevo Producto</li>
            </ol>
        </div>
        
        <div class="notice notice-sistemakv">
            <strong><i class="fa fa-car mr-3" style="font-size: 2rem;"></i>NUEVO PRODUCTO CLIENTE</strong>
        </div>

        <section class="form-usuarios mt-1 p-3 mb-2">
            <div class="formulario mt-3 mb-3" style="width: 100%;">
    	        <form action="../Controlador/registrarProductoCliente.php" method="POST" id="registroVehi" enctype="multipart/form-data">
    	        	<div id="tabs">

                        <ul>
                          <li><a href="#tabs-1">Información </a></li>
                          <li><a href="#tabs-2">Tarifas</a></li>
                        </ul>

                        <!-- INFORMACION BASICA-->
                            <div id="tabs-1" class="p-3">
                                
                            	<!-- CLIENTE -->
                                    <div class="row mt-4">
                                        <div class="label">
                                            <label>Cliente</label>
                                        </div>
                                        <div class="input">
                                            <select class="form-control selectpicker" data-live-search="true" name="id_cliente" id="id_cliente" required="required" onchange="validarContratosCliente(this.value); validarClasesVehiculosCliente(this.value);">
                                                <option value="">SELECCIONAR</option>
                                                <?php foreach ($listadoClientes as $lc){ ?>
                                                    <option value="<?php echo $lc['id_cliente']; ?>">
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
                                            <input class="form-control" name="detalle_producto" id="detalle_producto" style="border-style: dashed;" required="required">
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
                                                <option value="URBANO">URBANO</option>
                                                <option value="INTERMUNICIPAL">INTERMUNICIPAL</option>
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
                                                <option value="TODOS">TODOS</option>
                                                <option value="DIAS_HABILES">DÍAS HÁBILES</option>
                                                <option value="DIAS_HABILES_SABADOS">DÍAS HÁBILES + SABADOS</option>
                                                <option value="DIAS_HABILES_SABADOS">DÍAS ALEATORIOS</option>
                                            </select>
                                        </div>              
                                    </div>
                                    
                                          
                            	<!-- DIA DE CORTE -->
                                    <div class="row mt-4">
                                        <div class="label">
                                            <label>Día de Corte</label>
                                        </div>
                                        <div class="input">
                                            <input class="form-control" name="dia_corte" id="dia_corte" style="border-style: dashed;">
                                        </div>              
                                    </div>

					            
                            	<!-- REQUISITOS -->
                                    <div class="row mt-4">
                                        <div class="label">
                                            <label>Observaciones</label>
                                        </div>
                                        <div class="input">
                                            <textarea class="form-control" id="observaciones" name="observaciones" style="border-style: dashed;"></textarea>
                                        </div>              
                                    </div>
                                
                                    
                            </div>

                        <!-- TARIFAS-->
                            <div id="tabs-2">
                                
                            </div>

                    </div>

                    <!-- BOTONES -->
                    
                        <section class="col-12 mt-5 d-flex justify-content-center">
                          
                            <!-- CANCELAR REGISTRO -->
                                <a href="productosClientes.php" class="btn btn-outline-danger col-xs-12 col-sm-12 col-md-3 mr-3">Cancelar</a>
                          
                            <!-- REGISTRAR -->
                                <button type="submit" id="Registrar" class="btn btn-outline-success col-xs-12 col-sm-12 col-md-3">Registrar</button>
                      
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
        
        function validarClasesVehiculosCliente(value){
            var parametros = {
                "id_cliente" : value,
            };
            $.ajax({
                data:  parametros, 
                url:   '../Controlador/listarClasesMovilClientesID.php',
                type:  'POST', 
                beforeSend: function () {
                    $("#tabs-2").html("Procesando, espere por favor...");
                },
                success:  function (response) { 
                    //alert(response);
                    $("#tabs-2").html(response);
                }
            });
        }
        
        
    </script>
    
</body>
</html>