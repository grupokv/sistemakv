<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/CentroCostoCliente.php");
/* VARIABLES MENU*/

$titulo = 'Registrar Destino Cliente';
$redireccion = 'destino_cliente.php';
$icono = 'fa fa-briefcase';

$cliente = new Cliente();
$listarC = $cliente->listar();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Destino Cliente</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>

	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="destino_cliente.php">Destino Cliente</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar Destino</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="formulario mb-5">
            <form action="../Controlador/registrarDestinoCliente.php" method="POST">
				<?php include("Template/header-form.php"); ?> 
					<!--NOMBRE CARGO-->
						<div class="row mt-3">
						    <div class="label">
							    <label>Nombre</label>
						    </div>
						    <div class="input">
						        <input type="text" name="detalle" id="detalle" class="form-control">
						    </div>
						</div>
					        
					
						<div class="row mt-3">
						    <div class="label">
						        <label>Cliente</label>
						    </div>
						    <div class="input">
						        <select class="form-control selectpicker" data-live-search="true" name="id_cliente" id="id_cliente" onchange="cargar(this.value)">
						        	<option>Seleccionar </option>
						        	<?php foreach ($listarC as $la){ ?>
						        		<option value="<?php echo $la['id_cliente'] ?>">
						        			<?php echo $la['razon_social'] ?>
						        		</option>
						        	<?php } ?>
						        </select>
						    </div>
						</div>

						<div class="row mt-3">
						    <div class="label">
						        <label>Centro Costo</label>
						    </div>
						    <div class="input">
						        <select class="form-control" name="id_centro_costo" id="id_centro_costo">
						        </select>
						    </div>
						</div>
				<?php include("Template/bottom-form.php"); ?>
            </form>
        </div>
    </section>

    <?php include("Template/scripts.php"); ?>
 <script>

        function cargar(id_cliente){

          //alert(id_cliente); 

          if(id_cliente != ''){

              var parametros = {

                "id_cliente" : id_cliente

              };

              $.ajax({

                  data:  parametros,

                  url:   '../Controlador/listarCentroCostosCliente.php',

                  type:  'post',

                  beforeSend: function () {

                      //alert('envio');

                      $("#id_centro_costo").html("<option value='' disabled='disabled' selected='selected'>Cargando datos, por favor espere</option>");

                  },

                  success:  function (response) {

                      //alert(response);

                      $("#id_centro_costo").html(response);

                  }

              });

          }

        }        

    </script>
</body>
</html>

