<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/TipoVehiculo.php';
require_once '../Modelo/Contrato.php';


$id_proyecto = $_GET['id_proyecto'];

    $id = '';
    $titulo = '';
    $icono = '';
	$redireccion = '';

/* VARIABLES MENU*/
$titulo .= 'Actualizar Proyecto';
$redireccion .= 'contratos.php';
$icono .= 'fa fa-gears';

$contrato = new Contrato();
$listarProyectoPorId = $contrato->listarProyectosPorId($id_proyecto);


$tipoVehiculo = new TipoVehiculo();
$listarTiposVehiculos = $tipoVehiculo->listar();


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar Proyecto</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>
    
    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="Contratos.php">Contratos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar Proyecto</li>
         </ol>
    </div>


    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
            <!--FORMULARIO -->

	            <form action="../Controlador/actualizarProyectoContratos.php" method="POST">
	            	
	            	<?php include("Template/header-form.php"); ?>

                    <?php foreach ($listarProyectoPorId as $lppi){ ?>
                        

	            		<input type="hidden" class="form-control" name="id_proyecto" id="id_proyecto" value="<?php echo $id_proyecto ?>">
                        <input type="hidden" class="form-control" name="id_contrato" id="id_contrato" value="<?php echo $lppi['id_contrato'] ?>">

			            <!-- Nombre Proyecto -->

		                    <div class="row mt-3">
		                    	<section class="label">
				     	            <label>Nombre Proyecto</label>
				     	        </section>
		                    	<section class="input">
                                        <input type="text" name="nombre_proyecto" id="nombre_proyecto" class="form-control" required="true" value="<?php echo $lppi['nombre_proyecto'] ?>">
				     	        </section>
		                    </div>

                        <hr>

                    <?php } ?>
          
                    <?php include("Template/bottom-form.php"); ?>


	            </form> 
        </div>
    </section>



    <?php include("Template/scripts.php"); ?>


</body>
</html>