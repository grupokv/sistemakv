<?php 
require_once ("Conexion/conexionBD.php");


class Cartera{
    
    public function listarRodamientosCartera(){
        $rodamientos = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM rodamientos");
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $rodamientos[] = $filas;
        }
        
        return $rodamientos;
        
    }

    /* ---------------- ******************** ---------------- */

    public function listarCarteraVehiculosAfiliados($mes_fecha_cobro, $anio_fecha_cobro){
        $carteraAfiliados = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT cp.id_cobro, cp.id_vehiculo, cp.id_concepto, cp.valor, cp.fecha_cobro FROM cobro_propietario AS cp INNER JOIN vehiculos AS v ON cp.id_vehiculo = v.id_vehiculo WHERE MONTH(cp.fecha_cobro) = :mes_fecha_cobro AND YEAR(cp.fecha_cobro) = :anio_fecha_cobro AND v.tipo_afiliacion = 'AFILIADO' AND cp.estado = 'P' ");
        $sql->bindParam(":mes_fecha_cobro", $mes_fecha_cobro);        
        $sql->bindParam(":anio_fecha_cobro", $anio_fecha_cobro);        
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $carteraAfiliados[] = $filas;
        }
        
        return $carteraAfiliados;
        
    }

    public function actualizarValorConceptoCartera($id_cobro, $valor){
        
        try{

            $con = Conexion::conectar();
            $sql = $con->prepare("UPDATE cobro_propietario SET valor = :valor WHERE id_cobro = :id_cobro ");
            $sql->bindParam(":id_cobro", $id_cobro);        
            $sql->bindParam(":valor", $valor);        
            $sql->execute();

            //echo "UPDATE cobro_propietario SET valor = '$valor' WHERE id_cobro = '$id_cobro'";
            
        }catch(Exception $e){
            echo $e->getMessage();
        }

    }

    /* ---------------- ******************** ---------------- */
	
	public function reporteGeneral(){
        $rodamientos = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT vehiculos.placa, vehiculos.numero_movil, sum(cobro_propietario.valor) as total FROM cobro_propietario, vehiculos WHERE cobro_propietario.estado = 'P' and vehiculos.id_vehiculo = cobro_propietario.id_vehiculo group by cobro_propietario.id_vehiculo order by vehiculos.numero_movil Asc");
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $rodamientos[] = $filas;
        }
        
        return $rodamientos;
        
    }
    
    public function listarPolizasCartera(){
        $polizas = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM polizas_cartera");
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $polizas[] = $filas;
        }
        
        return $polizas;
        
    }
    
    public function registrarRodamientosCartera($id_empresa, $nombre_cliente, $tipo_identificacion, $num_identificacion, $valor_total, $por_vencer, $dias_mora_1_30, $dias_mora_31_60, $dias_mora_61_90, $dias_mora_mayor_90, $id_usuario_creador, $fecha_creacion){
        try{
            $con = Conexion::conectar();
            $sql = $con->prepare("INSERT INTO rodamientos (id_empresa, nombre_cliente, tipo_identificacion, num_identificacion, valor_total, por_vencer, dias_mora_1_30, dias_mora_31_60, dias_mora_61_90, dias_mora_mayor_90, id_usuario_creador, fecha_creacion) VALUES(:id_empresa, :nombre_cliente, :tipo_identificacion, :num_identificacion, :valor_total, :por_vencer, :dias_mora_1_30, :dias_mora_31_60, :dias_mora_61_90, :dias_mora_mayor_90, :id_usuario_creador, :fecha_creacion)");
            $sql->bindParam(":id_empresa", $id_empresa);
            $sql->bindParam(":nombre_cliente", $nombre_cliente);
            $sql->bindParam(":tipo_identificacion", $tipo_identificacion);
            $sql->bindParam(":num_identificacion", $num_identificacion);
            $sql->bindParam(":valor_total", $valor_total);
            $sql->bindParam(":por_vencer", $por_vencer);
            $sql->bindParam(":dias_mora_1_30", $dias_mora_1_30);
            $sql->bindParam(":dias_mora_31_60", $dias_mora_31_60);
            $sql->bindParam(":dias_mora_61_90", $dias_mora_61_90);
            $sql->bindParam(":dias_mora_mayor_90", $dias_mora_mayor_90);
            $sql->bindParam(":id_usuario_creador", $id_usuario_creador);
            $sql->bindParam(":fecha_creacion", $fecha_creacion);
            
            $sql->execute();
            
            //echo "INSERT INTO rodamientos (id_empresa, nombre_cliente, tipo_identificacion, num_identificacion, valor_total, por_vencer, dias_mora_1_30, dias_mora_31_60, dias_mora_61_90, dias_mora_mayor_90, id_usuario_creador, fecha_creacion) VALUES('$id_empresa', '$nombre_cliente', '$tipo_identificacion', '$num_identificacion', '$valor_total', '$por_vencer', '$dias_mora_1_30', '$dias_mora_31_60', '$dias_mora_61_90', '$dias_mora_mayor_90', '$id_usuario_creador', '$fecha_creacion')";
            
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    
    public function registrarPolizasCartera($id_empresa, $nombre_cliente, $tipo_identificacion, $num_identificacion, $valor_total, $por_vencer, $dias_mora_1_30, $dias_mora_31_60, $dias_mora_61_90, $dias_mora_mayor_90, $id_usuario_creador, $fecha_creacion){
        try{
            $con = Conexion::conectar();
            $sql = $con->prepare("INSERT INTO polizas_cartera (id_empresa, nombre_cliente, tipo_identificacion, num_identificacion, valor_total, por_vencer, dias_mora_1_30, dias_mora_31_60, dias_mora_61_90, dias_mora_mayor_90, id_usuario_creador, fecha_creacion) VALUES(:id_empresa, :nombre_cliente, :tipo_identificacion, :num_identificacion, :valor_total, :por_vencer, :dias_mora_1_30, :dias_mora_31_60, :dias_mora_61_90, :dias_mora_mayor_90, :id_usuario_creador, :fecha_creacion)");
            $sql->bindParam(":id_empresa", $id_empresa);
            $sql->bindParam(":nombre_cliente", $nombre_cliente);
            $sql->bindParam(":tipo_identificacion", $tipo_identificacion);
            $sql->bindParam(":num_identificacion", $num_identificacion);
            $sql->bindParam(":valor_total", $valor_total);
            $sql->bindParam(":por_vencer", $por_vencer);
            $sql->bindParam(":dias_mora_1_30", $dias_mora_1_30);
            $sql->bindParam(":dias_mora_31_60", $dias_mora_31_60);
            $sql->bindParam(":dias_mora_61_90", $dias_mora_61_90);
            $sql->bindParam(":dias_mora_mayor_90", $dias_mora_mayor_90);
            $sql->bindParam(":id_usuario_creador", $id_usuario_creador);
            $sql->bindParam(":fecha_creacion", $fecha_creacion);
            
            $sql->execute();
            
            //echo "INSERT INTO polizas_cartera (id_empresa, nombre_cliente, tipo_identificacion, num_identificacion, valor_total, por_vencer, dias_mora_1_30, dias_mora_31_60, dias_mora_61_90, dias_mora_mayor_90, id_usuario_creador, fecha_creacion) VALUES('$id_empresa', '$nombre_cliente', '$tipo_identificacion', '$num_identificacion', '$valor_total', '$por_vencer', '$dias_mora_1_30', '$dias_mora_31_60', '$dias_mora_61_90', '$dias_mora_mayor_90', '$id_usuario_creador', '$fecha_creacion')";
            
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    
    public function listarDescuentosCartera(){
        $descuentos = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM descuentos_cartera");
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $descuentos[] = $filas;
        }
        
        return $descuentos;
    }
    
    public function listarDescuentosCarteraPorId($id_descuento){
        $descuentosId = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM descuentos_cartera WHERE id_descuento = :id_descuento"); 
        $sql->bindParam(":id_descuento", $id_descuento);
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $descuentosId[] = $filas;
        }
        
        return $descuentosId;
    }
    
    public function listarDescuentosCarteraPorIdVehiculo($id_vehiculo, $id_concepto){
        $descuentosIdVehiculo = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM descuentos_cartera WHERE id_vehiculo = :id_vehiculo AND id_concepto = :id_concepto"); 
        $sql->bindParam(":id_vehiculo", $id_vehiculo);
        $sql->bindParam(":id_concepto", $id_concepto);
        $sql->execute();
        
        //echo "SELECT * FROM descuentos_cartera WHERE id_vehiculo = '$id_vehiculo' AND id_concepto = '$id_concepto' ";
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $descuentosIdVehiculo[] = $filas;
        }
        
        return $descuentosIdVehiculo;
    }
    
    public function registrarDescuentos($id_vehiculo, $id_concepto, $tipo_descuento, $descuento, $fecha_inicial_valido, $fecha_final_valido, $id_usuario_creador, $fecha_creacion_descuento, $descuento_nomina, $id_cliente){
        
        try{
            $con = Conexion::conectar();
            $sql = $con->prepare("INSERT INTO descuentos_cartera (id_vehiculo, id_concepto, tipo_descuento, descuento, fecha_inicial_valido, fecha_final_valido, id_usuario_creador, fecha_creacion_descuento, estado, descuento_nomina, id_cliente) VALUES(:id_vehiculo, :id_concepto, :tipo_descuento, :descuento, :fecha_inicial_valido, :fecha_final_valido, :id_usuario_creador, :fecha_creacion_descuento, 'A', :descuento_nomina, :id_cliente)"); 
            $sql->bindParam(":id_vehiculo", $id_vehiculo);
            $sql->bindParam(":id_concepto", $id_concepto);
            $sql->bindParam(":tipo_descuento", $tipo_descuento);
            $sql->bindParam(":descuento", $descuento);
            $sql->bindParam(":fecha_inicial_valido", $fecha_inicial_valido);
            $sql->bindParam(":fecha_final_valido", $fecha_final_valido);
            $sql->bindParam(":id_usuario_creador", $id_usuario_creador);
            $sql->bindParam(":fecha_creacion_descuento", $fecha_creacion_descuento);
            $sql->bindParam(":descuento_nomina", $descuento_nomina);
            $sql->bindParam(":id_cliente", $id_cliente);
            
            $sql->execute();
            
            //echo "INSERT INTO descuentos_cartera (id_vehiculo, id_concepto, tipo_descuento, descuento, fecha_inicial_valido, fecha_final_valido, id_usuario_creador, fecha_creacion_descuento, estado, descuento_nomina, id_cliente) VALUES('$id_vehiculo', '$id_concepto', '$tipo_descuento', '$descuento', '$fecha_inicial_valido', '$fecha_final_valido', '$id_usuario_creador', '$fecha_creacion_descuento', 'A', '$descuento_nomina', '$id_cliente')";
            
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    
    public function actualizarDescuentos($id_descuento, $id_vehiculo, $id_concepto, $tipo_descuento, $descuento, $fecha_inicial_valido, $fecha_final_valido, $id_usuario_creador, $fecha_creacion_descuento, $estado){
        
        try{
            $con = Conexion::conectar();
            $sql = $con->prepare("UPDATE descuentos_cartera SET id_vehiculo = :id_vehiculo, id_concepto = :id_concepto, tipo_descuento = :tipo_descuento, descuento = :descuento, fecha_inicial_valido = :fecha_inicial_valido, fecha_final_valido = :fecha_final_valido, id_usuario_creador = :id_usuario_creador, fecha_creacion_descuento = :fecha_creacion_descuento, estado = :estado WHERE id_descuento = :id_descuento "); 
            $sql->bindParam(":id_descuento", $id_descuento);
            $sql->bindParam(":id_vehiculo", $id_vehiculo);
            $sql->bindParam(":id_concepto", $id_concepto);
            $sql->bindParam(":tipo_descuento", $tipo_descuento);
            $sql->bindParam(":descuento", $descuento);
            $sql->bindParam(":fecha_inicial_valido", $fecha_inicial_valido);
            $sql->bindParam(":fecha_final_valido", $fecha_final_valido);
            $sql->bindParam(":id_usuario_creador", $id_usuario_creador);
            $sql->bindParam(":fecha_creacion_descuento", $fecha_creacion_descuento);
            $sql->bindParam(":estado", $estado);
            
            $sql->execute();
            
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    
    public function actualizarEstadoDescuentos($hoy){
        
        try{
            $con = Conexion::conectar();
            $sql = $con->prepare("UPDATE descuentos_cartera SET estado = 'I' WHERE fecha_final_valido < :hoy AND estado = 'A' "); 
            $sql->bindParam(":hoy", $hoy);
            
            $sql->execute();
            
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    
    public function registrarAnticipoCartera($id_vehiculo, $valor_anticipo, $num_id_comprobante, $id_concepto, $estado){
        try{
            $con = Conexion::conectar();
            $sql = $con->prepare("INSERT INTO anticipo_cartera (id_vehiculo, valor_anticipo, num_id_comprobante, id_concepto, estado) VALUES(:id_vehiculo, :valor_anticipo, :num_id_comprobante, :id_concepto, :estado); ");
            $sql->bindParam(":id_vehiculo", $id_vehiculo);
            $sql->bindParam(":valor_anticipo", $valor_anticipo);
            $sql->bindParam(":num_id_comprobante", $num_id_comprobante);
            $sql->bindParam(":id_concepto", $id_concepto);
            $sql->bindParam(":estado", $estado);
            
            $sql->execute();
            
            //echo "INSERT INTO anticipo_cartera (valor_anticipo, num_id_comprobante, id_concepto, fecha_inicial_valido, fecha_final_valido) VALUES('$valor_anticipo', '$num_id_comprobante', '$id_concepto', '$fecha_inicial_valido', '$fecha_final_valido')";
            
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    
    public function actualizarEstadoAnticipoCartera($id_anticipo, $estado){
        try{
            $con = Conexion::conectar();
            $sql = $con->prepare("UPDATE anticipo_cartera SET estado = :estado WHERE id_anticipo = :id_anticipo");
            $sql->bindParam(":id_anticipo", $id_anticipo);
            $sql->bindParam(":estado", $estado);
            
            $sql->execute();
            
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    
    public function actualizarValorAnticipoCartera($id_anticipo, $valor_anticipo){
        try{
            $con = Conexion::conectar();
            $sql = $con->prepare("UPDATE anticipo_cartera SET valor_anticipo = :valor_anticipo WHERE id_anticipo = :id_anticipo");
            $sql->bindParam(":id_anticipo", $id_anticipo);
            $sql->bindParam(":valor_anticipo", $valor_anticipo);
            
            $sql->execute();
            
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    
    public function registrarCruceDescuento($id_cobro, $id_descuento, $fecha_cruce, $hora_cruce){
        try{
            $con = Conexion::conectar();
            $sql = $con->prepare("INSERT INTO descuentos_cruzados (id_cobro, id_descuento, fecha_cruce, hora_cruce) VALUES(:id_cobro, :id_descuento, :fecha_cruce, :hora_cruce); ");
            $sql->bindParam(":id_cobro", $id_cobro);
            $sql->bindParam(":id_descuento", $id_descuento);
            $sql->bindParam(":fecha_cruce", $fecha_cruce);
            $sql->bindParam(":hora_cruce", $hora_cruce);
            
            $sql->execute();
            
            //echo "INSERT INTO descuentos_cruzados (id_cobro, id_descuento, fecha_cruce, hora_cruce) VALUES('$id_cobro', '$id_descuento', '$fecha_cruce', '$hora_cruce');";
            
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    
    public function listarAnticiposCarteraPorIdVehiculo($id_vehiculo, $id_concepto){
        $anticiposId = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM anticipo_cartera WHERE id_vehiculo = :id_vehiculo AND id_concepto = :id_concepto"); 
        $sql->bindParam(":id_vehiculo", $id_vehiculo);
        $sql->bindParam(":id_concepto", $id_concepto);
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $anticiposId[] = $filas;
        }
        
        return $anticiposId;
    }
    
    public function listarAnticiposCarteraPorComprobante($num_id_comprobante){
        $anticiposIdComprobante = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM anticipo_cartera WHERE num_id_comprobante = :num_id_comprobante"); 
        $sql->bindParam(":num_id_comprobante", $num_id_comprobante);
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $anticiposIdComprobante[] = $filas;
        }
        
        return $anticiposIdComprobante;
    }
    
    
    public function listarReporteDescuentosPorVehiculo($id_vehiculo){
            
        $descuentosPorVehiculo = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM descuentos_cartera WHERE id_vehiculo = :id_vehiculo AND estado = 'A'");
        $sql->bindParam(":id_vehiculo", $id_vehiculo);
        
        $sql->execute();
        
        //echo "SELECT * FROM descuentos_cartera WHERE id_vehiculo = :id_vehiculo";
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $descuentosPorVehiculo[] = $filas;
        }
        
        return $descuentosPorVehiculo;
            
    }
    
    public function listarReporteDescuentosPorNomina($id_cliente){
        
        $descuentosNomina = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM descuentos_cartera WHERE descuento_nomina = 'S' AND id_cliente = :id_cliente AND estado = 'A' ");
        $sql->bindParam(":id_cliente", $id_cliente);
        
        $sql->execute();
        
        //echo "SELECT * FROM descuentos_cartera WHERE id_vehiculo = :id_vehiculo";
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $descuentosNomina[] = $filas;
        }
        
        return $descuentosNomina;
    }
    
    public function listarReporteDescuentosCruzadosFiltro1($id_concepto, $fecha_cruce){
        
        $descuentosCruzadosFiltro1 = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM descuentos_cruzados AS dcc INNER JOIN descuentos_cartera As d ON dcc.id_descuento = d.id_descuento WHERE d.id_concepto = :id_concepto AND MONTH(dcc.fecha_cruce) = :fecha_cruce ");
        $sql->bindParam(":id_concepto", $id_concepto);
        $sql->bindParam(":fecha_cruce", $fecha_cruce);
        
        $sql->execute();
        
        //echo "SELECT * FROM descuentos_cruzados AS dcc INNER JOIN descuentos_cartera As d ON dcc.id_descuento = d.id_descuento WHERE d.id_concepto = '$id_concepto'  AND MONTH(dcc.fecha_cruce) = '$fecha_cruce' ";
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $descuentosCruzadosFiltro1[] = $filas;
        }
        
        return $descuentosCruzadosFiltro1;
        
    }
    
    public function listarReporteDescuentosCruzadosFiltro2($id_concepto){
        
        $descuentosCruzadosFiltro2 = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM descuentos_cruzados AS dcc INNER JOIN descuentos_cartera As d ON dcc.id_descuento = d.id_descuento WHERE d.id_concepto = :id_concepto ");
        $sql->bindParam(":id_concepto", $id_concepto);
        
        $sql->execute();
        
        //echo "SELECT * FROM descuentos_cruzados AS dcc INNER JOIN descuentos_cartera As d ON dcc.id_descuento = d.id_descuento WHERE d.id_concepto = '$id_concepto' ";
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $descuentosCruzadosFiltro2[] = $filas;
        }
        
        return $descuentosCruzadosFiltro2;
        
    }
    
    public function listarReporteTodosDescuentosCruzados(){
        
        $descuentosCruzados = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM descuentos_cruzados");
        
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $descuentosCruzados[] = $filas;
        }
        
        return $descuentosCruzados;
        
    }
    
    public function listarAnticiposPorVehiculo($id_vehiculo){
        
        $anticiposVehiculo = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM anticipo_cartera WHERE id_vehiculo = :id_vehiculo AND estado = 'A' ");
        $sql->bindParam(":id_vehiculo", $id_vehiculo);
        
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $anticiposVehiculo[] = $filas;
        }
        
        return $anticiposVehiculo;
        
    }
    
    
    public function registrarCruceSaldosCartera($id_anticipo, $valor_anticipo, $valor_a_pagar, $valor_total, $num_id_comprobante, $fecha_cruce){
        try{
            $con = Conexion::conectar();
            $sql = $con->prepare("INSERT INTO cruce_saldos_anticipos(id_anticipo, valor_anticipo, valor_a_pagar, valor_total, num_id_comprobante, fecha_cruce) VALUES (:id_anticipo, :valor_anticipo, :valor_a_pagar, :valor_total, :num_id_comprobante, :fecha_cruce); ");
            $sql->bindParam(":id_anticipo", $id_anticipo);
            $sql->bindParam(":valor_anticipo", $valor_anticipo);
            $sql->bindParam(":valor_a_pagar", $valor_a_pagar);
            $sql->bindParam(":valor_total", $valor_total);
            $sql->bindParam(":num_id_comprobante", $num_id_comprobante);
            $sql->bindParam(":fecha_cruce", $fecha_cruce);
            
            $sql->execute();
            
            //echo "INSERT INTO cruce_saldos_anticipos(id_anticipo, valor_anticipo, valor_a_pagar, valor_total, num_id_comprobante, fecha_cruce) VALUES ('$id_anticipo', '$valor_anticipo', '$valor_a_pagar', '$valor_total', '$num_id_comprobante', '$fecha_cruce');";
            
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    
    
    
    public function consultarAvalIdVehiculoMesAnio($id_vehiculo, $mes, $anio){
        
        $AvalIdVehiculoMes = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM aval_vehiculos WHERE id_vehiculo = :id_vehiculo AND mes = :mes AND anio = :anio");
        $sql->bindParam(":id_vehiculo", $id_vehiculo);
        $sql->bindParam(":mes", $mes);
        $sql->bindParam(":anio", $anio);
        
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $AvalIdVehiculoMes[] = $filas;
        }
        
        return $AvalIdVehiculoMes;
        
    }

    public function consultarAvalMesAnio($mes, $anio){
        
        $AvalMesAnio = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM aval_vehiculos WHERE mes = :mes AND anio = :anio ORDER BY fecha_activacion ASC");
        $sql->bindParam(":mes", $mes);
        $sql->bindParam(":anio", $anio);
        
        $sql->execute();

        //echo "SELECT * FROM aval_vehiculos WHERE mes = '$mes' AND anio = '$anio'";
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $AvalMesAnio[] = $filas;
        }
        
        return $AvalMesAnio;
        
    }
    
    
    public function consultarAvalIdVehiculo($id_vehiculo){
        
        $AvalIdVehiculo = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM aval_vehiculos WHERE id_vehiculo IN (:id_vehiculo) AND estado = 'A' ");
        $sql->bindParam(":id_vehiculo", $id_vehiculo);
        
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $AvalIdVehiculo[] = $filas;
        }
        
        return $AvalIdVehiculo;
        
    }

    public function consultarAvalesActivosMesVehiculo($id_vehiculo, $mes, $anio){
        
        $AvalesActivosMesIdV = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM aval_vehiculos WHERE id_vehiculo = :id_vehiculo AND mes = :mes AND anio = :anio AND estado = 'A' ");
        $sql->bindParam(":id_vehiculo", $id_vehiculo);
        $sql->bindParam(":mes", $mes);
        $sql->bindParam(":anio", $anio);
        
        $sql->execute();

        //echo "SELECT * FROM aval_vehiculos WHERE id_vehiculo = $id_vehiculo AND mes = $mes AND anio = $anio AND estado = 'A' ";
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $AvalesActivosMesIdV[] = $filas;
        }
        
        return $AvalesActivosMesIdV;
        
    }


    public function consultarAvalVehiculo($id_vehiculo){
        
        $AvalVehiculo = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM aval_vehiculos WHERE id_vehiculo = :id_vehiculo AND estado = 'A' ");
        $sql->bindParam(":id_vehiculo", $id_vehiculo);
        
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $AvalVehiculo[] = $filas;
        }
        
        return $AvalVehiculo;
        
    }


    public function consultarAvalID($id_aval){
        
        $AvalID = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM aval_vehiculos WHERE id_aval = :id_aval");
        $sql->bindParam(":id_aval", $id_aval);
        
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $AvalID[] = $filas;
        }
        
        return $AvalID;
        
    }

    public function consultarAvalIDs($id_aval){
        
        $AvalIDs = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM aval_vehiculos WHERE id_aval IN ($id_aval)");
        
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $AvalIDs[] = $filas;
        }
        
        return $AvalIDs;
        
    }
    
    
    
    public function listarCobroAvalesPorMes($mes){
        
        $AvalesVeh = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM aval_vehiculos WHERE mes = :mes ORDER BY id_aval ASC");
        $sql->bindParam(":mes", $mes);
        
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $AvalesVeh[] = $filas;
        }
        
        return $AvalesVeh;
        
    }


    public function ConsAvales(){
        
        $Avales = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM aval_vehiculos ORDER BY id_vehiculo ASC");
        
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $Avales[] = $filas;
        }
        
        return $Avales;
        
    }
    
    public function listarAvales($mes){
        
        $AvalesVeh = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM aval_vehiculos WHERE mes = :mes ORDER BY id_aval ASC");
        $sql->bindParam(":mes", $mes);
        
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $AvalesVeh[] = $filas;
        }
        
        return $AvalesVeh;
        
    }

    public function actualizarEstadoAvales($id_aval){
        try {
            $con = Conexion::conectar();
            $sql = $con->prepare("UPDATE aval_vehiculos SET estado = 'F' WHERE id_aval = :id_aval ORDER BY id_aval ASC");
            $sql->bindParam(":id_aval", $id_aval);
            
            $sql->execute();

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function eximirAvales($id_aval){
        try {
            $con = Conexion::conectar();
            $sql = $con->prepare("UPDATE aval_vehiculos SET estado = 'E' WHERE id_aval = :id_aval");
            $sql->bindParam(":id_aval", $id_aval);
            
            $sql->execute();

            //echo "UPDATE aval_vehiculos SET estado = 'E' WHERE id_aval = '$id_aval'";

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function registrarAval($id_vehiculo, $id_contrato, $valor, $estado, $mes, $anio, $fecha_activacion, $id_usuario_activacion){
        try {
            $con = Conexion::conectar();
            $sql = $con->prepare("INSERT INTO aval_vehiculos (id_vehiculo, id_contrato, valor, estado, mes, anio, fecha_activacion, id_usuario_activacion) VALUES(:id_vehiculo, :id_contrato, :valor, :estado, :mes, :anio, :fecha_activacion, :id_usuario_activacion);");
            $sql->bindParam(":id_vehiculo", $id_vehiculo);
            $sql->bindParam(":id_contrato", $id_contrato);
            $sql->bindParam(":valor", $valor);
            $sql->bindParam(":estado", $estado);
            $sql->bindParam(":mes", $mes);
            $sql->bindParam(":anio", $anio);
            $sql->bindParam(":fecha_activacion", $fecha_activacion);
            $sql->bindParam(":id_usuario_activacion", $id_usuario_activacion);

            $sql->execute();

            //echo "INSERT INTO aval_vehiculos (id_vehiculo, id_contrato, valor, estado, mes, anio, fecha_activacion) VALUES('$id_vehiculo', '$id_contrato', '$valor', '$estado', '$mes', '$anio', '$fecha_activacion');";

            if ($sql) {
                return 1;
            }else{
                return 0;
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    //INICIO COBRO CARTERA//
    
    public function listarCobroCartera(){
        
        $cobro_cartera = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM cobro_cartera WHERE total > 0 ORDER BY saldo_mayor_90_dias DESC, saldo_90_dias DESC, saldo_60_dias DESC, saldo_30_dias DESC");
        
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $cobro_cartera[] = $filas;
        }
        
        return $cobro_cartera;
        
    }
    
    public function listarCobroCarteraJuridica(){
        
        $cobro_cartera = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM cobro_cartera WHERE total > 0 and saldo_mayor_90_dias != '0'; ORDER BY saldo_mayor_90_dias DESC, saldo_90_dias DESC, saldo_60_dias DESC, saldo_30_dias DESC");
        
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $cobro_cartera[] = $filas;
        }
        
        return $cobro_cartera;
        
    }
    
    public function listarEstadoAcuerdosPago(){
        
        $estados = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM estado_acuerdos_pago ORDER BY posicion ASC");
        
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $estados[] = $filas;
        }
        
        return $estados;
        
    }
    
    public function listarPorIdEstadoAcuerdosPago($id){
        
        $estados = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM estado_acuerdos_pago WHERE id_estado = :id");
        $sql->bindParam(":id", $id);
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $estados[] = $filas;
        }
        
        return $estados;
        
    }
    
    public function listarAcuerdosPorVehiculo($id){
        
        $estados = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM acuerdos_pago_cobro WHERE id_vehiculo = :id order by fecha_acuerdo Desc Limit 10");
        $sql->bindParam(":id", $id);
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $estados[] = $filas;
        }
        
        return $estados;
        
    }
    
    public function registrarAcuerdo($id_vehiculo, $valor, $fecha_pago, $id_usuario, $hoy, $estado, $hoy2){
        try {
            $con = Conexion::conectar();
            $sql = $con->prepare("INSERT INTO acuerdos_pago_cobro (id_vehiculo, valor, fecha_pago, id_usuario, fecha_acuerdo, estado, fecha_cambio_estado) VALUES(:id_vehiculo, :valor, :fecha_pago, :id_usuario, :fecha_acuerdo, :estado, :fecha_cambio_estado);");
            $sql->bindParam(":id_vehiculo", $id_vehiculo);
            $sql->bindParam(":valor", $valor);
            $sql->bindParam(":fecha_pago", $fecha_pago);
            $sql->bindParam(":id_usuario", $id_usuario);
            $sql->bindParam(":fecha_acuerdo", $hoy);
            $sql->bindParam(":estado", $estado);
            $sql->bindParam(":fecha_cambio_estado", $hoy2);

            $sql->execute();

            if ($sql) {
                return $id = $con->lastInsertId();
            }else{
                return 0;
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function buscarAcuerdoPago($id_acuerdo){
        
        $estados = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM acuerdos_pago_cobro WHERE id_acuerdo = :id_acuerdo");
        $sql->bindParam(":id_acuerdo", $id_acuerdo);
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $estados[] = $filas;
        }
        
        return $estados;
        
    }
    
    public function actualizarEstadoAcuerdoPago($id_acuerdo,$estado){
        try {
            $con = Conexion::conectar();
            $sql = $con->prepare("UPDATE acuerdos_pago_cobro SET estado = :estado WHERE id_acuerdo = :id_acuerdo");
            $sql->bindParam(":id_acuerdo", $id_acuerdo);
            $sql->bindParam(":estado", $estado);
            
            $sql->execute();

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function listarTipoContactoCobro(){
        
        $estados = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM tipo_contacto_cobro");
        
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $estados[] = $filas;
        }
        
        return $estados;
        
    }
    
    public function listarPorIdTipoGestion($id){
        
        $estados = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM tipo_contacto_cobro WHERE id = :id");
        $sql->bindParam(":id", $id);
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $estados[] = $filas;
        }
        
        return $estados;
        
    }
    
    public function listarGestionPorVehiculo($id){
        
        $estados = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM gestion_cobro WHERE id_vehiculo = :id order by fecha Desc Limit 5");
        $sql->bindParam(":id", $id);
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $estados[] = $filas;
        }
        
        return $estados;
        
    }
    
    public function registrarGestion($id_vehiculo, $fecha, $tipo_contacto, $detalle_contacto, $id_usuario){
        try {
            $con = Conexion::conectar();
            $sql = $con->prepare("INSERT INTO gestion_cobro (id_vehiculo, fecha, tipo, detalle, id_usuario) VALUES(:id_vehiculo, :fecha, :tipo_contacto, :detalle_contacto, :id_usuario);");
            $sql->bindParam(":id_vehiculo", $id_vehiculo);
            $sql->bindParam(":fecha", $fecha);
            $sql->bindParam(":tipo_contacto", $tipo_contacto);
            $sql->bindParam(":detalle_contacto", $detalle_contacto);
            $sql->bindParam(":id_usuario", $id_usuario);
            
            $sql->execute();

            if ($sql) {
                return $id = $con->lastInsertId();
            }else{
                return 0;
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function listarComprobantePorVehiculo($id){
        
        $estados = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM comprobantes_cobro_cartera WHERE id_vehiculo = :id order by fecha Desc Limit 5");
        $sql->bindParam(":id", $id);
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $estados[] = $filas;
        }
        
        return $estados;
        
    }
    
    public function listarComprobantesSinAcuerdos($id){
        
        $estados = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM comprobantes_cobro_cartera WHERE id_vehiculo = :id and id_acuerdo = 0 order by fecha_carga Desc Limit 5");
        $sql->bindParam(":id", $id);
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $estados[] = $filas;
        }
        
        return $estados;
        
    }
    
    public function listarComprobantePorAcuerdo($id_acuerdo){
        
        $estados = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM comprobantes_cobro_cartera WHERE id_acuerdo = :id_acuerdo ");
        $sql->bindParam(":id_acuerdo", $id_acuerdo);
        $sql->execute();
        
        while($filas = $sql->fetch(PDO::FETCH_ASSOC)){
            $estados[] = $filas;
        }
        
        return $estados;
        
    }
    
    public function cargarAcuerdoFirmado($doc,$id_acuerdo){
        try {
            $con = Conexion::conectar();
            $sql = $con->prepare("UPDATE acuerdos_pago_cobro SET doc_firmado = :doc WHERE id_acuerdo = :id_acuerdo");
            $sql->bindParam(":id_acuerdo", $id_acuerdo);
            $sql->bindParam(":doc", $doc);
            
            $sql->execute();

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function cargarComprobantePago($id_vehiculo,$fecha_pago,$valor,$doc,$id_acuerdo,$hoy,$id_usuario,$estado){
        try {
            $con = Conexion::conectar();
            $sql = $con->prepare("INSERT INTO comprobantes_cobro_cartera (id_vehiculo, fecha_pago, valor, archivo, id_acuerdo, fecha_carga, usuario_carga, estado) VALUES (:id_vehiculo, :fecha_pago, :valor, :archivo, :id_acuerdo, :fecha_carga, :usuario_carga, :estado);");
            $sql->bindParam(":id_vehiculo", $id_vehiculo);
            $sql->bindParam(":fecha_pago", $fecha_pago);
            $sql->bindParam(":valor", $valor);
            $sql->bindParam(":archivo", $doc);
            $sql->bindParam(":id_acuerdo", $id_acuerdo);
            $sql->bindParam(":fecha_carga", $hoy);
            $sql->bindParam(":usuario_carga", $id_usuario);
            $sql->bindParam(":estado", $estado);
            
            $sql->execute();

            if ($sql) {
                return $id = $con->lastInsertId();
            }else{
                return 0;
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    //FIN COBRO CARTERA//
    
}

?>