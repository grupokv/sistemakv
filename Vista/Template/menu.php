<?php
require_once("../Modelo/Menu.php");
require_once("../Modelo/Usuario.php");
$id_usuario_permisos = $_SESSION['id_usuario'];
$menu = new Menu();

$usuario = new Usuario();
$listarUsuid = $usuario->listarUsuarioPorId($_SESSION['id_usuario']);

$nivel1 = $menu->Subnivel(0);
?>
  <div class="header col-12"></div>
    <!-- Menu --> 
    <input type="checkbox" name="abrir-menu" id="abrir-menu">
    <label for="abrir-menu" id="btn-menu"><span class="fa fa-bars"></span></label>

    <nav class="menu">
      <ul>
        <div class="row logo">
          <p class="ml-5" id="k">KING</p>  
          <p class="ml-1 mr-5" id="v">VISION</p>  
        </div>

            <?php if (($_SESSION['id_perfil'] == 3)and($_SESSION['id_cliente'] == 0)){ ?>
                <li><a href="inicioConductores.php">Inicio</a></li>
            <?php }else if (($_SESSION['id_perfil'] == 2)and($_SESSION['id_cliente'] == 0)){ ?>
                <li><a href="inicioPropietarios.php">Inicio</a></li>
                <?php if($_SESSION['id_usuario'] == 2020){ ?>
                  <li><a href="clientesPropietarios.php">Clientes</a></li>
                  <li><a href="contratosOcasionalesPropietarios.php">Extractos Ocasionales</a></li>
                  <li><a href="extractosFijosPropietarios.php">Extractos Fijos</a></li>
                <?php } ?>
            <?php }else if (($_SESSION['id_perfil'] == 8)and($_SESSION['id_cliente'] == 0)){ ?>
                <li><a href="inicioPropietarios.php">Inicio</a></li>
                <li><a href="contratosOcasionalesPropietarios.php">Contratos ocasionales</a></li>
            <?php }else if ($_SESSION['id_cliente'] != 0){ ?>
		<?php if ($_SESSION['id_perfil'] == 14){ ?>                
		<li><a href="inicioPasajeros.php">Inicio</a></li>
		<?php } else { ?>
		<li><a href="inicioCliente.php">Inicio</a></li>
		<?php } ?>           
           <?php } else { ?>
              <li><a href="inicio.php">Inicio</a></li>
            <?php  } ?>

            <?php foreach($nivel1 as $nv1){ ?>
          		<?php
              $tipo_permiso = $menu->Permisos($id_usuario_permisos,$nv1['id_modulo']);
              $cant_permiso = count($tipo_permiso);
              if($cant_permiso > 0) {

      				$nivel2 = $menu->Subnivel($nv1['id_modulo']);
      				$cant = count($nivel2);
      				if($cant > 0){
      			?>

            	<li class="submenu">
            		<a href="javascript:void(0)"><?php echo $nv1['nombre_modulo'];?> <span class="fa fa-angle-down"></span></a>
                <ul>

                	<?php foreach($nivel2 as $nv2){ ?>
  				 		<?php
              $tipo_permiso1 = $menu->Permisos($id_usuario_permisos,$nv2['id_modulo']);
              $cant_permiso1 = count($tipo_permiso1);
              if($cant_permiso1 > 0) {
  				 		$nivel3 = $menu->Subnivel($nv2['id_modulo']);
  				 		$cant1 = count($nivel3);
  				 		?>
  				 		<?php if ($cant1 > 0){ ?>
  				 		  <li class="sub-submenu"><a href="javascript:void(0)"><?php echo $nv2['nombre_modulo'];?> <span class="fa fa-angle-down"></span></a>
                              <ul>
                                <?php foreach($nivel3 as $nv3){ ?>
		  				 		<?php
                  $tipo_permiso2 = $menu->Permisos($id_usuario_permisos,$nv3['id_modulo']);
                  $cant_permiso2 = count($tipo_permiso2);
                  if($cant_permiso2 > 0) {
		  				 		$nivel4 = $menu->Subnivel($nv3['id_modulo']);
		  				 		$cant2 = count($nivel4);
		  				 		?>
		  				 		<?php if ($cant2 > 0){ ?>
		  				 		  <li class="sub-submenu"><a href="javascript:void(0)"><?php echo $nv3['nombre_modulo'];?> <span class="fa fa-angle-down fa-xs"></span></a>
		                              <ul>
		                              	<?php foreach($nivel4 as $nv4){ ?>
                                    <?php
                                    $tipo_permiso3 = $menu->Permisos($id_usuario_permisos,$nv4['id_modulo']);
                                    $cant_permiso3 = count($tipo_permiso3);
                                    if($cant_permiso3 > 0) {
                                    ?>
		                                <li><a href="<?php echo $nv4['link'];?>"><?php echo $nv4['nombre_modulo'];?></a></li>
		                            <?php } } ?>
		                              </ul>
		                          </li>
		  				 		<?php } else { ?>
		  				 		   <li><a href="<?php echo $nv3['link'];?>"><?php echo $nv3['nombre_modulo'];?></a></li>
		  				 		<?php } ?>
		  				 	<?php } } ?>
                              </ul>
                          </li>
  				 		<?php } else { ?>
  				 		   <li><a href="<?php echo $nv2['link'];?>"><?php echo $nv2['nombre_modulo'];?></a></li>
  				 		<?php } ?>
  				 	<?php } } ?>
          		</ul>
            </li>
        	<?php } else { ?>
            	<li>
            		<a href="<?php echo $nv1['link'];?>"><?php echo $nv1['nombre_modulo'];?> </a>
            	</li>
            <?php } }  } ?>


            <li class="submenu" id="cuenta"><a href="javascript:void(0)"> <?php $nombreUsuario =  explode(" ", $listarUsuid[0]['nombre']); $uno_nu = $nombreUsuario[0]; $dos_nu = $nombreUsuario[1]; $tres_nu = $nombreUsuario[2]; $cuatro_nu = $nombreUsuario[3]; echo $uno_nu . ' ' . $dos_nu?><span class="fa fa-angle-down ml-2"></span></a>
                <ul>
                    <?php if ($_SESSION['id_perfil'] == 3){ ?>
                        <li><a href="<?php echo $redirectUpdateDriver ?>">Mi Perfil<span class="fa fa-user ml-2 mr-3"></span><i style="color: orange; font-size: .7rem;" class="<?php echo $iconoNotificaciones ?>"></i> </a></li>
                    <?php }else if ($_SESSION['id_perfil'] == 2){ ?>
                        <li><a href="<?php echo $redirectUpdateDriver ?>">Mi Perfil<span class="fa fa-user ml-2 mr-3"></span><i style="color: orange; font-size: .7rem;" class="<?php echo $iconoNotificaciones ?>"></i> </a></li>
                    <?php } else{ ?>
                        <li><a href="actualizarPerfilUsuario.php">Mi Perfil<span class="fa fa-user-o"></span></a></li>
                    <?php } ?>
                    <li><a href="../Controlador/Sesion/logout.php">Salir<span class="fa fa-sign-out"></span></a></li>
                    
                </ul>
            </li>
          </ul>
        </nav>