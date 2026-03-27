<?php
require_once __DIR__ . '/Conexion/conexionBD.php';

class CRMComercial
{
    private $con;

    public function __construct()
    {
        $this->con = Conexion::conectar();
    }

    public function crearTablaSiNoExiste()
    {
        $sql = "CREATE TABLE IF NOT EXISTS crm_comercial (
            id INT AUTO_INCREMENT PRIMARY KEY,
            fecha_ingreso DATE NOT NULL,
            nombre VARCHAR(180) NOT NULL,
            empresa VARCHAR(180) NOT NULL,
            estado_venta VARCHAR(120) NOT NULL,
            tipo_cliente VARCHAR(80) NOT NULL,
            status_porcentaje TINYINT NOT NULL DEFAULT 0,
            telefono VARCHAR(60) DEFAULT NULL,
            correo VARCHAR(180) DEFAULT NULL,
            ciudad VARCHAR(120) DEFAULT NULL,
            estado ENUM('ACTIVO','INACTIVO') NOT NULL DEFAULT 'ACTIVO',
            fecha_seguimiento DATE DEFAULT NULL,
            valor_potencial DECIMAL(15,2) DEFAULT 0,
            ultimo_contacto DATE DEFAULT NULL,
            responsable VARCHAR(180) NOT NULL,
            observaciones TEXT,
            responsable_id INT NOT NULL,
            perfil_id INT NOT NULL,
            creado_en DATETIME NOT NULL,
            actualizado_en DATETIME DEFAULT NULL,
            actualizado_por_id INT DEFAULT NULL,
            actualizado_por VARCHAR(180) DEFAULT NULL,
            INDEX idx_perfil_id (perfil_id),
            INDEX idx_responsable_id (responsable_id),
            INDEX idx_estado (estado),
            INDEX idx_fecha_ingreso (fecha_ingreso)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

        $ok = $this->con->exec($sql) !== false;

        if ($ok) {
            $this->asegurarColumnasActualizacion();
        }

        return $ok;
    }

    private function asegurarColumnasActualizacion()
    {
        $columnas = [];
        $sql = $this->con->query("SHOW COLUMNS FROM crm_comercial");
        while ($fila = $sql->fetch(PDO::FETCH_ASSOC)) {
            $columnas[] = $fila['Field'];
        }

        if (!in_array('actualizado_por_id', $columnas, true)) {
            $this->con->exec("ALTER TABLE crm_comercial ADD COLUMN actualizado_por_id INT DEFAULT NULL AFTER actualizado_en");
        }

        if (!in_array('actualizado_por', $columnas, true)) {
            $this->con->exec("ALTER TABLE crm_comercial ADD COLUMN actualizado_por VARCHAR(180) DEFAULT NULL AFTER actualizado_por_id");
        }
    }

    public function listar()
    {
        $listar = [];
        $sql = $this->con->prepare("SELECT * FROM crm_comercial ORDER BY id DESC");
        $sql->execute();

        while ($fila = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $fila;
        }

        return $listar;
    }

    public function guardar($data)
    {
        if (!empty($data['id'])) {
            $sql = $this->con->prepare("UPDATE crm_comercial SET
                nombre = ?,
                empresa = ?,
                estado_venta = ?,
                estado = ?,
                tipo_cliente = ?,
                status_porcentaje = ?,
                telefono = ?,
                correo = ?,
                ciudad = ?,
                fecha_seguimiento = ?,
                valor_potencial = ?,
                ultimo_contacto = ?,
                responsable = ?,
                observaciones = ?,
                actualizado_en = ?,
                actualizado_por_id = ?,
                actualizado_por = ?
                WHERE id = ?");

            $ok = $sql->execute([
                $data['nombre'],
                $data['empresa'],
                $data['estado_venta'],
                $data['estado'],
                $data['tipo_cliente'],
                $data['status_porcentaje'],
                $data['telefono'],
                $data['correo'],
                $data['ciudad'],
                $data['fecha_seguimiento'],
                $data['valor_potencial'],
                $data['ultimo_contacto'],
                $data['responsable'],
                $data['observaciones'],
                date('Y-m-d H:i:s'),
                $data['actualizado_por_id'],
                $data['actualizado_por'],
                $data['id']
            ]);

            return $ok ? $data['id'] : 0;
        }

        $sql = $this->con->prepare("INSERT INTO crm_comercial
            (fecha_ingreso, nombre, empresa, estado_venta, tipo_cliente, status_porcentaje, telefono, correo, ciudad, estado, fecha_seguimiento, valor_potencial, ultimo_contacto, responsable, observaciones, responsable_id, perfil_id, creado_en)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $ok = $sql->execute([
            date('Y-m-d'),
            $data['nombre'],
            $data['empresa'],
            $data['estado_venta'],
            $data['tipo_cliente'],
            $data['status_porcentaje'],
            $data['telefono'],
            $data['correo'],
            $data['ciudad'],
            $data['estado'],
            $data['fecha_seguimiento'],
            $data['valor_potencial'],
            $data['ultimo_contacto'],
            $data['responsable'],
            $data['observaciones'],
            $data['responsable_id'],
            $data['perfil_id'],
            date('Y-m-d H:i:s')
        ]);

        return $ok ? $this->con->lastInsertId() : 0;
    }

    public function cambiarEstado($id, $actualizadoPorId, $actualizadoPor)
    {
        $sql = $this->con->prepare("UPDATE crm_comercial
            SET estado = CASE WHEN estado='ACTIVO' THEN 'INACTIVO' ELSE 'ACTIVO' END,
                actualizado_en = ?,
                actualizado_por_id = ?,
                actualizado_por = ?
            WHERE id = ?");

        return $sql->execute([date('Y-m-d H:i:s'), $actualizadoPorId, $actualizadoPor, $id]);
    }

}
