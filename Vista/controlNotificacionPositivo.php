<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/General.php';
require_once '../Modelo/Usuario.php';

$listarNotificaciones = listarNotificaciones();
$usuario = new Usuario();

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Control Notificación Positiva</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <!-- styles -->
  <?php include("Template/styles.php") ?>
  <!--fin  styles -->
  <style type="text/css">
    
    #inputURL{
        text-transform: none  !important; 
    }

    .barra-principal{
      background-color: #5e99b1;
      width: auto;
    }

    .botones_principal{
      display: flex;
      justify-content: flex-end;
    }

    .boton-registro{
      background-color: #fff; 
      height: 40px; 
      margin-top: 10px; 
      margin-bottom: 10px; 
      color: #00a0df;
    }

    #iconoAlerta{
  position: relative;
      animation: animationAlert 2s infinite;
    }

    @keyframes animationAlert {
        0%   {left:0px;}
        25%  {left:50px;}
        50%  {left:0px;}
        75%  {left:-50px;}
        100% {left:0px;}
    }

    @media (max-width: 760px){
      
        .fa-plus{
           display: none;
        }

        .titulo_principal{
          text-align: center;
        }

        .botones_principal{
          display: flex;
          justify-content: center;
        }
    }

  </style>
</head>
<body>
    <!--MENU-->
       <?php include("Template/menu.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->
    
    <!-- CONTENIDO -->

        <div aria-label="breadcrumb" class="mt-1"> 
             <ol class="breadcrumb">
                <li class="breadcrumb-item " aria-current="page"><a href="inicioPropietarios.php">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Contratos Ocasionales</li>
             </ol>
        </div>
            
        <hr style="background-color:#5e99b1; ">
        <div class="row barra-principal">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 titulo_principal">
                <h2 class="mt-2" style="color: #fff; line-height: 25px;"><span class="fa fa-users ml-2" style="border: 2px solid #fff; border-radius: 50%;  font-size:0.8em; padding: 9px;"></span> Control de Notificación Positiva</h2>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 botones_principal"> 
                <a class="btn boton-registro ml-1 mr-1" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df; cursor: pointer;" onclick = "copyOnClick();">Obtener Link <span class="fa fa-clone"></span></a>
            </div>
        </div>
        <hr style="background-color:#5e99b1;">


        <p id="txt_knoband" style="visibility: hidden;"><?php echo "https://www.sistemakv.com/Vista/encuesta_notificacion_positiva.php?id_referenciador=". base64_encode($_SESSION['id_usuario']); ?></p>

        <section class="mt-4 p-4 table-responsive">
            <table class="table table-hover text-center display" id="dataT">
                <thead>
                    <tr>
                        <th>NOMBRE Y APELLIDO DEL TRABAJADOR</th>
                        <th>TELÉFONO</th>
                        <th>CORREO ELECTRÓNICO</th>
                        <th>DIRECCIÓN</th>
                        <th>CANT DE PERSONAS CON CONTACTO</th>
                        <th>FECHA DE REGISTRO</th>
                        <th>LINK REFERIDO POR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listarNotificaciones as $ln){ ?>
                        <tr>
                            <td><?php echo strtoupper($ln['nombres_trabajador']) . ' ' . strtoupper($ln['apellidos_trabajador']); ?></td>
                            <td><?php echo $ln['telefono']; ?></td>
                            <td><?php echo strtoupper($ln['correo_electronico']); ?></td>
                            <td><?php echo strtoupper($ln['direccion']); ?></td>
                            <?php if ($ln['cant_personas_contacto'] == 1){ ?>
                                <td><a onclick="mostrarInfoModal(<?php echo $ln['id_notificacion']; ?>);" style="color: green; cursor: pointer;"><i class="fa fa-eye mr-2"></i><?php echo $ln['cant_personas_contacto'] . ' CONTACTO'; ?></a></td>
                            <?php }else{ ?>
                                <td><a onclick="mostrarInfoModal(<?php echo $ln['id_notificacion']; ?>);" style="color: green; cursor: pointer;"><i class="fa fa-eye mr-2"></i><?php echo $ln['cant_personas_contacto'] . ' CONTACTOS'; ?></a></td>
                            <?php } ?>
                            <td><?php echo $ln['fecha_registro']; ?></td>
                            <td>
                                <?php 
                                    $listarUsuId = $usuario->listarUsuarioPorId($ln['id_referenciador']);
                                    echo $listarUsuId[0]['nombre']; 
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content ">
                    <button type="button" class="close d-flex justify-content-end" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="mr-3">&times;</span>
                    </button>

                    <div class="modal-body d-flex justify-content-center" id="personasNotificaciones">
                                            </div>
                
                </div>
            </div>
        </div>



    <!-- FIN CONTENIDO -->

    <!-- MODAL ALERT COPY LINK -->
        <div class="modal fade" id="alertaLinkCopiado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgb(0,0,0,.8);">
            <div class="modal-dialog" role="document" >
                <div class="modal-content">
                    
                    <div class="modal-body text-center" id="modal-body">
                        <div class="col-12" style="height: auto;">
                            <i style="color: #25b01e; font-size: 6rem;" id="iconoAlerta" class="fa fa-check-circle-o"></i>
                            <h4 class="modal-title" style="color: #a1a1a1; "><strong>LINK COPIADO.</strong></h4>
                        </div> 
                        <div class="col-12 mt-1">
                            <p>Enhorabuena! El link se ha copiado correctamente.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- MODAL ALERT COPY LINK -->

    <!-- script -->
    <?php include("Template/scripts.php"); ?>

    <script type="text/javascript">
        function copyOnClick() {
            var tempInput = document.createElement("input"); 
            tempInput.value = document.getElementById("txt_knoband").innerHTML;
            tempInput.id = 'inputURL';
            console.log(tempInput);
            //console.log(tempInput);
            document.body.appendChild(tempInput); 
            tempInput.select(); 
            document.execCommand("copy"); 
            document.body.removeChild(tempInput); 
            $("#alertaLinkCopiado").modal("show");   
            setTimeout(function(){
            $("#alertaLinkCopiado").modal("hide");  
            }, 3500);
        }

        function mostrarInfoModal(id_notificacion){

            var parametros = {
                "id_notificacion" : id_notificacion,
            };

            $.ajax({
                data: parametros,
                url: '../Controlador/listarPersonasContactoNotificacionPositiva.php',
                type: 'POST',
                beforeSend: function () {
                },
                success:  function (response) {
                    //alert(response);
                    document.getElementById("personasNotificaciones").innerHTML = (response);
                    $("#exampleModal").modal("show");
                }
            });
        }

 /*       $( "#filtrar" ).click(function() {
           document.getElementById('botonesExportar').style.display = ''
        });
*/

    </script>

</body>

</html>