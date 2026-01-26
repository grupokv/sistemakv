<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Operativo.php");

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <title>SistemaKV | Facturación</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- styles -->
    <?php include("Template/styles.php") ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

    <style>
    #servicios thead {
        background-color: #fff;
    }

    #servicios table {
        font-size: .8rem;
    }

    #servicios tr {
        background-color: #fff;
    }

    #servicios th {
        border-radius: 13px;
        border: 3px solid #fff;
        background-color: #274054;
        color: #fff;
    }

    #contEstado {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        cursor: pointer;
    }

    .dropdown-menu .show {
        max-width: 400px !important;
        min-width: 300px !important;
    }

    </style>

    <!--fin  styles -->

</head>

<body>

    <!--MENU-->
    <?php include("Template/header.php"); ?>
    <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->

    <!-- CONTENIDO -->
    
    <section class="home_content">

        <div aria-label="breadcrumb" class="mt-1">
            <ol class="breadcrumb" style="background: #fff;">
                <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Servicios</li>
            </ol>
        </div>

        <div class="notice notice-sistemakv">
            <strong><img src="../Resources/images/401182.png" alt="icon_billing_kv" style="width: 45px;"><b style="font-size:1.4rem;" class="ml-3">FACTURACIÓN</b></strong>
        </div>

        <div style="width: 100%; height: auto; padding: 5px; background-color: #fff; border-radius: 10px;">

            <!-- REGISTRAR -->
            <?php if($registro == 1){ ?>
            <a href="registrarNuevoServicio.php" class="btn btn-outline-info" id="buttonsKV"
                style="border-radius: 10px;">Nuevo Servicio <i class="fa fa-plus-circle"></i></a>
            <?php } ?>

        </div>

        <div class="mt-2 p-4 table-responsive" id="servicios" style="background-color: #fff;">
            <table id="data" class="table table-hover table-sm display text-center" style="width:100%">
                <thead style="background-color: #1b2d3b; color: #fff;">
                    <tr>
                        <th style="vertical-align: top;">#</th>
                        <th style="vertical-align: top;">ID SERVICIO</th>
                        <th style="vertical-align: top;">FECHA INICIO</th>
                        <th style="vertical-align: top;">FECHA FINAL</th>
                        <th style="vertical-align: top;">CONTRATO</th>
                        <th style="vertical-align: top;">CLIENTE</th>
                        <th style="vertical-align: top;">EMPRESA</th>
                    </tr>
                </thead>
                <tbody style="font-size: .8rem;">
                </tbody>

            </table>
        </div>

    </section>
    <!-- FIN CONTENIDO -->

    <!------------------------------------------------ -->
    <!------------------------------------------------ -->

    <!-- SCRIPT -->
    <?php include("Template/scripts.php"); ?>

    <script type="text/javascript">
    </script>
    <!-- FIN SCRIPT -->

</body>

</html>