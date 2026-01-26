<?php 
include ("../Controlador/Sesion/autenticar.php");

$id_flota_propia = $_GET['id_flota_propia'];

$titulo = 'Asignar descuentos al detalle';
$redireccion = 'registrarDetalleFlotaPropia.php';
$icono = 'fa fa-file-text-o';

 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>SistemaKV | Asignar usuarios</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php include("Template/styles.php"); ?>
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar Flota Propia</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="formulario mb-5">
        	<form action="../Controlador/registrarDescuentosFlotaPropia.php" method="POST">
                <?php include("Template/header-form.php"); ?>   
                    <div class="row m-3">
                        	<div class="label">
                        		<label>¿Cuantos descuentos desea agregar al detalle?</label>
                        	</div>
                        	<div class="input ml-3">
                        		<input type="text" name="cantidad_descuentos" id="cantidad_descuentos" class="form-control" onkeyup="crearFilaDescuentos()">

                        		<input type="hidden" name="id_flota_propia" id="id_flota_propia" class="form-control" value="<?php echo $id_flota_propia ?>">
                        	</div>	
                    </div>

                    <table id="input-group" class="table">
                        
      				</table>
                <?php include("Template/bottom-form.php"); ?>
            </form>
        </div>
    </section>

    <?php include("Template/scripts.php"); ?>
    <script type="text/javascript">
    	function crearFilaDescuentos(){

            var cantidad_descuentos = document.getElementById('cantidad_descuentos').value;

            if(cantidad_descuentos > 0){
			    var parametros = {
			       "cantidad_descuentos" : cantidad_descuentos
			    };

			    $.ajax({
			        data:  parametros, //datos que se envian a traves de ajax
			        url:   '../Controlador/crearFilaDescuentos.php', //archivo que recibe la peticion
			        type:  'post', //método de envio
			        beforeSend: function () {
			                $("#input-group").html("Procesando, espere por favor...");
			        },
			        success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
			                /*alert(response);*/
			                $("#input-group").html(response);
			        }
			    });
 			}
    	}



    </script>

</body>
</html>
</html>