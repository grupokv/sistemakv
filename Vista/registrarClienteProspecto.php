<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/General.php");
require_once("../Modelo/ClienteProspecto.php");

/* VARIABLES MENU*/
$titulo = 'Registrar Cliente';
$redireccion = 'clientes_prospecto.php';
$icono = 'fa fa-briefcase';


$cliente = new ClienteProspecto();

$listado_status = $cliente->listarStatus();
$listado_volumen = $cliente->listarVolumen();
$listado_frecuencia = $cliente->listarFrecuencia();
?>

<!DOCTYPE html>
<html>
<head><meta charset="gb18030">
    
	<title>SistemaKV | Registrar Cliente</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>
    
    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar Cliente</li>
         </ol>
    </div>


    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
            <!--FORMULARIO -->

	            <form method="POST" action="../Controlador/registrarClienteProspecto.php">
	            	    <?php include("Template/header-form.php"); ?>
    	        	
		                
		                    <div class="row mt-3">
		                    	<section class="label">
				     	            <label>NIT o Cedula</label>
				     	        </section>
		                    	<section class="input">
						     	    <input type="text" name="nit_cliente" id="nit_cliente"  class="form-control" onchange="validarNitCliente(this.value);"  required="required">
				     	        </section>
		                    </div>
		                    
		                    <section class="row d-flex justify-content-center">
    		                    <div class="col-10 mt-3 text-center" style="border-radius: 8px; background-color: red;" class="validarValorCliente" id="validarValorCliente">
    		                    </div>
    		                </section>

						   <div class="row mt-3">
		                    	<section class="label">
				     	            <label>Razon Social</label>
				     	        </section>
		                    	<section class="input">
                                        <input type="text" name="razon_social" id="razon_social" class="form-control" required="required">
				     	        </section>
		                    </div>

		                    <div class="row mt-3">
		                    	<section class="label">
				     	            <label>Direccion</label>
				     	        </section>
		                    	<section class="input">
						     	    <input type="text" name="direccion" id="direccion" class="form-control" required="required">
				     	        </section>
		                    </div>

		                    <div class="row mt-3">
		                    	<section class="label">
				     	            <label>Telefono</label>
				     	        </section>
		                    	<section class="input">
						     	    <input type="text" name="telefono" id="telefono" class="form-control" required="required">
				     	        </section>
		                    </div>

		                    <div class="row  mt-3 ">
		                    	<section class="label">
				     	            <label>Status</label>
				     	        </section>
		                    	<section class="input">
						     	    <select name="status" id="status" class="form-control" required="required">
								        <option>Seleccionar</option>
								        <?php foreach ($listado_status as $ls){ ?>
								        	<option value="<?php echo $ls['id_status'] ?>">
								        		<?php echo $ls['detalle_status'] ?>
								        	</option>
								        <?php } ?>
								    </select>
								 </section>
		                    </div>

		                    <div class="row  mt-3 ">
		                    	<section class="label">
				     	            <label>Volumen Venta</label>
				     	        </section>
		                    	<section class="input">
						     	    <select name="volumen" id="volumen" class="form-control" required="required">
								        <option>Seleccionar</option>
								        <?php foreach ($listado_volumen as $lv){ ?>
								        	<option value="<?php echo $lv['id_volumen'] ?>">
								        		<?php echo $lv['detalle_volumen'] ?>
								        	</option>
								        <?php } ?>
								    </select>
								 </section>
		                    </div>
							
							<div class="row  mt-3 ">
		                    	<section class="label">
				     	            <label>Frecuencia Compra</label>
				     	        </section>
		                    	<section class="input">
						     	    <select name="frecuencia" id="frecuencia" class="form-control" required="required">
								        <option>Seleccionar</option>
								        <?php foreach ($listado_frecuencia as $lf){ ?>
								        	<option value="<?php echo $lf['id_frecuencia'] ?>">
								        		<?php echo $lf['detalle_frecuencia'] ?>
								        	</option>
								        <?php } ?>
								    </select>
								 </section>
		                    </div>

		                <hr>
            
                        <?php include("Template/bottom-form.php"); ?>
	            </form> 
        </div>
    </section>



    <?php include("Template/scripts.php"); ?>

	<script type="text/javascript">
	
	   function validarNitCliente(nit_cliente){
            var parametros = {
                "nit_cliente" : nit_cliente
            };
            $.ajax({
                data:  parametros,
                url:   '../Controlador/ValidarRegistroClienteProspecto.php',
                type:  'post',
                beforeSend: function () {
                    //alert('envio');
                },
                success:  function (response) {
                    //alert(response);
                    $("#validarValorCliente").html(response);
                    var valorVerificar = document.getElementById('valorVerificar').value;
                    
                    if(valorVerificar == 2){
						
                        $("#validarValorCliente").html("<p class='mt-3' style='color:#fff;'>Ya se encuentra registrado un cliente con el NIT O CEDULA diligenciado</p>");
						$("#razon_social").attr("disabled","disabled");  
                        $("#direccion").attr("disabled","disabled");                      
                        $("#telefono").attr("disabled","disabled");
						$("#status").attr("disabled","disabled");
						$("#volumen").attr("disabled","disabled");
						$("#frecuencia").attr("disabled","disabled");
						$("#guardar").attr("disabled","disabled");						
                          
                    } else {
						
						$("#razon_social").removeAttr("disabled");
                        $("#direccion").removeAttr("disabled");                     
                        $("#telefono").removeAttr("disabled");
						$("#status").removeAttr("disabled");
						$("#volumen").removeAttr("disabled");
						$("#frecuencia").removeAttr("disabled");
						$("#guardar").removeAttr("disabled");
						
                    }
                   
                }
            });
        }

	</script>


</body>
</html>