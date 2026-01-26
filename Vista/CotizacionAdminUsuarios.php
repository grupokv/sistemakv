<?php 
require_once("../Controlador/Sesion/CotizadorAutenticar.php");
require("../Modelo/CotizadorKV.php");

$cotizadorkv = new CotizadorKV();

$listar = $cotizadorkv->listar_usuarios();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Usuarios</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- styles -->
    <?php include("Template/styles.php") ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">

</head>
<body>

    <!--MENU-->
        <?php include("Template/header_cotizador.php"); ?>
    <?php include("Template/menu_cotizador.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->
    
<section class="home_content">

    <!-- CONTENIDO -->
    <div aria-label="breadcrumb" class="mt-1"> 
        <ol class="breadcrumb" style="background: #fff;">
            <li class="breadcrumb-item " aria-current="page"><a href="CotizacionNuevo.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
        </ol>
    </div>

    <div class="notice notice-sistemakv">
        <strong>
            <i class="fa fa-build mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">USUARIOS</b>
        </strong>
    </div>
    
    <div class="notice notice-sistemakv">
        <a id="buttonsKV" href="CotizadorAdminUsuariosNew.php" class="btn ml-1 mr-1">Nuevo Usuario <i class="fa fa-plus-circle ml-1"></i></a>
    </div>

    <div class="mt-2 mb-5 p-4 table-responsive" style="background-color: #fff;">
    	<table id="dataT" class="table table-hover table-sm display tablesaw tablesaw-columntoggle" data-tablesaw-mode="columntoggle" data-tablesaw style="width:100%">
    		<thead class="text-center" style="background-color: #1b2d3b; color: #fff;">
    			<tr>
    			    <th>NUM</th>
                    <th>USUARIO</th>
                    <th>NOMBRE</th>
                    <th>CORREO</th>
                    <th>ESTADO</th>
    				<th style="width: 100px;">OPCIONES</th>
    			</tr>
    		</thead>
    		<tbody class="text-center">
                <?php $i = 1; foreach ($listar as $lu){ ?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $lu['usuario'] ?></td>
                        <td><?php echo $lu['nombre'] ?></td>
                        <td><?php echo $lu['correo'] ?></td>
                        <td><?php if($lu['estado'] == 1) { echo "ACTIVO"; } else { echo "INACTIVO"; } ?></td>
                        <td>
                            <?php if ($lu['estado'] == 0){ ?>
                                    <a href="../Controlador/bloquearDesbloquearUsuarioCotizador.php?id=<?php echo base64_encode($lu['id_usuario']); ?>_1" class="btn btn-outline-success" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-unlock"></span></a>
                            <?php } else if ($lu['estado'] == 1) { ?>
                                    <a href="../Controlador/bloquearDesbloquearUsuarioCotizador.php?id=<?php echo base64_encode($lu['id_usuario']); ?>_2" class="btn btn-outline-danger" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-lock"></span></a>
                            <?php } ?>
                            
                            <a href="CotizadorAdminUsuariosEdit.php?id_usuario=<?php echo base64_encode($lu['id_usuario']) ?>" class="btn btn-outline-info"  style="margin: 0px; padding: 0px 4px 0px 4px;">
                                <span class="fa fa-edit"></span>
                            </a>
                            <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#modalDelete" style="margin: 2px; padding: 0px 4px 0px 4px;" onclick="borrar_registro(<?php echo $lu['id_usuario'];?>)"><i class="fa fa-close"></i></button>
                        </td>
                </tr>
                <?php $i++; } ?>
    		</tbody>
    	</table>
    </div>

</section>

<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog " role="document">
            <div class="modal-content f-flex justify-content-center">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">ELIMINAR REGISTRO</h5>  
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <section id="contenido_modal_contratos" name="contenido_modal_contratos">
                    Esta seguro de eliminar el registro?
                  </section>
              </div>
              <div class="modal-footer">
                  <form action="../Controlador/borrarUsuarioCotizador.php" method="post">
                      <input type="hidden" name="id_borrar" id="id_borrar" value=""/>
                      <button type="submit" class="btn btn-outline-success" >Confirmar</button>
                  </form>
                  
                  <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>
    
    <!-- FIN CONTENIDO -->
  <!-- script -->
  <?php include("Template/scripts.php"); ?>

    <script>
    function borrar_registro(id){
        document.getElementById('id_borrar').value = id;
    }
    </script>
  
</body>
</html>