<?php
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Encuesta.php");
require_once("../Modelo/General.php");

$id = $_GET['id'];

$encuesta = new Encuesta();
$listado = $encuesta->listarPreguntasPorIdEncuesta($id);

$modulo = 87;
$permisos = permisos($modulo,$_SESSION['id_usuario']);

if(count($permisos) < 1){
	echo ("<script LANGUAGE='JavaScript'>
    window.location.href='https://www.sistemakv.com/';
    </script>");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Encuesta</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- styles -->
  <?php include("Template/styles.php") ?>
  <style type="text/css">
    

    .barra-principal{
      background-color: #5e99b1;
      width: auto;
    }

    .botones_principal{
      display: flex;
      justify-content: flex-end;
    }

    .boton-registro{
      background-color: #fff; 
      height: 40px; 
      margin-top: 10px; 
      margin-bottom: 10px; 
      color: #00a0df;
    }

    .img-frontal{
      width: 100px;
    }

    .img-trasera{
      width: 100px;
    }

    .img-izq{
      width: 100px;
    }

    .img-der{
      width: 100px;
    }

    @media (max-width: 760px){
      
        .fa-plus{
           display: none;
        }

        .titulo_principal{
          text-align: center;
        }

        .botones_principal{
          display: flex;
          justify-content: center;
        }

        .img-frontal{
          width: 100%;
        }

        .img-trasera{
          width: 100%;
        }

        .img-izq{
          width: 100%;
        }

        .img-der{
          width: 100%;
        }
    }

  </style>
  <!--fin  styles -->
</head>
<body>

    <!--MENU-->
       <?php include("Template/menu.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->
    
    <!-- CONTENIDO -->
    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
	    <li class="breadcrumb-item " aria-current="page"><a href="encuesta.php">Encuesta</a></li>
            <li class="breadcrumb-item active" aria-current="page">Preguntas</li>
         </ol>
    </div>
    
    <hr style="background-color:#5e99b1; ">
    <div class="row barra-principal">

      	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 titulo_principal">
      		  <h2 class="mt-2" style="color: #fff; line-height: 25px;"><span class="fa fa-pencil-square-o icono-principal ml-2" style="border: 2px solid #fff; border-radius: 50%;  font-size:0.8em; padding: 9px;"></span> Preguntas Encuesta</h2>
      	</div>
      	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 botones_principal">
      		<?php if($permisos[0]['agregacion'] == 1){ ?>
            <a href="nuevaPregunta.php?id=<?php echo $id;?>" class="btn boton-registro ml-1 mr-1"><span class="fa fa-plus ml-2 mr-2"></span>Nueva Pregunta</a>
        	<?php } ?>
        </div>
    </div>

    <hr style="background-color:#5e99b1;">
      <div class="mt-2 p-4 table-responsive">
    	  <table  id="dataT" class="table table-hover table-sm display" style="width:100%">
      		<thead>
      			<tr>
              <th>ID</th>
              <th>PREGUNTA</th>
			  <th>TIPO PREGUNTA</th>
              <th>CANT. RESPUESTAS</th>
      				<th>OPCIONES</th>
      			</tr>
      		</thead>
    		  <tbody>
            <?php foreach ($listado as $lv){ ?>
              <tr>
                  <td><?php echo $lv['id_pregunta']; ?></td>
                  <td><?php echo $lv['detalle']; ?></td>
				  <td>
				  <?php $tipo = $encuesta->listarPorTipoPregunta($lv['id_tipo_pregunta']); echo $tipo[0]['detalle']; ?></td>
                  <td>
				<?php
				$respuestas = $encuesta->listarRespuestasPorPregunta($lv['id_pregunta']);
				?>
				<?php if(($lv['id_tipo_pregunta'] != '3')and($lv['id_tipo_pregunta'] != '6')){ ?>
				<a href="respuestasEncuesta.php?datos=<?php echo $lv['id_encuesta'].'_'.$lv['id_pregunta'].'_'.$lv['id_tipo_pregunta'];?>"><?php echo count($respuestas);?></a>
				<?php } else { ?>
				<?php echo count($respuestas);?>
				<?php } ?>
		  </td>
                         
                  <td>
                        
			<!-- Actualizar -->
			<?php if($permisos[0]['edicion'] == 1){ ?>
                          <a href="actualizarPregunta.php?id=<?php echo $lv['id_pregunta']; ?>" class="btn btn-outline-info"  style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-edit"></span></a>
                         <?php } ?>

                      <!--Consultar Documentos-->
                      <?php if($permisos[0]['consulta'] == 1){ ?>
                        <a href="javascript:void(0)" class="btn btn-outline-warning"  style="margin: 0px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#visualizar" onclick="vista(<?php echo $lv['id_pregunta'];?>)"><span class="fa fa-search"></span></a>
                      <?php } ?>
                                            
                  </td>
                      
              </tr>
            <?php } ?>
    		  </tbody>
    	  </table>
      </div>

      <!-- Vista Previa -->
        <div class="modal fade" id="visualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog " role="document">
            <div class="modal-content f-flex justify-content-center">
              <div class="modal-header">
                  <h5 class="modal-title " id="exampleModalLabel">Vista Previa</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <section id="contenido_modal" name="contenido_modal">

                  </section>
              </div>
              <div class="modal-footer">
              <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>

	
  <!-- script -->
  <?php include("Template/scripts.php"); ?>

    <script type="text/javascript">

function vista(id){
   var parametros = {
                "id" : id
        };
        $.ajax({
                data:  parametros, 
                url:   '../Controlador/listarRespuestas.php', 
                type:  'post',
                beforeSend: function () {
			$("#contenido_modal").html("Procesando, espere por favor...");
                },
                success:  function (response) {
			$("#contenido_modal").html(response);
                }
        });
}
</script>
  
</body>
</html>