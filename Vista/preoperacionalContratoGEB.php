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
	        <form action="../Controlador/registrarPreoperacionalContratoGEB.php" method="POST">
	        	<?php include("Template/header-form.php"); ?>


                    <!--id_preoperacional-->
                    <input type="hidden" name="id_preoperacional" id="id_preoperacional" value="<?php echo $id ?>">
                        
                    <!-- EQUIPO DE SEGURIDAD | 10 | -->
                        <table class="table">
                          <thead class="mb-5 mt-5">
                            <tr class="text-center">
                              <th  style="border: 0" width="40%">EQUIPO DE SEGURIDAD</th>
                              <th  style="border: 0" width="50%">ITEM</th>
                              <th  style="border: 0" ></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">BOTIQUÍN (Alcohol antiséptico, termómetro, solución salina, yodopovidona, vendas de algodón, vendas elásticas, guantes de látex, baja lenguas, esparadrapo, gasa, tijeras, inmovilizador cervical, venda triangular, inmovilizadores para extremidades). </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="botiquin" id="botiquin" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px"> Extintor cargado. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="extintor_cargado" id="extintor_cargado" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px"> Gato. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="gato" id="gato" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Cruceta o Copa. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="cruceta_copa" id="cruceta_copa" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px"> Triángulos (2). </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="triangulos" id="triangulos" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px"> Tacos o Cuñas (2). </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="tacos_cunias" id="tacos_cunias" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px"> Llanta de repuesto inflada y en buen estado. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="llanta_repuesto" id="llanta_repuesto" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px"> Herramientas (Llave expansiva, Destornilladores (Pala y estrella), llaves fijas, Alicate, Linterna). </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="herramientas" id="herramientas" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px"> Chaleco refractivo. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="chaleco_refractivo" id="chaleco_refractivo" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px"> Aviso como conduzco. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="aviso_conduzco" id="aviso_conduzco" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            
                          </tbody>
                        </table>

                    <!-- ESTADO GENERAL | 23 | -->
                        <table class="table">
                          <thead>
                            <tr class="text-center mb-3">
                              <th  style="border: 0" width="40%">ESTADO GENERAL</th>
                              <th  style="border: 0" width="50%">ITEM</th>
                              <th  style="border: 0" ></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Nivel del liquido refrigerante. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="nivel_liquido" id="nivel_liquido" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Nivel de aceite. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="nivel_aceite" id="nivel_aceite" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Fuga de aceite. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="fuga_aceite" id="fuga_aceite" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Estado filtro del combustible. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="estado_filtro_combustible" id="estado_filtro_combustible" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Sistema de embrague. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="sistema_embrague" id="sistema_embrague" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Cierre de puertas y ventanas. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="cierre_puertas_ventanas" id="cierre_puertas_ventanas" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Seguro de las puertas. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="seguro_puertas" id="seguro_puertas" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Cinturones de seguridad. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="cinturones_seguridad" id="cinturones_seguridad" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Control de Fugas. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="control_fugas" id="control_fugas" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Estado de la cojineria. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="estado_cojineria" id="estado_cojineria" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Estado y fijación de asientos. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="fijacion_asientos" id="fijacion_asientos" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Ajuste de la silla del conductor (Extender o recoger). </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="ajuste_silla_conductor" id="ajuste_silla_conductor" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Espejos retrovisores Ext. Der. Ext. Izq. E Interior. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="estado_retrovisores" id="estado_retrovisores" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Pisos de la cabina (Estado y Seguridad). </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="pisos_cabina" id="pisos_cabina" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Llanta trasera izquierda (Labrado Min. 3 mm). </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="llanta_trasera_izq" id="llanta_trasera_izq" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Llanta trasera derecha (Labrado Min. 3 mm). </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="llanta_trasera_der" id="llanta_trasera_der" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Llanta delantera izquierda (Labrado Min. 3 mm). </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="llanta_delantera_izq" id="llanta_delantera_izq" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Llanta delantera derecha (Labrado Min. 3 mm). </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="llanta_delantera_der" id="llanta_delantera_der" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Estado de latonería y pintura. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="estado_latoneria" id="estado_latoneria" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Pito. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="pito" id="pito" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Aire acondicionado. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="aire_acondicionado" id="aire_acondicionado" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Apoya cabezas. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="apoya_cabezas" id="apoya_cabezas" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Alarma de retroceso. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="alarma_retroceso" id="alarma_retroceso" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            
                          </tbody>
                        </table>

                    <!-- FRENOS | 2 | -->
                        <table class="table">
                          <thead>
                            <tr class="text-center mb-3">
                              <th  style="border: 0" width="40%">FRENOS</th>
                              <th  style="border: 0" width="50%">ITEM</th>
                              <th  style="border: 0" ></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Freno de parqueo - servicio de emergencia. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="freno_parqueo" id="freno_parqueo" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Nivel del liquido de freno. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="lvl_liquido_freno" id="lvl_liquido_freno" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            
                          </tbody>
                        </table>

                    <!-- INSTRUMENTO DE CONTROL Y SEGURIDAD  | 8 |-->
                        <table class="table">
                          <thead>
                            <tr class="text-center mb-3">
                              <th  style="border: 0" width="40%">INSTRUMENTO DE CONTROL Y SEGURIDAD</th>
                              <th  style="border: 0" width="50%">ITEM</th>
                              <th  style="border: 0" ></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Limpia Brisas. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="limpia_brisas" id="limpia_brisas" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Parabrisas. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="parabrisas" id="parabrisas" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Sistema de Agua para el Parabrisas. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="sistema_parabrisas" id="sistema_parabrisas" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Estado del vidrio trasero de la cabina. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="estado_vidrio_trasero" id="estado_vidrio_trasero" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Indicadores (Temperatura, Revoluciones, Voltímetro, Tacómetro). </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="indicadores" id="indicadores" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Indicador luces altas. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="indicadores_luces_altas" id="indicadores_luces_altas" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Indicador luces de parqueo. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="indicador_luces_parqueo" id="indicador_luces_parqueo" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Indicador Nivel de Gasolina. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="indicador_lvl_gasolina" id="indicador_lvl_gasolina" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            
                          </tbody>
                        </table>

                    <!-- CONTAMINANTES | 2 | -->
                        <table class="table">
                          <thead>
                            <tr class="text-center mb-3">
                              <th  style="border: 0" width="40%">CONTAMINANTES</th>
                              <th  style="border: 0" width="50%">ITEM</th>
                              <th  style="border: 0" ></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Sistema de Escape (Exosto - Silenciadores). </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="sistema_escape" id="sistema_escape" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Emanación de Gases (Inspección Visual). </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="emanacion_gases" id="emanacion_gases" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            
                          </tbody>
                        </table>

                    <!-- SISTEMA ELÉCTRICO Y LUCES | 12 | -->
                        <table class="table">
                          <thead>
                            <tr class="text-center mb-3">
                              <th  style="border: 0" width="40%">SISTEMA ELÉCTRICO Y LUCES</th>
                              <th  style="border: 0" width="50%">ITEM</th>
                              <th  style="border: 0" ></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Luces de Posición Delantera (Cocuyos). </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="luces_posicion_delantera" id="luces_posicion_delantera" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Luces de Posición Traseras (Cantidad 2). </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="luces_posicion_trasera" id="luces_posicion_trasera" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Luces de Freno (incluye tercera luz de freno). </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="luces_freno" id="luces_freno" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Direccionales (Delanteras - Traseras). </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="direccionales" id="direccionales" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Luces de Emergencia (Estacionarias). </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="luces_emergencia" id="luces_emergencia" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Luces de Retroceso. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="luces_retroceso" id="luces_retroceso" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Luz para placa. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="luz_placa" id="luz_placa" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Luces Bajas. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="luces_bajas" id="luces_bajas" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Luces Alta. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="luces_altas" id="luces_altas" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Luces Interiores. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="luces_interiores" id="luces_interiores" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Luces en el Tablero. </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="luces_tablero" id="luces_tablero" value="C">
                                        <span class="slider"></span>
                                    </label>    
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0px"></td>
                                <td style="border: 0px">Sistema Eléctrico Aislado (inspección visual). </td>
                                <td style="border: 0px">
                                    <label class="switch">
                                        <input type="checkbox" name="sistema_electrico_aislado" id="sistema_electrico_aislado" value="C">
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