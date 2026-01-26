<?php

$cant_obj_ama = 0;
$cant_obj_roj = 0;
$cant_act_ama = 0;
$cant_act_roj = 0;
$cantactvencidas = 0;
$cantobjvencidas = 0;

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
$amarillos = ($cant_obj_ama + $cant_act_ama);
$rojos = ($cant_obj_roj + $cant_act_roj);

$actvencidas = $querys->act_vencidas($fechaactual,$usuarioid);
$cantactvencidas = count($actvencidas);
$objvencidas = $querys->obj_vencidas($fechaactual,$usuarioid);
$cantobjvencidas = count($objvencidas);
$totalvencidas = ($cantactvencidas + $cantobjvencidas);

$invitaciones = $querys->invitaciones($usuarioid);
$cant_i = count($invitaciones);

?>   
   <header class="header dark-bg">
      <div class="toggle-nav">
        <div class="icon-reorder tooltips" data-original-title="Menu" data-placement="bottom"><i class="icon_menu"></i></div>
      </div>

      <!--logo start-->
      <a href="opciones.php" class="logo">King <span class="lite">Vision</span></a>
      <!--logo end-->

      <div class="top-nav notification-row">
        <!-- notificatoin dropdown start-->
        <ul class="nav pull-right top-menu">
			
		    <li id="task_notificatoin_bar" class="dropdown">
				<a data-toggle="dropdown" class="dropdown-toggle" href="#">
				<i class="icon-union-l"></i>
					<span class="badge bg-confirm"><?php echo $cant_i;?></span>
				</a>
				<ul class="dropdown-menu extended tasks-bar">
					<div class="notify-arrow notify-arrow-blue"></div>
					<li>
						<p class="blue">Tiene <?php echo $cant_i;?> invitaciones</p>
					</li>
					<?php if ($cant_i > 0){ ?>
					<?php foreach ($invitaciones as $inv){ ?>
					<li>
						<a href="invitaciones.php">
							<div class="task-info">
								<div class="desc">
									<?php 
									$actividad = $querys->actividad_id2($inv['id_actividad']);
									$user = $querys->usuarioid($inv['id_anfitrion']);
									echo $actividad[0]['fecha'].' - '.substr($user[0]['nombre'],0,15);
									?>
								</div>
							</div>
						</a>
					</li>
					<?php } ?>
					<?php } ?>
				</ul>
			</li>
			
		   <li id="task_notificatoin_bar" class="dropdown">
				<a data-toggle="dropdown" class="dropdown-toggle" href="#">
					<i class="icon-calendar-l"></i>
					<span class="badge bg-success"><?php echo $amarillos;?></span>
				</a>
				<ul class="dropdown-menu extended tasks-bar">
					<div class="notify-arrow notify-arrow-green"></div>
					<li>
						<p class="green">Tiene <?php echo $amarillos;?> actividades por completar</p>
					</li>
					<?php if ($cant_obj_ama > 0){ ?>
					<?php foreach ($alertaobj_amarillo as $objama){ ?>
					<li>
						<a href="pareto_activo.php">
							<div class="task-info">
								<div class="desc"><?php echo strtoupper(substr($objama['descripcion'],0,25));?></div>
							</div>
						</a>
					</li>
					<?php } ?>
					<?php } ?>
					
					<?php if ($cant_act_ama > 0){ ?>
					<?php foreach ($alertaact_amarillo as $actama){ ?>
					<li>
						<a href="pareto_activo.php">
							<div class="task-info">
								<div class="desc"><?php echo strtoupper (substr($actama['descripcion'],0,25));?></div>
							</div>
						</a>
					</li>
					<?php } ?>
					<?php } ?>
				</ul>
		   </li>	
			
           <li id="task_notificatoin_bar" class="dropdown">
				<a data-toggle="dropdown" class="dropdown-toggle" href="#">
					<i class="icon-task-l"></i>
					<span class="badge bg-warning"><?php echo $rojos;?></span>
				</a>
				<ul class="dropdown-menu extended tasks-bar">
					<div class="notify-arrow notify-arrow-yellow"></div>
					<li>
						<p class="yellow">Tiene <?php echo $rojos;?> actividades hoy</p>
					</li>
					<?php if ($cant_obj_roj > 0){ ?>
					<?php foreach ($alertaobj_rojo as $objroj){ ?>
					<li>
						<a href="obj_especificos.php">
							<div class="task-info">
								<div class="desc"><?php echo strtoupper(substr($objroj['descripcion'],0,25));?></div>
							</div>
						</a>
					</li>
					<?php } ?>
					<?php } ?>
					
					<?php if ($cant_act_roj > 0){ ?>
					<?php foreach ($alertaact_rojo as $actroj){ ?>
					<li>
						<a href="pareto_activo.php">
							<div class="task-info">
								<div class="desc"><?php echo strtoupper(substr ($actroj['descripcion'],0,25));?></div>
							</div>
						</a>
					</li>
					<?php } ?>
					<?php } ?>
				</ul>
		   </li>
          
          
           <li id="task_notificatoin_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="icon-bell-l"></i>
                            <span class="badge bg-danger"><?php echo $totalvencidas;?></span>
                        </a>
          	<ul class="dropdown-menu extended tasks-bar">
					<div class="notify-arrow notify-arrow-red"></div>
					<li>
						<p class="red">Tiene <?php echo $totalvencidas;?> actividades vencidas</p>
					</li>
					<?php if ($cantactvencidas > 0){ ?>
					<?php foreach ($actvencidas as $actven){ ?>
					<li>
						<?php if($actven['id_pareto'] > 0){ ?>
						<a href="consultar_pareto.php?id=<?php echo $actven['id_pareto'];?>">
							<div class="task-info">
								<div class="desc"><?php echo strtoupper (substr($actven['descripcion'],0,25));?></div>
							</div>
						</a>
						<?php } else { ?>
						<a href="javascript:void(0)" onclick="alert('No se inicio pareto a la fecha de la actividad');">
							<div class="task-info">
								<div class="desc"><?php echo strtoupper (substr($actven['descripcion'],0,25));?></div>
							</div>
						</a>
						<?php } ?>
					</li>
					<?php } ?>
					<?php } ?>
					
					<?php if ($cantobjvencidas > 0){ ?>
					<?php foreach ($objvencidas as $objven){ ?>
					<li>
						<a href="obj_especificos.php">
							<div class="task-info">
								<div class="desc"><?php echo strtoupper (substr($objven['descripcion'],0,25));?></div>
							</div>
						</a>
					</li>
					<?php } ?>
					<?php } ?>
				</ul>
          </li>
          
          <!-- user login dropdown start-->
          <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" >
                <span class="username"><?php echo $_SESSION['nombre'];?></span>
            </a>
          </li>
          <!-- user login dropdown end -->
        </ul>
        <!-- notificatoin dropdown end-->
      </div>
    </header>
    <!--header end-->