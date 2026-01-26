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
	        <form action="../Controlador/registrarPreoperacionalesCompartimientoMotor.php" method="POST">
	        	<?php include("Template/header-form.php"); ?>


                    <!--id_preoperacional-->
                    <input type="hidden" name="id_preoperacional" id="id_preoperacional" value="<?php echo $id_preoperacional ?>">
                        
                    <table class="table">
                      <thead>
                        <tr class="text-center">
                          <th  style="border: 0" > COMPARTIMIENTO DEL MOTOR </th>
                          <th  style="border: 0" >REQUISITO</th>
                          <th  style="border: 0" ></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                            <td style="border: 0px"> Tapas. </td>
                            <td style="border: 0px"> Completas y Bien ajustadas. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="tapas" id="tapas" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Niveles de aceite de motor. </td>
                            <td style="border: 0px"> Niveles de acuerdo al indicador en la varilla. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="niveles_aceite_motor" id="niveles_aceite_motor" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Radiador / Ventilador / Correas. </td>
                            <td style="border: 0px"> Sin fugas / Nivel de agua correcto / Hélices completas / Correas tensionadas / Mangueras sin fugas. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="radiador_ventilador_correas" id="radiador_ventilador_correas" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Mangueras. </td>
                            <td style="border: 0px"> Conectadas y Sin fugas. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="mangueras" id="mangueras" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Transmision. </td>
                            <td style="border: 0px"> Sin fugas.  </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="transmision" id="transmision" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Filtro de aire. </td>
                            <td style="border: 0px"> Limpios y Sin humedades. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="filtro_aire" id="filtro_aire" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Fugas de motor. </td>
                            <td style="border: 0px"> Sin fugas, Ni humedades. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="fugas_motor" id="fugas_motor" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Bomba de freno / Bomba de clutch. </td>
                            <td style="border: 0px"> Sin fugas. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="bomba_freno_clutch" id="bomba_freno_clutch" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Batería / Bornes / Soporte. </td>
                            <td style="border: 0px"> Asegurada / Limpios / Nivel de agua correcto. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="bateria_bornes_soporte" id="bateria_bornes_soporte" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Dirección / Nivel de aceite hidraulico. </td>
                            <td style="border: 0px"> Sin juego excesivo / Bien alineada / Nivel de aceite ok. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="direccion_nivel_aceite_hidraulico" id="direccion_nivel_aceite_hidraulico" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Deposito de lavaparabrisas. </td>
                            <td style="border: 0px"> Full que garantice la visibilidad. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="deposito_lavabrisas" id="deposito_lavabrisas" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> Conexiones electricas. </td>
                            <td style="border: 0px"> Revisar cables y Conexiones electricas. </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="conexiones_electricas" id="conexiones_electricas" value="C">
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