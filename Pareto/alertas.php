<?php
$fechaactual = date('Y-m-d');
$usuarioid = $_SESSION['idus'];
$alertaobj_amarillo = $querys->alerta_objetivo_ama($fechaactual,$usuarioid);
$cant_obj_ama = count($alertaobj_amarillo);
$alertaact_amarillo = $querys->alerta_actividad_ama($fechaactual,$usuarioid);
$cant_act_ama = count($alertaact_amarillo);
$alertaobj_rojo = $querys->alerta_objetivo_roj($fechaactual,$usuarioid);
$cant_obj_roj = count($alertaobj_rojo);
$alertaact_rojo = $querys->alerta_actividad_roj($fechaactual,$usuarioid);
$cant_act_roj = count($alertaact_rojo);
?>
  <!--<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Realizado</strong>
  </div>
	<div class="alert alert-info alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Informativo</strong>
  </div>-->
  
  <?php if ($cant_obj_ama > 0){ ?>
  <?php foreach ($alertaobj_amarillo as $objama){ ?>
  <div class="alert alert-warning alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>OBJETIVO: <?php echo strtoupper ($objama['descripcion']);?></strong>
  </div>
  <?php } ?>
  <?php } ?>
  
  <?php if ($cant_obj_roj > 0){ ?>
  <?php foreach ($alertaobj_rojo as $objroj){ ?>
  <div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>OBJETIVO: <?php echo strtoupper ($objroj['descripcion']);?></strong>
  </div>
  <?php } ?>
  <?php } ?>
  
  <?php if ($cant_act_ama > 0){ ?>
  <?php foreach ($alertaact_amarillo as $actama){ ?>
  <div class="alert alert-warning alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>ACTIVIDAD: <?php echo strtoupper ($actama['descripcion']);?></strong>
  </div>
  <?php } ?>
  <?php } ?>
  
  <?php if ($cant_act_roj > 0){ ?>
  <?php foreach ($alertaact_rojo as $actroj){ ?>
  <div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>ACTIVIDAD: <?php echo strtoupper ($actroj['descripcion']);?></strong>
  </div>
  <?php } ?>
  <?php } ?>
  