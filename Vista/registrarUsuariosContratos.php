<?php 
include ("../Controlador/Sesion/autenticar.php");

$id_contrato = $_GET['id_contrato_ocasional'];

$titulo = 'Asignar Usuarios al contrato';
$redireccion = 'contratosOcasionales.php';
$icono = 'fa fa-user-o';

 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>SistemaKV | Asignar usuarios</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- STYLES -->
        <?php include("Template/styles.php"); ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
    <!-- FIN STYLES -->

</head>
<body>

    <!-- MENU -->
        <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!-- FIN MENU -->

    <!--**************************--->
    
    <!-- CONTENIDO -->
    
        <section class="home_content"> 

        	<div aria-label="breadcrumb" class="mt-1"> 
                 <ol class="breadcrumb" style="background-color: #fff;">
                    <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Asignacion de Usuarios</li>
                 </ol>
            </div>

            <div class="notice notice-sistemakv">
                <strong><i class="fa fa-file-text-o mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">ASIGNACIÓN DE USUARIOS</b></strong>
            </div>


            <section class="form-usuarios mb-5">
                <div class="formulario mb-5">
                    <?php if ($_SESSION['id_perfil'] == 2){ ?>
                       <form action="../Controlador/registrarUsuContraOcasionalPropietarios.php" method="POST"> 
                    <?php } else {?>
                	   <form action="../Controlador/registrarUsuContraOcasional.php" method="POST">
                    <?php } ?>

                            <div class="row mt-5 p-4" id="cantUsu" style="border: 1px dashed #d1d1d1; ">
                                    <input type="hidden" name="id_contrato" id="id_contrato" class="form-control" value="<?php echo $id_contrato ?>">
                                	<div class="label">
                                		<label><b>¿Cuantos usuarios desea agregar al contrato?</b></label>
                                	</div>
                                	<div class="input ml-3">
                                		<input type="text" name="cantidad_usuarios" id="cantidad_usuarios" class="form-control " onkeyup="crearFilaInput();">
                                	</div>	
                            </div>

                            <section class="d-flex justify-content-center">
                                <div  id="botones" class="row m-3" style="display: none; font-family: 'Lato', sans-serif !important;">
                                    <button class="btn btn-danger mr-3" type="button" onclick="eliminarFila();" style="margin: 0px; padding: 5px 6px 5px 6px;"> Eliminar fila <i class="fa fa-trash ml-2" style="font-size: 1.2rem;"></i></button>

                                    <button class=" btn btn-success" type="button" onclick="agregarFila();" style="margin: 0px; padding: 5px 6px 5px 6px;"> Agregar Fila <i class="fa fa-plus-circle ml-2" style="font-size: 1.2rem;"></i></button>
                                </div>
                            </section>


                            <table id="input-group" class="table">
                                
              				</table>


                            <!-- BOTONES -->
                            
                                <section class="col-12 mt-5 d-flex justify-content-center">
                                  
                                    <!-- CANCELAR REGISTRO -->
                                        <a href="contratosOcasionalesPropietarios.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
                                  
                                    <!-- REGISTRAR -->
                                        <button type="submit" id="Registrar" class="btn btn-outline-success col-3">Registrar</button>
                              
                                </section>

                        </form>
                </div>
            </section>

        </section>

    <?php if (($_SESSION['id_perfil'] == 2)){ ?>
        
        <div class="modal fade" id="myModal" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center">
                  <div class="col-12" style="height: auto;">
                    <i style="color: #d62d2d; font-size: 6rem;" class="fa fa-info-circle"></i>
                    <h4 class="modal-title" style="color: #a1a1a1; "><strong>ANEXO INFORMATIVO</strong></h4>
                  </div>
                  <div class="col-12 mt-4">
                      <p class="mb-3">Estimado afiliado es responsabilidad del emisor del FUEC en diligenciar la información de manera correcta, fiel a el numero de documento de cada pasajero para evitar sanciones o multas. </p>
                      
                  </div>
                </div>
                <div class="col-12 modal-footer d-flex justify-content-center" style="border: 0px;">
                  <button type="button" class="col-3 btn btn-danger btn-block" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
          </div>
        </div>
    <?php } ?>

    <?php include("Template/scripts.php"); ?>

    <script type="text/javascript">

        $(function(){
            $("#cantidad_usuarios").keydown(function(event){
                if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105) && event.keyCode !==190  && event.keyCode !==110 && event.keyCode !==8 && event.keyCode !==9  ){
                    return false;
                }
            });
        });

        function soloNumeros(){
            $('.numero_documento').keypress(function (tecla) {
              if (tecla.charCode < 48 || tecla.charCode > 57) return false;
            });
        }

        function eliminarFila() {
            var nFilas = $("#input-group tr").length;
            var celdaAnterior = parseFloat(nFilas) - parseFloat(2);
            if(nFilas > 2){
                $("#input-group tr:last").remove();
            }
        }

        function agregarFila(index) {


            var nFilas = $("#input-group tr").length;

            var htmlTags = '<tr><td style="border: hidden; padding: 4px;"><div class="row"><span class="fa fa-user-circle-o mr-3 ml-3" style="font-size: 1.7rem; color: #1b2d3b;"></span><input class="form-control col-9" type="text" name="nombre_usuario[]" required/></div></td><td style="border: hidden; padding: 4px;"><input class="form-control numero_documento col-12" type="text" name="numero_documento[]" required /></td></tr>';
      
            $('#input-group').append(htmlTags);

            soloNumeros();

        }

    	function crearFilaInput(){

            var cantidad_usuarios = document.getElementById('cantidad_usuarios').value;

            if(cantidad_usuarios > 0){
			    var parametros = {
			       "cantidad_usuarios" : cantidad_usuarios
			    };

			    $.ajax({
			        data:  parametros, //datos que se envian a traves de ajax
			        url:   '../Controlador/crearFilaInput.php', //archivo que recibe la peticion
			        type:  'post', //método de envio
			        beforeSend: function () {
			                $("#input-group").html("Procesando, espere por favor...");
			        },
			        success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
			                /*alert(response);*/
			                $("#input-group").html(response);
                            document.getElementById('botones').style.display = "flex";
			        }
			    });
 			}
    	}

        /*function ValidarAgregarUsuarios(val){
            var agregar = document.getElementById('agregar_usuarios').value;
            if (agregar == 'S') {
                document.getElementById('cantUsu').style.display = 'flex';
            }else{
                document.getElementById('cantUsu').style.display = 'none';
            }
        }*/


            function modalAviso(){
                $("#myModal").modal("show");   
            }

            $(window).on("load", modalAviso());

    </script>

</body>
</html>
</html>