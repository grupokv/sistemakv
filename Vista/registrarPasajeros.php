<?php 
include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/TipoPasajero.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/Curso.php");

$titulo = 'Actualizar Pasajeros';
$redireccion = 'pasajeros.php';
$icono = 'fa fa-user';


$tipopasajero = new Tipopasajero();
$listarTipos = $tipopasajero->listar();

$colegio = new Cliente();
$listarColegios = $colegio->listarClientePorIdSegmento('3');

$curso = new Curso();

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Registrar pasajeros</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- styles -->
  <?php include("Template/styles.php"); ?>
  <link rel="stylesheet" href="../Resources/css/registrarUsuario.css">

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
            <li class="breadcrumb-item " aria-current="page"><a href="pasajeros.php">Pasajero</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar pasajeros</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="col-10 formulario mb-5">
            <div class="row" style="height: 60px; background-color: #5e99b1; ">
              <div class="col-">
                <h2 class="ml-4 mt-2" style="color: #fff;"><span class="fa fa-users" style="border: 1px solid #fff; border-radius: 50%; padding: 5px;"></span> Registrar pasajeros</h2>
              </div>
            </div>
            <hr>
            <!-- Formulario -->
            <form method="POST" action="../Controlador/registrarPas.php" class="p-4">

                    <!-- NOMBRE -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Nombre</label>
                        </div>
                        <div class="col-10">    
                            <input type="text" name="nombre" id="nombre" class="form-control">
                        </div>
                    </div>

                    <!-- DIRECCCION -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Dirección</label>
                        </div>
                        <div class="col-10">    
                            <input type="text" name="direccion" id="direccion" class="form-control">
                        </div>
                    </div>

                    <!-- HORA SUBIDA -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Hora Subida</label>
                        </div>
                        <div class="col-10">    
                                <input type="text" id="hora_subida" name="hora_subida" data-target="#hora_subida" class="form-control datetimepicker-input" data-target="#hora_subida" data-toggle="datetimepicker"/>
                        </div>
                    </div>

                    <!-- HORA BAJADA -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Hora Bajada</label>
                        </div>
                        <div class="col-10">    
                                <input type="text" id="hora_bajada" name="hora_bajada" data-target="#hora_bajada" class="form-control datetimepicker-input" data-target="#hora_bajada" data-toggle="datetimepicker"/>
                                
                        </div>
                    </div>

                    <!-- TIPO PASAJERO -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Tipo de Pasajero</label>
                        </div>
                        <div class="col-10">    
                           <select class="form-control" name="id_tipopasajero" id="id_tipopasajero" onchange="buscar_cursos()">
                                <option>Seleccionar </option>
                                <?php foreach ($listarTipos as $lt){ ?>
                                  <option value="<?php echo $lt['id_tipo'] ?>">
                                    <?php echo $lt['nombre'] ?>
                                  </option>
                                <?php } ?>
                              </select>
                        </div>
                    </div>

                    <!-- COLEGIO -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label for="speed">Colegio</label>
                        </div>
                        <div class="col-10">
                              <select class="form-control" name="id_colegio" id="id_colegio" onchange="buscar_cursos()">
                                <option value="">Seleccionar </option>
                                <?php foreach ($listarColegios as $lc){ ?>
                                  <option value="<?php echo $lc['id_cliente'] ?>">
                                    <?php echo $lc['razon_social'] ?>
                                  </option>
                                <?php } ?>
                              </select>
                        </div>
                    </div>

                    <!-- CURSO -->
                    <div class="row col-12 mb-4" id="select_curso" style="display: none">
                        <div class="col-2 text-center">    
                            <label for="speed">Curso</label>
                        </div>
                        <div class="col-10">
                            <select class="form-control" name="id_curso" id="id_curso">
                                <option value="">Seleccionar </option>
                            </select>
                        </div>
                    </div>

                    <hr>

                    <!-- BOTONES -->
                    <div class="row d-flex justify-content-center mt-4">
                      <div class="col-3">
                         <a type="submit" href="pasajeros.php" class="btn btn-danger btn-block">Cancelar</a>
                      </div>
                      <div class="col-3">
                          <input type="submit" class="btn btn-ingresar btn-block" value="Registrar"></input>
                      </div>
                 
                  
                    </div>
            </form>
        </div>
    </section>

    
    <!-- FIN CONTENIDO -->


  <!-- script -->
  <?php include("Template/scripts.php"); ?>
<!--INICIO INPUT HORA-->
<script type="text/javascript" src="../Resources/js/moment/moment.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
<!--FIN INPUT HORA-->

  <script type="text/javascript">

        $( function() {
            $( "#datepicker" ).datepicker();
        } );

        $( function() {
            $( "#id_perfil" ).selectmenu();
            $( "#id_cargo" ).selectmenu();
        } );
        $(function () {
            $('#hora_subida').datetimepicker({
              format: 'LT'
            });
        });
        $(function () {
            $('#hora_bajada').datetimepicker({
              format: 'LT'
            });
        });

        function buscar_cursos(){
          var colegio = document.getElementById('id_colegio').value;
          var tipo = document.getElementById('id_tipopasajero').value;
          //alert(colegio);
          if((colegio != '')&&(tipo == '1')){
              var parametros = {
                "colegio" : colegio
              };
              $.ajax({
                  data:  parametros,
                  url:   '../Modelo/CargarCursos.php',
                  type:  'post',
                  beforeSend: function () {
                      //alert('envio');
                      //$("#semana").html("Procesando, espere por favor...");
                  },
                  success:  function (response) {
                      //alert(response);
                      $("#id_curso").html(response);
                  }
              });
              document.getElementById('select_curso').style.display = 'flex';
          } else {
              document.getElementById('select_curso').style.display = 'none';
              document.getElementById('id_curso').value = '';
              $("#id_curso").html('<option value=""></option>');
          }
        }
  </script>
  
</body>
</html>