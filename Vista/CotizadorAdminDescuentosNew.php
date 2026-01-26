<?php
require_once("../Controlador/Sesion/CotizadorAutenticar.php");
require("../Modelo/CotizadorKV.php");

$cotizadorkv = new CotizadorKV();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>SistemaKV | Cotizador KV</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- styles -->
    <?php include("Template/styles.php") ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
</head>

<body>

   
    <!--MENU-->
    
    <?php include("Template/header_cotizador.php"); ?>
    <?php include("Template/menu_cotizador.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->

    <!-- CONTENIDO -->

    <section class="home_content">

        

        <div class="notice notice-sistemakv">
            <strong><i class="fa fa-build mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">NUEVO DESCUENTO</b></strong>
        </div>

        <section class="form-usuarios">
            <div class="formulario mb-5">
                <form action="../Controlador/guardarDescuentoCotizador.php" method="POST">
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Valor Descuento (%)</label>
                        </div>
                        <div class="input">
                            <input type="number" name="valor" id="valor" class="form-control" value="0" step="1" min="0" />
                        </div>
                    </div>
                    
                    <button id="boton" type="submit" class="mt-3 btn btn-success btn-block" >GUARDAR</button>

                </form>
            </div>
        </section>

    </section>

    <!-- FIN CONTENIDO -->

    <!--**************************--->

    <?php include("Template/scripts.php"); ?>
    <script>
    $('.decimales').on('input', function () {
      this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
    });
    </script>
</body>

</html>