<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Programacion.php");

$programacion = new Programacion();
$listarUnidadesOperativasProgramacion = $programacion->listarUnidadesOperativasProgramacion();
$listarTiposServiciosVariables = $programacion->listarTiposServiciosVariables();

$id_servicio = $_GET['id_servicio'];
$listarSolicitudPorId = $programacion->listarServiciosVariablesID($id_servicio);
//print_r($listarSolicitudPorId);

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Servicios Variables</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- STYLES -->
  <?php include("Template/styles.php") ?>

  <style type="text/css">

      @import url(https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic);

      body {
        color: #797979;
        background: #eeeeee;
        font-family: 'Lato', sans-serif;
        padding: 0px !important;
        margin: 0px !important;
        font-size:14px !important;
      }

      h1,h2,h3,h4,h5{
        font-weight: 300;
      }

      .lite{
        color: #00a0df !important;
      }

      .header {
          min-height: 50px;
          padding: 0 15px;
      }

      .header {
        position: fixed;
        left: 0;
        right: 0;
        z-index: 1002;
        border-bottom: 2px solid #fff;
      }

      a.logo {
        font-size: 22px;
        font-weight: 300;
        color: #fed189;
        float: left;
        margin-top: 8px;
        margin-left: 20px;
        text-transform: uppercase;
      }

      a.logo:hover, a.logo:focus {
        text-decoration: none;
        outline: none;
      }

      #top_menu .nav > li, ul.top-menu > li {
        float: left;
      }

      #notification_bar{
        margin-top: 5px;
      }

      ul.top-menu > li > a {
        color: #797979;
        font-size: 18px;
        padding: 2px 6px;
        margin-right: 15px;
      }

      ul.top-menu > li > a:hover, ul.top-menu > li > a:focus {
        background: transparent !important;
        color: #D7D7D7 !important;
      }

      .notification-row .badge {
        position: absolute;
        right: -4px;
        top: 0px;
        z-index: 100;
        border-radius: 9px;
        min-width: 18px;
        height: 18px;
        text-align: center;
        padding: 3px 5px;
        font-weight: 350;
        font-size: .7rem;
        color: #fff;
      }

      .badge {
        border-radius: 9px;
        min-width: 18px;
        height: 18px;
        text-align: center;
        padding: 3px 5px;
        background: #00a0df;
      }

      .top-nav  {
        margin-top: 5px;
      }

      .top-nav li.dropdown .dropdown-menu {
        float: right;
        right: 0;
        left: auto;
      }

      .dropdown-menu > li > a{
        color: #797979;
      }

      .top-nav ul.top-menu > li > a {
        padding: 8px;
        background: none;
        margin-right: 0;
      }

      .top-nav ul.top-menu > li {
        margin-left: 10px;
      }

      .dropdown-toggle::after {
        display:none;
      }

      .toggle-nav {
        float: left;
        padding-right: 15px;
        margin-top: 10px;
      }

      .toggle-nav .icon-reorder {
        cursor: pointer;
        display: inline-block;
        font-size: 20px;
      }

.dropdown-menu.extended {

    max-width: 300px !important;

    min-width: 160px !important;

    top: 42px;

    width: 235px !important;

    padding: 0;

    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.176) !important;

    border: none !important;

    border-radius: 4px;

    -webkit-border-radius: 4px;

}


/*----*/


  .notice {
      padding: 15px;
      background-color: #fafafa;
      border-left: 6px solid #7f7f84;
      margin-bottom: 10px;
      -webkit-box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
         -moz-box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
              box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
  }

  .notice-warning {
      border-color: #FEAF20;
  }
  .notice-warning>strong {
      color: #FEAF20;
  }
table {
  border-collapse: collapse;
  border-radius: .4em;
  overflow: hidden;
}

  </style>

</head>
<body>

    
    <?php include("Template/header.php"); ?>
    <?php include("Template/newMenu.php"); ?>


    <section class="home_content">

        <div aria-label="breadcrumb" class="mt-1"> 
           <ol class="breadcrumb" style="background: #fff;">
            <li class="breadcrumb-item"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item"><a href="inicio.php">Solicitudes Servicios</a></li>
            <li class="breadcrumb-item active" aria-current="page">registro Solicitudes</li>
           </ol>
        </div>
        
        <div class="notice notice-warning">
          <strong><i class="fa fa-file-text-o mr-3" style="font-size: 2rem;"></i>ACTUALIZAR SOLICITUD SERVICIOS VARIABLES</strong>
        </div>


    <section class="form-usuarios mt-1">

        <div class="formulario mb-5 p-4">

            <form action="../Controlador/actualizarSolicitudServiciosVariables.php" method="POST" id="actualizar">
                <?php foreach ($listarSolicitudPorId as $lspi){ ?>
                    
                    <!-- FECHA -->
                        <input type="hidden" name="id_servicio" id="id_servicio" class="form-control" value="<?php echo $id_servicio ?>">

                    <!-- UNIDAD OPERATIVA -->

                        <div class="row  mt-3 ">
                            <section class="label">
                                <label><strong>Unidad Operativa</strong></label>
                            </section>
                            <section class="input">
                                <select name="unidad_operativa" id="unidad_operativa" class="form-control selectpicker" data-live-search="true"> 
                                    <option value="">SELECCIONAR</option>
                                    <?php foreach ($listarUnidadesOperativasProgramacion as $uop){ ?>
                                        <option value="<?php echo $uop['id_unidad'] ?>" <?php if($lspi['unidad_operativa'] == $uop['id_unidad']){ ?> selected="selected" <?php } ?> >
                                            <?php echo utf8_encode($uop['unidad_operativa']); ?>
                                        </option>

                                    <?php } ?>
                                </select> 
                            </section>
                        </div>

                    <!-- FECHA -->
                        <div class="row mt-3">
                            <section class="label">
                                <label><strong>Fecha Inicial</strong></label>
                            </section>
                            <section class="input">
                                <input type="text" name="fecha_inicial" id="datepicker" class="form-control" readonly="true" value="<?php echo $lspi['fecha_inicial']; ?>">
                            </section>
                        </div>

                    <!-- FECHA -->
                        <div class="row mt-3">
                            <section class="label">
                                <label><strong>Fecha Final</strong></label>
                            </section>
                            <section class="input">
                                <input type="text" name="fecha_final" id="datepicker1" class="form-control" readonly="true" value="<?php echo $lspi['fecha_final']; ?>">
                            </section>
                        </div>

                    <!-- DIRECCIÓN -->
                        <div class="row mt-3">
                            <section class="label">
                                <label><strong>Dirección</strong></label>
                            </section>
                            <section class="input">
                                <input type="text" name="direccion" id="direccion" class="form-control" value="<?php echo $lspi['direccion']; ?>">
                            </section>
                        </div>

                    <!-- LUGAR DE DESTINO -->
                        <div class="row mt-3">
                            <section class="label">
                                <label><strong>Lugar de Destino</strong></label>
                            </section>
                            <section class="input">
                                <input type="text" name="lugar_destino" id="lugar_destino" class="form-control" value="<?php echo $lspi['lugar_destino']; ?>">
                            </section>
                        </div>

                    <!-- HORA ENCUENTRO -->
                        <div class="row mt-3">
                            <section class="label">
                                <label><strong>Hora de Encuentro</strong></label>
                            </section>
                            <section class="input">
                                <input type="text" name="hora_encuentro" id="hora_encuentro" class="form-control clockpicker" readonly="true" value="<?php echo $lspi['hora_encuentro']; ?>"> 
                            </section>
                        </div>

                    <!-- HORA REGISTRO -->
                        <div class="row mt-3">
                            <section class="label">
                                <label><strong>Hora de Regreso</strong></label>
                            </section>
                            <section class="input">
                                <input type="text" name="hora_regreso" id="hora_regreso" class="form-control clockpicker1" readonly="true" value="<?php echo $lspi['hora_regreso']; ?>"> 
                            </section>
                        </div>

                    <!-- CAPACIDAD-->
                        <div class="row mt-3">
                            <section class="label">
                                <label><strong>Capacidad del Servicio</strong></label>
                            </section>
                            <section class="input">
                                <input type="text" name="capacidad" id="capacidad" class="form-control" value="<?php echo $lspi['capacidad']; ?>">
                            </section>
                        </div>


                    <!-- PAX-->
                        <div class="row mt-3">
                            <section class="label">
                                <label><strong>Cantidad de Pax</strong></label>
                            </section>
                            <section class="input">
                                <input type="text" name="cant_pax" id="cant_pax" class="form-control" value="<?php echo $lspi['cant_pax']; ?>">
                            </section>
                        </div>

                    <!-- OBSERVACIONES -->
                        <div class="row mt-3">
                            <section class="label">
                                <label><strong>Observaciones</strong></label>
                            </section>
                            <section class="input">
                                <textarea name="observaciones" id="observaciones" class="form-control" value="<?php echo $lspi['observaciones']; ?>"></textarea>
                            </section>
                        </div>

                    <!-- TIPO SERVICIO -->

                        <div class="row  mt-3 ">
                            <section class="label">
                                <label><strong>Tipo de Servicio</strong></label>
                            </section>
                            <section class="input">
                                <select name="tipo_servicio" id="tipo_servicio" class="form-control selectpicker" data-live-search="true"> 
                                    <option value="">SELECCIONAR</option>
                                    <?php foreach ($listarTiposServiciosVariables as $ltsv){ ?>
                                        <option value="<?php echo $ltsv['id'] ?>" <?php if($lspi['tipo_servicio'] == $ltsv['id']){ ?> selected="selected" <?php } ?> >
                                            <?php echo $ltsv['codigo'] . ' | ' . $ltsv['tipo_servicio'] ; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </section>
                        </div>
                    
                    <!--CANT VEHICULOS -->

                        <div class="row  mt-3 ">
                            <section class="label">
                                <label><strong>N° de Vehículos</strong></label>
                            </section>
                            <section class="input">
                                <input type="text" name="num_buses" id="num_buses" class="form-control" value="<?php echo $lspi['num_buses']; ?>">
                            </section>
                        </div>



                <!-- SOLICITANTE -->

                    <div class="row  mt-3 ">
                        <section class="label">
                            <label><strong>Solicitante</strong></label>
                        </section>
                        <section class="input">
                            <select name="id_solicitante" id="id_solicitante" class="form-control selectpicker" data-live-search="true"> 
                                <option value="">SELECCIONAR</option>
                                <option value="1" <?php if($lspi['id_solicitante'] == 1) { ?> selected="selected" <? }?>>NIKOLAS MURILLO</option>
                                <option value="2" <?php if($lspi['id_solicitante'] == 2) { ?> selected="selected" <? }?>>FREDDY</option>
                                <option value="3" <?php if($lspi['id_solicitante'] == 3) { ?> selected="selected" <? }?>>ABELARDO</option>
                                
                            </select>
                        </section>
                    </div>


                    <section class="col-12 mt-4 d-flex justify-content-center">
                        <a href="solicitud_servicios_variables.php" class="btn btn-danger col-3 mr-3">Cancelar</a>
                        <button type="submit" class="btn btn-info col-3">Actualizar</button>
                    </section>

                <?php } ?>

            </form>

        </div>

    </section>


    </section>

    <!-- FIN CONTENIDO -->

    <!--***************************-->

  <!-- SCRIPTS -->
  <?php include("Template/scripts.php") ?>

  <script>
    
      $('.clockpicker').clockpicker({
          placement: 'bottom',
          align: 'left',
          autoclose: true,
      });

      $('.clockpicker1').clockpicker({
          placement: 'bottom',
          align: 'left',
          autoclose: true,
      });

      $( function() {
          $("#datepicker").datepicker({ dateFormat:'yy-mm-dd'});
          $("#datepicker1").datepicker({ dateFormat:'yy-mm-dd'});
      });


      $('#capacidad').keypress(function (tecla) {
          if (tecla.charCode < 48 || tecla.charCode > 57) return false;
      });


  </script>
</body>
</html>