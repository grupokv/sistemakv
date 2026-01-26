<?php
require_once "../Modelo/Vehiculo.php";
require_once "../Modelo/Usuario.php";
require_once "../Modelo/EmpresaEnt.php";
require_once "../Modelo/TipoVehiculo.php";
require_once "../Modelo/TipoServicio.php";

$id_vehiculo = $_POST['id_vehiculo'];

$vehiculo = new Vehiculo();
$usuario = new Usuario();
$empresa = new Empresa();
$tipovehiculo = new TipoVehiculo();
$tiposervicio = new TipoServicio();
$listarVehId = $vehiculo->listarPorId($id_vehiculo);
$cant = count($listarVehId);
$datospropietario = $usuario->listarUsuarioPorId($listarVehId[0]['id_propietario']);

$html = '<table class="table table-sm display table-condensed table-bordered table-hover" style="width:100%">';
    if($cant > 0){
        
        $html .= '<tr><th colspan="3" align="center"><strong>DATOS DEL PROPIETARIO</strong></th></tr>';
        
        $html .= '<tr>';
        $html .= '<td><strong>NUM DOCUMENTO</strong></td>';
        $html .= '<td><strong>NOMBRE</strong></td>';
        $html .= '<td><strong>CORREO ELECTRONICO</strong></td>';
        $html .= '</tr>';
        
        $html .= '<tr>';
        $html .= '<td>'.$datospropietario[0]['usuario'].'</td>';
        $html .= '<td>'.$datospropietario[0]['nombre'].'</td>';
        $html .= '<td>'.$datospropietario[0]['correo_electronico'].'</td>';
        $html .= '</tr>';
        
        $html .= '<tr>';
        $html .= '<td><strong>TELEFONO</strong></td>';
        $html .= '<td><strong>DIRECCION</strong></td>';
        $html .= '<td><strong>CIUDAD</strong></td>';
        $html .= '</tr>';
        
        $html .= '<tr>';
        $html .= '<td>'.$listarVehId[0]['telefono_propietario'].'</td>';
        $html .= '<td>'.$listarVehId[0]['direccion_propietario'].'</td>';
        $html .= '<td>'.$listarVehId[0]['ciudad_propietario'].'</td>';
        $html .= '</tr>';
        $html .= '</table>';
        
        $html .= '<table class="table table-sm display table-condensed table-bordered table-hover" style="width:100%">';
        
        $html .= '<tr><th colspan="4" align="center"><strong>DATOS DEL VEHICULO</strong></th></tr>';
        
        $html .= '<tr>';
        $html .= '<td><strong>PLACA</strong></td>';
        $html .= '<td><strong>MODELO</strong></td>';
        $html .= '<td><strong>MARCA</strong></td>';
        $html .= '<td><strong>CANT PASAJEROS</strong></td>';
        $html .= '</tr>';
        
        $html .= '<tr>';
        $html .= '<td>'.$listarVehId[0]['placa'].'</td>';
        $html .= '<td>'.$listarVehId[0]['modelo'].'</td>';
        $html .= '<td>'.$listarVehId[0]['marca'].'</td>';
        $html .= '<td>'.$listarVehId[0]['cant_pasajeros'].'</td>';
        $html .= '</tr>';
        
        $html .= '<tr>';
        $html .= '<td><strong>TIPO SERVICIO</strong></td>';
        $html .= '<td><strong>TIPO VEHICULO</strong></td>';
        $html .= '<td><strong>NUMERO MOVIL</strong></td>';
        $html .= '<td><strong>NUM TARJETA OPERACION</strong></td>';
        $html .= '</tr>';
        
        $html .= '<tr>';
        $datos_serv = $tiposervicio->listarPorId($listarVehId[0]['id_tipo_servicio']);
        $html .= '<td>'.$datos_serv[0]['nombre_tipo_servicio'].'</td>';
        $datos_tipo = $tipovehiculo->listarPorId($listarVehId[0]['id_tipo_vehiculo']);
        $html .= '<td>'.$datos_tipo[0]['nombre_tipo_vehiculo'].'</td>';
        $html .= '<td>'.$listarVehId[0]['numero_movil'].'</td>';
        $html .= '<td>'.$listarVehId[0]['num_tarjeta_operacion'].'</td>';
        $html .= '</tr>';
        
        $html .= '<tr>';
        $html .= '<td><strong>NUM LICENCIA</strong></td>';
        $html .= '<td><strong>TIPO AFILIACION</strong></td>';
        $html .= '<td><strong>EMPRESA AFILIADA</strong></td>';
        $html .= '<td><strong>NIT EMPRESA</strong></td>';
        $html .= '</tr>';
        
        $html .= '<tr>';
        $html .= '<td>'.$listarVehId[0]['num_licencia_transito'].'</td>';
        $html .= '<td>'.$listarVehId[0]['tipo_afiliacion'].'</td>';
        $html .= '<td>'.$listarVehId[0]['empresa_afiliada'].'</td>';
        $html .= '<td>'.$listarVehId[0]['nit_empresa_afiliada'].'</td>';
        $html .= '</tr>';
        
        $html .= '<tr>';
        $html .= '<td><strong>TARJETA OPERACION</strong></td>';
        $html .= '<td><strong>FECHA VENC. TARJETA</strong></td>';
        $html .= '<td><strong>LICENCIA TRANSITO</strong></td>';
        $html .= '<td><strong>FECHA VENC. LICENCIA</strong></td>';
        $html .= '</tr>';
        
        $html .= '<tr>';
        $html .= '<td><a href="../Documentos/Vehiculos/'.$listarVehId[0]['placa'].'/'.$listarVehId[0]['tarjeta_operacion'].'" target="_blank">'.$listarVehId[0]['tarjeta_operacion'].'</a></td>';
        $html .= '<td>'.$listarVehId[0]['fecha_vencimiento_to'].'</td>';
        $html .= '<td><a href="../Documentos/Vehiculos/'.$listarVehId[0]['placa'].'/'.$listarVehId[0]['licencia_transito'].'" target="_blank">'.$listarVehId[0]['licencia_transito'].'</a></td>';
        $html .= '<td>'.$listarVehId[0]['fecha_vencimiento_lt'].'</td>';
        $html .= '</tr>';
        
        $html .= '<tr>';
        $html .= '<td><strong>POLIZA CONTRACTUAL</strong></td>';
        $html .= '<td><strong>NUM POLIZA CONTRACTUAL</strong></td>';
        $html .= '<td><strong>FECHA VENC. CONTRACTUAL</strong></td>';
        $html .= '<td><strong>POLIZA EXTRA</strong></td>';
        $html .= '</tr>';
        
        $html .= '<tr>';
        $html .= '<td><a href="../Documentos/Vehiculos/'.$listarVehId[0]['placa'].'/'.$listarVehId[0]['poliza_contra'].'" target="_blank">'.$listarVehId[0]['poliza_contra'].'</a></td>';
        $html .= '<td>'.$listarVehId[0]['num_poliza_contra'].'</td>';
        $html .= '<td>'.$listarVehId[0]['fecha_vencimiento_contra'].'</td>';
        $html .= '<td><a href="../Documentos/Vehiculos/'.$listarVehId[0]['placa'].'/'.$listarVehId[0]['poliza_extra'].'" target="_blank">'.$listarVehId[0]['poliza_extra'].'</a></td>';
        $html .= '</tr>';
        
        $html .= '<tr>';
        $html .= '<td><strong>NUM POLIZA EXTRA</strong></td>';
        $html .= '<td><strong>FECHA VENC. EXTRA</strong></td>';
        $html .= '<td><strong>FLOTA PROPIA</strong></td>';
        $html .= '<td><strong>EMPRESA</strong></td>';
        $html .= '</tr>';
        
        $html .= '<tr>';
        $html .= '<td>'.$listarVehId[0]['num_poliza_extra'].'</td>';
        $html .= '<td>'.$listarVehId[0]['fecha_vencimiento_extra'].'</td>';
        $html .= '<td>'.$listarVehId[0]['flota_propia'].'</td>';
        if($listarVehId[0]['id_empresa'] != 0){ 
            $datos_emp = $empresa->listarPorId($listarVehId[0]['id_empresa']);
            $det_empresa = $datos_emp[0]['nombre_empresa'];
        } else {
            $det_empresa = '';
        }
        $html .= '<td>'.$det_empresa.'</td>';
        $html .= '</tr>';
        
    }else{
            $html .= '<tr><td><p class="text-center"><strong>SIN INFORMACION</strong></p></td></tr>';
    } 

$html .= '</table>';

echo $html;

?>