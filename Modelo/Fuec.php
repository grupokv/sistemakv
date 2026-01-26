<?php 

require_once("Conexion/conexionBD.php");

class Fuec{

        public function actualizarFechas($fecha_inicial_fuec, $fecha_final_fuec, $id_fuec){
            $con = Conexion::conectar();
            $sql = $con->prepare("UPDATE fuec SET fecha_inicial_fuec = :fecha_inicial_fuec ,fecha_final_fuec = :fecha_final_fuec WHERE id_fuec = :id_fuec");
            $sql->bindParam(":fecha_inicial_fuec", $fecha_inicial_fuec);
            $sql->bindParam(":fecha_final_fuec", $fecha_final_fuec);
            $sql->bindParam(":id_fuec", $id_fuec);
            $sql->execute();

            echo "UPDATE fuec SET fecha_inicial_fuec = '$fecha_inicial_fuec' ,fecha_final_fuec = '$fecha_final_fuec' WHERE id_fuec = '$id_fuec'";
        }
    	
        public function listar(){
    		$fuec = array();
                    $con = Conexion::conectar();
                    $sql = $con->prepare("SELECT * FROM fuec WHERE id_contrato != 0");
                    $sql->execute();
            
                    while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                    	$fuec[] = $filas;
                    }

                    return $fuec;
    	}
    	
        public function listarExtractosVencidos($fecha_proxima_venc, $id_usuario, $id_contrato, $id_vehiculo){
    		$fuecVencidos = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM fuec WHERE fecha_final_fuec <= :fecha_proxima_venc AND id_usuario LIKE :id_usuario AND id_contrato LIKE :id_contrato AND id_vehiculo LIKE :id_vehiculo");
            $sql->bindParam(':fecha_proxima_venc', $fecha_proxima_venc);
            $sql->bindParam(':id_usuario', $id_usuario);
            $sql->bindParam(':id_contrato', $id_contrato);
            $sql->bindParam(':id_vehiculo', $id_vehiculo);
            $sql->execute();

            //echo "SELECT * FROM fuec WHERE fecha_final_fuec <= '$fecha_proxima_venc' AND id_usuario LIKE '$id_usuario' AND id_contrato LIKE '$id_contrato' AND id_vehiculo LIKE '$id_vehiculo'";
    
            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            	$fuecVencidos[] = $filas;
            }

            return $fuecVencidos;
    	}

        public function listarMes($fecha){
                $fuec = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM fuec WHERE id_contrato != 0 and date(fecha_creacion) > :fecha and estado != 'P' AND estado != 'R' AND estado != 'E' ORDER BY id_fuec DESC ");
                $sql->bindParam(":fecha", $fecha);
                $sql->execute();
        
                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                        $fuec[] = $filas;
                }

                return $fuec;
        }

        public function listarFuecPorId($id_fuec){
                $fuecs = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM fuec WHERE id_fuec = ? ");
                $sql->bindParam(1, $id_fuec);
                $sql->execute();
        
                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                        $fuecs[] = $filas;
                }

                return $fuecs;
        }

        public function listarFuecPorIdContratoOcasional($id_contrato_ocasional){
                $fuecsco = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM fuec WHERE id_contrato_ocasional = ? ");
                $sql->bindParam(1, $id_contrato_ocasional);
                $sql->execute();
        
                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                        $fuecsco[] = $filas;
                }

                return $fuecsco;
        }

        public function listarFuecPorCod($cod_fuec){
                $fuec = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM fuec WHERE num_interno = ? ");
                $sql->bindParam(1, $cod_fuec);
                $sql->execute();
        
                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                        $fuec[] = $filas;
                }

                return $fuec;
        }

        public function listarFuecPorCodComprobante($cod_fuec){
                $fuec = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM fuec WHERE num_comprobante = ? ");
                $sql->bindParam(1, $cod_fuec);
                $sql->execute();
        
                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                        $fuec[] = $filas;
                }

                return $fuec;
        }

        public function listarFuecPorCliente($id_contrato,$year){
                $fuec = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT count(*) as cantidad FROM fuec WHERE id_contrato = :id_contrato and YEAR(fecha_creacion) = :year ");
                $sql->bindParam(":id_contrato", $id_contrato);
                $sql->bindParam(":year", $year);
                $sql->execute();
        
                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                        $fuec[] = $filas;
                }

                return $fuec;
        }

        public function listarFuecPorClienteContratoOcasional($id_contrato_ocasional,$year){
                $fuec = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT count(*) as cantidad FROM fuec WHERE id_contrato_ocasional = :id_contrato_ocasional and YEAR(fecha_creacion) = :year ");
                $sql->bindParam(":id_contrato_ocasional", $id_contrato_ocasional);
                $sql->bindParam(":year", $year);
                $sql->execute();
        
                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                        $fuec[] = $filas;
                }

                return $fuec;
        }

        public function listarTotalFuecEmitidos($year){
                $fuecTotal = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT count(*) as cantidad FROM fuec WHERE num_unico_emision != 0 and YEAR(fecha_creacion) = :year ");
                $sql->bindParam(":year", $year);
                $sql->execute();
        
                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                        $fuecTotal[] = $filas;
                }

                return $fuecTotal;
        }

        public function listarFuecPorContrato($id_contrato){
                $fuec = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM fuec WHERE id_contrato = ? order by id_fuec Desc limit 1");
                $sql->bindParam(1, $id_contrato);
                $sql->execute();
        
                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                        $fuec[] = $filas;
                }

                return $fuec;
        }

        public function listarFuecPorContratoVehiculo($id_contrato,$id_vehiculo){
                $fuec = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM fuec WHERE id_contrato = ? and id_vehiculo = ? order by id_fuec Desc limit 1");
                $sql->bindParam(1, $id_contrato);
                $sql->bindParam(2, $id_vehiculo);
                $sql->execute();
        
                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                        $fuec[] = $filas;
                }
                //echo "SELECT * FROM fuec WHERE id_contrato = $id_contrato and id_vehiculo = $id_vehiculo order by id_fuec Desc limit 1";
                return $fuec;
        }

        public function listarFuecPorContratoOcasionalVehiculo($id_contrato,$id_vehiculo){
                $fuec = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM fuec WHERE id_contrato_ocasional = ? and id_vehiculo = ? order by id_fuec Desc limit 1");
                $sql->bindParam(1, $id_contrato);
                $sql->bindParam(2, $id_vehiculo);
                $sql->execute();
        
                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                        $fuec[] = $filas;
                }

                return $fuec;
        }

        public function Aprobacion($id_empresa){
                $aprobacion = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM aprobacion_fuec WHERE id_empresa = ? and estado = 1");
                $sql->bindParam(1, $id_empresa);
                $sql->execute();
        
                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                        $aprobacion[] = $filas;
                }

                return $aprobacion;
        }


        
        public function registrarFuec($num_interno, $num_comprobante, $num_unico_emision, $origen, $destino, $tipo_fuec, $con_fuec, $fecha_inicial_fuec, $fecha_final_fuec, $id_vehiculo, $id_contrato, $id_contrato_ocasional, $responsable, $idResponsable, $dirResponsable, $telResponsable, $id_usuario, $fecha, $anexo, $estado){
                
                $con = Conexion::conectar();
                $sql = $con->prepare("INSERT INTO fuec(num_interno, num_comprobante, num_unico_emision, origen,destino, tipo_fuec, con_fuec, fecha_inicial_fuec, fecha_final_fuec, id_vehiculo, id_contrato, id_contrato_ocasional, responsable, idResponsable, dirResponsable, telResponsable, id_usuario, fecha_creacion, anexo, estado) VALUES(:num_interno, :num_comprobante, :num_unico_emision, :origen, :destino, :tipo_fuec, :con_fuec, :fecha_inicial_fuec,:fecha_final_fuec,:id_vehiculo,:id_contrato,:id_contrato_ocasional,:responsable,:idResponsable,:dirResponsable,:telResponsable,:id_usuario,:fecha_creacion, :anexo, :estado)");

                $sql->bindParam(":num_interno", $num_interno);
                $sql->bindParam(":num_comprobante", $num_comprobante);
                $sql->bindParam(":num_unico_emision", $num_unico_emision);
                $sql->bindParam(":origen", $origen);
                $sql->bindParam(":destino", $destino);
                $sql->bindParam(":tipo_fuec", $tipo_fuec);
                $sql->bindParam(":con_fuec", $con_fuec);
                $sql->bindParam(":fecha_inicial_fuec", $fecha_inicial_fuec);
                $sql->bindParam(":fecha_final_fuec", $fecha_final_fuec);
                $sql->bindParam(":id_vehiculo", $id_vehiculo);
                $sql->bindParam(":id_contrato", $id_contrato);
                $sql->bindParam(":id_contrato_ocasional", $id_contrato_ocasional);
                $sql->bindParam(":responsable", $responsable);
                $sql->bindParam(":idResponsable", $idResponsable);
                $sql->bindParam(":dirResponsable", $dirResponsable);
                $sql->bindParam(":telResponsable", $telResponsable);
                $sql->bindParam(":id_usuario", $id_usuario);
                $sql->bindParam(":fecha_creacion", $fecha);
                $sql->bindParam(":anexo", $anexo);
                $sql->bindParam(":estado", $estado);

                $sql->execute();

                
                //echo "INSERT INTO fuec(num_interno,num_comprobante,origen,destino,tipo_fuec,con_fuec,fecha_inicial_fuec,fecha_final_fuec,id_vehiculo,id_contrato,id_contrato_ocasional,responsable,idResponsable,dirResponsable,telResponsable,id_usuario,fecha_creacion, anexo) VALUES('$num_interno','$num_comprobante','$origen','$destino','$tipo_fuec','$con_fuec','$fecha_inicial_fuec','$fecha_final_fuec','$id_vehiculo','$id_contrato','$id_contrato_ocasional','$responsable','$idResponsable','$dirResponsable','$telResponsable','$id_usuario','$fecha', '$anexo')";
            
                if ($sql) {
                    $id = $con->lastInsertId();
                } else {
                    $id = '';
                }
                return $id;

        }
        
        public function registrarFuecPropietarios($num_interno, $num_comprobante, $num_unico_emision, $origen, $destino, $tipo_fuec, $con_fuec, $fecha_inicial_fuec, $fecha_final_fuec, $id_vehiculo, $id_contrato, $id_contrato_ocasional, $responsable, $idResponsable, $dirResponsable, $telResponsable, $id_usuario, $fecha, $anexo, $estado){
                
                $con = Conexion::conectar();
                $sql = $con->prepare("INSERT INTO fuec(num_interno, num_comprobante, num_unico_emision, origen,destino, tipo_fuec, con_fuec, fecha_inicial_fuec, fecha_final_fuec, id_vehiculo, id_contrato, id_contrato_ocasional, responsable, idResponsable, dirResponsable, telResponsable, id_usuario, fecha_creacion, anexo, estado) VALUES(:num_interno, :num_comprobante, :num_unico_emision, :origen, :destino, :tipo_fuec, :con_fuec, :fecha_inicial_fuec,:fecha_final_fuec,:id_vehiculo,:id_contrato,:id_contrato_ocasional,:responsable,:idResponsable,:dirResponsable,:telResponsable,:id_usuario,:fecha_creacion, :anexo, :estado)");

                $sql->bindParam(":num_interno", $num_interno);
                $sql->bindParam(":num_comprobante", $num_comprobante);
                $sql->bindParam(":num_unico_emision", $num_unico_emision);
                $sql->bindParam(":origen", $origen);
                $sql->bindParam(":destino", $destino);
                $sql->bindParam(":tipo_fuec", $tipo_fuec);
                $sql->bindParam(":con_fuec", $con_fuec);
                $sql->bindParam(":fecha_inicial_fuec", $fecha_inicial_fuec);
                $sql->bindParam(":fecha_final_fuec", $fecha_final_fuec);
                $sql->bindParam(":id_vehiculo", $id_vehiculo);
                $sql->bindParam(":id_contrato", $id_contrato);
                $sql->bindParam(":id_contrato_ocasional", $id_contrato_ocasional);
                $sql->bindParam(":responsable", $responsable);
                $sql->bindParam(":idResponsable", $idResponsable);
                $sql->bindParam(":dirResponsable", $dirResponsable);
                $sql->bindParam(":telResponsable", $telResponsable);
                $sql->bindParam(":id_usuario", $id_usuario);
                $sql->bindParam(":fecha_creacion", $fecha);
                $sql->bindParam(":anexo", $anexo);
                $sql->bindParam(":estado", $estado);

                $sql->execute();

                
                //echo "INSERT INTO fuec(num_interno, num_comprobante, num_unico_emision, origen,destino, tipo_fuec, con_fuec, fecha_inicial_fuec, fecha_final_fuec, id_vehiculo, id_contrato, id_contrato_ocasional, responsable, idResponsable, dirResponsable, telResponsable, id_usuario, fecha_creacion, anexo, estado) VALUES('$num_interno', '$num_comprobante', '$num_unico_emision', '$origen', '$destino', '$tipo_fuec', '$con_fuec', '$fecha_inicial_fuec','$fecha_final_fuec','$id_vehiculo','$id_contrato','$id_contrato_ocasional','$responsable','$idResponsable','$dirResponsable','$telResponsable','$id_usuario','$fecha', '$anexo', '$estado')";
            
                if ($sql) {
                    $id = $con->lastInsertId();
                } else {
                    $id = '';
                }
                return $id;

        }


        public function RegistrarPreliminar($origen,$destino,$tipo_fuec,$con_fuec,$id_vehiculo,$id_contrato,$responsable,$idResponsable,$dirResponsable,$telResponsable,$id_usuario,$fecha_creacion){
                $con = Conexion::conectar();

                $sql = $con->prepare("INSERT INTO fuec_preliminar(origen,destino,tipo_fuec,con_fuec,id_vehiculo,id_contrato,responsable,idResponsable,dirResponsable,telResponsable,id_usuario,fecha_creacion) VALUES (:origen,:destino,:tipo_fuec,:con_fuec,:id_vehiculo,:id_contrato,:responsable,:idResponsable,:dirResponsable,:telResponsable,:id_usuario,:fecha_creacion)");

                $sql->bindParam(":origen", $origen);
                $sql->bindParam(":destino", $destino);
                $sql->bindParam(":tipo_fuec", $tipo_fuec);
                $sql->bindParam(":con_fuec", $con_fuec);
                $sql->bindParam(":id_vehiculo", $id_vehiculo);
                $sql->bindParam(":id_contrato", $id_contrato);
                $sql->bindParam(":responsable", $responsable);
                $sql->bindParam(":idResponsable", $idResponsable);
                $sql->bindParam(":dirResponsable", $dirResponsable);
                $sql->bindParam(":telResponsable", $telResponsable);
                $sql->bindParam(":id_usuario", $id_usuario);
                $sql->bindParam(":fecha_creacion", $fecha_creacion);

                $sql->execute();

                //echo "INSERT INTO fuec_preliminar(origen,destino,tipo_fuec,con_fuec,id_vehiculo,id_contrato,responsable,idResponsable,dirResponsable,telResponsable,id_usuario,fecha_creacion) VALUES ('$origen','$destino','$tipo_fuec','$con_fuec','$id_vehiculo','$id_contrato','$responsable','$idResponsable','$dirResponsable','$telResponsable','$id_usuario','$fecha_creacion')";

                if ($sql) {
                    $id = $con->lastInsertId();
                } else {
                    $id = '';
                }
                return $id;
        }

        public function listarFuecPorIdPreliminar($id_fuec){
                $fuecs = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM fuec_preliminar WHERE id_fuec = ? ");
                $sql->bindParam(1, $id_fuec);
                $sql->execute();
        
                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                        $fuecs[] = $filas;
                }

                return $fuecs;
        }

        public function aprobacionPorEmpresa($id_empresa){
                $fuec = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM aprobacion_fuec WHERE id_empresa = ? and estado = 1");
                $sql->bindParam(1, $id_empresa);
                $sql->execute();
        
                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                        $fuec[] = $filas;
                }

                return $fuec;
        }

        public function listarEmisoresFuec(){
            $emisores = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM roles AS r INNER JOIN usuarios AS u  ON u.id_usuario = r.id_usuario WHERE r.id_modulo = 23 AND u.estado = 1 ORDER BY u.nombre ASC");

            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                $emisores[] = $filas;
            }

            return $emisores;
        }

        public function filtrarFuecs($id_usuario, $id_vehiculo, $fecha_creacion_inicial, $fecha_creacion_final){
            
                $filtro = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM fuec WHERE id_usuario LIKE :id_usuario AND id_vehiculo LIKE :id_vehiculo AND DATE(fecha_creacion) >= :fecha_creacion_inicial AND DATE(fecha_creacion) <= :fecha_creacion_final AND id_contrato_ocasional = 0 ORDER BY id_fuec DESC");

                $sql->bindParam(":id_usuario", $id_usuario);
                $sql->bindParam(":id_vehiculo", $id_vehiculo);
                $sql->bindParam(":fecha_creacion_inicial", $fecha_creacion_inicial);
                $sql->bindParam(":fecha_creacion_final", $fecha_creacion_final);

                $sql->execute();

                //echo "SELECT * FROM fuec WHERE id_usuario LIKE '$id_usuario' AND id_vehiculo LIKE '$id_vehiculo' AND DATE(fecha_creacion) >= '$fecha_creacion_inicial' AND DATE(fecha_creacion) <= '$fecha_creacion_final' AND id_contrato_ocasional = 0 ORDER BY id_fuec DESC";

                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $filtro[] = $filas;
                }
                return $filtro;
        }

        public function filtrarFuecsOcasionales($id_usuario, $id_contrato_ocasional, $id_vehiculo, $fecha_creacion_inicial, $fecha_creacion_final){
            
                $filtroOcasional = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM fuec WHERE id_usuario LIKE :id_usuario AND id_contrato_ocasional LIKE :id_contrato_ocasional AND id_vehiculo LIKE :id_vehiculo AND DATE(fecha_creacion) >= :fecha_creacion_inicial AND DATE(fecha_creacion) <= :fecha_creacion_final AND id_contrato = 0 ");

                $sql->bindParam(":id_usuario", $id_usuario);
                $sql->bindParam(":id_contrato_ocasional", $id_contrato_ocasional);
                $sql->bindParam(":id_vehiculo", $id_vehiculo);
                $sql->bindParam(":fecha_creacion_inicial", $fecha_creacion_inicial);
                $sql->bindParam(":fecha_creacion_final", $fecha_creacion_final);

                $sql->execute();

                //echo "SELECT * FROM fuec WHERE id_usuario LIKE '$id_usuario' AND id_contrato LIKE '$id_contrato' AND id_vehiculo LIKE '$id_vehiculo' AND DATE(fecha_creacion) >= '$fecha_creacion_inicial' AND DATE(fecha_creacion) <= '$fecha_creacion_final' ";

                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $filtroOcasional[] = $filas;
                }

                return $filtroOcasional;

        }

        public function listarFuecPorIdEmisor($id_usuario){
                $fuecEmisor = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM fuec WHERE id_usuario LIKE :id_usuario  AND estado = 'F' ");

                $sql->bindParam(":id_usuario", $id_usuario);

                $sql->execute();

                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $fuecEmisor[] = $filas;
                }

                return $fuecEmisor;

        }
}


?>