<?php
require_once("Conexion/conexionBD.php");

class NotificacionInternaAdministrativo
{
    private $correoRemitente = 'auxiliaroperativakve@gmail.com';
    private $nombreSistema = 'SISTEMA KV';

    private function asegurarEstructura()
    {
        $con = Conexion::conectar();

        $con->exec("CREATE TABLE IF NOT EXISTS notificaciones_internas_admin (
            id_notificacion INT AUTO_INCREMENT PRIMARY KEY,
            id_usuario_destino INT NOT NULL,
            id_usuario_remitente INT NULL,
            remitente VARCHAR(180) NOT NULL,
            area VARCHAR(80) NOT NULL,
            modulo VARCHAR(80) NOT NULL,
            id_referencia INT NULL,
            fecha_hora DATETIME NOT NULL,
            contenido TEXT NOT NULL,
            leido TINYINT(1) NOT NULL DEFAULT 0
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $con->exec("CREATE TABLE IF NOT EXISTS notificaciones_internas_admin_usuarios (
            id_notificacion INT NOT NULL,
            id_usuario_destino INT NOT NULL,
            leido TINYINT(1) NOT NULL DEFAULT 0,
            fecha_lectura DATETIME NULL,
            PRIMARY KEY (id_notificacion, id_usuario_destino)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

        try {
            $con->exec("ALTER TABLE notificaciones_internas_admin MODIFY COLUMN id_notificacion INT NOT NULL AUTO_INCREMENT");
        } catch (Exception $e) {
        }

        $con->exec("INSERT IGNORE INTO notificaciones_internas_admin_usuarios (id_notificacion, id_usuario_destino, leido)
            SELECT id_notificacion, id_usuario_destino, leido
            FROM notificaciones_internas_admin
            WHERE id_usuario_destino > 0");
    }

    private function normalizarTexto($texto)
    {
        $texto = strtoupper(trim((string)$texto));
        $texto = str_replace(
            array('Á', 'É', 'Í', 'Ó', 'Ú', 'á', 'é', 'í', 'ó', 'ú', 'Ñ', 'ñ'),
            array('A', 'E', 'I', 'O', 'U', 'A', 'E', 'I', 'O', 'U', 'N', 'N'),
            $texto
        );
        $texto = preg_replace('/\s+/', ' ', $texto);
        return $texto;
    }

    private function escribirLogCorreo($mensaje)
    {
        $rutaDir = __DIR__ . '/../logs';
        if (!is_dir($rutaDir)) {
            @mkdir($rutaDir, 0777, true);
        }

        $linea = '[' . date('Y-m-d H:i:s') . '] ' . $mensaje . PHP_EOL;
        @file_put_contents($rutaDir . '/notificaciones_correo.log', $linea, FILE_APPEND);
    }

    private function limpiarCorreo($correo)
    {
        $correo = strtolower(trim((string)$correo));
        $correo = str_replace(array("\r", "\n", "\t", " "), '', $correo);
        return $correo;
    }

    public function obtenerUsuariosDestinoServiciosOcasionales()
{
    $this->asegurarEstructura();
    $con = Conexion::conectar();

    $destinatarios = array();

    $sql = $con->prepare("
        SELECT 
            u.id_usuario,
            u.nombre,
            u.correo_electronico,
            u.id_cargo,
            c.nombre_cargo
        FROM usuarios u
        INNER JOIN cargos c ON c.id_cargo = u.id_cargo
        WHERE u.estado = 1
    ");
    $sql->execute();

    $rows = $sql->fetchAll(PDO::FETCH_ASSOC);
    $correosYaAgregados = array();

    $cargosPermitidos = array(
        'AUXILIAR CARTERA LP',
        'JEFE CARTERA',
        'LIDER DE FLOTA PROPIA',
        'ANALISTA DE GESTIÓN DOCUMENTAL',
        'ANALISTA DE GESTION DOCUMENTAL',
        'LIDER COMERCIAL PRIVADO'
    );

    foreach ($rows as $fila) {
        $nombreCargo = $this->normalizarTexto(isset($fila['nombre_cargo']) ? $fila['nombre_cargo'] : '');
        $correo = $this->limpiarCorreo(isset($fila['correo_electronico']) ? $fila['correo_electronico'] : '');

       $esDestino = in_array($nombreCargo, $cargosPermitidos, true);

        if (!$esDestino) {
            continue;
        }

        if (empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $this->escribirLogCorreo(
                "Usuario destino descartado | ID usuario: " . (int)$fila['id_usuario'] .
                " | ID cargo: " . (int)$fila['id_cargo'] .
                " | Cargo: {$nombreCargo} | Correo inválido: {$correo}"
            );
            continue;
        }

        if (isset($correosYaAgregados[$correo])) {
            continue;
        }

        $correosYaAgregados[$correo] = true;

        $destinatarios[] = array(
            'id_usuario' => (int)$fila['id_usuario'],
            'nombre' => isset($fila['nombre']) ? $fila['nombre'] : '',
            'correo_electronico' => $correo,
            'id_cargo' => (int)$fila['id_cargo'],
            'nombre_cargo' => $nombreCargo
        );

        $this->escribirLogCorreo(
            "Usuario destino encontrado | ID usuario: " . (int)$fila['id_usuario'] .
            " | ID cargo: " . (int)$fila['id_cargo'] .
            " | Cargo: {$nombreCargo} | Correo: {$correo}"
        );
    }

    $this->escribirLogCorreo("Total destinatarios encontrados: " . count($destinatarios));

    return $destinatarios;
}

    public function crearNotificacionServiciosOcasionales($idUsuarioRemitente, $remitente, $area, $contenido, $idReferencia = 0)
{
    $this->asegurarEstructura();
    $con = Conexion::conectar();

    $fechaHora = date('Y-m-d H:i:s');

    $sqlNotificacion = $con->prepare("INSERT INTO notificaciones_internas_admin
        (id_usuario_destino, id_usuario_remitente, remitente, area, modulo, id_referencia, fecha_hora, contenido, leido)
        VALUES (0, :id_usuario_remitente, :remitente, :area, 'servicios_ocasionales', :id_referencia, :fecha_hora, :contenido, 0)");

    $sqlNotificacion->bindValue(':id_usuario_remitente', (int)$idUsuarioRemitente, PDO::PARAM_INT);
    $sqlNotificacion->bindValue(':remitente', (string)$remitente, PDO::PARAM_STR);
    $sqlNotificacion->bindValue(':area', (string)$area, PDO::PARAM_STR);
    $sqlNotificacion->bindValue(':id_referencia', (int)$idReferencia, PDO::PARAM_INT);
    $sqlNotificacion->bindValue(':fecha_hora', $fechaHora, PDO::PARAM_STR);
    $sqlNotificacion->bindValue(':contenido', (string)$contenido, PDO::PARAM_STR);
    $sqlNotificacion->execute();

    $numeroNotificacion = (int)$con->lastInsertId();
    $this->escribirLogCorreo("Notificación creada en BD: #{$numeroNotificacion}");

    $destinatarios = $this->obtenerUsuariosDestinoServiciosOcasionales();

    if (count($destinatarios) < 1) {
        $this->escribirLogCorreo("No hay destinatarios para la notificación #{$numeroNotificacion}");
        return true;
    }

    $sqlDestino = $con->prepare("INSERT IGNORE INTO notificaciones_internas_admin_usuarios
        (id_notificacion, id_usuario_destino, leido)
        VALUES (:id_notificacion, :id_usuario_destino, 0)");

    foreach ($destinatarios as $d) {
        $idDestino = (int)$d['id_usuario'];
        $correo = $this->limpiarCorreo($d['correo_electronico']);

        $sqlDestino->bindValue(':id_notificacion', $numeroNotificacion, PDO::PARAM_INT);
        $sqlDestino->bindValue(':id_usuario_destino', $idDestino, PDO::PARAM_INT);
        $sqlDestino->execute();

        $this->escribirLogCorreo(
            "Intentando envío | Notificación #{$numeroNotificacion} | Usuario destino: {$idDestino} | Correo: {$correo}"
        );

        $okMail = $this->enviarCorreoNotificacion(
            $correo,
            $numeroNotificacion,
            $remitente,
            $area,
            $fechaHora,
            $contenido
        );

        if ($okMail) {
            $this->escribirLogCorreo("ENVÍO OK | Notificación #{$numeroNotificacion} | Correo: {$correo}");
        } else {
            $this->escribirLogCorreo("ENVÍO ERROR | Notificación #{$numeroNotificacion} | Correo: {$correo}");
        }
    }

    return true;
}

    public function contarNoLeidasUsuario($idUsuario)
    {
        $this->asegurarEstructura();
        $con = Conexion::conectar();

        $sql = $con->prepare("SELECT COUNT(*) AS total
            FROM notificaciones_internas_admin_usuarios
            WHERE id_usuario_destino = :id AND leido = 0");
        $sql->bindValue(':id', (int)$idUsuario, PDO::PARAM_INT);
        $sql->execute();

        $r = $sql->fetch(PDO::FETCH_ASSOC);
        return isset($r['total']) ? (int)$r['total'] : 0;
    }

    public function listarPorUsuario($idUsuario)
    {
        $this->asegurarEstructura();
        $con = Conexion::conectar();
        $arr = array();

        $sql = $con->prepare("SELECT n.*, nu.leido, nu.fecha_lectura
            FROM notificaciones_internas_admin n
            INNER JOIN notificaciones_internas_admin_usuarios nu ON nu.id_notificacion = n.id_notificacion
            WHERE nu.id_usuario_destino = :id
            ORDER BY n.id_notificacion DESC");
        $sql->bindValue(':id', (int)$idUsuario, PDO::PARAM_INT);
        $sql->execute();

        $numeroVisual = 1;
        while ($f = $sql->fetch(PDO::FETCH_ASSOC)) {
            $f['numero_visual'] = $numeroVisual;
            $numeroVisual++;
            $arr[] = $f;
        }

        return $arr;
    }

    public function marcarLeida($idNotificacion, $idUsuario)
    {
        $this->asegurarEstructura();
        $con = Conexion::conectar();

        $sql = $con->prepare("UPDATE notificaciones_internas_admin_usuarios
            SET leido = 1, fecha_lectura = NOW()
            WHERE id_notificacion = :id_notificacion
              AND id_usuario_destino = :id_usuario");

        $sql->bindValue(':id_notificacion', (int)$idNotificacion, PDO::PARAM_INT);
        $sql->bindValue(':id_usuario', (int)$idUsuario, PDO::PARAM_INT);

        return $sql->execute();
    }

   private function enviarCorreoNotificacion($correoDestino, $numeroNotificacion, $remitente, $area, $fechaHora, $contenido)
{
    $correoDestino = $this->limpiarCorreo($correoDestino);
    $correoRemitente = $this->limpiarCorreo($this->correoRemitente);

    if (empty($correoDestino) || !filter_var($correoDestino, FILTER_VALIDATE_EMAIL)) {
        $this->escribirLogCorreo("Correo destino inválido: {$correoDestino}");
        return false;
    }

    if (empty($correoRemitente) || !filter_var($correoRemitente, FILTER_VALIDATE_EMAIL)) {
        $this->escribirLogCorreo("Correo remitente inválido: {$correoRemitente}");
        return false;
    }

    $asunto = "NOTIFICACION SISTEMA KV #{$numeroNotificacion}";

    $mensaje  = "N° de notificación: {$numeroNotificacion}\r\n";
    $mensaje .= "Remitente: {$remitente}\r\n";
    $mensaje .= "Área: {$area}\r\n";
    $mensaje .= "Fecha y hora: {$fechaHora}\r\n";
    $mensaje .= "Contenido: {$contenido}\r\n\r\n";
    $mensaje .= "Para validar la información, por favor ingresar a la intranet {$this->nombreSistema}.\r\n";

    $headers = array();
    $headers[] = "From: {$correoRemitente}";
    $headers[] = "Reply-To: {$correoRemitente}";
    $headers[] = "MIME-Version: 1.0";
    $headers[] = "Content-Type: text/plain; charset=UTF-8";
    $headers[] = "X-Mailer: PHP/" . phpversion();

    $headersString = implode("\r\n", $headers);

    ini_set('sendmail_from', $correoRemitente);

    $resultado = mail($correoDestino, $asunto, $mensaje, $headersString);

    return $resultado === true;
}
}
?>