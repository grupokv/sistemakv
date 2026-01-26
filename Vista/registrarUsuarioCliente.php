<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/CargoCliente.php");

/* VARIABLES MENU*/
$titulo = 'Registrar Usuario';
$redireccion = 'usuarios_clientes.php';
$icono = 'fa fa-user-o';

/**/
$cliente = new Cliente();
$listarC = $cliente->listar();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Registrar usuario cliente</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>

</head>
<body>


    <?php include("Template/menu.php"); ?>

    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="usuario_cliente.php">Usuarios Clientes</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar usuario</li>
         </ol>
    </div>


    <section class="form-usuarios mt-1">
        <div class="formulario">

            <form method="POST" action="../Controlador/registrarUsuarioCliente.php">
                <?php include("Template/header-form.php"); ?>                    
                    <hr>
                        <!-- NOMBRE -->
                          <div class="row mt-4 mb-4 ">
                              <div class="label">    
                                  <label for="nombre">Nombres</label>
                              </div>
                              <div class="input">    
                                  <input type="text" name="nombre" id="nombre" class="form-control">
                              </div>
                          </div>

			 <div class="row mt-4 mb-4 ">
                              <div class="label">    
                                  <label for="apellido">Apellidos</label>
                              </div>
                              <div class="input">    
                                  <input type="text" name="apellido" id="apellido" class="form-control">
                              </div>
                          </div>

                        <!-- CORREO ELECTRONICO -->
                          <div class="row mb-4 ">
                              <div class="label">    
                                  <labe for="correo_electronico"l>Correo electronico</label>
                              </div>
                              <div class="input">    
                                  <input type="text" name="correo_electronico" id="correo_electronico" class="form-control">
                              </div>
                          </div>

                        <!-- NUMERO DE DOCUMENTO -->
                          <div class="row mb-4 ">
                              <div class="label">    
                                  <label for="numero_documento">Numero de Documento</label>
                              </div>
                              <div class="input">    
                                  <input type="text" name="numero_documento" id="numero_documento"  class="form-control">
                              </div>
                          </div>
			
			<div class="row mb-4 ">
                              <div class="label">    
                                  <label for="id_cliente">Cliente</label>
                              </div>
                              <div class="input">
                                  <select class="form-control selectpicker" data-live-search="true" name="id_cliente" id="id_cliente" onchange="cargarDatos(this.value)">
                                      <option>Seleccionar Cliente</option>
                                      <?php foreach ($listarC as $lc){ ?>
                                        <option value="<?php echo $lc['id_cliente'] ?>">
                                          <?php echo $lc['razon_social'] ?>
                                        </option>
                                      <?php } ?>
                                  </select>
                              </div>
                          </div>


                        <!-- CARGO -->
                          <div class="row mb-4 ">
                              <div class="label">    
                                  <label for="id_cargo">Cargo</label>
                              </div>
                              <div class="input">
                                  <select class="form-control" name="id_cargo" id="id_cargo">
                                  </select>
                              </div>
                          </div>

                        <!-- PERFIL -->
                          <div class="row mb-4 ">
                              <div class="label">    
                                  <label for="id_centro_costo">Centro Costo</label>
                              </div>
                              <div class="input">    
                                  <select class="form-control" name="id_centro_costo" id="id_centro_costo">
                                  </select>
                              </div>
                          </div>
                    <hr>
                <?php include("Template/bottom-form.php"); ?>
            </form>
        </div>
    </section>

    <?php include("Template/scripts.php"); ?>
<script>

        function cargarDatos(id_cliente){

          //alert(id_cliente); 

          if(id_cliente != ''){

              var parametros = {

                "id_cliente" : id_cliente

              };

              $.ajax({

                  data:  parametros,

                  url:   '../Controlador/listarCentroCostosCliente.php',

                  type:  'post',

                  beforeSend: function () {

                      //alert('envio');

                      $("#id_centro_costo").html("<option value='' disabled='disabled' selected='selected'>Cargando datos, por favor espere</option>");

                  },

                  success:  function (response) {

                      //alert(response);

                      $("#id_centro_costo").html(response);

                  }

              });

	      $.ajax({

                  data:  parametros,

                  url:   '../Controlador/listarCargosCliente.php',

                  type:  'post',

                  beforeSend: function () {

                      //alert('envio');

                      $("#id_cargo").html("<option value='' disabled='disabled' selected='selected'>Cargando datos, por favor espere</option>");

                  },

                  success:  function (response) {

                      //alert(response);

                      $("#id_cargo").html(response);

                  }

              });

          }

        }        

    </script>
</body>
</html>