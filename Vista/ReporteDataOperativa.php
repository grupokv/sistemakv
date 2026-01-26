<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/General.php';
require_once '../Modelo/Usuario.php';

$usuario = new Usuario();

if ($_POST) {

    if($_POST['capacidad'] != ''){
        $capacidad = $_POST['capacidad'];
    }else{
        $capacidad = '%%';
    }

    if($_POST['tipo_vehiculo'] != '0'){
        $tipo_vehiculo = $_POST['tipo_vehiculo'];
    }else{
        $tipo_vehiculo = '%%';
    }

    if($_POST['modelo'] != ''){
        $modelo = $_POST['modelo'];
    }else{
        $modelo = '%%';
    }

    if($_POST['fecha_inicial'] != ''){
        $fecha_inicial = $_POST['fecha_inicial'];
    }else{
        $fecha_inicial = '0000-00-00';
    }

    if($_POST['fecha_final'] != ''){
        $fecha_final = $_POST['fecha_final'];
    }else{
        $fecha_final = '9999-12-31';
    }

}else{
    $capacidad = '';
    $tipo_vehiculo = '';
    $modelo = '';
    $fecha_inicial = '0000-00-00';
    $fecha_final = '9999-12-31';
}

$filtrarReporteDataOperativa = filtroDataOperativa($capacidad, $tipo_vehiculo, $modelo, $fecha_inicial, $fecha_final);

$listarProyectosDO = listarProyectosDO();

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Data Operativa</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  
  <!-- STYLES -->
  <?php include("Template/styles.php") ?>
  <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

  <style type="text/css">
    
    #inputURL{
        text-transform: none  !important; 
    }

    #iconoAlerta{
        position: relative;
        animation: animationAlert 2s infinite;
    }

    @keyframes animationAlert {
        0%   {left:0px;}
        25%  {left:50px;}
        50%  {left:0px;}
        75%  {left:-50px;}
        100% {left:0px;}
    }

  </style>
  <!-- FIN STYLES -->

</head>
<body>
    
    <!--MENU-->
    <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->
    
    <section class="home_content">
           
        <div aria-label="breadcrumb" class="mt-1"> 
             <ol class="breadcrumb" style="background-color: #fff;">
                <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Operativa</li>
             </ol>
        </div>

        <section class="col-12 p-3 mb-3" style="background-color: #fff; border-radius: 5px;">
        
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3 titulo_reporte" style="background-color: #1b2d3b; color: #fff; border-radius: 3px; width: 96%">
                <p>FILTRAR REPORTE</p>
            </div>

            <form action="" method="POST">
                <hr style="background-color:#f2f2f2; width: 98%;">
                    <div class="row p-1 m-1 d-flex justify-content-center">
                        <div class="col-sm-12 col-md-3 col-lg-3 m-1">
                            <div class="label" style="width:100%;">
                                <label><strong>CAPACIDAD</strong></label>
                            </div>
                        </div>
                        
                        
                        <div class="col-sm-12 col-md-3 col-lg-3 m-1">
                            <div class="label" style="width:100%;">
                                <label><strong>TIPO VEHÍCULO</strong></label>
                            </div>
                        </div>
                        
                        <div class="col-sm-12 col-md-3 col-lg-3 m-1">
                            <div class="label" style="width:100%;margin-left:2px">
                                <label><strong>MODELO</strong></label>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div id="servicio"></div>
                    
                    <div class="row p-1 m-1 d-flex justify-content-center">
                        <div class="col-sm-12 col-md-3 col-lg-3 m-1 ">
                            <input type="text" class="form-control form-control-sm" name="capacidad" id="capacidad" placeholder="Capacidad">
                        </div>
                        
                        <div class="col-sm-12 col-md-3 col-lg-3 m-1">
                            <select class="form-control form-control-sm selectpicker" data-live-search="true" name="tipo_vehiculo" id="tipo_vehiculo" title="SELECCIONAR">
                                <option value="AUTOMOVIL">AUTOMÓVIL</option>
                                <option value="DOBLE CABINA">DOBLE CABINA</option>
                                <option value="STATION WAGON O 4X2">STATION WAGON O 4X2</option>
                                <option value="CAMPERO 4X4">CAMPERO 4X4</option>
                                <option value="VANS">VANS</option>
                                <option value="MICROBUS">MICROBUS</option>
                                <option value="BUSETA">BUSETA</option>
                                <option value="BUS">BUS</option>
                                <option value="OTRO">OTRO</option>
                            </select> 
                        </div>
                        
                        <div class="col-sm-12 col-md-3 col-lg-3 m-1">
                            <input type="text" class="form-control form-control-sm" name="modelo" id="modelo" placeholder="Modelo">
                        </div>
                        
                    </div>

                    <div class="row p-1 m-1 d-flex justify-content-center">
                        <div class="col-sm-12 col-md-3 col-lg-3 m-1">
                            <div class="label" style="width:100%;">
                                <label><strong>FECHA INICIAL</strong></label>
                            </div>
                        </div>
                        
                        
                        <div class="col-sm-12 col-md-3 col-lg-3 m-1">
                            <div class="label" style="width:100%;">
                                <label><strong>FECHA FINAL</strong></label>
                            </div>
                        </div>
                    
                    </div>
                    
                    <div id="servicio"></div>
                    
                    <div class="row p-1 m-1 d-flex justify-content-center">
                        <div class="col-sm-12 col-md-3 col-lg-3 m-1 ">
                            <input type="text" class="form-control form-control-sm" id="fecha_inicial" name="fecha_inicial" placeholder="FECHA INICIAL">
                        </div>
                        
                        <div class="col-sm-12 col-md-3 col-lg-3 m-1">
                            <input type="text" class="form-control form-control-sm" id="fecha_final" name="fecha_final" placeholder="FECHA FINAL">
                        </div>

                    </div>
                    
                <hr style="background-color:#f2f2f2; width: 98%;">

                <div class="row p-1 d-flex justify-content-center">
                    <div class="col-lg-3 col-md-3 col-sm-10 col-xs-10">
                        <button type="submit" id="filtrar" class="btn  btn-sm btn-outline-info btn-block mr-4 mt-3"><span class="fa fa-search ml-2 mr-2"></span>Filtrar</button>
                    </div>
                </div>

            </form>

            <div id="botonesExportar" class="row p-1 mb-4 d-flex justify-content-center">
                <div class="col-lg-3 col-md-3 col-sm-10 col-xs-10">    
                    <form action="ExportarExcelDataOperativa.php" method="POST" target="_blank">
                        <input type="hidden" class="form-control" name="capacidad_do" value="<?php echo $_POST['capacidad']; ?>">
                        <input type="hidden" class="form-control" name="tipo_vehiculo_do" value="<?php echo $_POST['tipo_vehiculo']; ?>">
                        <input type="hidden" class="form-control" name="modelo_do" value="<?php echo $_POST['modelo']; ?>">
                        <input type="hidden" class="form-control" name="departamento_do" value="<?php echo $_POST['departamento']; ?>">
                        <input type="hidden" class="form-control" name="ciudad_do" value="<?php echo $_POST['ciudad']; ?>">

                        <button type="submit" class="btn btn-sm btn-outline-success btn-block mr-4 mt-4"><span class="fa fa-file-excel-o ml-2 mr-2"></span>Exportar en Excel</button>
                    </form>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-10 col-xs-10">    
                    <form action="PDF/ExportarPDFDataOperativa.php" method="POST" target="_blank">
                        <input type="hidden" class="form-control" name="capacidad_do" value="<?php echo $_POST['capacidad']; ?>">
                        <input type="hidden" class="form-control" name="tipo_vehiculo_do" value="<?php echo $_POST['tipo_vehiculo']; ?>">
                        <input type="hidden" class="form-control" name="modelo_do" value="<?php echo $_POST['modelo']; ?>">
                        <input type="hidden" class="form-control" name="departamento_do" value="<?php echo $_POST['departamento']; ?>">
                        <input type="hidden" class="form-control" name="ciudad_do" value="<?php echo $_POST['ciudad']; ?>">

                        <button type="submit" class="btn btn-sm btn-outline-danger btn-block mr-4 mt-4"><span class="fa fa-file-pdf-o ml-2 mr-2"></span>Exportar en PDF</button>
                    </form>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3 titulo_reporte" style="background-color: #1b2d3b; border-radius: 3px; width: 96%">
                <p>-</p>
            </div>

        </section>
            
        <div class="notice notice-sistemakv">
            <strong>
                <i class="fa fa-cars mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">CONSULTAR DATA OPERATIVA</b>
            </strong>
        </div>

        <div class="notice notice-sistemakv">
            <a class="btn mr-1" id="buttonsKV" onclick = "copyOnClick();">Obtener Link Externos <i class="fa fa-clone"></i></a>
            <a class="btn" id="buttonsKV" onclick = "copyOnClick2();">Obtener Link Coordinador <i class="fa fa-clone"></i></a>     
        </div>

        <section class="mb-4 table-responsive p-4" style="background-color: #fff; border-radius: 5px;">
            <table class="table table-hover text-center display" id="dataT">
                <thead style="background-color: #1b2d3b; color: #fff; ">
                    <tr style="font-size: .9rem;">
                        <th>#</th>
                        <th>NOMBRES Y APELLIDOS</th>
                        <th>TIPO DE VEHÍCULO</th>
                        <th>CAPACIDAD</th>
                        <th>MODELO</th>
                        <th>UBICACIÓN</th>
                        <th>TELÉFONO CELULAR Y FIJO</th>
                        <th>DISPONIBILIDAD HORARIA</th>
                        <th>REGISTRADO POR</th>
                        <th>FECHA DE REGISTRO</th>
                        <th>OPCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($filtrarReporteDataOperativa as $frdo){ ?>
                        <tr style="font-size: .9rem;">
                            <td><?php echo $i; ?></td>
                            <td><?php echo strtoupper($frdo['nombres_apellidos']); ?></td>
                            <td>
                                <?php 
                                    if($frdo['tipo_vehiculo'] == 'OTRO'){
                                        echo strtoupper($frdo['tipo_vehiculo']) . ' - ' . strtoupper($frdo['otro']);
                                    }else{
                                        echo strtoupper($frdo['tipo_vehiculo']);
                                    }
                                ?>
                            </td>
                            <td><?php echo strtoupper($frdo['capacidad']); ?></td>
                            <td><?php echo strtoupper($frdo['modelo']); ?></td>
                            <td>
                                <?php 
                                    if($frdo['ubicacion_vehiculo'] != ''){
                                        echo strtoupper($frdo['ubicacion_vehiculo']) . ' DE ' . strtoupper($frdo['ciudad']) . ' - ' . strtoupper($frdo['direccion_ubicacion']); 
                                    }else{
                                        echo "NO REGISTRA";
                                    }
                                ?>
                            </td>
                            <td><?php echo $frdo['telefono_celular'] . ' -' . $frdo['telefono_fijo']; ?></td>
                            <td>
                                <?php 
                                    $fechaInicial = explode(":", $frdo['disponibilidad_horario_inicial']);
                                    $fechaFinal = explode(":", $frdo['disponibilidad_horario_final']);

                                    if ($fechaInicial[0] >= '00' && $fechaInicial[0] <= '11') {
                                        $horarioInicial = 'AM';
                                    }else{
                                        $horarioInicial = 'PM';
                                    }

                                    if ($fechaFinal[0] >= '00' && $fechaFinal[0] <= '11') {
                                        $horarioFinal = 'AM';
                                    }else{
                                        $horarioFinal = 'PM';
                                    }

                                    if($frdo['disponibilidad_horario_inicial'] != '00:00:00' && $frdo['disponibilidad_horario_final'] != '00:00:00'){
                                        echo $fechaInicial[0] . ':' . $fechaInicial[1] . ' ' .  '<strong>' . $horarioInicial . '</strong>' . ' A ' . $fechaFinal[0] . ':' . $fechaFinal[1] . ' ' . '<strong>' . $horarioFinal . '</strong>'; 
                                    }else{
                                        echo "NO REGISTRA";
                                    }
                                ?>
                            </td>
                           <!--  <td>
                                <?php 
                                    $listarUsuId = $usuario->listarUsuarioPorId($frdo['id_referenciador']);
                                    echo $listarUsuId[0]['nombre']; 
                                ?>
                            </td> -->
                            <td>
                                <?php 
                                    $listarUsuId = $usuario->listarUsuarioPorId($frdo['id_usuario_registro']);
                                    if ($frdo['id_usuario_registro'] == 0) {
                                        echo " EXTERNO ";
                                    }else{
                                        echo $listarUsuId[0]['nombre']; 
                                    }
                                    
                                ?>
                            </td>
                            <td><?php echo $frdo['fecha_registro']; ?></td>
                            <td>
                                <button onclick="mostrarInfoModal(<?php echo $frdo['id_data_operativa']; ?>);" style="margin: 0px; padding: 0px 4px 0px 4px; " class="btn btn-outline-success"><span class="fa fa-search"></span></button>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php } ?>
                </tbody>
            </table>
            
            <p id="txt_knoband" style="visibility: hidden;"><?php echo "https://www.sistemakv.com/Vista/data_vehiculos_externos.php?id_referenciador=". base64_encode($_SESSION['id_usuario']); ?></p>
            <p id="txt_knoband2" style="visibility: hidden;"><?php echo "https://www.sistemakv.com/Vista/data_coordinador_interno.php?id_referenciador=". base64_encode($_SESSION['id_usuario']); ?></p>

        </section>

    </section>

    <!-- FIN CONTENIDO -->

    <!-- MODAL ALERT COPY LINK -->
        <div class="modal fade" id="alertaLinkCopiado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgb(0,0,0,.8);">
            <div class="modal-dialog" role="document" >
                <div class="modal-content">
                    
                    <div class="modal-body text-center" id="modal-body">
                        <div class="col-12" style="height: auto;">
                            <i style="color: #25b01e; font-size: 6rem;" id="iconoAlerta" class="fa fa-check-circle-o"></i>
                            <h4 class="modal-title" style="color: #a1a1a1; "><strong>LINK COPIADO.</strong></h4>
                        </div> 
                        <div class="col-12 mt-1">
                            <p>Enhorabuena! El link se ha copiado correctamente.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- MODAL ALERT COPY LINK -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-12" id="mainContent">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- script -->
    <?php include("Template/scripts.php"); ?>

    <script type="text/javascript">

        /*function agregarFila(index) {

            var nFilas = $("#input-group tr").length;

            var htmlTags = '<tr><td style="border: hidden; padding: 4px;"><div class="row"><i class="fa fa-cube mr-3 ml-3" style="font-size: 1.7rem; color: #1b2d3b;"></i><p class="mr-2" style="font-size: .8rem;"><strong>NOMBRE PROYECTO</strong></p> <input class="form-control col-7" type="text" name="nombre_proyecto" required/></div></td></tr>';
      
            $('#input-group').append(htmlTags);

            soloNumeros();

        }*/


        $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '< Ant',
            nextText: 'Sig >',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
            weekHeader: 'Sm',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };

        $( function() {

            $("#fecha_inicial").datepicker({ dateFormat:'yy-mm-dd'});
            $("#fecha_final").datepicker({ dateFormat:'yy-mm-dd'});
        } );

        function copyOnClick() {
            var tempInput = document.createElement("input"); 
            tempInput.value = document.getElementById("txt_knoband").innerHTML;
            tempInput.id = 'inputURL';
            console.log(tempInput);
            //console.log(tempInput);
            document.body.appendChild(tempInput); 
            tempInput.select(); 
            document.execCommand("copy"); 
            document.body.removeChild(tempInput); 
            $("#alertaLinkCopiado").modal("show");   
            setTimeout(function(){
            $("#alertaLinkCopiado").modal("hide");  
            }, 3500);
        }

        function copyOnClick2() {
            var tempInput = document.createElement("input"); 
            tempInput.value = document.getElementById("txt_knoband2").innerHTML;
            tempInput.id = 'inputURL';
            console.log(tempInput);
            //console.log(tempInput);
            document.body.appendChild(tempInput); 
            tempInput.select(); 
            document.execCommand("copy"); 
            document.body.removeChild(tempInput); 
            $("#alertaLinkCopiado").modal("show");   
            setTimeout(function(){
            $("#alertaLinkCopiado").modal("hide");  
            }, 3500);
        }

        function mostrarInfoModal(id_data_operativa){

            var parametros = {
                "id_data_operativa" : id_data_operativa
            };


            $.ajax({
                data: parametros,
                url: '../Controlador/listarDataOperativaID.php',
                type: 'POST',
                beforeSend: function () {
                },
                success:  function (response) {
                    $("#exampleModal").modal("show"); 
                    document.getElementById("mainContent").innerHTML = (response);
                }
            });
        }

 /*       $( "#filtrar" ).click(function() {
           document.getElementById('botonesExportar').style.display = ''
        });
*/

    </script>

</body>

</html>