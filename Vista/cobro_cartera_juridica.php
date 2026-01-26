<?php 
include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Cartera.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/General.php");

$cartera = new Cartera();
$vehiculo = new Vehiculo();
$listado = $cartera->listarCobroCarteraJuridica();

$modulo = 132;
$permisos = permisos($modulo,$_SESSION['id_usuario']);
//print_r($permisos);
if(count($permisos) < 1){
  echo ("<script LANGUAGE='JavaScript'>
    window.location.href='https://www.sistemakv.com/';
    </script>");
}

$listado_tipos_contacto = $cartera->listarTipoContactoCobro();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Cobro Cartera Juridica</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <?php include("Template/styles.php") ?>
  <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
  
</head>
<body>
    
    <?php include("Template/header.php"); ?>
    <?php include("Template/newMenu.php"); ?>
    
    <section class="home_content">  
    
        <div class="notice notice-sistemakv">
            <strong><i class="fa fa-dollar mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">COBRO CARTERA JURIDICA</b></strong>
        </div>

        <div class="notice notice-sistemakv">
            <?php if($permisos[0]['consulta'] == 1){ ?>
                <a id="buttonsKV" href="consultar_acuerdos.php" class="btn ml-1 mr-1">Calendario Acuerdos Pago <i class="fa fa-calendar ml-1"></i></a>
            <?php } ?>
            <?php if($permisos[0]['agregacion'] == 1){ ?>
                <a id="buttonsKV" href="registrar_gestion.php" class="btn ml-1 mr-1">Gestion Cobro <i class="fa fa-plus-circle ml-1"></i></a>
            <?php } ?>
            <?php if($permisos[0]['consulta'] == 1){ ?>
                <a id="buttonsKV" href="descargarCarteraActual.php" class="btn ml-1 mr-1">Descargar Cartera<i class="fa fa-clipboard ml-1"></i></a>
            <?php } ?>
         </div>

        <div class="mt-2 mb-4 table-responsive p-4" style="background-color: #fff; border-radius: 5px;">
    	<table  id="dataT" class="table table-hover table-sm display" style="width:100%">
    		<thead>
    			<tr class="text-center">
    				<th>NUM MOVIL</th>
    				<th>PLACA</th>
    				<th>FLOTA PROPIA</th>
    				<th>ESTADO</th>
    				<th>1 - 30</th>
    				<th>31 - 60</th>
    				<th>61 - 90</th>
    				<th>MAS DE 90</th>
    				<th>VALOR TOTAL</th>
    				<th>OPCIONES</th>
    			</tr>
    		</thead>
    		<tbody>
                <?php foreach ($listado as $lpc){ ?>
                    <tr class="text-center">
                        <td><?php echo $lpc['num_movil']; ?></td>
        				<td><?php echo $lpc['placa'] ?></td>
        				<?php $det_vehiculo = $vehiculo->listarPorId($lpc['id_vehiculo']);?>
        				<td><?php if($det_vehiculo[0]['flota_propia'] == 'S') { echo 'SI'; } else { echo 'NO'; } ?></td>
        				<td>
        				<?php
        				if($det_vehiculo[0]['estado'] == 0){
                            echo "Inactivo";
                          } else if($det_vehiculo[0]['estado'] == 1){
                            echo "Activo";
                          } else if($det_vehiculo[0]['estado'] == 2){
                            echo "Desvinculado";
                          } else if($det_vehiculo[0]['estado'] == 3){
                            echo "Retirado";
                          }
        				?>
        				</td>
        				<td><?php echo number_format($lpc['saldo_30_dias']); ?></td>
        				<td><?php echo number_format($lpc['saldo_60_dias']); ?></td>
        				<td><?php echo number_format($lpc['saldo_90_dias']); ?></td>
        				<td><?php echo number_format($lpc['saldo_mayor_90_dias']); ?></td>
        				<td><?php echo number_format($lpc['total']); ?></td>
        				<td>
        				    <?php if($permisos[0]['agregacion'] == 1){ ?>
                                <a href="javascript:void(0)" title="Agregar Comprobante Pago" class="btn btn-outline-info" style="margin: 0px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#pagos" onclick="modalPagos(<?php echo $lpc['id_vehiculo'];?>)">
                                    <span class="fa fa-upload"></span>
                                </a>
                                <a href="javascript:void(0)" title="Agregar Gestion" class="btn btn-outline-danger" style="margin: 0px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#gestion" onclick="modalGestion(<?php echo $lpc['id_vehiculo'];?>)">
                                    <span class="fa fa-phone"></span>
                                </a>
                            <?php } ?>
        				    
        				    <?php if($permisos[0]['edicion'] == 1){ ?>
                                <a href="javascript:void(0)" title="Acuerdos de Pago" class="btn btn-outline-success" style="margin: 0px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#acuerdos" onclick="modalAcuerdos(<?php echo $lpc['id_vehiculo'];?>)">
                                    <span class="fa fa-dollar"></span>
                                </a>
                            <?php } ?>
        				    
        				    <?php if($permisos[0]['consulta'] == 1){ ?>
                                <a href="javascript:void(0)" title="Ver Info Vehiculo" class="btn btn-outline-warning" style="margin: 0px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#info" onclick="modalInfo(<?php echo $lpc['id_vehiculo'];?>)">
                                    <span class="fa fa-search"></span>
                                </a>
                            <?php } ?>
        				</td>
                    </tr>
                <?php } ?>
    		</tbody>
    	</table>
    </div>
    </section>
    
    <!-- INFORMACION -->
        <div class="modal fade" id="info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">                                  
            <div class="modal-dialog modal-xl" role="document">                                    
                <div class="modal-content f-flex justify-content-center">   
                    <div class="modal-header">                                        
                      <h5 class="modal-title" id="exampleModalLabel">INFORMACION DEL VEHICULO</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>                                      
                    </div>                                      
                    <div class="modal-body">                                         
                        <section id="contenido_modal_info">                                                                                      
                        </section>                                      
                    </div>                                      
                    <div class="modal-footer">                                        
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>    
                    </div>                                    
                </div>                                  
            </div>                                
        </div>
    
    <!-- ACUERDOS -->
        <div class="modal fade" id="acuerdos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">                                  
            <div class="modal-dialog modal-xl" role="document">                                    
                <div class="modal-content f-flex justify-content-center">   
                    <div class="modal-header">                                        
                      <h5 class="modal-title" id="exampleModalLabel">ACUERDOS DE PAGO</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>                                      
                    </div>                                      
                    <div class="modal-body">                                         
                        <section id="contenido_modal_acuerdos">                                                                                      
                        </section>                                      
                    </div>                                      
                    <div class="modal-footer">
                        <input type="hidden" id="id_vehiculo_nuevo_acuerdo" value=""/>
                        <a href="javascript:void(0)" title="Nuevo Acuerdo Pago" data-dismiss="modal" data-toggle="modal" data-target="#nuevo_acuerdo" onclick="modalNuevoAcuerdo(this.value)">
                            <button type="button" class="btn btn-outline-info" >Nuevo Acuerdo</button>
                        </a>
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>    
                    </div>                                    
                </div>                                  
            </div>                                
        </div>
        
    <!-- PAGOS -->
        <div class="modal fade" id="pagos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">                                  
            <div class="modal-dialog modal-xl" role="document">                                    
                <div class="modal-content f-flex justify-content-center">   
                    <div class="modal-header">                                        
                      <h5 class="modal-title" id="exampleModalLabel">COMPROBANTES DE PAGO</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>                                      
                    </div>                                      
                    <div class="modal-body">                                         
                        <section id="contenido_modal_pagos">                                                                                      
                        </section>                                      
                    </div>                                      
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>    
                    </div>                                    
                </div>                                  
            </div>                                
        </div>
    
    <!-- GESTION -->
        <div class="modal fade" id="gestion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">                                  
            <div class="modal-dialog modal-xl" role="document">                                    
                <div class="modal-content f-flex justify-content-center">   
                    <div class="modal-header">                                        
                      <h5 class="modal-title" id="exampleModalLabel">GESTION DE COBRO</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>                                      
                    </div>                                      
                    <div class="modal-body">                                         
                        <section id="contenido_modal_gestion">
                        </section> 
                        <section class="input">
		     	            <hr style="width:100%"/>
		     	        </section>
                        <section>
                            <form action="../Controlador/guardarGestionCobro.php" method="post">
                                <div class="row mt-3">
    		                    	<section class="label">
    				     	            <label><b>Tipo Contacto</b></label>
    				     	        </section>
    				     	        <section class="input">
    						     	    <select name="tipo_contacto" id="tipo_contacto" class="form-control" required="required">
    						     	        <option value="">Seleccione Opción</option>
    						     	        <?php foreach($listado_tipos_contacto as $lcon){ ?>
    						     	        <option value="<?php echo $lcon['id'];?>"><?php echo $lcon['detalle'];?></option>
    						     	        <?php } ?>
    						     	    </select>
    						     	    <input type="hidden" id="id_veh_gestion" name="id_veh_gestion"/>
    								</section>
    							</div>
                                <div class="row mt-3">
    		                    	<section class="label">
    				     	            <label><b>Detalle</b></label>
    				     	        </section>
    		                    	<section class="input">
    						     	    <textarea name="detalle_contacto" id="detalle_contacto" class="form-control" required="required"></textarea>
    								</section>
    							</div>
                                <div class="row mt-3" style="text-align:center">
                                    <button type="submit" class="btn btn-outline-success" style="margin: 0 auto">Guardar Gestión</button>  
                                </div>
                            </form>
                        </section>            
                    </div>                                      
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>    
                    </div>                                    
                </div>                                  
            </div>                                
        </div>
    
    <!-- NUEVO ACUERDO -->
        <div class="modal fade" id="nuevo_acuerdo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">                                  
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">                                    
                <div class="modal-content f-flex justify-content-center">   
                    <div class="modal-header">                                        
                      <h5 class="modal-title" id="exampleModalLabel">NUEVO ACUERDO DE PAGO</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>                                      
                    </div>   
                    <form action="../Controlador/guardarNuevoAcuerdoPago.php" method="post">
                    <div class="modal-body">                                         
                        <section id="contenido_modal_nuevo_acuerdo">   
                            
                            <div class="row mt-3">
		                    	<section class="label">
				     	            <label><b>Fecha Pago</b></label>
				     	        </section>
		                    	<section class="input">
						     	    <input type="date" name="fecha_pago" id="fecha_pago" class="form-control" value="" required="required">
								</section>
							</div>
							
							<div class="row mt-3">
		                    	<section class="label">
				     	            <label><b>Valor</b></label>
				     	        </section>
		                    	<section class="input">
						     	    <input type="number" name="valor" id="valor" class="form-control" value="" required="required">
								</section>
							</div>
                            
                        </section>                                      
                    </div>                                      
                    <div class="modal-footer">
                        <input type="hidden" name="id_vehiculo_acuerdo" id="id_vehiculo_acuerdo" />
                        <button type="submit" class="btn btn-outline-success">Guardar</button>
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>    
                    </div>
                    </form>
                </div>                                  
            </div>                                
        </div>
        
    <!-- CARGAR ACUERDO FIRMADO-->
        <div class="modal fade" id="doc_firmado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">                                  
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">                                    
                <div class="modal-content f-flex justify-content-center">   
                    <div class="modal-header">                                        
                      <h5 class="modal-title" id="exampleModalLabel">CARGAR ACUERDO FIRMADO</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>                                      
                    </div>   
                    <form action="../Controlador/guardarAcuerdoFirmado.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">                                         
                        <section id="contenido_modal_acuerdo_firmado" >   
                            
                            <div class="row mt-3">
		                    	<section class="label">
				     	            <label><b>Archivo Acuerdo En Blanco</b></label>
				     	        </section>
		                    	<section class="input">
						     	    <a href="../Documentos/Cartera/acuerdo_en_blanco.docx" target="_blank"><button type="button" class="btn btn-outline-info"><span class="fa fa-download"></span> DESCARGAR</button></a>
								</section>
							</div>
							
							<div class="row mt-3">
		                    	<section class="label">
				     	            <label><b>Archivo Descuento En Blanco</b></label>
				     	        </section>
		                    	<section class="input">
						     	    <a href="../Documentos/Cartera/autorizacion_en_blanco.docx" target="_blank"><button type="button" class="btn btn-outline-info"><span class="fa fa-download"></span> DESCARGAR</button></a>
								</section>
							</div>
                            
                            <div class="row mt-3">
		                    	<section class="label">
				     	            <label><b>Archivo Firmado</b></label>
				     	        </section>
		                    	<section class="input">
						     	    <input type="file" name="doc_firmado_file" id="doc_firmado_file" class="form-control" value="" required="required">
								</section>
							</div>
                            
                        </section>                                      
                    </div>                                      
                    <div class="modal-footer">
                        <input type="hidden" name="id_acuerdo_doc" id="id_acuerdo_doc" />
                        <button type="submit" class="btn btn-outline-success">Guardar</button>
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>    
                    </div>
                    </form>
                </div>                                  
            </div>                                
        </div>
        
        <!-- CARGAR COMPROBANTE PAGO-->
        <div class="modal fade" id="doc_comprobante" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">                                  
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">                                    
                <div class="modal-content f-flex justify-content-center">   
                    <div class="modal-header">                                        
                      <h5 class="modal-title" id="exampleModalLabel">CARGAR COMPROBANTE PAGO</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>                                      
                    </div>   
                    <form action="../Controlador/guardarComprobantePagoCartera.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">                                         
                        <section id="contenido_modal_cargar_comprobante" >   
                            
                            <div class="row mt-3">
		                    	<section class="label">
				     	            <label><b>Comprobante Pago</b></label>
				     	        </section>
		                    	<section class="input">
						     	    <input type="file" name="doc_comprobante_file" id="doc_comprobante_file" class="form-control" value="" required="required">
								</section>
							</div>
							
							<div class="row mt-3">
		                    	<section class="label">
				     	            <label><b>Valor Pagado</b></label>
				     	        </section>
		                    	<section class="input">
						     	    <input type="text" name="valor_comprobante" id="valor_comprobante" class="form-control" value="" required="required">
								</section>
							</div>
							
							<div class="row mt-3">
		                    	<section class="label">
				     	            <label><b>Fecha Pago</b></label>
				     	        </section>
		                    	<section class="input">
						     	    <input type="date" name="fecha_comprobante" id="fecha_comprobante" class="form-control" value="" required="required">
								</section>
							</div>
                            
                        </section>                                      
                    </div>                                      
                    <div class="modal-footer">
                        <input type="hidden" name="id_acuerdo_comprobante" id="id_acuerdo_comprobante" />
                        <button type="submit" class="btn btn-outline-success">Guardar</button>
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>    
                    </div>
                    </form>
                </div>                                  
            </div>                                
        </div>
    
    <?php include("Template/scripts.php"); ?>
    
    <script type="text/javascript">

        function modalInfo(id_vehiculo){
            var parametros = {
                "id_vehiculo" : id_vehiculo
            };
            $.ajax({
                    data:  parametros, //datos que se envian a traves de ajax
                    url:   '../Controlador/listarInfoVehiculo.php', //archivo que recibe la peticion
                    type:  'post', //método de envio
                    beforeSend: function () {
                            $("#contenido_modal_info").html("Procesando, espere por favor...");
                    },
                    success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                            //alert(response);
                            $("#contenido_modal_info").html(response);
                    }
            });
        }
        
        function modalAcuerdos(id_vehiculo){
            document.getElementById('id_vehiculo_nuevo_acuerdo').value = id_vehiculo;
            var parametros = {
                "id_vehiculo" : id_vehiculo
            };
            $.ajax({
                    data:  parametros, //datos que se envian a traves de ajax
                    url:   '../Controlador/listarAcuerdosVehiculo.php', //archivo que recibe la peticion
                    type:  'post', //método de envio
                    beforeSend: function () {
                            $("#contenido_modal_acuerdos").html("Procesando, espere por favor...");
                    },
                    success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                            //alert(response);
                            $("#contenido_modal_acuerdos").html(response);
                    }
            });
        }
        
        function modalPagos(id_vehiculo){
            var parametros = {
                "id_vehiculo" : id_vehiculo
            };
            $.ajax({
                    data:  parametros, //datos que se envian a traves de ajax
                    url:   '../Controlador/listarPagosVehiculo.php', //archivo que recibe la peticion
                    type:  'post', //método de envio
                    beforeSend: function () {
                            $("#contenido_modal_pagos").html("Procesando, espere por favor...");
                    },
                    success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                            //alert(response);
                            $("#contenido_modal_pagos").html(response);
                    }
            });
        }
        
        function modalGestion(id_vehiculo){
            //alert(id_vehiculo);
            document.getElementById('id_veh_gestion').value = id_vehiculo;
            var parametros = {
                "id_vehiculo" : id_vehiculo
            };
            $.ajax({
                    data:  parametros, //datos que se envian a traves de ajax
                    url:   '../Controlador/listarGestionVehiculo.php', //archivo que recibe la peticion
                    type:  'post', //método de envio
                    beforeSend: function () {
                            $("#contenido_modal_gestion").html("Procesando, espere por favor...");
                    },
                    success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                            //alert(response);
                            $("#contenido_modal_gestion").html(response);
                    }
            });
        }
        
        function modalNuevoAcuerdo(){
            var id_vehiculo_acuerdo = document.getElementById('id_vehiculo_nuevo_acuerdo').value; 
            document.getElementById('id_vehiculo_acuerdo').value = id_vehiculo_acuerdo;
        }
        
        function acuerdoPagado(id_acuerdo){
            let respuesta = confirm("¿Esta seguro de cambiar el estado a Pagado?");
            if(respuesta == true){
            var parametros = {
                "id_acuerdo" : id_acuerdo,
                "estado" : 2,
            };
            $.ajax({
                    data:  parametros, //datos que se envian a traves de ajax
                    url:   '../Controlador/cambiarEstadoAcuerdoPago.php', //archivo que recibe la peticion
                    type:  'post', //método de envio
                    beforeSend: function () {
                    },
                    success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                        //alert(response);
                        if(response != '0'){
                            alert('Cambio de Estado Exitoso');
                            window.location.reload();
                        }
                    }
            });
            }
        }
        
        function acuerdoCancelado(id_acuerdo){
            let respuesta = confirm("¿Esta seguro de cambiar el estado a Cancelado?");
            if(respuesta == true){
            var parametros = {
                "id_acuerdo" : id_acuerdo,
                "estado" : 4,
            };
            $.ajax({
                    data:  parametros, //datos que se envian a traves de ajax
                    url:   '../Controlador/cambiarEstadoAcuerdoPago.php', //archivo que recibe la peticion
                    type:  'post', //método de envio
                    beforeSend: function () {
                    },
                    success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                        //alert(response);
                        if(response != '0'){
                            alert('Cambio de Estado Exitoso');
                            window.location.reload();
                        }
                    }
            });
            }
        }
        
        function modalCargarDoc(id_acuerdo){
            document.getElementById('id_acuerdo_doc').value = id_acuerdo;
        }
        
        function modalCargarComprobante(id_acuerdo){
            document.getElementById('id_acuerdo_comprobante').value = id_acuerdo;
        }
    </script>
        
</body>
</html>