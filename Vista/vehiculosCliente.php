<?php
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Contrato.php");
require_once("../Modelo/TipoVehiculo.php");
require_once("../Modelo/Vehiculo-Contrato.php");
require_once("../Modelo/Usuario.php");
$vehiculo = new Vehiculo();
$veh_con = new Vehiculo_Contrato();
$contrato = new Contrato();


$fecha = date('Y-m-d');
$contrato_activo = $contrato->listarPorClienteActivo($_SESSION['id_cliente'],$fecha);

$rutas = $vehiculo->listarRutasPorCliente($_SESSION['id_cliente']);
$num_contrato = $contrato_activo[0]['id_contrato'];
$tipov = new TipoVehiculo();
$listarV = $veh_con->listarPorContrato($num_contrato);
$usuario = new Usuario();?>
<!DOCTYPE html>
<html>
<head><meta charset="gb18030">  
  
<title>SistemaKV | Vehiculos</title>  
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">  
<?php include("Template/styles.php") ?>  
<style type="text/css">        
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
.img-frontal{      
width: 100px;    
}    
.img-trasera{      
width: 100px;    
}    
.img-izq{      
width: 100px;    
}    
.img-der{      width: 100px;    }    @media (max-width: 760px){              .fa-plus{           display: none;        }        .titulo_principal{          text-align: center;        }        .botones_principal{          display: flex;          justify-content: center;        }        .img-frontal{          width: 100%;        }        .img-trasera{          width: 100%;        }        .img-izq{          width: 100%;        }        .img-der{          width: 100%;        }    }  </style>  <!--fin  styles --></head>
<body>    
<!--MENU-->       
<?php include("Template/menu.php"); ?>    
<!--FIN MENU-->    
<!--**************************--->        
<!-- CONTENIDO -->    
<div aria-label="breadcrumb" class="mt-1">          
<ol class="breadcrumb">            
<li class="breadcrumb-item " aria-current="page"><a href="inicioCliente.php">Inicio</a></li>            
<li class="breadcrumb-item active" aria-current="page">Vehiculos</li>         
</ol>    
</div>        
<hr style="background-color:#5e99b1; ">    
<div class="row barra-principal">      	
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 titulo_principal">      		  
<h2 class="mt-2" style="color: #fff; line-height: 25px;">
<span class="fa fa-car icono-principal ml-2" style="border: 2px solid #fff; border-radius: 50%;  font-size:0.8em; padding: 9px;"></span> Vehiculos
</h2>      	
</div>      	
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 botones_principal"> 
<a href="ReporteExportarExcelVehiculosContrato.php?id_contrato=<?php echo $num_contrato;?>" class="btn  mr-4" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;">Exportar Reporte <span class="fa fa-file"></span></a> 
<a href="javascript:void(0)" data-toggle="modal" data-target="#consultarVehiculos" onclick="consultarVehiculosContrato(<?php echo $num_contrato;?>);" class="btn  mr-4" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;">Consultar Base y Backup <span class="fa fa-search"></span></a>                   
</div>    
</div>    
<hr style="background-color:#5e99b1;">      
<div class="mt-2 p-4 table-responsive">    	  

<table  id="dataT" class="table table-hover table-sm display" style="width:100%">      		
<thead>      			
<tr>              
<th>ID</th>
<?php if(count($rutas) > 0){ ?>
<th># RUTA</th>
<?php } ?>             
<th>PLACA</th>              
<th>MARCA Y LINEA</th>              
<th>MODELO</th>              
<th>TIPO VEHICULO</th>              
<th>CANTIDAD DE PASAJEROS</th>                            
<th>MOVIL</th>          
<th>ESTADO</th>      				
<th>OPCIONES</th>      			
</tr>      		
</thead>    		  
<tbody>            
<?php foreach ($listarV as $lv){ ?>              
<tr>                  
<td><?php echo $lv['id_vehiculo'] ?></td>
<?php if(count($rutas) > 0){ ?>
<td>
<?php
$datos_ruta = $vehiculo->listarRutaPorIdVehiculo($lv['id_vehiculo'],$_SESSION['id_cliente']);
echo $datos_ruta[0]['num_ruta'];
?>
</td>
<?php } ?>                 
<td><?php echo $lv['placa'] ?></td>                  
<td><?php echo $lv['marca'] ?></td>                  
<td><?php echo $lv['modelo'] ?></td>                  
<td><?php $tipo_v = $tipov->listarPorID($lv['id_tipo_vehiculo']); echo $tipo_v[0]['nombre_tipo_vehiculo']; ?></td>                  
<td>
<?php if($lv['cant_pasajeros'] == 1){                            
echo $lv['cant_pasajeros'] . " Pasajero";                      
} else {                            
echo $lv['cant_pasajeros'] . " Pasajeros";                      
}?>
</td>                                    
<td><?php echo $lv['numero_movil'] ?></td>         
<td>                    
<?php
if($lv['estado'] == 1){                        
echo "Activo";                      
} else {                        
echo "Inactivo";                      
}                     
?>                  
</td>                         
<td>                     
<!--Consultar Documentos-->                        
<a href="javascript:void(0)" class="btn btn-outline-warning"  style="margin: 0px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#vehiModal" onclick="modal(<?php echo $lv['id_vehiculo'];?>)"><span class="fa fa-search"></span></a>                                        
<a href="javascript:void(0)" class="btn btn-outline-success"  style="margin: 0px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#condsVehiculos" onclick="modalCond(<?php echo $lv['id_vehiculo'];?>)"><span class="fa fa-users"></span></a>                                        

</td>                                    
</tr>            
<?php } ?>    		  
</tbody>    	  
</table>      

</div>      
<!-- Modal DOCUMENTACION -->        
<div class="modal fade" id="vehiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">          <div class="modal-dialog " role="document">            <div class="modal-content f-flex justify-content-center">              <div class="modal-header">                  <h5 class="modal-title " id="exampleModalLabel">Documentación</h5>                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">                    <span aria-hidden="true">&times;</span>                  </button>              </div>              <div class="modal-body">                  <section id="contenido_modal" name="contenido_modal">                  </section>              </div>              <div class="modal-footer">              <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>                           </div>            </div>          </div>        </div>      <!-- Modal CONDUCTORES-->          <div class="modal fade" id="condsVehiculos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">            <div class="modal-dialog " role="document">              <div class="modal-content f-flex justify-content-center">                <div class="modal-header">                    <h5 class="modal-title " id="exampleModalLabel">CONDUCTORES ANCLADOS</h5>                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">                      <span aria-hidden="true">&times;</span>                    </button>                </div>                <div class="modal-body">                    <section id="contenido_modal_cond" name="contenido_modal_cond">                    </section>                </div>                <div class="modal-footer">                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>                </div>              </div>            </div>          </div>      <!-- Modal CONDUCTORES-->          <div class="modal fade" id="contratosVehiculos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">            <div class="modal-dialog " role="document">              <div class="modal-content f-flex justify-content-center">                <div class="modal-header">                    <h5 class="modal-title" id="exampleModalLabel">CONTRATOS ANCLADOS</h5>                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">                      <span aria-hidden="true">&times;</span>                    </button>                </div>                <div class="modal-body">                    <section id="contenido_modal_contratos" name="contenido_modal_contratos">                    </section>                </div>                <div class="modal-footer">                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>                </div>              </div>            </div>          </div>  <!-- script -->  <?php include("Template/scripts.php"); ?>    <script type="text/javascript">function modal(id_vehiculo){   var parametros = {                "id_vehiculo" : id_vehiculo        };        $.ajax({                data:  parametros,                url:   '../Controlador/listarDocsVehiculo.php',                 type:  'post',                 beforeSend: function () {                        $("#contenido_modal").html("Procesando, espere por favor...");                },                success:  function (response) {                         $("#contenido_modal").html(response);                }        });}  </script>  <div class="modal fade" id="consultarVehiculos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body">

					<div class="alert alert-warning text-center" role="alert">
						<strong>VEHICULOS POR CONTRATO</strong>
					</div>

					<hr>

					<div class="contenido_modal_vehiculos" id="contenido_modal_vehiculos">

					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal CONDUCTORES-->
          <div class="modal fade" id="condsVehiculos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
              <div class="modal-content f-flex justify-content-center">
                <div class="modal-header">
                    <h5 class="modal-title " id="exampleModalLabel">CONDUCTORES ANCLADOS</h5>  
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <section id="contenido_modal_cond" name="contenido_modal_cond">

                    </section>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>
                </div>
              </div>
            </div>
          </div>
	<script>
	function consultarVehiculosContrato(id_contrato){
		var parametros = {
			"id_contrato" : id_contrato
		};
		$.ajax({
                data:  parametros, 
                url:   '../Controlador/consultarVehiculosContratos.php', 
                type:  'POST',
                beforeSend: function () {
                	$("#contenido_modal_vehiculos").html("Procesando, espere por favor...");
                },
                success:  function (response) { 
                        
                        $("#contenido_modal_vehiculos").html(response);
                    }
                });
	}      
                function modalCond(id_vehiculo){
 

   var parametros = {
                "id_vehiculo" : id_vehiculo
        };
        $.ajax({
                data:  parametros, 
                url:   '../Controlador/listarCondsVehiculoCliente.php', 
                type:  'POST', 
                beforeSend: function () {
                        $("#contenido_modal_cond").html("Procesando, espere por favor...");
                },
                success:  function (response) { 
                        //alert(response);
                        $("#contenido_modal_cond").html(response);
                }
        });
            }
            </script>
        </body></html>