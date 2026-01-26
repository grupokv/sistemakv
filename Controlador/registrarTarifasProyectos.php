<?php 

require_once '../Modelo/Contrato.php';

$id_proyecto = $_POST['id_proyecto'];
$detalle = $_POST['detalle'];
$id_tipo_vehiculo = $_POST['id_tipo_vehiculo'];
$tiempo_cobro = $_POST['tiempo_cobro'];
$costo_servicio = $_POST['costo_servicio'];

$contrato = new Contrato();

$registrarTarifas = $contrato->registrarTarifasProyectos($id_proyecto, $detalle, $id_tipo_vehiculo, $tiempo_cobro, $costo_servicio);


include '../Vista/Template/styles.php';
 ?>

<style type="text/css" media="screen">
	@import url('https://fonts.googleapis.com/css?family=Poppins&display=swap');

body{
    background: #eeeeee;
    font-family: 'Poppins', sans-serif;
}

#registrar:hover{
	background-color: #18ad13;
	color: #fff !important;
}

#continuar:hover{
	background-color: #c40c0c;
	color: #fff !important;

}

.contenedor{
	width: 50%;
	height: 170px;
	background:  #fff;
	border-radius: 2px;

}

.linaSuperior{
	border-bottom: 4px solid #fff;
	height: 1px; 
	width: 50%;
}

.lineaInferior{
	border-bottom: 4px solid #fff; 
	height: 1px;
	width: 50%;
}

.mensaje2{
	border-left: 4px solid #eee;
	background-color: #fff;
}

@media (max-width: 768px){
	.contenedor{
		width: 95%;
		height: auto;
	}

	.linaSuperior{
		width: 95%;
	}

	.lineaInferior{
		width: 95%;
		margin-bottom: 100px; 
	}

	.mensaje1{
		margin-bottom: 3px;
	}

	.mensaje2{
		border-left: 0px;
		height: 180px;
	}
}

</style>

<div style="display: flex; justify-content: center; margin-top: 60px;">
	<div class="mb-2 linaSuperior"></div>
</div>

<div style="display: flex; justify-content: center;">
	<div class="row contenedor">
		<section class="col-sm-12 col-md-8 mensaje1">
			<div class="row justify-content-center mt-4">
                <p class="text-center mt-5" style="font-family: 'Raleway', sans-serif;">¿Desea agregar otra tarifa a este proyecto?</p>
            </div>
		</section>

		<section class="col-sm-12 col-md-4 mensaje2">
			<div class="mt-5">
				<a href="../Vista/registrarTarifasProyecto.php?id_proyecto=<?php echo $id_proyecto ?>" type="button" class="btn btn-block" id="registrar" style="border: 1px solid  #18ad13; border-radius: 18px; color:  #18ad13;  ">Agregar</a>
				<a href="../Vista/contratos.php" type="button" class="btn btn-block" id="continuar" style="border: 1px solid #c40c0c; border-radius: 18px; color: #c40c0c; ">Finalizar</a>
			</div>
		</section>
	</div>
</div>

<div style="display: flex; justify-content: center;">
	<div class="mt-2 lineaInferior"></div>
</div>

<?php include '../Vista/Template/scripts.php'; ?>