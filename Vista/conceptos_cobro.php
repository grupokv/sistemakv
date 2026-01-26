<?php
include ("../Controlador/Sesion/autenticar.php");	
require_once("../Modelo/ConceptosCobro.php");
$concepto = new ConceptoCobro();$listado = $concepto->listar();

?>
<!DOCTYPE html>
<html>
    <head>  
        <meta charset="utf-8">  
            <title>SistemaKV | Conceptos Cobros</title>  
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
                <li class="breadcrumb-item active" aria-current="page">Conceptos Cobro</li>         
            </ol>    
        </div>    

        <div class="notice notice-sistemakv">
            <strong><i class="fa fa-money mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">CONCEPTOS COBRO</b></strong>
        </div>


        <div class="notice notice-sistemakv">
            <a href="registrarConceptoCobro.php" class="btn btn-outline-info" id="buttonsKV">Registrar <span class="fa fa-plus"></span></a>        
            <a href="activar_cobro.php" class="btn btn-outline-info" id="buttonsKV">Activar Cobros <span class="fa fa-star"></span></a>    
        </div>
        
        <div class="mt-2 p-4 mb-4 table-responsive" style="background-color: #fff;">    	
            <table  id="dataT" class="table table-hover table-sm display text-center" style="width:100%">    		
                <thead style="background-color: #1b2d3b; color: #fff;">    			
                    <tr>                    
                        <th>ID</th>                    
                        <th>DETALLE</th>    		    
                        <th>FRECUENCIA</th>                    
                        <th>SIGUIENTE FECHA</th>                    
                        <th>ESTADO</th>    		    
                        <th>OPCIONES</th>    			
                    </tr>    		
                </thead>    		
                
                <tbody>    			
                    <?php foreach ($listado as $lc){ ?>    				
                        <tr>                                        
                            <td><?php echo  $lc['id_concepto'] ?></td>                        
                            <td><?php echo $lc['detalle_concepto'] ?></td>                                           
                            <td><?php if($lc['frecuencia'] == 'M'){	echo 'MENSUAL';	} else if($lc['frecuencia'] == 'A'){ echo 'ANUAL'; } else if($lc['frecuencia'] == 'N'){ echo 'NINGUNA'; } ?>	</td>                    
                            <td><?php setlocale(LC_TIME, 'spanish'); if($lc['frecuencia'] != 'N'){ echo strtoupper(strftime("%B %d del %Y",strtotime($lc['siguiente_fecha']))); }else{ echo ""; } ?></td>                                        
                            <td><?php if($lc['estado'] == '1'){	echo 'ACTIVO'; } else if($lc['estado'] == '0'){	echo 'INACTIVO'; }	?>  </td> 
                            <td>
                                <a href="actualizarConceptoCobro.php?id=<?php echo base64_encode($lc['id_concepto']); ?>" style="margin: 0px; padding: 0px 4px 0px 4px;" class="btn btn-outline-info"><span class="fa fa-edit"></span></a>						    
                                <a href="actualizarValoresConcepto.php?id=<?php echo base64_encode($lc['id_concepto']); ?>" style="margin: 0px; padding: 0px 4px 0px 4px;" class="btn btn-outline-success"><span class="fa fa-dollar"></span></a>                        
                            </td>    				                    
                        </tr>    			
                    <?php } ?>    		
                </tbody>    	
            </table>    
        </div>        
        
        <!-- FIN CONTENIDO -->    
        
        <!-- script -->    
            <?php include("Template/scripts.php"); ?>
    </body>
    </html>