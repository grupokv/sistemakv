<?php
include ("../Controlador/Sesion/autenticar.php");	
require_once("../Modelo/ConceptosCobro.php");
require_once("../Modelo/EmpresaEnt.php");
require("../Modelo/Vehiculo.php");

$concepto = new ConceptoCobro();
$listado = $concepto->listarActivos();

$empresa = new Empresa();
$listadoEmpresas = $empresa->listar();

$vehiculo = new Vehiculo();
$listarVehi = $vehiculo->listarVehiculosVinculados();

$hoy = date('Y-m-d');

?>
<!DOCTYPE html>
<html>
	<head>  
	<meta charset="utf-8">  
	<title>SistemaKV | Activar Cobros</title>  
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">  

        <!-- STYLES -->  
    	    <?php include("Template/styles.php") ?>  
            <link rel="stylesheet" href="../Resources/css/stylesHeader.css">  
        <!--FIN STYLES -->

	</head>
	<body>    

        <!--MENU-->
            <?php include("Template/header.php"); ?>
            <?php include("Template/newMenu.php"); ?>
        <!--FIN MENU-->
        
        <section class="home_content">  
    
            <div aria-label="breadcrumb" class="mt-1">      
                <ol class="breadcrumb" style="background-color: #fff;">            
                <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                <li class="breadcrumb-item " aria-current="page"><a href="conceptos_cobro.php">Conceptos Cobro</a></li>
                <li class="breadcrumb-item active" aria-current="page">Activar Cobros</li>           
                </ol>    
            </div>    

            <div class="notice notice-sistemakv">
                <strong><i class="fa fa-money mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">ACTIVAR COBRO</b></strong>
            </div>

            <div class="notice notice-sistemakv">

                <!-- COBRO POR VEHÍCULO-->
                <a href="cobroConceptoPorVehiculo.php" class="btn btn-outline-info" id="buttonsKV"> Cobro por Vehiculo <i class="fa fa-plus ml-1"></i></a>

                <!-- PAGO POR VEHÍCULO-->
                <a href="pagoConceptoPorVehiculo.php" class="btn btn-outline-info" id="buttonsKV"> Pago por Vehiculo <i class="fa fa-money  ml-1"></i></a>

            </div>
    
    		<div class="mt-2 p-4 table-responsive" style="background-color: #fff;">    	
    			<table id="dataT" class="table table-hover display text-center" style="width:100%">
    				<thead style="background-color: #1b2d3b; color: #fff;">
    					<tr>                    
    						<th>ID</th>                    
    						<th>CONCEPTO</th>    		    
    						<th>FRECUENCIA DE COBRO</th>                    
    						<th>PROX FECHA DE COBRO</th> 		    
    						<th>OPCIONES</th>    			
    					</tr>    		
    				</thead>    		
    				<tbody>    			
    					<?php foreach ($listado as $lc){ ?>    				
    						<tr>                                        
    							<td><b><?php echo  $lc['id_concepto'] ?></b></td>
    							<td><?php echo $lc['detalle_concepto'] ?></td>
    							<td>
    								<?php 			
        								if($lc['frecuencia'] == 'M'){				
        									echo 'MENSUAL';			
        								} else if($lc['frecuencia'] == 'A'){				
        									echo 'ANUAL';			
        								}			
    								?>			
    							</td>
    							<td>
                                    <?php 
                                        if($lc['frecuencia'] == 'N'){ 
                                            echo ""; 
                                        }else { 
                                            echo date('M-d-Y',strtotime($lc['siguiente_fecha'])); 
                                        } 
                                    ?>
                                </td>
    							<td>    
    								<?php if(($hoy >= $lc['siguiente_fecha']) && ($lc['frecuencia'] != 'N')){ ?>                       
        								<button class="btn btn-outline-info" data-toggle="modal" data-target="#modalCobro" onclick="consultarConcepto(<?php echo $lc['id_concepto']; ?>);" style="margin: 0px; padding: 0px 4px 0px 4px;" >
        									<span class="fa fa-dollar"></span>
        								</button>
    								<?php } ?>  
    							</td>    				                    
    						</tr>    			
    					<?php } ?> 
    				</tbody>    	
    			</table>    
    		</div>     
    		
        </section>


                        <!--Modal -->
                            <div class="modal fade" id="modalCobro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form action="../Controlador/generarCobros.php" method="POST">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                
                                                <div class="alert alert-primary text-center" role="alert"> COBRO DE CONCEPTO </div>
                                                
                                                <section class="d-flex justify-content-center mb-4"> ¿ Desea inhabilitar el cobro para algun vehiculo ? </section>
                                                
                                                <!-- ID CONCEPTO -->
                                                <input type="hidden" name="id_concepto" id="id_concepto" class="form-control"/>
                                                
                                                <!-- COBRO VEHICULO -->
                                                <input type="hidden" name="cobroPorVehiculo" id="cobroPorVehiculo" class="form-control" value="N"/>
                                                
                                                
                                                <!-- INHABILITAR COBRO -->
                                                <section class="row d-flex justify-content-center mb-4">
                                                    <div class="col-9">
                                                        <select class="form-control " name="inhabilitar_cobro" id="inhabilitar_cobro" onchange="inhabilitar_cobroFunction(this.value);">
                                                            <option value="0">SELECCIONAR</option>
                                                            <option value="1">SI</option>
                                                            <option value="2">NO</option>
                                                        </select>
                                                    </div> 
                                                </section>
                                                
                                                
                                                <!-- OPCIONES COBRO -->
                                                <section class="row d-flex justify-content-center mb-4">
                                                    <div class="col-9" id="opcionesCobroConceptos" style="display:none">
                                                        <select name="opcion_cobro" id="opcion_cobro" class="form-control" onchange="opcionCobro(this.value)" required="required">
                                                            <option value="0">SELECCIONAR</option>
                                                            <option value="FP">FLOTA PROPIA</option>
                                                            <option value="VE">VEHÍCULO EN ESPECÍFICO</option>
                                                        </select>
                                                    </div> 
                                                </section>
                                                
                                                
                                                <!-- EMPRESA -->
                                                <section class="row" id="empresa_fpl" style="display:none">
                                                    <div class="col-9 ml-5">
                                                        <label class="ml-3">Empresa</label>
                                                    </div>
                                                </section>
                                                
                                                
                                                <section class="row mb-5"  id="empresa_fpi" style="display:none">
                                                    <div class="col-9 ml-5">
                                                        <select class="form-control ml-3" name="id_empresa" id="id_empresa">
                                                            <option value="0">Seleccionar</option>
                                                            <option value="TFP">TODO FLOTA PROPIA</option>
                                                            <?php foreach($listadoEmpresas as $le){?>
                                                                <option value="<?php echo $le['id_empresa'];?>"><?php echo $le['nombre_empresa']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </section>
                                                
                                                
                                                <!-- VEHICULO -->
                                                
                                                <section class="row" id="vehiculoL" style="display:none">
                                                    <div class="col-9 ml-5">
                                                        <label class="ml-3">Vehiculo(s)</label>
                                                    </div>
                                                </section>
                                                
                                                <section class="row d-flex justify-content-center mb-3">
                                                    <div class="col-9" id="vehiculoC" style="display:none">
                                                        <select class="form-control" name="id_vehiculo[]" id="id_vehiculo" multiple="multiple">
                                                            <?php foreach ($listarVehi as $lv){ ?>
                                                                <option value="<?php echo $lv['id_vehiculo'] ?>">
                                                                    <?php echo $lv['placa'] . ' | ' . $lv['numero_movil']?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </section>
                                                
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-primary" name="cobrar" id="cobrar">Cobrar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                
		            
        <?php include("Template/scripts.php"); ?>
	</body>
	
	<script type="text/javascript">
	
        
    	function inhabilitar_cobroFunction(id_num){
    	    if(id_num == 1){
    	        document.getElementById('opcionesCobroConceptos').style.display = "flex";
    	    }else{
    	        document.getElementById('opcionesCobroConceptos').style.display = "none";
    	        document.getElementById('vehiculo').style.display = "none";
    	        document.getElementById('empresa_fpl').style.display = "none";
    	        document.getElementById('empresa_fpi').style.display = "none";
    	    }
    	}
    	
    	function opcionCobro(id){
    	    //alert(id);
    	    if(id == "FP"){
    	        document.getElementById('empresa_fpl').style.display = "flex";
    	        document.getElementById('empresa_fpi').style.display = "flex";
    	        document.getElementById('vehiculoC').style.display = "none";
    	        document.getElementById('vehiculoL').style.display = "none";
    	    }else if(id == "VE"){
    	        document.getElementById('vehiculoC').style.display = "flex";
    	        document.getElementById('vehiculoL').style.display = "flex";
    	        document.getElementById('empresa_fpl').style.display = "none";
    	        document.getElementById('empresa_fpi').style.display = "none";
    	    }else{
    	        document.getElementById('vehiculoC').style.display = "none";
    	        document.getElementById('vehiculoL').style.display = "none";
    	        document.getElementById('empresa_fpl').style.display = "none";
    	        document.getElementById('empresa_fpi').style.display = "none";
    	    }
    	}
    	
    	function consultarConcepto(concepto){
    	    //alert(concepto);
    	    $("#id_concepto").val(concepto);
    	}
    	
    	$( function(){
      	  $("#id_vehiculo").chosen(); 
        });
    	
    </script>
</html>