<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Empleado.php");

$empleado = new Empleado();
$listarSS = $empleado->listarSS();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar SS Empleados</title>
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
            <ol class="breadcrumb" style="background: #fff;">
                <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                <li class="breadcrumb-item " aria-current="page"><a href="seguridadSocialEmpleados.php">Seguridad Social</a></li>
                <li class="breadcrumb-item active" aria-current="page">Registrar Seguridad Social</li>
            </ol>
        </div>

        <div class="notice notice-sistemakv">
            <strong><i class="fa fa-map mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">REGISTRAR SEGURIDAD SOCIAL</b></strong>
        </div>

        <section class="form-usuarios mb-4">
            <div class="formulario mb-3">
                <form action="../Controlador/registrarSSEmpleado.php" method="POST" enctype="multipart/form-data">
                        
                    <section class="d-flex justify-content-center mt-5">
                        <button type="button" class="btn btn-outline-info mr-2" onclick="agregarFila();"><span class="fa fa-plus"></span> Agregar Fila</button>    
                        <button type="button" class="btn btn-outline-danger" onclick="eliminarFila();"><span class="fa fa-trash"></span> Eliminar Fila</button>    
                    </section>

                    <hr>

                    <table id="input-group" class="table">
                        <thead>
                            <tr>
                                <th style="border:none;"></th>
                                <th style="border:none;">NOMBRE DE DOCUMENTO</th>
                                <th style="border:none;">DOC SEGURIDAD SOCIAL</th>
                                <th style="border:none;">MES</th>
                                <th width="100" style="border:none;">AÑO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border:none;"><span style="font-size: 1.6rem;" class="fa fa-file-text"></span></td>
                                <td style="border:none;"><input type="text" class="form-control form-control-sm" name="nombre_doc_ss[]" id="nombre_doc_ss"></td>
                                <td style="border:none;"><input type="file" class="form-control form-control-sm" name="doc_ss[]" id="doc_ss"></td>
                                <td style="border:none;">
                                    <select class="form-control form-control-sm" data-live-search="true" name="mes[]" id="mes">
                                        <option value="0">SELECCIONAR</option>
                                        <option value="01">ENERO</option>
                                        <option value="02">FEBRERO</option>
                                        <option value="03">MARZO</option>
                                        <option value="04">ABRIL</option>
                                        <option value="05">MAYO</option>
                                        <option value="06">JUNIO</option>
                                        <option value="07">JULIO</option>
                                        <option value="08">AGOSTO</option>
                                        <option value="09">SEPTIEMBRE</option>
                                        <option value="10">OCTUBRE</option>
                                        <option value="11">NOVIEMBRE</option>
                                        <option value="12">DICIEMBRE</option>
                                    </select>
                                </td style="border:none;">
                                <td style="border:none;">
                                    <input type="text" name="anio[]" id="anio" class="anio_ss form-control form-control-sm">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <section class="col-12 mt-4 mb-3 d-flex justify-content-center">
                        <a href="seguridadSocialEmpleados.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
                        <button type="submit" class="btn btn-outline-info col-3">Registrar</button>
                    </section>

                </form>
            </div>
        </section>

    </section>


    <?php include("Template/scripts.php"); ?>

    <script>
        
        $( function() {
            $('.anio_ss').yearpicker(); 
        }); 


        function eliminarFila() {
            var nFilas = $("#input-group tr").length;
            var celdaAnterior = parseFloat(nFilas) - parseFloat(2);
            if(nFilas > 2){
                $("#input-group tr:last").remove();
            }
        }

        function agregarFila(index) {


            var nFilas = $("#input-group tr").length;

            var htmlTags = '<tr><td style="border:none;"><i style="font-size: 1.6rem;" class="fa fa-file-text"></i></td><td style="border:none;"><input type="text" class="form-control form-control-sm" name="nombre_doc_ss[]" id="nombre_doc_ss"></td><td style="border:none;"><input type="file" class="form-control form-control-sm" name="doc_ss[]" id="doc_ss"></td><td style="border:none;"><select class="form-control form-control-sm" data-live-search="true" name="mes[]" id="mes"><option value="0">SELECCIONAR</option><option value="01">ENERO</option><option value="02">FEBRERO</option><option value="03">MARZO</option><option value="04">ABRIL</option><option value="05">MAYO</option><option value="06">JUNIO</option><option value="07">JULIO</option><option value="08">AGOSTO</option><option value="09">SEPTIEMBRE</option><option value="10">OCTUBRE</option><option value="11">NOVIEMBRE</option><option value="12">DICIEMBRE</option></select></td style="border:none;"><td style="border:none;"><input type="text" name="anio[]" id="anio" class="anio_ss form-control form-control-sm"></td></tr>';
      
            $('#input-group').append(htmlTags);
            $('.anio_ss').yearpicker(); 
        }
            
    </script>
</body>
</html>