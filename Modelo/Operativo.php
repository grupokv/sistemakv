<?php 
require_once("Conexion/conexionBD.php");
/**
 * 
 */
class Operativo
{
	
	public function listarServiciosActivos($fecha, $fecha2){
		$listarServiciosA= array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM base_servicios WHERE (fecha_inicio >= :fecha AND fecha_inicio <= :fecha2) ");
		$sql->bindParam(":fecha", $fecha);
		$sql->bindParam(":fecha2", $fecha2);
		$sql->execute();

		while ($filas= $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarServiciosA[] = $filas;
		}
		return $listarServiciosA;
	}

	public function listarServiciosPorProducto($id_producto){
		$listarServiciosA= array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM base_servicios WHERE  ");
		$sql->bindParam(":fecha", $fecha);
		$sql->bindParam(":fecha2", $fecha2);
		$sql->execute();

		while ($filas= $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarServiciosA[] = $filas;
		}
		return $listarServiciosA;
	}

	public function listarServicios($fecha, $fecha2, $id_cliente, $tipo_servicio, $id_usuario_creador, $id_vehiculo, $id_conductor, $estado, $id_producto){
		$listarServicios = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM base_servicios AS bs LEFT JOIN base_servicio_vehiculos AS bsv ON bs.id_servicio_base = bsv.id_servicio WHERE (DATE(bs.fecha_inicio) >= '$fecha' AND DATE(bs.fecha_inicio) <= '$fecha2') AND ((JSON_EXTRACT(bsv.id_vehiculo, '$.entrada') $id_vehiculo OR JSON_EXTRACT(bsv.id_vehiculo, '$.salida') $id_vehiculo) AND (JSON_EXTRACT(bsv.id_conductor, '$.entrada') $id_conductor OR JSON_EXTRACT(bsv.id_conductor, '$.salida') $id_conductor)) AND bs.id_cliente $id_cliente AND bs.tipo_servicio LIKE '%$tipo_servicio%' AND bs.id_usuario_creador LIKE '%$id_usuario_creador%' AND bs.estado_servicio $estado AND bs.id_producto LIKE '%$id_producto%' GROUP BY bsv.id_servicio ORDER BY bs.id_servicio_base DESC");

		$sql->bindParam(":fecha", $fecha);
		$sql->bindParam(":fecha2", $fecha2);
		$sql->bindParam(":id_cliente", $id_cliente);
		$sql->bindParam(":tipo_servicio", $tipo_servicio);
		$sql->bindParam(":id_usuario_creador", $id_usuario_creador);
		$sql->bindParam(":id_vehiculo", $id_vehiculo);
		$sql->bindParam(":id_conductor", $id_conductor);
		$sql->bindParam(":estado", $estado);
		$sql->bindParam(":id_producto", $id_producto);
		$sql->execute();

		//echo "SELECT * FROM base_servicios AS bs LEFT JOIN base_servicio_vehiculos AS bsv ON bs.id_servicio_base = bsv.id_servicio WHERE (DATE(bs.fecha_inicio) >= '$fecha' AND DATE(bs.fecha_inicio) <= '$fecha2') AND ((JSON_EXTRACT(bsv.id_vehiculo, '$.entrada') $id_vehiculo OR JSON_EXTRACT(bsv.id_vehiculo, '$.salida') $id_vehiculo) AND (JSON_EXTRACT(bsv.id_conductor, '$.entrada') $id_conductor OR JSON_EXTRACT(bsv.id_conductor, '$.salida') $id_conductor)) AND bs.id_cliente $id_cliente AND bs.tipo_servicio LIKE '%$tipo_servicio%' AND bs.id_usuario_creador LIKE '%$id_usuario_creador%' AND bs.estado_servicio $estado AND bs.id_producto LIKE '%$id_producto%' GROUP BY bsv.id_servicio ORDER BY bs.id_servicio_base DESC";

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarServicios[] = $filas;
		}
		return $listarServicios;
	}


	public function reporteServiciosConsolidadoCliente($fecha, $fecha2, $id_cliente, $tipo_servicio, $id_usuario_creador, $id_vehiculo, $id_conductor, $estado, $id_producto){
		$listarServicios = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT bs.id_cliente, COUNT(bs.id_servicio_base) AS total, SUM(JSON_EXTRACT(bsv.valor_cliente, '$.entrada') + JSON_EXTRACT(bsv.valor_cliente, '$.salida')) AS valor_cliente, SUM(JSON_EXTRACT(bsv.valor_movil, '$.entrada') + JSON_EXTRACT(bsv.valor_movil, '$.salida')) AS valor_movil FROM base_servicios AS bs LEFT JOIN base_servicio_vehiculos AS bsv ON bs.id_servicio_base = bsv.id_servicio WHERE (DATE(bs.fecha_inicio) >= '$fecha' AND DATE(bs.fecha_inicio) <= '$fecha2') AND ((JSON_EXTRACT(bsv.id_vehiculo, '$.entrada') $id_vehiculo OR JSON_EXTRACT(bsv.id_vehiculo, '$.salida') $id_vehiculo) AND (JSON_EXTRACT(bsv.id_conductor, '$.entrada') $id_conductor OR JSON_EXTRACT(bsv.id_conductor, '$.salida') $id_conductor)) AND bs.id_cliente $id_cliente AND bs.tipo_servicio LIKE '%$tipo_servicio%' AND bs.id_usuario_creador LIKE '%$id_usuario_creador%' AND bs.estado_servicio $estado AND bs.id_producto LIKE '%$id_producto%' GROUP BY bs.id_cliente ");

		$sql->bindParam(":fecha", $fecha);
		$sql->bindParam(":fecha2", $fecha2);
		$sql->bindParam(":id_cliente", $id_cliente);
		$sql->bindParam(":tipo_servicio", $tipo_servicio);
		$sql->bindParam(":id_usuario_creador", $id_usuario_creador);
		$sql->bindParam(":id_vehiculo", $id_vehiculo);
		$sql->bindParam(":id_conductor", $id_conductor);
		$sql->bindParam(":estado", $estado);
		$sql->bindParam(":id_producto", $id_producto);
		$sql->execute();

		//echo "SELECT bs.id_cliente, COUNT(bs.id_servicio_base) AS total, SUM(JSON_EXTRACT(bsv.valor_cliente, '$.entrada') + JSON_EXTRACT(bsv.valor_cliente, '$.salida')) AS valor_cliente, SUM(JSON_EXTRACT(bsv.valor_movil, '$.entrada') + JSON_EXTRACT(bsv.valor_movil, '$.salida')) AS valor_movil FROM base_servicios AS bs LEFT JOIN base_servicio_vehiculos AS bsv ON bs.id_servicio_base = bsv.id_servicio WHERE (DATE(bs.fecha_inicio) >= '$fecha' AND DATE(bs.fecha_inicio) <= '$fecha2') AND ((JSON_EXTRACT(bsv.id_vehiculo, '$.entrada') $id_vehiculo OR JSON_EXTRACT(bsv.id_vehiculo, '$.salida') $id_vehiculo) AND (JSON_EXTRACT(bsv.id_conductor, '$.entrada') $id_conductor OR JSON_EXTRACT(bsv.id_conductor, '$.salida') $id_conductor)) AND bs.id_cliente $id_cliente AND bs.tipo_servicio LIKE '%$tipo_servicio%' AND bs.id_usuario_creador LIKE '%$id_usuario_creador%' AND bs.estado_servicio $estado AND bs.id_producto LIKE '%$id_producto%' GROUP BY bs.id_cliente";

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarServicios[] = $filas;
		}
		return $listarServicios;
	}

	public function reporteServiciosConsolidadoPorProducto($fecha, $fecha2, $id_cliente, $tipo_servicio, $id_usuario_creador, $id_vehiculo, $id_conductor, $estado, $id_producto){
		$listarServicios = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT COUNT(bs.id_producto)AS total, bs.id_producto, bs.id_cliente, SUM(JSON_EXTRACT(bsv.valor_cliente, '$.entrada') + JSON_EXTRACT(bsv.valor_cliente, '$.salida')) AS valor_cliente , SUM(JSON_EXTRACT(bsv.valor_movil, '$.entrada') + JSON_EXTRACT(bsv.valor_movil, '$.salida')) AS valor_movil FROM base_servicios AS bs LEFT JOIN base_servicio_vehiculos AS bsv ON bs.id_servicio_base = bsv.id_servicio WHERE ((DATE(bs.fecha_inicio) >= '$fecha' AND DATE(bs.fecha_inicio) <= '$fecha2')) AND ((JSON_EXTRACT(bsv.id_vehiculo, '$.entrada') $id_vehiculo OR JSON_EXTRACT(bsv.id_vehiculo, '$.salida') $id_vehiculo) AND (JSON_EXTRACT(bsv.id_conductor, '$.entrada') $id_conductor OR JSON_EXTRACT(bsv.id_conductor, '$.salida') $id_conductor)) AND bs.id_cliente $id_cliente AND bs.tipo_servicio LIKE '%$tipo_servicio%' AND bs.id_usuario_creador LIKE '%$id_usuario_creador%' AND bs.estado_servicio $estado AND bs.id_producto LIKE '%$id_producto%' GROUP BY bs.id_producto ORDER BY bs.id_cliente");

		$sql->bindParam(":fecha", $fecha);
		$sql->bindParam(":fecha2", $fecha2);
		$sql->bindParam(":id_cliente", $id_cliente);
		$sql->bindParam(":tipo_servicio", $tipo_servicio);
		$sql->bindParam(":id_usuario_creador", $id_usuario_creador);
		$sql->bindParam(":id_vehiculo", $id_vehiculo);
		$sql->bindParam(":id_conductor", $id_conductor);
		$sql->bindParam(":estado", $estado);
		$sql->bindParam(":id_producto", $id_producto);
		$sql->execute();


		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarServicios[] = $filas;
		}
		return $listarServicios;
	}

	public function reporteServiciosVehEntrada($fecha, $fecha2, $id_cliente, $tipo_servicio, $id_usuario_creador, $id_vehiculo, $id_conductor, $estado, $id_producto){
		$listarServicios = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT JSON_EXTRACT(bsv.id_vehiculo, '$.entrada') AS id_vehiculo, bs.id_cliente, bs.id_producto, COUNT(JSON_EXTRACT(bsv.id_vehiculo, '$.entrada')) AS total, SUM(JSON_EXTRACT(bsv.valor_cliente, '$.entrada')) AS valor_cliente, SUM(JSON_EXTRACT(bsv.valor_movil, '$.entrada')) AS valor_movil FROM base_servicios AS bs LEFT JOIN base_servicio_vehiculos AS bsv ON bs.id_servicio_base = bsv.id_servicio WHERE ((DATE(bs.fecha_inicio) >= '$fecha' AND DATE(bs.fecha_inicio) <= '$fecha2') AND (JSON_EXTRACT(bsv.id_vehiculo, '$.entrada') $id_vehiculo) AND (JSON_EXTRACT(bsv.id_conductor, '$.entrada') $id_conductor OR JSON_EXTRACT(bsv.id_conductor, '$.salida') $id_conductor)) AND bs.id_cliente $id_cliente AND bs.tipo_servicio LIKE '%$tipo_servicio%' AND bs.id_usuario_creador LIKE '%$id_usuario_creador%' AND bs.estado_servicio $estado AND bs.id_producto LIKE '%$id_producto%'  AND JSON_EXTRACT(bsv.id_vehiculo, '$.entrada') !=  '' GROUP BY JSON_EXTRACT(bsv.id_vehiculo, '$.entrada'), bs.id_cliente, bs.id_producto ");

		$sql->bindParam(":fecha", $fecha);
		$sql->bindParam(":fecha2", $fecha2);
		$sql->bindParam(":id_cliente", $id_cliente);
		$sql->bindParam(":tipo_servicio", $tipo_servicio);
		$sql->bindParam(":id_usuario_creador", $id_usuario_creador);
		$sql->bindParam(":id_vehiculo", $id_vehiculo);
		$sql->bindParam(":id_conductor", $id_conductor);
		$sql->bindParam(":estado", $estado);
		$sql->bindParam(":id_producto", $id_producto);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarServicios[] = $filas;
		}
		return $listarServicios;
	}


	public function reporteServiciosVehSalida($fecha, $fecha2, $id_cliente, $tipo_servicio, $id_usuario_creador, $id_vehiculo, $id_conductor, $estado, $id_producto){
		$listarServicios = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT JSON_EXTRACT(bsv.id_vehiculo, '$.salida') AS id_vehiculo, bs.id_cliente, bs.id_producto, COUNT(JSON_EXTRACT(bsv.id_vehiculo, '$.salida')) AS total, SUM(JSON_EXTRACT(bsv.valor_cliente, '$.salida')) AS valor_cliente, SUM(JSON_EXTRACT(bsv.valor_movil, '$.salida')) AS valor_movil FROM base_servicios AS bs LEFT JOIN base_servicio_vehiculos AS bsv ON bs.id_servicio_base = bsv.id_servicio WHERE ((DATE(bs.fecha_inicio) >= '$fecha' AND DATE(bs.fecha_inicio) <= '$fecha2') AND (JSON_EXTRACT(bsv.id_vehiculo, '$.salida') $id_vehiculo ) AND (JSON_EXTRACT(bsv.id_conductor, '$.entrada') $id_conductor OR JSON_EXTRACT(bsv.id_conductor, '$.salida') $id_conductor)) AND bs.id_cliente $id_cliente AND bs.tipo_servicio LIKE '%$tipo_servicio%' AND bs.id_usuario_creador LIKE '%$id_usuario_creador%' AND bs.estado_servicio $estado AND bs.id_producto LIKE '%$id_producto%'  AND JSON_EXTRACT(bsv.id_vehiculo, '$.salida') !=  '' GROUP BY JSON_EXTRACT(bsv.id_vehiculo, '$.salida'), bs.id_cliente, bs.id_producto ");

		$sql->bindParam(":fecha", $fecha);
		$sql->bindParam(":fecha2", $fecha2);
		$sql->bindParam(":id_cliente", $id_cliente);
		$sql->bindParam(":tipo_servicio", $tipo_servicio);
		$sql->bindParam(":id_usuario_creador", $id_usuario_creador);
		$sql->bindParam(":id_vehiculo", $id_vehiculo);
		$sql->bindParam(":id_conductor", $id_conductor);
		$sql->bindParam(":estado", $estado);
		$sql->bindParam(":id_producto", $id_producto);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarServicios[] = $filas;
		}
		return $listarServicios;
	}

	public function listarVehiculosPorServicioID($id_servicio){
		$vehiculosServicioID = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM base_servicio_vehiculos WHERE id_servicio = :id_servicio ORDER BY id ASC");
		$sql->bindParam(":id_servicio", $id_servicio);
		$sql->execute();

		while ($filas= $sql->fetch(PDO::FETCH_ASSOC)) {
			$vehiculosServicioID[] = $filas;
		}
		return $vehiculosServicioID;
	}
	
	public function listarProductos(){
		$listarProductos = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM productos_clientes");
		$sql->execute();

		while ($filas= $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarProductos[] = $filas;
		}
		return $listarProductos;
	}
	
	public function listarTipoNovedades(){
		$listarTN = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM tipo_novedades_servicios ORDER BY tipo_novedad ASC");
		$sql->execute();

		while ($filas= $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarTN[] = $filas;
		}
		return $listarTN;
	}
	
	public function listarTipoNovedadesPorId($id_tipo_novedad){
		$listarTN = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM tipo_novedades_servicios WHERE id_tipo_novedad = :id_tipo_novedad ");
		$sql->bindParam(":id_tipo_novedad", $id_tipo_novedad);
		$sql->execute();

		while ($filas= $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarTN[] = $filas;
		}
		return $listarTN;
	}

	public function cambiarNovedadServicio($id_servicio, $tipo_novedad, $novedad){
		$listarTN = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("UPDATE base_servicios SET estado_servicio = :tipo_novedad, novedad = :novedad WHERE id_servicio_base = :id_servicio");
		$sql->bindParam(":tipo_novedad", $tipo_novedad);
		$sql->bindParam(":novedad", $novedad);
		$sql->bindParam(":id_servicio", $id_servicio);
		$sql->execute();

		//echo "UPDATE base_servicios SET estado_servicio = '$tipo_novedad', novedad = '$novedad' WHERE id_servicio_base = '$id_servicio' ";

		while ($filas= $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarTN[] = $filas;
		}
		return $listarTN;
	}

	public function eliminarBaseServicio($id_servicio){

		try{
			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE base_servicios SET estado_servicio = 'E' WHERE id_servicio_base = :id_servicio");
			$sql->bindParam(":id_servicio", $id_servicio);
			$sql->execute();

		} catch (Exception $e) {
			echo $e->getMessage();
		}

	}

	/* --------------------------------------------------- */
	/* --------------------------------------------------- */
	/* --------------------------------------------------- */

	public function registrarPermisosUsuario($rol, $tipo_usuario, $id_usuario, $id_cliente, $registro, $consulta, $valor_cliente, $lectura_reportes, $anulacion, $fecha_asignacion, $id_usuario_asignacion){
		try{
			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO permisos_usuarios_mod_operativo (rol, tipo_usuario, id_usuario, id_cliente, registro, consulta, valor_cliente, lectura_reportes, anulacion, fecha_asignacion, id_usuario_asignacion) VALUES(:rol, :tipo_usuario, :id_usuario, :id_cliente, :registro, :consulta, :valor_cliente, :lectura_reportes, :anulacion, :fecha_asignacion, :id_usuario_asignacion)");
			
			$sql->bindParam(":rol", $rol);
			$sql->bindParam(":tipo_usuario", $tipo_usuario);
			$sql->bindParam(":id_usuario", $id_usuario);
			$sql->bindParam(":id_cliente", $id_cliente);
			$sql->bindParam(":registro", $registro);
			$sql->bindParam(":consulta", $consulta);
			$sql->bindParam(":valor_cliente", $valor_cliente);
			$sql->bindParam(":lectura_reportes", $lectura_reportes);
			$sql->bindParam(":anulacion", $anulacion);
			$sql->bindParam(":fecha_asignacion", $fecha_asignacion);
			$sql->bindParam(":id_usuario_asignacion", $id_usuario_asignacion);
			$sql->execute();

			//echo "INSERT INTO permisos_usuarios_mod_operativo (rol, tipo_usuario, id_usuario, id_cliente, registro, consulta, valor_cliente, lectura_reportes, anulacion, fecha_asignacion, id_usuario_asignacion) VALUES($rol, $tipo_usuario, $id_usuario, $id_cliente, $registro, $consulta, $valor_cliente, $lectura_reportes, $anulacion, $fecha_asignacion, $id_usuario_asignacion)";

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function listarPermisosUsuariosOperativo(){
		$listarPU = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM permisos_usuarios_mod_operativo ORDER BY fecha_asignacion ASC");
		$sql->execute();

		while ($filas= $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarPU[] = $filas;
		}
		return $listarPU;
	}
	
	public function listarPermisosUsuariosOperativoID($id){
		$listarID = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM permisos_usuarios_mod_operativo WHERE id = :id");
		$sql->bindParam(":id", $id);
		$sql->execute();

		while ($filas= $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarID[] = $filas;
		}
		return $listarID;
	}
	

	public function listarPermisosUsuariosOperativoIdUsuario($id_usuario){
		$listarPUId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM permisos_usuarios_mod_operativo WHERE id_usuario = :id_usuario");
		$sql->bindParam(":id_usuario", $id_usuario);
		$sql->execute();

		while ($filas= $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarPUId[] = $filas;
		}
		return $listarPUId;
	}
	
	/* --------------------------------------------------- */
	/* --------------------------------------------------- */
	/* --------------------------------------------------- */

	public function listarClasesMovilClientes(){
		$listarCMClientes = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM clases_movil_cliente");
		$sql->execute();

		while ($filas= $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarCMClientes[] = $filas;
		}
		return $listarCMClientes;
	}
	
	public function listarClasesMovilClientesID($id){
		$listarCMClientes = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM clases_movil_cliente WHERE id = :id");
		$sql->bindParam(":id", $id);
		$sql->execute();

		while ($filas= $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarCMClientes[] = $filas;
		}
		return $listarCMClientes;
	}
	
	public function listarClasesMovilPorIdCliente($id_cliente){
		$listarCMClientes = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM clases_movil_cliente WHERE id_cliente = :id_cliente");
		$sql->bindParam(":id_cliente", $id_cliente);
		$sql->execute();

		while ($filas= $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarCMClientes[] = $filas;
		}
		return $listarCMClientes;
	}

	public function listarClasesMovilPorNombreYCliente($id_cliente, $clase_movil_producto){
		$listarCM = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM clases_movil_cliente WHERE id_cliente = :id_cliente AND clase_movil_producto LIKE :clase_movil_producto");
		$sql->bindParam(":id_cliente", $id_cliente);
		$sql->bindParam(":clase_movil_producto", $clase_movil_producto);
		$sql->execute();

		while ($filas= $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarCM[] = $filas;
		}
		return $listarCM;
	}
	
	public function listarProductosPorCliente($id_cliente){
		$listarProductoC = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM productos_clientes WHERE id_cliente = :id_cliente");
		$sql->bindParam(":id_cliente", $id_cliente);
		$sql->execute();

		while ($filas= $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarProductoC[] = $filas;
		}
		return $listarProductoC;
	}

	public function listarProductosPorID($id_producto){
		$listarProID = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM productos_clientes WHERE id_producto = :id_producto");
		$sql->bindParam(":id_producto", $id_producto);
		$sql->execute();

		while ($filas= $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarProID[] = $filas;
		}
		return $listarProID;
	}

	public function listarProductosPorNombreYCliente($id_cliente, $detalle_producto){
		$listarPrNombre = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM productos_clientes WHERE id_cliente = :id_cliente AND detalle_producto LIKE :detalle_producto ");
		$sql->bindParam(":detalle_producto", $detalle_producto);
		$sql->bindParam(":id_cliente", $id_cliente);
		$sql->execute();

		//echo "SELECT * FROM productos_clientes WHERE id_cliente = $id_cliente AND detalle_producto LIKE $detalle_producto";

		while ($filas= $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarPrNombre[] = $filas;
		}
		return $listarPrNombre;
	}

	public function listarTarifasProductosPorID($id_producto){
		$listarProID = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM tarifas_productos_clientes WHERE id_producto = :id_producto ORDER BY id_tipo_vehiculo ASC");
		$sql->bindParam(":id_producto", $id_producto);
		$sql->execute();

		while ($filas= $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarProID[] = $filas;
		}
		return $listarProID;
	}

	public function listarServiciosPorID($id_servicio){
		$listarservID = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM base_servicios WHERE id_servicio_base = :id_servicio");
		$sql->bindParam(":id_servicio", $id_servicio);
		$sql->execute();

		while ($filas= $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarservID[] = $filas;
		}
		return $listarservID;
	}

	public function listarTarifasProductosPorIdYTipoVehiculo($id_producto, $id_tipo_vehiculo){
		$listarTarifasIdYTv = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM tarifas_productos_clientes WHERE id_producto = :id_producto AND id_tipo_vehiculo = :id_tipo_vehiculo");
		$sql->bindParam(":id_producto", $id_producto);
		$sql->bindParam(":id_tipo_vehiculo", $id_tipo_vehiculo);
		$sql->execute();

		//echo "SELECT * FROM tarifas_productos_clientes WHERE id_producto = '$id_producto' AND id_tipo_vehiculo = '$id_tipo_vehiculo' ";

		while ($filas= $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarTarifasIdYTv[] = $filas;
		}
		return $listarTarifasIdYTv;
	}

	public function registrarProductoCliente($id_cliente, $detalle_producto, $tipo_producto, $dias_aplicados_mensualidad, $dia_corte, $observaciones, $fecha_creacion, $id_usuario_creacion){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO productos_clientes (id_cliente, detalle_producto, tipo_producto, dias_aplicados_mensualidad, dia_corte, observaciones, estado, fecha_creacion, id_usuario_creacion) VALUES (:id_cliente, :detalle_producto, :tipo_producto, :dias_aplicados_mensualidad, :dia_corte, :observaciones, 'A', :fecha_creacion, :id_usuario_creacion);");

			$sql->bindParam(":id_cliente", $id_cliente);
			$sql->bindParam(":detalle_producto", $detalle_producto);
			$sql->bindParam(":tipo_producto", $tipo_producto);
			$sql->bindParam(":dias_aplicados_mensualidad", $dias_aplicados_mensualidad);
			$sql->bindParam(":dia_corte", $dia_corte);
			$sql->bindParam(":observaciones", $observaciones);
			$sql->bindParam(":fecha_creacion", $fecha_creacion);
			$sql->bindParam(":id_usuario_creacion", $id_usuario_creacion);

			$sql->execute();

			if ($sql) {
				return $con->lastInsertId();
			}

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function registrarClaseMovilCliente($id_cliente, $clase_movil_producto, $capacidad, $id_tipo_vehiculo, $observaciones, $id_usuario_creacion, $fecha_creacion){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO clases_movil_cliente (id_cliente, clase_movil_producto, capacidad, id_tipo_vehiculo, observaciones, estado, id_usuario_creacion, fecha_creacion) VALUES (:id_cliente, :clase_movil_producto, :capacidad, :id_tipo_vehiculo, :observaciones, 'A', :id_usuario_creacion, :fecha_creacion);");

			$sql->bindParam(":id_cliente", $id_cliente);
			$sql->bindParam(":clase_movil_producto", $clase_movil_producto);
			$sql->bindParam(":capacidad", $capacidad);
			$sql->bindParam(":id_tipo_vehiculo", $id_tipo_vehiculo);
			$sql->bindParam(":observaciones", $observaciones);
			$sql->bindParam(":id_usuario_creacion", $id_usuario_creacion);
			$sql->bindParam(":fecha_creacion", $fecha_creacion);
			
			$sql->execute();

			//echo "INSERT INTO clases_movil_producto (id_cliente, clase_movil_producto, capacidad, id_tipo_vehiculo, observaciones, estado) VALUES ('$id_cliente', '$clase_movil_producto', '$capacidad', '$id_tipo_vehiculo', '$observaciones', 'A');";

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function actualizarClaseMovilCliente($id, $id_cliente, $clase_movil_producto, $capacidad, $id_tipo_vehiculo, $observaciones, $estado){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE clases_movil_cliente SET id_cliente = :id_cliente, clase_movil_producto = :clase_movil_producto, capacidad = :capacidad, id_tipo_vehiculo = :id_tipo_vehiculo, observaciones = :observaciones, estado = :estado WHERE id = :id");

			$sql->bindParam(":id", $id);
			$sql->bindParam(":id_cliente", $id_cliente);
			$sql->bindParam(":clase_movil_producto", $clase_movil_producto);
			$sql->bindParam(":capacidad", $capacidad);
			$sql->bindParam(":id_tipo_vehiculo", $id_tipo_vehiculo);
			$sql->bindParam(":observaciones", $observaciones);
			$sql->bindParam(":estado", $estado);
			
			$sql->execute();

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function actualizarProductoCliente($id_producto, $id_cliente, $detalle_producto, $tipo_producto, $dias_aplicados_mensualidad, $dia_corte, $observaciones){

		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE productos_clientes SET id_cliente = :id_cliente, detalle_producto = :detalle_producto, tipo_producto = :tipo_producto, dias_aplicados_mensualidad = :dias_aplicados_mensualidad, dia_corte = :dia_corte, observaciones = :observaciones WHERE id_producto = :id_producto");

			$sql->bindParam(":id_producto", $id_producto);
			$sql->bindParam(":id_cliente", $id_cliente);
			$sql->bindParam(":detalle_producto", $detalle_producto);
			$sql->bindParam(":tipo_producto", $tipo_producto);
			$sql->bindParam(":dias_aplicados_mensualidad", $dias_aplicados_mensualidad);
			$sql->bindParam(":dia_corte", $dia_corte);
			$sql->bindParam(":observaciones", $observaciones);

			$sql->execute();

			//echo "UPDATE productos_clientes SET id_cliente = '$id_cliente', detalle_producto = '$detalle_producto', tipo_producto = '$tipo_producto', dias_aplicados_mensualidad = '$dias_aplicados_mensualidad', dia_corte = '$dia_corte', observaciones = '$observaciones' WHERE id_producto = '$id_producto'";

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function eliminarTarifasProductos($id_producto){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("DELETE FROM tarifas_productos_clientes WHERE id_producto = :id_producto");
			$sql->bindParam(":id_producto", $id_producto);

			$sql->execute();

			if ($sql) {
				return 1;
			}else{
				return 0;
			}

		} catch (Exception $e) {
			echo $e->getMesage();
		}
	}

	public function eliminarVehiculosServicio($id_servicio){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("DELETE FROM base_servicio_vehiculos WHERE id_servicio = :id_servicio");
			$sql->bindParam(":id_servicio", $id_servicio);

			$sql->execute();

		} catch (Exception $e) {
			echo $e->getMesage();
		}
	}

	public function registrarTarifasProductoCliente($id_tipo_vehiculo, $id_producto, $id_cliente, $valor_recorrido, $valor_hora, $recorridos_x_dia, $valor_mensual, $valor_relevo_sencillo, $valor_relevo_doble, $costo_disponibilidad){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO tarifas_productos_clientes (id_tipo_vehiculo, id_producto, id_cliente, valor_recorrido, valor_hora, recorridos_x_dia, valor_mensual, valor_relevo_sencillo, valor_relevo_doble, costo_disponibilidad) VALUES (:id_tipo_vehiculo, :id_producto, :id_cliente, :valor_recorrido, :valor_hora, :recorridos_x_dia, :valor_mensual, :valor_relevo_sencillo, :valor_relevo_doble, :costo_disponibilidad); ");

			$sql->bindParam(":id_tipo_vehiculo", $id_tipo_vehiculo);
			$sql->bindParam(":id_producto", $id_producto);
			$sql->bindParam(":id_cliente", $id_cliente);
			$sql->bindParam(":valor_recorrido", $valor_recorrido);
			$sql->bindParam(":valor_hora", $valor_hora);
			$sql->bindParam(":recorridos_x_dia", $recorridos_x_dia);
			$sql->bindParam(":valor_mensual", $valor_mensual);
			$sql->bindParam(":valor_relevo_sencillo", $valor_relevo_sencillo);
			$sql->bindParam(":valor_relevo_doble", $valor_relevo_doble);
			$sql->bindParam(":costo_disponibilidad", $costo_disponibilidad);

			$sql->execute();

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function registrarServicio($id_cliente, $id_contrato, $id_producto, $division_cliente, $tipo_servicio, $grupo, $solicitante, $fecha_inicio, $hora_inicio, $origen, $destino, $fecha_final, $hora_final, $observaciones, $requisitos, $estado, $id_usuario_creador, $fecha_creacion){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO base_servicios (id_cliente, id_contrato, id_producto, division_cliente, tipo_servicio, grupo, solicitante, fecha_inicio, hora_inicio, origen, destino, fecha_final, hora_final, observaciones, requisitos, estado_servicio, id_usuario_creador, fecha_creacion) VALUES (:id_cliente, :id_contrato, :id_producto, :division_cliente, :tipo_servicio, :grupo, :solicitante, :fecha_inicio, :hora_inicio, :origen, :destino, :fecha_final, :hora_final, :observaciones, :requisitos, :estado, :id_usuario_creador, :fecha_creacion); ");

			$sql->bindParam(":id_cliente", $id_cliente);
			$sql->bindParam(":id_contrato", $id_contrato);
			$sql->bindParam(":id_producto", $id_producto);
			$sql->bindParam(":division_cliente", $division_cliente);
			$sql->bindParam(":tipo_servicio", $tipo_servicio);
			$sql->bindParam(":grupo", $grupo);
			$sql->bindParam(":solicitante", $solicitante);
			$sql->bindParam(":fecha_inicio", $fecha_inicio);
			$sql->bindParam(":hora_inicio", $hora_inicio);
			$sql->bindParam(":origen", $origen);
			$sql->bindParam(":destino", $destino);
			$sql->bindParam(":fecha_final", $fecha_final);
			$sql->bindParam(":hora_final", $hora_final);
			$sql->bindParam(":observaciones", $observaciones);
			$sql->bindParam(":requisitos", $requisitos);
			$sql->bindParam(":estado", $estado);
			$sql->bindParam(":id_usuario_creador", $id_usuario_creador);
			$sql->bindParam(":fecha_creacion", $fecha_creacion);

			$sql->execute();

			if ($sql) {
				return $con->lastInsertId();
			}

			//echo "INSERT INTO base_servicios (id_cliente, id_contrato, id_producto, division_cliente, tipo_servicio, grupo, solicitante, fecha_inicio, hora_inicio, origen, destino, fecha_final, hora_final, observaciones, requisitos, estado_servicio, id_usuario_creador, fecha_creacion) VALUES ('$id_cliente', '$id_contrato', '$id_producto', '$division_cliente', '$tipo_servicio', '$grupo', '$solicitante', '$fecha_inicio', '$hora_inicio', '$origen', '$destino', '$fecha_final', '$hora_final', '$observaciones', '$requisitos', 'A', '$id_usuario_creador', '$fecha_creacion')";

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function registrarServicioPruebas($id_cliente, $id_contrato, $id_producto, $division_cliente, $tipo_servicio, $grupo, $solicitante, $fecha_inicio, $hora_inicio, $origen, $destino, $fecha_final, $hora_final, $observaciones, $requisitos, $estado, $id_usuario_creador, $fecha_creacion){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO base_servicios (id_cliente, id_contrato, id_producto, division_cliente, tipo_servicio, grupo, solicitante, fecha_inicio, hora_inicio, origen, destino, fecha_final, hora_final, observaciones, requisitos, estado_servicio, id_usuario_creador, fecha_creacion) VALUES (:id_cliente, :id_contrato, :id_producto, :division_cliente, :tipo_servicio, :grupo, :solicitante, :fecha_inicio, :hora_inicio, :origen, :destino, :fecha_final, :hora_final, :observaciones, :requisitos, :estado, :id_usuario_creador, :fecha_creacion); ");

			$sql->bindParam(":id_cliente", $id_cliente);
			$sql->bindParam(":id_contrato", $id_contrato);
			$sql->bindParam(":id_producto", $id_producto);
			$sql->bindParam(":division_cliente", $division_cliente);
			$sql->bindParam(":tipo_servicio", $tipo_servicio);
			$sql->bindParam(":grupo", $grupo);
			$sql->bindParam(":solicitante", $solicitante);
			$sql->bindParam(":fecha_inicio", $fecha_inicio);
			$sql->bindParam(":hora_inicio", $hora_inicio);
			$sql->bindParam(":origen", $origen);
			$sql->bindParam(":destino", $destino);
			$sql->bindParam(":fecha_final", $fecha_final);
			$sql->bindParam(":hora_final", $hora_final);
			$sql->bindParam(":observaciones", $observaciones);
			$sql->bindParam(":requisitos", $requisitos);
			$sql->bindParam(":estado", $estado);
			$sql->bindParam(":id_usuario_creador", $id_usuario_creador);
			$sql->bindParam(":fecha_creacion", $fecha_creacion);

			// $sql->execute();

			// if ($sql) {
			// 	return $con->lastInsertId();
			// }

			echo "INSERT INTO base_servicios (id_cliente, id_contrato, id_producto, division_cliente, tipo_servicio, grupo, solicitante, fecha_inicio, hora_inicio, origen, destino, fecha_final, hora_final, observaciones, requisitos, estado, id_usuario_creador, fecha_creacion) VALUES ('$id_cliente', '$id_contrato', '$id_producto', '$division_cliente', '$tipo_servicio', '$grupo', '$solicitante', '$fecha_inicio', '$hora_inicio', '$origen', '$destino', '$fecha_final', '$hora_final', '$observaciones', '$requisitos', '$estado', '$id_usuario_creador', '$fecha_creacion');";

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function actualizarServicio($id_servicio, $id_cliente, $id_contrato, $id_producto, $division_cliente, $tipo_servicio, $grupo, $solicitante, $fecha_inicio, $hora_inicio, $origen, $destino, $fecha_final, $hora_final, $observaciones, $requisitos, $estado){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE base_servicios SET id_cliente = :id_cliente, id_contrato  = :id_contrato, id_producto = :id_producto, division_cliente = :division_cliente, tipo_servicio = :tipo_servicio, grupo = :grupo, solicitante = :solicitante, fecha_inicio = :fecha_inicio, hora_inicio = :hora_inicio, origen = :origen, destino = :destino, fecha_final = :fecha_final, hora_final = :hora_final, observaciones = :observaciones, requisitos = :requisitos, estado_servicio = :estado WHERE id_servicio_base = :id_servicio ");

			$sql->bindParam(":id_servicio", $id_servicio);
			$sql->bindParam(":id_cliente", $id_cliente);
			$sql->bindParam(":id_contrato", $id_contrato);
			$sql->bindParam(":id_producto", $id_producto);
			$sql->bindParam(":division_cliente", $division_cliente);
			$sql->bindParam(":tipo_servicio", $tipo_servicio);
			$sql->bindParam(":grupo", $grupo);
			$sql->bindParam(":solicitante", $solicitante);
			$sql->bindParam(":fecha_inicio", $fecha_inicio);
			$sql->bindParam(":hora_inicio", $hora_inicio);
			$sql->bindParam(":origen", $origen);
			$sql->bindParam(":destino", $destino);
			$sql->bindParam(":fecha_final", $fecha_final);
			$sql->bindParam(":hora_final", $hora_final);
			$sql->bindParam(":observaciones", $observaciones);
			$sql->bindParam(":requisitos", $requisitos);
			$sql->bindParam(":estado", $estado);

			$sql->execute();

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}


	public function actualizarValoresServicio($id_servicio, $valor_cliente, $valor_movil){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE base_servicio_vehiculos SET valor_cliente = :valor_cliente, valor_movil  = :valor_movil WHERE id_servicio = :id_servicio ");

			$sql->bindParam(":id_servicio", $id_servicio);
			$sql->bindParam(":valor_cliente", $valor_cliente);
			$sql->bindParam(":valor_movil", $valor_movil);

			$sql->execute();

			//echo "UPDATE base_servicio_vehiculos SET valor_cliente = '$valor_cliente', valor_movil = '$valor_movil' WHERE id_servicio_base = '$id_servicio'";

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function registrarVehiculosServicio($id_servicio, $servicio, $clase_vehiculo, $id_vehiculo, $id_conductor, $id_vehiculo_relevo, $cant_pasajeros, $kms, $valor_cliente, $descuento_cliente, $valor_movil, $descuento_movil, $disp){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO base_servicio_vehiculos(id_servicio, servicio, clase_vehiculo, id_vehiculo, id_conductor, id_vehiculo_relevo, cant_pasajeros, kms, valor_cliente, descuento_cliente, valor_movil, descuento_movil, disp, estado) VALUES (:id_servicio, :servicio, :clase_vehiculo, :id_vehiculo, :id_conductor, :id_vehiculo_relevo, :cant_pasajeros, :kms, :valor_cliente, :descuento_cliente, :valor_movil, :descuento_movil, :disp, 'A') ");

			$sql->bindParam(":id_servicio", $id_servicio);
			$sql->bindParam(":servicio", $servicio);
			$sql->bindParam(":clase_vehiculo", $clase_vehiculo);
			$sql->bindParam(":id_vehiculo", $id_vehiculo);
			$sql->bindParam(":id_conductor", $id_conductor);
			$sql->bindParam(":id_vehiculo_relevo", $id_vehiculo_relevo);
			$sql->bindParam(":cant_pasajeros", $cant_pasajeros);
			$sql->bindParam(":kms", $kms);
			$sql->bindParam(":valor_cliente", $valor_cliente);
			$sql->bindParam(":descuento_cliente", $descuento_cliente);
			$sql->bindParam(":valor_movil", $valor_movil);
			$sql->bindParam(":descuento_movil", $descuento_movil);
			$sql->bindParam(":disp", $disp);

			$sql->execute();

			//echo "INSERT INTO base_servicio_vehiculos(id_servicio, servicio, clase_vehiculo, id_vehiculo, id_conductor, id_vehiculo_relevo, cant_pasajeros, kms, valor_cliente, descuento, valor_movil, disp, estado) VALUES ('$id_servicio', '$servicio', '$clase_vehiculo', '$id_vehiculo', '$id_conductor', '$id_vehiculo_relevo', '$cant_pasajeros', '$kms', '$valor_cliente', '$descuento', '$valor_movil', '$disp', 'A')";

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function registrarVehiculosServicioPruebas($id_servicio, $servicio, $clase_vehiculo, $id_vehiculo, $id_conductor, $id_vehiculo_relevo, $cant_pasajeros, $kms, $valor_cliente, $descuento_cliente, $valor_movil, $descuento_movil, $disp){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO base_servicio_vehiculos(id_servicio, servicio, clase_vehiculo, id_vehiculo, id_conductor, id_vehiculo_relevo, cant_pasajeros, kms, valor_cliente, descuento_cliente, valor_movil, descuento_movil, disp, estado) VALUES (:id_servicio, :servicio, :clase_vehiculo, :id_vehiculo, :id_conductor, :id_vehiculo_relevo, :cant_pasajeros, :kms, :valor_cliente, :descuento_cliente, :valor_movil, :descuento_movil, :disp, 'A') ");

			$sql->bindParam(":id_servicio", $id_servicio);
			$sql->bindParam(":servicio", $servicio);
			$sql->bindParam(":clase_vehiculo", $clase_vehiculo);
			$sql->bindParam(":id_vehiculo", $id_vehiculo);
			$sql->bindParam(":id_conductor", $id_conductor);
			$sql->bindParam(":id_vehiculo_relevo", $id_vehiculo_relevo);
			$sql->bindParam(":cant_pasajeros", $cant_pasajeros);
			$sql->bindParam(":kms", $kms);
			$sql->bindParam(":valor_cliente", $valor_cliente);
			$sql->bindParam(":descuento_cliente", $descuento_cliente);
			$sql->bindParam(":valor_movil", $valor_movil);
			$sql->bindParam(":descuento_movil", $descuento_movil);
			$sql->bindParam(":disp", $disp);


			//$sql->execute();

			echo "INSERT INTO base_servicio_vehiculos(id_servicio, servicio, clase_vehiculo, id_vehiculo, id_conductor, id_vehiculo_relevo, cant_pasajeros, kms, valor_cliente, descuento, valor_movil, disp, estado) VALUES ('$id_servicio', '$servicio', '$clase_vehiculo', '$id_vehiculo', '$id_conductor', '$id_vehiculo_relevo', '$cant_pasajeros', '$kms', '$valor_cliente', '$descuento_cliente', '$valor_movil', '$descuento_movil', '$disp', 'A')";

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}


	/* ------------------------------------------------------------- */
	/* ------------------------------------------------------------- */
	/* ------------------------------------------------------------- */


	function listarControlMantenimientos(){
		$listarCM = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM control_mantenimientos ORDER BY id_mantenimiento DESC");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarCM[] = $filas;
		}

		return $listarCM;
	}

	function listarControlMantenimientosID($id_mantenimiento){
		$listarCM = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM control_mantenimientos WHERE id_mantenimiento = :id_mantenimiento ");
		$sql->bindParam(":id_mantenimiento", $id_mantenimiento);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarCM[] = $filas;
		}

		return $listarCM;
	}

	function listarControlMantenimientosporVehiculo($id_vehiculo, $fecha_mtto){
		$listarCMV = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM control_mantenimientos WHERE id_mantenimiento = (SELECT MAX(id_mantenimiento) FROM control_mantenimientos WHERE id_vehiculo = :id_vehiculo AND fecha_mtto = :fecha_mtto)");
		$sql->bindParam(":id_vehiculo", $id_vehiculo);
		$sql->bindParam(":fecha_mtto", $fecha_mtto);
		$sql->execute();

		//echo "SELECT * FROM control_mantenimientos WHERE id_mantenimiento = (SELECT MAX(id_mantenimiento) FROM control_mantenimientos WHERE id_vehiculo = '$id_vehiculo' AND fecha_mtto = '$fecha_mtto')";

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarCMV[] = $filas;
		}

		return $listarCMV;
	}
	
	function listarControlMantenimientosporVehiculoSinFecha($id_vehiculo){
		$listarCMV = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM control_mantenimientos WHERE id_mantenimiento = (SELECT MAX(id_mantenimiento) FROM control_mantenimientos WHERE id_vehiculo = :id_vehiculo)");
		$sql->bindParam(":id_vehiculo", $id_vehiculo);
		$sql->execute();

		//echo "SELECT * FROM control_mantenimientos WHERE id_mantenimiento = (SELECT MAX(id_mantenimiento) FROM control_mantenimientos WHERE id_vehiculo = '$id_vehiculo' AND fecha_mtto = '$fecha_mtto')";

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarCMV[] = $filas;
		}

		return $listarCMV;
	}

	function actualizarControlMantenimiento($id_mantenimiento, $id_vehiculo, $tipo_servicio, $enviado_por, $fecha_mtto, $detalle_mtto, $valor_mtto, $forma_pago, $estado, $observaciones){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE control_mantenimientos SET id_vehiculo = :id_vehiculo, tipo_servicio = :tipo_servicio, enviado_por = :enviado_por, fecha_mtto = :fecha_mtto, detalle_mtto =  :detalle_mtto, valor_mtto = :valor_mtto, forma_pago = :forma_pago, estado = :estado, observaciones = :observaciones WHERE id_mantenimiento = :id_mantenimiento");
			
			$sql->bindParam(":id_mantenimiento", $id_mantenimiento);
			$sql->bindParam(":id_vehiculo", $id_vehiculo);
			$sql->bindParam(":tipo_servicio", $tipo_servicio);
			$sql->bindParam(":enviado_por", $enviado_por);
			$sql->bindParam(":fecha_mtto", $fecha_mtto);
			$sql->bindParam(":detalle_mtto", $detalle_mtto);
			$sql->bindParam(":valor_mtto", $valor_mtto);
			$sql->bindParam(":forma_pago", $forma_pago);
			$sql->bindParam(":estado", $estado);
			$sql->bindParam(":observaciones", $observaciones);

			$sql->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function registrarControlMantenimiento($id_vehiculo, $tipo_servicio, $enviado_por, $fecha_mtto, $detalle_mtto, $valor_mtto, $forma_pago, $estado, $observaciones, $id_usuario_creador, $fecha_creacion){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO control_mantenimientos (id_vehiculo, tipo_servicio, enviado_por, fecha_mtto, detalle_mtto, valor_mtto, forma_pago, estado, observaciones, id_usuario_creador, fecha_creacion) VALUES (:id_vehiculo, :tipo_servicio, :enviado_por, :fecha_mtto, :detalle_mtto, :valor_mtto, :forma_pago, :estado, :observaciones, :id_usuario_creador, :fecha_creacion); ");
			
			$sql->bindParam(":id_vehiculo", $id_vehiculo);
			$sql->bindParam(":tipo_servicio", $tipo_servicio);
			$sql->bindParam(":enviado_por", $enviado_por);
			$sql->bindParam(":fecha_mtto", $fecha_mtto);
			$sql->bindParam(":detalle_mtto", $detalle_mtto);
			$sql->bindParam(":valor_mtto", $valor_mtto);
			$sql->bindParam(":forma_pago", $forma_pago);
			$sql->bindParam(":estado", $estado);
			$sql->bindParam(":observaciones", $observaciones);
			$sql->bindParam(":id_usuario_creador", $id_usuario_creador);
			$sql->bindParam(":fecha_creacion", $fecha_creacion);

			$sql->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function listarServiciosPorVehiculo($fecha, $fecha2, $id_vehiculo){
		$listarServicios = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM base_servicios AS bs LEFT JOIN base_servicio_vehiculos AS bsv ON bs.id_servicio_base = bsv.id_servicio WHERE (DATE(bs.fecha_inicio) >= '$fecha' AND DATE(bs.fecha_inicio) <= '$fecha2') AND (JSON_EXTRACT(bsv.id_vehiculo, '$.entrada') $id_vehiculo OR JSON_EXTRACT(bsv.id_vehiculo, '$.salida') $id_vehiculo)");

		$sql->bindParam(":fecha", $fecha);
		$sql->bindParam(":fecha2", $fecha2);
		$sql->bindParam(":id_vehiculo", $id_vehiculo);
		$sql->execute();

		//echo "SELECT * FROM base_servicios AS bs LEFT JOIN base_servicio_vehiculos AS bsv ON bs.id_servicio_base = bsv.id_servicio WHERE (DATE(bs.fecha_inicio) >= '$fecha' AND DATE(bs.fecha_inicio) <= '$fecha2') AND ((JSON_EXTRACT(bsv.id_vehiculo, '$.entrada') $id_vehiculo OR JSON_EXTRACT(bsv.id_vehiculo, '$.salida') $id_vehiculo) GROUP BY bsv.id_servicio";

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarServicios[] = $filas;
		}
		return $listarServicios;
	}

	/* ---------------------------------------------- */

	public function listarAcuerdosPago(){
		$listarAP = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM acuerdos_pago ORDER BY id ASC");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarAP[] = $filas;
		}
		return $listarAP;
	}


}

 ?>