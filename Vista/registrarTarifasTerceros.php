<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/TipoVehiculo.php';
require_once("../Modelo/Contrato.php");

$id_contrato = $_GET['id_contrato'];
$contrato = new Contrato();


$id = '';
$titulo = '';
$icono = '';
$redireccion = '';

/* VARIABLES MENU*/

$titulo .= 'Registrar Tarifa de terceros';
$redireccion .= 'contratos.php';
$icono .= 'fa fa-gears';


$listarProyectosPorIdContrato = $contrato->listarProyectosContratos($id_contrato);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Proyecto</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>
    
    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="Contratos.php">Contratos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar Proyecto Proyectos</li>
         </ol>
    </div>


    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
            <!--FORMULARIO -->

	            <form action="../Controlador/registrarTarifasTerceros.php" method="POST">
	            	
	            	<?php include("Template/header-form.php"); ?>

	            		<input type="hidden" class="form-control" name="id_proyecto" id="id_proyecto" value="<?php echo $id_proyecto ?>">

                        <!-- Proyectos -->

                            <div class="row mt-3 mb-4">
                                <div class="label">
                                    <label>Proyecto</label>
                                </div>
                                <div class="input">
                                    <select name="id_proyecto" id="id_proyecto" required="required" class="form-control" onchange="listarTarifas(this.value);">
                                        <option value="" selected="selected">SELECCIONAR</option>
                                        <?php foreach ($listarProyectosPorIdContrato as $lppic) { ?>
                                            <option value="<?php echo $lppic['id_proyecto']; ?>"><?php echo $lppic['nombre_proyecto']; ?></option> 
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                        <!-- Tarifas -->

                            <div class="row mt-3 mb-4">
                                <div class="label">
                                    <label>Tarifa</label>
                                </div>
                                <div class="input">
                                    <select name="id_tarifa_proyecto" id="id_tarifa_proyecto" required="required" class="form-control">
                                    </select>
                                </div>
                            </div>
                            
                        <!-- Costo Servicio -->

                            <div class="row mt-3">
                                <section class="label">
                                    <label>Valor a pagar al tercero</label>
                                </section>
                                <section class="input">
                                        <input type="text" name="valor_tercero" id="valor_tercero" class="form-control" required="true">
                                </section>
                            </div>

                        <hr>

          
                    <?php include("Template/bottom-form.php"); ?>


	            </form> 
        </div>
    </section>



    <?php include("Template/scripts.php"); ?>
    
    <script type="text/javascript">
    
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
        
    </script>
    

</body>
</html>