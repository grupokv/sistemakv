<?php
require_once("../Controlador/Sesion/CotizadorAutenticar.php");
require("../Modelo/CotizadorKV.php");

$cotizadorkv = new CotizadorKV();
$id = base64_decode($_GET['id_empresa']);

$datos = $cotizadorkv->listarEmpresaPorId($id);
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
            <strong><i class="fa fa-build mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">EDITAR EMPRESA</b></strong>
        </div>

        <section class="form-usuarios">
            <div class="formulario mb-5">
                <form action="../Controlador/editarEmpresaCotizador.php" method="POST">
                    
                    <input type="hidden" name="id" id="id" value="<?php echo $id;?>"/>
                    <input type="hidden" name="logo_act" id="logo_act" value="<?php echo $datos[0]['logo'];?>"/>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Razon Social</label>
                        </div>
                        <div class="input">
                            <input type="text" name="razon_social" id="razon_social" class="form-control" required="required" value="<?php echo $datos[0]['razon_social'];?>" />
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>NIT</label>
                        </div>
                        <div class="input">
                            <input type="text" name="nit" id="nit" class="form-control" required="required" value="<?php echo $datos[0]['nit'];?>" />
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Direccion</label>
                        </div>
                        <div class="input">
                            <input type="text" name="direccion" id="direccion" class="form-control" required="required" value="<?php echo $datos[0]['direccion'];?>" />
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Telefono</label>
                        </div>
                        <div class="input">
                            <input type="text" name="telefono" id="telefono" class="form-control" required="required" value="<?php echo $datos[0]['telefono'];?>" />
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Estado</label>
                        </div>
                        <div class="input">
                            <select name="estado" id="estado" class="form-control" required="required" >
                                <option value="1" <?php if($datos[0]['estado'] == 1) { ?> selected="selected" <?php } ?> >ACTIVO</option>
                                <option value="0" <?php if($datos[0]['estado'] == 0) { ?> selected="selected" <?php } ?> >INACTIVO</option>
                            </select>
                        </div>
                    </div>

                    <button id="boton" type="submit" class="mt-3 btn btn-success btn-block" >ACTUALIZAR</button>

                </form>
            </div>
        </section>

    </section>

    <!-- FIN CONTENIDO -->

    <!--**************************--->

    <?php include("Template/scripts.php"); ?>
    
</body>

</html>