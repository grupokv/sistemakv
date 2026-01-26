<?php
include ("../Controlador/Sesion/autenticar.php");

$id = $_GET['id'];

/* VARIABLES MENU*/
$titulo = 'Protocolo Desinfeccion';
$redireccion = 'inicio.php';
$icono = 'fa fa-car';

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Protocolo Desinfeccion</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">

    <style type="text/css" media="screen">
      
    </style>
</head>
<body>
    <section class="form-usuarios">
        <div class="formulario mb-5">
	        <form action="../Controlador/registrarDesinfeccionServicioConductor.php" method="POST">
	        	<?php include("Template/header-form.php"); ?>


                    <!--id_preoperacional-->
                    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                        
                    <table class="table">                      
					<thead>                        
					<tr class="text-center">                          
					<th  style="border: 0"> PROCESO DESINFECCIÓN</th>                          
					<th  style="border: 0"></th>                        
					</tr>                      
					</thead>                      
					<tbody>                        
					<tr>                            
						<td style="border: 0px"> ¿Realizó lavado de manos? </td>                            
						<td style="border: 0px">
							<label class="switch">                                    
							<input type="checkbox" name="lavado_manos" id="lavado_manos" value="C">                                    
							<span class="slider"></span>                                
							</label>                                
						</td>                        
					</tr>                        
					<tr>                            
						<td style="border: 0px"> ¿Se colocó traje de Bioseguridad y Tapabocas?</td>                            
						<td style="border: 0px">
							<label class="switch">                                    
							<input type="checkbox" name="tapabocas_guantes" id="tapabocas_guantes" value="C">                                    
							<span class="slider"></span>                                
							</label>                                
						</td>                        
					</tr>			
					<tr>                            
						<td style="border: 0px"> ¿Alistó elementos de aseo?</td>                            
						<td style="border: 0px">                                
							<label class="switch">                                    
							<input type="checkbox" name="desinfectante" id="desinfectante" value="C">                                    
							<span class="slider"></span>                                
							</label>                                
						</td>                        
					</tr>                        
					<tr>                            
						<td style="border: 0px"> ¿Alistó Limpiador / Desinfectante? </td>                            
						<td style="border: 0px">                                
							<label class="switch">                                    
							<input type="checkbox" name="bayetillas_toallas" id="bayetillas_toallas" value="C">                                    
							<span class="slider"></span>                                
							</label>                                
						</td>                        
					</tr>                        
					<tr>                            
						<td style="border: 0px"> ¿Barrio la zona de pasajeros? </td>                            
						<td style="border: 0px">                                
							<label class="switch">                                    
							<input type="checkbox" name="escoba_trapero" id="escoba_trapero" value="C">                                    
							<span class="slider"></span>                                
							</label>                                
						</td>                        
					</tr>                        
					<tr>                            
						<td style="border: 0px"> ¿Limpio las sillas? </td>                            
							<td style="border: 0px">                                
							<label class="switch">                                    
							<input type="checkbox" name="alisto_toalla" id="alisto_toalla" value="C">                                    
							<span class="slider"></span>                                
							</label>                                
						</td>                        
					</tr>                        
					<tr>                            
						<td style="border: 0px"> ¿Desinfectó zona de pasajeros? </td>
						<td style="border: 0px">                               
							<label class="switch">                                    
								<input type="checkbox" name="balde" id="balde" value="C">     
								<span class="slider"></span>                                
							</label>                                
						</td>                        
					</tr>                        
					<tr>                            	
						<td style="border: 0px"> ¿Barrio zona del conductor? </td>             
						<td style="border: 0px">                                
							<label class="switch">                                    
								<input type="checkbox" name="bolsa" id="bolsa" value="C">
								<span class="slider"></span>                                
							</label>                                
						</td>                        
					</tr>                        
					<tr>                            
						<td style="border: 0px"> ¿limpio zona del conductor? </td>             
						<td style="border: 0px">                                
							<label class="switch">                                    
								<input type="checkbox" name="productos" id="productos" value="C">
								<span class="slider"></span>                                
							</label>                                
						</td>                        
					</tr>                        

					<tr>                            
						<td style="border: 0px"> ¿Desinfectó zona del conductor? </td>
						<td style="border: 0px">                                
							<label class="switch">                                    
								<input type="checkbox" name="tapetes" id="tapetes" value="C">
								<span class="slider"></span>                                
							</label>                                
						</td>                        
					</tr>                        
					<tr>                            
						<td style="border: 0px"> ¿Limpio y Desinfecto protector del volante? </td>    
						<td style="border: 0px">                                
							<label class="switch">                                   
							 	<input type="checkbox" name="volante" id="volante" value="C">
							 	<span class="slider"></span>                                
							</label>                                
						</td>                        
					</tr>                        
					<tr>                            
						<td style="border: 0px"> ¿Limpio y Desinfecto la zona de pasajeros? </td>
						<td style="border: 0px">                                
							<label class="switch">                                    
								<input type="checkbox" name="zona_pasajeros" id="zona_pasajeros" value="C">                                    
								<span class="slider"></span>                                
							</label>                                
						</td>                        
					</tr>			
					<tr>                            
						<td style="border: 0px"> ¿Limpió y Desinfecto la zona del conductor? </td>
						<td style="border: 0px">                                
							<label class="switch">                                    
								<input type="checkbox" name="zona_conductor" id="zona_conductor" value="C">                                    
								<span class="slider"></span>                                
							</label>                                
						</td>                        
					</tr>			
					<tr>                            
						<td style="border: 0px"> ¿Realizó Aspersión? </td>
						<td style="border: 0px">                                
							<label class="switch">                                    
								<input type="checkbox" name="piso_vehiculo" id="piso_vehiculo" value="C">                                    
								<span class="slider"></span>                                
							</label>                                
						</td>                        
					</tr>		
					<tr>                            
						<td style="border: 0px"> ¿Guardó los residuos en bolsa? </td>
						<td style="border: 0px">                                
							<label class="switch">                                    
								<input type="checkbox" name="aspersion" id="aspersion" value="C">
								<span class="slider"></span>                                
							</label>                                
						</td>                        
					</tr>			
					<tr>                            
						<td style="border: 0px"> ¿Reviso gel Antibacterial o Alcohol? </td>
						<td style="border: 0px">                                
							<label class="switch">                                    
								<input type="checkbox" name="disposicion" id="disposicion" value="C">
								<span class="slider"></span>                                
							</label>                                
						</td>                        
					</tr>									
					<tr>                            				
						<td style="border: 0px"> ¿Organizó la bodega, Desinfectó, Organizo los productos? </td>                            				
						<td style="border: 0px">                                					
							<label class="switch">                                    
								<input type="checkbox" name="bodega" id="bodega" value="C">
								<span class="slider"></span>                                
							</label>                                
						</td>                        
					</tr>			
					<tr>                            
						<td style="border: 0px"> ¿Se lavo las manos nuevamente y se hidrato? </td>
						<td style="border: 0px">                                
							<label class="switch">                                    
								<input type="checkbox" name="hidratacion" id="hidratacion" value="C">
								<span class="slider"></span>                                
							</label>                                
						</td>                        
					</tr> 

				</tbody>                    
			</table>

				<div class="row justify-content-center botones-form mt-2 mb-5">	
					<div class="boton mt-2">		
						<button type="submit" class="btn btn-primary btn-block" id="guardar">Guardar</button>	
					</div>
				</div>

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