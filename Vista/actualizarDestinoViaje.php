<?php 
include ("../Controlador/Sesion/autenticar.php");
include ("../Modelo/Viaje.php");
$titulo = 'Actualizar Destino';
$redireccion = 'destino_viaje.php';
$icono = 'fa fa-map';

$id = $_GET['id'];
$viaje = new Viaje();
$datos = $viaje->listarDestinoPorId($id);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Registrar Destino</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="destino_viaje.php">Destino</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar Destino</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="formulario mb-5">
            <form action="../Controlador/actualizarDestinoViaje.php" method="POST">
                <?php include("Template/header-form.php"); ?>
                        <input type="hidden" name="id" value="<?php echo $id;?>"/>
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>Detalle</label>
                            </div>
                            <div class="input">
                                <input type="text" name="detalle" id="detalle" class="form-control" required="required" value="<?php echo $datos[0]['detalle'];?>">
                            </div>
                        </div>
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>Estado</label>
                            </div>
                            <div class="input">
                                <select name="estado" id="estado" class="form-control" required="required">
                                    <option value="">Seleccione</option>
                                    <option value="1" <?php if($datos[0]['estado'] == 1){ ?> selected="selected" <?php } ?> >Activo</option>
                                    <option value="0" <?php if($datos[0]['estado'] == 0){ ?> selected="selected" <?php } ?>>Inactivo</option>
                                </select>
                            </div>
                        </div>
                <?php include("Template/bottom-form.php"); ?>
            </form>
        </div>
    </section>
    <?php include("Template/scripts.php"); ?>
</body>
</html>