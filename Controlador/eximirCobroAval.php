<?php  
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Cartera.php");

$cartera = new Cartera();

$avales = $_POST['aval'];

for ($i=0; $i < count($avales); $i++) { 
	$eximirAvales = $cartera->eximirAvales($avales[$i]);
}

?>

<!DOCTYPE html>
<html>
<head>
		<?php include("../Vista/Template/styles.php") ?>
		<style>
			.ajs-button{
            border-radius: 5px;
            background-color: #5e99b1;
            color: #fff;
            box-shadow: none;
            border:0px;
        }

        .ajs-header{
            color: #1b2d3b !important;
        }
		</style>
	</head>
<body>
	<?php include("../Vista/Template/scripts.php"); ?>
	<script>

		function modalAviso(){
			alertify.alert('OPERACIÓN EXITOSA', '¡Se ha eximido correctamente el cobro para los vehiculos seleccionados!', function(){ window.location.href = '../Vista/avalVehiculosCartera.php'; });   
        }

        $(window).on("load", modalAviso());

	</script>
</body>
</html>
