<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Rol.php");
require_once("../Modelo/Modulo.php");

$titulo = 'Actualizar Permisos';
$redireccion = 'usuarios.php';
$icono = 'fa fa-user-o';


$rol = new Rol();
$modulo = new Modulo();


$id_usuario = $_GET['us'];

if (!isset($id_usuario)) {
    
}else{
    $listarM = $modulo->listar();
    $ModulosUsuario = $rol->listarPorId($id_usuario);

    //print_r($ModulosUsuario);

    $modulos = array();
    for ($i=0; $i < count($listarM) ; $i++) { 
        array_push($modulos, $listarM[$i]['id_modulo']);
    }

    $misModulos = array();
    for ($i=0; $i < count($ModulosUsuario); $i++) { 
        array_push($misModulos, $ModulosUsuario[$i]['id_modulo']);
    }

    $modulos = array_diff($modulos, $misModulos);

}

 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Permisos</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

    <style type="text/css">

        th{
            border:none !important;
        }
        td{
            border:none !important;
        }

        .main-container-modulos{
            width: 95%; 
            height: 400px; 
            margin-top: 10px; 
            margin-left: 10px;  
            border: 2px solid #f2f2f2; 
            overflow-y: scroll; 
            scrollbar-color: #1b2d3b #fff;
            scrollbar-width: thin;
        }

        .collapsePermisosCerrar, .collapsePermisosAbrir{
            cursor: pointer;
        }

        .seccionPermisos{
            width: 100%;
            height: auto;
            padding: 8px 10px 8px 10px;
            background: #f7f7f7;
            border-bottom: 4px solid #f2f2f2;
            display: none;
        }

        #permisos{
            height: 40px; 
            margin-top: 10px; 
            color: #404040;
            align-items: center;
        }
    </style>

</head>
<body>

    <!--MENU-->
        <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

<section class="home_content">

    <!-- CONTENIDO -->
    <div aria-label="breadcrumb" class="mt-1"> 
        <ol class="breadcrumb" style="background: #fff;">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="usuarios.php">Usuarios</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar usuarios</li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar Permisos</li>
        </ol>
    </div>

    <form action="../Controlador/actualizarRol.php" method="POST">

        <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_GET['us'] ?>">
        <section class="form-usuarios mt-1 ">

            <div class="row"style="width: 100%;">

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 d-flex justify-content-center mt-2 mb-2">
                    <section style="width: 100%; height: 490px; border: 4px solid #eeeeee; ">
                        <div class="col-12 text-center" style="width: 95%; border-radius: 5px 5px 0 0; padding: 10px 0 0 0; margin-left: 10px; margin-top: 10px; height: 50px; background: #1b2d3b; color: #fff;">
                            <h5><strong>MODULOS</strong></h5>
                        </div>
                        <div class="col-12 text-center" style="width: 95%; border-radius: 0 0 5px 5px; margin-left: 10px; height: 5px; background: #4c81a8; color: #fff;"></div>
                        <div class="main-container-modulos col-12">
                            <?php foreach ($modulos as $m){ 
                                $listarPorId = $modulo->listarPorId($m); ?>

                                <div class="row" style="height: 40px; margin-top: 10px; border-bottom: 2px solid #f2f2f2; color: #404040;">
                                    <section class="col-9"><?php echo $listarPorId[0]['nombre_modulo'] ?></section>
                                    <section class="col-2 d-flex justify-content-end">
                                        <label class="switch">
                                            <input type="checkbox" name="check_row" id="check_row<?php echo $listarPorId[0]['id_modulo'];?>" value="<?php echo $listarPorId[0]['id_modulo'].'|1' ?>" onclick="seleccionarModulo(this.value)">
                                            <span class="slider"></span>
                                        </label>
                                    </section>
                                    <section class="col-1">
                                        <label id="collapsePermisosCerrar_<?php echo $listarPorId[0]['id_modulo']?>" class="fa fa-chevron-down collapsePermisosCerrar" style="display: none;">
                                            <input type="button" value="<?php echo $listarPorId[0]['id_modulo']; ?>" onclick="cerrarPermisos(this.value);" style="display: none;">
                                        </label>
                                        <label id="collapsePermisosAbrir_<?php echo $listarPorId[0]['id_modulo']?>" class="fa fa-chevron-right collapsePermisosAbrir">
                                            <input type="button" value="<?php echo $listarPorId[0]['id_modulo']; ?>" onclick="deplegarPermisos(this.value); validacionCheckPermisos(this.value);" style="display: none;">
                                        </label>
                                    </section>
                                </div>

                                <div id="seccionPermisos_<?php echo $listarPorId[0]['id_modulo']?>" class="seccionPermisos col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="row" id="permisos">  
                                        <section class="col-9"><i class="fa fa-search ml-3 mr-3" style="color: #eb7e17; font-size: 1.3rem;"></i><strong> Consultar </strong></section>
                                        <section class="col-3 d-flex justify-content-end">
                                            <label class="switch">
                                                <input type="checkbox" name="consulta_<?php echo $listarPorId[0]['id_modulo'];?>" id="consulta<?php echo $listarPorId[0]['id_modulo'];?>" value="1">
                                                 <span class="slider"></span>
                                            </label>
                                        </section>
                                    </div>
                                    <div class="row" id="permisos">  
                                        <section class="col-9"><i class="fa fa-trash ml-3  mr-3" style="color: #cf172c; font-size: 1.3rem;"></i><strong> Eliminar </strong></section>
                                        <section class="col-3 d-flex justify-content-end">
                                            <label class="switch">
                                                <input type="checkbox" name="eliminacion_<?php echo $listarPorId[0]['id_modulo'];?>" id="eliminacion<?php echo $listarPorId[0]['id_modulo'];?>" value="1" >
                                                <span class="slider"></span>
                                            </label>   
                                        </section>
                                    </div>
                                    <div class="row" id="permisos">  
                                        <section class="col-9"><i class="fa fa-plus-circle ml-3  mr-3" style="color: #12a119; font-size: 1.3rem;"></i><strong> Agregar </strong></section>
                                        <section class="col-3 d-flex justify-content-end">
                                            <label class="switch">
                                                <input type="checkbox" name="agregacion_<?php echo $listarPorId[0]['id_modulo'];?>" id="agregacion<?php echo $listarPorId[0]['id_modulo'];?>" value="1">
                                                <span class="slider"></span>
                                            </label> 
                                        </section>
                                    </div>
                                    <div class="row mb-3" id="permisos">  
                                        <section class="col-9"><i class="fa fa-pencil-square-o ml-3  mr-3" style="color: #2065ba; font-size: 1.3rem;"></i><strong> Actualizar </strong></section>
                                        <section class="col-3 d-flex justify-content-end">
                                            <label class="switch">
                                                <input type="checkbox" name="edicion_<?php echo $listarPorId[0]['id_modulo'];?>" id="edicion<?php echo $listarPorId[0]['id_modulo'];?>" value="1">
                                                <span class="slider"></span>
                                            </label> 
                                        </section>
                                    </div>
                                </div>

                            <?php } ?>
                        </div>
                    </section>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 main-container-misModulos mt-2 mb-2">
                    <section style="width: 100%; height: 490px; border: 4px solid #eeeeee; ">
                        <div class="col-12 text-center" style="width: 95%; border-radius: 5px 5px 0 0; padding:  10px 0 0 0; margin-left: 10px; margin-top: 10px; height: 50px; background: #1b2d3b; color: #fff;">
                            <h5><strong>MODULOS DEL USUARIO</strong></h5>
                        </div>
                        <div class="col-12 text-center" style="width: 95%; border-radius: 0 0 5px 5px; margin-left: 10px; height: 5px; background: #4c81a8; color: #fff;"></div>
                            <div class="main-container-modulos col-12">
                                <?php foreach ($ModulosUsuario as $mu){ ?>
                                    <div class="row" style="height: 40px; margin-top: 10px; border-bottom: 2px solid #f2f2f2; color: #404040;">
                                        <section class="col-9"><?php echo $mu['nombre_modulo'] ?></section>

                                        <section class="col-2 d-flex justify-content-end">
                                            <label class="switch">
                                                <input type="checkbox" name="check_row" id="check_row<?php echo $mu['id_modulo'];?>"  onclick="seleccionarModulo(this.value)"  <?php if(($mu['consulta'] == 1) || ($mu['eliminacion'] == 1) || ($mu['agregacion'] == 1) || ($mu['edicion'] == 1)){?> value="<?php echo $mu['id_modulo'] . '|0' ?>" checked <?php }else {?> value="<?php echo $mu['id_modulo'].'|1' ?>" <?php } ?>>
                                                <span class="slider"<?php if(($mu['consulta'] == 1) && ($mu['eliminacion'] == 1) && ($mu['agregacion'] == 1) && ($mu['edicion'] == 1)){?> style="box-shadow: 0 0 0 2px #56bf2c,0 0 2px #56bf2c;" <?php }else { ?> style="box-shadow: 0 0 0 2px #377a1c,0 0 2px #377a1c; background: #377a1c; " <?php } ?>></span>
                                            </label>
                                        </section>

                                        <section class="col-1">
                                            <label id="collapsePermisosCerrar_<?php echo $mu['id_modulo']?>" class="fa fa-chevron-down collapsePermisosCerrar" style="display: none;">
                                                <input type="button" value="<?php echo $mu['id_modulo']; ?>" onclick="cerrarPermisos(this.value);" style="display: none;">
                                            </label>
                                            <label id="collapsePermisosAbrir_<?php echo $mu['id_modulo']?>" class="fa fa-chevron-right collapsePermisosAbrir">
                                                <input type="button" value="<?php echo $mu['id_modulo']; ?>" onclick="deplegarPermisos(this.value); validacionCheckPermisos(this.value);" style="display: none;">
                                            </label>
                                        </section>
                                    </div>

                                     <div id="seccionPermisos_<?php echo $mu['id_modulo']?>" class="seccionPermisos col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="row" id="permisos">  
                                            <section class="col-9"><i class="fa fa-search ml-3 mr-3" style="color: #eb7e17; font-size: 1.3rem;"></i><strong> Consultar </strong></section>
                                            <section class="col-3 d-flex justify-content-end">
                                                <label class="switch">
                                                    <input type="checkbox" name="consulta_<?php echo $mu['id_modulo'];?>" id="consulta<?php echo $mu['id_modulo'];?>" value="<?php echo $mu['consulta'] ?>" <?php if($mu['consulta'] == 1){?> checked <?php } ?>>
                                                     <span class="slider"></span>
                                                </label>
                                            </section>
                                        </div>
                                        <div class="row" id="permisos">  
                                            <section class="col-9"><i class="fa fa-trash ml-3  mr-3" style="color: #cf172c; font-size: 1.3rem;"></i><strong> Eliminar </strong></section>
                                            <section class="col-3 d-flex justify-content-end">
                                                <label class="switch">
                                                    <input type="checkbox" name="eliminacion_<?php echo $mu['id_modulo'];?>" id="eliminacion<?php echo $mu['id_modulo'];?>" value="<?php echo $mu['eliminacion'] ?>" <?php if($mu['eliminacion'] == 1){?> checked <?php } ?>>
                                                    <span class="slider"></span>
                                                </label>   
                                            </section>
                                        </div>
                                        <div class="row" id="permisos">  
                                            <section class="col-9"><i class="fa fa-plus-circle ml-3  mr-3" style="color: #12a119; font-size: 1.3rem;"></i><strong> Agregar </strong></section>
                                            <section class="col-3 d-flex justify-content-end">
                                                <label class="switch">
                                                    <input type="checkbox" name="agregacion_<?php echo $mu['id_modulo'];?>" id="agregacion<?php echo $mu['id_modulo'];?>" value="<?php echo $mu['agregacion'] ?>" <?php if($mu['agregacion'] == 1){?> checked <?php } ?>>
                                                    <span class="slider"></span>
                                                </label> 
                                            </section>
                                        </div>
                                        <div class="row mb-3" id="permisos">  
                                            <section class="col-9"><i class="fa fa-pencil-square-o ml-3  mr-3" style="color: #2065ba; font-size: 1.3rem;"></i><strong> Actualizar </strong></section>
                                            <section class="col-3 d-flex justify-content-end">
                                                <label class="switch">
                                                    <input type="checkbox" name="edicion_<?php echo $mu['id_modulo'];?>" id="edicion<?php echo $mu['id_modulo'];?>" value="<?php echo $mu['edicion'] ?>" <?php if($mu['edicion'] == 1){?> checked <?php } ?>>
                                                    <span class="slider"></span>
                                                </label> 
                                            </section>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                    </section>
                </div>

            </div>

        </section>

        <section class="col-12 d-flex justify-content-center" style="padding: 8px 18px 8px 2px; margin-top: 20px; margin-bottom: 20px; background-color: #fff;"> 
            <a type="button" href="usuarios.php" class="col-2 btn btn-outline-danger mr-2">Cancelar</a>
            <button type="submit" class="col-2 btn btn-outline-success">Guardar</button>
        </section>

    </form>

</section>

    <?php include("Template/scripts.php"); ?>
    <script type="text/javascript">

        function deplegarPermisos(value_id){    
            $('#seccionPermisos_'+value_id).fadeIn(400);
            document.getElementById('seccionPermisos_'+value_id).style.display = 'block';
            document.getElementById('collapsePermisosAbrir_'+value_id).style.display = 'none';
            document.getElementById('collapsePermisosCerrar_'+value_id).style.display = 'flex';
        }

        function cerrarPermisos(value_id){
            document.getElementById('seccionPermisos_'+value_id).style.display = 'none';
            document.getElementById('collapsePermisosAbrir_'+value_id).style.display = 'flex';
            document.getElementById('collapsePermisosCerrar_'+value_id).style.display = 'none';
        }

        function validacionCheckPermisos(value_id) {
            var consultar = document.getElementById('consulta'+value_id).value;
            var editar = document.getElementById('edicion'+value_id).value;
            var agregar = document.getElementById('agregacion'+value_id).value;
            var eliminar = document.getElementById('eliminacion'+value_id).value;

            $("#consulta"+value_id).on("click", function() {
                if( ($('#consulta'+value_id).prop('checked'))){
                    document.getElementById('check_row'+value_id).checked = true;
                    document.getElementById('check_row'+value_id).value = value_id+'|0';
                }else{
                    document.getElementById('check_row'+value_id).checked = false;
                    document.getElementById('check_row'+value_id).value = value_id+'|1';
                }
            });

        }

        /*   $( function() {
            $( "#id_modulo" ).selectmenu();
        } );

            function seleccionarTodos(){
                var boton = document.getElementById('check_all').value;
                var cant = document.getElementById('cant_modulos').value;
                if (boton == 1) {
                    var i = 0;
                    for(i=0;i<cant;i++){
                    document.getElementById('consulta'+i).checked = true;
                    document.getElementById('edicion'+i).checked = true;
                    document.getElementById('agregacion'+i).checked = true;
                    document.getElementById('eliminacion'+i).checked = true;
                    }
                    document.getElementById('check_all').value = 0;
                    document.getElementById('check_all').innerHTML = 'Quitar todos';
                    document.getElementById('check_all').className = 'btn btn-primary';
                }else{
                    var a = 0;
                    for(a=0;a<cant;a++){
                      document.getElementById('consulta'+a).checked = false;
                      document.getElementById('edicion'+a).checked = false;
                      document.getElementById('agregacion'+a).checked = false;
                      document.getElementById('eliminacion'+a).checked = false;
                    }
                      document.getElementById('check_all').value = 1;
                     document.getElementById('check_all').innerHTML = 'Seleccionar todos';
                     document.getElementById('check_all').className = 'btn btn-success';
                }
            }*/

            function seleccionarModulo(num){
                var dividir = num.split('|');
                var fila = dividir[0];
                var estado = dividir[1];
                if(estado == 1){
                    document.getElementById('consulta'+fila).checked = true;
                    document.getElementById('edicion'+fila).checked = true;
                    document.getElementById('agregacion'+fila).checked = true;
                    document.getElementById('eliminacion'+fila).checked = true;
                    document.getElementById('check_row'+fila).value = fila+'|0';
                } else {
                    document.getElementById('consulta'+fila).checked = false;
                    document.getElementById('edicion'+fila).checked = false;
                    document.getElementById('agregacion'+fila).checked = false;
                    document.getElementById('eliminacion'+fila).checked = false;
                    document.getElementById('check_row'+fila).value = fila+'|1';
                }

            }

    </script>
</body>
</html>