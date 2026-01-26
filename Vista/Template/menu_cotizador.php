<div class="sidebar">
    <div class="logo_content" style="height: 30px;"></div>
    <ul class="nav_list">
        <?php if(($_SESSION['id_user'] == 1)or($_SESSION['id_user'] == 2)){ ?>
        <li class="nav_list_lvl_2">
            <a href="javascript:void(0)">
                <i class="fa fa-gears"></i>
                <span class="links_name">Administracion</span> 
                <i class="fa fa-angle-down"></i>
            </a>

            <ul id="lvl_2" style="display: none;">
                <li>
                    <a href="CotizacionAdminEmpresas.php">
                        <span class="links_name">Empresas</span>
                    </a>
                </li>
                <li>
                    <a href="CotizacionAdminDestinos.php">
                        <span class="links_name">Destinos</span>
                    </a>
                </li>
                <li>
                    <a href="CotizacionAdminTarifaIndividual.php">
                        <span class="links_name">Tarifa Individual</span>
                    </a>
                </li>
                <li>
                <li>
                    <a href="CotizacionAdminDescuentos.php">
                        <span class="links_name">Descuentos</span>
                    </a>
                </li>
                <li>
                    <a href="CotizacionAdminUsuarios.php">
                        <span class="links_name">Usuarios</span>
                    </a>
                </li>
            </ul>
        </li>
        <?php } ?>
        <li>
            <a href="CotizacionListado.php">
                <i class="fa fa-list"></i>
                <span class="links_name">Listado Cotizaciones</span>
            </a>
        </li>
        <li>
            <a href="CotizacionNuevo.php">
                <i class="fa fa-plus"></i>
                <span class="links_name">Nueva Cotizacion</span>
            </a>
        </li>
    </ul>
</div>
    