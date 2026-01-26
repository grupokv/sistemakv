<?php 
include ("../Controlador/Sesion/autenticar.php");

/* VARIABLES MENU*/
$titulo = 'Activar Aval';
$redireccion = 'avalVehiculosCartera.php';
$icono = 'fa fa-server';

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Eximir Aval</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- STYLES -->
        <?php include("Template/styles.php"); ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
    <!-- FIN STYLES -->
    
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
             <ol class="breadcrumb" style="background-color: #fff;">
                <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                <li class="breadcrumb-item " aria-current="page"><a href="avalVehiculosCartera.php">Avales</a></li>
                <li class="breadcrumb-item active" aria-current="page">Eximir Aval</li>
             </ol>
        </div>

        <section class="form-usuarios mt1">
            <div class="formulario mb-5">

                <form action="../Controlador/eximirCobroAval.php" method="POST">

					<!--FECHA -->
						<div class="row mt-3" id="mes">
							<div class="label">
								<label>Mes Activación</label>
							</div>
							<div class="input">
							    <input type="text" name="mes_activacion" id="mes_activacion" class="form-control" onblur="validarAvalMes(this.value);">
							</div>
					    </div>

                    <div id="dataAval"></div>

                    <!-- BOTONES -->
                            
                        <section class="col-12 mt-5 d-flex justify-content-center">
                              
                            <!-- CANCELAR REGISTRO -->
                                <a href="avalVehiculosCartera.php" class="btn btn-outline-danger col-xs-12 col-sm-12 col-md-3 mr-3">Cancelar</a>
                              
                            <!-- REGISTRAR -->
                                <button type="submit" id="Registrar" class="btn btn-outline-success col-xs-12 col-sm-12 col-md-3">Eximir</button>
                          
                        </section>

                </form>
            </div>
        </section>

    </section>


    <?php include("Template/scripts.php"); ?>

    <script>

	  	$('#valor_aval').keypress(function (tecla) {
            if (tecla.charCode < 48 || tecla.charCode > 57) return false;
        });

        $("#mes_activacion").MonthPicker({
		    IsRTL: true,
		    i18n: {
		        months: ["Enero", "Feb", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agos", "Sept", "Oct","Nov", "Dic"],
		    }
	    });

        $('#mes_activacion').MonthPicker('option', 'Button', false );
    	
    	function validarAvalMes(mes){
            var parametros = {
                "mes" : mes
            };
            $.ajax({
                data:  parametros,
                url:   '../Controlador/cargarAvalesVehiculosMes.php',
                type:  'POST',
                beforeSend: function () {
                },
                success:  function (response) {
                    //alert(response);
                    $("#dataAval").html(response); 
                    $("#aval").attr("multiple", 'multiple');
                    $('#aval').chosen();
                }
            });
    	}

    </script>
</body>
</html>

