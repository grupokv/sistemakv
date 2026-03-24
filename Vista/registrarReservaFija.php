<?php
include ("../Controlador/Sesion/autenticar.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Registrar Reserva Fija</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php include("Template/styles.php") ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
</head>
<body>
<?php include("Template/header.php"); ?>
<?php include("Template/newMenu.php"); ?>
<section class="home_content">
    <div class="notice notice-sistemakv">
        <strong><i class="fa fa-calendar mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">RESERVA FIJA</b></strong>
    </div>
    <div class="alert alert-info mt-3">
        Módulo de Reserva Fija en construcción. Este acceso ya quedó creado para el nuevo flujo.
    </div>
    <a href="serviciosOcasionales.php" class="btn btn-outline-primary">Volver</a>
</section>
<?php include("Template/scripts.php"); ?>
</body>
</html>