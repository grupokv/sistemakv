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
            INDEX idx_perfil_id (perfil_id),
            INDEX idx_responsable_id (responsable_id),
            INDEX idx_estado (estado),
            INDEX idx_fecha_ingreso (fecha_ingreso)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

        return $this->con->exec($sql) !== false;
    }

    public function listar($perfil_id, $base_principal = false)
    {
        $listar = [];
        if ($base_principal) {
            $sql = $this->con->prepare("SELECT * FROM crm_comercial ORDER BY id DESC");
        } else {
            $sql = $this->con->prepare("SELECT * FROM crm_comercial WHERE perfil_id = ? ORDER BY id DESC");
            $sql->bindParam(1, $perfil_id);
        }
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
                actualizado_en = ?
                WHERE id = ?");

            $ok = $sql->execute([
                $data['nombre'],
                $data['empresa'],
                $data['estado_venta'],
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
                $data['id']
            ]);

            return $ok ? $data['id'] : 0;
        }

        $sql = $this->con->prepare("INSERT INTO crm_comercial
            (fecha_ingreso, nombre, empresa, estado_venta, tipo_cliente, status_porcentaje, telefono, correo, ciudad, estado, fecha_seguimiento, valor_potencial, ultimo_contacto, responsable, observaciones, responsable_id, perfil_id, creado_en)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'ACTIVO', ?, ?, ?, ?, ?, ?, ?, ?)");

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

    public function cambiarEstado($id, $perfil_id)
    {
        $sql = $this->con->prepare("UPDATE crm_comercial
            SET estado = CASE WHEN estado='ACTIVO' THEN 'INACTIVO' ELSE 'ACTIVO' END,
                actualizado_en = ?
            WHERE id = ? AND perfil_id = ?");

        return $sql->execute([date('Y-m-d H:i:s'), $id, $perfil_id]);
    }

    public function reporte($filtros)
    {
        $where = [];
        $params = [];

        if (!empty($filtros['responsable'])) {
            $where[] = "responsable LIKE ?";
            $params[] = '%' . $filtros['responsable'] . '%';
        }

        if (!empty($filtros['estado_venta'])) {
            $where[] = "estado_venta = ?";
            $params[] = $filtros['estado_venta'];
        }

        if (!empty($filtros['semaforo'])) {
            if ($filtros['semaforo'] == 'rojo') {
                $where[] = "status_porcentaje < 50";
            } elseif ($filtros['semaforo'] == 'naranja') {
                $where[] = "status_porcentaje BETWEEN 50 AND 79";
            } elseif ($filtros['semaforo'] == 'verde') {
                $where[] = "status_porcentaje >= 80";
            }
        }

        if (!empty($filtros['fecha_inicio'])) {
            $where[] = "fecha_ingreso >= ?";
            $params[] = $filtros['fecha_inicio'];
        }

        if (!empty($filtros['fecha_fin'])) {
            $where[] = "fecha_ingreso <= ?";
            $params[] = $filtros['fecha_fin'];
        }

        $sqlTxt = "SELECT * FROM crm_comercial";
        if (count($where) > 0) {
            $sqlTxt .= " WHERE " . implode(' AND ', $where);
        }
        $sqlTxt .= " ORDER BY id DESC";

        $sql = $this->con->prepare($sqlTxt);
        $sql->execute($params);

        $listar = [];
        while ($fila = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $fila;
        }

        return $listar;
    }
}