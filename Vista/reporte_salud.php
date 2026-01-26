<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Salud.php");
require_once("../Modelo/General.php");
require_once("../Modelo/Usuario.php");

$fecha = date('Y-m-d');
$salud = new Salud();
$listarC = $salud->listarHoy($fecha);
$usuario = new Usuario();
$modulo = 97;
$permisos = permisos($modulo,$_SESSION['id_usuario']);
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
    <title>SistemaKV | Reporte Salud</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- STYLES -->

      <?php include("Template/styles.php") ?>
      <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

      <style type="text/css">

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
             <ol class="breadcrumb" style="background-color: #fff;">
                <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Reporte Salud</li>
             </ol>
        </div>

        <div class="notice notice-sistemakv">
            <strong><i class="fa fa-heartbeat mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">ENCUESTA DE SALUD DIARIA</b></strong>
        </div>

        <div class="notice notice-sistemakv">
            <a href="filtroReporteSalud.php" class="btn" id="buttonsKV">Reporte<i class="fa fa-clipboard ml-2"></i></a>
        </div>

        <div class="mt-2 p-4 table-responsive" style="background-color: #fff;">
        	<table  id="dataT" class="table table-hover table-sm display text-center" style="width:100%">
        		<thead style="background-color: #1b2d3b; color: #fff;">
        			<tr>
                <th>NOMBRE</th>
                <th>N° DOCUMENTO</th>
                <th>EMPRESA</th>
                <th>EMAIL</th>
                <th>CELULAR</th>
        				<th>OPCIONES</th>
        			</tr>
        		</thead>
        		<tbody>
              <?php foreach ($listarC as $lc){ ?>
                  <tr>
                      <td><?php $datos_usu = $usuario->listarUsuarioPorId($lc['id_usuario']); echo $datos_usu[0]['nombre']; ?></td>
                      <td><?php echo $datos_usu[0]['usuario']; ?></td>
                      <td><?php echo strtoupper($lc['empresa']); ?></td>
    			            <td><?php echo strtoupper($lc['email']); ?></td>
                      <td><?php echo $lc['celular'] ?></td>
                      <td>
                          <?php if($permisos[0]['consulta'] == 1){ ?>
                          
                            <!--CONSULTAR-->
                              <a href="" class="btn btn-outline-warning"  style="margin: 0px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#modalSalud" onclick="modal(<?php echo $lc['id_respuesta'];?>)"><i class="fa fa-search"></i></a>

                          <?php } ?>
                      </td>
                  </tr>
              <?php } ?>
        		</tbody>
        	</table>
        </div>
    </section>

  <!-- FIN CONTENIDO -->

  <!-- ****************************** -->

  <!-- MODAL RESPUESTAS ENCUESTA -->

  <!-- ****************************** -->
  
  <!-- SCRIPT -->
    <?php include("Template/scripts.php"); ?>
    <script type="text/javascript">

      function modal(id){
         var parametros = {
                      "id" : id
              };
              $.ajax({
                      data:  parametros, //datos que se envian a traves de ajax
                      url:   '../Controlador/listarReporteSalud.php', //archivo que recibe la peticion
                      type:  'post', //método de envio
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
  <!-- FIN SCRIPT -->
  
</body>
</html>