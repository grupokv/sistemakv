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
	        <form action="../Controlador/registrarPreoperacionalesDesinfeccion.php" method="POST">
	        	<?php include("Template/header-form.php"); ?>


                    <!--id_preoperacional-->
                    <input type="hidden" name="id_preoperacional" id="id_preoperacional" value="<?php echo $id_preoperacional ?>">
                        
                    <table class="table">
                      <thead>
                        <tr class="text-center">
                          <th  style="border: 0"> PROCESO DESINFECCION</th>
                          <th  style="border: 0"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                            <td style="border: 0px"> REALIZO LAVADO DE MANOS? </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="lavado_manos" id="lavado_manos" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> SE COLOCO TRAJE DE BIOSEGURIDAD Y TAPABOCAS?</td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="tapabocas_guantes" id="tapabocas_guantes" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
			<tr>
                            <td style="border: 0px"> ALISTO ELEMENTOS DE ASEO?</td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="desinfectante" id="desinfectante" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> ALISTO LIMPIADOR / DESINFECTANTE? </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="bayetillas_toallas" id="bayetillas_toallas" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> BARRIO ZONA PASAJEROS? </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="escoba_trapero" id="escoba_trapero" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> LIMPIO SILLAS? </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="alisto_toalla" id="alisto_toalla" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> DESINFECTO ZONA DE PASAJEROS? </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="balde" id="balde" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> BARRIO ZONA CONDUCTOR?</td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="bolsa" id="bolsa" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> LIMPIO ZONA CONDUCTOR? </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="productos" id="productos" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> DESINFECTO ZONA CONDUCTOR? </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="tapetes" id="tapetes" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> LIMPIO Y DESINFECTO PROTECTOR DE VOLANTE? </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="volante" id="volante" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0px"> LIMPIO Y DESINFECTO LA ZONA DE PASAJEROS? </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="zona_pasajeros" id="zona_pasajeros" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
			<tr>
                            <td style="border: 0px"> LIMPIO Y DESINFECTO LA ZONA DEL CONDUCTOR? </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="zona_conductor" id="zona_conductor" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
			<tr>
                            <td style="border: 0px"> REALIZO ASPERSION? </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="piso_vehiculo" id="piso_vehiculo" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>
			<tr>                            <td style="border: 0px"> GUARDO LOS RESIDUOS EN BOLSA? </td>                            <td style="border: 0px">                                <label class="switch">                                    <input type="checkbox" name="aspersion" id="aspersion" value="C">                                    <span class="slider"></span>                                </label>                                </td>                        </tr>
			<tr>
                            <td style="border: 0px"> REVISO GEL ANTIBACTERIAL O ALCOHOL? </td>
                            <td style="border: 0px">
                                <label class="switch">
                                    <input type="checkbox" name="disposicion" id="disposicion" value="C">
                                    <span class="slider"></span>
                                </label>    
                            </td>
                        </tr>						<tr>                            <td style="border: 0px"> ORGANIZO LA BODEGA, DESINFECTO Y ORGANIZO PRODUCTOS? </td>                            <td style="border: 0px">                                <label class="switch">                                    <input type="checkbox" name="bodega" id="bodega" value="C">                                    <span class="slider"></span>                                </label>                                </td>                        </tr>			<tr>                            <td style="border: 0px"> SE LAVO LAS MANOS NUEVAMENTE Y SE HIDRATO? </td>                            <td style="border: 0px">                                <label class="switch">                                    <input type="checkbox" name="hidratacion" id="hidratacion" value="C">                                    <span class="slider"></span>                                </label>                                </td>                        </tr>
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