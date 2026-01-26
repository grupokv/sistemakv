<?php 
include("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/ProveedorMantenimiento.php");
require_once ("../Modelo/Categoria_Mantenimiento.php");
require_once ("../Modelo/Subcategoria_Mantenimiento.php");

$proveedor = new ProveedorMantenimiento();
$listarE = $proveedor->listar();

$subCatMantenimiento = new Subcategoria_Mantenimiento();

$catMantenimiento = new Categoria_Mantenimiento();

 ?>
<!DOCTYPE html>
<html>
<head>
    
    <meta charset="utf-8">
    <title>SistemaKV | Proveedores</title>
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

    <!-- ************************** --->
    
    <!-- CONTENIDO -->

        <section class="home_content">

            <div aria-label="breadcrumb" class="mt-1"> 
                 <ol class="breadcrumb" style="background-color: #fff;">
                    <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Proveedores</li>
                 </ol>
            </div>

            <div class="notice notice-sistemakv">
                <strong><i class="fa fa-file-text-o mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">PROVEEDORES</b></strong>
            </div>

            <div class="notice notice-sistemakv">
                <a href="registrarProveedorMantenimiento.php" class="btn" id="buttonsKV">Registrar Proveedor <i class="fa fa-plus"></i></a>
            </div>

            <div class="mt-2 p-4 table-responsive" style="background-color: #fff;">
            	<table id="dataT" class="table table-hover table-sm display text-center" style="width:100%">
            		<thead style="background-color: #1b2d3b; color: #fff;">
            			<tr>
            				<th>RAZÓN SOCIAL</th>
            				<th>NIT</th>
            				<th>DIRECCIÓN</th>
            				<th>TELEFONO</th>
                            <th>EMAIL</th>
            				<th>ESTADO</th>
            				<th>OPCIONES</th>
            			</tr>
            		</thead>
            		<tbody>
            			<?php foreach ($listarE as $le){ ?>
            				<tr>
            					<td><?php echo $le['razon_social']; ?></td>
            					<td><?php echo $le['nit']; ?></td>
            					<td><?php echo strtoupper($le['direccion']);?></td>
            					<td><?php echo $le['telefono']; ?></td>
                                <td><?php echo strtoupper($le['email']);?></td>
            					<td>
                                    <?php 
                                        if ($le['estado'] == 'A') {
                                            echo "ACTIVO";
                                        } else{
                                            echo "INACTIVO";
                                        }
                                    ?>
                                </td>
            					<td>

            						<!--Eliminar-->
                						<?php if ($le['estado'] == 'A'){ ?>
                							<a href="../Controlador/bloquearDesbloquearProv.php?id=<?php echo $le['id_proveedor']; ?>_1" class="btn btn-outline-success" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-unlock"></span></a>
                						<?php } elseif ($le['estado'] == 'I') { ?>
                							<a href="../Controlador/bloquearDesbloquearProv.php?id=<?php echo $le['id_proveedor']; ?>_2" class="btn btn-outline-danger" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-lock"></span></a>
                						 <?php }  ?>
            						
                                    <?php if($le['estado'] == 'A'){ ?>

                						<!--Editar-->

                					       <a href="actualizarProveedorMantenimiento.php?id=<?php echo $le['id_proveedor']; ?>" class="btn btn-outline-info"  style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-edit"></span></a>

                                        <!--Sub categoria-->

                                           <a href="registrarSubcategoriaProveedor.php?id=<?php echo $le['id_proveedor']; ?>" class="btn btn-outline-danger"  style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-money"></span></a>

                					    <!--Consultar-->

                                            <button class="btn btn-outline-warning" tton type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalProveedor" style="margin: 0px; padding: 0px 4px 0px 4px;" onclick="cargarCostosServiciosProveedor(<?php echo $le['id_proveedor'] ?>);"><span class="fa fa-search"></span></button>

                                    <?php } ?> 
            					</td>
            				</tr>
            			<?php } ?>
            		</tbody>
            	</table>
            </div>
        
        </section>

    <!-- FIN CONTENIDO -->


    <!-- MODAL SERVICIOS PROVEEDOR -->
        <div class="modal fade" id="modalProveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: none;">
                    <div class="col-12 notice notice-sistemakv">
                        <strong><i class="fa fa-file-text-o mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">SERVICIOS DEL PROVEEDORES</b></strong>
                    </div>
                </div>
                <div class="modal-body" id="datosCostos">
                    
                </div>
                <div class="modal-footer d-flex justify-content-center mt-3" style="border-top: none;">
                    <button type="button" class="btn btn-outline-danger col-3" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
          </div>
        </div>


    <!-- ************************** --->

    <!-- SCRIPT -->

        <?php include("Template/scripts.php"); ?>

        <script type="text/javascript">
            function cargarCostosServiciosProveedor(id_proveedor){
                //alert(id_proveedor);
                var parametros = {
                    "id_proveedor": id_proveedor
                };
                $.ajax({
                    data: parametros,
                    url: '../Controlador/cargarCostosServiciosProveedor.php',
                    type: 'POST',
                    beforeSend: function(){
                        $("#datosCostos").html("<p class='text-center'>Cargando datos por favor espere....</p>");
                    },
                    success: function(response){
                        $("#datosCostos").html(response);
                    }
                });
            }

        </script>

    <!-- FIN SCRIPT -->
    
</body>
</html>