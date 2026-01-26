<?php

  require_once("../Modelo/Menu.php");
  require_once("../Modelo/Usuario.php");
  require_once("../Modelo/Cargo.php");
  require_once("../Modelo/Perfil.php");

  $menu = new Menu();
  $usuario = new Usuario();
  $cargo = new Cargo();
  $perfil = new Perfil();

  $id_usuario_permisos = $_SESSION['id_usuario'];
  $listarUsuid = $usuario->listarUsuarioPorId($id_usuario_permisos);

  $listarCargosPorId = $cargo->listarCargosPorId($listarUsuid[0]['id_cargo']);
  $listarPerfilesPorId = $perfil->listarPerfilesPorId($listarUsuid[0]['id_perfil']);

  $nivel1 = $menu->Subnivel(0);
?>

    <div class="sidebar">

      <div class="logo_content" style="height: 30px;">
      </div>

      <ul class="nav_list">

        <?php if (($_SESSION['id_perfil'] == 2) || ($_SESSION['id_perfil'] == 8)){ ?>
            <li>
              <a href="inicioPropietarios.php">
                <i class="fa fa-home"></i>
                <span class="links_name">Inicio</span>
              </a>
            </li>
            <li>
              <a href="clientesPropietarios.php">
                <i class="fa fa-server"></i>
                <span class="links_name">Clientes</span>
              </a>
            </li>
            <li>
              <a href="contratosOcasionalesPropietarios.php">
                <i class="fa fa-file-text-o"></i>
                <span class="links_name">Planillas Ocasionales</span>
              </a>
            </li>
            <li>
              <a href="extractosFijosPropietarios.php">
                <i class="fa fa-clipboard"></i>
                <span class="links_name">Extractos Fijos</span>
              </a>
            </li>
        <?php }else if ($_SESSION['id_perfil'] == 3){ ?>
            <li>
              <a href="inicioConductores.php">
                <i class="fa fa-home"></i>
                <span class="links_name">Inicio</span>
              </a>
            </li>
        <?php } else { ?>
            <li>
              <a href="inicio.php">
                <i class="fa fa-home"></i>
                <span class="links_name">Inicio</span>
              </a>
            </li>
        <?php } ?>

        <?php foreach($nivel1 as $nv1){ 

              $tipo_permiso = $menu->Permisos($id_usuario_permisos, $nv1['id_modulo']);
              $cant_permiso = count($tipo_permiso);

              if($cant_permiso > 0) {

                  $nivel2 = $menu->Subnivel($nv1['id_modulo']);
                  $cant = count($nivel2);
                  
                  if($cant > 0){ ?>

                    <li class="nav_list_lvl_2">
                      <a href="javascript:void(0)">
                        <i class="<?php echo $nv1['icono']; ?>"></i>
                        <span class="links_name"><?php echo $nv1['nombre_modulo']; ?></span> 
                        <i class="fa fa-angle-down"></i>
                      </a>

                      <ul id="lvl_2">
                          <?php foreach($nivel2 as $nv2){ 

                              $tipo_permiso1 = $menu->Permisos($id_usuario_permisos,$nv2['id_modulo']);
                              $cant_permiso1 = count($tipo_permiso1);

                              if($cant_permiso1 > 0) {

                                $nivel3 = $menu->Subnivel($nv2['id_modulo']);
                                $cant1 = count($nivel3);
                                
                                if ($cant1 > 0){ ?>
                                  <li class="nav_list_lvl_3">

                                    <a href="javascript:void(0)">
				                        <!-- <i class="<?php echo $nv2['icono']; ?>"></i> -->
				                        <span class="links_name"><?php echo $nv2['nombre_modulo']; ?></span> 
				                        <i class="fa fa-angle-down"></i>
                                    </a>

                                    <ul class="lvl_3">

                                        <?php foreach($nivel3 as $nv3){ 

                                          $tipo_permiso2 = $menu->Permisos($id_usuario_permisos, $nv3['id_modulo']);
                                          $cant_permiso2 = count($tipo_permiso2);

                                              if($cant_permiso2 > 0) {

                                                  $nivel4 = $menu->Subnivel($nv3['id_modulo']);
                                                  $cant2 = count($nivel4);
                                              
                                                  if ($cant2 == 0){ ?>
                                                    
                                                    <li >
                                                      <a href="<?php echo $nv3['link']; ?>">
                                                        <span class="links_name"><?php echo $nv3['nombre_modulo']; ?></span>
                                                      </a>
                                                    </li>

                                                  <?php }
                                              }
                                        } ?>

                                    </ul>

                                  </li>
                                <?php } else{ ?>
                                  <li>
                                    <a href="<?php echo $nv2['link']; ?>">
                                      <span class="links_name"><?php echo $nv2['nombre_modulo']; ?></span>
                                    </a>
                                  </li>
                                <?php }
                              }
                          } ?>

                      </ul>

                    </li>

                  <?php }

              }

        } ?>


      </ul>

      <div class="profile_content">
        <div class="profile">
          <div class="profile_detail">
            <img src="../Resources/img/User-Profile.png" alt="">
            <div class="name_job">
              <div class="name">
                <a data-toggle="modal" data-target="#exampleModal">
                <?php 
                    $nombreUsuario =  explode(" ", $listarUsuid[0]['nombre']); 
                    $uno_nu = $nombreUsuario[0]; 
                    $dos_nu = $nombreUsuario[1]; 
                    $tres_nu = $nombreUsuario[2]; 
                    $cuatro_nu = $nombreUsuario[3]; 
                  
                    echo ucwords(strtolower( $uno_nu . ' ' . $dos_nu)); 

                ?>
                </a> 
              </div>
              <?php if ($listarUsuid[0]['id_cargo'] != 0){ ?>
                <div class="job"><strong><?php echo ucwords(strtolower($listarCargosPorId[0]['nombre_cargo'])); ?></strong></div>
              <?php } else { ?>
                <div class="job"><strong><?php echo ucwords(strtolower($listarPerfilesPorId[0]['nombre_perfil'])); ?></strong></div>
              <?php } ?>
            </div>
          </div>
          <a href="../Controlador/Sesion/logout.php"><i class="fa fa-sign-out" id="log_out"></i></a>
        </div>
      </div>

    </div>

    <!-- MODAL USER PROFILE -->

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog " style="border-radius: 18px;" role="document">
        <div class="modal-content" style="border: 4px solid #eeeeee;">

          <div class="modal-body">

              <div class="col-12 d-flex justify-content-center mb-2" style="border-bottom: 1px solid #eee;">
                  <h4><b>MI PERFIL</b></h4>
              </div>

              <section class="row">
                  <div class="col-5 d-flex justify-content-center">
                    <img src="../Resources/img/User-Profile.png" style="width: 210px; height: 170px;" alt="UserPicture">
                  </div>
                  <div class="col-7 text-center">

                      <p class="mt-3"><b><?php echo $listarUsuid[0]['nombre']; ?></b></p>
                      <p><b>
                        <?php if ($listarUsuid[0]['id_cargo'] != 0){ 
                          echo ucwords(strtolower($listarCargosPorId[0]['nombre_cargo']));  
                        } else { 
                          echo ucwords(strtolower($listarPerfilesPorId[0]['nombre_perfil']));
                        } ?>
                      </b></p>

                      <p style="font-size: .7rem;"><i class="fa fa-envelope mr-2" style="color: #1b2d3b; font-size: 1rem;"></i><?php echo $listarUsuid[0]['correo_electronico']; ?></p>

                  </div>
              </section>

              <section class="col-12 d-flex justify-content-center mt-1" style="border-top: 1px solid #eee;">

                <!-- CERRAR MODAL -->
                  <button type="button" class="btn btn-outline-danger mr-2 mt-2" data-dismiss="modal">Cerrar</button>

                <!-- ACTUALIZAR PERFIL -->
                <!--<a href="actualizarPerfilUsuario.php" class="btn mt-2" id="buttonsKV">Actualizar Info <i class="fa fa-user-o"></i></a>-->

              </section>

                            
          </div>

        </div>
      </div>
    </div>

<!-- 

<div class="home_content">
      <div class="text">Home</div>
</div> -->