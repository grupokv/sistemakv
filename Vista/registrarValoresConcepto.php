<?php 
include ("../Controlador/Sesion/autenticar.php");
include("../Modelo/TipoVehiculo.php");

$id = base64_decode($_GET['id']);

$titulo = 'Registrar Valor Concepto';
$redireccion = 'conceptos_cobro.php';
$icono = 'fa fa-money';
$tv = new TipoVehiculo();
$listado_tv = $tv->listar();
$cantidad = count($listado_tv);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Registrar Valor Concepto</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>

	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="conceptos_cobro.php">Conceptos Cobro</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar Valores</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="formulario mb-5">
	        <form action="../Controlador/registrarValoresConcepto.php" method="POST">
	        	<?php include("Template/header-form.php"); ?>
                    	<input type="hidden" name="id" value="<?php echo $id;?>"/>
			<div class="row mt-3 mb-4">
                            <div class="label">
                                <strong>TIPO VEHICULO</strong>
                            </div>
                            <div class="label">
                                <strong>VALOR</strong>
                            </div>
                        </div>
			<?php foreach($listado_tv as $lt){ ?>
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label><?php echo $lt['nombre_tipo_vehiculo'];?></label>
                            </div>
                            <div class="input">
                                <input class="form-control" name="valor_<?php echo $lt['id_tipo_vehiculo'];?>" id="valor" required="required" type="number">
                            </div>
                        </div>
			<?php } ?>		
                <?php include("Template/bottom-form.php"); ?>
	        </form>
        </div>
    </section>
    <?php include("Template/scripts.php"); ?>
</body>
</html>