<?php 
include("../Controlador/Sesion/autenticar.php");
include("../Modelo/Viaje.php");

$hoy = date('Y-m-d');
$hora = date('H:i:s');
$viaje = new Viaje();
$reservas = $viaje->buscarReservasActivasUsuario($_SESSION['id_usuario']);
$cant_pp = count($reservas);
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Inicio Pasajero</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- STYLES -->
  <?php include("Template/styles.php") ?>

  <style type="text/css">
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
          left: 185px;
      }


    }

  </style>

</head>
<body>

    <!--MENU-->
        <?php     
            include("Template/menu.php"); 
        ?>
    <!--FIN MENU-->

    <!--***************************-->
  
    <!-- CONTENIDO -->
    <section class="p-2">
        <div class="alert alert-primary m-0" role="alert">
        </div>
        <div id="card-events">
          <section class="row">
           
                <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 p-3 mt-1 mb-1 cards mr-2 ml-2" style="background-color: #fff; border-radius: 4px;">
                    <div class="box-part text-center">
                      <i class="fa fa-ticket fa-3x" aria-hidden="true"></i><?php if ($cant_pp != 0){ ?><div class="text-center cant-notificaciones"><?php echo $cant_pp;?></div><?php } ?>
                      <div class="title">
                        <h4 style="color: red;">Mis Reservas</h4>
                      </div>          
                      <div class="text">
                        <span style="font-size: 0.9rem;">Consulte sus reservas aqui</span>
                      </div>           
                      <a href="mis_reservas.php">Consultar <span class="fa fa-search ml-1"></span></a>
                    </div>
                  </div>

                 <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 p-3 mt-1 mb-1 cards mr-2 ml-2" style="background-color: #fff; border-radius: 4px;">
                    <div class="box-part text-center">
                      <i class="fa fa-check fa-3x" aria-hidden="true"></i>
                      <div class="title">
                        <h4 style="color: red;">Realizar Reserva</h4>
                      </div>          
                      <div class="text">
                        <span style="font-size: 0.9rem;">Consulte viajes y sillas disponibles</span>
                      </div>           
                      <a href="consultar_viajes.php" >Consultar <span class="fa fa-search ml-1"></span></a>
                      
                        
                    </div>
                  </div>
                  
                  

          </section>
        </div>
      </section>
    </section>

    <!-- FIN CONTENIDO -->

    <!--***************************-->

  <!-- SCRIPTS -->
  <?php include("Template/scripts.php") ?>
</body>
</html>