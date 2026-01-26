<?php 
require_once '../Modelo/Agendas.php';
 
$agenda = new Agenda();
	$tema_acta = $_POST['tema'];
	$descripcion_acta = $_POST['descripcion'];
	$id_acta = $_POST['id_acta'];

	$registrarAgenda = $agenda->registrarAgenda($id_acta, $tema_acta, $descripcion_acta);
	
?>

  <!-- Bootstrap CSS -->
  <link href="../Recursos/css/bootstrap.min.css" rel="stylesheet">
  <!-- bootstrap theme -->
  <link href="../Recursos/css/bootstrap-theme.css" rel="stylesheet">
  <!--external css-->
  <!-- font icon -->
  <link href="../Recursos/css/elegant-icons-style.css" rel="stylesheet" />
  <link href="../Recursos/css/font-awesome.min.css" rel="stylesheet" />

	<div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin: 0 auto; text-align: center; display: block">
  	   <div class="modal-dialog" role="document" style="max-width:450px;">
    	       <div class="modal-content">
      		   <div class="modal-body">
        	       <strong style="font-size: 2rem;"><?php echo utf8_encode("¿") ?>Desea registrar otro tema para el acta?</strong>
      		   </div>
      		   <div class="modal-footer">
        		<a href="../Vista/registrarSituacion.php?id_acta=<?php echo $id_acta ?> " class="btn btn-danger" data-dismiss="modal">No, gracias.</a>
        		<a href="../Vista/registrarTemas.php?id_acta=<?php echo $id_acta ?>" class="btn btn-primary">Agregar</a>
      		   </div>
    	       </div>
   	   </div>
        </div>
<!-- javascripts -->
  <script src="../Recursos/js/jquery.js"></script>
  <script src="../Recursos/js/jquery-ui-1.10.4.min.js"></script>
  <script src="../Recursos/js/jquery-1.8.3.min.js"></script>
  <script type="text/javascript" src="../Recursos/js/jquery-ui-1.9.2.custom.min.js"></script>
  <script type="text/javascript" src="../Recursos/jquery-ui-1.12.1/jquery-ui.min.js"></script>
  <!-- bootstrap -->

<script src="../Recursos/js/bootstrap.min.js"></script>
