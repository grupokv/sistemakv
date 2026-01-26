<?php 
require_once ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Programacion.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/TipoVehiculo.php");
require_once("../Modelo/Conductor.php");
require_once("../Modelo/Contrato.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Cliente.php");


$titulo = '';
$redireccion = '';
$id = '';
$icono = '';


/* VARIABLES MENU*/
$titulo = 'Asignar Vehiculo';
$redireccion = 'asignaciones.php';
$icono = 'fa fa-car';

$id_servicio = $_GET['ids'];

$programacion = new Programacion();
$detalle_servicio = $programacion->serviciosPorIdDetalle($id_servicio);

$vehiculo = new Vehiculo();
$listado_vehiculos = $vehiculo->listarPorTipoVehiculo($detalle_servicio[0]['id_tipovehiculo']);

$empresa = new Empresa();
$tipovehiculo = new TipoVehiculo();
$cliente = new Cliente();

$contrato = new Contrato();
$listarContratosPorCliente = $contrato->listarPorCliente($detalle_servicio[0]['id_cliente']);


?>
<!DOCTYPE html>
<html>
<head><meta charset="euc-kr">
    
	<title>SistemaKV | Asignar Vehiculo</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="asignaciones.php">Asignaciones</a></li>
            <li class="breadcrumb-item active" aria-current="page">Asignar Vehiculo</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="formulario mb-5">
	        <form action="../Controlador/registrarAsignacion.php" method="post" data-toggle="validator" role="form" onsubmit="return checkSubmit();">
	        	<?php include("Template/header-form.php"); ?>
                    <!--NOMBRE AREA-->
                        
                        <input type="hidden" name="id_servicio" id="id_servicio" value="<?php echo $id_servicio;?>">

                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>Tipo Vehiculo Cliente</label>
                            </div>
                            <div class="input">
                                <?php $tipov = $tipovehiculo->listarPorId($detalle_servicio[0]['id_tipovehiculo']); echo $tipov[0]['nombre_tipo_vehiculo'];?>
                            </div>
                        </div>

                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>Cantidad Pasajeros</label>
                            </div>
                            <div class="input">
                                <?php echo $detalle_servicio[0]['cantidad'];?>
                            </div>
                        </div>

                        <!-- CONTRATO -->

                            <div class="row mt-3 mb-4">
                                <div class="label">
                                    <label>Contrato</label>
                                </div>
                                <div class="input">
                                    <select name="id_contrato" id="id_contrato" required="required" class="form-control" onchange="listarProyectos(this.value);">
                                        <option value="" selected="selected">Seleccione</option>
                                        <?php foreach ($listarContratosPorCliente as $lcpc){ 
                                             $hoy = date('Y-m-d');
                                             if($lcpc['fecha_final_contrato'] < $hoy){ ?>
                                                <option value="<?php echo $lcpc['id_contrato']; ?>" style="color:red;" disabled>
                                                    <?php
                                                        $emp = $empresa->listarPorId($lcpc['id_empresa']);
                                                        $cli = $cliente->listarClientePorId($lcpc['id_cliente']);
                                                        echo "No. interno ". $lcpc['id_contrato']." - CONTRATO No " . $lcpc['numero_contrato'] . " Entre " . $cli[0]['razon_social'] . " y " . $emp[0]['nombre_empresa'];                                                     ?>
                                                </option> 
					     <?php }else{ ?>
						 <option value="<?php echo $lcpc['id_contrato']; ?>">
                                                    <?php
                                                        $emp = $empresa->listarPorId($lcpc['id_empresa']);
                                                        $cli = $cliente->listarClientePorId($lcpc['id_cliente']);
                                                        echo "No. interno ". $lcpc['id_contrato']." - CONTRATO No " . $lcpc['numero_contrato'] . " Entre " . $cli[0]['razon_social'] . " y " . $emp[0]['nombre_empresa'];                                                     ?>
                                                </option> 
                                             <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                        <!-- PROYECTO -->

                            <div class="row mt-3 mb-4">
                                <div class="label">
                                    <label>Proyecto</label>
                                </div>
                                <div class="input">
                                    <select name="id_proyecto" id="id_proyecto" required="required" class="form-control" onchange="listarTarifas(this.value);">
                                    </select>
                                </div>
                            </div>

                        <!-- Valor a Cobrar Cliente -->

                            <div class="row mt-3 mb-4">
                                <div class="label">
                                    <label>Valor a Cobrar Cliente</label>
                                </div>
                                <div class="input">
                                    
                                    <select name="id_tarifa_proyecto" id="id_tarifa_proyecto" required="required" class="form-control" onchange="listarValorTerceros(this.value);">
                                    </select>
                                </div>
                            </div>

                        <!-- VEHICULO-->

                            <div class="row mt-3 mb-4">
                                <div class="label">
                                    <label>Vehiculo</label>
                                </div>
                                <div class="input">
                                    <select name="id_vehiculo" id="id_vehiculo" required="required" class="form-control" onchange="cargar(this.value)">
                                        
                                    </select>
                                </div>
                            </div>

                        <!-- CONDUCTOR-->

                            <div class="row mt-3 mb-4">
                                <div class="label">
                                    <label>Conductor</label>
                                </div>
                                <div class="input">
                                    <select name="id_conductor" id="id_conductor" class="form-control"  required="required">
                                        <option value="">Seleccione</option>
                                    </select>
                                </div>
                            </div>
                        
                        <!-- CONDUCTOR-->
                            <div class="row mt-3 mb-4">
                                <div class="label">
                                    <label>Costo del Vehiculo</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="costo_servicio" id="costo_servicio" required="required" class="form-control">
                                </div>
                            </div>

                        


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
    
        function listarValorTerceros(id_tarifa_proyecto){
            //alert(id_tarifa_proyecto);
            
            var parametros = {
              "id_tarifa_proyecto" : id_tarifa_proyecto
            };
            
            $.ajax({
                data:  parametros,
                url:   '../Controlador/listarValorTarifasAV.php',
                type:  'POST',
                beforeSend: function () {
                    $("#costo_servicio").val("Cargando valor, por favor espere.");
                },
                success:  function (response) {
                    //alert(response);
                    $("#costo_servicio").val(response);
                }
            });
        }

        function listarTarifas(id_proyecto){

            var parametros = {
              "id_proyecto" : id_proyecto
            };
            $.ajax({
                data:  parametros,
                url:   '../Controlador/listarTarifaPorProyectoAV.php',
                type:  'post',
                beforeSend: function () {
                    //alert('envio');
                    $("#id_tarifa_proyecto").html("<option value='' disabled='disabled' selected='selected'> Cargando valores, por favor espere.</option>");
                },
                success:  function (response) {
                    //alert(response);
                    $("#id_tarifa_proyecto").html(response);
                }
            });
        }
        

        function listarProyectos(id_contrato){
            var parametros = {
              "id_contrato" : id_contrato,
	      "contrato" : id_contrato
            };
            $.ajax({
                data:  parametros,
                url:   '../Controlador/listarProyectosPorContratoAV.php',
                type:  'post',
                beforeSend: function () {
                    //alert('envio');
                    $("#id_proyecto").html("<option value='' disabled='disabled' selected='selected'>Cargando valores, por favor espere.</option>");
                },
                success:  function (response) {
                    //alert(response);
                    $("#id_proyecto").html(response);
                }
            });
	 
	   $.ajax({
                data:  parametros,
                url:   '../Modelo/CargarVehiculosPorContrato.php',
                type:  'post',
                beforeSend: function () {
                    //alert('envio');
                    $("#id_vehiculo").html("<option value='' disabled='disabled' selected='selected'>Cargando valores, por favor espere.</option>");
                },
                success:  function (response) {
                    //alert(response);
                    $("#id_vehiculo").html(response);
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
                    $("#id_conductor").html("<option value='' selected='selected'>Seleccione</option>");
                },
                success:  function (response) {
                    
                    $("#id_vehiculo").html(response);
                }
            });
          } else{ 
            if(id_vehiculo != ''){
                var id_servicio = document.getElementById('id_servicio').value;
                var parametros = {
                  "id_vehiculo" : id_vehiculo,
                  "id_servicio" : id_servicio
                };

                $.ajax({
                    data:  parametros,
                    url:   '../Controlador/verificarDisponibilidadVehiculo.php',
                    type:  'post',
                    beforeSend: function () {
                        //alert('envio');
                        $("#id_conductor").html("<option value='' disabled='disabled' selected='selected'>Cargando datos, por favor espere</option>");
                    },
                    success:  function (response) {
                        //alert(response);
                        if(response == 1){
                            var r = confirm("El vehiculo ya tiene un servicio asignado, desea continuar?");
                            if (r == true) {
                              
                            } else {
                                cargar(0);
                            }
                        }
                    }
                });

                $.ajax({
                    data:  parametros,
                    url:   '../Controlador/listarConductoresVehiculo.php',
                    type:  'post',
                    beforeSend: function () {
                        //alert('envio');
                        $("#id_conductor").html("<option value='' disabled='disabled' selected='selected'>Cargando datos, por favor espere</option>");
                    },
                    success:  function (response) {
                        //alert(response);
                        $("#id_conductor").html(response);
                    }
                });
            }
          }
        }    
        function checkSubmit() {
        if (!enviando) {
            enviando = true;
            return true;
        } else {
            alert("El formulario ya se esta enviando");
            return false;
        }
    }    
    </script>
</body>
</html>