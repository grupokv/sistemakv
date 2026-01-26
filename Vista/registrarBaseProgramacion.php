<?php

include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Programacion.php");
require_once ("../Modelo/Vehiculo.php");
require_once ("../Modelo/TipoVehiculo.php");

/* VARIABLES MENU*/
$titulo = 'Registrar Programación';
$redireccion = 'programaciones.php';
$icono = 'fa fa-file-text-o';

$programacion = new Programacion();
$listarUnidadesOperativasProgramacion = $programacion->listarUnidadesOperativasProgramacion();


$vehiculo = new Vehiculo();
$tipovehiculo = new TipoVehiculo();
$id_contrato = 250;
$listarVehiculos = $vehiculo->listarVehiculosPorContrato($id_contrato);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Vehiculo</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

</head>
<body>

    <?php include("Template/header.php"); ?>
    <?php include("Template/newMenu.php"); ?>



    <section class="home_content">

        <div aria-label="breadcrumb" class="mt-1"> 
           <ol class="breadcrumb" style="background: #fff;">
                <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                <li class="breadcrumb-item " aria-current="page"><a href="programaciones.php">Programaciones</a></li>
                <li class="breadcrumb-item active" aria-current="page">Registro</li>
           </ol>
        </div>
        
        <div class="notice notice-sistemakv">
          <strong><i class="fa fa-file-text-o mr-3" style="font-size: 2rem;"></i><b style="font-size: 1.3rem;">REGISTRO DE PROGRAMACIÓN</b></strong>
        </div>


        <section class="form-usuarios mt-1">
            <div class="formulario mb-5">

    	        <form action="../Controlador/registrarProgramacionServicio.php" method="POST" name="formulario_registro" id="formulario_registro">
        	        	
                        <!-- LOCALIDAD -->
                            <div class="row  mt-3" style="width: 100%;">
                                <div class="label">
                                    <label>Localidad</label>
                                </div>
                                <div class="input">
                                    <select name="localidad" id="localidad" class="form-control selectpicker" data-live-search="true" > 
                                        <option value="">SELECCIONAR</option>
                                        <option value="ANTONIO NARIÑO">ANTONIO NARIÑO</option>
                                        <option value="BARRIOS UNIDOS">BARRIOS UNIDOS</option>
                                        <option value="BOSA">BOSA</option>
                                        <option value="CHAPINERO">CHAPINERO</option>
                                        <option value="CIUDAD BOLÍVAR">CIUDAD BOLÍVAR</option>
                                        <option value="ENGATIVÁ">ENGATIVÁ</option>
                                        <option value="FONTIBÓN">FONTIBÓN</option>
                                        <option value="KENNEDY">KENNEDY</option>
                                        <option value="LA CANDELARIA">LA CANDELARIA</option>
                                        <option value="LOS MÁRTIRES">LOS MÁRTIRES</option>
                                        <option value="PUENTE ARANDA">PUENTE ARANDA</option>
                                        <option value="RAFAEL URIBE URIBE">RAFAEL URIBE URIBE</option>
                                        <option value="SAN CRISTÓBAL">SAN CRISTÓBAL</option>
                                        <option value="SANTA FE">SANTA FE</option>
                                        <option value="SUBA">SUBA</option>
                                        <option value="SUMAPAZ">SUMAPAZ</option>
                                        <option value="TEUSAQUILLO">TEUSAQUILLO</option>
                                        <option value="TUNJUELITO">TUNJUELITO</option>
                                        <option value="USAQUÉN">USAQUÉN</option>
                                        <option value="USME">USME</option>
                                    </select>
                                </div>              
                            </div>

                        <!-- PROYECTO -->
                            <div class="row  mt-3 " style="width: 100%;">
                                <div class="label">
                                    <label>Proyecto</label>
                                </div>
                                <div class="input">
                                    <select name="proyecto" id="proyecto" class="form-control selectpicker" data-live-search="true"> 
                                        <option value="">SELECCIONAR</option>
                                        <option value="VEJEZ">VEJEZ</option>
                                        <option value="DISCAPACIDAD">DISCAPACIDAD</option>
                                        <option value="EMPRESARIAL">EMPRESARIAL</option>
                                        <option value="INFANCIA">INFANCIA</option>
                                    </select> 
                                </div>              
                            </div>
                                           
                        <!-- UNIDAD OPERATIVA -->
                            <div class="row  mt-3 " style="width: 100%;">
                                <div class="label">
                                    <label>Unidad Operativa</label>
                                </div>
                                <div class="input">
                                    <select name="unidad_operativa" id="unidad_operativa" class="form-control selectpicker" data-live-search="true" onchange="validarCodigoIdent(this.value);"> 
                                        <option value="">SELECCIONAR</option>
                                        <?php foreach ($listarUnidadesOperativasProgramacion as $uop){ ?>
                                            <option value="<?php echo $uop['id_unidad'] ?>"><?php echo utf8_encode($uop['unidad_operativa']); ?></option>

                                        <?php } ?>
                                    </select> 
                                </div>              
                            </div>
                                           
                        <!-- CODIGO IDENTIFICATIVO-->
                            <div class="row  mt-3 " style="width: 100%;">
                                <div class="label">
                                    <label>Codigo Identificativo</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="codigo_identificativo" id="codigo_identificativo" class="form-control"/> 
                                </div>              
                            </div>
                                           
                        <!-- CANT PASAJEROS-->
                            <div class="row  mt-3 " style="width: 100%;">
                                <div class="label">
                                    <label>Frecuencia</label>
                                </div>
                                <div class="input">
                                    <select name="frecuencia[]" id="frecuencia" class="form-control selectpicker" data-live-search="true" multiple="multiple"> 
                                        <option value="LUNES">LUNES</option>
                                        <option value="MARTES">MARTES</option>
                                        <option value="MIERCOLES">MIERCOLES</option>
                                        <option value="JUEVES">JUEVES</option>
                                        <option value="VIERNES">VIERNES</option>
                                        <option value="SABADO">SABADO</option>
                                        <option value="DOMINGO">DOMINGO</option>
                                    </select>
                                </div>              
                            </div>
                                           
                        <!-- CANT PASAJEROS-->
                            
                            <div class="row mt-3" style="width: 100%;">
                                <div class="label">
                                    <label>Hora</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="horario" id="horario" class="form-control clockpicker" readonly="true"> 
                                </div> 
                            </div>    

                            <div class="row mt-3" style="width: 100%;">
                                <div class="label">
                                    <label>Entrada o Salida</label>
                                </div>
                                <div class="input">
                                    <select name="entrada_salida" id="entrada_salida" class="form-control selectpicker" data-live-search="true" > 
                                        <option value="">SELECCIONAR</option>
                                        <option value="E">ENTRADA</option>
                                        <option value="S">SALIDA</option>
                                    </select> 
                                </div>             
                            </div>
                                           
                        <!-- CANT PASAJEROS-->
                            <div class="row mt-3" style="width: 100%;">
                                <div class="label">
                                    <label>Punto Inicio</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="punto_inicio" id="punto_inicio" class="form-control">
                                </div>  
                            </div>

                            <div class="row mt-3" style="width: 100%;">
                                <div class="label">
                                    <label>Punto Fin</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="punto_final" id="punto_final" class="form-control">  
                                </div> 
                            </div>
                                        
                        <!-- CANT PASAJEROS-->
                            <div class="row  mt-3 " style="width: 100%;">
                                <div class="label">
                                    <label>Capacidad del Servicio</label>
                                </div>
                                <div class="input">
                                    <input name="capacidad_servicio" id="capacidad_servicio" class="form-control" /> 
                                </div>              
                            </div>
                                           
                        <!-- PLACA-->
                            <div class="row  mt-3 " style="width: 100%;">
                                <div class="label">
                                    <label>Vehiculo (Placa a Liquidar)</label>
                                </div>
                                <div class="input">
                                    <select name="id_vehiculo" id="id_vehiculo" class="form-control selectpicker" data-live-search="true" onchange="listarConductoresPorVehiculo(this.value);"> 
                                        <option value="">SELECCIONAR</option>
                                        <?php foreach ($listarVehiculos as $lv){ 
                                            $listarVehiculoPorId = $vehiculo->listarPorId($lv['id_vehiculo']); 
                                            $listarTipoPorId = $tipovehiculo->listarPorId($listarVehiculoPorId[0]['id_tipo_vehiculo']); ?>

                                            <option value="<?php echo $listarVehiculoPorId[0]['id_vehiculo'] ?>"><?php echo $listarVehiculoPorId[0]['placa'] . ' - ' . $listarTipoPorId[0]['nombre_tipo_vehiculo']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>              
                            </div>
                                           
                        <!-- CANT PASAJEROS-->
                            <div class="row  mt-3 " style="width: 100%;">
                                <div class="label">
                                    <label>Conductor</label>
                                </div>
                                <div class="input">
                                    <select name="id_conductor" id="id_conductor" class="form-control"> 
                                    </select>
                                </div>              
                            </div>
                                           
                        <!-- CANT PASAJEROS-->
                            <div class="row  mt-3 " style="width: 100%;">
                                <div class="label">
                                    <label>Nombre Monitor/@</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="nombre_monitora" id="nombre_monitora" class="form-control"> 
                                </div>              
                            </div>
                                           
                        <!-- CANT PASAJEROS-->
                            <div class="row  mt-3 " style="width: 100%;">
                                <div class="label">
                                    <label>Télefono Contacto Monitor/@</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="telefono_monitora" id="telefono_monitora" class="form-control">
                                </div>              
                            </div>
                                           
                        <!-- CANT PASAJEROS-->
                            <div class="row  mt-3 " style="width: 100%;">
                                <div class="label">
                                    <label>Valor a Pagar Vehículo</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="valor_pagar" id="valor_pagar" class="form-control" data-type="currency">
                                </div>              
                            </div>

                        <!-- CANT PASAJEROS-->
                            <div class="row  mt-3 " style="width: 100%;">
                                <div class="label">
                                    <label>Valor a Pagar Monitora</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="valor_pagar_monitora" id="valor_pagar_monitora" class="form-control" data-type="currency">
                                </div>              
                            </div>
                                           
                        <!-- CANT PASAJEROS-->
                            <div class="row  mt-3 " style="width: 100%;">
                                <div class="label">
                                    <label>Valor a Facturar</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="valor_facturar" id="valor_facturar" class="form-control" data-type="currency">
                                </div>              
                            </div>
                                           
                        <!-- CANT PASAJEROS-->
                            <div class="row  mt-3 " style="width: 100%;">
                                <div class="label">
                                    <label>Observaciones</label>
                                </div>
                                <div class="input">
                                    <select name="confirmarObservaciones" id="confirmarObservaciones" class="form-control" onchange="confirmarObservacionesProgramacion(this.value);"> 
                                        <option value="">SELECCIONAR</option>
                                        <option value="S">SI</option>
                                        <option value="N">NO</option>
                                    </select>
                                </div>              
                            </div>
                                           
                        <!-- CANT PASAJEROS-->
                            <div class="row mt-3 mb-4" style="width: 100%;">
                                <div class="label"></div>
                                <div class="input" id="observ" style="display: none;">
                                    <textarea name="observaciones" id="observaciones" class="form-control"></textarea>
                                </div>
                            </div>

                    <section class="col-12 mt-5 d-flex justify-content-center">
                        <a href="programaciones.php" class="btn btn-danger col-3 mr-3">Cancelar</a>
                        <button type="submit" class="btn btn-info col-3">Registrar</button>
                    </section>

    	        </form>
            <!--FIN FORMULARIO-->

            </div>
        </section>

    </section>

    <?php include("Template/scripts.php"); ?>
    <script type="text/javascript">

    	$('.clockpicker').clockpicker({
            placement: 'bottom',
            align: 'left',
            autoclose: true,
        });

        $('#capacidad').keypress(function (tecla) {
            if (tecla.charCode < 48 || tecla.charCode > 57) return false;
        });

        $('#valor_pagar').keypress(function (tecla) {
            if (tecla.charCode < 48 || tecla.charCode > 57) return false;

        });

        $('#valor_facturar').keypress(function (tecla) {
            if (tecla.charCode < 48 || tecla.charCode > 57) return false;
        });

        function validarCodigoIdent(val){
            if (val != '') {
                var proyecto = document.getElementById('proyecto').value;

                var parametros = {
                    "proyecto" : proyecto,
                    "unidad_operativa" : val
                };
                $.ajax({
                    data: parametros,
                    url: '../Controlador/validarCodigoProyectoProgramacion.php',
                    type: 'POST',
                    beforeSend: function () {
                        $("#codigo_identificativo").val('Validando Codigo');
                    },
                    success:  function (response) { 
                        //alert(response);
                        $("#codigo_identificativo").val(response);
                    }
                });
            }else{
                $("#codigo_identificativo").val("");
            }
        }

        function listarConductoresPorVehiculo(id_vehiculo){
            //alert(id_vehiculo);
            var parametros = {
                "id_vehiculo" : id_vehiculo
            };
            $.ajax({
                data: parametros,
                url: '../Controlador/listarConductoresPorVehiculo.php',
                type: 'POST',
                beforeSend: function () {
                    $("#id_conductor").html('<option value=""> Cargando Conductores</option>');
                },
                success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                        //alert(response);
                        $("#id_conductor").html(response);
                }
            });
        }

        function confirmarObservacionesProgramacion(value){
            if (value == 'S') {
                document.getElementById('observ').style.display = 'flex';
            } else {
                document.getElementById('observ').style.display = 'none';
            }
        }

    </script>
    
</body>
</html>