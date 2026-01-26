<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/contratoOcasional.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/Ciudad.php");
require_once("../Modelo/Usuario.php");

$contratoOcasional = new ContratoOcasional();
$listar = $contratoOcasional->listar(date('Y'));

$empresa = new Empresa();
$cliente = new Cliente();
$ciudad = new Ciudad();
$usuario = new Usuario();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Contratos Ocasionales</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- STYLES -->
        <?php include("Template/styles.php") ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

        <style>

            #loading{
                background-image:url('../Resources/images/renderLoader.gif');
                background-position: 0px -150px;
                height: 55px;
                width: 100%;
            }
            
        </style>    
    <!--FIN STYLES -->

</head>
<body>

    <!--MENU-->
        <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

    <!-- ************************** --->
    
    <!-- CONTENIDO --->

        <section class="home_content">  

            <div aria-label="breadcrumb" class="mt-1"> 
                <ol class="breadcrumb" style="background: #fff;">
                    <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Contratos Ocasionales</li>
                </ol>
            </div>

            <div class="notice notice-sistemakv">
                <strong><i class="fa fa-file-text-o mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">CONTRATOS OCASIONALES</b></strong>
            </div>


            <div class="notice notice-sistemakv">
                <a id="buttonsKV" href="registrarContratosOcasionales.php" class="btn btn-outline-info mr-4">Generar Ocasional <span class="fa fa-plus"></span></a>
                
                <a id="buttonsKV" href="reporteFuecOcasionales.php" class="btn btn-outline-info mr-4">Reporte <span class="fa fa-file-text-o"></span></a>
            </div>

            <div class="mt-2 p-4 table-responsive" style="background-color: #fff;">
            	<table  id="dataT" class="table table-hover table-sm display" style="width:100%">
            		<thead style="background-color: #1b2d3b; color: #fff;">
            			<tr class="text-center">
                            <th>CONTRATO N°</th>
                            <th>CONTRATISTA</th>
            				<th>CONTRATANTE</th>
                            <th>LUGAR DE EXPEDICIÓN</th>
                            <th>FECHA DE EXPEDICIÓN</th>
                            <th>EMISOR</th>
            				<th>OPCIONES</th>
            			</tr>
            		</thead>
            		<tbody>
            			<?php foreach ($listar as $lco){ 
                            ?>
            				<tr class="text-center">                
                                <td><?php echo  str_pad($lco['id_contrato_ocasional'], 6, '0', STR_PAD_LEFT); ?></td>
                                <td><?php echo $lco['nombre_empresa'] ?></td>                   
                                <td><?php echo $lco['razon_social'] ?></td>                   
                                <td style="width: 50px;"><?php echo $lco['ciudad'] ?></td>                   
                                <td><?php echo $lco['fecha_creacion'] . ' a las ' . '' , $lco['hora_creacion'] ?></td>
                                <?php $listarUId = $usuario->listarUsuarioPorId($lco['id_responsable']) ?>
                                <td>
                                    <?php foreach ($listarUId as $lui) {
                                             echo utf8_encode($lui['nombre']);
                                    } ?>        
                                </td>
                                <td style="padding: 10px;">
                                    <a href="PDF/contratoOcasional.php?id_contrato_ocasional=<?php echo $lco['id_contrato_ocasional']; ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;" class="btn btn-outline-success">
                                        <i class="fa fa-search"></i>
                                    </a>

                                    <a style="margin: 4px; padding: 0px 4px 0px 4px; cursor: pointer; color: #ffffff;" class="btn btn-info" data-toggle="modal" data-target="#fuecOcasional"  onclick="cargando_fuec(<?php echo $lco['id_contrato_ocasional'];?>)">
                                        <i class="fa fa-file-text-o mr-1"></i>FUEC
                                    </a>
                                </td>    				
                            </tr>
            			<?php } ?>
            		</tbody>
            	</table>
            </div>

        </section>

    <!-- FIN CONTENIDO -->

    <!-- ************************** --->

    <!-- MODAL CARGAR FUEC -->
            
        <div class="modal fade" id="fuecOcasional" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgb(0,0,0,.8);">
            <div class="modal-dialog" role="document" >
                <div class="modal-content">
                    
                    <div class="modal-body" id="modal-body" >
                    </div>
                </div>
            </div>
        </div>

    <!-- ************************** --->

    <!-- SCRIPT -->

        <?php include("Template/scripts.php"); ?>

        <script>

            function cargando_fuec(id_contrato_ocasional){
                /*alert(id_contrato_ocasional);*/
             
                document.getElementById('modal-body').style.display = 'block';      
                document.getElementById('modal-body').innerHTML = " <section class='loading' id='loading'></section>";
                setTimeout(function() {
                    $(".fade").fadeOut(300);                     
                    window.open("PDF/fuecContratoOcasional.php?id=" + window.btoa(id_contrato_ocasional) + "");
                },3000);
            }
        </script>

    <!-- FIN SCRIPT -->

</body>
</html>