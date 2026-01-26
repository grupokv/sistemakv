<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/OrdenServicio.php");
require_once("../Modelo/ProveedorMantenimiento.php");
require_once("../Modelo/TipoServicioMantenimiento.php");
require_once ("../Modelo/Subcategoria_Mantenimiento.php");
require_once ("../Modelo/Categoria_Mantenimiento.php");

$id_orden_servicio = $_GET['id_orden_servicio'];

$subcategoria = new Subcategoria_Mantenimiento();
$categoria = new Categoria_Mantenimiento();

$proveedor = new ProveedorMantenimiento();
$listarP = $proveedor->listar();

$orden = new OrdenServicio();
$listarOrdenId = $orden->listarPorId($id_orden_servicio);

$vehiculo = new Vehiculo();
$listarV = $vehiculo->listarVehiculoFlotaPropia();


$tipo_servicio = new TipoServicioMantenimiento();
$listarTS = $tipo_servicio->listar();

 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar Orden Servicio</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- STYLES -->
    	<?php include("Template/styles.php"); ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css"> 

        <style type="text/css">
        	.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active, a.ui-button:active, .ui-button:active, .ui-button.ui-state-active:hover {
        		background-color: #5e99b1;
        		border: #1b2d3b !important;
        	}

        	input[readonly] {
			    background-color: #fff !important;
			}

        	textarea[readonly] {
			    background-color: #fff !important;
			}

        </style>
    <!-- FIN STYLES -->

</head>
<body>

    <?php include("Template/header.php"); ?>
    <?php include("Template/newMenu.php"); ?>


    <section class="home_content">  
        
        <div aria-label="breadcrumb" class="mt-1">      
            <ol class="breadcrumb" style="background-color: #fff;">            
	            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
	            <li class="breadcrumb-item " aria-current="page"><a href="ordenes_servicio.php">Ordenes Servicios</a></li>
	            <li class="breadcrumb-item active" aria-current="page">Actualizar Orden Servicio</li>      
            </ol>    
        </div>    

        <div class="notice notice-sistemakv">
            <strong><i class="fa fa-wrench mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">ACTUALIZAR ORDEN DE SERVICIO</b></strong>
        </div>

	    <section class="form-usuarios mt-1 mb-5">
	        <div class="formulario mb-4">
	           
		        <form action="../Controlador/actualizarOrdenServicio.php" method="POST">
		        	<div id="tabs" class="mt-3" style="font-family: 'Lato', sans-serif;">
	                    <ul>
	                      	<li><a href="#tabs-1"><b>Información Orden</b></a></li>
	                      	<li><a href="#tabs-2"><b>Detalle del Servicio</b></a></li>
	                    </ul>
		        		
		        		<?php foreach ($listarOrdenId as $loi){ ?>

		        			<!-- INFORMACIÓN GENERAL ORDEN-->
		     					<div id="tabs-1">

			                        <input type="hidden" name="valorActual" id="valorActual" value="<?php echo $loi['valor_total']; ?>">

		     						<input type="hidden" name="id_orden" id="id_orden" value="<?php echo $id_orden_servicio; ?>">

		     						<input type="hidden" name="fecha_creacion" id="fecha_creacion" value="<?php echo $loi['fecha_creacion']; ?>">

		     						<input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $loi['id_usuario']; ?>">

					        		<!-- VEHICULO -->
								        <div class="row mt-3 ">
								        	<div class="label">
									            <label><b>Vehículo</b></label>
								        	</div>
								        	<div class="input">
								        		<select name="id_vehiculo" id="id_vehiculo" required="required" class="form-control selectpicker" data-live-search="true" onchange="cambioVehiculo()" >
								        		<option value="">SELECCIONAR</option>
								        		<?php foreach($listarV as $veh){ ?>
								        			<option value="<?php echo $veh['numero_movil'] .' | '.$veh['id_vehiculo'];?>" <?php if($loi['id_vehiculo'] == $veh['id_vehiculo']){ ?> selected="selected" <?php } ?> >
								        				<?php echo $veh['numero_movil'].' | '.$veh['placa'];?>
								        			</option>
								        		<?php } ?>
								        		</select>
								        		<?php $listarVehiculoId = $vehiculo->listarPorId($loi['id_vehiculo']); ?>
								        		<input type="hidden" name="vehiculo_act" id="vehiculo_act" value="<?php echo $listarVehiculoId[0]['numero_movil']  .' | '. $loi['id_vehiculo'] ?>">
								        	</div>
								        </div>
											        
							        <!-- TIPO COMBUSTIBLE -->
								        <div class="row mt-3 ">
								        	<div class="label">
								                <label><b>Tipo Combustible</b></label>
								            </div>
								        	<div class="input">
								                <select name="tipo_combustible" id="tipo_combustible" required="required" class="form-control">
								        		
									        		<?php if ($loi['tipo_combustible'] == 'GASOLINA'){ ?>
									        			<option value="GASOLINA" selected="selected">GASOLINA</option>
									        			<option value="DIESEL">DIESEL</option>
									        		<?php } else if ($loi['tipo_combustible'] == 'DIESEL'){ ?>
									        			<option value="DIESEL" selected="selected">DIESEL</option>
									        			<option value="GASOLINA">GASOLINA</option>
									        		<?php } else { ?>
									        			<option value="" selected="selected">Seleccione Tipo Combustible</option>
														<option value="GASOLINA">GASOLINA</option>
									        			<option value="DIESEL">DIESEL</option>
									        		<?php } ?>

								        		</select>
								            </div>
								        </div>

							        <!-- PROVEEDOR -->
								        <div class="row mt-3 ">
								        	<div class="label">
								                <label><b>Proveedor</b></label>
								            </div>
								        	<div class="input">
								                <select name="id_proveedor" id="id_proveedor" required="required" class="form-control selectpicker" data-live-search="true">
								        		<option value="">SELECCIONAR</option>
								        		<?php foreach($listarP as $prov){ ?>
								        			<option value="<?php echo $prov['id_proveedor'];?>" <?php if($loi['id_proveedor'] == $prov['id_proveedor']){ ?> selected="selected" <?php } ?> >
								        				<?php echo $prov['razon_social'];?>
								        			</option>
								        		<?php } ?>
								        		</select>
								            </div>
								        </div>

								    <!-- TIPO DE SERVICIO -->
								        <div class="row mt-3 ">
								        	<div class="label">
								                <label><b>Tipo Servicio</b></label>
								            </div>
								        	<div class="input">
								                <select name="id_tipo_servicio" id="id_tipo_servicio" required="required" class="form-control">
								        		<option value="">Seleccione Tipo Servicio</option>
								        		<?php foreach($listarTS as $tiposerv){ ?>
								        			<option value="<?php echo $tiposerv['id_tipo_servicio'];?>" <?php if($loi['id_tipo_servicio'] == $tiposerv['id_tipo_servicio']){ ?> selected="selected" <?php } ?>>
								        				<?php echo $tiposerv['detalle_tipo'];?>
								        			</option>
								        		<?php } ?>
								        		</select>
								            </div>
								        </div>

							        <!-- CRONOGRAMA -->
								        <div class="row mt-3 ">
								        	<div class="label">
								                <label><b>Cronograma</b></label>
								            </div>
								        	<div class="input">
								                <select name="cronograma" id="cronograma" required="required" class="form-control" onchange="validarCampos(this.value);habilitar_conductores(this.value); ">
								                	<?php if ($loi['solicitado_por'] == "CRONOGRAMA MTO"){ ?>
								                		<?php $cro = 'S'; ?>
														<option value="V">SELECCIONAR</option>
								                		<option value="S" selected="selected">SI</option>
								        				<option value="N">NO</option>
								                	<?php }else if (($loi['solicitado_por'] != "CRONOGRAMA MTO") && ($loi['solicitado_por'] != "")){ ?>
								                		<?php $cro = 'N'; ?>
														<option value="V">SELECCIONAR</option>
														<option value="S">SI</option>
								        				<option value="N" selected="selected">NO</option>
								                	<?php }else{ ?>
								                		<?php $cro = 'V'; ?>
														<option value="V" selected="selected">SELECCIONAR</option>
										        		<option value="S">SI</option>
										        		<option value="N">NO</option>
								                	<?php } ?>
								        		    
								        		</select>

								            </div>
								        </div>

								    <!-- SOLICITADO POR -->
										<?php if ($loi['solicitado_por'] != "CRONOGRAMA MTO"){ ?>
										    <div class="row mt-3" id="conductores">
								                <section class="label">
										     	    <label><b>Solicitado Por</b></label>
										     	</section>
								                <section class="input">
												    <select class="form-control" name="solicitado_por" id="solicitado_por" >
													</select>
													<input type="hidden" name="solicitado_por_act" id="solicitado_por_act" value="<?php echo $loi['solicitado_por']; ?>">
										     	</section>
										    </div>
										<?php }else{ ?>
											<div class="row mt-3" id="conductores" style="display: none;">
								                <section class="label">
										     	    <label><b>Solicitado Por</b></label>
										     	</section>
								                <section class="input">
												    <select class="form-control" name="solicitado_por" id="solicitado_por" >
													</select>
													<input type="hidden" name="solicitado_por_act" id="solicitado_por_act" value="<?php echo $loi['solicitado_por']; ?>">
										     	</section>
										    </div>
										<?php } ?>
									
								    <!-- FECHA INICIAL -->
									    <div class="row mt-3">
							                <section class="label">
									     	    <label><b>Fecha Inicial</b></label>
									     	</section>
							                <section class="input">
											    <input type="text" class="form-control" name="fecha_inicial" id="datepicker" value="<?php echo $loi['fecha_inicial']; ?>" required="required" />
									     	</section>
									    </div>

								    <!-- FECHA FINAL -->
									    <div class="row mt-3">
							                <section class="label">
									     	    <label><b>Fecha Final</b></label>
									     	</section>
							                <section class="input">
											    <input type="text" class="form-control" name="fecha_final" id="datepicker1" value="<?php echo $loi['fecha_final']; ?>" required="required" />
									     	</section>
									    </div>

								    <!-- OBSERVACIONES -->
									    <div class="row mt-3 mb-5">
							                <section class="label">
									     	    <label><b>Observaciones</b></label>
									     	</section>
							                <section class="input">
											    <textarea class="form-control" name="detalle" id="detalle" value="<?php echo $loi['detalle']; ?>"></textarea>
									     	</section>
									    </div>
				        		</div>

				        	<!-- DETALLES DE LA ORDEN -->
				        		<div id="tabs-2">

				        			<!-- LISTAR SERVICIOS ACTUALES-->
				        				<div class="col-12 p-2" style="border: 1px dashed #d1d1d1;">
										<table class="table">	
				      						<thead>
				      							<tr>
				      								<th style="border: hidden;" class="text-center">CATEGORIA</th>
				      								<th style="border: hidden;" class="text-center">SUB - CATEGORIA</th>
				      								<th style="border: hidden;" class="text-center">CANTIDAD</th>
				      								<th style="border: hidden;" class="text-center">VALOR</th>
				      								<th style="border: hidden;" class="text-center"></th>
				      							</tr>
				      						</thead>
				      						<tbody>

				      							<?php $detallePorIdOrden = $orden->detallePorIdOrden($id_orden_servicio); 

				      							foreach ($detallePorIdOrden as $dpio) {

				                                    $listarCategoriasId = $categoria->listarPorId($dpio['id_categoria']);
				                                    $listarSubcategoriasId = $subcategoria->listarPorId($dpio['id_subcategoria']); ?>

													<tr id="detalleOrden_<?php echo $dpio['id_servicio'];  ?>">
														<td style="border: hidden; padding: 4px;">
															<div class="row">
																<span class="fa fa-wrench mr-3 ml-3" style="font-size: 1.7rem; color: #1b2d3b;"></span>
																
																<input class="form-control col-9" type="text" name="id_categoria" value="<?php echo $listarCategoriasId[0]['detalle_categoria']; ?>" readonly="true" required/>
															</div>
														</td>

														<td style="border: hidden; padding: 4px;">
															
															<input class="form-control col-12" type="text" name="id_subcategoria" value="<?php echo $listarSubcategoriasId[0]['detalle_subcategoria']; ?>" readonly="true" required/>

														</td>

														<td style="border: hidden; padding: 4px;">
															<input class="form-control col-12" type="text" name="id_subcategoria" value="<?php echo $dpio['cantidad']; ?>" readonly="true" required/>
														</td>

														<td style="border: hidden; padding: 4px;">
															<input class="form-control col-12" type="text" name="valor" value="<?php echo $dpio['valor'] ?>" readonly="true" required/>
														</td>

														<td style="border: hidden; padding: 4px;">

															<!-- Eliminar -->
															<a class="btn btn-danger" onclick="eliminarDO(<?php echo $dpio['id_servicio'] ?>, <?php echo $dpio['valor'] ?>, <?php echo $id_orden_servicio ?>);" style="cursor: pointer; margin: 0px; padding: 0px 4px 0px 4px;"><i class="fa fa-trash" style="color:#fff;"></i></a>
															
														</td>	

													</tr>

												<?php } ?>
											</tbody>
										</table>
										</div>

										<?php 
											$listarSubcategoriaProveedor = $subcategoria->listarSubcategoriaProveedor($loi['id_proveedor']);
										
										?>

									<!-- REGISTRAR DETALLES ORDEN-->
										<div class="col-12 p-2 mt-2" style="border: 1px dashed #d1d1d1;">

									        <div class="notice notice-sistemakv">
									            <strong style="font-size: 1.1rem;"><i class="fa fa-wrench mr-2" style="font-size: 2rem;"></i>NUEVO DETALLE ORDEN</strong>
									        </div>

		                        			<input type="hidden" name="valor" id="valor" class="form-control">

											<!-- CATEGORIA -->
											<div class="row mt-3 mb-4 mt-4">
					                            <div class="label">
					                                <label><b>Categoria</b></label>
					                            </div>
					                            <div class="input">
					                                <select name="id_categoria" id="id_categoria" class="form-control selectpicker" data-live-search="true" onchange="listarSubCategorias(this.value, <?php echo $loi['id_proveedor'] ?>);">
					                                    <option value="">SELECCIONAR</option>
					                                <?php   
					                                	$idC = "";
					                                	foreach ($listarSubcategoriaProveedor as $lsp) {
															$listarCategoria = $subcategoria->listarCategoriasPorIdSubcategoria($lsp['id_subcategoria']);
															if($idC != $listarCategoria[0]['id_categoria']){
																$idC = $listarCategoria[0]['id_categoria'];
													?>

															<option value="<?php echo $listarCategoria[0]['id_categoria']?>"><?php echo $listarCategoria[0]['detalle_categoria']; ?></option>
													<?php } } ?>		
					                                </select>
					                            </div>
					                        </div>

					                    	<!-- SUB CATEGORIA-->
						                        <div class="row mt-3 mb-4">
						                            <div class="label">
						                                <label><b>Sub - Categoria</b></label>
						                            </div>
						                            <div class="input">
						                                <select name="id_subcategoria" id="id_subcategoria" class="form-control" onchange="cargarValorSubcategoria(this.value, <?php echo $loi['id_proveedor'] ?>);">
						                                </select>
						                            </div>
						                        </div>

						                    <!-- CANTIDAD -->
						                        <div class="row mt-3 mb-4">
						                            <div class="label">
						                                <label><b>Cantidad</b></label>
						                            </div>
						                            <div class="input">
						                                <input type="text" name="cantidad" id="cantidad" class="form-control" onblur="valorTotalDetalle();">
						                            </div>
						                        </div>

						                    <!-- VALOR -->
						                        <div class="row mt-3 mb-4">
						                            <div class="label">
						                                <label><b>Valor</b></label>
						                            </div>
						                            <div class="input">
						                                <input type="text" name="valorTotal" id="valorTotal" class="form-control" onKeyPress="return solo_numeros(event)">
						                            </div>
						                        </div>
										</div>

				        		</div>

		        		<?php } ?>
		        	</div>

                    <section class="col-12 mt-4 d-flex justify-content-center">
                        <a href="ordenes_servicio.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
                        <button type="submit" class="btn btn-outline-info col-3">Actualizar</button>
                    </section>

		        </form>

	        </div>
	    </section>

	</section>

    <?php include("Template/scripts.php"); ?>
	
	<script type="text/javascript">



        function valorTotalDetalle(){
            var valor = $("#valor").val();
            var cantidad = $("#cantidad").val();

            $("#valorTotal").val(valor * cantidad);
        }



		$( function() {

            $("#datepicker").datepicker({ dateFormat:'yy/mm/dd'});
            $("#datepicker1").datepicker({ dateFormat:'yy/mm/dd'});
        } );

		$( function() {
          $( "#tabs" ).tabs();
        } );

       function cambioVehiculo(){
        	if (document.getElementById('id_vehiculo').value != document.getElementById('vehiculo_act').value) {	
        		document.getElementById('cronograma').selectedIndex = "0";
        		document.getElementById('solicitado_por').selectedIndex = "0";
				document.getElementById('conductores').style.display = 'none';
        	}
        };


		function validarCampos(cronograma){
			if(cronograma == 'N'){
				document.getElementById('conductores').style.display = 'flex';
			}else if(cronograma == 'S'){
				document.getElementById('conductores').style.display = 'none';
				document.getElementById('solicitado_por').value = '';
			}else{
				document.getElementById('conductores').style.display = 'flex';
			}
		}

		function eliminarDO(id_servicio, valor, id_orden){
			//alert(id_acta);
			    valorActual = document.getElementById('valorActual').value;

				var parametros = {
			       "id_servicio" : id_servicio,
			       "valor" : valor,
			       "id_orden" : id_orden,
			       "valorActual" : valorActual
			    };

			    $.ajax({
			        data:  parametros, //datos que se envian a traves de ajax
			        url:   '../Controlador/eliminardetallesOrdenServicio.php', //archivo que recibe la peticion
			        type:  'post', //método de envio
			        beforeSend: function () {
			            $("#input-message").html("<p>Procesando, espere por favor...</p>");
			        },
			        success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
			        	//alert(response);
			            $("#exampleModal"+id_servicio).modal('hide');
			            location.reload();
			        }
			    });    	
		}

		function listarSubCategorias(id_categoria, id_proveedor){
			//alert(id_acta);
				var parametros = {
			       "id_categoria" : id_categoria,
			       "id_proveedor" : id_proveedor
			    };

			    $.ajax({
			        data:  parametros, //datos que se envian a traves de ajax
			        url:   '../Controlador/cargarSubCategoriaProveedor.php', //archivo que recibe la peticion
			        type:  'post', //método de envio
			        beforeSend: function () {
			            $("#id_subcategoria").html("<option selected'selected'>Procesando, espere por favor...</option>");
			        },
			        success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
			        	//alert(response);
			           $("#id_subcategoria").html(response);
			        }
			    });    	
		}

		function cargarValorSubcategoria(id_subcategoria, id_proveedor){
			//alert(id_acta);
				var parametros = {
			       "id_subcategoria" : id_subcategoria,
			       "id_proveedor" : id_proveedor
			    };

			    $.ajax({
			        data:  parametros, //datos que se envian a traves de ajax
			        url:   '../Controlador/CargarDatosSubcateProveedor.php', //archivo que recibe la peticion
			        type:  'post', //método de envio
			        beforeSend: function () {
			            $("#valorSub").val("Cargando valor, por favor espere.");
			        },
			        success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
			        	//alert(response);
	                    $("#valor").val(response);
	                    $("#valorTotal").val("");
	                    $("#cantidad").val("");
			        }
			    });    	
		}

		
		function habilitar_conductores(valor){
			
    		if(valor == 'N'){
				id_vehiculo = document.getElementById('id_vehiculo').value;
				
				var datos = id_vehiculo.split("|");
				id_vehiculo = datos[1];
				id_orden_servicio = document.getElementById('id_orden').value;

				var parametros = {
					   "id_vehiculo" : id_vehiculo,
					   "id_orden_servicio" : id_orden_servicio
				};

				$.ajax({
			        data: parametros,
			        url: '../Controlador/listarConductoresVehiculoMantActualizar.php',
			        type: 'post',
			        beforeSend: function(){
			        	$('#solicitado_por').html("Cargando, por favor espere.");
			        },
			        success: function(response){
			         	//alert(response);
			            $('#solicitado_por').html(response);
			        }

				});
			}
		}



	</script>
	<script>habilitar_conductores(<?php echo "'" . $cro . "'";?>);</script>
</body>
</html>