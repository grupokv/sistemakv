<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/General.php");
require_once("../Modelo/Cargo.php");

$usuario = new Usuario();
$cargo = new Cargo();

$listarUsuariosPropietarios = $usuario->listarUsuariosPropietarios();

$listarMensajesAfiliados = listarMensajesAfiliados();

$modulo = 108;
$permisos = permisos($modulo, $_SESSION['id_usuario']);
//print_r($permisos);
if(count($permisos) < 1){
	echo ("<script LANGUAGE='JavaScript'>window.location.href='https://www.sistemakv.com/';</script>");
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Mensajes Afiliados</title>
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

    .img-frontal{
      width: 100px;
    }

    .img-trasera{
      width: 100px;
    }

    .img-izq{
      width: 100px;
    }

    .img-der{
      width: 100px;
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

        .img-frontal{
          width: 100%;
        }

        .img-trasera{
          width: 100%;
        }

        .img-izq{
          width: 100%;
        }

        .img-der{
          width: 100%;
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
            <li class="breadcrumb-item active" aria-current="page">Mensaje Afiliados</li>
         </ol>
    </div>
    
    <hr style="background-color:#5e99b1; ">
    <div class="row barra-principal">

      	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 titulo_principal">
      		  <h2 class="mt-2" style="color: #fff; line-height: 25px;"><span class="fa fa-car icono-principal ml-2" style="border: 2px solid #fff; border-radius: 50%;  font-size:0.8em; padding: 9px;"></span> Mensajes Afiliados</h2>
      	</div>
      	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 botones_principal">
          <button data-toggle="modal" data-target="#RegistroMensajes" class="btn boton-registro ml-1 mr-1"><span class="fa fa-paper-plane ml-2 mr-2"></span><strong style="font-size: 1rem;">Enviar Mensaje</strong></button>
        </div>
    </div>

    <hr style="background-color:#5e99b1;">
      
    <div class="mt-2 p-4 table-responsive">
  	  <table  id="dataT" class="table table-hover table-sm display" style="width:100%">
    		<thead>
    			<tr>
            <th>ID</th>
            <th>USUARIO DESTINATARIO</th>
            <th>MENSAJE</th>
            <th>USUARIO REMITENTE</th>
            <th>FECHA</th>
    			</tr>
    		</thead>
  		  <tbody>
            <?php foreach ($listarMensajesAfiliados as $lma){ ?>
              <tr>
                <td><?php echo $lma['id_mensaje']; ?></td>
                <td>
                  <?php 
                    $listarUsuarioPorId = $usuario->listarUsuarioPorId($lma['id_usuario_destinatario']);
                    echo $listarUsuarioPorId[0]['nombre']; 
                  ?>
                </td>
                <td><?php echo strtoupper($lma['mensaje']); ?></td>
                <td>
                  <?php 
                    $listarUsuarioPorId = $usuario->listarUsuarioPorId($lma['id_usuario_remitente']);
                    $listarCargosPorId = $cargo->listarCargosPorId($listarUsuarioPorId[0]['id_cargo']);
                    echo $listarUsuarioPorId[0]['nombre'] . ' - ' . $listarCargosPorId[0]['nombre_cargo']; 
                  ?>
                </td>
                <td>
                  <?php 
                      $fecha = explode("-", $lma['fecha']); 

                      echo $fecha[2] . " DE " . strtoupper(mes($fecha[1])) . ' DE ' . $fecha[0];
                  ?>
                </td>
              </tr>   
            <?php } ?>
        </tbody>
      </table>
    </div>

		
    <!-- Modal CONDUCTORES-->
      <div class="modal fade" id="RegistroMensajes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
          <div class="modal-content f-flex justify-content-center">
            <div class="modal-body">  
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <section id="contenido col-12">
                  <form action="../Controlador/registrarMensajeAfiliado.php" method="POST">
                    <div class="mt-5 text-center">
                      <h5 class="modal-title mb-3" id="exampleModalLabel"><strong>Enviar Mensaje</strong></h5> 
                    </div>

                    <section style="background-color: #fafafa; padding: 7px; border: 2px solid #f9f9f9;">

                      <div class="col-12 mt-4">

                          <label for=""><i style="color: #5e99b1;" class="fa fa-user-circle-o"></i><strong class="ml-2" style="font-size: .9rem;">USUARIO/S</strong></label>

                          <select class="form-control selectpicker" data-live-search="true" name="id_usuario[]" id="id_usuario" multiple="multiple">
                              <?php foreach ($listarUsuariosPropietarios as $lup){ ?>
                                  <option value="<?php echo $lup['id_usuario']; ?>"><?php echo $lup['nombre']; ?></option>
                              <?php } ?>
                          </select>

                      </div>


                      <div class="col-12 mt-3 mb-3">
                          <label for=""><i style="color: #5e99b1;" class="fa fa-commenting-o"></i><strong class="ml-2" style="font-size: .9rem;">MENSAJE</strong></label>

                          <textarea style="" class="form-control" name="mensaje" id="mensaje" cols="20" rows="5"></textarea>
                      </div>


                      <div class="col-12 mt-3 mb-5 d-flex justify-content-center">
                         <button class="col-5 btn btn-outline " style="background-color: #5e99b1; color: #ffffff;"><i class="fa fa-paper-plane mr-2"></i>Enviar</button>
                      </div>

                    </section>
                  </form>
                </section>
            </div>
          </div>
        </div>
      </div>

  <!-- script -->
  <?php include("Template/scripts.php"); ?>

</tbody>



<script type="text/javascript">


  </script>



  
</body>
</html>