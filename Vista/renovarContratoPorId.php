<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Contrato.php");


/* VARIABLES MENU*/
$titulo = 'Renovar Contrato';
$redireccion = 'contratos.php';
$icono = 'fa fa-file-text-o';

/**/
$id_contrato = $_GET['id_contrato'];

$contrato = new Contrato();
$listarContratoPorId = $contrato->listarId($id_contrato);

 ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Generar Contrato</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>
    
    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Renovar Contrato</li>
         </ol>
    </div>


    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
            <!--FORMULARIO -->

	            <form method="POST" action="../Controlador/renovarContrato.php" enctype="multipart/form-data">
	            	    <?php include("Template/header-form.php"); ?>

			            <hr>

			            <?php foreach ($listarContratoPorId as $lci){ ?>
			            
			                <!--Id_contrato-->
			                <input type="hidden" name="id_contrato" id="id_contrato" class="form-control" value="<?php echo $lci['id_contrato'] ?>">
			            
				            <!-- Contrato -->

			                    <div class="row mt-3">
			                    	<section class="label">
					     	            <label>Fotocopia del Contrato</label>
					     	        </section>
			                    	<section class="input">
							     	    <input type="file" name="doc_fotocopia_contrato" id="doc_fotopia_contrato" class="form-control">
										<input type="hidden" name="act_certificados_cursos" id="act_certificados_cursos" class="form-control" value="<?php echo $lci['doc_fotocopia_contrato']; ?>">

							     	    <?php if ($lic['doc_fotocopia_contrato'] == '') { ?>
						        	    	<label class="mt-2" for="act_certificados_cursos"><strong>Documento Actual: </strong> No hay documentos cargados</label>
							        	<?php } else{ ?>
							        	    <label class="mt-2" for="act_certificados_cursos"><strong>Documento Actual: </strong> <a target="_blank" href="http://186.155.38.170:91/Contratos/<?php  echo $lic['doc_fotocopia_contrato'] ?>"><?php echo $lic['doc_fotocopia_contrato'] ?> <span class="fa fa-eye"></span> </a></label>
							        	<?php }  ?>
					     	        </section>
			                    </div>

		                    <!--Fecha Inicio-->
		                    
			                    <div class="row mt-3 ">
			                    	<section class="label">
			                    	 	<label>Fecha inicial del contrato</label>
			                    	</section>
			                    	<section class="input">
			                    	 	<input type="text" name="fecha_inicial_contrato" id="datepicker" class="form-control" value="<?php echo $lci['fecha_inicial_contrato'] ?>">
			                    	 	<input type="hidden" name="act_fecha_inicial_contrato" id="act_fecha_inicial_contrato" class="form-control" value="<?php echo $lci['fecha_inicial_contrato'] ?>">
			                    	</section>
			                    </div>

		     	   			<!--Fecha final-->

			     	   			<div class="row mt-3 " id="fechaFinal">
			                    	<section class="label">
			     	                    <label>Fecha final del contrato </label>
			     	                </section>
			                    	<section class="input">
			     	                    <input type="text" name="fecha_final_contrato" id="datepicker1" class="form-control" value="<?php echo $lci['fecha_final_contrato'] ?>">
			     	                    <input type="hidden" name="act_fecha_final_contrato" id="act_fecha_final_contrato" class="form-control" value="<?php echo $lci['fecha_final_contrato'] ?>">
			     	                </section>
			                    </div>

			            <?php } ?>

                        <hr>
                        <?php include("Template/bottom-form.php"); ?>
	            </form> 
        </div>
    </section>



    <?php include("Template/scripts.php"); ?>

	<script type="text/javascript">


        $( function() {
            $("#datepicker").datepicker({ 
            	dateFormat:'yy-mm-dd',
            	minDate: document.getElementById('datepicker').value,
            	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'], 
            	dayNames: ['Domingo', 'Lunes', 'Martes', 'Mi&eacute;rcoles', 'Jueves', 'Viernes', 'S&aacute;bado'],
            	dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mi&eacute;', 'Juv', 'Vie', 'S&aacute;b'], 
            	dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'S&aacute;']
           	});

           	$("#datepicker1").datepicker({ 
            	dateFormat:'yy-mm-dd',
            	minDate: document.getElementById('datepicker1').value,
            	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'], 
            	dayNames: ['Domingo', 'Lunes', 'Martes', 'Mi&eacute;rcoles', 'Jueves', 'Viernes', 'S&aacute;bado'],
            	dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mi&eacute;', 'Juv', 'Vie', 'S&aacute;b'], 
            	dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'S&aacute;']
           	});

        } );
        

	</script>

</body>
</html>