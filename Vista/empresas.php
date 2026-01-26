<?php 
include("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/EmpresaEnt.php");

$empresa = new Empresa();
$listarE = $empresa->listar();

 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Empresas</title>
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
    
    <!-- CONTENIDO -->

    <section class="home_content">  

        <div aria-label="breadcrumb" class="mt-1"> 
             <ol class="breadcrumb" style="background-color: #fff;">
                <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Empresas</li>
             </ol>
        </div>

        <div class="notice notice-sistemakv">
            <strong><i class="fa fa-building-o mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">EMPRESAS</b></strong>
        </div>

        <div class="notice notice-sistemakv">
            <a href="registrarEmpresas.php" class="btn" id="buttonsKV">Registrar empresa <i class="fa fa-plus"></i></a>
        </div>

        <div class="mt-2 p-4 table-responsive" style="background-color: #fff;">
        	<table id="dataT" class="table table-hover table-sm display text-center" style="width:100%">
        		<thead style="background-color: #1b2d3b; color: #fff;">
        			<tr>
        				<th>NOMBRE EMPRESA</th>
        				<th>NIT</th>
        				<th>DIRECCIÓN</th>
        				<th>TELEFONO</th>
                        <th>REPRESENTANTE LEGAL</th>
        				<th>ESTADO EMPRESA</th>
        				<th>OPCIONES</th>
        			</tr>
        		</thead>
        		<tbody>
        			<?php foreach ($listarE as $le){ ?>
        				<tr>
        					<td><?php echo $le['nombre_empresa']; ?></td>
        					<td><?php echo $le['nit_empresa']; ?></td>
        					<td><?php echo $le['direccion']; ?></td>
        					<td><?php echo $le['telefono']; ?></td>
                            <td><?php echo $le['representante_legal']; ?></td>
        					<td><?php if ($le['estado'] == 1) {
                                echo "Activa";
                            } else{
                                echo "Inactiva";
                            }?></td>
        					<td>

        						<!--Eliminar-->
            						<?php if ($le['estado'] == 0){ ?>
            							<a href="../Controlador/bloquearDesbloquearEmp.php?id_empresa=<?php echo $le['id_empresa']; ?>_1" class="btn btn-outline-success" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-unlock"></span></a>
            						<?php } elseif ($le['estado'] == 1) { ?>
            							<a href="../Controlador/bloquearDesbloquearEmp.php?id_empresa=<?php echo $le['id_empresa']; ?>_2" class="btn btn-outline-danger" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-lock"></span></a>
            						 <?php }  ?>
        						
        						<!--Editar-->

        					       <a href="actualizarEmpresa.php?id_empresa=<?php echo $le['id_empresa']; ?>" class="btn btn-outline-info"  style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-edit"></span></a>

        					    <!--Consultar-->

        					       <a href="" class="btn btn-outline-warning" data-toggle="modal" data-target="#exampleModal" style="margin: 0px; padding: 0px 4px 0px 4px;" onclick="mostrarInformacionEmpresa(<?php echo $le['id_empresa'];?>)"><span class="fa fa-search"></span></a>

                                <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content f-flex justify-content-center">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">INFORMACIÓN ACERCA DE LA EMPRESA</h5>
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
        					</td>
        				</tr>
        			<?php } ?>
        		</tbody>
        	</table>
        </div>

    </section>
    
    <!-- FIN CONTENIDO -->

    <!-- script -->
    <?php include("Template/scripts.php"); ?>
    <script type="text/javascript">
        function mostrarInformacionEmpresa(id_empresa){

            var parametros = {
                "id_empresa" : id_empresa
            };
            $.ajax({
                data: parametros,
                url: '../Controlador/listarInfoEmpresa.php',
                type: 'post',
                beforeSend: function () {
                },
                success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                        //alert(response);
                        $("#contenido_modal").html(response);
                }
            })

        }
    </script>


</body>
</html>