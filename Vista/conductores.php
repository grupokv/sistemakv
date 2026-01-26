<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Conductor.php");
require_once("../Modelo/General.php");

$conductor = new Conductor();
$listarC = $conductor->listar();

$modulo = 12;
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
  <title>SistemaKV | Conductores</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- styles -->

  <?php include("Template/styles.php") ?>
  <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

  <!--fin  styles -->

</head>
<body>

    <!--MENU-->
    <?php include("Template/header.php"); ?>
    <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->
    
    <!-- CONTENIDO -->

    <section class="home_content">  
    
        <div class="notice notice-sistemakv">
            <strong><i class="fa fa-car mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">CONDUCTORES</b></strong>
        </div>

    
        <div class="notice notice-sistemakv">
            <?php if($permisos[0]['agregacion'] == 1){ ?>
                <a id="buttonsKV" href="registrarConductores.php" class="btn ml-1 mr-1">Nuevo conductor<i class="fa fa-plus-circle ml-1"></i></a>
            <?php } ?>
            <?php if($permisos[0]['consulta'] == 1){ ?>
                <a id="buttonsKV" href="reporteConductores.php" class="btn ml-1 mr-1">Reporte<i class="fa fa-clipboard ml-1"></i></a>
            <?php } ?>
         </div>

        <div class="mt-2 mb-4 table-responsive p-4" style="background-color: #fff; border-radius: 5px;">
        	<table  id="dataT" class="table table-hover table-sm display" style="width:100%">
        		<thead style="background-color: #1b2d3b; color: #fff;">
                    <tr class="text-center">
                        <th>ID</th>
                        <th>NOMBRE</th>
                        <th>N° DOCUMENTO</th>
                        <th>TELEFONOS</th>
                        <th>FECHA NACIMIENTO</th>
                        <th>ESTADO</th>
        				<th>OPCIONES</th>
        			</tr>
        		</thead>
        		<tbody class="text-center">
                    <?php foreach ($listarC as $lc){ ?>
                        <tr>
                            <td><?php echo $lc['id_conductor']; ?></td>
                            <td><?php echo strtr($lc['nombre_conductor'], "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ") ?></td>
                            <td><?php echo $lc['numero_documento_conductor'] ?></td>
                            <td><?php echo $lc['telefono1'] ?></td>
                            <td><?php echo $lc['fecha_nacimiento_conductor'] ?></td>
                            <td><?php if ($lc['estado'] == 1) {
                                            echo "Activo";
                                    }else{
                                            echo "Inactivo";
                                    } ?>
                                        
                            </td>
                            <td>
                                <?php if($permisos[0]['eliminacion'] == 1){ ?>
                                <!--Bloquear y Desboquear-->
                                <?php if ($lc['estado'] == 0){ ?>
                                    <a href="../Controlador/bloquearDesbloquearConductor.php?id_conductor=<?php echo $lc['id_conductor']; ?>_1" class="btn btn-outline-success" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-unlock"></span></a>
                                <?php } elseif ($lc['estado'] == 1) { ?>
                                    <a href="../Controlador/bloquearDesbloquearConductor.php?id_conductor=<?php echo $lc['id_conductor']; ?>_2" class="btn btn-outline-danger" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-lock"></span></a>
                                 <?php }  ?>
                                 <?php } ?> 

                                 <?php if($permisos[0]['edicion'] == 1){ ?>
                                <a href="actualizarConductores.php?id_conductor=<?php echo $lc['id_conductor'] ?>" class="btn btn-outline-info"  style="margin: 0px; padding: 0px 4px 0px 4px;">
                                        <span class="fa fa-edit"></span>
                                </a>
                                <?php } ?>

                                <?php if($permisos[0]['consulta'] == 1){ ?>
                                <!--Consultar-->
                                 <a href="" class="btn btn-outline-warning"  style="margin: 0px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#condDoc" onclick="modal(<?php echo $lc['id_conductor'];?>)">
                                        <span class="fa fa-search"></span>
                                </a>
                              <?php } ?>

                              <?php if($permisos[0]['edicion'] == 1){ ?>
    			   <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#condsVehiculos" style="margin: 0px; padding: 0px 4px 0px 4px;" onclick="modalVeh(<?php echo $lc['id_conductor'];?>)"><span class="fa fa-car"></span></button>
                              <?php } ?>      

                            </td>
                    </tr>
                    <?php } ?>
        		</tbody>
        	</table>
        </div>
    </section>

    <!-- DOCUMENTACIÓN -->
        <div class="modal fade" id="condDoc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">                                  
            <div class="modal-dialog" role="document">                                    
                <div class="modal-content f-flex justify-content-center">   
                    <div class="modal-header">                                        
                      <h5 class="modal-title" id="exampleModalLabel">DOCUMENTACIÓN DEL CONDUCTOR</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>                                      
                    </div>                                      
                    <div class="modal-body">                                         
                        <section id="contenido_modal">                                                                                      
                        </section>                                      
                    </div>                                      
                    <div class="modal-footer">                                        
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>    
                                    
                          <form action="actualizarConductores.php" method="GET">     
                            <input type="hidden" name="id_conductor" id="id_cond" value="">
                            <?php if($permisos[0]['edicion'] == 1){ ?>  
                                <button type="submit"  class="btn btn-outline-info"> Actualizar información</button>
                            <?php } ?>                                        
                          </form>  
                                                         
                    </div>                                    
                </div>                                  
            </div>                                
        </div>

    <!-- VEHICULOS ANCLADOS-->
        <div class="modal fade" id="condsVehiculos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
              <div class="modal-content f-flex justify-content-center">
                <div class="modal-header">
                    <h5 class="modal-title " id="exampleModalLabel">VEHICULOS ANCLADOS</h5>  
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <section id="contenido_modal_cond" name="contenido_modal_cond">
                    </section>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>
                </div>
              </div>
            </div>
        </div>


    <!-- script -->
    
    <?php include("Template/scripts.php"); ?>

    <script type="text/javascript">

        function modal(id_conductor){
            document.getElementById('id_cond'). value = id_conductor
            var parametros = {
                "id_conductor" : id_conductor
            };
            $.ajax({
                    data:  parametros, //datos que se envian a traves de ajax
                    url:   '../Controlador/listarDocsConductor.php', //archivo que recibe la peticion
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

        function modalVeh(id){

            var parametros = {
                "id_conductor" : id
            };

            $.ajax({
                data:  parametros, //datos que se envian a traves de ajax
                url:   '../Controlador/listarVehConductor.php', //archivo que recibe la peticion
                type:  'POST', //método de envio
                beforeSend: function () {
                    $("#contenido_modal_cond").html("Procesando, espere por favor...");
                },
                success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                    $("#contenido_modal_cond").html(response);
                }

            });

        }
    </script>

  
</body>
</html>