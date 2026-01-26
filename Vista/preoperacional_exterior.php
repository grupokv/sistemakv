<?php 
include ("../Controlador/Sesion/autenticar.php");

/* VARIABLES MENU*/
$titulo = 'Pre Operacional';
$redireccion = 'inicio.php';
$icono = 'fa fa-car';

$id = $_GET['id'];

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
	        <form action="../Controlador/registrarPreoperacionalesExterior.php" method="POST">
	        	<?php include("Template/header-form.php"); ?>


                    <!--id_preoperacional-->
                    <input type="hidden" name="id_preoperacional" id="id_preoperacional" value="<?php echo $id ?>">
                        
                    <table class="table">
                      <thead>
                        <tr class="text-center">
                          <th  style="border: 0" >EXTERIOR</th>
                          <th  style="border: 0" >REQUISITO</th>
                          <th  style="border: 0" ></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                            <td style="border: 0px"> Puertas. </td>
                            <td style="border: 0px"> Que abran por dentro y por fuera. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="puertas" id="puertas" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Espejos Retrovisores </td>
                            <td style="border: 0px"> Sin roturas / Bien Ajustadas. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="espejos_retrovisores" id="espejos_retrovisores" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Ventanas </td>
                            <td style="border: 0px"> Vidrios sin roturas / Sin distorsiones o manchas. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="ventanas" id="ventanas" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Vidrio fontral (Panoramico) </td>
                            <td style="border: 0px"> Sin fracturas o chispas. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="vidrio_frontal" id="vidrio_frontal" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Llantas y Rines </td>
                            <td style="border: 0px"> Profundidad de labrado no menor a 2 mm / Presión correcta / Sin cortaduras ni deformaciones. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="llantas_rines" id="llantas_rines" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Llanta de Repuesto</td>
                            <td style="border: 0px"> Profundidad de labrado no menor a 2 mm / Presión. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="llanta_repuesto" id="llanta_repuesto" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Luces delanteras </td>
                            <td style="border: 0px"> Unidades sin roturas / Funcionando. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="luces_delanteras" id="luces_delanteras" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Luces de freno </td>
                            <td style="border: 0px"> Encienden al pisar el pedal / Sin roturas. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="luces_freno" id="luces_freno" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Luces de reserva </td>
                            <td style="border: 0px"> Enciende automáticamente al activar la reserva. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="luces_reserva" id="luces_reserva" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Luces de parqueo / Direccionales </td>
                            <td style="border: 0px"> Intermitentes / Encienden al accionar el interruptor. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="luces_parqueo_direccionales" id="luces_parqueo_direccionales" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Sistema de suspensión </td>
                            <td style="border: 0px"> Amortiguadores sin fugas. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="sistema_suspension" id="sistema_suspension" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Sistema de frenos </td>
                            <td style="border: 0px"> Que no presente fugas de liquido de frenos. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="sistema_frenos" id="sistema_frenos" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Sistema de Dirección </td>
                            <td style="border: 0px"> Que no presente fugas de liquido de aceite hidraulico, juego excesivo en el volante ni ruidos extraños. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="sistema_direccion" id="sistema_direccion" value="C">
                                    <span class="slider"></span>
                                </label>    
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