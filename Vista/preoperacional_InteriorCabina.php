<?php 
include ("../Controlador/Sesion/autenticar.php");

/* VARIABLES MENU*/
$titulo = 'Pre Operacional';
$redireccion = 'inicio.php';
$icono = 'fa fa-car';

$id_preoperacional = $_GET['id'];

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Pre Operacional</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">

    <style type="text/css" media="screen">
      
    </style>
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pre Operacional</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="formulario mb-5">
	        <form action="../Controlador/registrarPreoperacionalesInteriorCabina.php" method="POST">
	        	<?php include("Template/header-form.php"); ?>


                    <!--id_preoperacional-->
                    <input type="hidden" name="id_preoperacional" id="id_preoperacional" value="<?php echo $id_preoperacional ?>">
                        
                    <table class="table">
                      <thead>
                        <tr class="text-center">
                          <th  style="border: 0"> INTERIOR DE LA CABINA </th>
                          <th  style="border: 0"> REQUISITO </th>
                          <th  style="border: 0"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                            <td style="border: 0px"> Plumillas Limpiavidrios. </td>
                            <td style="border: 0px"> Funcionando / Empaques sin desgaste. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="plumillas_limpiavidrios" id="plumillas_limpiavidrios" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Indicadores luces tablero. </td>
                            <td style="border: 0px"> Luces frontales altas / Direccionales / Parqueo. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="indicadores_luces_tablero" id="indicadores_luces_tablero" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Indicador de velocidad. </td>
                            <td style="border: 0px"> La aguja indica la velocidad al transitar (Rodando). </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="indicador_velocidad" id="indicador_velocidad" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Indicador de combustible. </td>
                            <td style="border: 0px"> La aguja muestra el nivel de combustible. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="indicador_combustible" id="indicador_combustible" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Indicador de aceite motor. </td>
                            <td style="border: 0px"> Enciende al iniciar el motor. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="indicador_aceite_motor" id="indicador_aceite_motor" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Pito. </td>
                            <td style="border: 0px"> Funcionando / Se oye a unas distancia de 50 m. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="pito" id="pito" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Freno de emergencia. </td>
                            <td style="border: 0px"> Prueba antes del arranque. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="freno_emergencia" id="freno_emergencia" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Pito reversa. </td>
                            <td style="border: 0px"> Funciona automáticamente con la reversa. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="pito_reserva" id="pito_reserva" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Botiquin. </td>
                            <td style="border: 0px"> Sin elementos vencidos. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="botiquin" id="botiquin" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Equipo de carretera. </td>
                            <td style="border: 0px"> Un (1) gato, Dos (2) tacos, Dos (2) señales en forma de triangulo,  Copa de ruedas o cruceta herramienta, Botiquín, Extintor  y Una (1) linterna de mano con baterías. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="equipo_carretera" id="equipo_carretera" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Kilometraje. </td>
                            <td style="border: 0px"> Kilometraje actual del vehiculo. </td>
                            <td style="border: 0px">
                                <input type="text" name="kilometraje" id="kilometraje" class="form-control" required="required">
                            </td>
                        </tr>

                      </tbody>
                    </table>


                <?php include("Template/bottom-form.php"); ?>
	        </form>
        </div>
    </section>


    <?php include("Template/scripts.php"); ?>
    <script>
        function cargarConductores(id_vehiculo){
          //alert(id_departamento); 
              var parametros = {
                "id_vehiculo" : id_vehiculo
              };
              $.ajax({
                  data:  parametros,
                  url:   '../Controlador/listarConductoresVehiculo.php',
                  type:  'post',
                  beforeSend: function () {
                      //alert('envio');
                      $("#id_conductor").html("<option value='' disabled='disabled' selected='selected'>Cargando datos, por favor espere</option>");
                  },
                  success:  function (response) {
                      //alert(response);
                      $("#id_conductor").html(response);
                  }
              });
        }        
    </script>
</body>
</html>