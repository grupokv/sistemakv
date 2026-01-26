<?php 

include ("../Controlador/Sesion/autenticar.php");

include("../Modelo/Programacion.php");

include("../Modelo/Vehiculo.php");

include("../Modelo/TipoVehiculo.php");

include("../Modelo/Conductor.php");



/* VARIABLES MENU*/

$titulo = 'Seguimiento Servicio';

$redireccion = 'asignaciones.php';

$icono = 'fa fa-volume-control-phone';



$id_servicio = $_GET['ids'];



$programacion = new Programacion();

$detalle_servicio = $programacion->serviciosPorIdDetalle($id_servicio);

$detalle_asignado = $programacion->asignadoActivoPorServicio($id_servicio);



if($detalle_asignado[0]['id_usuario_seg_pre'] != ''){

    if ($detalle_asignado[0]['id_usuario_seg_pos'] != ''){

        $num = 3;

    } else {

        $num = 2;

    }

} else {

    $num = 1;

}



$vehiculo = new Vehiculo();

$listado_vehiculos = $vehiculo->listar();



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

            <?php if($num < 3){ ?>

	        <form action="../Controlador/registrarSeguimiento.php" method="post" data-toggle="validator" role="form" onsubmit="return checkSubmit();">

	        	<?php include("Template/header-form.php"); ?>

                    <!--NOMBRE AREA-->

                        

                        <input type="hidden" name="id_servicio" id="id_servicio" value="<?php echo $id_servicio;?>">

                        <input type="hidden" name="id_asignacion" id="id_asignacion" value="<?php echo $detalle_asignado[0]['id_asignacion'];?>">

                        <input type="hidden" name="num" id="num" value="<?php echo $num;?>">

                        <div class="row mt-3 mb-4">

                            <div class="label">

                                <label>Seguimiento No. <?php echo $num;?></label>

                            </div>

                            <div class="input">

                            </div>

                        </div>





                        <div class="row mt-3 mb-4">

                            <div class="label">

                                <label>Detalle Seguimiento</label>

                            </div>

                            <div class="input">

                                <textarea name="detalle" id="detalle" required="required" class="form-control">SIN NOVEDAD</textarea>

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



        <?php } else { ?>

            <form action="../Controlador/cerrarServicio.php" method="post" data-toggle="validator" role="form" onsubmit="return checkSubmit();">

                <?php include("Template/header-form.php"); ?>

                    <!--NOMBRE AREA-->

                        

                        <input type="hidden" name="id_servicio" id="id_servicio" value="<?php echo $id_servicio;?>">

                        <input type="hidden" name="id_asignacion" id="id_asignacion" value="<?php echo $detalle_asignado[0]['id_asignacion'];?>">

                        

                <div class="row justify-content-center botones-form mt-2 mb-5">

                    <div class="boton mt-2">

                            <a href="<?php echo $redireccion ?>" class="btn btn-danger btn-block">Cancelar</a>

                    </div>



                    <div class="boton mt-2">

                        <button type="submit" class="btn btn-primary btn-block" id="guardar">Finalizar Servicio</button>

                    </div>

                </div>

            </form>

        <?php } ?>

        </div>

    </section>





    <?php include("Template/scripts.php"); ?>

    <script>

        function cargar(id_vehiculo){

          //alert(id_vehiculo);

          if(id_vehiculo == 0){

            var parametros = {

              "id_vehiculo" : id_vehiculo

            };

            $.ajax({

                data:  parametros,

                url:   '../Controlador/listarVehiculos.php',

                type:  'post',

                beforeSend: function () {

                    //alert('envio');

                    $("#id_vehiculo").html("<option value='' disabled='disabled' selected='selected'>Cargando datos, por favor espere</option>");

                    $("#id_conductor").html("<option value='' selected='selected'>Seleccione</option>");

                },

                success:  function (response) {

                    //alert(response);

                    $("#id_vehiculo").html(response);

                }

            });

          } else{ 

            if(id_vehiculo != ''){

                var parametros = {

                  "id_vehiculo" : id_vehiculo

                };

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