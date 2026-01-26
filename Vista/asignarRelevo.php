<?php 
include ("../Controlador/Sesion/autenticar.php");
include("../Modelo/Programacion.php");
include("../Modelo/Vehiculo.php");
include("../Modelo/TipoVehiculo.php");
include("../Modelo/Conductor.php");

/* VARIABLES MENU*/
$titulo = 'Asignar Relevo';
$redireccion = 'asignaciones.php';
$icono = 'fa fa-exchange';

$id_servicio = $_GET['ids'];

$programacion = new Programacion();
$detalle_servicio = $programacion->serviciosPorIdDetalle($id_servicio);
$detalle_asignado = $programacion->asignadoActivoPorServicio($id_servicio);
$id_vehiculo_act = $detalle_asignado[0]['id_vehiculo'];
$vehiculo = new Vehiculo();
$listado_vehiculos = $vehiculo->listar();
$datos_vehiculo = $vehiculo->listarPorId($id_vehiculo_act);
$placa_act = $datos_vehiculo[0]['placa'];
$movil_act = $datos_vehiculo[0]['numero_movil'];
$tipovehiculo = new TipoVehiculo();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Asignar Relevo</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
    <script>
        if (history.forward(1)) {
            location.replace(history.forward(1));
        }   
    </script>
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="asignaciones.php">Asignaciones</a></li>
            <li class="breadcrumb-item active" aria-current="page">Asignar Relevo</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="formulario mb-5">
	        <form action="../Controlador/registrarRelevo.php" method="post" data-toggle="validator" role="form" onsubmit="return checkSubmit();">
	        	<?php include("Template/header-form.php"); ?>

                        <input type="hidden" name="id_servicio" id="id_servicio" value="<?php echo $id_servicio;?>">
                        <input type="hidden" name="id_asignacion" id="id_asignacion" value="<?php echo $detalle_asignado[0]['id_asignacion'];?>">
                        

                    <!-- TIPO VEHICULO CLIENTE-->
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>Tipo Vehiculo Cliente</label>
                            </div>
                            <div class="input">
                                <?php $tipov = $tipovehiculo->listarPorId($detalle_servicio[0]['id_tipovehiculo']); echo $tipov[0]['nombre_tipo_vehiculo'];?>
                            </div>
                        </div>

                    <!-- CANT PASAJEROS-->
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>Cantidad Pasajeros</label>
                            </div>
                            <div class="input">
                                <?php echo $detalle_servicio[0]['cantidad'];?>
                            </div>
                        </div>

                    <!-- TIPO RELEVO-->
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>Tipo de Relevo</label>
                            </div>
                            <div class="input">
                                <select name="tipo_relevo" id="tipo_relevo" onchange="tiporelevo(this.value)" required="required" class="form-control">
                                    <option value="">Seleccione Opción</option>
                                    <option value="RC">Relevo Conductor</option>
                                    <option value="RV">Relevo Vehiculo</option>
                                </select>
                            </div>
                        </div>

                    <!-- VEHICULO-->
                        <div class="row mt-3 mb-4" id="vehiculos" style="display:none">
                            <div class="label">
                                <label>Vehiculo</label>
                            </div>
                            <div class="input">
                                <select name="id_vehiculo" id="id_vehiculo" required="required" class="form-control" data-live-search="true" onchange="cargarConductorPorVehiculo(this.value); cargar(this.value);">
                                    
                                </select>
                            </div>
                        </div>

                    <!-- CONDUCTOR-->
                        <div class="row mt-3 mb-4" id="conductores" style="display:none">
                            <div class="label">
                                <label>Conductor</label>
                            </div>
                            <div class="input">
                                <select name="id_conductor" id="id_conductor" class="form-control"  required="required">
                                    
                                </select>
                            </div>
                        </div>


                    <!-- VALOR-->
                        <div class="row mt-3 mb-4" id="valor" style="display:none">
                            <div class="label">
                                <label>Tarifa Relevo</label>
                            </div>
                            <div class="input">
                                <input type="text" name="costo" id="costo" class="form-control"  required="required">
                            </div>
                        </div>
                    
                    <!-- BOTONES-->
                        <div class="row justify-content-center botones-form mt-2 mb-5">
                            <div class="boton mt-2">
                                    <a href="<?php echo $redireccion ?>" class="btn btn-danger btn-block">Cancelar</a>
                            </div>

                            <div class="boton mt-2">
                                <button type="submit" class="btn btn-primary btn-block" id="guardar">Guardar</button>
                            </div>
                        </div>

	        </form>
        </div>
    </section>


    <?php include("Template/scripts.php"); ?>
    <script>
        function tiporelevo(dato){
            if(dato != ''){  
                
                if(dato == 'RV'){
                    $("#id_conductor").html("<option value='SELECCIONAR'></option>");
                    cargarRelevosVehiculos(document.getElementById("id_servicio").value);
                } else if(dato == 'RC'){
                    $("#id_vehiculo").html("<option value='<?php echo $id_vehiculo_act ?>' selected='selected'><?php echo $placa_act . ' | ' . $movil_act; ?></option>");
                    cargarConductorPorVehiculo(<?php echo $id_vehiculo_act;?>);
                }
                document.getElementById('conductores').style.display = "flex";
                document.getElementById('vehiculos').style.display = "flex"; 
                document.getElementById('valor').style.display = "flex"; 
            } else {
                document.getElementById('conductores').style.display = "none";
                document.getElementById('vehiculos').style.display = "none";
                document.getElementById('valor').style.display = "none";
            }
        }


        function cargarRelevosVehiculos(id_servicio){

            var parametros = {
               "id_servicio" : id_servicio
            };
            $.ajax({
                data:  parametros,
                url:   '../Controlador/listarVehiculos.php',
                type:  'post',
                beforeSend: function () {
                    //alert('envio');
                    $("#id_vehiculo").html("<option value=''>Cargando datos, por favor espere</option>");
                },
                success:  function (response) {
                    $("#id_vehiculo").html(response);
                    //$("#id_vehiculo").addClass('selectpicker');
                }
            });
        }

        function cargarConductorPorVehiculo(id_vehiculo){

            var parametros = {
               "id_vehiculo" : id_vehiculo
            };
            $.ajax({
                data:  parametros,
                url:   '../Controlador/listarConductoresRelevo.php',
                type:  'post',
                beforeSend: function () {
                    //alert('envio');
                },
                success:  function (response) {
                    //alert(response);
                    $("#id_conductor").html(response);
                    //$("#id_vehiculo").addClass('selectpicker');
                }
            });
        }

        function cargar(id_vehiculo){
            //alert(id_vehiculo);
            if(id_vehiculo == 0){
                var parametros = {
                  "id_vehiculo" : id_vehiculo
                };
                $.ajax({
                    data:  parametros,
                    url:   '../Controlador/listarTodosVehiculos.php',
                    type:  'post',
                    beforeSend: function () {
                        //alert('envio');
                        $("#id_vehiculo").html("<option value='' disabled='disabled' selected='selected'>Seleccione un vehiculo</option>");
                    },
                    success:  function (response) {
                        //alert(response);
                        $("#id_vehiculo").html(response);
                    }
                });
            }
        }
    </script>
</body>
</html>