<?php
require_once("../Controlador/Sesion/CotizadorAutenticar.php");
require("../Modelo/CotizadorKV.php");

$cotizadorkv = new CotizadorKV();

$detalle_destino = $cotizadorkv->listarDestinoPorId($_POST['destino']);
$empresas = $cotizadorkv->listarEmpresasActivas();

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
            <strong><i class="fa fa-dollar mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">REALIZAR COTIZACIÓN (TARIFAS) </b></strong>
        </div>

        <section class="form-usuarios">
            <div class="formulario mb-5">
                <form action="CotizacionGuardar.php" method="POST">
                    
                    <input type="hidden" name="destino_nombre" value="<?php echo $detalle_destino[0]['nombre'];?>"/>
                    <input type="hidden" name="dias_servicio_ind" value="<?php echo $_POST['dias_servicio_ind'];?>"/>
                    <input type="hidden" name="kilometros" value="<?php echo $_POST['kilometros'];?>"/>
                    <input type="hidden" name="peajes" value="<?php echo $_POST['peajes'];?>"/>
                    <input type="hidden" name="dias_espera" value="<?php echo $_POST['dias_espera'];?>"/>
                    <input type="hidden" name="totalizado_espera" value="<?php echo $_POST['totalizado_espera'];?>"/>
                    <input type="hidden" name="dias_servicio" value="<?php echo $_POST['dias_servicio'];?>"/>
                    <input type="hidden" name="totalizado_servicio" value="<?php echo $_POST['totalizado_servicio'];?>"/>
                    <input type="hidden" name="capacidad" value="<?php echo $_POST['capacidad'];?>"/>
                    <input type="hidden" name="valor_parcial" value="<?php echo $_POST['valor_parcial'];?>"/>
                    <input type="hidden" name="descuento" value="<?php echo $_POST['descuento'];?>"/>
                    <input type="hidden" name="valor_descontado" value="<?php echo $_POST['valor_descontado'];?>"/>
                    <input type="hidden" name="valor_final" value="<?php echo $_POST['valor_final'];?>"/>
                    
                    <div class="row mt-1 mb-1" style="background-color:#e4e4e4; text-align:center; font-size:1rem">
                        <b style="width:100%">DATOS EMPRESA</b>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Empresa</label>
                        </div>
                        <div class="input">
                            <select name="empresa" id="empresa" class="form-control selectpicker" data-live-search="true"
                                required="required" onchange="habilitar()">
                                <option value="">Seleccione Empresa</option>
                                <?php foreach($empresas as $ld){ ?>
                                <option value="<?php echo $ld['id_empresa'];?>">
                                    <?php echo $ld['razon_social'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mt-1 mb-1" style="background-color:#e4e4e4; text-align:center; font-size:1rem">
                        <b style="width:100%">DATOS CLIENTE</b>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Numero Documento o NIT</label>
                        </div>
                        <div class="input">
                            <input type="text" class="form-control" name="id_cliente" id="id_cliente" value="" onblur="buscar_cliente(this.value); habilitar()" required="required"/>
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1" id="mensaje_valores" style="display:none">
                        <div class="label">
                            <label>Mensaje:</label>
                        </div>
                        <div class="input">
                            <label>Buscando datos cliente, por favor esperar...</label>
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Nombre o Razon Social</label>
                        </div>
                        <div class="input">
                            <input type="text" class="form-control" name="nom_cliente" id="nom_cliente" value="" required="required" onblur="habilitar()" />
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Direccion</label>
                        </div>
                        <div class="input">
                            <input type="text" class="form-control" name="dir_cliente" id="dir_cliente" value="" />
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Telefono</label>
                        </div>
                        <div class="input">
                            <input type="text" class="form-control" name="tel_cliente" id="tel_cliente" value="" />
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Correo Electronico</label>
                        </div>
                        <div class="input">
                            <input type="text" class="form-control" name="email_cliente" id="email_cliente" value="" />
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Nombre Contacto</label>
                        </div>
                        <div class="input">
                            <input type="text" class="form-control" name="contacto" id="contacto" value="" />
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Observaciones</label>
                        </div>
                        <div class="input">
                            <textarea class="form-control" row="5" name="observaciones" id="observaciones"></textarea>
                        </div>
                    </div>

                    <button id="boton" disabled="disabled" type="submit" class=" mt-3 btn btn-success btn-block" >GENERAR COTIZACION</button>

                </form>
            </div>
        </section>

    </section>

    <!-- FIN CONTENIDO -->

    <!--**************************--->

    <?php include("Template/scripts.php"); ?>
    <script>
    function buscar_cliente() {
        var id_cliente = document.getElementById('id_cliente').value;
        
        if (id_cliente != '') {

            var parametros = {
                "id_cliente": id_cliente
            };

            $.ajax({
                data: parametros,
                url: '../Controlador/cotizadorTraerDatosCliente.php',
                type: 'post',
                beforeSend: function() {
                    document.getElementById('mensaje_valores').style.display = "flex";
                },
                success: function(response) {
                    document.getElementById('mensaje_valores').style.display = "none";
                    //alert(response);
                    var respuesta = response.split('|');
                    document.getElementById('dias_servicio_ind').value = respuesta[0];
                    document.getElementById('kilometros').value = respuesta[1];
                    document.getElementById('peajes').value = respuesta[2];
                    document.getElementById('valor_normal_ind').value = respuesta[3];
                    document.getElementById('valor_normal').value = '$ ' + formatMoney(respuesta[3],0,",",".");
                    
                    document.getElementById('valor_espera_ind').value = respuesta[4];
                    document.getElementById('valor_servicio_ind').value = respuesta[5];
                    
                    habilitar();
                    
                }
            });
        } 
    }
    function habilitar(){
        var empresa = document.getElementById('empresa').value;
        var id_cliente = document.getElementById('id_cliente').value;
        var nom_cliente = document.getElementById('nom_cliente').value;
        
        if((empresa != "")&&(id_cliente != "")&&(nom_cliente != "")){
            document.getElementById('boton').removeAttribute("disabled");
        } else {
            document.getElementById('boton').setAttribute("disabled","disabled");
        }
        
    }
    </script>
</body>

</html>