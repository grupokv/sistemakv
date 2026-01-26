<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Pais.php");
require_once("../Modelo/Departamento.php");

$titulo = 'Actualizar Departamento';
$redireccion = 'departamentos.php';
$icono = 'fa fa-map';

$id_departamento = $_GET['id_departamento'];

if (!isset($id_departamento)) {
    
}else{
    $paises = new Pais();
    $listado_paises = $paises->listar();
    $departamento = new Departamento();
    $listarId = $departamento->listarPorId($id_departamento);
}

 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar departamento</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="departamentos.php">Departamentos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar departamento</li>
         </ol>
    </div>

    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
	        <form action="../Controlador/actualizarDepartamento.php" method="POST">
                <?php include("Template/header-form.php") ?>
    	        	<?php foreach ($listarId as $lis){ ?>

                        <!--ID MODULO-->

                            <input type="hidden" value="<?php echo $lis['id_departamento'] ?>"  name="id_departamento" id="id_departamento" class="form-control">

                            <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>Pais</label>
                            </div>
                            <div class="input">
                                <select name="id_pais" id="id_pais" required="required" class="form-control">
                                    <option value="">Seleccione</option>
                                    <?php foreach($listado_paises as $lp){ ?>
                                    <option value="<?php echo $lp['id_pais'];?>" <?php if ($lis['id_pais'] == $lp['id_pais']){ ?> selected="selected" <?php } ?> >
                                        <?php echo $lp['pais'];?>
                                    </option>
                                    <?php } ?> 
                                </select>
                                <input type="hidden" name="id_pais_act" id="id_pais_act" value="<?php echo $lis['id_pais'];?>">
                            </div>
                        </div>

        		        <!--NOMBRE AREA-->
            		        <div class="row mt-3 mb-4">
            		        	<div class="label">
            			            <label>Nombre Departamento</label>
            		        	</div>
            		        	<div class="input">
            		        		<input type="text" value="<?php echo $lis['departamento'] ?>"  name="nombre_departamento" id="nombre_departamento" class="form-control" required="required">
                                    <input type="hidden" value="<?php echo $lis['departamento'] ?>"  name="nombre_departamento_act" id="nombre_departamento_act" class="form-control">
            		        	</div>
            		        </div>

                    <?php } ?>
                <?php include("Template/bottom-form.php") ?>
	        </form>


        </div>
    </section>


    <?php include("Template/scripts.php"); ?>
</body>
</html>