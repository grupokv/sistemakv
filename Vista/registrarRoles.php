<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Modulo.php");

/* VARIABLES MENU*/
$titulo = 'Asignar Permisos';
$redireccion = 'usuarios.php';
$icono = 'fa fa-user-o';


$modulo = new Modulo();
$listarModulo = $modulo->listar();

$id_usu = $_GET['us'];


 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Perfil</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="Areas.php">Rol</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar roles</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="formulario mb-5">

            <form action="../Controlador/registrarRol.php" method="POST">
                <?php include("Template/header-form.php"); ?>
                <button type="button" class="btn btn-success " name="check_all" id="check_all" value="1" onclick="seleccionarTodos()">Seleccionar Todos</button>
                        <hr>   
                        <input type="hidden" name="id_usu" value="<?php echo $_GET['us']?>">
                       
                        <table class="table table-sm text-center">
                            <thead style="border: hidden;">
                                <tr>
                                    <th>Modulo</th>
                                    <th>Consultar</th>
                                    <th>Editar</th>
                                    <th>Agregar</th>
                                    <th>Eliminar</th>
                                    <th>Seleccionar Fila</th>
                                </tr>
                            </thead>
                           
                                <tbody style="border: hidden;">
                                    <?php $i = 0;?>
                                    <?php foreach ($listarModulo as $lm){ ?>
                                    <tr>
                                        <td>
                                            <p name = "nombre_modulo" id="nombre_modulo"><?php echo $lm['nombre_modulo'] ?></p>
                                        </td>
                                        <td>
                                             <label class="switch">
                                                <input type="checkbox" name="consulta_<?php echo $lm['id_modulo'];?>" id="consulta<?php echo $i;?>" value="1">
                                                 <span class="slider"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" name="edicion_<?php echo $lm['id_modulo'];?>" id="edicion<?php echo $i;?>" value="1">
                                                <span class="slider"></span>
                                            </label>      
                                        </td>
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" name="agregacion_<?php echo $lm['id_modulo'];?>" id="agregacion<?php echo $i;?>" value="1">
                                                <span class="slider"></span>
                                            </label>   
                                        </td>
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" name="eliminacion_<?php echo $lm['id_modulo'];?>" id="eliminacion<?php echo $i;?>" value="1">
                                                <span class="slider"></span>
                                            </label>   
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-info" style="margin: 0px; padding: 0px 4px 0px 4px;" name="check_row" id="check_row<?php echo $i;?>" value="<?php echo $i.'|1' ?>" onclick="seleccionarModulo(this.value)"><span class="fa fa-check-square-o "></span></button>
                                        </td>
                                    </tr>
                                    <?php $i++; } ?>
                                </tbody>

                                
                                <input type="hidden" id="cant_modulos" value="<?php echo $i;?>">
                            </table>
                <?php include("Template/bottom-form.php"); ?>
            </form>
        </div>
    </section>


    <?php include("Template/scripts.php"); ?>
    <script type="text/javascript">
            $( function() {
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
            }

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