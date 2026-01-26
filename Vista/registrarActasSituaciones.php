<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/Usuario.php';
require_once '../Modelo/Actas.php';

$usuario = new Usuario();
$acta = new Acta();
$listarTodosUsuarios = $usuario->listarUsuariosInternosEmpresa();
$listarEstadoSituacion = $acta->listarEstadoSituacion();
$id_acta = $_GET['id_acta'];

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Actas</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- STYLES -->
		<?php include("Template/styles.php") ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
	    
	    <style type="text/css" media="screen">
	            
	        .wrapper{
	      		position: relative;
				display: inline-block;
				border: none;
			}

			.wrapper input {
			   border: 0;
			   width: 1px;
			   height: 1px;
			   overflow: hidden;
			   position: absolute !important;
			   clip: rect(1px 1px 1px 1px);
			   clip: rect(1px, 1px, 1px, 1px);
			   opacity: 0;
			}

			.wrapper label {
			   position: relative;
			   color: #C8C8C8;
			}

			.wrapper label:before {
			   margin: 5px;
			   content: "\f005";
			   font-family: FontAwesome;
			   display: inline-block;
			   font-size: 1.5em;
			   color: #ccc;
			   -webkit-user-select: none;
			   -moz-user-select: none;
			   user-select: none;
			}

			.wrapper input:checked ~ label:before {
			  color: #FFC107;
			}

			.wrapper label:hover ~ label:before {
			  color: #ffdb70;
			}

			.wrapper label:hover:before {
			  color: #FFC107;
			}
		</style>

    <!-- FIN STYLES -->

</head>
<body>

    <?php include("Template/menu.php"); ?>


 	<!--MENU-->
		<?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

    <!-- ************************** --->
    
    <!-- CONTENIDO -->

	<section class="home_content">

		<div aria-label="breadcrumb" class="mt-1"> 
	         <ol class="breadcrumb" style="background-color: #fff;">
	            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
	            <li class="breadcrumb-item " aria-current="page"><a href="Actas.php">Actas</a></li>
	            <li class="breadcrumb-item active" aria-current="page">Registrar Actas</li>
	         </ol>
	    </div>

	    <div class="notice notice-sistemakv">
			<strong><i class="fa fa-file-text-o mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">REGISTRAR ACTAS</b></strong>
		</div>

	    <section class="form-usuarios mb-5">
	        <div class="formulario mb-5">
		        <form action="../Controlador/registrarActaSituaciones.php" method="POST" enctype="multipart/form-data" onsubmit="return validar()">
						
					<!--ID ACTA-->
		        	    <input type="hidden" name="id_acta"  id="id_acta" class="form-control" value="<?php echo $id_acta ?>">
                    
                 	<!--SITUACIÓN-->
		                <div class="row mt-3">
		        	        <div class="label">
		        		        <label>Situación - Problema</label>
		        	        </div>
		        	        <div class="input">
		        	            <textarea type="text" name="descripcion_situacion"  id="descripcion_situacion" class="form-control form-control-sm" required="required"></textarea>
		        	        </div>      		
		                </div>

		           	<!--SOLUCION-->
		                <div class="row mt-3">
		        	        <div class="label">
		        		        <label>Solución</label>
		        	        </div>
		        	        <div class="input">
		        	        	<textarea name="solucion_situacion" id="solucion_situacion" class="form-control form-control-sm" required="required"></textarea>
		        	        </div>      		
		                </div>

		            <!--RESPONSABLE-->
		                <div class="row mt-3">
		        	        <div class="label">
		        		        <label>Responsable(s)</label>
		        	        </div>
		        	        <div class="input">
		        	        	<select class="form-control form-control-sm selectpicker" multiple="multiple" data-live-search="true" id="id_responsable" name="id_responsable[]">
		        	        		<option value="">SELECCIONAR</option>}
		        	        		option
                                    <?php foreach ($listarTodosUsuarios as $lu){ ?>
                                        <option value="<?php echo $lu['id_usuario']; ?>"><?php echo $lu['nombre']; ?></option>
                                    <?php } ?>
                                </select> 
		        	        </div>      		
		                </div>
		                
		                <div class="row mt-3">
		        	        <div class="label">
		        		        <label>Estado Solucion</label>
		        	        </div>
		        	        <div class="input">
		        	        	<select class="form-control form-control-sm selectpicker" data-live-search="true" id="estado_solucion" name="estado_solucion">
		        	        		<option value="">SELECCIONAR</option>}
		        	        		option
                                    <?php foreach ($listarEstadoSituacion as $est){ ?>
                                        <option value="<?php echo $est['id_estado']; ?>"><?php echo $est['detalle']; ?></option>
                                    <?php } ?>
                                </select> 
		        	        </div>      		
		                </div>

		            <!--REPORTAR A-->
		                <div class="row mt-3">
		        	        <div class="label">
		        		        <label>Reportar a</label>
		        	        </div>
		        	        <div class="input">
		        	        	<select class="form-control form-control-sm selectpicker" data-live-search="true" id="id_reportar_a" name="id_reportar_a">
		        	        		<option value="">SELECCIONAR</option>}
		        	        		option
                                    <?php foreach ($listarTodosUsuarios as $lu){ ?>
                                        <option value="<?php echo $lu['id_usuario']; ?>"><?php echo $lu['nombre']; ?></option>
                                    <?php } ?>
                                </select> 
		        	        </div>      		
		                </div>

					<!--FECHA LIMITE-->
		                <div class="row mt-3">
		        	        <div class="label">
		        		        <label>Fecha Limite</label>
		        	        </div>
		        	        <div class="input">
		        	        	 <input type="text" name="fecha_limite"  id="datepicker" class="form-control form-control-sm" required="required">
		        	        </div>      		
		                </div>

		            <!--PRIORIDAD-->
		                <div class="row mt-3">
		        	        <div class="label">
		        		        <label>Prioridad</label>
		        	        </div>
		        	        <div class="input">
								<select name="prioridad" id="prioridad" class="form-control form-control-sm selectpicker" data-live-search="true">
									<option value="">SELECCIONAR</option>
									<option value="1">BAJA</option>
									<option value="2">MEDIA</option>
									<option value="3">ALTA</option>
								</select>

		        	        </div>      		
		                </div>

					<section class="col-12 mt-4 p-1 d-flex justify-content-center">
						<a href="Actas.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
						<button type="submit" class="btn btn-outline-info col-3">Continuar</button>
					</section>
	                   
		        </form>
	        </div>
	    </section>

	</section>


    <?php include("Template/scripts.php"); ?>
    <script type="text/javascript">

        function validar(){
        	document.getElementById('guardar').innerHTML = 'Por favor espere';
    		document.getElementById('guardar').disabled = true;

        	return true;
        }

		$( function() {
            $( "#datepicker" ).datepicker({ dateFormat:'yy/mm/dd'});
            
        } );
    </script>
</body>
</html>