<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Pais.php");
require_once("../Modelo/Departamento.php");
require_once("../Modelo/Ciudad.php");

$titulo = 'Actualizar Ciudad';
$redireccion = 'ciudades.php';
$icono = 'fa fa-map';

$id_ciudad = $_GET['id_ciudad'];

if (!isset($id_ciudad)) {
    
}else{

    $paises = new Pais();
    $departamentos = new Departamento();
    $listado_paises = $paises->listar();
    $ciudades = new Ciudad();
    $listarId = $ciudades->listarCiudadPorId($id_ciudad);
}

 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar ciudad</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="ciudades.php">Ciudades</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar ciudad</li>
         </ol>
    </div>

    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
	        <form action="../Controlador/actualizarCiudad.php" method="POST">
                <?php include("Template/header-form.php") ?>
    	        	<?php foreach ($listarId as $lis){ ?>

                        <!--ID MODULO-->

                            <input type="hidden" value="<?php echo $lis['id_ciudad'] ?>"  name="id_ciudad" id="id_ciudad" class="form-control">

                            <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>Pais</label>
                            </div>
                            <div class="input">
                                <select name="id_pais" id="id_pais" required="required" class="form-control" onchange="cargar(this.value,0)">
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

                        <div class="row  mt-3">
                                    <section class="label">
                                        <label>Departamento</label>
                                    </section>
                                    <section class="input">
                                        <select name="id_departamento" id="id_departamento" class="form-control" required="required">
                                        </select>
                                     </section>
                                </div>

                                <input type="hidden" name="id_departamento_act" id="id_departamento_act" value="<?php echo $lis['id_departamento'];?>">

        		        <!--NOMBRE AREA-->
            		        <div class="row mt-3 mb-4">
            		        	<div class="label">
            			            <label>Nombre Ciudad</label>
            		        	</div>
            		        	<div class="input">
            		        		<input type="text" value="<?php echo $lis['ciudad'] ?>"  name="nombre_ciudad" id="nombre_ciudad" class="form-control" required="required">
                                    <input type="hidden" value="<?php echo $lis['ciudad'] ?>"  name="nombre_ciudad_act" id="nombre_ciudad_act" class="form-control">
            		        	</div>
            		        </div>

                    <?php } ?>
                <?php include("Template/bottom-form.php") ?>
	        </form>


        </div>
    </section>


    <?php include("Template/scripts.php"); ?>
    <script>
        function cargar(id_pais,id_departamento){
          if(id_pais != ''){
              var parametros = {
                "id_pais" : id_pais,
                "id_departamento" : id_departamento
              };
              $.ajax({
                  data:  parametros,
                  url:   '../Controlador/listarDepartamentosEditar.php',
                  type:  'post',
                  beforeSend: function () {
                      //alert('envio');
                      $("#id_departamento").html("<option value='' disabled='disabled' selected='selected'>Cargando datos, por favor espere</option>");

                  },
                  success:  function (response) {
                      //alert(response);
                      $("#id_departamento").html(response);
                      
                  }
              });
          }
          
        }

    </script>
    <?php
    if($listarId[0]['id_pais'] != '0'){ 
        echo "<script>
            cargar(".$listarId[0]['id_pais'].",".$listarId[0]['id_departamento'].");
        </script>";
    }
    ?>
</body>
</html>