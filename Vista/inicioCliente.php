<?php 
    include("../Controlador/Sesion/autenticar.php");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Inicio</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- STYLES -->
  <?php include("Template/styles.php") ?>

  <style type="text/css">
    #card-events{
      height: 178px;
      background-color: #e9ecef;
    }

    .cards{
      border: 2px solid #ddd;
    }

    .cant-notificaciones{
        background-color: red; 
        width: 25px; 
        height: 25px; 
        position: absolute; 
        border-radius: 50%; 
        top: 12px; 
        left: 170px; 
        border: 3px solid #fff; 
        color: #fff; 
        font-size: .7rem; 
        line-height: 18px;
    }


    @media(max-width: 768px){
      #card-events{
        height: auto;
      }

      .cards{
        margin-left: 5px;
        margin-right: 5px;
      }

      .cant-notificaciones{
          position: absolute;
          left: 150px;
      }

      .boton-cerrar{
          width: 100%;
      }


    }


  </style>


</head>
<body>
    <?php include("Template/menu.php"); ?>
  
    <!-- CONTENIDO -->
      <section class="p-2">
        <div class="alert alert-primary mb-2" role="alert">
        </div>

        <div id="card-events">
          <section class="row" style="margin: 0;">
            
	    <?php if($_SESSION['id_perfil'] != 10){ ?>

            <!-- SERVICIOS -->
              <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 p-3 mt-1 mb-1 cards" style="background-color: #fff; border-radius: 4px;">
                <div class="box-part text-center">
                    <i class="fa fa-bus fa-3x" aria-hidden="true"></i>
                    <div class="title">
                      <h4 style="color: red;">Servicios</h4>
                    </div>
		    <?php if($_SESSION['id_cliente'] == '22'){ ?>
		    <a href="../Vista/serviciosCliente.php">Ver mas <span class="fa fa-search ml-1"></span></a>
		    <?php } else { ?> 
		    <a href="../Controlador/buscarServiciosActivos.php">Ver mas <span class="fa fa-search ml-1"></span></a>
		    <?php } ?>
                </div>
              </div>
	      <?php } ?>

	      <?php if($_SESSION['id_perfil'] == 10){ ?>

	      <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 p-3 mt-1 mb-1 cards" style="background-color: #fff; border-radius: 4px;">
                <div class="box-part text-center">
                    <i class="fa fa-file fa-3x" aria-hidden="true"></i>
                    <div class="title">
                      <h4 style="color: red;">Reporte</h4>
                    </div> 
		    <?php if($_SESSION['id_cliente'] == '22'){ ?>
		    <a href="../Vista/reporteServiciosCliente.php">Consultar <span class="fa fa-search ml-1"></span></a>
		    <?php } else { ?>      
                    <a href="../Vista/reporteRecorridos.php">Consultar <span class="fa fa-search ml-1"></span></a>
		    <?php } ?>
                </div>
              </div>

	      <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 p-3 mt-1 mb-1 cards" style="background-color: #fff; border-radius: 4px;">
                <div class="box-part text-center">
                    <i class="fa fa-file fa-3x" aria-hidden="true"></i>
                    <div class="title">
                      <h4 style="color: red;">Vehiculos</h4>
                    </div> 
		    <a href="../Vista/vehiculosCliente.php">Consultar <span class="fa fa-search ml-1"></span></a>
                </div>
              </div>
	      <?php } ?>

	      <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 p-3 mt-1 mb-1 cards" style="background-color: #fff; border-radius: 4px;">
                <div class="box-part text-center">
                    <i class="fa fa-file fa-3x" aria-hidden="true"></i>
                    <div class="title">
                      <h4 style="color: red;">Preoperacionales</h4>
                    </div> 
		    <a href="../Vista/preoperacionalesCliente.php">Consultar <span class="fa fa-search ml-1"></span></a>
                </div>
              </div>

		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 p-3 mt-1 mb-1 cards" style="background-color: #fff; border-radius: 4px;">
                <div class="box-part text-center">
                    <i class="fa fa-file fa-3x" aria-hidden="true"></i>
                    <div class="title">
                      <h4 style="color: red;">Desinfecciones</h4>
                    </div> 
		    <a href="../Vista/desinfeccionesCliente.php">Consultar <span class="fa fa-search ml-1"></span></a>
                </div>
              </div>
        
          </section>
        </div>
      </section>
    </section>
    <!-- FIN CONTENIDO -->

    

    
  <!-- SCRIPTS -->
  <?php include("Template/scripts.php") ?>
</body>
</html>
