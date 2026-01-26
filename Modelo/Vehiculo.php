<?php 

require_once("Conexion/conexionBD.php");

class Vehiculo{

        public function listarBaseVehiculos(){
            $baseVehiculos = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM vehiculos WHERE placa = 'ASD132' ORDER BY id_vehiculo DESC");
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                $baseVehiculos[] = $filas;
            }
            
            return $baseVehiculos;
        }

        function listarTipoMovilID($id_tipo){
            $tipoMovilID = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM tipo_movil WHERE id_tipo = :id_tipo");
            $sql->bindParam(":id_tipo", $id_tipo);
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                $tipoMovilID[] = $filas;
            }
            
            return $tipoMovilID;
        }

        function listarTipoMoviles(){
          $tipoMovil = array();
          $con = Conexion::conectar();
          $sql = $con->prepare("SELECT * FROM tipo_movil ORDER BY tipo_movil ASC");
          $sql->execute();

          while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
              $tipoMovil[] = $filas;
          }
          
          return $tipoMovil;
        }

        public function listar(){

            $vehiculos = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM vehiculos AS v INNER JOIN tipos_vehiculos AS tv ON v.id_tipo_vehiculo = tv.id_tipo_vehiculo INNER JOIN tipos_servicios AS ts ON v.id_tipo_servicio = ts.id_tipo_servicio ORDER BY v.id_vehiculo DESC");
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                $vehiculos[] = $filas;
            }
            
            return $vehiculos;
        }

        public function listarBaseVehiculosInforme(){

          $baseVehiculosInforme = array();
          $con = Conexion::conectar();
          $sql = $con->prepare("SELECT * FROM vehiculos AS v INNER JOIN tipos_vehiculos AS tv ON v.id_tipo_vehiculo = tv.id_tipo_vehiculo INNER JOIN tipos_servicios AS ts ON v.id_tipo_servicio = ts.id_tipo_servicio WHERE (estado = 1 OR estado = 0)  AND tipo_afiliacion = 'AFILIADO' AND (numero_movil >= 1 AND numero_movil <= 1999) ORDER BY v.numero_movil ASC");
          $sql->execute();

          while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
              $baseVehiculosInforme[] = $filas;
          }
          
          return $baseVehiculosInforme;
      }

        public function listarPorTipoAfiliacion($tipo_afiliacion){
            $vehiculos = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM vehiculos AS v INNER JOIN tipos_vehiculos AS tv ON v.id_tipo_vehiculo = tv.id_tipo_vehiculo INNER JOIN tipos_servicios AS ts ON v.id_tipo_servicio = ts.id_tipo_servicio WHERE tipo_afiliacion = :tipo_afiliacion ORDER BY v.id_vehiculo DESC");
            $sql->bindParam(":tipo_afiliacion", $tipo_afiliacion);
            $sql->execute();
            //echo "SELECT * FROM vehiculos AS v INNER JOIN tipos_vehiculos AS tv ON v.id_tipo_vehiculo = tv.id_tipo_vehiculo INNER JOIN tipos_servicios AS ts ON v.id_tipo_servicio = ts.id_tipo_servicio WHERE tipo_afiliacion LIKE '$tipo_afiliacion' ORDER BY v.id_vehiculo DESC";
            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                $vehiculos[] = $filas;
            }
            
            return $vehiculos;
        }

        public function listarBaseOrt(){
            $vehiculosOrt = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM vehiculos WHERE numero_movil > '0' AND numero_movil <= '999' ORDER BY placa ASC");
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                $vehiculosOrt[] = $filas;
            }

            return $vehiculosOrt;
        }

	     public function listarDirecto(){
            $vehiculos = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM vehiculos ORDER BY placa ASC");
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                $vehiculos[] = $filas;
            }

            return $vehiculos;
        }


        public function listarPorId($id_vehiculo){

          $vehiculosId = array();
          $con = Conexion::conectar();
          $sql = $con->prepare("SELECT * FROM vehiculos WHERE id_vehiculo = ?");
          $sql->bindParam(1, $id_vehiculo);
          $sql->execute();

          while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $vehiculosId[] = $filas;
          }

          return $vehiculosId;

        }

        public function listarVehiculosPorPropietario($id_propietario){
          $vehiculosPropietario = array();
          $sql = $con->prepare("SELECT * FROM vehiculo WHERE id_propietario = :id_propietario");
          $sql->bindParam(":id_propietario", $id_propietario);
          $sql->execute();

          while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $vehiculosPropietario[] = $filas;
          }

          return $vehiculosPropietario;
          
        }

	public function listarRecorridoId($id){

              $vehiculosId = array();

              $con = Conexion::conectar();

              $sql = $con->prepare("SELECT * FROM detalle_recorrido_fijo WHERE id_recorrido = ?");

              $sql->bindParam(1, $id);



              $sql->execute();

              

              while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                

                 $vehiculosId[] = $filas;

              }



          return $vehiculosId;

        }

	
	public function buscarPasajeroFijoPorId($id){

              $vehiculosId = array();

              $con = Conexion::conectar();

              $sql = $con->prepare("SELECT * FROM pasajero_ruta_fija WHERE id_pasajero = ?");

              $sql->bindParam(1, $id);

              $sql->execute();

              while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                 $vehiculosId[] = $filas;

              }

          return $vehiculosId;

        }

	public function listarRutasPorCliente($id_cliente){

              $vehiculosId = array();

              $con = Conexion::conectar();

              $sql = $con->prepare("SELECT * FROM vehiculo_ruta WHERE id_cliente = ?");

              $sql->bindParam(1, $id_cliente);

              $sql->execute();

              while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                 $vehiculosId[] = $filas;

              }

		//echo "SELECT * FROM vehiculo_ruta WHERE id_cliente = '$id_cliente'";

          return $vehiculosId;

        }

	public function listarRutaPorId($id){

              $vehiculosId = array();

              $con = Conexion::conectar();

              $sql = $con->prepare("SELECT * FROM vehiculo_ruta WHERE id = ?");

              $sql->bindParam(1, $id);

              $sql->execute();

              while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                 $vehiculosId[] = $filas;

              }
              return $vehiculosId;

        }

	public function listarRutaPorIdVehiculo($id,$id_cliente){

              $vehiculosId = array();

              $con = Conexion::conectar();

              $sql = $con->prepare("SELECT * FROM vehiculo_ruta WHERE id_vehiculo = ? and id_cliente = ?");

              $sql->bindParam(1, $id);
	      $sql->bindParam(2, $id_cliente);
              $sql->execute();

              while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                 $vehiculosId[] = $filas;

              }
              return $vehiculosId;

        }


        public function listarActivos(){
            $vehiculosId = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM vehiculos WHERE estado = 1 order by placa Asc");
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
               $vehiculosId[] = $filas;
            }
            
            return $vehiculosId;
        }



        public function listarPorTipoVehiculo($id_tipo){

              $vehiculosId = array();

              $con = Conexion::conectar();

              $sql = $con->prepare("SELECT * FROM vehiculos WHERE id_tipo_vehiculo = ? order by placa Asc");

              $sql->bindParam(1, $id_tipo);

              $sql->execute();

              

              while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                

                 $vehiculosId[] = $filas;

              }



          return $vehiculosId;

        }

	public function buscarRuta($usuario,$cliente){

              $vehiculosId = array();
              $con = Conexion::conectar();
              $sql = $con->prepare("SELECT * FROM vehiculo_ruta WHERE id_monitor = ? and id_cliente = ?");
              $sql->bindParam(1, $usuario);
	      $sql->bindParam(2, $cliente);
              $sql->execute();              

              while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                 $vehiculosId[] = $filas;
              }
	      return $vehiculosId;

        }

	public function buscarActivos($ruta,$fecha){

              $vehiculosId = array();
              $con = Conexion::conectar();
              $sql = $con->prepare("SELECT * FROM recorrido_ruta_fija WHERE id_ruta = ? and fecha_inicio = ?");
              $sql->bindParam(1, $ruta);
	      $sql->bindParam(2, $fecha);
              $sql->execute();              

              while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                 $vehiculosId[] = $filas;
              }
	      return $vehiculosId;
		//echo "SELECT * FROM recorrido_ruta_fija WHERE id_ruta = '$ruta' and fecha_inicio = '$fecha'";
        }
	
	public function recorridosFechas($fechai,$fechaf){

              $vehiculosId = array();
              $con = Conexion::conectar();
              $sql = $con->prepare("SELECT * FROM recorrido_ruta_fija WHERE fecha_inicio >= ? and fecha_inicio <= ?");
              $sql->bindParam(1, $fechai);
	      $sql->bindParam(2, $fechaf);
              $sql->execute();              

              while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                 $vehiculosId[] = $filas;
              }
	      //echo "SELECT * FROM ruta_pasajero WHERE id_ruta = '$ruta'";
	      return $vehiculosId;

        }

	public function buscarRecorridoId($id){

              $vehiculosId = array();
              $con = Conexion::conectar();
              $sql = $con->prepare("SELECT * FROM detalle_recorrido_fijo WHERE id_recorrido = ?");
              $sql->bindParam(1, $id);
              $sql->execute();              

              while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                 $vehiculosId[] = $filas;
              }
	      return $vehiculosId;

        }

	public function buscarPasajerosRuta($ruta){

              $vehiculosId = array();
              $con = Conexion::conectar();
              $sql = $con->prepare("SELECT * FROM ruta_pasajero WHERE id_ruta = ?");
              $sql->bindParam(1, $ruta);
              $sql->execute();              

              while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                 $vehiculosId[] = $filas;
              }
	      //echo "SELECT * FROM ruta_pasajero WHERE id_ruta = '$ruta'";
	      return $vehiculosId;

        }


        public function listarVehiculoFlotaPropia(){

            $flotaPropia = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM vehiculos WHERE flota_propia = 'S' AND estado = 1 ORDER BY placa ASC");
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                $flotaPropia[] = $filas;
            }

            return $flotaPropia;
        }


        public function listarVehiculoPorFlotaPropiaYEmpresa($id_empresa){

            $flotaPropiaYEmpresa = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM vehiculos WHERE flota_propia = 'S' AND id_empresa = :id_empresa AND estado = 1 ORDER BY id_vehiculo ASC");
            $sql->bindParam(":id_empresa", $id_empresa);
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                $flotaPropiaYEmpresa[] = $filas;
            }

            return $flotaPropiaYEmpresa;
        }



        public function listarVehiculoTodos(){

            $flotaPropia = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM vehiculos WHERE numero_movil != 0");
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                $flotaPropia[] = $filas;
            }

            return $flotaPropia;
        }

	public function listarVehiculosVinculados(){

              $flotaPropia = array();

              $con = Conexion::conectar();

              $sql = $con->prepare("SELECT * FROM vehiculos WHERE numero_movil != 0 and estado = 1 ORDER BY id_vehiculo ASC");



              $sql->execute();

              

              while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                

                 $flotaPropia[] = $filas;

              }



          return $flotaPropia;

        }



        public function listarVehiculoActivos(){

              $flotaPropia = array();

              $con = Conexion::conectar();

              $sql = $con->prepare("SELECT * FROM vehiculos WHERE estado = '1'");



              $sql->execute();

              

              while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                

                 $flotaPropia[] = $filas;

              }



          return $flotaPropia;

        }





        public function listarVehiculoInactivos(){

              $inactivos = array();

              $con = Conexion::conectar();

              $sql = $con->prepare("SELECT * FROM vehiculos WHERE estado = '0'");



              $sql->execute();

              

              while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                

                 $inactivos[] = $filas;

              }



          return $inactivos;

        }



         public function registrarVehiculo($placa, $marca, $modelo, $cant_pasajeros, $id_tipo_servicio, $id_tipo_vehiculo, $tipo_afiliacion, $empresa_afiliada, $nit_empresa_afiliada, $numero_movil, $numero_motor, $numero_chasis, $id_propietario, $telefono_propietario, $fotocopia_cedula_propietario, $direccion_propietario, $ciudad_propietario, $tarjeta_operacion, $num_tarjeta_operacion, $fecha_vencimiento_to, $licencia_transito, $num_licencia_transito, $fecha_vencimiento_lt, $soat, $num_soat, $fecha_vencimiento_soat, $revision_tecnomecanica, $num_revision_tecnomecanica, $fecha_vencimiento_rt, $revision_preventiva, $fecha_vencimiento_rp, $poliza_contra, $num_poliza_contra, $fecha_vencimiento_contra, $poliza_extra, $num_poliza_extra, $fecha_vencimiento_extra, $disp_velocidad, $fecha_exp_disp_velocidad, $tipo_propietario, $propiedad, $camara_comercio, $contrato_banco, $contrato_vinculacion, $fecha_exp_contrato_vinculacion, $ficha_tecnica_homologacion, $seguro_todo_riesgo, $num_seguro_todo_riesgo, $fecha_vencimiento_seguro_todo_riesgo, $hoja_vida, $rut, $poder_apoderado, $flota_propia, $id_empresa, $fecha_registro, $ciudad_registro, $num_puertas, $cilindraje, $tipo_carroceria, $tipo_combustible){

            try {   

                $con = Conexion::conectar();
                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = $con->prepare("INSERT INTO vehiculos(placa, marca, modelo, cant_pasajeros, id_tipo_servicio, id_tipo_vehiculo, tipo_afiliacion, empresa_afiliada, nit_empresa_afiliada, numero_movil, numero_motor, numero_chasis, id_propietario, telefono_propietario, fotocopia_cedula_propietario, direccion_propietario, ciudad_propietario, tarjeta_operacion, num_tarjeta_operacion, fecha_vencimiento_to, licencia_transito, num_licencia_transito, fecha_vencimiento_lt, soat, num_soat, fecha_vencimiento_soat, revision_tecnomecanica, num_revision_tecnomecanica, fecha_vencimiento_rt, revision_preventiva, fecha_vencimiento_rp, poliza_contra, num_poliza_contra, fecha_vencimiento_contra, poliza_extra, num_poliza_extra, fecha_vencimiento_extra, disp_velocidad, fecha_exp_disp_velocidad, tipo_propietario, propiedad, camara_comercio, contrato_banco, contrato_vinculacion, fecha_exp_contrato_vinculacion, ficha_tecnica_homologacion, seguro_todo_riesgo, num_seguro_todo_riesgo, fecha_vencimiento_seguro_todo_riesgo, hoja_vida, rut, poder_apoderado, flota_propia, id_empresa, fecha_registro, ciudad_registro, num_puertas, cilindraje, tipo_carroceria, tipo_combustible, estado) VALUES (:placa, :marca, :modelo, :cant_pasajeros, :id_tipo_servicio, :id_tipo_vehiculo, :tipo_afiliacion, :empresa_afiliada, :nit_empresa_afiliada, :numero_movil, :numero_motor, :numero_chasis, :id_propietario, :telefono_propietario, :fotocopia_cedula_propietario, :direccion_propietario, :ciudad_propietario, :tarjeta_operacion, :num_tarjeta_operacion, :fecha_vencimiento_to, :licencia_transito, :num_licencia_transito, :fecha_vencimiento_lt, :soat, :num_soat, :fecha_vencimiento_soat, :revision_tecnomecanica, :num_revision_tecnomecanica, :fecha_vencimiento_rt, :revision_preventiva, :fecha_vencimiento_rp, :poliza_contra, :num_poliza_contra, :fecha_vencimiento_contra, :poliza_extra, :num_poliza_extra, :fecha_vencimiento_extra, :disp_velocidad, :fecha_exp_disp_velocidad, :tipo_propietario, :propiedad, :camara_comercio, :contrato_banco, :contrato_vinculacion, :fecha_exp_contrato_vinculacion, :ficha_tecnica_homologacion, :seguro_todo_riesgo, :num_seguro_todo_riesgo, :fecha_vencimiento_seguro_todo_riesgo, :hoja_vida, :rut, :poder_apoderado, :flota_propia, :id_empresa, :fecha_registro, :ciudad_registro, :num_puertas, :cilindraje, :tipo_carroceria, :tipo_combustible, 1)");

                $sql->bindParam(":placa", $placa);
                $sql->bindParam(":marca", $marca);
                $sql->bindParam(":modelo", $modelo);
                $sql->bindParam(":cant_pasajeros", $cant_pasajeros);
                $sql->bindParam(":id_tipo_servicio", $id_tipo_servicio);
                $sql->bindParam(":id_tipo_vehiculo", $id_tipo_vehiculo);
                $sql->bindParam(":tipo_afiliacion", $tipo_afiliacion);
                $sql->bindParam(":empresa_afiliada", $empresa_afiliada);
                $sql->bindParam(":nit_empresa_afiliada", $nit_empresa_afiliada);
                $sql->bindParam(":numero_movil", $numero_movil);
                $sql->bindParam(":numero_motor", $numero_motor);
                $sql->bindParam(":numero_chasis", $numero_chasis);
                $sql->bindParam(":id_propietario", $id_propietario);
                $sql->bindParam(":telefono_propietario", $telefono_propietario);
                $sql->bindParam(":fotocopia_cedula_propietario", $fotocopia_cedula_propietario);
                $sql->bindParam(":direccion_propietario", $direccion_propietario);
                $sql->bindParam(":ciudad_propietario", $ciudad_propietario);
                $sql->bindParam(":tarjeta_operacion", $tarjeta_operacion);
                $sql->bindParam(":num_tarjeta_operacion", $num_tarjeta_operacion);
                $sql->bindParam(":fecha_vencimiento_to", $fecha_vencimiento_to);
                $sql->bindParam(":licencia_transito", $licencia_transito);
                $sql->bindParam(":num_licencia_transito", $num_licencia_transito);
                $sql->bindParam(":fecha_vencimiento_lt", $fecha_vencimiento_lt);
                $sql->bindParam(":soat", $soat);
                $sql->bindParam(":num_soat", $num_soat);
                $sql->bindParam(":fecha_vencimiento_soat", $fecha_vencimiento_soat);
                $sql->bindParam(":revision_tecnomecanica", $revision_tecnomecanica);
                $sql->bindParam(":num_revision_tecnomecanica", $num_revision_tecnomecanica);
                $sql->bindParam(":fecha_vencimiento_rt", $fecha_vencimiento_rt);
                $sql->bindParam(":revision_preventiva", $revision_preventiva);
                $sql->bindParam(":fecha_vencimiento_rp", $fecha_vencimiento_rp);
                $sql->bindParam(":poliza_contra", $poliza_contra);
                $sql->bindParam(":num_poliza_contra", $num_poliza_contra);
                $sql->bindParam(":fecha_vencimiento_contra", $fecha_vencimiento_contra); 
                $sql->bindParam(":poliza_extra", $poliza_extra);
                $sql->bindParam(":num_poliza_extra", $num_poliza_extra);
                $sql->bindParam(":fecha_vencimiento_extra", $fecha_vencimiento_extra);
                $sql->bindParam(":disp_velocidad", $disp_velocidad);
                $sql->bindParam(":fecha_exp_disp_velocidad", $fecha_exp_disp_velocidad);
                $sql->bindParam(":tipo_propietario", $tipo_propietario);
                $sql->bindParam(":propiedad", $propiedad);
                $sql->bindParam(":camara_comercio", $camara_comercio);
                $sql->bindParam(":contrato_banco", $contrato_banco);
                $sql->bindParam(":contrato_vinculacion", $contrato_vinculacion);
                $sql->bindParam(":fecha_exp_contrato_vinculacion", $fecha_exp_contrato_vinculacion);
                $sql->bindParam(":ficha_tecnica_homologacion", $ficha_tecnica_homologacion);
                $sql->bindParam(":seguro_todo_riesgo", $seguro_todo_riesgo);
                $sql->bindParam(":num_seguro_todo_riesgo", $num_seguro_todo_riesgo);
                $sql->bindParam(":fecha_vencimiento_seguro_todo_riesgo", $fecha_vencimiento_seguro_todo_riesgo);
                $sql->bindParam(":hoja_vida", $hoja_vida);
                $sql->bindParam(":rut", $rut);
                $sql->bindParam(":poder_apoderado", $poder_apoderado);
                $sql->bindParam(":flota_propia", $flota_propia);
                $sql->bindParam(":id_empresa", $id_empresa);
        				$sql->bindParam(":fecha_registro", $fecha_registro);
        				$sql->bindParam(":ciudad_registro", $ciudad_registro);
        				$sql->bindParam(":num_puertas", $num_puertas);
        				$sql->bindParam(":cilindraje", $cilindraje);
        				$sql->bindParam(":tipo_carroceria", $tipo_carroceria);
        				$sql->bindParam(":tipo_combustible", $tipo_combustible);
                //$sql->debugDumpParams();
                $sql->execute();

echo "INSERT INTO vehiculos(placa, marca, modelo, cant_pasajeros, id_tipo_servicio, id_tipo_vehiculo, numero_movil, numero_motor, numero_chasis, id_propietario, telefono_propietario, fotocopia_cedula_propietario, fecha_nac_propietario, direccion_propietario, ciudad_propietario, tarjeta_operacion, num_tarjeta_operacion, fecha_vencimiento_to, licencia_transito, fecha_vencimiento_lt, soat, fecha_vencimiento_soat, revision_tecnomecanica, fecha_vencimiento_rt, revision_preventiva, fecha_vencimiento_rp, poliza_contra, fecha_vencimiento_contra, poliza_extra, fecha_vencimiento_extra, disp_velocidad, fecha_exp_disp_velocidad, tipo_propietario, propiedad, camara_comercio, contrato_banco, contrato_vinculacion, flota_propia, id_empresa, fecha_registro, ciudad_registro, num_puertas, cilindraje, tipo_carroceria, tipo_combustible, estado) VALUES ('$placa', '$marca', '$modelo', '$cant_pasajeros', '$id_tipo_servicio', '$id_tipo_vehiculo', '$numero_movil', '$numero_motor', '$numero_chasis', '$id_propietario', '$telefono_propietario', '$fotocopia_cedula_propietario', '$fecha_nac_propietario', '$direccion_propietario', '$ciudad_propietario', '$tarjeta_operacion', '$num_tarjeta_operacion', '$fecha_vencimiento_to', '$licencia_transito', '$fecha_vencimiento_lt', '$soat', '$fecha_vencimiento_soat', '$revision_tecnomecanica', '$fecha_vencimiento_rt', '$revision_preventiva', '$fecha_vencimiento_rp', '$poliza_contra', '$fecha_vencimiento_contra', '$poliza_extra', '$fecha_vencimiento_extra', '$disp_velocidad', '$fecha_exp_disp_velocidad', '$tipo_propietario', '$propiedad', '$camara_comercio', '$contrato_banco', '$contrato_vinculacion', '$flota_propia', '$id_empresa', '$fecha_registro', '$ciudad_registro', '$num_puertas', '$cilindraje', '$tipo_carroceria', '$tipo_combustible', 1)";

                 /* if ($sql) {

                    $id_vehiculo = $con->lastInsertId();
                    return $id_vehiculo;

                  } else {

                    echo 'error';

                  }*/



          } catch (PDOException $e) {
            echo "Error PDO: " . $e->getMessage();
        }

        }



        public function actualizarVehiculo($id_vehiculo, $placa, $marca, $modelo, $cant_pasajeros, $id_tipo_servicio, $id_tipo_vehiculo, $tipo_afiliacion, $empresa_afiliada, $nit_empresa_afiliada, $numero_movil, $numero_motor, $numero_chasis, $id_propietario, $telefono_propietario, $fotocopia_cedula_propietario, $direccion_propietario, $ciudad_propietario, $tarjeta_operacion, $num_tarjeta_operacion, $fecha_vencimiento_to, $licencia_transito, $num_licencia_transito, $fecha_vencimiento_lt, $soat, $num_soat, $fecha_vencimiento_soat, $revision_tecnomecanica, $num_revision_tecnomecanica, $fecha_vencimiento_rt, $revision_preventiva, $fecha_vencimiento_rp,  $poliza_contra, $num_poliza_contra, $fecha_vencimiento_contra, $poliza_extra, $num_poliza_extra, $fecha_vencimiento_extra, $disp_velocidad, $fecha_exp_disp_velocidad, $tipo_propietario, $propiedad, $camara_comercio, $contrato_banco, $contrato_vinculacion, $fecha_exp_contrato_vinculacion, $ficha_tecnica_homologacion, $seguro_todo_riesgo, $num_seguro_todo_riesgo, $fecha_vencimiento_seguro_todo_riesgo, $hoja_vida, $rut, $poder_apoderado, $flota_propia, $id_empresa, $fecha_registro, $ciudad_registro, $num_puertas, $cilindraje, $tipo_carroceria, $tipo_combustible, $estado){

            try {

            $con = Conexion::conectar();
            $sentencia = "UPDATE vehiculos SET placa = '$placa', marca = '$marca', modelo = '$modelo', cant_pasajeros = '$cant_pasajeros', id_tipo_servicio =  '$id_tipo_servicio',  id_tipo_vehiculo = '$id_tipo_vehiculo', tipo_afiliacion = '$tipo_afiliacion', empresa_afiliada = '$empresa_afiliada', nit_empresa_afiliada = '$nit_empresa_afiliada', numero_movil = '$numero_movil', numero_motor = '$numero_motor', numero_chasis = '$numero_chasis', id_propietario = '$id_propietario', telefono_propietario = '$telefono_propietario', fotocopia_cedula_propietario = '$fotocopia_cedula_propietario', direccion_propietario = '$direccion_propietario', ciudad_propietario = '$ciudad_propietario', tarjeta_operacion = '$tarjeta_operacion', num_tarjeta_operacion = '$num_tarjeta_operacion', fecha_vencimiento_to = '$fecha_vencimiento_to', licencia_transito = '$licencia_transito', num_licencia_transito = '$num_licencia_transito', fecha_vencimiento_lt = '$fecha_vencimiento_lt', soat = '$soat', num_soat = '$num_soat', fecha_vencimiento_soat = '$fecha_vencimiento_soat', revision_tecnomecanica = '$revision_tecnomecanica', num_revision_tecnomecanica = '$num_revision_tecnomecanica', fecha_vencimiento_rt = '$fecha_vencimiento_rt', revision_preventiva = '$revision_preventiva', fecha_vencimiento_rp = '$fecha_vencimiento_rp', poliza_contra = '$poliza_contra', num_poliza_contra = '$num_poliza_contra', fecha_vencimiento_contra = '$fecha_vencimiento_contra', poliza_extra = '$poliza_extra', num_poliza_extra = '$num_poliza_extra', fecha_vencimiento_extra = '$fecha_vencimiento_extra', disp_velocidad = '$disp_velocidad', fecha_exp_disp_velocidad = '$fecha_exp_disp_velocidad', tipo_propietario = '$tipo_propietario', propiedad = '$propiedad', camara_comercio = '$camara_comercio', contrato_banco = '$contrato_banco', contrato_vinculacion = '$contrato_vinculacion', fecha_exp_contrato_vinculacion = '$fecha_exp_contrato_vinculacion', ficha_tecnica_homologacion = '$ficha_tecnica_homologacion', seguro_todo_riesgo = '$seguro_todo_riesgo', num_seguro_todo_riesgo = '$num_seguro_todo_riesgo', fecha_vencimiento_seguro_todo_riesgo = '$fecha_vencimiento_seguro_todo_riesgo', hoja_vida = '$hoja_vida', rut = '$rut', poder_apoderado = '$poder_apoderado', flota_propia = '$flota_propia', id_empresa = '$id_empresa', fecha_registro = '$fecha_registro', ciudad_registro = '$ciudad_registro', num_puertas = '$num_puertas', cilindraje = '$cilindraje', tipo_carroceria = '$tipo_carroceria', tipo_combustible = '$tipo_combustible', estado = '$estado' WHERE id_vehiculo = '$id_vehiculo'";
    		    $sql = $con->prepare($sentencia);


              $sql->execute();
		  
          } catch (Exception $e) {
            echo $e->getMessage();
          }

    }   



        public function actualizarDocumentos($tarjeta_operacion, $fecha_vencimiento_to, $licencia_transito, $fecha_vencimiento_lt, $soat, $fecha_vencimiento_soat, $revision_tecnomecanica, $fecha_vencimiento_rt, $revision_preventiva, $fecha_vencimiento_rp,  $poliza_contra, $fecha_vencimiento_contra, $poliza_extra, $fecha_vencimiento_extra){

          try {

                  $con = Conexion::conectar();

                  $sql = $con->prepare("UPDATE vehiculos SET tarjeta_operacion = :tarjeta_operacion, fecha_vencimiento_to = :fecha_vencimiento_to, licencia_transito = :licencia_transito,  fecha_vencimiento_lt = :fecha_vencimiento_lt, soat = :soat, fecha_vencimiento_soat = :fecha_vencimiento_soat, revision_tecnomecanica = :revision_tecnomecanica, fecha_vencimiento_rt = :fecha_vencimiento_rt, revision_preventiva = :revision_preventiva, fecha_vencimiento_rp = :fecha_vencimiento_rp, poliza_contra = :poliza_contra, fecha_vencimiento_contra = :fecha_vencimiento_contra, poliza_extra = :poliza_extra, fecha_vencimiento_extra = :fecha_vencimiento_extra WHERE id_vehiculo = :id_vehiculo");

                    $sql->bindParam(":id_vehiculo", $id_vehiculo);

                    $sql->bindParam(":tarjeta_operacion", $tarjeta_operacion);

                    $sql->bindParam(":fecha_vencimiento_to", $fecha_vencimiento_to);

                    $sql->bindParam(":licencia_transito", $licencia_transito);

                    $sql->bindParam(":fecha_vencimiento_lt", $fecha_vencimiento_lt);

                    $sql->bindParam(":soat", $soat);

                    $sql->bindParam(":fecha_vencimiento_soat", $fecha_vencimiento_soat);

                    $sql->bindParam(":revision_tecnomecanica", $revision_tecnomecanica);

                    $sql->bindParam(":fecha_vencimiento_rt", $fecha_vencimiento_rt);

                    $sql->bindParam(":revision_preventiva", $revision_preventiva);

                    $sql->bindParam(":fecha_vencimiento_rp", $fecha_vencimiento_rp);

                    $sql->bindParam(":poliza_contra", $poliza_contra);

                    $sql->bindParam(":fecha_vencimiento_contra", $fecha_vencimiento_contra);

                    $sql->bindParam(":poliza_extra", $poliza_extra);

                    $sql->bindParam(":fecha_vencimiento_extra", $fecha_vencimiento_extra);

                   

                  $sql->execute();



                  if ($sql) {

                     header("Location: ../Vista/vehiculos.php");

                  }

              } catch (Exception $e) {

                  echo $e->getMessage();

              }

        }



        public function actualizarPorDocumento($id_vehiculo, $nombre_documento, $nuevo_documento, $fecha_vencimiento, $nueva_fecha_vencimiento){

           try {

              $con = Conexion::conectar();

              $sql = $con->prepare("UPDATE vehiculos SET $nombre_documento = :nuevo_documento, $fecha_vencimiento = :nueva_fecha_vencimiento WHERE id_vehiculo = :id_vehiculo");

              $sql->bindParam(":id_vehiculo", $id_vehiculo);

              $sql->bindParam(":nuevo_documento", $nuevo_documento);

              $sql->bindParam(":nueva_fecha_vencimiento", $nueva_fecha_vencimiento);

              $sql->execute();



           } catch (Exception $e) {

             echo $e->getMessage();

           }

        }

        public function cambiarEstadoVehiculo($id_vehiculo, $estado, $soporte_cambio_estado){
            try {
                $con = Conexion::conectar();
                $sql = $con->prepare("UPDATE vehiculos SET estado = :estado, soporte_cambio_estado = :soporte_cambio_estado WHERE id_vehiculo = :id_vehiculo ");
                $sql->bindParam(":id_vehiculo", $id_vehiculo);
                $sql->bindParam(":estado", $estado);
                $sql->bindParam(":soporte_cambio_estado", $soporte_cambio_estado);
                $sql->execute();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        public function bloquear($id_vehiculo){
              try {
                  $con = Conexion::conectar();
                  $sql = $con->prepare("UPDATE vehiculos SET estado = 0 WHERE id_vehiculo = ?");
                  $sql->bindParam(1, $id_vehiculo);
                  $sql->execute();

                  if ($sql) {
                    header("Location: ../Vista/vehiculos.php");
                  }
              } catch (Exception $e) {
                  echo $e->getMessage();
              }
        }

	public function CambiarEstadoPasajero($id_detalle,$hora){

              try {

                  $con = Conexion::conectar();

                  $sql = $con->prepare("UPDATE detalle_recorrido_fijo SET hora_recogida = ? WHERE id_detalle = ?");

                  $sql->bindParam(1, $hora);
		  $sql->bindParam(2, $id_detalle);

                  $sql->execute();
		//echo "UPDATE detalle_recorrido_fijo SET hora_recogida = '$hora' WHERE id_detalle = '$id_detalle'";
              } catch (Exception $e) {

                  echo $e->getMessage();

              }

        }



          public function desbloquear($id_vehiculo){

              try {

                  $con = Conexion::conectar();

                  $sql = $con->prepare("UPDATE vehiculos SET estado = 1 WHERE id_vehiculo = ?");

                  $sql->bindParam(1, $id_vehiculo);

                  $sql->execute();



                  if ($sql) {

                    header("Location: ../Vista/vehiculos.php");

                  }

              } catch (Exception $e) {

                  echo $e->getMessage();

              }

        }



        public function listarPorTipo($id_tipo){

              $vehiculosId = array();

              $con = Conexion::conectar();

              $sql = $con->prepare("SELECT * FROM vehiculos AS v INNER JOIN tipos_vehiculos AS tv ON

                              v.id_tipo_vehiculo = tv.id_tipo_vehiculo INNER JOIN tipos_servicios AS ts ON v.id_tipo_servicio = ts.id_tipo_servicio WHERE v.id_tipo_servicio = ?");

              $sql->bindParam(1, $id_tipo);



              $sql->execute();

              

              while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                

                 $vehiculosId[] = $filas;

              }



          return $vehiculosId;

        }



        public function pasajerosAsignados($id_vehiculo){

              $vehiculosId = array();

              $con = Conexion::conectar();

              $sql = $con->prepare("SELECT * FROM ruta_pasajero WHERE id_ruta = ?");

              $sql->bindParam(1, $id_vehiculo);



              $sql->execute();

              

              while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                

                 $vehiculosId[] = $filas;

              }



          return $vehiculosId;

        }



        public function asignarPasajeros($id_pasajero,$id_vehiculo){

            try { 



              $con = Conexion::conectar();

              $sql = $con->prepare("INSERT INTO ruta_pasajero (id_pasajero,id_ruta) VALUES (:id_pasajero,:id_ruta)");

              $sql->bindParam(id_pasajero, $id_pasajero);

              $sql->bindParam(id_ruta, $id_vehiculo);



              $sql->execute();

                            

            } catch (Exception $e) {

              echo $e->getMessage();

            }

        }
	

	public function registrarPasajeroRecorrido($pasajero, $recorrido, $ruta, $fecha, $hora, $usuario){

            try { 

              $con = Conexion::conectar();

              $sql = $con->prepare("INSERT INTO detalle_recorrido_fijo (id_pasajero,id_recorrido,id_ruta,fecha,hora,us_registra) VALUES (:pasajero, :recorrido, :ruta, :fecha, :hora, :usuario)");
	
 	      $sql->bindParam(":pasajero", $pasajero);
	      $sql->bindParam(":recorrido", $recorrido);
              $sql->bindParam(":fecha", $fecha);
              $sql->bindParam(":hora", $hora);
	      $sql->bindParam(":usuario", $usuario);
	      $sql->bindParam(":ruta", $ruta);
	      
              $sql->execute();
				
	      //echo "INSERT INTO detalle_recorrido_fijo (id_pasajero,id_recorrido,id_ruta,fecha,hora,us_registra) VALUES ('$pasajero', '$recorrido', '$ruta', '$fecha', '$hora', '$usuario')";
              //$id = $con->lastInsertId();

              return $id;              	

            } catch (Exception $e) {

              echo $e->getMessage();

            }

        }

	public function registrarRecorrido($fecha, $hora, $usuario, $id_ruta, $tipo)	{

            try { 



              $con = Conexion::conectar();

              $sql = $con->prepare("INSERT INTO recorrido_ruta_fija (fecha_inicio,hora_inicio,id_usuario,id_ruta,tipo_usuario) VALUES (:fecha, :hora, :usuario, :id_ruta, :tipo)");

              $sql->bindParam(":fecha", $fecha);
              $sql->bindParam(":hora", $hora);
	      $sql->bindParam(":usuario", $usuario);
	      $sql->bindParam(":id_ruta", $id_ruta);
	      $sql->bindParam(":tipo", $tipo);

              $sql->execute();

              $id = $con->lastInsertId();

              return $id;              	

            } catch (Exception $e) {

              echo $e->getMessage();

            }

        }


        public function borrarPasajeros($id_vehiculo){

            try { 



              $con = Conexion::conectar();

              $sql = $con->prepare("DELETE FROM ruta_pasajero WHERE id_ruta = ?");

              $sql->bindParam(1, $id_vehiculo);



              $sql->execute();

                            

            } catch (Exception $e) {

              echo $e->getMessage();

            }

        }

        

        public function listarOtrasRutas($id_vehiculo){

              $vehiculosId = array();

              $con = Conexion::conectar();

              $sql = $con->prepare("SELECT * FROM vehiculos WHERE id_vehiculo != ? and id_tipo_servicio = '1'");

              $sql->bindParam(1, $id_vehiculo);



              $sql->execute();

              

              while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                

                 $vehiculosId[] = $filas;

              }



          return $vehiculosId;

        }



        public function rutaAsignada($id_vehiculo){

              $vehiculosId = array();

              $con = Conexion::conectar();

              $sql = $con->prepare("SELECT * FROM vehiculo_ruta WHERE id_vehiculo = ?");

              $sql->bindParam(1, $id_vehiculo);



              $sql->execute();

              

              while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                

                 $vehiculosId[] = $filas;

              }



          return $vehiculosId;

        }



        public function asignarRuta($id_vehiculo,$id_colegio,$id_conductor,$id_monitor){

            try { 



              $con = Conexion::conectar();

              $sql = $con->prepare("INSERT INTO vehiculo_ruta (id_vehiculo,id_cliente,id_conductor,id_monitor) VALUES (:id_vehiculo,:id_cliente,:id_conductor,:id_monitor)");

              $sql->bindParam("id_vehiculo", $id_vehiculo);

              $sql->bindParam("id_cliente", $id_colegio);

              $sql->bindParam("id_conductor", $id_conductor);

              $sql->bindParam("id_monitor", $id_monitor);



              $sql->execute();

                            

            } catch (Exception $e) {

              echo $e->getMessage();

            }

        }



        public function actualizarRuta($id,$id_cliente,$id_vehiculo,$id_conductor,$id_monitor,$num_ruta){

            try {

              $con = Conexion::conectar();

              $sql = $con->prepare("UPDATE vehiculo_ruta SET id_vehiculo = :id_vehiculo, id_cliente = :id_cliente, id_conductor = :id_conductor, id_monitor = :id_monitor, num_ruta = :num_ruta WHERE id = :id");

              $sql->bindParam("id_vehiculo", $id_vehiculo);
              $sql->bindParam("id_cliente", $id_cliente);
              $sql->bindParam("id_conductor", $id_conductor);
              $sql->bindParam("id_monitor", $id_monitor);
	      $sql->bindParam("num_ruta", $num_ruta);
	      $sql->bindParam("id", $id);	   	

              $sql->execute();

                            

            } catch (Exception $e) {

              echo $e->getMessage();

            }

        }

	

        public function listarConductoresPorId($id_vehiculo){

            $vehiculosId = array();
            $con = Conexion::conectar();

            $sql = $con->prepare("SELECT * FROM vehiculos_conductores AS vc INNER JOIN vehiculos AS v ON vc.id_vehiculo = v.id_vehiculo INNER JOIN conductores AS c ON vc.id_conductor = c.id_conductor WHERE vc.id_vehiculo = ?");
            $sql->bindParam(1, $id_vehiculo);

            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
               $vehiculosId[] = $filas;
            }

            return $vehiculosId;
        }



        public function listarConductoresPorVehiculo($id_vehiculo){

              $vehiculosId = array();

              $con = Conexion::conectar();

              $sql = $con->prepare("SELECT * FROM vehiculos_conductores AS vc INNER JOIN conductores AS c ON vc.id_conductor = c.id_conductor WHERE vc.id_vehiculo = ? ");

              $sql->bindParam(1, $id_vehiculo);



              $sql->execute();

              

              while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                

                 $vehiculosId[] = $filas;

              }



          return $vehiculosId;

        }
        
        public function ConductoresPorVehiculo($id_vehiculo){
              $vehiculosCondId = array();
              $con = Conexion::conectar();
              $sql = $con->prepare("SELECT * FROM vehiculos_conductores  WHERE id_vehiculo = :id_vehiculo ");
              $sql->bindParam(":id_vehiculo", $id_vehiculo);

              $sql->execute();
              
              while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                
                 $vehiculosCondId[] = $filas;
              }

          return $vehiculosCondId;
        }

        public function ConductoresPorVehiculo2($id_vehiculo){
              $vehiculosCondId = array();
              $con = Conexion::conectar();
              $sql = $con->prepare("SELECT * FROM vehiculos_conductores AS vc INNER JOIN conductores AS c ON c.id_conductor = vc.id_conductor WHERE id_vehiculo = :id_vehiculo ");
              $sql->bindParam(":id_vehiculo", $id_vehiculo);

              $sql->execute();
              
              while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                
                 $vehiculosCondId[] = $filas;
              }

          return $vehiculosCondId;
        }

        public function listarVehiculosPorContrato($id_contrato){
            $vehiculosId = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM vehiculos_contratos WHERE id_contrato = ?");
            $sql->bindParam(1, $id_contrato);
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
               $vehiculosId[] = $filas;
            }

            return $vehiculosId;
        }

        public function listarVehiculosPorContrato2($id_contrato){
            $vehiculosId = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM vehiculos_contratos As vc INNER JOIN vehiculos AS v ON v.id_vehiculo = vc.id_vehiculo WHERE id_contrato = ?");
            $sql->bindParam(1, $id_contrato);
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
               $vehiculosId[] = $filas;
            }

            return $vehiculosId;
        }



        public function listarContratoPorVehiculo($id_vehiculo){

              $contratoId = array();

              $con = Conexion::conectar();

              $sql = $con->prepare("SELECT * FROM vehiculos_contratos WHERE id_vehiculo = ?");

              $sql->bindParam(1, $id_vehiculo);



              $sql->execute();

              

              while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                

                 $contratoId[] = $filas;

              }



          return $contratoId;

        }



        public function listarVehiculosPorConductor($id_conductor){

              $vc = array();

              $con = Conexion::conectar();

              $sql = $con->prepare("SELECT * FROM vehiculos_conductores  WHERE id_conductor = :id_conductor");

              $sql->bindParam(':id_conductor', $id_conductor);



              $sql->execute();

              

              while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                 $vc[] = $filas;

              }



          return $vc;

        }



        public function listarVehiculosPorConductor_1($id_conductor){

              $vc1 = array();

              $con = Conexion::conectar();

              $sql = $con->prepare("SELECT id_vehiculo FROM vehiculos_conductores  WHERE id_conductor = :id_conductor ");

              $sql->bindParam(':id_conductor', $id_conductor);



              $sql->execute();

              

              while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                

                 $vc1[] = $filas;

              }



          return $vc1;

        }



        public function listarPorPlaca($placa){

              $vehiculosId = array();

              $con = Conexion::conectar();

              $sql = $con->prepare("SELECT * FROM vehiculos WHERE placa = :placa");

              $sql->bindParam(":placa", $placa);



              $sql->execute();

              

              while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                

                 $vehiculosId[] = $filas;

              }



          return $vehiculosId;

        }



          /*TAR OPERACION*/



            public function listarDocsToVencidos($notificarFecha){



                $toVencidos = array();

                $con = Conexion::conectar();

                $sql = $con->prepare("SELECT * FROM vehiculos WHERE fecha_vencimiento_to <= :notificarFecha AND fecha_vencimiento_to != '0000-00-00' ORDER BY fecha_vencimiento_to");

                $sql->bindParam(":notificarFecha", $notificarFecha);

                $sql->execute();





                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                    $toVencidos[] = $filas;

                }

                return $toVencidos;

            }
			
			public function listarDocsToVencidosVeh($vehiculos,$notificarFecha){



                $toVencidos = array();

                $con = Conexion::conectar();

                $sql = $con->prepare("SELECT * FROM vehiculos WHERE fecha_vencimiento_to <= :notificarFecha AND fecha_vencimiento_to != '0000-00-00' AND estado = 1 and id_vehiculo IN ($vehiculos) ORDER BY fecha_vencimiento_to");

                $sql->bindParam(":notificarFecha", $notificarFecha);

                $sql->execute();

				//echo "SELECT * FROM vehiculos WHERE fecha_vencimiento_to <= '$notificarFecha' AND fecha_vencimiento_to != '0000-00-00' AND estado = 1 and id_vehiculo IN ($vehiculos) ORDER BY fecha_vencimiento_to";
				


                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                    $toVencidos[] = $filas;

                }

                return $toVencidos;

            }



            public function listarDisposVencidos($notificarFecha2){



                $toVencidos = array();

                $con = Conexion::conectar();

                $sql = $con->prepare("SELECT * FROM vehiculos WHERE (fecha_exp_disp_velocidad <= :notificarFecha2 or fecha_exp_disp_velocidad = '0000-00-00') ORDER BY fecha_exp_disp_velocidad");

                $sql->bindParam(":notificarFecha2", $notificarFecha2);

                $sql->execute();





                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                    $toVencidos[] = $filas;

                }

                return $toVencidos;

            }
			
			public function listarDisposVencidosVeh($vehiculos,$notificarFecha2){



                $toVencidos = array();

                $con = Conexion::conectar();

                $sql = $con->prepare("SELECT * FROM vehiculos WHERE (fecha_exp_disp_velocidad <= :notificarFecha2 or fecha_exp_disp_velocidad = '0000-00-00') AND estado = 1 and id_vehiculo IN ($vehiculos) ORDER BY fecha_exp_disp_velocidad");

                $sql->bindParam(":notificarFecha2", $notificarFecha2);

                $sql->execute();





                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                    $toVencidos[] = $filas;

                }

                return $toVencidos;

            }



             public function listarDocsToVencidosPorVehiculo($id_vehiculo, $notificarFecha){



                $toVencidosId = array();

                $con = Conexion::conectar();

                $sql = $con->prepare("SELECT * FROM vehiculos WHERE id_vehiculo = :id_vehiculo AND (fecha_vencimiento_to <= :notificarFecha OR fecha_vencimiento_to = '0000-00-00') and estado = 1");

                $sql->bindParam(":id_vehiculo", $id_vehiculo);

                $sql->bindParam(":notificarFecha", $notificarFecha);

                $sql->execute();





                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                    $toVencidosId[] = $filas;

                }

                return $toVencidosId;

            }



          /*LICENCIA TRANSITO*/



            public function validarDocLt($id_vehiculo){



                $docLt = array();

                $con = Conexion::conectar();

                $sql = $con->prepare("SELECT * FROM vehiculos WHERE id_vehiculo = :id_vehiculo AND fecha_vencimiento_lt = '0000-00-00' and estado = 1");

                $sql->bindParam(":id_vehiculo", $id_vehiculo);

                $sql->execute();



                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                   $docLt[] = $filas;

                }



                return $docLt;



            }



          /*SOAT*/



            public function listarDocsSoatVencidos($notificarFecha){



                $soatVencidos = array();

                $con = Conexion::conectar();

                $sql = $con->prepare("SELECT * FROM vehiculos WHERE fecha_vencimiento_soat <= :notificarFecha AND fecha_vencimiento_soat != '0000-00-00' ORDER BY fecha_vencimiento_soat");

                $sql->bindParam(":notificarFecha", $notificarFecha);

                $sql->execute();





                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                    $soatVencidos[] = $filas;

                }

                return $soatVencidos;

            }
			
			public function listarDocsSoatVencidosVeh($vehiculos,$notificarFecha){



                $soatVencidos = array();

                $con = Conexion::conectar();

                $sql = $con->prepare("SELECT * FROM vehiculos WHERE fecha_vencimiento_soat <= :notificarFecha AND fecha_vencimiento_soat != '0000-00-00' AND estado = 1 AND estado = 1 and id_vehiculo IN ($vehiculos) ORDER BY fecha_vencimiento_soat");

                $sql->bindParam(":notificarFecha", $notificarFecha);

                $sql->execute();





                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                    $soatVencidos[] = $filas;

                }

                return $soatVencidos;

            }



            public function listarDocsSoatVencidosPorVehiculo($id_vehiculo, $notificarFecha){
                $soatVencidosId = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM vehiculos WHERE id_vehiculo = :id_vehiculo AND (fecha_vencimiento_soat <= :notificarFecha OR fecha_vencimiento_soat = '0000-00-00') AND estado = 1");

                $sql->bindParam(":id_vehiculo", $id_vehiculo);
                $sql->bindParam(":notificarFecha", $notificarFecha);

                $sql->execute();

                //echo "SELECT * FROM vehiculos WHERE id_vehiculo = '$id_vehiculo' AND (fecha_vencimiento_soat <= '$notificarFecha' OR fecha_vencimiento_soat = '0000-00-00') AND estado = 1";

                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $soatVencidosId[] = $filas;
                }

                return $soatVencidosId;      
            }



          /*REVISION TECNOME*/



            public function listarDocsRtVencidos($notificarFecha){



                $rtVencidos = array();

                $con = Conexion::conectar();

                $sql = $con->prepare("SELECT * FROM vehiculos WHERE fecha_vencimiento_rt <= :notificarFecha AND fecha_vencimiento_rt != '0000-00-00' ORDER BY fecha_vencimiento_rt");

                $sql->bindParam(":notificarFecha", $notificarFecha);

                $sql->execute();





                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                    $rtVencidos[] = $filas;

                }

                return $rtVencidos;

            }
			
			public function listarDocsRtVencidosVeh($vehiculos,$notificarFecha){



                $rtVencidos = array();

                $con = Conexion::conectar();

                $sql = $con->prepare("SELECT * FROM vehiculos WHERE fecha_vencimiento_rt <= :notificarFecha AND fecha_vencimiento_rt != '0000-00-00' and estado = 1 and id_vehiculo IN ($vehiculos) ORDER BY fecha_vencimiento_rt");

                $sql->bindParam(":notificarFecha", $notificarFecha);

                $sql->execute();





                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                    $rtVencidos[] = $filas;

                }

                return $rtVencidos;

            }



            public function listarDocsRtVencidosPorId($id_vehiculo, $notificarFecha){



                $rtVencidosId = array();

                $con = Conexion::conectar();

                $sql = $con->prepare("SELECT * FROM vehiculos WHERE id_vehiculo = :id_vehiculo AND (fecha_vencimiento_rt <= :notificarFecha OR fecha_vencimiento_rt = '0000-00-00') and estado = 1");

                $sql->bindParam(":id_vehiculo", $id_vehiculo);

                $sql->bindParam(":notificarFecha", $notificarFecha);

                $sql->execute();





                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                    $rtVencidosId[] = $filas;

                }

                return $rtVencidosId;

            }



            /*PREVENTIVA*/



          /*REVISION PREVENTIVA*/
		  
				public function listarDocsRpVencidos($notificarFecha2){



                  $rpVencidos = array();

                  $con = Conexion::conectar();

                  $sql1 = $con->prepare("SELECT * FROM vehiculos WHERE fecha_vencimiento_rp <= :notificarFecha2 AND fecha_vencimiento_rp != '0000-00-00' ORDER BY fecha_vencimiento_rp");

                  $sql1->bindParam(":notificarFecha2", $notificarFecha2);

                  $sql1->execute();

                  while ($filas1 = $sql1->fetch(PDO::FETCH_ASSOC)) {

                      $rpVencidos[] = $filas1;

                  }
                  $con = null;
                  return $rpVencidos;

              }

              public function listarDocsRpVencidosVeh($vehiculos,$notificarFecha){



                  $rpVencidos = array();

                  $con = Conexion::conectar();

                  $sql = $con->prepare("SELECT * FROM vehiculos WHERE fecha_vencimiento_rp <= :notificarFecha AND fecha_vencimiento_rp != '0000-00-00' and estado = 1 and id_vehiculo IN ($vehiculos) ORDER BY fecha_vencimiento_rp");

                  $sql->bindParam(":notificarFecha", $notificarFecha);

                  $sql->execute();





                  while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                      $rpVencidos[] = $filas;

                  }

                  return $rpVencidos;

              }



              public function listarDocsRpVencidosPorId($id_vehiculo, $notificarFecha){



                  $rpVencidosId = array();

                  $con = Conexion::conectar();

                  $sql = $con->prepare("SELECT * FROM vehiculos WHERE id_vehiculo = :id_vehiculo AND (fecha_vencimiento_rp <= :notificarFecha OR fecha_vencimiento_rp = '0000-00-00') and estado = 1");

                  $sql->bindParam(":id_vehiculo", $id_vehiculo);

                  $sql->bindParam(":notificarFecha", $notificarFecha);

                  $sql->execute();





                  while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                      $rpVencidosId[] = $filas;

                  }

                  return $rpVencidosId;

              }



          /*CONTRACTUAL*/



            public function listarDocsPcVencidos($notificarFecha1){



                $pcVencidos = array();

                $con = Conexion::conectar();

                $sql = $con->prepare("SELECT * FROM vehiculos WHERE fecha_vencimiento_contra <= :notificarFecha1 AND fecha_vencimiento_contra != '0000-00-00'");
                
                $sql->bindParam(":notificarFecha1", $notificarFecha1);

                $sql->execute();
                
                //$sql->debugDumpParams();    
                
                while ($filas1 = $sql->fetch(PDO::FETCH_ASSOC)) {

                    $pcVencidos[] = $filas1;

                }

                return $pcVencidos;

            }
			
			public function listarDocspcVencidosVeh($vehiculos,$notificarFecha){



                $pcVencidos = array();

                $con = Conexion::conectar();

                $sql = $con->prepare("SELECT * FROM vehiculos WHERE fecha_vencimiento_contra <= :notificarFecha AND fecha_vencimiento_contra != '0000-00-00' and estado = 1 and id_vehiculo IN ($vehiculos) ORDER BY fecha_vencimiento_contra");

                $sql->bindParam(":notificarFecha", $notificarFecha);

                $sql->execute();





                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                    $pcVencidos[] = $filas;

                }

                return $pcVencidos;

            }



            public function listarDocspcVencidosPorId($id_vehiculo, $notificarFecha){



                $pcVencidosId = array();

                $con = Conexion::conectar();

                $sql = $con->prepare("SELECT * FROM vehiculos WHERE id_vehiculo = :id_vehiculo AND (fecha_vencimiento_contra <= :notificarFecha OR fecha_vencimiento_contra = '0000-00-00') and estado = 1");

                $sql->bindParam(":id_vehiculo", $id_vehiculo);

                $sql->bindParam(":notificarFecha", $notificarFecha);

                $sql->execute();





                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                    $pcVencidosId[] = $filas;

                }

                return $pcVencidosId;

            }



          /*EXTRA*/



            public function listarDocspeVencidos($notificarFecha){



                $peVencidos = array();

                $con = Conexion::conectar();

                $sql = $con->prepare("SELECT * FROM vehiculos WHERE fecha_vencimiento_extra <= :notificarFecha AND fecha_vencimiento_extra != '0000-00-00' ORDER BY fecha_vencimiento_extra");

                $sql->bindParam(":notificarFecha", $notificarFecha);

                $sql->execute();





                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                    $peVencidos[] = $filas;

                }

                return $peVencidos;

            }
			
			public function listarDocspeVencidosVeh($vehiculos,$notificarFecha){



                $peVencidos = array();

                $con = Conexion::conectar();

                $sql = $con->prepare("SELECT * FROM vehiculos WHERE fecha_vencimiento_extra <= :notificarFecha AND fecha_vencimiento_extra != '0000-00-00' AND estado = 1 and id_vehiculo IN ($vehiculos) ORDER BY fecha_vencimiento_extra");

                $sql->bindParam(":notificarFecha", $notificarFecha);

                $sql->execute();





                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                    $peVencidos[] = $filas;

                }

                return $peVencidos;

            }



            public function listarDocspeVencidosPorId($id_vehiculo, $notificarFecha){



                $peVencidosId = array();

                $con = Conexion::conectar();

                $sql = $con->prepare("SELECT * FROM vehiculos WHERE id_vehiculo = :id_vehiculo AND (fecha_vencimiento_extra <= :notificarFecha OR fecha_vencimiento_extra = '0000-00-00') AND estado = 1");

                $sql->bindParam(":id_vehiculo", $id_vehiculo);

                $sql->bindParam(":notificarFecha", $notificarFecha);

                $sql->execute();





                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                    $peVencidosId[] = $filas;

                }

                return $peVencidosId;

            }



            public function buscarVehiculoPorPropietario($id_propietario){
                $vehiculosPropietario = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM vehiculos WHERE id_propietario = :id_propietario AND estado = 1");
                $sql->bindParam(":id_propietario", $id_propietario);
                $sql->execute();

                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                  $vehiculosPropietario[] = $filas;
                }

                return $vehiculosPropietario;
            }



            //INICIO CONSULTAS REPORTE//

            public function listarActivosFiltro($id_filtro,$id_propia,$id_propietario){

                if($id_filtro == 0){
                    $id_filtro = "numero_movil like '%%'";
                } else if($id_filtro == 1){
                    $id_filtro = "numero_movil >= '1' and numero_movil <= '999'";
                } else if($id_filtro == 2){
                    $id_filtro = "numero_movil >= '1000' and numero_movil <= '1999'";
                } else if($id_filtro == 3){
                    $id_filtro = "numero_movil = '0'";
                }


                if($id_propia == 0){
                    $id_propia = "flota_propia like '%%'";
                } else if($id_propia == 1){
                    $id_propia = "flota_propia = 'S'";
                } else if($id_propia == 2){
                    $id_propia = "flota_propia = 'N'";
                } 


                if($id_propietario == 0){
                    $id_propietario = "id_propietario like '%%'";
                } else if($id_propietario == 1){
                    $id_propietario = "id_propietario = 176 ";
                } else if($id_propietario == 2){
                    $id_propietario = "id_propietario = 37 or id_propietario = 241 ";
                } else if($id_propietario == 3){
                    $id_propietario = "id_propietario = 175 or id_propietario = 317 ";
                } 
                  
                $vehiculosId = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM vehiculos WHERE estado = 1 AND $id_filtro AND $id_propia AND $id_propietario ORDER BY placa ASC");
                $sql->execute();
                  
                //echo "SELECT * FROM vehiculos WHERE estado = 1 AND $id_filtro AND $id_propia AND $id_propietario ORDER BY placa ASC";

                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $vehiculosId[] = $filas;
                }
                
                return $vehiculosId;

            }


            public function listarActivosFiltroVehiculos($flota_propia, $empresa, $id_tipo_vehiculo){

                $activosFiltroVehi = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM vehiculos WHERE flota_propia LIKE '$flota_propia' AND $empresa AND id_tipo_vehiculo LIKE '$id_tipo_vehiculo' AND estado = 1 ORDER BY id_vehiculo ASC");
/*
                $sql->bindParam(":id_flota_propia", $flota_propia);
                $sql->bindParam(":empresa", $empresa);
                $sql->bindParam(":id_tipo_vehiculo", $id_tipo_vehiculo);*/

                $sql->execute();

                //echo "SELECT * FROM vehiculos WHERE flota_propia LIKE '$flota_propia' AND $empresa AND id_tipo_vehiculo LIKE '$id_tipo_vehiculo' AND estado = 1 ORDER BY id_vehiculo ASC";

                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $activosFiltroVehi[] = $filas;
                }

                return $activosFiltroVehi;

            }
            
            public function listarTodosFiltroVehiculos($flota_propia, $empresa, $id_tipo_vehiculo){

                $activosFiltroVehi = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM vehiculos WHERE flota_propia LIKE '$flota_propia' AND $empresa AND id_tipo_vehiculo LIKE '$id_tipo_vehiculo' ORDER BY id_vehiculo ASC");
/*
                $sql->bindParam(":id_flota_propia", $flota_propia);
                $sql->bindParam(":empresa", $empresa);
                $sql->bindParam(":id_tipo_vehiculo", $id_tipo_vehiculo);*/

                $sql->execute();

                //echo "SELECT * FROM vehiculos WHERE flota_propia LIKE '$flota_propia' AND $empresa AND id_tipo_vehiculo LIKE '$id_tipo_vehiculo' ORDER BY id_vehiculo ASC";

                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $activosFiltroVehi[] = $filas;
                }

                return $activosFiltroVehi;

            }

            /*public function reporteVehiculosContrato($id_contrato, $tipo_contrato){

                $FiltroContrato = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM vehiculos AS v INNER JOIN vehiculos_contratos AS vc ON v.id_vehiculo = vc.id_vehiculo WHERE v.estado = 1 AND (vc.id_contrato LIKE :id_contrato AND vc.tipo_contrato LIKE :tipo_contrato) ORDER BY v.placa ASC");

                $sql->bindParam(":id_contrato", $id_contrato);
                $sql->bindParam(":tipo_contrato", $tipo_contrato);
                $sql->execute();

                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $FiltroContrato[] = $filas;
                }

                return $FiltroContrato;
            }*/



            public function reporteCP($id_filtro,$id_propia,$id_propietario, $id_contrato, $tipo_contrato){



                if($id_filtro == 0){

                    $id_filtro = "v.numero_movil like '%%'";

                  } else if($id_filtro == 1){

                    $id_filtro = "v.numero_movil >= '1' and v.numero_movil <= '999'";

                  } else if($id_filtro == 2){

                    $id_filtro = "v.numero_movil >= '1000' and v.numero_movil <= '1999'";

                  } else if($id_filtro == 3){

                    $id_filtro = "v.numero_movil = '0'";

                  }



                  if($id_propia == 0){

                    $id_propia = "v.flota_propia like '%%'";

                  } else if($id_propia == 1){

                    $id_propia = "v.flota_propia = 'S'";

                  } else if($id_propia == 2){

                    $id_propia = "v.flota_propia = 'N'";

                  } 



                  if($id_propietario == 0){

                    $id_propietario = "v.id_propietario like '%%'";

                  } else if($id_propietario == 1){

                    $id_propietario = "v.id_propietario = '176'";

                  } else if($id_propietario == 2){

                    $id_propietario = "v.id_propietario = '37' or v.id_propietario = '241'";

                  } else if($id_propietario == 3){

                    $id_propietario = "v.id_propietario = '175' or v.id_propietario = '317'";

                  } 



                $reporte1 = array();

                $con = Conexion::conectar();

                $sql = $con->prepare("SELECT * FROM vehiculos_contratos AS vc INNER JOIN vehiculos AS v ON v.id_vehiculo = vc.id_vehiculo WHERE v.estado = 1 and $id_filtro and $id_propia and $id_propietario AND vc.id_contrato LIKE :id_contrato AND vc.tipo_contrato LIKE :tipo_contrato");



                  $sql->bindParam(":id_contrato", $id_contrato);

                  $sql->bindParam(":tipo_contrato", $tipo_contrato);



                $sql->execute();



                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                    $reporte1[] = $filas;

                }

                return $reporte1;

            }



            public function reporteTO($id_filtro,$id_propia,$id_propietario,$hoy, $id_contrato, $tipo_contrato){



                if($id_filtro == 0){

                    $id_filtro = "v.numero_movil like '%%'";

                  } else if($id_filtro == 1){

                    $id_filtro = "v.numero_movil >= '1' and v.numero_movil <= '999'";

                  } else if($id_filtro == 2){

                    $id_filtro = "v.numero_movil >= '1000' and v.numero_movil <= '1999'";

                  } else if($id_filtro == 3){

                    $id_filtro = "v.numero_movil = '0'";

                  }



                  if($id_propia == 0){

                    $id_propia = "v.flota_propia like '%%'";

                  } else if($id_propia == 1){

                    $id_propia = "v.flota_propia = 'S'";

                  } else if($id_propia == 2){

                    $id_propia = "v.flota_propia = 'N'";

                  } 



                  if($id_propietario == 0){

                    $id_propietario = "v.id_propietario like '%%'";

                  } else if($id_propietario == 1){

                    $id_propietario = "v.id_propietario = '176'";

                  } else if($id_propietario == 2){

                    $id_propietario = "v.id_propietario = '37' or v.id_propietario = '241'";

                  } else if($id_propietario == 3){

                    $id_propietario = "v.id_propietario = '175' or v.id_propietario = '317'";

                  } 



                $reporte2 = array();

                $con = Conexion::conectar();

                $sql = $con->prepare("SELECT * FROM vehiculos_contratos AS vc INNER JOIN vehiculos AS v ON v.id_vehiculo = vc.id_vehiculo WHERE  ((v.tarjeta_operacion = '')or(v.fecha_vencimiento_to = '0000-00-00')or(v.fecha_vencimiento_to <= '$hoy')) and v.estado = 1 and $id_filtro and $id_propia and $id_propietario AND vc.id_contrato LIKE :id_contrato AND vc.tipo_contrato LIKE :tipo_contrato");

                  $sql->bindParam(":id_contrato", $id_contrato);

                  $sql->bindParam(":tipo_contrato", $tipo_contrato);

                $sql->execute();



                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                    $reporte2[] = $filas;

                }

                //echo "SELECT * FROM vehiculos WHERE ((tarjeta_operacion = '')or(fecha_vencimiento_to = '0000-00-00')or(fecha_vencimiento_to <= '$hoy')) and estado = 1 and $id_filtro and $id_propia and $id_propietario";

                return $reporte2;

            }



            public function reporteLT($id_filtro,$id_propia,$id_propietario, $id_contrato, $tipo_contrato){



                  if($id_filtro == 0){

                    $id_filtro = "v.numero_movil like '%%'";

                  } else if($id_filtro == 1){

                    $id_filtro = "v.numero_movil >= '1' and v.numero_movil <= '999'";

                  } else if($id_filtro == 2){

                    $id_filtro = "v.numero_movil >= '1000' and v.numero_movil <= '1999'";

                  } else if($id_filtro == 3){

                    $id_filtro = "v.numero_movil = '0'";

                  }



                  if($id_propia == 0){

                    $id_propia = "v.flota_propia like '%%'";

                  } else if($id_propia == 1){

                    $id_propia = "v.flota_propia = 'S'";

                  } else if($id_propia == 2){

                    $id_propia = "v.flota_propia = 'N'";

                  } 



                  if($id_propietario == 0){

                    $id_propietario = "v.id_propietario like '%%'";

                  } else if($id_propietario == 1){

                    $id_propietario = "v.id_propietario = '176'";

                  } else if($id_propietario == 2){

                    $id_propietario = "v.id_propietario = '37' or v.id_propietario = '241'";

                  } else if($id_propietario == 3){

                    $id_propietario = "v.id_propietario = '175' or v.id_propietario = '317'";

                  } 



                $reporte3 = array();

                $con = Conexion::conectar();

                $sql = $con->prepare("SELECT * FROM vehiculos_contratos AS vc INNER JOIN vehiculos AS v ON v.id_vehiculo = vc.id_vehiculo WHERE ((v.licencia_transito = '')or(v.fecha_vencimiento_lt = '0000-00-00')) and v.estado = 1 and $id_filtro and $id_propia and $id_propietario AND vc.id_contrato LIKE :id_contrato AND vc.tipo_contrato LIKE :tipo_contrato");

                

                $sql->bindParam(":id_contrato", $id_contrato);

                

                $sql->bindParam(":tipo_contrato", $tipo_contrato);



                $sql->execute();



                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                    $reporte3[] = $filas;

                }



                return $reporte3;





            }



            public function reporteSOAT($id_filtro,$id_propia,$id_propietario,$hoy, $id_contrato, $tipo_contrato){



                if($id_filtro == 0){

                    $id_filtro = "v.numero_movil like '%%'";

                  } else if($id_filtro == 1){

                    $id_filtro = "v.numero_movil >= '1' and v.numero_movil <= '999'";

                  } else if($id_filtro == 2){

                    $id_filtro = "v.numero_movil >= '1000' and v.numero_movil <= '1999'";

                  } else if($id_filtro == 3){

                    $id_filtro = "v.numero_movil = '0'";

                  }



                  if($id_propia == 0){

                    $id_propia = "v.flota_propia like '%%'";

                  } else if($id_propia == 1){

                    $id_propia = "v.flota_propia = 'S'";

                  } else if($id_propia == 2){

                    $id_propia = "v.flota_propia = 'N'";

                  } 



                  if($id_propietario == 0){

                    $id_propietario = "v.id_propietario like '%%'";

                  } else if($id_propietario == 1){

                    $id_propietario = "v.id_propietario = '176'";

                  } else if($id_propietario == 2){

                    $id_propietario = "v.id_propietario = '37' or v.id_propietario = '241'";

                  } else if($id_propietario == 3){

                    $id_propietario = "v.id_propietario = '175' or v.id_propietario = '317'";

                  } 



                $reporte4 = array();

                $con = Conexion::conectar();

                $sql = $con->prepare("SELECT * FROM vehiculos_contratos AS vc INNER JOIN vehiculos AS v ON v.id_vehiculo = vc.id_vehiculo WHERE ((v.soat = '')or(v.fecha_vencimiento_soat = '0000-00-00')or(v.fecha_vencimiento_soat <= '$hoy')) and v.estado = 1 and $id_filtro and $id_propia and $id_propietario AND vc.id_contrato LIKE :id_contrato AND vc.tipo_contrato LIKE :tipo_contrato");

                  $sql->bindParam(":id_contrato", $id_contrato);

                  $sql->bindParam(":tipo_contrato", $tipo_contrato);

                $sql->execute();



                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                    $reporte4[] = $filas;

                }

                return $reporte4;

            }



            public function reporteRTM($id_filtro,$id_propia,$id_propietario,$hoy, $id_contrato, $tipo_contrato){



                if($id_filtro == 0){

                    $id_filtro = "v.numero_movil like '%%'";

                  } else if($id_filtro == 1){

                    $id_filtro = "v.numero_movil >= '1' and v.numero_movil <= '999'";

                  } else if($id_filtro == 2){

                    $id_filtro = "v.numero_movil >= '1000' and v.numero_movil <= '1999'";

                  } else if($id_filtro == 3){

                    $id_filtro = "v.numero_movil = '0'";

                  }



                  if($id_propia == 0){

                    $id_propia = "v.flota_propia like '%%'";

                  } else if($id_propia == 1){

                    $id_propia = "v.flota_propia = 'S'";

                  } else if($id_propia == 2){

                    $id_propia = "v.flota_propia = 'N'";

                  } 



                  if($id_propietario == 0){

                    $id_propietario = "v.id_propietario like '%%'";

                  } else if($id_propietario == 1){

                    $id_propietario = "v.id_propietario = '176'";

                  } else if($id_propietario == 2){

                    $id_propietario = "v.id_propietario = '37' or v.id_propietario = '241'";

                  } else if($id_propietario == 3){

                    $id_propietario = "v.id_propietario = '175' or v.id_propietario = '317'";

                  } 



                $reporte5 = array();

                $con = Conexion::conectar();

                $sql = $con->prepare("SELECT * FROM vehiculos_contratos AS vc INNER JOIN vehiculos AS v ON v.id_vehiculo = vc.id_vehiculo WHERE ((v.revision_tecnomecanica = '')or(v.fecha_vencimiento_rt = '0000-00-00')or(v.fecha_vencimiento_rt <= '$hoy')) and v.estado = 1 and $id_filtro and $id_propia and $id_propietario AND vc.id_contrato LIKE :id_contrato AND vc.tipo_contrato LIKE :tipo_contrato");

                  $sql->bindParam(":id_contrato", $id_contrato);

                  $sql->bindParam(":tipo_contrato", $tipo_contrato);

                $sql->execute();



                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                    $reporte5[] = $filas;

                }

                return $reporte5;

            }



            public function reporteRP($id_filtro,$id_propia,$id_propietario,$hoy, $id_contrato, $tipo_contrato){



                if($id_filtro == 0){

                    $id_filtro = "v.numero_movil like '%%'";

                  } else if($id_filtro == 1){

                    $id_filtro = "v.numero_movil >= '1' and v.numero_movil <= '999'";

                  } else if($id_filtro == 2){

                    $id_filtro = "v.numero_movil >= '1000' and v.numero_movil <= '1999'";

                  } else if($id_filtro == 3){

                    $id_filtro = "v.numero_movil = '0'";

                  }



                  if($id_propia == 0){

                    $id_propia = "v.flota_propia like '%%'";

                  } else if($id_propia == 1){

                    $id_propia = "v.flota_propia = 'S'";

                  } else if($id_propia == 2){

                    $id_propia = "v.flota_propia = 'N'";

                  } 



                  if($id_propietario == 0){

                    $id_propietario = "v.id_propietario like '%%'";

                  } else if($id_propietario == 1){

                    $id_propietario = "v.id_propietario = '176'";

                  } else if($id_propietario == 2){

                    $id_propietario = "v.id_propietario = '37' or v.id_propietario = '241'";

                  } else if($id_propietario == 3){

                    $id_propietario = "v.id_propietario = '175' or v.id_propietario = '317'";

                  } 



                $reporte6 = array();

                $con = Conexion::conectar();

                $sql = $con->prepare("SELECT * FROM vehiculos_contratos AS vc INNER JOIN vehiculos AS v ON v.id_vehiculo = vc.id_vehiculo WHERE ((v.revision_preventiva = '')or(v.fecha_vencimiento_rp = '0000-00-00')or(v.fecha_vencimiento_rp <= '$hoy')) and v.estado = 1 and $id_filtro and $id_propia and $id_propietario AND vc.id_contrato LIKE :id_contrato AND vc.tipo_contrato LIKE :tipo_contrato");

                  $sql->bindParam(":id_contrato", $id_contrato);

                  $sql->bindParam(":tipo_contrato", $tipo_contrato);

                $sql->execute();



                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                    $reporte6[] = $filas;

                }

                return $reporte6;

            }



            public function reportePRC($id_filtro,$id_propia,$id_propietario,$hoy, $id_contrato, $tipo_contrato){



                if($id_filtro == 0){

                    $id_filtro = "v.numero_movil like '%%'";

                  } else if($id_filtro == 1){

                    $id_filtro = "v.numero_movil >= '1' and v.numero_movil <= '999'";

                  } else if($id_filtro == 2){

                    $id_filtro = "v.numero_movil >= '1000' and v.numero_movil <= '1999'";

                  } else if($id_filtro == 3){

                    $id_filtro = "v.numero_movil = '0'";

                  }



                  if($id_propia == 0){

                    $id_propia = "v.flota_propia like '%%'";

                  } else if($id_propia == 1){

                    $id_propia = "v.flota_propia = 'S'";

                  } else if($id_propia == 2){

                    $id_propia = "v.flota_propia = 'N'";

                  } 



                  if($id_propietario == 0){

                    $id_propietario = "v.id_propietario like '%%'";

                  } else if($id_propietario == 1){

                    $id_propietario = "v.id_propietario = '176'";

                  } else if($id_propietario == 2){

                    $id_propietario = "v.id_propietario = '37' or v.id_propietario = '241'";

                  } else if($id_propietario == 3){

                    $id_propietario = "v.id_propietario = '175' or v.id_propietario = '317'";

                  } 



                $reporte7 = array();

                $con = Conexion::conectar();

                $sql = $con->prepare("SELECT * FROM vehiculos_contratos AS vc INNER JOIN vehiculos AS v ON v.id_vehiculo = vc.id_vehiculo WHERE ((v.poliza_contra = '')or(v.fecha_vencimiento_contra = '0000-00-00')or(v.fecha_vencimiento_contra <= '$hoy')) and v.estado = 1 and $id_filtro and $id_propia and $id_propietario AND vc.id_contrato LIKE :id_contrato AND vc.tipo_contrato LIKE :tipo_contrato");

                  $sql->bindParam(":id_contrato", $id_contrato);

                  $sql->bindParam(":tipo_contrato", $tipo_contrato);

                $sql->execute();



                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                    $reporte7[] = $filas;

                }

                return $reporte7;

            }



            public function reportePRE($id_filtro,$id_propia,$id_propietario,$hoy, $id_contrato, $tipo_contrato){



                if($id_filtro == 0){

                    $id_filtro = "v.numero_movil like '%%'";

                  } else if($id_filtro == 1){

                    $id_filtro = "v.numero_movil >= '1' and v.numero_movil <= '999'";

                  } else if($id_filtro == 2){

                    $id_filtro = "v.numero_movil >= '1000' and v.numero_movil <= '1999'";

                  } else if($id_filtro == 3){

                    $id_filtro = "v.numero_movil = '0'";

                  }



                  if($id_propia == 0){

                    $id_propia = "v.flota_propia like '%%'";

                  } else if($id_propia == 1){

                    $id_propia = "v.flota_propia = 'S'";

                  } else if($id_propia == 2){

                    $id_propia = "v.flota_propia = 'N'";

                  } 



                  if($id_propietario == 0){

                    $id_propietario = "v.id_propietario like '%%'";

                  } else if($id_propietario == 1){

                    $id_propietario = "v.id_propietario = '176'";

                  } else if($id_propietario == 2){

                    $id_propietario = "v.id_propietario = '37' or v.id_propietario = '241'";

                  } else if($id_propietario == 3){

                    $id_propietario = "v.id_propietario = '175' or v.id_propietario = '317'";

                  } 



                $reporte8 = array();

                $con = Conexion::conectar();

                $sql = $con->prepare("SELECT * FROM vehiculos_contratos AS vc INNER JOIN vehiculos AS v ON v.id_vehiculo = vc.id_vehiculo WHERE ((v.poliza_extra = '')or(v.fecha_vencimiento_extra = '0000-00-00')or(v.fecha_vencimiento_extra <= '$hoy')) and v.estado = 1 and $id_filtro and $id_propia and $id_propietario AND vc.id_contrato LIKE :id_contrato AND vc.tipo_contrato LIKE :tipo_contrato");

                  $sql->bindParam(":id_contrato", $id_contrato);

                  $sql->bindParam(":tipo_contrato", $tipo_contrato);

                $sql->execute();



                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                    $reporte8[] = $filas;

                }

                return $reporte8;

            }



            public function reporteDV($id_filtro,$id_propia,$id_propietario,$fecha, $id_contrato, $tipo_contrato){


                if($id_filtro == 0){
                    $id_filtro = "v.numero_movil like '%%'";
                } else if($id_filtro == 1){
                    $id_filtro = "v.numero_movil >= '1' and v.numero_movil <= '999'";
                } else if($id_filtro == 2){
                    $id_filtro = "v.numero_movil >= '1000' and v.numero_movil <= '1999'";
                } else if($id_filtro == 3){
                    $id_filtro = "v.numero_movil = '0'";
                }

                if($id_propia == 0){
                    $id_propia = "v.flota_propia like '%%'";
                } else if($id_propia == 1){
                    $id_propia = "v.flota_propia = 'S'";
                } else if($id_propia == 2){
                    $id_propia = "v.flota_propia = 'N'";
                } 

                if($id_propietario == 0){
                    $id_propietario = "v.id_propietario like '%%'";
                } else if($id_propietario == 1){
                    $id_propietario = "v.id_propietario = '176'";
                } else if($id_propietario == 2){
                    $id_propietario = "v.id_propietario = '37' or v.id_propietario = '241'";
                } else if($id_propietario == 3){
                    $id_propietario = "v.id_propietario = '175' or v.id_propietario = '317'";
                } 


                $reporte9 = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM vehiculos_contratos AS vc INNER JOIN vehiculos AS v ON v.id_vehiculo = vc.id_vehiculo WHERE ((v.disp_velocidad = '')or(v.fecha_exp_disp_velocidad = '0000-00-00')or(v.fecha_exp_disp_velocidad <= '$fecha')) and v.estado = 1 and $id_filtro and $id_propia and $id_propietario AND vc.id_contrato LIKE :id_contrato AND vc.tipo_contrato LIKE :tipo_contrato");
                $sql->bindParam(":id_contrato", $id_contrato);
                $sql->bindParam(":tipo_contrato", $tipo_contrato);

                $sql->execute();

                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $reporte9[] = $filas;
                }

                //echo "SELECT * FROM vehiculos WHERE ((disp_velocidad = '')or(fecha_exp_disp_velocidad = '0000-00-00')or(fecha_exp_disp_velocidad <= '$fecha')) and estado = 1 and $id_filtro and $id_propia and $id_propietario";

                return $reporte9;
            }

            //FIN CONSULTAS REPORTE



            //INICIO DOCUMENTOS VENCIDOS//

            public function documentosvencidosPorId($id_vehiculo,$fecha1,$fecha2){

                $VencidosId = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM vehiculos WHERE id_vehiculo = :id_vehiculo AND ((tarjeta_operacion = '' OR fecha_vencimiento_to < :fecha1 OR fecha_vencimiento_to = '0000-00-00')OR(licencia_transito = '' OR fecha_vencimiento_lt = '0000-00-00')OR(soat = '' OR fecha_vencimiento_soat < :fecha1 OR fecha_vencimiento_soat = '0000-00-00')OR(revision_tecnomecanica = '' OR fecha_vencimiento_rt < :fecha1 OR fecha_vencimiento_rt = '0000-00-00')OR(revision_preventiva = '' OR fecha_vencimiento_rp < :fecha1 OR fecha_vencimiento_rp = '0000-00-00')OR(poliza_contra = '' OR fecha_vencimiento_contra < :fecha1 OR fecha_vencimiento_contra = '0000-00-00')OR(poliza_extra = '' OR fecha_vencimiento_extra < :fecha1 OR fecha_vencimiento_extra = '0000-00-00')OR(disp_velocidad = '' OR fecha_exp_disp_velocidad < :fecha2 OR fecha_exp_disp_velocidad = '0000-00-00')) and estado = 1");
                $sql->bindParam(":id_vehiculo", $id_vehiculo);
                $sql->bindParam(":fecha1", $fecha1);
                $sql->bindParam(":fecha2", $fecha2);
                $sql->execute();


                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $VencidosId[] = $filas;
                }

                return $VencidosId;
            }

            //FIN DOCUMENTOS VENCIDOS TODOS//
            
            public function listarfiltroEmpresaConductores($filtro){
                $filtroEmpresa = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM vehiculos WHERE $filtro AND estado = 1");
                $sql->execute();

                //echo "SELECT * FROM vehiculos WHERE $filtro AND estado = 1";

                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $filtroEmpresa[] = $filas;
                }

                return $filtroEmpresa;
            }


            public function actualizarIDPropietarior($id_propietario, $id_vehiculo){
                try {
                  $con = Conexion::conectar();
                  $sql = $con->prepare("UPDATE vehiculos SET id_propietario = :id_propietario WHERE id_vehiculo = :id_vehiculo ");
                  $sql->bindParam(":id_propietario", $id_propietario);
                  $sql->bindParam(":id_vehiculo", $id_vehiculo);
                  $sql->execute();
                } catch (Exception $e) {
                  echo $e->getMessage();
                }
            }


            public function actualizarInfoPropietario($id_vehiculo, $telefono_propietario, $fecha_nac_propietario, $direccion_propietario, $ciudad_propietario, $tipo_propietario, $propiedad, $camara_comercio, $contrato_banco, $hoja_vida, $rut, $poder_apoderado){
                try {
                  $con = Conexion::conectar();
                  $sql = $con->prepare("UPDATE vehiculos SET telefono_propietario = :telefono_propietario, fecha_nac_propietario = :fecha_nac_propietario, direccion_propietario = :direccion_propietario, ciudad_propietario = :ciudad_propietario, tipo_propietario = :tipo_propietario, propiedad = :propiedad, camara_comercio = :camara_comercio, contrato_banco = :contrato_banco, hoja_vida = :hoja_vida, rut = :rut, poder_apoderado = :poder_apoderado WHERE id_vehiculo = :id_vehiculo ");
                  $sql->bindParam(":id_vehiculo", $id_vehiculo);
                  $sql->bindParam(":telefono_propietario", $telefono_propietario);
                  $sql->bindParam(":fecha_nac_propietario", $fecha_nac_propietario);
                  $sql->bindParam(":direccion_propietario", $direccion_propietario);
                  $sql->bindParam(":ciudad_propietario", $ciudad_propietario);
                  $sql->bindParam(":tipo_propietario", $tipo_propietario);
                  $sql->bindParam(":propiedad", $propiedad);
                  $sql->bindParam(":camara_comercio", $camara_comercio);
                  $sql->bindParam(":contrato_banco", $contrato_banco);
                  $sql->bindParam(":hoja_vida", $hoja_vida);
                  $sql->bindParam(":rut", $rut);
                  $sql->bindParam(":poder_apoderado", $poder_apoderado);

                  $sql->execute();

                } catch (Exception $e) {
                  echo $e->getMessage();
                }
            }

            public function listarVehiculosPorIDs($id_vehiculos){
                $vehiculosIDs = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM vehiculos WHERE id_vehiculo IN (:id_vehiculos)");
                $sql->bindParam(":id_vehiculos", $id_vehiculos);
                $sql->execute();

                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $vehiculosIDs[] = $filas;
                }

                return $vehiculosIDs;
            }

            public function buscarReferencia($id_vehiculo, $tipo_referencia){
                $bucarReferenciasProp = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM vehiculos WHERE id_vehiculo = :id_vehiculo AND tipo_referencia LIKE '%:tipo_referencia%' ");
                $sql->bindParam(":id_vehiculo", $id_vehiculo);
                $sql->bindParam(":tipo_referencia", $tipo_referencia);
                $sql->execute();

                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $bucarReferenciasProp[] = $filas;
                }

                return $bucarReferenciasProp;
            }

            public function filtroActualizacionesDocs($fecha_inicial_reporte, $fecha_final_reporte, $tipo_actividad, $id_modulo, $id_vehiculo){

                $filtroActualizaciones = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM bitacora_acciones WHERE (fecha_Actividad >= '$fecha_inicial_reporte' AND fecha_actividad <= '$fecha_final_reporte') AND tipo_actividad LIKE '$tipo_actividad' AND id_modulo LIKE '$id_modulo' AND id_registro LIKE '$id_vehiculo' ");

                $sql->execute();

                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $filtroActualizaciones[] = $filas;
                }

                return $filtroActualizaciones;
            }

  }

 ?>