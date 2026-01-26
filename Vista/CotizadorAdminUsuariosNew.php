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
            <strong><i class="fa fa-build mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">NUEVO USUARIO</b></strong>
        </div>

        <section class="form-usuarios">
            <div class="formulario mb-5">
                <form action="../Controlador/guardarUsuarioCotizador.php" method="POST">
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Nombre</label>
                        </div>
                        <div class="input">
                            <input type="text" name="nombre" id="nombre" class="form-control" value="" required="required" />
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Usuario</label>
                        </div>
                        <div class="input">
                            <input type="text" name="usuario" id="usuario" class="form-control" value="" required="required" />
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Password</label>
                            <button type="button" id="visible" class="btn btn-info" style="float:right;display:flex" onclick="ver_pass()"><i class="fa fa-eye"></i></button>
                            <button type="button" id="no_visible" style="float:right;display:none" class="btn btn-warning" onclick="no_ver_pass()"><i class="fa fa-eye-slash"></i></button>
                        </div>
                        <div class="input">
                            <input type="password" name="pass" id="pass" class="form-control" value="" required="required" />
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Cargo</label>
                        </div>
                        <div class="input">
                            <input type="text" name="cargo" id="cargo" class="form-control" value="" required="required" />
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Telefono</label>
                        </div>
                        <div class="input">
                            <input type="text" name="telefono" id="telefono" class="form-control" value="" required="required" />
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Correo</label>
                        </div>
                        <div class="input">
                            <input type="email" name="email" id="email" class="form-control" value="" required="required" />
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
    function ver_pass(){
        document.getElementById('no_visible').style.display = "flex";
        document.getElementById('visible').style.display = "none";
        document.getElementById('pass').type = "input";
    }
    function no_ver_pass(){
        document.getElementById('no_visible').style.display = "none";
        document.getElementById('visible').style.display = "flex";
        document.getElementById('pass').type = "password";
    }
    </script>
</body>

</html>