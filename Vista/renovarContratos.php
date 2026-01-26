<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Contrato.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Cliente.php");


/* VARIABLES MENU*/
$titulo = 'Renovar Contrato';
$redireccion = 'contratos.php';
$icono = 'fa fa-file-text-o';

/**/

$contrato = new Contrato();
$listarContratos = $contrato->listarTodos();

$cliente = new Cliente();


$empresa = new Empresa();
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

	            <form method="POST" action="" enctype="multipart/form-data">
	            	    <?php include("Template/header-form.php"); ?>

			            <hr>
			            
			            <!-- Contrato -->

		                    <div class="row mt-3">
		                    	<section class="label">
				     	            <label>Contratos</label>
				     	        </section>
		                    	<section class="input">
						     	    <select name="id_tipo_contrato" id="id_tipo_contrato" class="form-control" onchange="validarFechaInicial(this.value)">
								        <option value="0">Seleccionar</option>
								        <?php foreach ($listarContratos as $lc){ ?>
								        	<?php 
								        		$listarClientePorId = $cliente->cliente_ID($lc['id_cliente']);
								        		$listarEmpresaPorId = $empresa->listarPorId($lc['id_empresa']);
								        		
												$hoy = date('Y-m-d');

								        	
								        	if ($lc['fecha_final_contrato'] < $hoy) { ?>
								        		<option value="<?php echo $lc['id_contrato'] ?>" style="color: red;">
								        			<?php echo "CONTRATO N° ". $lc['numero_contrato'] . " Entre " . $listarClientePorId[0]['razon_social'] . " y " .  $listarEmpresaPorId[0]['nombre_empresa'];?>
								        		</option>
								       	 	<?php }else{ ?>
												<option value="<?php echo $lc['id_contrato'] ?>">
								        			<?php echo "CONTRATO N° ". $lc['numero_contrato'] . " Entre " . $listarClientePorId[0]['razon_social'] . " y " .  $listarEmpresaPorId[0]['nombre_empresa'];?>
								        		</option>
								       	 	<?php } ?>
								        <?php } ?>
								    </select>
				     	        </section>
		                    </div>

	                    <!--Fecha Inicio-->
	                    
		                    <div class="row mt-3 ">
		                    	<section class="label">
		                    	 	<label>Fecha inicial del contrato</label>
		                    	</section>
		                    	<section class="input">
		                    	 	<input type="text" name="fecha_inicial_contrato" id="datepicker" class="form-control">
		                    	 	<input type="hidden" name="act_fecha_inicial_contrato" id="act_fecha_inicial_contrato" class="form-control">
		                    	</section>
		                    </div>

	     	   			<!--Fecha final-->

		     	   			<div class="row mt-3 " id="fechaFinal">
		                    	<section class="label">
		     	                    <label>Fecha final del contrato </label>
		     	                </section>
		                    	<section class="input">
		     	                    <input type="text" name="fecha_final_contrato" id="datepicker1" class="form-control">
		     	                </section>
		                    </div>

                        <!--DOC CONTRATO-->
            			
            				<div class="row mt-3 mb-5" id="fotocopiaContrato">
		                    	<section class="label">
		     	                    <label>Fotocopia del contrato firmado</label>
		     	                </section>
		                    	<section class="input">
		     	                    <input type="file" name="doc_fotocopia_contrato" id="doc_fotocopia_contrato" class="form-control">
		     	                </section>
		               	 	</div>

                        <hr>
                        <?php include("Template/bottom-form.php"); ?>
	            </form> 
        </div>
    </section>



    <?php include("Template/scripts.php"); ?>

	<script type="text/javascript">


        $( function() {
	        
	        
	    } );

        

	    function validarFechaInicial(id_contrato){
	    	/*alert(id_contrato);*/

	    	var parametros = {
	    		"id_contrato" : id_contrato
	    	};

	    	$.ajax({
                data:  parametros, //datos que se envian a traves de ajax
                url:   '../Controlador/validarFechaRenovacion.php', //archivo que recibe la peticion
                type:  'POST', //método de envio
                beforeSend: function () {
                    $("#datepicker").value = " Procesando, espere por favor ... ";
                    $("#datepicker1").value = " Procesando, espere por favor ... ";
                },
                success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                    /*alert(response);*/

                    to = $( "#datepicker" ).datepicker({dateFormat: "yy-mm-dd", defaultDate: response, monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'], dayNames: ['Domingo', 'Lunes', 'Martes', 'Mi&eacute;rcoles', 'Jueves', 'Viernes', 'S&aacute;bado'], dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mi&eacute;', 'Juv', 'Vie', 'S&aacute;b'], dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'S&aacute;']});

                  	to.datepicker( "option", "minDate", response);

                }
       		});


	    }

	</script>

</body>
</html>