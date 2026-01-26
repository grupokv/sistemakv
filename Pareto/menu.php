<!--sidebar start-->
    <aside>
      <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu">
          <!--INICIO OPCIONES GLOBALES-->
		  <li class>
              <a class="" href="opciones.php">
				  <i class="icon_house_alt"></i>
				  <span>INICIO</span>
			  </a>
          </li>
          <li class="sub-menu">
            <a href="javascript:;" class="">
			  <i class="icon_document_alt"></i>
			  <span>OBJETIVOS</span>
			  <span class="menu-arrow arrow_carrot-right"></span>
			</a>
            <ul class="sub">
              <li><a class="" href="obj_general.php">Ob. de Presupuestos</a></li>
              <li><a class="" href="obj_especificos.php">Entregables Esp.</a></li>
            </ul>
          </li>
		  <li class="sub-menu">
            <a href="javascript:;" class="">
                          <i class="icon_folder-open_alt"></i>
                          <span>PARETO</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
            <ul class="sub">
              <li><a class="" href="pareto_activo.php">Pareto Actual</a></li>
              <li><a class="" href="historial_pareto.php">Historial</a></li>
			  <li><a class="" href="mis_solicitudes.php">Invitaciones</a></li>
            </ul>
          </li>
		  <li>
			  <a class="" href="agenda/agenda.php">
				  <i class="icon_calendar"></i>
				  <span>AGENDA</span>
			  </a>
          </li>
		  <!--FIN OPCIONES GLOBALES-->
		  
		  <!--INICIO OPCIONES ADMINISTRACION-->
		  <?php if (($_SESSION['perfil'] == 1)or($_SESSION['perfil'] == 2)){ ?>
		  <li class="sub-menu">
			  <a href="javascript:;" class="">
				  <i class="icon_datareport"></i>
				  <span>REPORTES</span>
				  <span class="menu-arrow arrow_carrot-right"></span>
			  </a>
			  <ul class="sub">
              <li><a class="" href="reporte_usuario.php">Grafica Usuario</a></li>
			  <li><a class="" href="paretos_usuario.php">Paretos Usuario</a></li>
			  <li><a class="" href="objetivos_usuario.php">Objetivos Usuario</a></li>
              <li><a class="" href="reporte_area.php">Grafica Area</a></li>
            </ul>
          </li>
		  <?php if ($_SESSION['perfil'] == 1){ ?>
		  <li>
			  <a class="" href="areas.php">
				  <i class="icon_archive_alt"></i>
				  <span>AREAS</span>
			  </a>
          </li>
		  <?php } ?>
		  <li>
			  <a class="" href="cargos.php">
				  <i class="icon_id-2"></i>
				  <span>CARGOS</span>
			  </a>
          </li>
		  <li>
			  <a class="" href="usuarios.php">
				  <i class="icon_profile"></i>
				  <span>USUARIOS</span>
			  </a>
          </li>
		  <?php } ?>
		   <?php if ($_SESSION['perfil'] == 1){ ?>
		  <li>
			  <a class="" href="perfiles.php">
				  <i class="icon_group"></i>
				  <span>PERFILES</span>
			  </a>
          </li>
		  <li>
			  <a class="" href="tipos_actividad.php">
				  <i class="icon_pencil-edit"></i>
				  <span>TIPOS ACTIVIDAD</span>
			  </a>
          </li>
		  <li>
			  <a class="" href="tipo_evidencia.php">
				  <i class="icon_search_alt"></i>
				  <span>TIPOS EVIDENCIA</span>
			  </a>
          </li>
		  <?php } ?>
		  <!--FIN OPCIONES ADMINISTRACION-->
		<!--<li class>
              <a class="" href="Actas/Vista/mostrarInformacionActa.php">
				  <i class="icon_archive_alt"></i>
				  <span>ACTAS</span>
			  </a>
          </li>-->

		  <li>
              <a class="" href="logout.php">
				  <i class="icon_close"></i>
				  <span>SALIR</span>
			  </a>
          </li>
          
        </ul>
        <!-- sidebar menu end-->
      </div>
    </aside>
    <!--sidebar end-->