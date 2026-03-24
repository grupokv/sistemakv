<?php
require_once("Conexion/conexionBD.php");

class NotificacionInternaConductor
{
    private function asegurarEstructura()
    {
        $con = Conexion::conectar();
        $con->exec("CREATE TABLE IF NOT EXISTS notificaciones_internas_conductor (
            id_notificacion INT AUTO_INCREMENT PRIMARY KEY,
            id_conductor INT NOT NULL,
            id_usuario_remitente INT NULL,
            remitente VARCHAR(180) NOT NULL,
            area VARCHAR(80) NOT NULL,
            modulo VARCHAR(80) NOT NULL,
            id_referencia INT NULL,
            fecha_hora DATETIME NOT NULL,
            contenido TEXT NOT NULL,
            leido TINYINT(1) NOT NULL DEFAULT 0
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
    }

    public function obtenerConductorPorDocumentoSesion($documentoSesion)
    {
        $this->asegurarEstructura();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT id_conductor, nombre_conductor, correo_electronico
            FROM conductores
            WHERE numero_documento_conductor = :doc
            LIMIT 1");
        $sql->bindParam(':doc', $documentoSesion);
        $sql->execute();
        $f = $sql->fetch(PDO::FETCH_ASSOC);
        return $f ? $f : array();
    }

    public function crearNotificacion($idConductor, $idUsuarioRemitente, $remitente, $area, $contenido, $idReferencia = 0)
    {
        $this->asegurarEstructura();

        $idConductor = (int)$idConductor;
        if ($idConductor <= 0) {
            return false;
        }

        $con = Conexion::conectar();
        $fechaHora = date('Y-m-d H:i:s');

        $sql = $con->prepare("INSERT INTO notificaciones_internas_conductor
            (id_conductor, id_usuario_remitente, remitente, area, modulo, id_referencia, fecha_hora, contenido, leido)
            VALUES (:id_conductor, :id_usuario_remitente, :remitente, :area, 'servicios_ocasionales', :id_referencia, :fecha_hora, :contenido, 0)");
        $sql->bindParam(':id_conductor', $idConductor, PDO::PARAM_INT);
        $sql->bindParam(':id_usuario_remitente', $idUsuarioRemitente);
        $sql->bindParam(':remitente', $remitente);
        $sql->bindParam(':area', $area);
        $sql->bindParam(':id_referencia', $idReferencia);
        $sql->bindParam(':fecha_hora', $fechaHora);
        $sql->bindParam(':contenido', $contenido);
        $ok = $sql->execute();

        if ($ok) {
            $numeroNotificacion = (int)$con->lastInsertId();
            $destino = $this->obtenerConductorPorId($idConductor);
            if (!empty($destino['correo_electronico'])) {
                $correo = strtolower(trim($destino['correo_electronico']));
                if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                    $this->enviarCorreoNotificacion($correo, $numeroNotificacion, $remitente, $area, $fechaHora, $contenido);
                }
            }
        }

        return $ok;
    }

    public function contarNoLeidasConductor($idConductor)
    {
        $this->asegurarEstructura();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT COUNT(*) AS total FROM notificaciones_internas_conductor WHERE id_conductor = :id AND leido = 0");
        $sql->bindParam(':id', $idConductor, PDO::PARAM_INT);
        $sql->execute();
        $r = $sql->fetch(PDO::FETCH_ASSOC);
        return isset($r['total']) ? (int)$r['total'] : 0;
    }


    public function listarPorConductor($idConductor)
{
    $this->asegurarEstructura();
    $con = Conexion::conectar();
    $arr = array();

    $sql = $con->prepare("SELECT * FROM notificaciones_internas_conductor WHERE id_conductor = :id ORDER BY id_notificacion DESC");
    $sql->bindParam(':id', $idConductor, PDO::PARAM_INT);
    $sql->execute();

    while ($f = $sql->fetch(PDO::FETCH_ASSOC)) {
        $f['numero_visual'] = isset($f['id_notificacion']) ? (int)$f['id_notificacion'] : 0;
        $arr[] = $f;
    }

    return $arr;
}

    public function marcarLeidaConductor($idNotificacion, $idConductor)
    {
        $this->asegurarEstructura();
        $con = Conexion::conectar();
        $sql = $con->prepare("UPDATE notificaciones_internas_conductor
            SET leido = 1
            WHERE id_notificacion = :id_notificacion AND id_conductor = :id_conductor");
        $sql->bindParam(':id_notificacion', $idNotificacion, PDO::PARAM_INT);
        $sql->bindParam(':id_conductor', $idConductor, PDO::PARAM_INT);
        return $sql->execute();
    }

    public function marcarLeidasConductor($idConductor)
    {
        $this->asegurarEstructura();
        $con = Conexion::conectar();
        $sql = $con->prepare("UPDATE notificaciones_internas_conductor SET leido = 1 WHERE id_conductor = :id");
        $sql->bindParam(':id', $idConductor, PDO::PARAM_INT);
        return $sql->execute();
    }

    private function obtenerConductorPorId($idConductor)
    {
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT id_conductor, nombre_conductor, correo_electronico FROM conductores WHERE id_conductor = :id LIMIT 1");
        $sql->bindParam(':id', $idConductor, PDO::PARAM_INT);
        $sql->execute();
        $f = $sql->fetch(PDO::FETCH_ASSOC);
        return $f ? $f : array();
    }

    private function enviarCorreoNotificacion($correoDestino, $numeroNotificacion, $remitente, $area, $fechaHora, $contenido)
    {
        $asunto = 'NOTIFICACION SISTEMA KV';
        $mensaje = "N° de notificación: {$numeroNotificacion}\n" .
            "Remitente: {$remitente}\n" .
            "Área: {$area}\n" .
            "Fecha y hora: {$fechaHora}\n" .
            "Contenido: {$contenido}\n\n" .
            "Para validar la información por favor ingresar a la intranet SISTEMA KV.";

        $headers = "From: desarrollo@ortsas.com\r\n" .
            "Reply-To: desarrollo@ortsas.com\r\n" .
            "MIME-Version: 1.0\r\n" .
            "Content-Type: text/plain; charset=UTF-8\r\n" .
            "X-Mailer: PHP/" . phpversion();

        @mail(strtolower(trim($correoDestino)), $asunto, $mensaje, $headers);
    }
}