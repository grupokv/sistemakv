<?php
require_once("Conexion/conexionBD.php");
require_once("NotificacionInternaAdministrativo.php");
require_once("NotificacionInternaConductor.php");

class ServicioOcasional
{
    private function notificarAdministrativos($idUsuarioRemitente, $remitente, $area, $contenido, $idServicio = 0)
    {
        $noti = new NotificacionInternaAdministrativo();
        $noti->crearNotificacionServiciosOcasionales((int)$idUsuarioRemitente, $remitente, $area, $contenido, (int)$idServicio);
    }


    private function notificarConductor($idConductor, $idUsuarioRemitente, $remitente, $area, $contenido, $idServicio = 0)
    {
        $noti = new NotificacionInternaConductor();
        $noti->crearNotificacion((int)$idConductor, (int)$idUsuarioRemitente, $remitente, $area, $contenido, (int)$idServicio);
    }

    private function nombreUsuario($idUsuario)
    {
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT nombre FROM usuarios WHERE id_usuario = :id LIMIT 1");
        $sql->bindParam(':id', $idUsuario);
        $sql->execute();
        $f = $sql->fetch(PDO::FETCH_ASSOC);
        return $f && !empty($f['nombre']) ? $f['nombre'] : ('Usuario #' . (int)$idUsuario);
    }


    private function obtenerPlacaTrayecto($idServicio, $consecutivo, $tipoTrayecto)
    {
        $con = Conexion::conectar();
        $tipo = strtoupper(trim((string)$tipoTrayecto));
        $campoVehiculo = $tipo === 'FIN' ? 'id_vehiculo_fin' : 'id_vehiculo_inicio';

        $sql = $con->prepare("SELECT {$campoVehiculo} AS id_vehiculo
            FROM operaciones_servicios_ocasionales
            WHERE id_servicio_ocasional = :id_servicio AND consecutivo = :consecutivo
            LIMIT 1");
        $sql->bindParam(':id_servicio', $idServicio, PDO::PARAM_INT);
        $sql->bindParam(':consecutivo', $consecutivo, PDO::PARAM_INT);
        $sql->execute();
        $op = $sql->fetch(PDO::FETCH_ASSOC);

        $idVehiculo = isset($op['id_vehiculo']) ? (int)$op['id_vehiculo'] : 0;
        if ($idVehiculo <= 0) {
            return 'N/A';
        }

        $sqlVeh = $con->prepare("SELECT placa FROM vehiculos WHERE id_vehiculo = :id LIMIT 1");
        $sqlVeh->bindParam(':id', $idVehiculo, PDO::PARAM_INT);
        $sqlVeh->execute();
        $veh = $sqlVeh->fetch(PDO::FETCH_ASSOC);

        return $veh && !empty($veh['placa']) ? $veh['placa'] : 'N/A';
    }


    private function obtenerConductorTrayecto($idServicio, $consecutivo, $tipoTrayecto)
    {
        $con = Conexion::conectar();
        $tipo = strtoupper(trim((string)$tipoTrayecto));
        $campoConductor = $tipo === 'FIN' ? 'id_conductor_fin' : 'id_conductor_inicio';

        $sql = $con->prepare("SELECT {$campoConductor} AS id_conductor
            FROM operaciones_servicios_ocasionales
            WHERE id_servicio_ocasional = :id_servicio AND consecutivo = :consecutivo
            LIMIT 1");
        $sql->bindParam(':id_servicio', $idServicio, PDO::PARAM_INT);
        $sql->bindParam(':consecutivo', $consecutivo, PDO::PARAM_INT);
        $sql->execute();
        $op = $sql->fetch(PDO::FETCH_ASSOC);

        return isset($op['id_conductor']) ? (int)$op['id_conductor'] : 0;
    }


    private function placaVehiculoPorId($idVehiculo)
    {
        $idVehiculo = (int)$idVehiculo;
        if ($idVehiculo <= 0) {
            return 'N/A';
        }

        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT placa FROM vehiculos WHERE id_vehiculo = :id LIMIT 1");
        $sql->bindParam(':id', $idVehiculo, PDO::PARAM_INT);
        $sql->execute();
        $f = $sql->fetch(PDO::FETCH_ASSOC);

        return $f && !empty($f['placa']) ? $f['placa'] : 'N/A';
    }

    private function nombreConductorPorId($idConductor)
    {
        $idConductor = (int)$idConductor;
        if ($idConductor <= 0) {
            return 'N/A';
        }

        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT nombre_conductor FROM conductores WHERE id_conductor = :id LIMIT 1");
        $sql->bindParam(':id', $idConductor, PDO::PARAM_INT);
        $sql->execute();
        $f = $sql->fetch(PDO::FETCH_ASSOC);

        return $f && !empty($f['nombre_conductor']) ? $f['nombre_conductor'] : 'N/A';
    }

    private function asegurarEstructura()
    {
        $con = Conexion::conectar();

        $sqlServicios = "CREATE TABLE IF NOT EXISTS servicios_ocasionales (
            id_servicio_ocasional INT AUTO_INCREMENT PRIMARY KEY,
            id_cliente INT NOT NULL,
            id_empresa INT NOT NULL,
            id_tipo_vehiculo VARCHAR(100) NOT NULL,
            tipo_servicio VARCHAR(80) NOT NULL,
            origen VARCHAR(255) NOT NULL,
            destino VARCHAR(255) NOT NULL,
            cantidad_vehiculos INT NOT NULL,
            cantidad_pasajeros INT NOT NULL,
            fecha_inicio DATE NOT NULL,
            fecha_fin DATE NOT NULL,
            hora_inicio TIME NOT NULL,
            hora_fin TIME NOT NULL,
            valor_servicio DECIMAL(15,2) NOT NULL DEFAULT 0,
            id_responsable INT NOT NULL,
            fecha_creacion DATE NOT NULL,
            hora_creacion TIME NOT NULL,
            estado CHAR(1) NOT NULL DEFAULT 'P',
            detalle_servicio TEXT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

        $sqlDocs = "CREATE TABLE IF NOT EXISTS doc_servicios_ocasionales (
            id_servicio_ocasional INT NOT NULL,
            doc_rut VARCHAR(255) NULL,
            doc_camara VARCHAR(255) NULL,
            doc_cedula_rl VARCHAR(255) NULL,
            doc_aceptacion VARCHAR(255) NULL,
            doc_contrato VARCHAR(255) NULL,
            doc_primer_abono VARCHAR(255) NULL,
            doc_segundo_abono VARCHAR(255) NULL,
            doc_prefactura VARCHAR(255) NULL,
            doc_recibo_caja_abono_1 VARCHAR(255) NULL,
            doc_recibo_caja_abono_2 VARCHAR(255) NULL,
            doc_factura VARCHAR(255) NULL,
            doc_fuec_generado VARCHAR(255) NULL,
            doc_contrato_generado VARCHAR(255) NULL,
            doc_fuec_documental TEXT NULL,
            doc_convenio_documental TEXT NULL,
            fecha_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id_servicio_ocasional)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

        $con->exec($sqlServicios);
        $con->exec($sqlDocs);

        $sqlConfirmaciones = "CREATE TABLE IF NOT EXISTS confirmaciones_servicios_ocasionales (
            id_servicio_ocasional INT PRIMARY KEY,
            confirmacion_contabilidad TINYINT(1) NOT NULL DEFAULT 0,
            usuario_contabilidad INT NULL,
            fecha_contabilidad DATETIME NULL,
            documentos_contabilidad TEXT NULL,
            confirmacion_operaciones TINYINT(1) NOT NULL DEFAULT 0,
            usuario_operaciones INT NULL,
            fecha_operaciones DATETIME NULL,
            confirmacion_documental TINYINT(1) NOT NULL DEFAULT 0,
            usuario_documental INT NULL,
            fecha_documental DATETIME NULL,
            confirmacion_conductor TINYINT(1) NOT NULL DEFAULT 0,
            usuario_conductor INT NULL,
            fecha_conductor DATETIME NULL,
            estado_contabilidad VARCHAR(30) NULL,
            estado_operaciones VARCHAR(30) NULL,
            estado_documental VARCHAR(30) NULL,
            estado_conductor VARCHAR(30) NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

        $sqlOperacionDetalle = "CREATE TABLE IF NOT EXISTS operaciones_servicios_ocasionales (
            id_operacion INT AUTO_INCREMENT PRIMARY KEY,
            id_servicio_ocasional INT NOT NULL,
            consecutivo INT NOT NULL,
            id_vehiculo_inicio INT NULL,
            id_vehiculo_fin INT NULL,
            id_conductor_inicio INT NULL,
            id_conductor_fin INT NULL,
            direccion_origen VARCHAR(255) NULL,
            direccion_destino VARCHAR(255) NULL,
            tipo_recorrido VARCHAR(30) NULL,
            fecha_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

        $con->exec($sqlConfirmaciones);
        $con->exec($sqlOperacionDetalle);

        $sqlFuecServicios = "CREATE TABLE IF NOT EXISTS fuec_servicios_ocasionales (
            id_fuec_so INT AUTO_INCREMENT PRIMARY KEY,
            id_servicio_ocasional INT NOT NULL,
            consecutivo INT NOT NULL,
            tipo_trayecto VARCHAR(10) NOT NULL,
            id_vehiculo INT NOT NULL,
            id_conductor INT NULL,
            id_contrato_ocasional INT NOT NULL,
            id_fuec INT NULL,
            documento_fuec VARCHAR(255) NULL,
            fecha_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY uq_fuec_so (id_servicio_ocasional, consecutivo, tipo_trayecto)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
        $con->exec($sqlFuecServicios);

        try {
            $con->exec("ALTER TABLE servicios_ocasionales DROP COLUMN id_ciudad");
        } catch (Exception $e) {
        }

        try {
            $con->exec("ALTER TABLE servicios_ocasionales ADD COLUMN detalle_servicio TEXT NULL");
        } catch (Exception $e) {
        }
        try {
            $con->exec("ALTER TABLE doc_servicios_ocasionales ADD COLUMN doc_fuec_documental TEXT NULL");
        } catch (Exception $e) {
        }
        try {
            $con->exec("ALTER TABLE doc_servicios_ocasionales ADD COLUMN doc_recibo_caja_abono_1 VARCHAR(255) NULL");
        } catch (Exception $e) {
        }
        try {
            $con->exec("ALTER TABLE doc_servicios_ocasionales ADD COLUMN doc_recibo_caja_abono_2 VARCHAR(255) NULL");
        } catch (Exception $e) {
        }
        try {
            $con->exec("ALTER TABLE doc_servicios_ocasionales ADD COLUMN doc_factura VARCHAR(255) NULL");
        } catch (Exception $e) {
        }

        try {
            $con->exec("ALTER TABLE operaciones_servicios_ocasionales ADD COLUMN direccion_origen VARCHAR(255) NULL");
        } catch (Exception $e) {
        }

        try {
            $con->exec("ALTER TABLE operaciones_servicios_ocasionales ADD COLUMN direccion_destino VARCHAR(255) NULL");
        } catch (Exception $e) {
        }

        try {
            $con->exec("ALTER TABLE operaciones_servicios_ocasionales ADD COLUMN tipo_recorrido VARCHAR(30) NULL");
        } catch (Exception $e) {
        }

        try {
            $con->exec("ALTER TABLE fuec_servicios_ocasionales MODIFY COLUMN id_fuec INT NULL");
        } catch (Exception $e) {
        }

        try {
            $con->exec("ALTER TABLE fuec_servicios_ocasionales ADD COLUMN documento_fuec VARCHAR(255) NULL");
        } catch (Exception $e) {
        }
        
        try {
    $con->exec("ALTER TABLE doc_servicios_ocasionales ADD COLUMN doc_convenio_documental TEXT NULL");
} catch (Exception $e) {
}

    }

    public function registrarServicioOcasional(
        $id_cliente,
        $id_empresa,
        $id_tipo_vehiculo,
        $tipo_servicio,
        $origen,
        $destino,
        $cantidad_vehiculos,
        $cantidad_pasajeros,
        $fecha_inicio,
        $fecha_fin,
        $hora_inicio,
        $hora_fin,
        $valor_servicio,
        $id_responsable,
        $fecha_creacion,
        $hora_creacion,
        $estado,
        $detalle_servicio = ''
    ) {
        $this->asegurarEstructura();

        $con = Conexion::conectar();

        $sql = $con->prepare("INSERT INTO servicios_ocasionales
            (id_cliente, id_empresa, id_tipo_vehiculo, tipo_servicio, origen, destino, cantidad_vehiculos, cantidad_pasajeros,
             fecha_inicio, fecha_fin, hora_inicio, hora_fin, valor_servicio, id_responsable, fecha_creacion, hora_creacion, estado, detalle_servicio)
            VALUES
            (:id_cliente, :id_empresa, :id_tipo_vehiculo, :tipo_servicio, :origen, :destino, :cantidad_vehiculos, :cantidad_pasajeros,
             :fecha_inicio, :fecha_fin, :hora_inicio, :hora_fin, :valor_servicio, :id_responsable, :fecha_creacion, :hora_creacion, :estado, :detalle_servicio)");

        $sql->bindParam(':id_cliente', $id_cliente);
        $sql->bindParam(':id_empresa', $id_empresa);
        $sql->bindParam(':id_tipo_vehiculo', $id_tipo_vehiculo);
        $sql->bindParam(':tipo_servicio', $tipo_servicio);
        $sql->bindParam(':origen', $origen);
        $sql->bindParam(':destino', $destino);
        $sql->bindParam(':cantidad_vehiculos', $cantidad_vehiculos);
        $sql->bindParam(':cantidad_pasajeros', $cantidad_pasajeros);
        $sql->bindParam(':fecha_inicio', $fecha_inicio);
        $sql->bindParam(':fecha_fin', $fecha_fin);
        $sql->bindParam(':hora_inicio', $hora_inicio);
        $sql->bindParam(':hora_fin', $hora_fin);
        $sql->bindParam(':valor_servicio', $valor_servicio);
        $sql->bindParam(':id_responsable', $id_responsable);
        $sql->bindParam(':fecha_creacion', $fecha_creacion);
        $sql->bindParam(':hora_creacion', $hora_creacion);
        $sql->bindParam(':estado', $estado);
        $sql->bindParam(':detalle_servicio', $detalle_servicio);

        $sql->execute();
        $idServicio = (int)$con->lastInsertId();
        $this->notificarAdministrativos(
            (int)$id_responsable,
            $this->nombreUsuario((int)$id_responsable),
            'COMERCIAL',
            'Se creó la reserva ocasional #' . $idServicio . ' el ' . date('Y-m-d H:i:s') . '.',
            $idServicio
        );

        return $idServicio;
    }

    public function listarServiciosOcasionales($year)
    {
        $this->asegurarEstructura();

        $listar = array();
        $con = Conexion::conectar();

        $sql = $con->prepare("SELECT so.*, c.razon_social, c.nit_cliente, e.nombre_empresa, tv.nombre_tipo_vehiculo
            FROM servicios_ocasionales AS so
            INNER JOIN clientes AS c ON so.id_cliente = c.id_cliente
            INNER JOIN empresas AS e ON so.id_empresa = e.id_empresa
            INNER JOIN tipos_vehiculos AS tv ON so.id_tipo_vehiculo = tv.id_tipo_vehiculo
            WHERE YEAR(so.fecha_creacion) = :year
            ORDER BY so.id_servicio_ocasional DESC");

        $sql->bindParam(':year', $year);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
    $filas['nombre_tipo_vehiculo'] = $this->convertirIdsTipoVehiculoANombres($filas['id_tipo_vehiculo']);
    $listar[] = $filas;
}

        return $listar;
    }

    public function listarServicioPorId($id_servicio_ocasional)
    {
        $this->asegurarEstructura();

        $servicio = array();
        $con = Conexion::conectar();

        $sql = $con->prepare("SELECT so.*, c.razon_social, c.nit_cliente, e.nombre_empresa, tv.nombre_tipo_vehiculo
            FROM servicios_ocasionales AS so
            INNER JOIN clientes AS c ON so.id_cliente = c.id_cliente
            INNER JOIN empresas AS e ON so.id_empresa = e.id_empresa
            INNER JOIN tipos_vehiculos AS tv ON so.id_tipo_vehiculo = tv.id_tipo_vehiculo
            WHERE so.id_servicio_ocasional = :id_servicio_ocasional");

        $sql->bindParam(':id_servicio_ocasional', $id_servicio_ocasional);
        $sql->execute();

       while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
    $filas['nombre_tipo_vehiculo'] = $this->convertirIdsTipoVehiculoANombres($filas['id_tipo_vehiculo']);
    $servicio[] = $filas;
}

        return $servicio;
    }

    public function actualizarEstadoServicioOcasional($id_servicio_ocasional, $estado)
    {
        $this->asegurarEstructura();

        $con = Conexion::conectar();
        $sql = $con->prepare("UPDATE servicios_ocasionales SET estado = :estado WHERE id_servicio_ocasional = :id_servicio_ocasional");

        $sql->bindParam(':estado', $estado);
        $sql->bindParam(':id_servicio_ocasional', $id_servicio_ocasional);
        $ok = $sql->execute();

        if ($ok) {
            $servicio = $this->listarServicioPorId($id_servicio_ocasional);
            $idResponsable = isset($servicio[0]['id_responsable']) ? (int)$servicio[0]['id_responsable'] : 0;
            $this->notificarAdministrativos(
                $idResponsable,
                $this->nombreUsuario($idResponsable),
                'COMERCIAL',
                'Se actualizó el estado de la reserva ocasional #' . (int)$id_servicio_ocasional . ' a ' . strtoupper($estado) . ' el ' . date('Y-m-d H:i:s') . '.',
                (int)$id_servicio_ocasional
            );
        }
    }

    public function registrarDocumentoServicioOcasional($id_servicio_ocasional, $campo, $documento, $id_usuario = 0)
    {
        $this->asegurarEstructura();

        $permitidos = [
            'doc_rut', 'doc_camara', 'doc_cedula_rl', 'doc_aceptacion', 'doc_contrato',
            'doc_primer_abono', 'doc_segundo_abono', 'doc_prefactura',
            'doc_recibo_caja_abono_1', 'doc_recibo_caja_abono_2', 'doc_factura',
            'doc_fuec_generado', 'doc_contrato_generado'
        ];

        if (!in_array($campo, $permitidos, true)) {
            return false;
        }

        $con = Conexion::conectar();

        $sqlInsert = $con->prepare("INSERT INTO doc_servicios_ocasionales (id_servicio_ocasional, fecha_registro)
            VALUES (:id_servicio_ocasional, NOW())
            ON DUPLICATE KEY UPDATE fecha_registro = fecha_registro");
        $sqlInsert->bindParam(':id_servicio_ocasional', $id_servicio_ocasional);
        $sqlInsert->execute();

        $sqlUpdate = $con->prepare("UPDATE doc_servicios_ocasionales
            SET {$campo} = :documento, fecha_registro = NOW()
            WHERE id_servicio_ocasional = :id_servicio_ocasional");
        $sqlUpdate->bindParam(':documento', $documento);
        $sqlUpdate->bindParam(':id_servicio_ocasional', $id_servicio_ocasional);
        $ok = $sqlUpdate->execute();

        if ($ok && (int)$id_usuario > 0) {
            $etiquetas = array(
                'doc_recibo_caja_abono_1' => 'recibo de caja abono 1',
                'doc_recibo_caja_abono_2' => 'recibo de caja abono 2',
                'doc_factura' => 'factura'
            );

            if (isset($etiquetas[$campo])) {
                $nombre = $this->nombreUsuario((int)$id_usuario);
                $this->notificarAdministrativos(
                    (int)$id_usuario,
                    $nombre,
                    'CONTABILIDAD',
                    $nombre . ' subió el ' . $etiquetas[$campo] . ' de la reserva #' . (int)$id_servicio_ocasional . ' el ' . date('Y-m-d H:i:s') . '.',
                    (int)$id_servicio_ocasional
                );
            }
        }

        return $ok;
    }

    public function listarDocumentosServicioOcasional($id_servicio_ocasional)
    {
        $this->asegurarEstructura();

        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM doc_servicios_ocasionales WHERE id_servicio_ocasional = :id_servicio_ocasional LIMIT 1");
        $sql->bindParam(':id_servicio_ocasional', $id_servicio_ocasional);
        $sql->execute();

        $fila = $sql->fetch(PDO::FETCH_ASSOC);
        return $fila ? $fila : [];
    }

    public function actualizarServicioOcasional(
        $id_servicio_ocasional,
        $id_cliente,
        $id_empresa,
        $id_tipo_vehiculo,
        $tipo_servicio,
        $origen,
        $destino,
        $cantidad_vehiculos,
        $cantidad_pasajeros,
        $fecha_inicio,
        $fecha_fin,
        $hora_inicio,
        $hora_fin,
        $valor_servicio,
        $detalle_servicio = ''
    ) {
        $this->asegurarEstructura();

        $con = Conexion::conectar();

        $sql = $con->prepare("UPDATE servicios_ocasionales
            SET id_cliente = :id_cliente,
                id_empresa = :id_empresa,
                id_tipo_vehiculo = :id_tipo_vehiculo,
                tipo_servicio = :tipo_servicio,
                origen = :origen,
                destino = :destino,
                cantidad_vehiculos = :cantidad_vehiculos,
                cantidad_pasajeros = :cantidad_pasajeros,
                fecha_inicio = :fecha_inicio,
                fecha_fin = :fecha_fin,
                hora_inicio = :hora_inicio,
                hora_fin = :hora_fin,
                valor_servicio = :valor_servicio,
                detalle_servicio = :detalle_servicio
            WHERE id_servicio_ocasional = :id_servicio_ocasional
            LIMIT 1");

        $sql->bindParam(':id_servicio_ocasional', $id_servicio_ocasional, PDO::PARAM_INT);
        $sql->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
        $sql->bindParam(':id_empresa', $id_empresa, PDO::PARAM_INT);
        $sql->bindParam(':id_tipo_vehiculo', $id_tipo_vehiculo);
        $sql->bindParam(':tipo_servicio', $tipo_servicio);
        $sql->bindParam(':origen', $origen);
        $sql->bindParam(':destino', $destino);
        $sql->bindParam(':cantidad_vehiculos', $cantidad_vehiculos, PDO::PARAM_INT);
        $sql->bindParam(':cantidad_pasajeros', $cantidad_pasajeros, PDO::PARAM_INT);
        $sql->bindParam(':fecha_inicio', $fecha_inicio);
        $sql->bindParam(':fecha_fin', $fecha_fin);
        $sql->bindParam(':hora_inicio', $hora_inicio);
        $sql->bindParam(':hora_fin', $hora_fin);
        $sql->bindParam(':valor_servicio', $valor_servicio);
        $sql->bindParam(':detalle_servicio', $detalle_servicio);

        $ok = $sql->execute();
        if ($ok) {
            $servicio = $this->listarServicioPorId($id_servicio_ocasional);
            $idResponsable = isset($servicio[0]['id_responsable']) ? (int)$servicio[0]['id_responsable'] : 0;
            $this->notificarAdministrativos(
                $idResponsable,
                $this->nombreUsuario($idResponsable),
                'COMERCIAL',
                'Se editó la reserva ocasional #' . (int)$id_servicio_ocasional . ' el ' . date('Y-m-d H:i:s') . '.',
                (int)$id_servicio_ocasional
            );
        }

        return $ok;
    }

    public function obtenerConfirmaciones($id_servicio_ocasional)
    {
        $this->asegurarEstructura();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM confirmaciones_servicios_ocasionales WHERE id_servicio_ocasional = :id LIMIT 1");
        $sql->bindParam(':id', $id_servicio_ocasional);
        $sql->execute();
        $fila = $sql->fetch(PDO::FETCH_ASSOC);
        return $fila ? $fila : [];
    }

    public function guardarConfirmacionArea($id_servicio_ocasional, $area, $id_usuario, $estado = 'CONFIRMADO', $documentos = array())
    {
        $this->asegurarEstructura();
        $con = Conexion::conectar();

        $permitidas = array('contabilidad', 'operaciones', 'documental', 'conductor');
        if (!in_array($area, $permitidas, true)) {
            return false;
        }

        $sqlBase = $con->prepare("INSERT INTO confirmaciones_servicios_ocasionales (id_servicio_ocasional) VALUES (:id)
            ON DUPLICATE KEY UPDATE id_servicio_ocasional = id_servicio_ocasional");
        $sqlBase->bindParam(':id', $id_servicio_ocasional);
        $sqlBase->execute();

        $campoConfirmacion = 'confirmacion_' . $area;
        $campoUsuario = 'usuario_' . $area;
        $campoFecha = 'fecha_' . $area;
        $campoEstado = 'estado_' . $area;

        $sql = "UPDATE confirmaciones_servicios_ocasionales
                SET {$campoConfirmacion} = 1,
                    {$campoUsuario} = :id_usuario,
                    {$campoFecha} = NOW(),
                    {$campoEstado} = :estado";

        if ($area === 'contabilidad') {
            $sql .= ", documentos_contabilidad = :documentos";
        }

        $sql .= " WHERE id_servicio_ocasional = :id_servicio_ocasional";
        $query = $con->prepare($sql);
        $query->bindParam(':id_usuario', $id_usuario);
        $query->bindParam(':estado', $estado);
        if ($area === 'contabilidad') {
            $docs = json_encode($documentos);
            $query->bindParam(':documentos', $docs);
        }
        $query->bindParam(':id_servicio_ocasional', $id_servicio_ocasional);
        $ok = $query->execute();
        if ($ok) {
            $this->notificarAdministrativos(
                (int)$id_usuario,
                $this->nombreUsuario((int)$id_usuario),
                strtoupper($area),
                $this->nombreUsuario((int)$id_usuario) . ' realizó acción ' . strtoupper($estado) . ' en ' . strtoupper($area) . ' para reserva #' . (int)$id_servicio_ocasional . ' el ' . date('Y-m-d H:i:s') . '.',
                (int)$id_servicio_ocasional
            );
        }
        return $ok;
    }

    public function guardarConfirmacionConductorRecibido($id_servicio_ocasional, $id_usuario, $confirmado)
    {
        $this->asegurarEstructura();
        $con = Conexion::conectar();

        $sqlBase = $con->prepare("INSERT INTO confirmaciones_servicios_ocasionales (id_servicio_ocasional) VALUES (:id)
            ON DUPLICATE KEY UPDATE id_servicio_ocasional = id_servicio_ocasional");
        $sqlBase->bindParam(':id', $id_servicio_ocasional);
        $sqlBase->execute();

        $confirmado = (int)$confirmado === 1 ? 1 : 0;
        $estado = $confirmado === 1 ? 'CONFIRMADO' : 'NO CONFIRMADO';

        $sql = $con->prepare("UPDATE confirmaciones_servicios_ocasionales
            SET confirmacion_conductor = :confirmacion,
                usuario_conductor = :id_usuario,
                fecha_conductor = NOW(),
                estado_conductor = :estado
            WHERE id_servicio_ocasional = :id_servicio_ocasional");

        $sql->bindParam(':confirmacion', $confirmado, PDO::PARAM_INT);
        $sql->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $sql->bindParam(':estado', $estado);
        $sql->bindParam(':id_servicio_ocasional', $id_servicio_ocasional, PDO::PARAM_INT);

        $ok = $sql->execute();
        if ($ok) {
            $this->notificarAdministrativos(
                (int)$id_usuario,
                $this->nombreUsuario((int)$id_usuario),
                'CONDUCTOR',
                $this->nombreUsuario((int)$id_usuario) . ' ' . ($confirmado === 1 ? 'confirmó' : 'no confirmó') . ' el recibido de la reserva #' . (int)$id_servicio_ocasional . ' el ' . date('Y-m-d H:i:s') . '.',
                (int)$id_servicio_ocasional
            );
        }

        return $ok;
    }
    
    private function convertirIdsTipoVehiculoANombres($idsTexto)
{
    $idsTexto = trim((string)$idsTexto);
    if ($idsTexto === '') {
        return '';
    }

    $ids = array_filter(array_map('trim', explode(',', $idsTexto)));
    $ids = array_unique($ids);

    $idsValidos = array();
    foreach ($ids as $id) {
        if (ctype_digit($id)) {
            $idsValidos[] = (int)$id;
        }
    }

    if (count($idsValidos) < 1) {
        return $idsTexto;
    }

    $con = Conexion::conectar();

    $placeholders = implode(',', array_fill(0, count($idsValidos), '?'));
    $sql = $con->prepare("SELECT nombre_tipo_vehiculo 
                          FROM tipos_vehiculos 
                          WHERE id_tipo_vehiculo IN ($placeholders)
                          ORDER BY nombre_tipo_vehiculo ASC");
    $sql->execute($idsValidos);

    $nombres = $sql->fetchAll(PDO::FETCH_COLUMN);

    return count($nombres) > 0 ? implode(' / ', $nombres) : $idsTexto;
}

    public function listarReservasAsignadasConductor($id_conductor, $fecha_inicial = '0000-00-00', $fecha_final = '9999-12-31')
    {
        $this->asegurarEstructura();
        $arr = array();
        $con = Conexion::conectar();

        $sql = $con->prepare("SELECT
                so.id_servicio_ocasional,
                so.origen,
                so.destino,
                so.fecha_inicio,
                so.fecha_fin,
                so.hora_inicio,
                so.hora_fin,
                so.detalle_servicio,
                c.razon_social AS contratante,
                e.nombre_empresa AS cliente,
                IFNULL(cs.confirmacion_operaciones, 0) AS confirmacion_operaciones,
                IFNULL(cs.confirmacion_conductor, 0) AS confirmacion_conductor,
                IFNULL(cs.estado_conductor, '') AS estado_conductor,
                GROUP_CONCAT(DISTINCT op.direccion_origen ORDER BY op.consecutivo SEPARATOR ' / ') AS direccion_origen,
                GROUP_CONCAT(DISTINCT op.direccion_destino ORDER BY op.consecutivo SEPARATOR ' / ') AS direccion_destino
            FROM servicios_ocasionales so
            INNER JOIN clientes c ON c.id_cliente = so.id_cliente
            INNER JOIN empresas e ON e.id_empresa = so.id_empresa
            INNER JOIN operaciones_servicios_ocasionales op ON op.id_servicio_ocasional = so.id_servicio_ocasional
            LEFT JOIN confirmaciones_servicios_ocasionales cs ON cs.id_servicio_ocasional = so.id_servicio_ocasional
            WHERE (op.id_conductor_inicio = :id_conductor_inicio OR op.id_conductor_fin = :id_conductor_fin)
              AND so.fecha_inicio >= :fecha_inicial
              AND so.fecha_inicio <= :fecha_final
            GROUP BY
                so.id_servicio_ocasional,
                so.origen,
                so.destino,
                so.fecha_inicio,
                so.fecha_fin,
                so.hora_inicio,
                so.hora_fin,
                so.detalle_servicio,
                c.razon_social,
                e.nombre_empresa,
                cs.confirmacion_operaciones,
                cs.confirmacion_conductor,
                cs.estado_conductor
            ORDER BY so.fecha_inicio DESC, so.hora_inicio DESC");

        $sql->bindParam(':id_conductor_inicio', $id_conductor, PDO::PARAM_INT);
        $sql->bindParam(':id_conductor_fin', $id_conductor, PDO::PARAM_INT);
        $sql->bindParam(':fecha_inicial', $fecha_inicial);
        $sql->bindParam(':fecha_final', $fecha_final);
        $sql->execute();

        while ($f = $sql->fetch(PDO::FETCH_ASSOC)) {
            $arr[] = $f;
        }

        return $arr;
    }

    public function guardarDetalleOperacion($id_servicio_ocasional, $detalles, $id_usuario = 0)
    {
        $this->asegurarEstructura();
        $con = Conexion::conectar();

        $detallesAnteriores = $this->listarDetalleOperacion($id_servicio_ocasional);

        $conductoresAnteriores = array();
        foreach ($detallesAnteriores as $old) {
            $idCI = isset($old['id_conductor_inicio']) ? (int)$old['id_conductor_inicio'] : 0;
            $idCF = isset($old['id_conductor_fin']) ? (int)$old['id_conductor_fin'] : 0;
            if ($idCI > 0) {
                $conductoresAnteriores[$idCI] = 1;
            }
            if ($idCF > 0) {
                $conductoresAnteriores[$idCF] = 1;
            }
        }

        $del = $con->prepare("DELETE FROM operaciones_servicios_ocasionales WHERE id_servicio_ocasional = :id");
        $del->bindParam(':id', $id_servicio_ocasional);
        $del->execute();

        $sql = $con->prepare("INSERT INTO operaciones_servicios_ocasionales
            (id_servicio_ocasional, consecutivo, id_vehiculo_inicio, id_vehiculo_fin, id_conductor_inicio, id_conductor_fin, direccion_origen, direccion_destino, tipo_recorrido)
            VALUES(:id, :consecutivo, :id_vehiculo_inicio, :id_vehiculo_fin, :id_conductor_inicio, :id_conductor_fin, :direccion_origen, :direccion_destino, :tipo_recorrido)");

        $anclajes = array();
        $conductoresNuevos = array();

        foreach ($detalles as $d) {
            $sql->bindParam(':id', $id_servicio_ocasional);
            $sql->bindParam(':consecutivo', $d['consecutivo']);
            $sql->bindParam(':id_vehiculo_inicio', $d['id_vehiculo_inicio']);
            $sql->bindParam(':id_vehiculo_fin', $d['id_vehiculo_fin']);
            $sql->bindParam(':id_conductor_inicio', $d['id_conductor_inicio']);
            $sql->bindParam(':id_conductor_fin', $d['id_conductor_fin']);
            $sql->bindParam(':direccion_origen', $d['direccion_origen']);
            $sql->bindParam(':direccion_destino', $d['direccion_destino']);
            $sql->bindParam(':tipo_recorrido', $d['tipo_recorrido']);
            $sql->execute();

            $consecutivo = isset($d['consecutivo']) ? (int)$d['consecutivo'] : 0;

            $idVehInicio = isset($d['id_vehiculo_inicio']) ? (int)$d['id_vehiculo_inicio'] : 0;
            $idConInicio = isset($d['id_conductor_inicio']) ? (int)$d['id_conductor_inicio'] : 0;
            if ($idConInicio > 0) {
                $conductoresNuevos[$idConInicio] = 1;
            }
            if ($idVehInicio > 0 || $idConInicio > 0) {
                $partes = array();
                if ($idVehInicio > 0) {
                    $partes[] = 'placa ' . $this->placaVehiculoPorId($idVehInicio);
                }
                if ($idConInicio > 0) {
                    $partes[] = 'conductor ' . $this->nombreConductorPorId($idConInicio);
                }
                if (count($partes) > 0) {
                    $anclajes[] = implode(' y ', $partes) . ' (INICIO, consecutivo ' . $consecutivo . ')';
                }
            }

            $idVehFin = isset($d['id_vehiculo_fin']) ? (int)$d['id_vehiculo_fin'] : 0;
            $idConFin = isset($d['id_conductor_fin']) ? (int)$d['id_conductor_fin'] : 0;
            if ($idConFin > 0) {
                $conductoresNuevos[$idConFin] = 1;
            }
            if ($idVehFin > 0 || $idConFin > 0) {
                $partes = array();
                if ($idVehFin > 0) {
                    $partes[] = 'placa ' . $this->placaVehiculoPorId($idVehFin);
                }
                if ($idConFin > 0) {
                    $partes[] = 'conductor ' . $this->nombreConductorPorId($idConFin);
                }
                if (count($partes) > 0) {
                    $anclajes[] = implode(' y ', $partes) . ' (FIN, consecutivo ' . $consecutivo . ')';
                }
            }
        }

        $anclajes = array_values(array_unique($anclajes));
        $nombreUsuario = (int)$id_usuario > 0 ? $this->nombreUsuario((int)$id_usuario) : 'OPERACIONES';
        $detalleAnclajes = count($anclajes) > 0 ? implode('; ', $anclajes) : 'sin detalle de placa/conductor';

        $this->notificarAdministrativos(
            (int)$id_usuario,
            $nombreUsuario,
            'OPERACIONES',
            $nombreUsuario . ' ancló ' . $detalleAnclajes . ' a la reserva #' . (int)$id_servicio_ocasional . ' el ' . date('Y-m-d H:i:s') . '.',
            (int)$id_servicio_ocasional
        );

        $idsAnteriores = array_keys($conductoresAnteriores);
        $idsNuevos = array_keys($conductoresNuevos);

        // Notificar asignación cada vez que operaciones guarda un conductor anclado.
        // Esto evita que se pierda la notificación cuando el flujo no detecta cambio por diff.
        $idsAnclados = $idsNuevos;
        $idsDesanclados = array_diff($idsAnteriores, $idsNuevos);

        foreach ($idsAnclados as $idConductor) {
            $nombreConductor = $this->nombreConductorPorId((int)$idConductor);
            $this->notificarConductor(
                (int)$idConductor,
                (int)$id_usuario,
                $nombreUsuario,
                'OPERACIONES',
                $nombreUsuario . ' te asignó a la reserva ocasional #' . (int)$id_servicio_ocasional . ' (' . $nombreConductor . ') el ' . date('Y-m-d H:i:s') . '.',
                (int)$id_servicio_ocasional
            );
        }

        foreach ($idsDesanclados as $idConductor) {
            $nombreConductor = $this->nombreConductorPorId((int)$idConductor);
            $this->notificarConductor(
                (int)$idConductor,
                (int)$id_usuario,
                $nombreUsuario,
                'OPERACIONES',
                $nombreUsuario . ' retiró tu asignación de la reserva ocasional #' . (int)$id_servicio_ocasional . ' (' . $nombreConductor . ') el ' . date('Y-m-d H:i:s') . '.',
                (int)$id_servicio_ocasional
            );
        }

        return true;
    }

    public function listarDetalleOperacion($id_servicio_ocasional)
    {
        $this->asegurarEstructura();
        $arr = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM operaciones_servicios_ocasionales WHERE id_servicio_ocasional = :id ORDER BY consecutivo ASC");
        $sql->bindParam(':id', $id_servicio_ocasional);
        $sql->execute();
        while ($f = $sql->fetch(PDO::FETCH_ASSOC)) {
            $arr[] = $f;
        }
        return $arr;
    }

    public function listarDetalleOperacionConNombres($id_servicio_ocasional)
    {
        $this->asegurarEstructura();
        $arr = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT op.*,
                vi.placa AS placa_inicio,
                vf.placa AS placa_fin,
                CASE
                    WHEN REPLACE(UPPER(TRIM(IFNULL(vi.flota_propia, 'NO'))), 'Í', 'I') IN ('SI', 'S', '1', 'TRUE', 'FLOTA PROPIA') THEN 'FLOTA PROPIA'
                    ELSE IFNULL(vi.tipo_afiliacion, 'N/A')
                END AS tipo_afiliacion_inicio,
                CASE
                    WHEN REPLACE(UPPER(TRIM(IFNULL(vf.flota_propia, 'NO'))), 'Í', 'I') IN ('SI', 'S', '1', 'TRUE', 'FLOTA PROPIA') THEN 'FLOTA PROPIA'
                    ELSE IFNULL(vf.tipo_afiliacion, 'N/A')
                END AS tipo_afiliacion_fin,
                ci.nombre_conductor AS conductor_inicio,
                ci.numero_documento_conductor AS cedula_conductor_inicio,
                cf.nombre_conductor AS conductor_fin,
                cf.numero_documento_conductor AS cedula_conductor_fin
            FROM operaciones_servicios_ocasionales op
            LEFT JOIN vehiculos vi ON vi.id_vehiculo = op.id_vehiculo_inicio
            LEFT JOIN vehiculos vf ON vf.id_vehiculo = op.id_vehiculo_fin
            LEFT JOIN conductores ci ON ci.id_conductor = op.id_conductor_inicio
            LEFT JOIN conductores cf ON cf.id_conductor = op.id_conductor_fin
            WHERE op.id_servicio_ocasional = :id
            ORDER BY op.consecutivo ASC");
        $sql->bindParam(':id', $id_servicio_ocasional);
        $sql->execute();
        while ($f = $sql->fetch(PDO::FETCH_ASSOC)) {
            $arr[] = $f;
        }
        return $arr;
    }

    public function listarServiciosOcasionalesTodos()
    {
        $this->asegurarEstructura();
        $listar = array();
        $con = Conexion::conectar();

        $sql = $con->prepare("SELECT so.*, c.razon_social, c.nit_cliente, e.nombre_empresa, tv.nombre_tipo_vehiculo
            FROM servicios_ocasionales AS so
            INNER JOIN clientes AS c ON so.id_cliente = c.id_cliente
            INNER JOIN empresas AS e ON so.id_empresa = e.id_empresa
            INNER JOIN tipos_vehiculos AS tv ON so.id_tipo_vehiculo = tv.id_tipo_vehiculo
            ORDER BY so.id_servicio_ocasional DESC");

        $sql->execute();
        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
    $filas['nombre_tipo_vehiculo'] = $this->convertirIdsTipoVehiculoANombres($filas['id_tipo_vehiculo']);
    $listar[] = $filas;
}

        return $listar;
    }

    public function listarClientesConServicios()
    {
        $this->asegurarEstructura();

        $arr = array();
        $con = Conexion::conectar();

        $sql = $con->prepare("SELECT DISTINCT c.id_cliente, c.razon_social
        FROM servicios_ocasionales so
        INNER JOIN clientes c ON c.id_cliente = so.id_cliente
        ORDER BY c.razon_social ASC");

        $sql->execute();

        while ($f = $sql->fetch(PDO::FETCH_ASSOC)) {
            $arr[] = $f;
        }

        return $arr;
    }

    public function listarEmisoresServiciosOcasionales()
    {
        $this->asegurarEstructura();

        $arr = array();
        $con = Conexion::conectar();

        $sql = $con->prepare("SELECT DISTINCT u.id_usuario, u.nombre
        FROM servicios_ocasionales so
        INNER JOIN usuarios u ON u.id_usuario = so.id_responsable
        ORDER BY u.nombre ASC");

        $sql->execute();

        while ($f = $sql->fetch(PDO::FETCH_ASSOC)) {
            $arr[] = $f;
        }

        return $arr;
    }

    public function filtrarReservasReporte($id_responsable, $id_cliente, $fecha_inicial, $fecha_final)
    {
        $this->asegurarEstructura();

        $arr = array();
        $con = Conexion::conectar();

        $sql = $con->prepare("
        SELECT
            so.id_servicio_ocasional,
            so.id_tipo_vehiculo,
            so.fecha_inicio,
            so.fecha_fin,
            so.hora_inicio,
            so.hora_fin,
            so.fecha_creacion,
            so.estado,
            so.origen,
            so.destino,
            so.tipo_servicio,
            so.cantidad_vehiculos,
            so.cantidad_pasajeros,
            so.valor_servicio,
            so.detalle_servicio,

            c.razon_social AS contratante,
            c.nit_cliente,
            e.nombre_empresa AS cliente,
           

            IFNULL(u.nombre, 'Sin responsable') AS responsable,

            IFNULL(cs.confirmacion_contabilidad, 0) AS confirmacion_contabilidad,
            IFNULL(cs.confirmacion_operaciones, 0) AS confirmacion_operaciones,
            IFNULL(cs.confirmacion_documental, 0) AS confirmacion_documental,
            IFNULL(cs.confirmacion_conductor, 0) AS confirmacion_conductor,

            IFNULL(cs.estado_contabilidad, '') AS estado_confirmacion_contabilidad,
            IFNULL(cs.estado_operaciones, '') AS estado_confirmacion_operaciones,
            IFNULL(cs.estado_documental, '') AS estado_confirmacion_documental,
            IFNULL(cs.estado_conductor, '') AS estado_confirmacion_conductor,

            IFNULL(cs.usuario_contabilidad, '') AS usuario_confirmacion_contabilidad,
            IFNULL(cs.usuario_operaciones, '') AS usuario_confirmacion_operaciones,
            IFNULL(cs.usuario_documental, '') AS usuario_confirmacion_documental,
            IFNULL(cs.usuario_conductor, '') AS usuario_confirmacion_conductor,

            IFNULL(cs.fecha_contabilidad, '') AS fecha_confirmacion_contabilidad,
            IFNULL(cs.fecha_operaciones, '') AS fecha_confirmacion_operaciones,
            IFNULL(cs.fecha_documental, '') AS fecha_confirmacion_documental,
            IFNULL(cs.fecha_conductor, '') AS fecha_confirmacion_conductor,

            (
                IFNULL(cs.confirmacion_contabilidad, 0) +
                IFNULL(cs.confirmacion_operaciones, 0) +
                IFNULL(cs.confirmacion_documental, 0) +
                IFNULL(cs.confirmacion_conductor, 0)
            ) AS total_confirmaciones,

            GROUP_CONCAT(DISTINCT vi.placa ORDER BY vi.placa SEPARATOR ' / ') AS placas_inicio,
            GROUP_CONCAT(DISTINCT vf.placa ORDER BY vf.placa SEPARATOR ' / ') AS placas_fin,
            GROUP_CONCAT(DISTINCT ci.nombre_conductor ORDER BY ci.nombre_conductor SEPARATOR ' / ') AS conductor_inicio,
            GROUP_CONCAT(DISTINCT cf.nombre_conductor ORDER BY cf.nombre_conductor SEPARATOR ' / ') AS conductor_fin,
            GROUP_CONCAT(
                DISTINCT (
                    CASE
                        WHEN REPLACE(UPPER(TRIM(IFNULL(vi.flota_propia, 'NO'))), 'Í', 'I') IN ('SI', 'S', '1', 'TRUE', 'FLOTA PROPIA') THEN
                            CONCAT('FLOTA PROPIA - ', IFNULL(NULLIF(TRIM(epi.nombre_empresa), ''), 'N/A'))
                        ELSE
                            CONCAT(
                                IFNULL(NULLIF(TRIM(vi.tipo_afiliacion), ''), 'N/A'),
                                CASE
                                    WHEN IFNULL(NULLIF(TRIM(vi.empresa_afiliada), ''), '') <> ''
                                         OR IFNULL(NULLIF(TRIM(vi.nit_empresa_afiliada), ''), '') <> ''
                                        THEN CONCAT(
                                            ' - ',
                                            IFNULL(NULLIF(TRIM(vi.empresa_afiliada), ''), 'SIN EMPRESA'),
                                            CASE
                                                WHEN IFNULL(NULLIF(TRIM(vi.nit_empresa_afiliada), ''), '') <> ''
                                                    THEN CONCAT(' (NIT: ', TRIM(vi.nit_empresa_afiliada), ')')
                                                ELSE ''
                                            END
                                        )
                                    ELSE ''
                                END
                            )
                    END
                )
                ORDER BY vi.placa SEPARATOR ' / '
            ) AS tipo_afiliacion_inicio,
            GROUP_CONCAT(
                DISTINCT (
                    CASE
                        WHEN REPLACE(UPPER(TRIM(IFNULL(vf.flota_propia, 'NO'))), 'Í', 'I') IN ('SI', 'S', '1', 'TRUE', 'FLOTA PROPIA') THEN
                            CONCAT('FLOTA PROPIA - ', IFNULL(NULLIF(TRIM(epf.nombre_empresa), ''), 'N/A'))
                        ELSE
                            CONCAT(
                                IFNULL(NULLIF(TRIM(vf.tipo_afiliacion), ''), 'N/A'),
                                CASE
                                    WHEN IFNULL(NULLIF(TRIM(vf.empresa_afiliada), ''), '') <> ''
                                         OR IFNULL(NULLIF(TRIM(vf.nit_empresa_afiliada), ''), '') <> ''
                                        THEN CONCAT(
                                            ' - ',
                                            IFNULL(NULLIF(TRIM(vf.empresa_afiliada), ''), 'SIN EMPRESA'),
                                            CASE
                                                WHEN IFNULL(NULLIF(TRIM(vf.nit_empresa_afiliada), ''), '') <> ''
                                                    THEN CONCAT(' (NIT: ', TRIM(vf.nit_empresa_afiliada), ')')
                                                ELSE ''
                                            END
                                        )
                                    ELSE ''
                                END
                            )
                    END
                )
                ORDER BY vf.placa SEPARATOR ' / '
            ) AS tipo_afiliacion_fin,

            dso.doc_rut,
            dso.doc_camara,
            dso.doc_cedula_rl,
            dso.doc_aceptacion,
            dso.doc_contrato,
            dso.doc_primer_abono,
            dso.doc_segundo_abono,
            dso.doc_prefactura,
            dso.doc_recibo_caja_abono_1,
            dso.doc_recibo_caja_abono_2,
            dso.doc_factura,
            dso.doc_fuec_generado,
            dso.doc_contrato_generado,
            dso.doc_fuec_documental,
            dso.doc_convenio_documental

        FROM servicios_ocasionales so
        INNER JOIN clientes c
            ON c.id_cliente = so.id_cliente
        INNER JOIN empresas e
            ON e.id_empresa = so.id_empresa
        LEFT JOIN usuarios u
            ON u.id_usuario = so.id_responsable
        LEFT JOIN confirmaciones_servicios_ocasionales cs
            ON cs.id_servicio_ocasional = so.id_servicio_ocasional
        LEFT JOIN operaciones_servicios_ocasionales op
            ON op.id_servicio_ocasional = so.id_servicio_ocasional
        LEFT JOIN vehiculos vi
            ON vi.id_vehiculo = op.id_vehiculo_inicio
        LEFT JOIN vehiculos vf
            ON vf.id_vehiculo = op.id_vehiculo_fin
        LEFT JOIN empresas epi
            ON epi.id_empresa = vi.id_empresa
        LEFT JOIN empresas epf
            ON epf.id_empresa = vf.id_empresa
        LEFT JOIN conductores ci
            ON ci.id_conductor = op.id_conductor_inicio
        LEFT JOIN conductores cf
            ON cf.id_conductor = op.id_conductor_fin
        LEFT JOIN doc_servicios_ocasionales dso
            ON dso.id_servicio_ocasional = so.id_servicio_ocasional

        WHERE so.id_responsable LIKE :id_responsable
          AND so.id_cliente LIKE :id_cliente
          AND DATE(so.fecha_creacion) >= :fecha_inicial
          AND DATE(so.fecha_creacion) <= :fecha_final

        GROUP BY
            so.id_servicio_ocasional,
            so.fecha_inicio,
            so.fecha_fin,
            so.hora_inicio,
            so.hora_fin,
            so.fecha_creacion,
            so.estado,
            so.origen,
            so.destino,
            so.tipo_servicio,
            so.cantidad_vehiculos,
            so.cantidad_pasajeros,
            so.valor_servicio,
            so.detalle_servicio,
            c.razon_social,
            c.nit_cliente,
            e.nombre_empresa,
            u.nombre,
            cs.confirmacion_contabilidad,
            cs.confirmacion_operaciones,
            cs.confirmacion_documental,
            cs.confirmacion_conductor,
            cs.estado_contabilidad,
            cs.estado_operaciones,
            cs.estado_documental,
            cs.estado_conductor,
            cs.usuario_contabilidad,
            cs.usuario_operaciones,
            cs.usuario_documental,
            cs.usuario_conductor,
            cs.fecha_contabilidad,
            cs.fecha_operaciones,
            cs.fecha_documental,
            cs.fecha_conductor,
            dso.doc_rut,
            dso.doc_camara,
            dso.doc_cedula_rl,
            dso.doc_aceptacion,
            dso.doc_contrato,
            dso.doc_primer_abono,
            dso.doc_segundo_abono,
            dso.doc_prefactura,
            dso.doc_recibo_caja_abono_1,
            dso.doc_recibo_caja_abono_2,
            dso.doc_factura,
            dso.doc_fuec_generado,
            dso.doc_contrato_generado,
            dso.doc_fuec_documental,
            dso.doc_convenio_documental

        ORDER BY so.id_servicio_ocasional DESC
    ");

        $sql->bindParam(':id_responsable', $id_responsable);
        $sql->bindParam(':id_cliente', $id_cliente);
        $sql->bindParam(':fecha_inicial', $fecha_inicial);
        $sql->bindParam(':fecha_final', $fecha_final);
        $sql->execute();

       while ($f = $sql->fetch(PDO::FETCH_ASSOC)) {
    $f['fecha_hora_inicio'] = trim($f['fecha_inicio'] . ' ' . $f['hora_inicio']);
    $f['fecha_hora_fin'] = trim($f['fecha_fin'] . ' ' . $f['hora_fin']);
    $f['nombre_tipo_vehiculo'] = isset($f['id_tipo_vehiculo'])
        ? $this->convertirIdsTipoVehiculoANombres($f['id_tipo_vehiculo'])
        : '';
    $arr[] = $f;
}

        return $arr;
    }

    public function listarVehiculosSimple()
    {
        $con = Conexion::conectar();
        $arr = array();
        $sql = $con->prepare("SELECT id_vehiculo, placa, marca, modelo FROM vehiculos WHERE estado = 1 ORDER BY placa ASC");
        $sql->execute();
        while ($f = $sql->fetch(PDO::FETCH_ASSOC)) {
            $arr[] = $f;
        }
        return $arr;
    }

    public function listarConductoresSimple()
    {
        $con = Conexion::conectar();
        $arr = array();
        $sql = $con->prepare("SELECT id_conductor, nombre_conductor, numero_documento_conductor FROM conductores ORDER BY nombre_conductor ASC");
        $sql->execute();
        while ($f = $sql->fetch(PDO::FETCH_ASSOC)) {
            $arr[] = $f;
        }
        return $arr;
    }

    public function listarConductoresPorVehiculo($id_vehiculo)
    {
        $con = Conexion::conectar();
        $arr = array();

        $sql = $con->prepare("SELECT
            c.id_conductor,
            c.nombre_conductor,
            c.numero_documento_conductor
        FROM vehiculos_conductores vc
        INNER JOIN conductores c ON c.id_conductor = vc.id_conductor
        WHERE vc.id_vehiculo = :id_vehiculo
        ORDER BY c.nombre_conductor ASC");

        $sql->bindParam(':id_vehiculo', $id_vehiculo, PDO::PARAM_INT);
        $sql->execute();

        while ($f = $sql->fetch(PDO::FETCH_ASSOC)) {
            $arr[] = $f;
        }

        return $arr;
    }

    public function listarAlertasDocumentacionOperacion($id_servicio_ocasional)
    {
        $this->asegurarEstructura();
        $hoy = date('Y-m-d');
        $alertas = array();

        $detalle = $this->listarDetalleOperacionConNombres($id_servicio_ocasional);
        $con = Conexion::conectar();

        foreach ($detalle as $fila) {
            foreach (array(
                array('campo' => 'id_vehiculo_inicio', 'label' => 'Vehículo inicio', 'placa' => 'placa_inicio'),
                array('campo' => 'id_vehiculo_fin', 'label' => 'Vehículo fin', 'placa' => 'placa_fin')
            ) as $cfgVehiculo) {
                $idVehiculo = isset($fila[$cfgVehiculo['campo']]) ? (int)$fila[$cfgVehiculo['campo']] : 0;
                if ($idVehiculo <= 0) {
                    continue;
                }

                $sqlVeh = $con->prepare("SELECT fecha_vencimiento_to, fecha_vencimiento_soat, fecha_vencimiento_rt, fecha_vencimiento_rp, fecha_vencimiento_contra
                    FROM vehiculos WHERE id_vehiculo = :id LIMIT 1");
                $sqlVeh->bindParam(':id', $idVehiculo);
                $sqlVeh->execute();
                $v = $sqlVeh->fetch(PDO::FETCH_ASSOC);
                if (!$v) {
                    continue;
                }

                foreach (array(
                    'fecha_vencimiento_to' => 'Tarjeta operación',
                    'fecha_vencimiento_soat' => 'SOAT',
                    'fecha_vencimiento_rt' => 'Revisión tecnomecánica',
                    'fecha_vencimiento_rp' => 'Revisión preventiva',
                    'fecha_vencimiento_contra' => 'Póliza contractual'
                ) as $campoFecha => $nombreDoc) {
                    if (!empty($v[$campoFecha]) && $v[$campoFecha] !== '0000-00-00' && $v[$campoFecha] < $hoy) {
                        $alertas[] = $cfgVehiculo['label'] . ' (' . (isset($fila[$cfgVehiculo['placa']]) ? $fila[$cfgVehiculo['placa']] : 'N/A') . ') tiene ' . $nombreDoc . ' vencido (' . $v[$campoFecha] . ').';
                    }
                }
            }

            foreach (array(
                array('campo' => 'id_conductor_inicio', 'label' => 'Conductor inicio', 'nombre' => 'conductor_inicio'),
                array('campo' => 'id_conductor_fin', 'label' => 'Conductor fin', 'nombre' => 'conductor_fin')
            ) as $cfgConductor) {
                $idConductor = isset($fila[$cfgConductor['campo']]) ? (int)$fila[$cfgConductor['campo']] : 0;
                if ($idConductor <= 0) {
                    continue;
                }

                $sqlCon = $con->prepare("SELECT fecha_vencimiento_licencia FROM conductores WHERE id_conductor = :id LIMIT 1");
                $sqlCon->bindParam(':id', $idConductor);
                $sqlCon->execute();
                $c = $sqlCon->fetch(PDO::FETCH_ASSOC);

                if ($c && !empty($c['fecha_vencimiento_licencia']) && $c['fecha_vencimiento_licencia'] !== '0000-00-00' && $c['fecha_vencimiento_licencia'] < $hoy) {
                    $alertas[] = $cfgConductor['label'] . ' (' . (isset($fila[$cfgConductor['nombre']]) ? $fila[$cfgConductor['nombre']] : 'N/A') . ') tiene licencia vencida (' . $c['fecha_vencimiento_licencia'] . ').';
                }
            }
        }

        return $alertas;
    }

    public function guardarDocumentoFuecServicioOcasional($id_servicio_ocasional, $consecutivo, $tipo_trayecto, $documento, $id_usuario = 0)
    {
        $this->asegurarEstructura();

        $tipo = strtoupper(trim($tipo_trayecto));
        if (!in_array($tipo, array('INICIO', 'FIN'), true)) {
            return false;
        }

        $con = Conexion::conectar();

        $sqlBase = $con->prepare("INSERT INTO doc_servicios_ocasionales (id_servicio_ocasional, fecha_registro)
            VALUES (:id_servicio, NOW())
            ON DUPLICATE KEY UPDATE fecha_registro = NOW()");
        $sqlBase->bindParam(':id_servicio', $id_servicio_ocasional, PDO::PARAM_INT);
        $sqlBase->execute();

        $docActual = $this->listarDocumentosServicioOcasional($id_servicio_ocasional);
        $mapa = array();
        if (!empty($docActual['doc_fuec_documental'])) {
            $tmp = json_decode($docActual['doc_fuec_documental'], true);
            if (is_array($tmp)) {
                $mapa = $tmp;
            }
        }

        if (!isset($mapa[$consecutivo]) || !is_array($mapa[$consecutivo])) {
            $mapa[$consecutivo] = array();
        }

        $mapa[$consecutivo][$tipo] = array(
            'documento_fuec' => $documento,
            'fecha_registro' => date('Y-m-d H:i:s'),
            'id_usuario' => (int)$id_usuario
        );

        $jsonMapa = json_encode($mapa);
        $sql = $con->prepare("UPDATE doc_servicios_ocasionales
            SET doc_fuec_documental = :mapa, fecha_registro = NOW()
            WHERE id_servicio_ocasional = :id_servicio
            LIMIT 1");
        $sql->bindParam(':mapa', $jsonMapa);
        $sql->bindParam(':id_servicio', $id_servicio_ocasional, PDO::PARAM_INT);

        $ok = $sql->execute();
        if ($ok) {
            $nombreUsuario = $id_usuario > 0 ? $this->nombreUsuario((int)$id_usuario) : 'DOCUMENTAL';
            $placa = $this->obtenerPlacaTrayecto((int)$id_servicio_ocasional, (int)$consecutivo, $tipo);
            $this->notificarAdministrativos(
                (int)$id_usuario,
                $nombreUsuario,
                'DOCUMENTAL',
                $nombreUsuario . ' subió el FUEC de la placa ' . $placa . ' para la reserva #' . (int)$id_servicio_ocasional . ' el ' . date('Y-m-d H:i:s') . '.',
                (int)$id_servicio_ocasional
            );

            $idConductorTrayecto = $this->obtenerConductorTrayecto((int)$id_servicio_ocasional, (int)$consecutivo, $tipo);
            if ($idConductorTrayecto > 0) {
                $this->notificarConductor(
                    (int)$idConductorTrayecto,
                    (int)$id_usuario,
                    $nombreUsuario,
                    'DOCUMENTAL',
                    $nombreUsuario . ' subió el FUEC de la placa ' . $placa . ' para tu servicio en la reserva #' . (int)$id_servicio_ocasional . ' el ' . date('Y-m-d H:i:s') . '.',
                    (int)$id_servicio_ocasional
                );
            }
        }
        return $ok;
    }

    public function guardarDocumentoConvenioServicioOcasional($id_servicio_ocasional, $consecutivo, $tipo_trayecto, $aplica, $documento = '', $id_usuario = 0)
{
    $this->asegurarEstructura();

    $tipo = strtoupper(trim($tipo_trayecto));
    if (!in_array($tipo, array('INICIO', 'FIN'), true)) {
        return false;
    }

    $con = Conexion::conectar();

    $sqlBase = $con->prepare("INSERT INTO doc_servicios_ocasionales (id_servicio_ocasional, fecha_registro)
        VALUES (:id_servicio, NOW())
        ON DUPLICATE KEY UPDATE fecha_registro = NOW()");
    $sqlBase->bindParam(':id_servicio', $id_servicio_ocasional, PDO::PARAM_INT);
    $sqlBase->execute();

    $docActual = $this->listarDocumentosServicioOcasional($id_servicio_ocasional);
    $mapa = array();

    if (!empty($docActual['doc_convenio_documental'])) {
        $tmp = json_decode($docActual['doc_convenio_documental'], true);
        if (is_array($tmp)) {
            $mapa = $tmp;
        }
    }

    if (!isset($mapa[$consecutivo]) || !is_array($mapa[$consecutivo])) {
        $mapa[$consecutivo] = array();
    }

    $mapa[$consecutivo][$tipo] = array(
        'aplica' => ((int)$aplica === 1 ? 1 : 0),
        'documento_convenio' => $documento,
        'fecha_registro' => date('Y-m-d H:i:s'),
        'id_usuario' => (int)$id_usuario
    );

    $jsonMapa = json_encode($mapa);

    $sql = $con->prepare("UPDATE doc_servicios_ocasionales
        SET doc_convenio_documental = :mapa, fecha_registro = NOW()
        WHERE id_servicio_ocasional = :id_servicio
        LIMIT 1");
    $sql->bindParam(':mapa', $jsonMapa);
    $sql->bindParam(':id_servicio', $id_servicio_ocasional, PDO::PARAM_INT);

    $ok = $sql->execute();

if ($ok) {
    $nombreUsuario = $id_usuario > 0 ? $this->nombreUsuario((int)$id_usuario) : 'DOCUMENTAL';
    $placa = $this->obtenerPlacaTrayecto((int)$id_servicio_ocasional, (int)$consecutivo, $tipo);

    if ((int)$aplica === 1) {
        $this->notificarAdministrativos(
            (int)$id_usuario,
            $nombreUsuario,
            'DOCUMENTAL',
            $nombreUsuario . ' registró convenio de colaboración para la placa ' . $placa . ' en la reserva #' . (int)$id_servicio_ocasional . ' el ' . date('Y-m-d H:i:s') . '.',
            (int)$id_servicio_ocasional
        );

        $idConductorTrayecto = $this->obtenerConductorTrayecto((int)$id_servicio_ocasional, (int)$consecutivo, $tipo);
        if ($idConductorTrayecto > 0) {
            $this->notificarConductor(
                (int)$idConductorTrayecto,
                (int)$id_usuario,
                $nombreUsuario,
                'DOCUMENTAL',
                $nombreUsuario . ' registró convenio de colaboración para la placa ' . $placa . ' en tu servicio de la reserva #' . (int)$id_servicio_ocasional . ' el ' . date('Y-m-d H:i:s') . '.',
                (int)$id_servicio_ocasional
            );
        }
    }
}

return $ok;
}

    public function listarDocumentosFuecServicioOcasional($id_servicio_ocasional)
    {
        $this->asegurarEstructura();
        $arr = array();

        $docs = $this->listarDocumentosServicioOcasional($id_servicio_ocasional);
        if (!empty($docs['doc_fuec_documental'])) {
            $tmp = json_decode($docs['doc_fuec_documental'], true);
            if (is_array($tmp)) {
                foreach ($tmp as $consecutivo => $trayectos) {
                    $cons = (int)$consecutivo;
                    if (!is_array($trayectos)) {
                        continue;
                    }
                    foreach ($trayectos as $tipo => $data) {
                        $tipoKey = strtoupper($tipo);
                        if ($tipoKey !== 'INICIO' && $tipoKey !== 'FIN') {
                            continue;
                        }
                        $arr[$cons][$tipoKey] = is_array($data) ? $data : array('documento_fuec' => $data);
                    }
                }
                return $arr;
            }
        }

        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT consecutivo, tipo_trayecto, documento_fuec, id_contrato_ocasional
            FROM fuec_servicios_ocasionales
            WHERE id_servicio_ocasional = :id
            ORDER BY consecutivo ASC");
        $sql->bindParam(':id', $id_servicio_ocasional, PDO::PARAM_INT);
        $sql->execute();

        while ($f = $sql->fetch(PDO::FETCH_ASSOC)) {
            $cons = (int)$f['consecutivo'];
            $tipo = strtoupper($f['tipo_trayecto']);
            if (!isset($arr[$cons])) {
                $arr[$cons] = array();
            }
            $arr[$cons][$tipo] = $f;
        }

        return $arr;
    }

    public function listarDocumentosConvenioServicioOcasional($id_servicio_ocasional)
{
    $this->asegurarEstructura();
    $arr = array();

    $docs = $this->listarDocumentosServicioOcasional($id_servicio_ocasional);
    if (!empty($docs['doc_convenio_documental'])) {
        $tmp = json_decode($docs['doc_convenio_documental'], true);
        if (is_array($tmp)) {
            foreach ($tmp as $consecutivo => $trayectos) {
                $cons = (int)$consecutivo;
                if (!is_array($trayectos)) {
                    continue;
                }
                foreach ($trayectos as $tipo => $data) {
                    $tipoKey = strtoupper($tipo);
                    if ($tipoKey !== 'INICIO' && $tipoKey !== 'FIN') {
                        continue;
                    }
                    $arr[$cons][$tipoKey] = is_array($data) ? $data : array(
                        'aplica' => 0,
                        'documento_convenio' => ''
                    );
                }
            }
        }
    }

    return $arr;
}

    public function obtenerOGenerarFuecServiciosOcasionales($id_servicio_ocasional, $id_usuario)
    {
        $this->asegurarEstructura();
        require_once(__DIR__ . '/contratoOcasional.php');
        require_once(__DIR__ . '/Fuec.php');
        require_once(__DIR__ . '/Cliente.php');

        $servicioData = $this->listarServicioPorId($id_servicio_ocasional);
        if (count($servicioData) < 1) {
            return array();
        }

        $servicio = $servicioData[0];
        $operaciones = $this->listarDetalleOperacion($id_servicio_ocasional);
        $con = Conexion::conectar();

        $clienteModel = new Cliente();
        $clienteData = $clienteModel->listarClientePorId($servicio['id_cliente']);
        $cliente = isset($clienteData[0]) ? $clienteData[0] : array();

        $fuecModel = new Fuec();
        $contratoModel = new ContratoOcasional();
        $aprobacion = $fuecModel->aprobacionPorEmpresa($servicio['id_empresa']);

        $cod_ciudad = isset($aprobacion[0]['cod_ciudad']) ? $aprobacion[0]['cod_ciudad'] : '000';
        $num_aprobacion = isset($aprobacion[0]['num_aprobacion']) ? $aprobacion[0]['num_aprobacion'] : '0000';
        $year_aprobacion = isset($aprobacion[0]['fecha']) ? date('y', strtotime($aprobacion[0]['fecha'])) : date('y');
        $year = date('Y');

        $mapa = array();

        foreach ($operaciones as $fila) {
            $consecutivo = (int)$fila['consecutivo'];
            $trayectos = array(
                'INICIO' => array(
                    'id_vehiculo' => (int)$fila['id_vehiculo_inicio'],
                    'id_conductor' => (int)$fila['id_conductor_inicio']
                )
            );

            if (!empty($fila['id_vehiculo_fin']) && (int)$fila['id_vehiculo_fin'] !== (int)$fila['id_vehiculo_inicio']) {
                $trayectos['FIN'] = array(
                    'id_vehiculo' => (int)$fila['id_vehiculo_fin'],
                    'id_conductor' => (int)$fila['id_conductor_fin']
                );
            }

            foreach ($trayectos as $tipoTrayecto => $trayecto) {
                if ($trayecto['id_vehiculo'] <= 0) {
                    continue;
                }

                $existente = $con->prepare("SELECT * FROM fuec_servicios_ocasionales WHERE id_servicio_ocasional = :id AND consecutivo = :consecutivo AND tipo_trayecto = :tipo LIMIT 1");
                $existente->bindParam(':id', $id_servicio_ocasional);
                $existente->bindParam(':consecutivo', $consecutivo);
                $existente->bindParam(':tipo', $tipoTrayecto);
                $existente->execute();
                $filaExistente = $existente->fetch(PDO::FETCH_ASSOC);

                if ($filaExistente) {
                    $mapa[$consecutivo][$tipoTrayecto] = array(
                        'id_contrato_ocasional' => $filaExistente['id_contrato_ocasional'],
                        'id_fuec' => $filaExistente['id_fuec']
                    );
                    continue;
                }

                $objeto = 'SERVICIO OCASIONAL #' . $id_servicio_ocasional . ' - ' . $tipoTrayecto;
                $idContrato = $contratoModel->registrarContratoOcasional(
                    $objeto,
                    $servicio['id_empresa'],
                    $servicio['id_cliente'],
                    $trayecto['id_vehiculo'],
                    $servicio['origen'],
                    $servicio['destino'],
                    0,
                    $servicio['fecha_inicio'],
                    $servicio['fecha_fin'],
                    date('Y-m-d'),
                    date('H:i:s'),
                    $servicio['valor_servicio'],
                    $id_usuario,
                    'P'
                );

                if (empty($idContrato)) {
                    continue;
                }

                $cantidad = $fuecModel->listarTotalFuecEmitidos(date('Y'));
                $cantidad = isset($cantidad[0]['cantidad']) ? ((int)$cantidad[0]['cantidad'] + 1) : 1;
                $num_unico_emision = str_pad((string)$cantidad, 4, '0', STR_PAD_LEFT);
                $num_contrato = str_pad((string)$idContrato, 4, '0', STR_PAD_LEFT);
                $num_comprobante = $cod_ciudad . $num_aprobacion . $year_aprobacion . $year . substr($num_contrato, -4) . $num_unico_emision;

                $idFuec = $fuecModel->registrarFuec(
                    date('YmdHis') . $consecutivo,
                    $num_comprobante,
                    $num_unico_emision,
                    $servicio['origen'],
                    $servicio['destino'],
                    $servicio['tipo_servicio'],
                    'NO',
                    $servicio['fecha_inicio'],
                    $servicio['fecha_fin'],
                    $trayecto['id_vehiculo'],
                    0,
                    $idContrato,
                    isset($cliente['razon_social']) ? $cliente['razon_social'] : '',
                    isset($cliente['nit_cliente']) ? $cliente['nit_cliente'] : '',
                    isset($cliente['direccionC']) ? $cliente['direccionC'] : '',
                    isset($cliente['telefonoC']) ? $cliente['telefonoC'] : '',
                    $id_usuario,
                    date('Y-m-d H:i:s'),
                    'N',
                    'A'
                );

                if (empty($idFuec)) {
                    continue;
                }

                $ins = $con->prepare("INSERT INTO fuec_servicios_ocasionales
                    (id_servicio_ocasional, consecutivo, tipo_trayecto, id_vehiculo, id_conductor, id_contrato_ocasional, id_fuec)
                    VALUES (:id_servicio, :consecutivo, :tipo, :id_vehiculo, :id_conductor, :id_contrato, :id_fuec)");
                $ins->bindParam(':id_servicio', $id_servicio_ocasional);
                $ins->bindParam(':consecutivo', $consecutivo);
                $ins->bindParam(':tipo', $tipoTrayecto);
                $ins->bindParam(':id_vehiculo', $trayecto['id_vehiculo']);
                $ins->bindParam(':id_conductor', $trayecto['id_conductor']);
                $ins->bindParam(':id_contrato', $idContrato);
                $ins->bindParam(':id_fuec', $idFuec);
                $ins->execute();

                $mapa[$consecutivo][$tipoTrayecto] = array(
                    'id_contrato_ocasional' => $idContrato,
                    'id_fuec' => $idFuec
                );
            }
        }

        return $mapa;
    }

}
?>