<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Empleado.php");
require_once("../Modelo/General.php");

$empleado = new Empleado();
$listarC = $empleado->listar();

$modulo = 92;
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
    <title>SistemaKV | Empleados</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- STYLES -->

        <?php include("Template/styles.php") ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
  
    <!-- FIN STYLES -->

</head>
<body>

    <!--MENU-->
        <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->


    <!--**************************--->
    
<section class="home_content"> 

    <div aria-label="breadcrumb" class="mt-1"> 
        <ol class="breadcrumb" style="background: #fff;">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Empleados</li>
        </ol>
    </div>

    <div class="notice notice-sistemakv">
        <strong><i class="fa fa-clipboard mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">EMPLEADOS</b></strong>
    </div>

    <div class="notice notice-sistemakv">
        <?php if($permisos[0]['agregacion'] == 1){ ?>
            <a href="registrarEmpleado.php" class="btn btn-outline-info ml-1 mr-1">Registrar Empleado <i class="fa fa-plus"></i></a>
        <?php } ?>
    </div>

    <div class="mt-2 p-4 mb-4 table-responsive" style="background: #fff;">
    	<table  id="dataT" class="table table-hover table-sm display text-center" style="width:100%">
    		<thead style="background-color: #1b2d3b; color: #fff;">
    			<tr>
                    <th>NOMBRE</th>
                    <th>N° DOCUMENTO</th>
                    <th>EMPRESA</th>
                    <th>FECHA NACIMIENTO</th>
					<th>EPS</th>
					<th>ARL</th>
                    <th>ESTADO</th>
    				<th>OPCIONES</th>
    			</tr>
    		</thead>
    		<tbody>
                <?php foreach ($listarC as $lc){ ?>
                    <tr>
                        <td><?php echo $lc['nombres'].' '.$lc['apellidos']; ?></td>
                        <td><?php echo $lc['num_documento'] ?></td>
						<td><?php echo $lc['empresa'] ?></td>
						<td><?php echo $lc['fecha_nac'] ?></td>
                        <td><?php echo $lc['eps'] ?></td>
                        <td><?php echo $lc['arl'] ?></td>
                        <td>
                            <?php 
                                if ($lc['estado'] == 1) {
                                        echo "Activo";
                                }else{
                                        echo "Inactivo";
                                } 
                            ?>       
                        </td>
                        <td>
                            

                                <!-- ACTIVAR O INACTIVAR-->
                                    <?php if($permisos[0]['eliminacion'] == 1){ ?>
                                        <?php if ($lc['estado'] == 0){ ?>
                                            <a href="../Controlador/bloquearDesbloquearEmpleado.php?id=<?php echo $lc['id_empleado']; ?>_1" class="btn btn-outline-success" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-unlock"></span></a>
                                        <?php } else if ($lc['estado'] == 1) { ?>
                                            <a href="../Controlador/bloquearDesbloquearEmpleado.php?id=<?php echo $lc['id_empleado']; ?>_2" class="btn btn-outline-danger" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-lock"></span></a>
                                        <?php }  ?>
                                    <?php } ?> 

                                <!-- ACTUALIZAR -->
                                    <?php if($permisos[0]['edicion'] == 1){ ?>
                                        <a href="actualizarEmpleado.php?id_empleado=<?php echo $lc['id_empleado'] ?>" class="btn btn-outline-info"  style="margin: 0px; padding: 0px 4px 0px 4px;"><i class="fa fa-edit"></i></a>
                                    <?php } ?>

                                <!-- CONSULTAR -->
                                    <?php if($permisos[0]['consulta'] == 1){ ?>
                                        <a href="" class="btn btn-outline-warning"  style="margin: 0px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#modalDocEmployee" onclick="modal(<?php echo $lc['id_empleado'];?>)"><i class="fa fa-search"></i></a>
                                    <?php } ?>  

                            
                        </td>
                </tr>
                <?php } ?>
    		</tbody>
    	</table>
    </div>

</section>

<!--------------- *****************************------------------>
<!------------------------- MODALES ----------------------------->
<!--------------- *****************************------------------>
 
    <!-- MODAL DOCUMENTACIÓN EMPLEADO -->
        <div class="modal fade" id="modalDocEmployee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">                                  
            <div class="modal-dialog" role="document">                                    
                <div class="modal-content f-flex justify-content-center">                                      
                    <div class="modal-header">                                        
                        <h5 class="modal-title" id="exampleModalLabel">DOCUMENTACIÓN DEL EMPLEADO</h5>                                        
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>                                      
                    </div>                                      
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

<!-- SCRIPT  -->

<?php include("Template/scripts.php"); ?>
<script type="text/javascript">

    function modal(id){
    	
        var parametros = {
            "id" : id
        };

        $.ajax({
            data:  parametros,
            url:   '../Controlador/listarDocsEmpleado.php',
            type:  'POST',
            beforeSend: function () {
                $("#contenido_modal").html("Procesando, espere por favor...");
            },
            success:  function (response) { 
                $("#contenido_modal").html(response);
            }
        });
    }

</script>

  
</body>
</html>