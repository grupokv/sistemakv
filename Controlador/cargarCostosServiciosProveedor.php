<?php 
require_once "../Modelo/ProveedorMantenimiento.php"; 
require_once "../Modelo/Subcategoria_Mantenimiento.php"; 


$id_proveedor = $_POST['id_proveedor'];

$proveedorMantenimiento = new ProveedorMantenimiento();
$subcategoriaMantenimiento = new Subcategoria_Mantenimiento();

$listarsubcategoriaPorProveedores = $proveedorMantenimiento->listarsubcategoriaPorProveedores($id_proveedor);
$cant = count($listarsubcategoriaPorProveedores);

$html = '';

if ($cant >= 1) {
	$html .= '<table id="dataTable" class="table table-hover table-sm display text-center">';
		$html .= "<thead style='background-color: #1b2d3b; color: #fff;'>";
			$html .= "<tr>";
				$html .= "<th>CATEGORIA</th>";
				$html .= "<th>SUBCATEGORIA</th>";
				$html .= "<th>COSTO</th>";
				$html .= "<th>OPCIONES</th>";
			$html .= "</tr>";
		$html .= "</thead>";
		$html .= "<tbody>";
			foreach ($listarsubcategoriaPorProveedores as $lspp) {
				$categoria = $subcategoriaMantenimiento->listarCategoriasPorIdSubcategoria($lspp['id_subcategoria']);
					
				$html .= "<tr>";
					$html .= "<td>". $categoria[0]['detalle_categoria'] ."</td>";

					$html .= "<td>". $categoria[0]['detalle_subcategoria'] ."</td>";
					$html .= "<td> $ ". number_format($lspp['costo']) ."</td>";
					$html .= "<td><a target='_blank' href='../Vista/actualizarSubcategoriaProveedor.php?id=" . $lspp['id'] . "' class='btn btn-outline-info' style='margin: 0px; padding: 0px 4px 0px 4px;'><span class='fa fa-edit'></span></a></td>";
				$html .= "</tr>";
			}
		$html .= "</tbody>";
	$html .= "</table>";
}else{
	$html .= '<p class="text-center" style="font-size:1.2rem;">El proveedor no tiene servicios anclados.</p>';
}
	
	

echo $html;



 ?>

<script type="text/javascript">

    $(document).ready(function() {
        $('#dataTable').DataTable({
            "scrollX": true, 
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
            },
        });
    });

</script>