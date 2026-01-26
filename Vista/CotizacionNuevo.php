<?php
require_once("../Controlador/Sesion/CotizadorAutenticar.php");
require("../Modelo/CotizadorKV.php");

$cotizadorkv = new CotizadorKV();

$destinos = $cotizadorkv->listar_destinos_activos();
$descuentos = $cotizadorkv->listar_descuentos();
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
                <form action="CotizacionCliente.php" method="POST">
                    
                    <div class="row mt-1 mb-1" style="background-color:#e4e4e4; text-align:center; font-size:1rem">
                        <b style="width:100%">DATOS BASICOS</b>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Destino</label>
                        </div>
                        <div class="input">
                            <select name="destino" id="destino" class="form-control selectpicker" data-live-search="true"
                                required="required" onchange="habilitar()">
                                <option value="">Seleccione Destino</option>
                                <?php foreach($destinos as $ld){ ?>
                                <option value="<?php echo $ld['id_destino'];?>">
                                    <?php echo $ld['nombre'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Capacidad Vehiculo</label>
                        </div>
                        <div class="input">
                            <select name="capacidad" id="capacidad" class="form-control selectpicker" required="required" onchange="habilitar()">
                                <option value="">Seleccione Capacidad</option>
                                <option value="4">4</option>
                                <option value="19">19</option>
                                <option value="24">24</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                                <option value="45">45</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label3">
                            <label>Dias Servicio</label>
                        </div>
                        <div class="input3">
                            <input type="text" class="form-control" readonly="readonly" id="dias_servicio_ind" name="dias_servicio_ind" value=""/>
                        </div>
                        <div class="label3">
                            <label>KMS Trayecto</label>
                        </div>
                        <div class="input3">
                            <input type="text" class="form-control" readonly="readonly" id="kilometros" name="kilometros" value=""/>
                        </div>
                        <div class="label3">
                            <label>Peajes Trayecto</label>
                        </div>
                        <div class="input3">
                            <input type="text" class="form-control" readonly="readonly" id="peajes" name="peajes" value=""/>
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1" id="mensaje_valores" style="display:none">
                        <div class="label">
                            <label>Mensaje:</label>
                        </div>
                        <div class="input">
                            <label>Cargando valores, por favor esperar...</label>
                        </div>
                    </div>

                    <div class="row mt-3 mb-1" style="background-color:#e4e4e4; text-align:center; font-size:1rem">
                        <b style="width:100%">ADICIONALES</b>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label2">
                            <label>Dias Espera Adicional</label>
                        </div>
                        <div class="input2">
                            <input type="number" step="1" min="0" name="dias_espera" id="dias_espera" class="form-control" required="required" value="0" onchange="calcular_adicional()" />
                        </div>

                        <div class="label2">
                            <label>Total $ Espera</label>
                        </div>
                        <div class="input2">
                            <input type="text" name="total_espera" id="total_espera" class="form-control" required="required" value="0" readonly="readonly" />
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label2">
                            <label>Dias Servicio Adicional</label>
                        </div>
                        <div class="input2">
                            <input type="number" step="1" min="0" name="dias_servicio" id="dias_servicio" class="form-control" required="required" value="0" onchange="calcular_adicional()" />
                        </div>

                        <div class="label2">
                            <label>Total $ Servicio</label>
                        </div>
                        <div class="input2">
                            <input type="text" name="total_servicio" id="total_servicio" class="form-control" required="required" value="0" readonly="readonly" />
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1" style="background-color:#e4e4e4; text-align:center; font-size:1rem">
                        <b style="width:100%">VALORES</b>
                    </div>

                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Valor Estandar</label>
                        </div>
                        <div class="input">
                            <input type="text" name="valor_normal" id="valor_normal" class="form-control" required="required" disabled="disabled" readonly="readonly" />
                            <input type="hidden" name="valor_normal_ind" id="valor_normal_ind" value="0"/>
                            <input type="hidden" name="valor_servicio_ind" id="valor_servicio_ind" value="0"/>
                            <input type="hidden" name="valor_espera_ind" id="valor_espera_ind" value="0"/>
                            <input type="hidden" name="totalizado_espera" id="totalizado_espera" value="0"/>
                            <input type="hidden" name="totalizado_servicio" id="totalizado_servicio" value="0"/>
                            <input type="hidden" name="valor_parcial" id="valor_parcial" value="0"/>
                            <input type="hidden" name="valor_descontado" id="valor_descontado" value="0"/>
                            <input type="hidden" name="valor_final" id="valor_final" value="0"/>
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Descuento (%)</label>
                        </div>
                        <div class="input">
                            <select name="descuento" id="descuento" class="form-control selectpicker" required="required" onchange="calcular_descuento()">
                                <option value="">Seleccione Descuento</option>
                                <?php foreach($descuentos as $ldes){ ?>
                                <option value="<?php echo $ldes['valor'];?>">
                                    <?php echo $ldes['valor'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Valor Descuento</label>
                        </div>
                        <div class="input">
                            <input type="text" name="valor_descuento" id="valor_descuento" class="form-control" required="required" disabled="disabled" readonly="readonly" value="0" />
                            
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Valor Especial</label>
                        </div>
                        <div class="input">
                            <input type="text" name="valor_especial" id="valor_especial" class="form-control" required="required" disabled="disabled" readonly="readonly" />
                        </div>
                    </div>

                    <button id="boton" disabled="disabled" type="submit" class=" mt-3 btn btn-success btn-block" >SIGUIENTE PASO</button>

                </form>
            </div>
        </section>

    </section>

    <!-- FIN CONTENIDO -->

    <!--**************************--->

    <?php include("Template/scripts.php"); ?>
    <script>
    function habilitar() {
        var destino = document.getElementById('destino').value;
        var capacidad = document.getElementById('capacidad').value;
        if ((destino != '') && (capacidad != '')) {

            var parametros = {
                "destino": destino,
                "capacidad": capacidad,
            };

            $.ajax({
                data: parametros,
                url: '../Controlador/cotizadorTraerValores.php',
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
                    calcular_adicional();
                }
            });
        } else {
            document.getElementById('mensaje_valores').style.display = "none";
            document.getElementById('dias_servicio_ind').value = "0";
            document.getElementById('kilometros').value = "0";
            document.getElementById('peajes').value = "0";
            document.getElementById('valor_normal_ind').value = "0";
            document.getElementById('valor_normal').value = "0";
            
            document.getElementById('valor_espera_ind').value = "0";
            document.getElementById('valor_servicio_ind').value = "0";
            calcular_adicional();
            
        }
        
    }
    function calcular_adicional(){
        var espera_adic = document.getElementById('dias_espera').value;
        var servicio_adic = document.getElementById('dias_servicio').value;
        
        if(espera_adic > 0){
            var valor_espera_ind = document.getElementById('valor_espera_ind').value;
            var total_espera = (valor_espera_ind * espera_adic);
            document.getElementById('totalizado_espera').value = total_espera;
            document.getElementById('total_espera').value = '$ ' + formatMoney(total_espera,0,",",".");
        } else {
            document.getElementById('totalizado_espera').value = 0;
            document.getElementById('total_espera').value = 0;
        }
        if(servicio_adic > 0){
            var valor_servicio_ind = document.getElementById('valor_servicio_ind').value;
            var total_servicio = (valor_servicio_ind * servicio_adic);
            document.getElementById('totalizado_servicio').value = total_servicio;
            document.getElementById('total_servicio').value = '$ ' + formatMoney(total_servicio,0,",",".");
        } else {
            document.getElementById('totalizado_servicio').value = 0;
            document.getElementById('total_servicio').value = 0;
        }
        calcular_total();
    }
    function calcular_total(){
        
        var v1 = document.getElementById('valor_normal_ind').value;
        var v2 = document.getElementById('totalizado_espera').value;
        var v3 = document.getElementById('totalizado_servicio').value;
        
        var total_parcial = (parseInt(v1) + parseInt(v2) + parseInt(v3));
        document.getElementById('valor_normal').value = '$ ' + formatMoney(total_parcial,0,",",".");
        document.getElementById('valor_parcial').value = total_parcial;
        calcular_descuento();
        
    }
    function calcular_descuento(){
        var antes = document.getElementById('valor_parcial').value;
        var porc_descuento = document.getElementById('descuento').value;
        if(porc_descuento == ""){
            porc_descuento = 0;
        }
        var descontado = ((antes * porc_descuento)/100);
        var final = (antes - descontado);
        document.getElementById('valor_especial').value = '$ ' + formatMoney(final,0,",",".");
        document.getElementById('valor_descuento').value = '$ ' + formatMoney(descontado,0,",",".");
        document.getElementById('valor_descontado').value = descontado;
        document.getElementById('valor_final').value = final;
        
        if(final > 0){
            document.getElementById('boton').removeAttribute("disabled");
        } else {
            document.getElementById('boton').setAttribute("disabled","disabled");
        }
        
    }
    </script>
    <script>
    function mascara(val) {
        val = val.replace('%', '');
        if ((val == '')) {
            val = 0;
        }
        val = parseInt(val);
        con = val + '%';
        document.getElementById('desc_porc').value = con;
    };

    function formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",") {
        try {
            decimalCount = Math.abs(decimalCount);
            decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

            const negativeSign = amount < 0 ? "-" : "";

            let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
            let j = (i.length > 3) ? i.length % 3 : 0;

            return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" +
                thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
        } catch (e) {
            console.log(e)
        }
    };
    </script>
</body>

</html>