<?php
include ("../Controlador/Sesion/autenticar.php");	
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Contrato.php");
require_once("../Modelo/Cartera.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/General.php");


$vehiculo = new Vehiculo();
$contrato = new Contrato();
$cliente = new Cliente();
$empresa = new Empresa();
$cartera = new Cartera();

$listado = $cartera->ConsAvales();

?>
<!DOCTYPE html>
<html>
    <head>  
        <meta charset="utf-8">  
        <title>SistemaKV | Aval Vehiculos</title>  
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">  
        
        <!-- STYLES -->  
            <?php include("Template/styles.php") ?>  
            <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
        <!-- FIN STYLES -->

    </head>
    
    <body>    

        <!--MENU-->
            <?php include("Template/header.php"); ?>
            <?php include("Template/newMenu.php"); ?>
        <!--FIN MENU--> 
        
        <!--**************************--->        
        
        <!-- CONTENIDO -->    

            <section class="home_content">
        
                <div aria-label="breadcrumb" class="mt-1">      
                    <ol class="breadcrumb" style="background-color: #fff;">            
                        <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>            
                        <li class="breadcrumb-item active" aria-current="page">Avales</li>         
                    </ol>    
                </div>  


                <div class="notice notice-sistemakv">
                    <strong><i class="fa fa-car mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">AVAL VEHÍCULOS</b></strong>
                </div>

                <div class="notice notice-sistemakv">

                    <a href="activar_cobroAvales.php" class="btn" id="buttonsKV">Activar Cobro <i class="fa fa-star"></i></a>     

                    <?php if (count($listado) > 0){ ?>
                        <a href="eximir_cobroAvales.php" class="btn" id="buttonsKV">Eximir Cobro <i class="fa fa-star"></i></a> 
                    <?php } ?>   
                </div>
  
        
                <div class="mt-2 p-4 table-responsive" style="background-color: #fff;">    	
                    <table  id="dataT" class="table table-hover table-sm display text-center" style="width:100%">    		
                        <thead style="background-color: #1b2d3b; color: #fff;">    			
                            <tr>                    
                                <th>ID</th>                    
                                <th>VEHICULO</th>                 
                                <th>CONTRATO</th>                 
                                <th>DETALLE</th>                
                                <th>FRECUENCIA</th>                    
                                <th>MES COBRO</th>                    
                                <th>SIGUIENTE MES COBRO</th>                    
                                <th>ESTADO</th>      			
                            </tr>    		
                        </thead>    		
                        
                        <tbody>    			
                            <?php foreach ($listado as $lc){ 
                                $listarVehiculoID = $vehiculo->listarPorId($lc['id_vehiculo']); 
                                $listarContratoID = $contrato->listarId($lc['id_contrato']); 
                            ?>    				
                                <tr>                                        
                                    <td><?php echo  $lc['id_aval'] ?></td>                        
                                    <td>
                                        <?php 
                                            echo  $listarVehiculoID[0]['placa'] . ' | Movil ' . $listarVehiculoID[0]['numero_movil'];
                                        ?>
                                    </td> 
                                    <td>
                                        <?php 
                                            $cli = $cliente->listarClientePorId($listarContratoID[0]['id_cliente']);
                                            echo "Contrato No. ". $listarContratoID[0]['id_contrato']. " - " . $cli[0]['razon_social'];
                                        ?>                      
                                    </td>                        
                                    <td>AVAL <?php echo strtoupper(mes($lc['mes'])) . ' - ' . $listarVehiculoID[0]['placa'] ?></td>                                           
                                    <td>MENSUAL</td>                    
                                    <td><?php echo strtoupper(mes($lc['mes'])) . ' DE ' . $lc['anio']; ?></td>                                        
                                    <td>
                                        <?php 
                                            $fecha_cobro = $lc['anio'] . '/' . $lc['mes'] . '/01' ;
                                            $siguiente_fecha_cobro = date("Y-m", strtotime($fecha_cobro."+ 1 month")); 
                                            $siguiente_cobro = explode("-", $siguiente_fecha_cobro);
                                            $anio = $siguiente_cobro[0];
                                            $mes = $siguiente_cobro[1];
                                            echo strtoupper(mes($mes)) . ' DE ' . $anio;
                                        ?>
                                    </td>                                        
                                    <td>
                                        <?php 
                                            if($lc['estado'] == 'A'){	
                                                echo '<p><strong style="font-size: .9rem;"><i class="fa fa-check-circle-o" style="color: green; font-size: 1.1rem;"></i> ACTIVO</strong>'; 
                                            }else if($lc['estado'] == 'F'){	
                                                echo '<p><strong style="font-size: .9rem;"><i class="fa fa-check-circle-o" style="color: red; font-size: 1.1rem;"></i> FINALIZADO</strong>'; 
                                            }else if($lc['estado'] == 'E'){    
                                                echo '<p><strong style="font-size: .9rem;"><i class="fa fa-minus-square-o" style="color: red; font-size: 1.1rem;"></i> EXIMIDO</strong>'; 
                                            }else if($lc['estado'] == 'I'){    
                                                echo 'INACTIVO'; 
                                            }   
                                        ?>  
                                    </td> 				                    
                                </tr>    			
                            <?php } ?>    		
                        </tbody>    	
                    </table>    
                </div>    

        </section>
        <!-- FIN CONTENIDO -->    
        
        <!-- script -->    
            <?php include("Template/scripts.php"); ?>
    </body>
    </html>