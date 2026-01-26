 <?php 
include("../Controlador/Sesion/autenticar.php");

require_once("../Modelo/Cliente.php");

$id_usuario = $_SESSION['id_usuario'];

$cliente = new Cliente();
$listarClientesAncladosPorPropietario = $cliente->listarClientesAncladosPorPropietario($id_usuario);

 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Clientes Propietarios</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- STYLES -->
    <?php include("Template/styles.php") ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
    <style type="text/css">



      .input-group-text{
          background: #fff;
          border: 0px;
      }

      #documentoCliente{
          text-transform: capitalize !important;
          border-style: hidden;
          border-radius: 20px;
          border: 2px solid #4c81a8;
      }

      #TitleSearchClient{
        width: 100%;
        height: auto;
        background: #1b2d3b;
        color: #fff;
        border-radius: 5px 5px 5px 5px;
        margin: 0px;
        font-size: .9rem;
        padding: 0px;
      }

      #buttonSearch{
        width: 150px;
        background: #4c81a8;
        color: #fff;
      }

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

          #TitleSearchClient{
            width: 100%;
            height: auto;
            border-radius: 0px;
            padding-right: 0px;
          }

          #container{
            margin: 0px;
            padding: 0px;
          }

          #sectionInfoClientes{
             height: auto;
             width: 100%;
             margin-top: 5px;
             border-radius: 6px !important; 
             border: 1px solid;
          }

          #sectionBuscadorClientes{
             border-radius: 6px !important; 
             border: 1px solid;
          }

          #container-title{
            margin: 0px;
            padding: 0px;
          }
      }
    </style>
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
                <li class="breadcrumb-item " aria-current="page"><a href="inicioPropietarios.php">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Clientes</li>
             </ol>
          </div>

          <div class="notice notice-sistemakv" style="background-color: #fff;">
              <strong><i class="fa fa-users mr-3" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">CLIENTES</b></strong>
          </div>

          <section id="main" class="col-12 mt-5 mb-5">
            
            <div class="col-12 mt-3" style="background-color: #1b2d3b; color: #fff; border-radius: 3px; width: 100%">
                <p style="margin: 10px; margin-top: 10px;">BUSCAR Y ANCLAR CLIENTE</p>
            </div>

            <div id="container" class="col-12 mt-3">
                <section class="row">
                    <div id="sectionBuscadorClientes" class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="border-radius: 6px 0px 0px 6px; border:1px solid #dedede; background-color: #fff;">

                        <div class="col-12 mt-5 mb-5">
                            <label class="col-12"><strong>NIT o Número de Documento del Cliente</strong></label>

                            <div class="col-12 input-group mb-2">
                                <input type="text" class="form-control" id="documentoCliente" placeholder="Buscar">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><span class="fa fa-search"></span></div>
                                </div>
                            </div>

                            <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $id_usuario; ?>">

                        </div>
                    </div>
                    <div id="sectionInfoClientes" class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="border-radius: 0px 6px 6px 0px; border-bottom: 1px solid; border-right: 1px solid; border-top:1px solid; border-color: #dedede; background-color: #fff;">
                    </div>
                </section>
            </div>

            <div id="sectionButton" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2 p-2" style="background-color: #fff; display: flex; justify-content: center;">
              <button type="submit" id="buttonsKV" class="btn col-3" onclick="validarClienteBusqueda();">Buscar</button>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3" style="background-color: #1b2d3b; color: #fff; border-radius: 3px; width: 100%; height: 18px;"></div>

          </section>

          <div class="notice notice-sistemakv" style="background-color: #fff;">
              <a href="registrarClientes.php" class="btn" id="buttonsKV">Crear Cliente <i class="fa fa-plus"></i></a>
          </div>

          <!-- TABLE -->
            <div class="mt-2 mb-4 p-3 table-responsive" style="background-color: #fff;">
              <table id="dataT" class="table table-hover table-sm display text-center" style="width:100%">
                <thead style="background-color: #1b2d3b; color: #fff;">
                  <tr>
                      <th>RAZÓN SOCIAL</th>
                      <th>NIT - CEDULA</th>
                      <th>DIRECCIÓN</th>
                      <th>TELÉFONO</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($listarClientesAncladosPorPropietario as $lcpp){ 
                    $listarClientesPorId = $cliente->cliente_ID($lcpp['id_cliente']); ?>
                      <tr>
                        <td><?php echo $listarClientesPorId[0]['razon_social'] ?></td>
                        <td><?php echo $listarClientesPorId[0]['nit_cliente'] ?></td>
                        <td><?php echo $listarClientesPorId[0]['direccionC'] ?></td>
                        <td><?php echo $listarClientesPorId[0]['telefonoC'] ?></td>
                      </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>

          <!-- FIN TABLE -->
      </section>
    <!-- FIN CONTENIDO -->

    <!--**************************--->

    <!-- SCRIPT -->
      <?php include("Template/scripts.php"); ?>

      <script type="text/javascript">
            $('#documentoCliente').keypress(function (tecla) {
              if (tecla.charCode < 48 || tecla.charCode > 57) return false;
            });

            function validarClienteBusqueda(){
                var buscador = $("#documentoCliente").val();
                var id_usuario = $("#id_usuario").val();

                var parametros = {
                    "buscador" : buscador,
                    "id_usuario" : id_usuario,
                };
                $.ajax({
                    data:  parametros,
                    url:   '../Controlador/validarClienteBusquedaPropietario.php',
                    type:  'POST',
                    beforeSend: function () {
                    },
                    success:  function (response) {
                        $('#sectionInfoClientes').html(response);
                    }
                });
            }
      </script>
    <!-- FIN SCRIPT-->

  
</body>
</html>