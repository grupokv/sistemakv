<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/Vehiculo.php';
require_once '../Modelo/ConceptosCobro.php';
require_once '../Modelo/Cliente.php';

$vehiculo = new Vehiculo();
$listarVehiculosVinculados = $vehiculo->listarVehiculosVinculados();

$conceptoCobro = new ConceptoCobro();
$listarConceptos = $conceptoCobro->listar();

$cliente = new Cliente();
$listarClientes = $cliente->listar();



/* VARIABLES MENU*/
$titulo = 'Registrar Descuento';
$redireccion = 'actas.php';
$icono = 'fa fa-file-text';

?>
<!DOCTYPE html>
<html>
<head><meta charset="euc-kr">
    
	<title>SistemaKV | Registrar Descuento</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="descuentosCartera.php">Descuentos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar Descuento</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="formulario mb-5">
	        <form action="../Controlador/registrarDescuentoCartera.php" method="POST" onsubmit="return validar()">
				<?php include("Template/header-form.php"); ?> 
                            
                    <!--CONCEPTO-->
                        <div class="row mt-3">
        	                <div class="label">
        		                <label>¿ Es un descuento por nomina?</label>
        	                </div>
        	                <div class="input" id="descuentoNomina">
        	                    <select name="nomina" id="nomina" class="form-control" onchange="validarDescuento();">
                                    <option value="0">SELECCIONAR</option>
                                    <option value="S">SI</option>
                                    <option value="N">NO</option>
                                </select>
        	                </div>      		
                        </div>
                    
                    <!--CONCEPTO-->
                        <div class="row mt-3" id="cliente" style="display:none;">
        	                <div class="label">
        		                <label>Cliente</label>
        	                </div>
        	                <div class="input">
        	                    <select name="id_cliente" id="id_cliente" class="form-control selectpicker" data-live-search="true">
                                    <option value="0">SELECCIONAR</option>
                                    <?php foreach($listarClientes As $lc) { ?>
                                        <option value="<?php echo $lc['id_cliente']; ?>"><?php echo $lc['razon_social']; ?></option>
                                    <?php } ?>
                                </select>
        	                </div>      		
                        </div>
                            
                	<!--VEHICULO-->
                        <div class="row mt-3">
        	                <div class="label">
        		                <label>Vehiculo</label>
        	                </div>
        	                <div class="input">
        	                    <select name="id_vehiculo" id="id_vehiculo" required="required" class="form-control selectpicker" data-live-search="true" onchange="cargarConceptosCobrosPorVehiculo(this.value); cargarPropietario(this.value);">
                                    <option class="0">SELECCIONAR</option>
                                    <?php foreach($listarVehiculosVinculados As $lvv){ ?>
                                        <option value="<?php echo $lvv['id_vehiculo'] ?>"><?php echo $lvv['placa'] . ' | N° MOVIL ' . $lvv['numero_movil'] ?></option>
                                    <?php } ?>
                                </select>
        	                </div>      		
                        </div>

		                    <!--CONCEPTO-->
		                        <div class="row mt-3">
		        	                <div class="label">
		        		                <label>Concepto</label>
		        	                </div>
		        	                <div class="input">
		        	                    <select name="id_concepto" id="id_concepto" class="form-control">
                                            
                                        </select>
		        	                </div>      		
		                        </div>
		                        
		                    <!--TIPO DESCUENTO-->
		                        <div class="row mt-3">
		        	                <div class="label">
		        		                <label>Tipo Descuento</label>
		        	                </div>
		        	                <div class="input">
		        	                    <select name="tipo_descuento" id="tipo_descuento" class="form-control">
                                            <option value="0">SELECCIONAR</option>
                                            <option value="PORCENTAJE">PORCENTAJE (%)</option>
                                            <option value="FIJO">VALOR FIJO ($)</option>
                                        </select>
		        	                </div>      		
		                        </div>
		                        
		                    <!--DESCUENTO-->
		                        <div class="row mt-3">
		        	                <div class="label">
		        		                <label>Descuento</label>
		        	                </div>
		        	                <div class="input">
		        	                    <input type="text" class="form-control" name="descuento" id="descuento"/>
		        	                </div>      		
		                        </div>
		                        
		                   
		                    <!--PERIODO DE VALIDEZ-->
		                        <div class="row mt-3">
		        	                <div class="label">
		        		                <label>Periodo de Validez</label>
		        	                </div>
		        	                <div class="row d-flex justify-content-center">
		        	                	<div class="col-6">
											 <input type="text" name="fecha_inicial" id="datepicker" class="form-control" required="required">
		        	                	</div>
		        	                	<div class="col-6">
											 <input type="text" name="fecha_final" id="datepicker1" class="form-control" required="required">
		        	                	</div>
		        	                </div>      		
		                        </div>

			    <?php include("Template/bottom-form.php"); ?>
	        </form>
        </div>
    </section>


    <?php include("Template/scripts.php"); ?>
    <script type="text/javascript">

    	$( function() {
            $("#datepicker").datepicker({ dateFormat:'yy-mm-dd'});
            $("#datepicker1").datepicker({ dateFormat:'yy-mm-dd'});
        } );


        function validar(){
        	document.getElementById('guardar').innerHTML = 'Por favor espere';
    		document.getElementById('guardar').disabled = true;

        	return true;
        }
        
        function validarDescuento(){
        	var nomina = document.getElementById('nomina').value;
        	
        	if(nomina == "S"){
        	    document.getElementById("cliente").style.display = "flex";
        	}else{
        	    document.getElementById("cliente").style.display = "none";
        	}
        }
        
        
        function cargarConceptosCobrosPorVehiculo(id_vehiculo){
            var parametros = {
                "id_vehiculo" : id_vehiculo
            };
            $.ajax({
                data:  parametros,
                url:   '../Controlador/cargarConceptosCobrosPorV.php',
                type:  'post',
                beforeSend: function () {
                    //alert('envio');
                    $("#id_concepto").html("<option value=''>Procesando, espere por favor...</option>");
                },
                success:  function (response) {
                    //alert(response);
                    $("#id_concepto").html(response);
                }
            });
            
        }

    </script>
</body>
</html>