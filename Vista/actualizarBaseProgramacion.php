<?php

include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Programacion.php");
require_once ("../Modelo/TipoVehiculo.php");
require_once ("../Modelo/Vehiculo.php");

/* VARIABLES MENU*/
$titulo = 'Actualizar Programación';
$redireccion = 'programaciones.php';
$icono = 'fa fa-file-text-o';

$id_programacion = $_GET['id'];
$id_contrato = 250;

$tipovehiculo = new TipoVehiculo();
$programacion = new Programacion();
$vehiculo = new Vehiculo();

$listar_programacion_serviciosID = $programacion->listar_programacion_serviciosID($id_programacion);
$listarUnidadesOperativasProgramacion = $programacion->listarUnidadesOperativasProgramacion();
$listarVehiculos = $vehiculo->listarVehiculosPorContrato($id_contrato);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar Programación</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>

</head>
<body>

    <section class="home_content">   
        <?php include("Template/newMenu.php"); ?>


    	<div aria-label="breadcrumb" class="mt-1"> 
             <ol class="breadcrumb">
                <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                <li class="breadcrumb-item " aria-current="page"><a href="vehiculos.php">Programaciones</a></li>
                <li class="breadcrumb-item active" aria-current="page">Actualización</li>
             </ol>
        </div>

        <section class="form-usuarios mt-1">
            <div class="formulario mb-5">
    	        <form action="../Controlador/actualizarProgramacionServicio.php" method="POST" name="formulario_registro" id="formulario_registro">
                    <?php include("Template/header-form.php"); ?>
        	        	
                        <?php foreach ($listar_programacion_serviciosID as $lpsID){ ?> 

                            <input type="hidden" class="form-control" name="id_programacion" id="id_programacion" value="<?php echo $lpsID['id_programacion']; ?>">


                                           
                            <!-- VALOR A FACTURAR -->
                                <div class="row  mt-3 " style="width: 100%;">
                                    <div class="label">
                                        <label>Codigo Identificativo</label>
                                    </div>
                                    <div class="input">
                                        <input type="text" name="codigo_identificativo" id="codigo_identificativo" class="form-control" value="<?php echo $lpsID['codigo_identificativo']; ?>" readonly>
                                    </div>              
                                </div>

                            <!-- LOCALIDAD -->
                                <div class="row  mt-3" style="width: 100%;">
                                    <div class="label">
                                        <label>Localidad</label>
                                    </div>
                                    <div class="input">
                                        <select name="localidad" id="localidad" class="form-control selectpicker" data-live-search="true" > 
                                            <option value="">SELECCIONAR</option>
                                            
                                            <option value="ANTONIO NARIÑO" <?php if ($lpsID['localidad'] == 'ANTONIO NARIÑO'){ ?> selected="selected" <?php } ?> >ANTONIO NARIÑO</option>
                                            <option value="BARRIOS UNIDOS" <?php if (utf8_decode($lpsID['localidad']) == 'BARRIOS UNIDOS'){ ?> selected="selected" <?php } ?> >BARRIOS UNIDOS</option>
                                            <option value="BOSA" <?php if ($lpsID['localidad'] == 'BOSA'){ ?> selected="selected" <?php } ?>>BOSA</option>
                                            <option value="CHAPINERO" <?php if ($lpsID['localidad'] == 'CHAPINERO'){ ?> selected="selected" <?php } ?>>CHAPINERO</option>
                                            <option value="CIUDAD BOLÍVAR" <?php if ($lpsID['localidad'] == 'CIUDAD BOLÍVAR'){ ?> selected="selected" <?php } ?>>CIUDAD BOLÍVAR</option>
                                            <option value="ENGATIVÁ" <?php if ($lpsID['localidad'] == 'ENGATIVÁ'){ ?> selected="selected" <?php } ?>>ENGATIVÁ</option>
                                            <option value="FONTIBÓN" <?php if ($lpsID['localidad'] == 'FONTIBÓN'){ ?> selected="selected" <?php } ?>>FONTIBÓN</option>
                                            <option value="KENNEDY" <?php if ($lpsID['localidad'] == 'KENNEDY'){ ?> selected="selected" <?php } ?>>KENNEDY</option>
                                            <option value="LA CANDELARIA" <?php if ($lpsID['localidad'] == 'LA CANDELARIA'){ ?> selected="selected" <?php } ?>>LA CANDELARIA</option>
                                            <option value="LOS MÁRTIRES" <?php if ($lpsID['localidad'] == 'LOS MÁRTIRES'){ ?> selected="selected" <?php } ?>>LOS MÁRTIRES</option>
                                            <option value="PUENTE ARANDA" <?php if ($lpsID['localidad'] == 'PUENTE ARANDA'){ ?> selected="selected" <?php } ?>>PUENTE ARANDA</option>
                                            <option value="RAFAEL URIBE URIBE" <?php if ($lpsID['localidad'] == 'RAFAEL URIBE URIBE'){ ?> selected="selected" <?php } ?>>RAFAEL URIBE URIBE</option>
                                            <option value="SAN CRISTÓBAL" <?php if ($lpsID['localidad'] == 'SAN CRISTÓBAL'){ ?> selected="selected" <?php } ?>>SAN CRISTÓBAL</option>
                                            <option value="SANTA FE" <?php if ($lpsID['localidad'] == 'SANTA FE'){ ?> selected="selected" <?php } ?>>SANTA FE</option>
                                            <option value="SUBA" <?php if ($lpsID['localidad'] == 'SUBA'){ ?> selected="selected" <?php } ?>>SUBA</option>
                                            <option value="SUMAPAZ" <?php if ($lpsID['localidad'] == 'SUMAPAZ'){ ?> selected="selected" <?php } ?>>SUMAPAZ</option>
                                            <option value="TEUSAQUILLO" <?php if ($lpsID['localidad'] == 'TEUSAQUILLO'){ ?> selected="selected" <?php } ?>>TEUSAQUILLO</option>
                                            <option value="TUNJUELITO" <?php if ($lpsID['localidad'] == 'TUNJUELITO'){ ?> selected="selected" <?php } ?>>TUNJUELITO</option>
                                            <option value="USAQUÉN" <?php if ($lpsID['localidad'] == 'USAQUÉN'){ ?> selected="selected" <?php } ?>>USAQUÉN</option>
                                            <option value="USME" <?php if ($lpsID['localidad'] == 'USME'){ ?> selected="selected" <?php } ?>>USME</option>
                                        </select>
                                    </div>              
                                </div>


                                           
                        <!-- PROYECTO -->
                            <div class="row  mt-3 " style="width: 100%;">
                                <div class="label">
                                    <label>Proyecto</label>
                                </div>
                                <div class="input">
                                    <select name="proyecto" id="preoyecto" class="form-control selectpicker" data-live-search="true" > 
                                        <option value="">SELECCIONAR</option>
                                        <option value="VEJEZ" <?php if ($lpsID['proyecto'] == 'VEJEZ'){ ?> selected="selected" <?php } ?>>VEJEZ</option>
                                        <option value="DISCAPACIDAD" <?php if ($lpsID['proyecto'] == 'DISCAPACIDAD'){ ?> selected="selected" <?php } ?>>DISCAPACIDAD</option>
                                        <option value="EMPRESARIAL" <?php if ($lpsID['proyecto'] == 'EMPRESARIAL'){ ?> selected="selected" <?php } ?>>EMPRESARIAL</option>
                                        <option value="INFANCIA" <?php if ($lpsID['proyecto'] == 'INFANCIA'){ ?> selected="selected" <?php } ?>>INFANCIA</option>
                                    </select> 
                                </div>              
                            </div>


                                           
                        <!-- UNIDAD OPERATIVA -->
                            <div class="row  mt-3 " style="width: 100%;">
                                <div class="label">
                                    <label>Unidad Operativa</label>
                                </div>
                                <div class="input">
                                    <select name="unidad_operativa" id="unidad_operativa" class="form-control selectpicker" data-live-search="true" > 
                                        <option value="">SELECCIONAR</option>
                                        <?php foreach ($listarUnidadesOperativasProgramacion as $uop){ ?>
                                            <option value="<?php echo $uop['id_unidad'] ?>" <?php if ($uop['id_unidad'] == $lpsID['unidad_operativa']){ ?> selected ="selected" <?php } ?> ><?php echo utf8_encode($uop['unidad_operativa']); ?></option>
                                        <?php } ?>
                                    </select> 
                                </div>              
                            </div>


                        <!-- FRECUENCIA -->
                            <div class="row  mt-3 " style="width: 100%;">
                                <div class="label">
                                    <label>Frecuencia</label>
                                </div>
                                <div class="input">
                                    <select name="frecuencia[]" id="frecuencia" class="form-control selectpicker" data-live-search="true" multiple="multiple"> 
                                        <?php $frecuencia = explode(",", $lpsID['frecuencia']); ?>

                                            <option value="LUNES" <?php if(in_array("LUNES", $frecuencia)){ ?> selected="selected"<?php }?> >LUNES</option>
                                            <option value="MARTES" <?php if(in_array('MARTES', $frecuencia)){ ?> selected="selected" <?php }?> >MARTES</option>
                                            <option value="MIERCOLES" <?php if(in_array('MIERCOLES', $frecuencia)){ ?> selected="selected" <?php }?> >MIERCOLES</option>
                                            <option value="JUEVES" <?php if(in_array('JUEVES', $frecuencia)){ ?> selected="selected" <?php }?> >JUEVES</option>
                                            <option value="VIERNES" <?php if(in_array('VIERNES', $frecuencia)){ ?> selected="selected" <?php }?> >VIERNES</option>
                                            <option value="SABADO" <?php if(in_array('SABADO', $frecuencia)){ ?> selected="selected" <?php }?> >SABADO</option>
                                            <option value="DOMINGO" <?php if(in_array('DOMINGO', $frecuencia)){ ?> selected="selected" <?php }?> >DOMINGO</option>

                                    </select>
                                </div>              
                            </div>      


                                           
                        <!--HORA -->
                            
                            <div class="row mt-3" style="width: 100%;">
                                <div class="label">
                                    <label>Hora</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="horario" id="horario" class="form-control clockpicker" readonly="true" value="<?php echo $lpsID['horario']; ?>"> 
                                </div> 
                            </div>  

                        <!--ENTRADA / SALIDA -->

                            <div class="row mt-3" style="width: 100%;">
                                <div class="label">
                                    <label>Entrada o Salida</label>
                                </div>
                                <div class="input">
                                    <select name="entrada_salida" id="entrada_salida" class="form-control selectpicker" data-live-search="true" > 
                                        <option value="">SELECCIONAR</option>
                                        <option value="E" <?php if($lpsID['entrada_salida'] == 'E'){ ?> selected="selected" <?php } ?>>ENTRADA</option>
                                        <option value="S" <?php if($lpsID['entrada_salida'] == 'S'){ ?> selected="selected" <?php } ?>>SALIDA</option>
                                    </select> 
                                </div>             
                            </div>
                                           
                        <!-- PUNTO INICIAL -->

                            <div class="row mt-3" style="width: 100%;">
                                <div class="label">
                                    <label>Punto Inicio</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="punto_inicio" id="punto_inicio" class="form-control" value="<?php echo $lpsID['punto_inicio']; ?>">
                                </div>  
                            </div>
                                           
                        <!-- PUNTO FINAL -->

                            <div class="row mt-3" style="width: 100%;">
                                <div class="label">
                                    <label>Punto Fin</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="punto_final" id="punto_final" class="form-control" value="<?php echo $lpsID['punto_final']; ?>">  
                                </div> 
                            </div>

                                           
                        <!-- CAPACIDAD SERVICIO -->
                            <div class="row  mt-3 " style="width: 100%;">
                                <div class="label">
                                    <label>Capacidad del Servicio</label>
                                </div>
                                <div class="input">
                                    <select name="capacidad_servicio" id="capacidad_servicio" class="form-control selectpicker" data-live-search="true" > 
                                        <option value="">SELECCIONAR</option>
                                        <option value="25" <?php if($lpsID['capacidad_servicio'] == 25){ ?> selected="selected" <?php } ?> >25</option>
                                        <option value="30" <?php if($lpsID['capacidad_servicio'] == 30){ ?> selected="selected" <?php } ?> >30</option>
                                    </select> 
                                </div>               
                            </div>
                                           
                        <!-- PLACA FACT-->
                            <div class="row  mt-3 " style="width: 100%;">
                                <div class="label">
                                    <label>Placa a Facturar</label>
                                </div>
                                <div class="input">
                                    <select name="id_vehiculo_facturacion" id="id_vehiculo_facturacion" class="form-control selectpicker" data-live-search="true" > 
                                        <option value="">SELECCIONAR</option> 
                                        <?php foreach ($listarVehiculos as $lv){
                                            $listarVehiculoPorId = $vehiculo->listarPorId($lv['id_vehiculo']); 
                                            $listarTipoPorId = $tipovehiculo->listarPorId($listarVehiculoPorId[0]['id_tipo_vehiculo']); ?>

                                            <option value="<?php echo $listarVehiculoPorId[0]['id_vehiculo'] ?>" <?php if($lpsID['id_vehiculo_facturacion'] == $lv['id_vehiculo']){ ?> selected="selected" <?php } ?> ><?php echo $listarVehiculoPorId[0]['placa'] . ' - ' . $listarTipoPorId[0]['nombre_tipo_vehiculo']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>              
                            </div>


                                           
                        <!-- CANT PASAJEROS-->
                            <div class="row  mt-3 " style="width: 100%;">
                                <div class="label">
                                    <label>Placa a Liquidar</label>
                                </div>
                                <div class="input">
                                    <select name="id_vehiculo_liquidacion" id="id_vehiculo_liquidacion" class="form-control selectpicker" data-live-search="true" onchange="listarConductoresPorVehiculo(this.value);"> 
                                        <option value="">SELECCIONAR</option>
                                        <?php foreach ($listarVehiculos as $lv){ 
                                            $listarVehiculoPorId = $vehiculo->listarPorId($lv['id_vehiculo']); 
                                            $listarTipoPorId = $tipovehiculo->listarPorId($listarVehiculoPorId[0]['id_tipo_vehiculo']); ?>

                                            <option value="<?php echo $listarVehiculoPorId[0]['id_vehiculo'] ?>" <?php if($lpsID['id_vehiculo_liquidacion'] == $lv['id_vehiculo']){ ?> selected="selected" <?php } ?> ><?php echo $listarVehiculoPorId[0]['placa'] . ' - ' . $listarTipoPorId[0]['nombre_tipo_vehiculo']; ?></option>
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

                                        <?php 
                                        $listarConductoresPorId = $vehiculo->listarConductoresPorId($lpsID['id_vehiculo_liquidacion']);
                                        foreach ($listarConductoresPorId as $lcpi){ ?>
                                            <option value="<?php echo $lcpi['id_conductor'] ?>" <?php if($lcpi['id_conductor'] == $lpsID['id_conductor']){ ?> selected="selected "<?php } ?> ><?php echo $lcpi['nombre_conductor'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>              
                            </div>
                                           
                        <!-- MONITOR -->
                            <div class="row  mt-3 " style="width: 100%;">
                                <div class="label">
                                    <label>Nombre Monitor/@</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="nombre_monitora" id="nombre_monitora" class="form-control" value="<?php echo $lpsID['nombre_monitora']; ?>"> 
                                </div>              
                            </div>
                                           
                        <!-- CONTACTO MONITOR -->
                            <div class="row  mt-3 " style="width: 100%;">
                                <div class="label">
                                    <label>Télefono Contacto Monitor/@</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="telefono_monitora" id="telefono_monitora" class="form-control" value="<?php echo $lpsID['telefono_monitora']; ?>">
                                </div>              
                            </div>
                                      
                        <!-- VALOR A PAGAR -->
                            <div class="row  mt-3 " style="width: 100%;">
                                <div class="label">
                                    <label>Valor a Pagar Vehículo</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="valor_pagar" id="valor_pagar" class="form-control" data-type="currency" value="<?php echo $lpsID['valor_pagar']; ?>">
                                </div>              
                            </div>
                                            
                        <!-- VALOR A PAGAR MONITORA-->
                            <div class="row  mt-3 " style="width: 100%;">
                                <div class="label">
                                    <label>Valor a Pagar Monitora</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="valor_pagar_monitora" id="valor_pagar_monitora" class="form-control" data-type="currency" value="<?php echo $lpsID['valor_pagar_monitora']; ?>">
                                </div>              
                            </div>
                                           
                        <!-- VALOR A FACTURAR -->
                            <div class="row  mt-3 " style="width: 100%;">
                                <div class="label">
                                    <label>Valor a Facturar</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="valor_facturar" id="valor_facturar" class="form-control" data-type="currency" value="<?php echo $lpsID['valor_facturar']; ?>">
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
                                        <option value="S" <?php if($lpsID['observaciones'] != 'NO HAY OBSERVACIONES'){ ?> selected="selected" <?php } ?>>SI</option>
                                        <option value="N" <?php if($lpsID['observaciones'] == 'NO HAY OBSERVACIONES'){ ?> selected="selected" <?php } ?>>NO</option>
                                    </select>
                                </div>              
                            </div>
                                         
                            <div class="row mt-3 mb-4" style="width: 100%;">
                                <div class="label"></div>
                                <div class="input" id="observ">
                                    <textarea name="observaciones" id="observaciones" class="form-control"><?php echo $lpsID['observaciones']; ?></textarea>
                                </div>
                            </div>

                                           
                                    
                            

                        <?php } ?>

    		        <?php include("Template/bottom-form.php") ?>
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

      /*  function confirmarObservacionesProgramacion(value){
            if (value == 'S') {
                document.getElementById('observ').style.display = 'flex';
            } else {
                document.getElementById('observ').style.display = 'none';
            }
        }*/

    </script>
    
</body>
</html>