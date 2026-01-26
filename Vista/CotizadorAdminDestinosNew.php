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
            <strong><i class="fa fa-build mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">NUEVO DESTINO</b></strong>
        </div>

        <section class="form-usuarios">
            <div class="formulario mb-5">
                <form action="../Controlador/guardarDestinoCotizador.php" method="POST">
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Nombre</label>
                        </div>
                        <div class="input">
                            <input type="text" name="nombre" id="nombre" class="form-control" required="required" value="" />
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>KMS</label>
                        </div>
                        <div class="input">
                            <input type="number" name="kms" id="kms" class="form-control" value="0" step="1" min="0" />
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Dias Viaje</label>
                        </div>
                        <div class="input">
                            <input type="text" name="dias_viaje" id="dias_viaje" class="form-control" required="required" value="" />
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Valor 4 Pax</label>
                        </div>
                        <div class="input">
                            <input type="text" name="valor_4_pax" id="valor_4_pax" class="form-control decimales" value="" />
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Valor 19 Pax</label>
                        </div>
                        <div class="input">
                            <input type="text" name="valor_19_pax" id="valor_19_pax" class="form-control decimales" value="" />
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Valor 24 Pax</label>
                        </div>
                        <div class="input">
                            <input type="text" name="valor_24_pax" id="valor_24_pax" class="form-control decimales" value="" />
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Valor 30 Pax</label>
                        </div>
                        <div class="input">
                            <input type="text" name="valor_30_pax" id="valor_30_pax" class="form-control decimales" value="" />
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Valor 40 Pax</label>
                        </div>
                        <div class="input">
                            <input type="text" name="valor_40_pax" id="valor_40_pax" class="form-control decimales" value="" />
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Valor 45 Pax</label>
                        </div>
                        <div class="input">
                            <input type="text" name="valor_45_pax" id="valor_45_pax" class="form-control decimales" value="" />
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Cant. Peajes</label>
                        </div>
                        <div class="input">
                            <input type="number" min="0" name="cant_peajes" id="cant_peajes" class="form-control" value="0" step="1" />
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Estado</label>
                        </div>
                        <div class="input">
                            <select name="estado" id="estado" class="form-control" required="required" >
                                <option value="1" selected="selected">ACTIVO</option>
                                <option value="0">INACTIVO</option>
                            </select>
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