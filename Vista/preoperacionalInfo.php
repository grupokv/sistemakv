<?php 
include ("../Controlador/Sesion/autenticar.php");
include("../Modelo/Vehiculo.php");

/* VARIABLES MENU*/
$titulo = 'Pre Operacional';
$redireccion = 'inicio.php';
$icono = 'fa fa-car';

$vehiculo = new Vehiculo();
$listarVehiculosActivos = $vehiculo->listarActivos();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registro Pre Operacional</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pre Operacional</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="formulario mb-5">
	        <form action="../Controlador/registrarPreoperacionales.php" method="POST">
	        	<?php include("Template/header-form.php"); ?>


                    <!--USUARIO-->
                        <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION['id_usuario'] ?>">

                    <!--VEHICULO-->
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>Vehiculo</label>
                            </div>
                            <div class="input">
                                <select name="id_vehiculo" id="id_vehiculo" required="required" class="form-control selectpicker" data-live-search="true" onchange="cargarConductores(this.value);">
                                    <option>SELECCIONAR</option>
                                    <?php foreach ($listarVehiculosActivos as $lva){ 
                                        $hoy = date('Y-m-d');
                                        $fecha2 = strtotime('-1 year',strtotime(date('Y-m-d')));
                                        $fecha2 = date('Y-m-d',$fecha2);
                                        $docs_vacios = $vehiculo->documentosvencidosPorId($lva['id_vehiculo'],$hoy,$fecha2);

                                        if(count($docs_vacios)>0){ ?>
                                            <option value="<?php echo $lva['id_vehiculo'] ?>" disabled style="color:red;font-weight:bolder" ><?php echo $lva['placa'] ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $lva['id_vehiculo'] ?>" ><?php echo $lva['placa'] ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                    <!--CONDUCTOR-->
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>Conductor</label>
                            </div>
                            <div class="input">
                                <select name="id_conductor" id="id_conductor" required="required" class="form-control">
                                    
                                </select>
                            </div>
                        </div>

                <?php include("Template/bottom-form.php"); ?>
	        </form>
        </div>
    </section>


    <?php include("Template/scripts.php"); ?>
    <script>
        function cargarConductores(id_vehiculo){
          //alert(id_departamento); 
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
    </script>
</body>
</html>