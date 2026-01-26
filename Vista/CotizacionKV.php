<?php 
include ("../Modelo/Cotizador.php");
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
    <!--FIN MENU-->

    <!--**************************--->

    <!-- CONTENIDO -->

    <section class="home_content">

        

        <div class="notice notice-sistemakv">
            <strong><i class="fa fa-dollar mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">REALIZAR COTIZACIÓN (TARIFAS) </b></strong>
        </div>



        <section class="form-usuarios">
            <div class="formulario mb-5">
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
                                <?php foreach($destinod as $ld){ ?>
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
                            <input type="text" class="form-control" readonly="readonly" id="dias_servicio" value=""/>
                        </div>
                        <div class="label3">
                            <label>KMS Trayecto</label>
                        </div>
                        <div class="input3">
                            <input type="text" class="form-control" readonly="readonly" id="kilometros" value=""/>
                        </div>
                        <div class="label3">
                            <label>Peajes Trayecto</label>
                        </div>
                        <div class="input3">
                            <input type="text" class="form-control" readonly="readonly" id="peajes" value=""/>
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
                            <input type="number" step="1" min="0" name="dias_espera" id="dias_espera" class="form-control" required="required" value="0" />
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
                            <input type="number" step="1" min="0" name="dias_servicio" id="dias_servicio" class="form-control" required="required" value="0" />
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
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Descuento (%)</label>
                        </div>
                        <div class="input">
                            <select name="descuento" id="descuento" class="form-control selectpicker" required="required" onchange="calcular_des()">
                                <option value="">Seleccione Descuento</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Valor Descuento</label>
                        </div>
                        <div class="input">
                            <input type="text" name="valor_descuento" id="valor_descuento" class="form-control" required="required" disabled="disabled" readonly="readonly" />
                        </div>
                    </div>
                    
                    <div class="row mt-3 mb-1">
                        <div class="label">
                            <label>Valor Especial</label>
                        </div>
                        <div class="input">
                            <input type="text" name="valor_final" id="valor_final" class="form-control" required="required" disabled="disabled" readonly="readonly" />
                        </div>
                    </div>

                    <button type="button" class=" mt-3 btn btn-success btn-block" >GENERAR COTIZACIÓN</button>
            </div>
        </section>

    </section>

    <!-- MENSAJE MODAL NOTIFICACION HORARIO -->
    <div class="modal fade" id="modal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="col-12 " style="height: auto;">
                    <section class="col-12 d-flex justify-content-center">
                        <img src="https://sistemakv.com/Resources/img/kingvision_transparente.png" alt="Logo_King_Vision" width="101" height="65" style="display: block; margin-top: 10px;">
                    </section>
                    <h4 class="modal-title mt-3" style="color: #a1a1a1; "><strong>INGRESAR AL COTIZADOR</strong></h4>
                </div>
              <div class="col-12 mt-3">
                  <form action="CotizacionIniciarSesion.php" method="POST" >          
                    <div class="login">                          
                        <hr>              
                            <div class="row" style="margin-bottom:15px; margin-top:15px; margin-left: 30px;">                  
                                <div class="col-12">                      
                                    <label for="usuario" style="float:left; color: #404040; font-size:.9rem; font-weight:bolder; text-transform: uppercase;">Usuario</label>                                      
                                </div> 
                                <div class="col-12">
                                    <input type="text" class="form-control mb-3" name="usuario" id="usuario" required="required" style="width: 80%;">  
                                </div>
                            </div>              
                            <div class="row" style="margin-bottom:15px; margin-left: 30px;">                  
                                <section class="col-12">                      
                                    <label for="`password" style="float:left; color:#404040; font-size:.9rem; font-weight:bolder; text-transform:uppercase;">Contraseña</label>                      
                                </section>
                                <section class="col-12">
                                    <input type="password" class="form-control mb-1" name="clave" id="clave" required="required" style="width: 80%;">                  
                                </section>
                            </div>   
                        
                            <section class="row mt-2" style="display: flex; justify-content: center; margin-top: 20px; margin-bottom: 20px;"> 
                                <div class="col-6" style="width: 100%; display: flex; justify-content: center; ">   
                                    <button class="btn btn-block" style="border-radius: 2px; background: #335689; width: 60%; color: #fff;">Ingresar</button>  
                                </div>
                            </section> 
                        
                        <hr>              
                        
                        <div class="mensaje text-center" style="color: #B40404;">                
                            <p><?php echo $mensaje; ?></p>              
                        </div>                          
                    </div>        
                </form>     
             
              </div>
            </div>
            <!-- <div class="col-12 modal-footer d-flex justify-content-center" style="border: 0px;">
              <button type="button" class="col-3 btn btn-danger btn-block" data-dismiss="modal">Cerrar</button>
            </div> -->
        </div>
      </div>
    </div>
    
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
    $('#modal').modal({backdrop: 'static', keyboard: false})
    
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
    function modalAviso(){
        $("#modal").modal("show");   
    }

    $(window).on("load", modalAviso());
    </script>
</body>

</html>