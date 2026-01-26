<?php 
//include ("../Controlador/Sesion/autenticar.php");
include ("../Modelo/Cotizador.php");

$cotizador = new Cotizador();
$listado_destinos = $cotizador->listarDestinos();
$listado_vehiculos = $cotizador->listarTipoVehiculo();
$listado_costo_conductor = $cotizador->listarCostoConductor();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>SistemaKV | Realizar Cotizacion</title>
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
    <?php include("Template/header.php"); ?>
    <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->

    <!-- CONTENIDO -->

    <section class="home_content">

        <div aria-label="breadcrumb" class="mt-1">
            <ol class="breadcrumb" style="background: #fff;">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Realizar Cotizacion</li>
            </ol>
        </div>

        <div class="notice notice-sistemakv">
            <strong><i class="fa fa-dollar mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">REALIZAR COTIZACIÓN (TARIFAS) </b></strong>
        </div>



        <section class="form-usuarios">
            <div class="formulario mb-5">
                <form action="" method="POST">
                    
                    <!--NOMBRE AREA-->
                    <div class="row mt-3 mb-4">
                        <div class="label">
                            <label>Destino</label>
                        </div>
                        <div class="input">
                            <select name="destino" id="destino" class="form-control selectpicker" data-live-search="true"
                                required="required" onchange="habilitar()">
                                <option value="">Seleccione Destino</option>
                                <?php foreach($listado_destinos as $ld){ ?>
                                <option value="<?php echo $ld['id_destino'];?>">
                                    <?php echo $ld['ciudad']." - ".$ld['departamento'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3 mb-4">
                        <div class="label">
                            <label>Tipo Vehiculo</label>
                        </div>
                        <div class="input">
                            <select name="tipo_vehiculo" id="tipo_vehiculo" class="form-control selectpicker"
                                data-live-search="true" required="required" onchange="habilitar()">
                                <option value="">Seleccione Tipo Vehiculo</option>
                                <?php foreach($listado_vehiculos as $lv){ ?>
                                <option value="<?php echo $lv['id'];?>"><?php echo $lv['tipo_vehiculo'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3 mb-4">
                        <div class="label3">
                            <label>Kilometros</label>
                        </div>
                        <div class="input3">
                            <input type="text" name="kms" id="kms" class="form-control" required="required"
                                disabled="disabled" value="" readonly="readonly" />
                        </div>

                        <div class="label3">
                            <label>Peajes</label>
                        </div>
                        <div class="input3">
                            <input type="text" name="peajes" id="peajes" class="form-control" required="required"
                                disabled="disabled" value="" readonly="readonly" />
                        </div>

                        <div class="label3">
                            <label>Costo Peaje</label>
                        </div>
                        <div class="input3">
                            <input type="text" name="valor_peaje" id="valor_peaje" class="form-control" required="required"
                                disabled="disabled" value="" readonly="readonly" />
                        </div>
                    </div>

                    <div class="row mt-3 mb-4">
                        <div class="label2">
                            <label>Tiempo de Viaje</label>
                        </div>
                        <div class="input2">
                            <input type="text" name="dias_viaje" id="dias_viaje" class="form-control" required="required"
                                disabled="disabled" readonly="readonly" />
                        </div>

                        <div class="label2">
                            <label>Dias Adicionales</label>
                        </div>
                        <div class="input2">
                            <input type="number" name="dias_adicional" id="dias_adicional" class="form-control"
                                required="required" disabled="disabled" value="0" min='0' onblur="habilitar()" />
                        </div>
                    </div>

                    <div class="row mt-3 mb-4">
                        <div class="label2">
                            <label>Lavados</label>
                        </div>
                        <div class="input2">
                            <input type="number" name="lavados" id="lavados" class="form-control" required="required"
                                disabled="disabled" value="1" min='1' onchange="habilitar()" />
                        </div>

                        <div class="label2">
                            <label>Hospedaje</label>
                        </div>
                        <div class="input2">
                            <input type="checkbox" name="hospedaje" id="hospedaje" class="form-control" disabled="disabled"
                                value="S" onchange="habilitar()" />
                        </div>
                    </div>

                    <div class="row mt-3 mb-4">
                        <div class="label2">
                            <label>Alimentacion</label>
                        </div>
                        <div class="input2">
                            <input type="checkbox" name="alimentacion" id="alimentacion" class="form-control"
                                disabled="disabled" value="S" onchange="habilitar()" />
                        </div>

                        <div class="label2">
                            <label>Parqueadero</label>
                        </div>
                        <div class="input2">
                            <input type="checkbox" name="parqueadero" id="parqueadero" class="form-control"
                                disabled="disabled" value="S" onchange="habilitar()" />
                        </div>
                    </div>

                    <div class="row mt-3 mb-4">
                        <div class="label2">
                            <label>Desc. Porcentaje</label>
                        </div>
                        <div class="input2">
                            <input type="text" name="desc_porc" id="desc_porc" class="form-control" disabled="disabled"
                                value="0%" min='0' maxlength="3" onblur="habilitar();mascara(this.value)" />
                        </div>

                        <div class="label2">
                            <label>Desc. Valor</label>
                        </div>
                        <div class="input2">
                            <input type="number" name="desc_valor" id="desc_valor" class="form-control" disabled="disabled"
                                value="0" min='0' onchange="habilitar()" />
                        </div>
                    </div>

                    <div class="row mt-3 mb-4">
                        <div class="label">
                            <label>Costo Conductor</label>
                        </div>
                        <div class="input">
                            <select name="costo_conductor" id="costo_conductor" class="form-control" onchange="habilitar()"
                                disabled="disabled">
                                <?php foreach($listado_costo_conductor as $lc){ ?>
                                <option value="<?php echo $lc['id_costo_conductor'];?>">
                                    <?php echo 'El '.$lc['porcentaje_pago'].'% del '.$lc['porcentaje_total'].'%';?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3 mb-4">
                        <div class="label">
                            <label>Valor Gastos</label>
                        </div>
                        <div class="input">
                            <input type="text" name="costos" id="costos" class="form-control" required="required"
                                disabled="disabled" value="0" min='0' />
                        </div>
                    </div>

                    <div class="row mt-3 mb-4">
                        <div class="label">
                            <label>Oferta Piso</label>
                        </div>
                        <div class="input">
                            <input type="text" name="minima" id="minima" class="form-control" required="required"
                                disabled="disabled" value="0" min='0' />
                        </div>
                    </div>

                    <div class="row mt-3 mb-4">
                        <div class="label">
                            <label><b>Precio Normal</b></label>
                        </div>
                        <div class="input">
                            <input type="text" name="normal" id="normal" class="form-control" required="required"
                                disabled="disabled" value="0" min='0' />
                        </div>
                    </div>

                    <div class="row mt-3 mb-4">
                        <div class="label">
                            <label>Pago a Conductor</label>
                        </div>
                        <div class="input">
                            <input type="text" name="pago_conductor" id="pago_conductor" class="form-control"
                                required="required" disabled="disabled" value="0" min='0' />
                        </div>
                    </div>

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
        var tipo = document.getElementById('tipo_vehiculo').value;
        if ((destino != '') && (tipo != '')) {

            var hospedaje = document.getElementById('hospedaje').checked;
            if (hospedaje == true) {
                hospedaje = 'S';
            } else {
                hospedaje = 'N';
            }
            var alimentacion = document.getElementById('alimentacion').checked;
            if (alimentacion == true) {
                alimentacion = 'S';
            } else {
                alimentacion = 'N';
            }
            var parqueadero = document.getElementById('parqueadero').checked;
            if (parqueadero == true) {
                parqueadero = 'S';
            } else {
                parqueadero = 'N';
            }
            var lavadas = document.getElementById('lavados').value;
            var costo_conductor = document.getElementById('costo_conductor').value;
            var desc_porc = document.getElementById('desc_porc').value;
            var desc_valor = document.getElementById('desc_valor').value;
            var adicionales = document.getElementById('dias_adicional').value;

            document.getElementById('dias_adicional').disabled = false;
            document.getElementById('lavados').disabled = false;
            document.getElementById('hospedaje').disabled = false;
            document.getElementById('alimentacion').disabled = false;
            document.getElementById('parqueadero').disabled = false;
            document.getElementById('desc_porc').disabled = false;
            document.getElementById('desc_valor').disabled = false;
            document.getElementById('costo_conductor').disabled = false;

            var parametros = {
                "id_destino": destino,
                "id_tipo": tipo,
                "dias": adicionales,
                "hospedaje": hospedaje,
                "alimentacion": alimentacion,
                "lavadas": lavadas,
                "parqueadero": parqueadero,
                "desc_porc": desc_porc,
                "desc_valor": desc_valor,
                "costo_conductor": costo_conductor
            };

            $.ajax({
                data: parametros,
                url: '../Controlador/traerDatosCotizacion.php',
                type: 'post',
                beforeSend: function() {

                },
                success: function(response) {
                    var respuesta = response.split('|');
                    document.getElementById('dias_viaje').value = respuesta[0];
                    document.getElementById('minima').value = '$ ' + formatMoney(respuesta[1], 0, ",", ".");
                    document.getElementById('pago_conductor').value = '$ ' + formatMoney(respuesta[2], 0,
                        ",", ".");
                    document.getElementById('costos').value = '$ ' + formatMoney(respuesta[3], 0, ",", ".");

                    document.getElementById('normal').value = '$ ' + formatMoney(respuesta[4], 0, ",", ".");
                    document.getElementById('kms').value = respuesta[5];
                    document.getElementById('peajes').value = respuesta[6];
                    document.getElementById('valor_peaje').value = '$ ' + formatMoney(respuesta[7], 0, ",",
                        ".");;
                }
            });
        } else {
            document.getElementById('dias_adicional').disabled = true;
            document.getElementById('lavados').disabled = true;
            document.getElementById('hospedaje').disabled = true;
            document.getElementById('alimentacion').disabled = true;
            document.getElementById('parqueadero').disabled = true;
            document.getElementById('desc_porc').disabled = true;
            document.getElementById('desc_valor').disabled = true;
            document.getElementById('costo_conductor').disabled = true;
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