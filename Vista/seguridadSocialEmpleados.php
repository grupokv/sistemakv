<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Empleado.php");
require_once("../Modelo/General.php");
require_once("../Modelo/Usuario.php");

$empleado = new Empleado();
$usuario = new Usuario();


$listarSS = $empleado->listarSS();

$modulo = 105;
$permisos = permisos($modulo,$_SESSION['id_usuario']);
//print_r($permisos);

//print_r($permisos);
if(count($permisos) < 1){
  echo ("<script LANGUAGE='JavaScript'>
    window.location.href='https://www.sistemakv.com/';
    </script>");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | SS Empleados</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- STYLES -->
    <?php include("Template/styles.php") ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
    
    <style type="text/css">
      
      thead {
        background-color: #fff;
      }

      table {
          font-size: .8rem;
      }

      tr {
          background-color: #fff;
      }

      th {
          border-radius: 13px;
          border: 3px solid #fff;
          background-color: #274054;
          color: #fff;
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
          <ol class="breadcrumb" style="background: #fff;">
              <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
              <li class="breadcrumb-item active" aria-current="page">Empleados</li>
          </ol>
      </div>
    
      <div class="notice notice-sistemakv">
          <strong><i class="fa fa-file-text-o mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">SEGURIDAD SOCIAL</b></strong>
      </div>

      <div style="width: 100%; height: auto; padding: 5px; background-color: #fff; border-radius: 10px;">
          <?php if($permisos[0]['agregacion'] == 1){ ?>
            <a href="registrarSeguridadSocialEmpleado.php" id="buttonsKV" class="btn ml-1 mr-1" >Registrar <i class="fa fa-plus-circle"></i></a>
          <?php } ?>
      </div>

    <!---->

    <div class="mt-2" style="height: auto; padding: 2px; width: 100%; background-color: #fff; border-radius: 10px;">
      <div class="mt-2 p-4 table-responsive">
        <table id="dataT" class="table table-hover table-sm display text-center" style="width:100%">
          <thead style="background-color: #1b2d3b; color: #fff;">
            <tr>
              <th>ID</th>
              <th>NOMBRE DOCUMENTO</th>
              <th>DOC SEGURIDAD SOCIAL</th>
              <th>MES</th>
              <th>AÑO</th>
              <th>CARGADO POR</th>
              <th>OPCIONES</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; ?>
            <?php foreach ($listarSS as $lss){ ?>
              <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $lss['nombre_documento']?></td>
                  <td><a target="_blank" href="../Documentos/Empleados/SeguridadSocial/<?php echo $lss['seguridad_social']?>">DOC SEGURIDAD SOCIAL: <?php echo $lss['nombre_documento']?> <span class="fa fa-eye"></span></a></td>
                  <td><?php echo strtoupper(mes($lss['mes'])) ?></td>
                  <td><?php echo $lss['anio'] ?></td>
                  <td>
                      <?php 
                          $listarUsuarioPorId = $usuario->listarUsuarioPorId($lss['usuario_carga_doc']);
                          echo utf8_encode($listarUsuarioPorId[0]['nombre']);
                      ?>
                  </td>
                  <td>
                      <?php if($permisos[0]['edicion'] == 1){ ?>
                          <a href="actualizarSeguridadSocialEmpleado.php?id=<?php echo $lss['id']; ?>" class="btn btn-outline-info"  style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-edit"></span></a>
                      <?php } ?>
                              <?php if($permisos[0]['eliminacion'] == 1){ ?>
                          <a href="../Controlador/eliminarSeguridadSocialEmpleado.php?id=<?php echo $lss['id']; ?>" class="btn btn-outline-danger"  style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-trash"></span></a>
                      <?php } ?>
                  </td>
              </tr>
              
              <?php $i++; ?>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>


    <!-- Modal -->                                
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">                                  
        <div class="modal-dialog" role="document">                                    
            <div class="modal-content f-flex justify-content-center">
                <h5 class="modal-title mt-4 mb-4 text-center" id="exampleModalLabel"><strong>SEGURIDAD SOCIAL DEL EMPLEADO</strong></h5>
                <br>                                   
                <div class="modal-body">                                         
                    <section id="contenido_modal">                                                                                      
                    </section>                                      
                </div>                                      
                <div class="modal-footer">                                        
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>                                                                             
                </div>                                    
            </div>                                  
        </div>                                
    </div>

    <!-- FIN CONTENIDO -->


  <!-- script -->
  <?php include("Template/scripts.php"); ?>
  <script type="text/javascript">


function modalSS(id_empleado){
	
    var parametros = {
        "id_empleado" : id_empleado
    };
    $.ajax({
        data:  parametros, //datos que se envian a traves de ajax
        url:   '../Controlador/listarSSEmpleado.php', //archivo que recibe la peticion
        type:  'POST', //método de envio
        beforeSend: function () {
                $("#contenido_modal").html("Procesando, espere por favor...");
        },
        success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                //alert(response);
                $("#contenido_modal").html(response);
        }
    });
}

  </script>

  
</body>
</html>