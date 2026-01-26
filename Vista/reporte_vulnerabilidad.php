<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Salud.php");
require_once("../Modelo/General.php");
require_once("../Modelo/Usuario.php");

$fecha = date('Y-m-d');
$salud = new Salud();
//$listarC = $salud->listarHoyVulnerabilidad($fecha);
$listarVulnerabilidad = $salud->listarVulnerabilidad();
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
  <title>SistemaKV | Reporte Vulnerabilidad</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- styles -->
  <?php include("Template/styles.php") ?>
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
  <!--fin  styles -->

</head>
<body>
    <!--MENU-->
       <?php include("Template/menu.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->
    
    <!-- CONTENIDO -->
    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reporte Vulnerabilidad</li>
         </ol>
    </div>
    
    <!-- BARRA PRINCIPAL-->
    <hr style="background-color:#5e99b1; ">
    <div class="row barra-principal">
    	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 titulo_principal">
    		<h2 class="ml-4 mt-2" style="color: #fff; line-height: 25px;"><span class="fa fa-users" style="border: 2px solid #fff; border-radius: 50%;  font-size:0.8em; padding: 9px;"></span> Reporte Vulnerabilidad</h2>
    	</div>
    	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 botones_principal">
            <?php if($permisos[0]['consulta'] == 1){ ?>
            <a href="filtroReporteVulnerabilidad.php" class="btn boton-registro ml-1 mr-1" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;"><span class="fa fa-clipboard ml-2 mr-2"></span>Reporte</a>
            <?php } ?>
        </div>
    </div>
    <!---->

    <hr style="background-color:#5e99b1;">
    <div class="mt-2 p-4 table-responsive">
    	<table  id="dataT" class="table table-hover table-sm display" style="width:100%">
    		<thead>
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
                <?php foreach ($listarVulnerabilidad as $lc){ ?>
                    <tr>
                        <td><?php $datos_usu = $usuario->listarUsuarioPorId($lc['id_usuario']); echo $datos_usu[0]['nombre']; ?></td>
                        <td><?php echo $datos_usu[0]['usuario']; ?></td>
                        <td><?php echo $lc['empresa'] ?></td>
						<td><?php echo $lc['email'] ?></td>
                        <td><?php echo $lc['celular'] ?></td>
                        <td>

                            <?php if($permisos[0]['consulta'] == 1){ ?>
                            <!--Consultar-->
                             <a href="" class="btn btn-outline-warning"  style="margin: 0px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#exampleModal" onclick="modal(<?php echo $lc['id_respuesta'];?>)">
                                    <span class="fa fa-search"></span>
                            </a>
                          <?php } ?>     

                        </td>
                </tr>
                <?php } ?>
    		</tbody>
    	</table>
    </div>
    <!-- Modal -->                                
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">                                    
			<div class="modal-content f-flex justify-content-center">                                      
				<div class="modal-header">                                        
					<h5 class="modal-title" id="exampleModalLabel">DETALLE DE LA ENCUESTA DE VULNERABILIDAD</h5>                                        
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">                                          
						<span aria-hidden="true">&times;</span>                                        
					</button>                                     
				</div>                                      
				<div class="modal-body">                                         
					<section id="contenido_modal"></section>                                      
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


function modal(id){
   var parametros = {
                "id" : id
        };
        $.ajax({
                data:  parametros, //datos que se envian a traves de ajax
                url:   '../Controlador/listarReporteVulnerabilidad.php', //archivo que recibe la peticion
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

  
</body>
</html>