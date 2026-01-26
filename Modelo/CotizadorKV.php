<?php 
require_once("Conexion/conexionBD.php");

class CotizadorKV
{
    /*INICIO USUARIOS*/
    public function iniciar_sesion($usuario,$clave){
        $clave_enc = base64_encode($clave);
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM cotizador_usuario WHERE usuario = ? AND password = ? and estado = 1");
        $sql->bindParam(1, $usuario);
        $sql->bindParam(2, $clave_enc);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }
        return $listar;
    }
    public function listar_usuarios(){
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM cotizador_usuario WHERE id_usuario > 1 order by id_usuario Desc");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }
       return $listar;
    }
    public function listar_usuario_id($id){
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM cotizador_usuario WHERE id_usuario = ?");
        $sql->bindParam(1, $id);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }
        return $listar;
    }
    public function guardar_usuario($usuario,$pass,$nombre,$email,$telefono,$cargo,$estado){
        $pass = base64_encode($pass);
        $con = Conexion::conectar();
        $sql = $con->prepare("INSERT INTO cotizador_usuario (usuario, password, nombre, correo, telefono, cargo, estado) VALUES (:usuario,:pass,:nombre,:email,:telefono,:cargo,:estado)");
        $sql->bindParam(":usuario",$usuario);
        $sql->bindParam(":pass",$pass);
        $sql->bindParam(":nombre",$nombre);
        $sql->bindParam(":email",$email);
        $sql->bindParam(":telefono",$telefono);
        $sql->bindParam(":cargo",$cargo);
        $sql->bindParam(":estado",$estado);
        $sql->execute();
        
        return $con->lastInsertId();
        
    }
    public function editar_usuario($id,$usuario,$pass,$nombre,$email,$telefono,$cargo,$estado){
        $pass = base64_encode($pass);
        $con = Conexion::conectar();
        $sql = $con->prepare("UPDATE cotizador_usuario set usuario = :usuario, password = :pass, nombre = :nombre, correo = :email, telefono = :telefono, cargo = :cargo, estado = :estado WHERE id_usuario = :id");
        $sql->bindParam(":usuario",$usuario);
        $sql->bindParam(":pass",$pass);
        $sql->bindParam(":nombre",$nombre);
        $sql->bindParam(":email",$email);
        $sql->bindParam(":telefono",$telefono);
        $sql->bindParam(":cargo",$cargo);
        $sql->bindParam(":estado",$estado);
        $sql->bindParam(":id",$id);
        $sql->execute();
        
        return $id;
        
    }
    public function bloquear_usuario($id){
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("UPDATE cotizador_usuario SET estado = 0 WHERE id_usuario = ?");
        $sql->bindParam(1, $id);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }
        
        return $listar;
    }
    public function desbloquear_usuario($id){
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("UPDATE cotizador_usuario SET estado = 1 WHERE id_usuario = ?");
        $sql->bindParam(1, $id);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }
        return $listar;
    }
    public function eliminar_usuario($id){
        $con = Conexion::conectar();
        $sql = $con->prepare("DELETE from cotizador_usuario WHERE id_usuario = :id");
        $sql->bindParam(":id",$id);
        $sql->execute();
        
        return $id;
        
    }
    /*FIN USUARIOS*/
    
    /*INICIO EMPRESAS*/
    public function listarEmpresasActivas(){
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM cotizador_empresa WHERE estado = 1 order by id_empresa Desc");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }
       return $listar;
    }
    public function listarEmpresas(){
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM cotizador_empresa order by id_empresa Desc");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }
       return $listar;
    }
    public function listarEmpresaPorId($id){
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM cotizador_empresa WHERE id_empresa = ?");
        $sql->bindParam(1, $id);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }
        return $listar;
    }
    public function guardar_empresa($razon_social, $nit, $direccion, $telefono, $logo, $estado){
        $con = Conexion::conectar();
        $sql = $con->prepare("INSERT INTO cotizador_empresa (razon_social, nit, direccion, telefono, logo, estado) VALUES (:razon_social,:nit,:direccion,:telefono,:logo,:estado);");
        $sql->bindParam(":razon_social",$razon_social);
        $sql->bindParam(":nit",$nit);
        $sql->bindParam(":direccion",$direccion);
        $sql->bindParam(":telefono",$telefono);
        $sql->bindParam(":logo",$logo);
        $sql->bindParam(":estado",$estado);
        $sql->execute();
        
        return $con->lastInsertId();
        
    }
    public function editar_empresa($id,$razon_social, $nit, $direccion, $telefono, $logo, $estado){
        $con = Conexion::conectar();
        $sql = $con->prepare("UPDATE cotizador_empresa set razon_social = :razon_social, nit = :nit, direccion = :direccion, telefono = :telefono, logo = :logo, estado = :estado WHERE id_empresa = :id");
        $sql->bindParam(":razon_social",$razon_social);
        $sql->bindParam(":nit",$nit);
        $sql->bindParam(":direccion",$direccion);
        $sql->bindParam(":telefono",$telefono);
        $sql->bindParam(":logo",$logo);
        $sql->bindParam(":estado",$estado);
        $sql->bindParam(":id",$id);
        $sql->execute();
        
        return $id;
        
    }
    public function bloquear_empresa($id){
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("UPDATE cotizador_empresa SET estado = 0 WHERE id_empresa = ?");
        $sql->bindParam(1, $id);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }
        
        return $listar;
    }
    public function desbloquear_empresa($id){
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("UPDATE cotizador_empresa SET estado = 1 WHERE id_empresa = ?");
        $sql->bindParam(1, $id);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }
        return $listar;
    }
    /*FIN EMPRESAS*/
    
    /*INICIO TARIFA INDIVIDUAL*/
    public function listarTarifaIndividual(){
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM cotizador_tarifa_individual order by id_tarifa Desc");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }
       return $listar;
    }
    public function listarTarifaIndividualPorId($id){
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM cotizador_tarifa_individual WHERE id_tarifa = ?");
        $sql->bindParam(1, $id);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }
        return $listar;
    }
    public function listarValoresIndividualPorCapacidad($pax){
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM cotizador_tarifa_individual WHERE cant_pax = ?");
        $sql->bindParam(1, $pax);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }
        return $listar;
    }
    public function editar_tarifa_individual($id,$valor,$espera,$servicio){
        $con = Conexion::conectar();
        $sql = $con->prepare("UPDATE cotizador_tarifa_individual set precio = :valor, espera = :espera, servicio = :servicio WHERE id_tarifa = :id");
        $sql->bindParam(":valor",$valor);
        $sql->bindParam(":espera",$espera);
        $sql->bindParam(":servicio",$servicio);
        $sql->bindParam(":id",$id);
        $sql->execute();
        
        return $id;
        
    }
    /*FIN TARIFA INDIVIDUAL*/
    
    /*INICIO DESTINOS*/
    public function listar_destinos_activos(){
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT id_destino, nombre FROM cotizador_destinos where estado = '1' order by nombre Asc");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }
       return $listar;
    }
    public function listarDestinos(){
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM cotizador_destinos order by id_destino Desc");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }
       return $listar;
    }
    public function listarDestinoPorId($id){
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM cotizador_destinos WHERE id_destino = ?");
        $sql->bindParam(1, $id);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }
        return $listar;
    }
    public function guardar_destino($nombre, $kms, $dias_viaje, $valor4, $valor19, $valor24, $valor30, $valor40, $valor45, $cant_peajes, $estado){
        $con = Conexion::conectar();
        $sql = $con->prepare("INSERT INTO cotizador_destinos (nombre, kms, dias_viaje, valor_4_pax, valor_19_pax, valor_24_pax, valor_30_pax, valor_40_pax, valor_45_pax, cant_peajes, estado) VALUES (:nombre,:kms,:dias_viaje,:valor4,:valor19,:valor24,:valor30,:valor40,:valor45,:cant_peajes,:estado);");
        $sql->bindParam(":nombre",$nombre);
        $sql->bindParam(":kms",$kms);
        $sql->bindParam(":dias_viaje",$dias_viaje);
        $sql->bindParam(":valor4",$valor4);
        $sql->bindParam(":valor19",$valor19);
        $sql->bindParam(":valor24",$valor24);
        $sql->bindParam(":valor30",$valor30);
        $sql->bindParam(":valor40",$valor40);
        $sql->bindParam(":valor45",$valor45);
        $sql->bindParam(":cant_peajes",$cant_peajes);
        $sql->bindParam(":estado",$estado);
        $sql->execute();
        
        return $con->lastInsertId();
        
    }
    public function editar_destino($id,$nombre, $kms, $dias_viaje, $valor4, $valor19, $valor24, $valor30, $valor40, $valor45, $cant_peajes, $estado){
        $con = Conexion::conectar();
        $sql = $con->prepare("UPDATE cotizador_destinos set nombre = :nombre, kms = :kms, dias_viaje = :dias_viaje, valor_4_pax = :valor4, valor_19_pax = :valor19, valor_24_pax = :valor24, valor_30_pax = :valor30, valor_40_pax = :valor40, valor_45_pax = :valor45, cant_peajes = :cant_peajes, estado = :estado WHERE id_destino = :id");
        $sql->bindParam(":nombre",$nombre);
        $sql->bindParam(":kms",$kms);
        $sql->bindParam(":dias_viaje",$dias_viaje);
        $sql->bindParam(":valor4",$valor4);
        $sql->bindParam(":valor19",$valor19);
        $sql->bindParam(":valor24",$valor24);
        $sql->bindParam(":valor30",$valor30);
        $sql->bindParam(":valor40",$valor40);
        $sql->bindParam(":valor45",$valor45);
        $sql->bindParam(":cant_peajes",$cant_peajes);
        $sql->bindParam(":estado",$estado);
        $sql->bindParam(":id",$id);
        $sql->execute();
        
        return $id;
        
    }
    public function bloquear_destino($id){
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("UPDATE cotizador_destinos SET estado = 0 WHERE id_destino = ?");
        $sql->bindParam(1, $id);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }
        
        return $listar;
    }
    public function desbloquear_destino($id){
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("UPDATE cotizador_destinos SET estado = 1 WHERE id_destino = ?");
        $sql->bindParam(1, $id);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }
        return $listar;
    }
    /*FIN DESTINOS*/
    
    /*INICIO DESCUENTOS*/
    public function listarDescuentos(){
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM cotizador_descuento order by valor Asc");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }
       return $listar;
    }
    public function listar_descuentos(){
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT valor FROM cotizador_descuento order by valor Asc");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }
       return $listar;
    }
    public function listarDescuentoPorId($id){
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM cotizador_descuento WHERE id_descuento = ?");
        $sql->bindParam(1, $id);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }
        return $listar;
    }
    public function guardar_descuento($valor){
        $con = Conexion::conectar();
        $sql = $con->prepare("INSERT INTO cotizador_descuento (valor) values (:valor)");
        $sql->bindParam(":valor",$valor);
        $sql->execute();
        
        return $con->lastInsertId();
        
    }
    public function editar_descuento($id,$valor){
        $con = Conexion::conectar();
        $sql = $con->prepare("UPDATE cotizador_descuento set valor = :valor WHERE id_descuento = :id");
        $sql->bindParam(":valor",$valor);
        $sql->bindParam(":id",$id);
        $sql->execute();
        
        return $id;
        
    }
    public function eliminar_descuento($id){
        $con = Conexion::conectar();
        $sql = $con->prepare("DELETE from cotizador_descuento WHERE id_descuento = :id");
        $sql->bindParam(":id",$id);
        $sql->execute();
        
        return $id;
        
    }
    /*FIN DESCUENTOS*/
    
    /*INICIO COTIZACIONES*/
    public function listar_cotizaciones(){
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM cotizador_cotizacion order by id_cotizacion Desc");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }
       return $listar;
    }
    public function guardar_cotizacion($fecha,$usuario,$empresa,$nom_cliente,$id_cliente,$dir_cliente,$tel_cliente,$email_cliente,$contacto,$destino,$dias_servicio_destino,$kms,$peajes,$dias_espera,$valor_espera,$dias_servicio,$valor_servicio,$pax,$valor_parcial,$descuento,$valor_desc,$valor_final,$observaciones,$pdf){
        $con = Conexion::conectar();
        $sql = $con->prepare("INSERT INTO cotizador_cotizacion (fecha_creacion, id_creador, id_empresa, nombre_cliente, ident_cliente, dir_cliente, tel_cliente, email_cliente, contacto_cliente, destino, dias_servicio, kms, cant_peajes, dia_espera, valor_espera, dia_servicio, valor_servicio, cant_pax, valor_estandar, descuento, valor_descuento, valor_final, observaciones, pdf) VALUES (:fecha,:usuario,:empresa,:nom_cliente,:id_cliente,:dir_cliente,:tel_cliente,:email_cliente,:contacto,:destino,:dias_servicio_destino,:kms,:peajes,:dias_espera,:valor_espera,:dias_servicio,:valor_servicio,:pax,:valor_parcial,:descuento,:valor_desc,:valor_final,:observaciones,:pdf);");
        $sql->bindParam(":fecha",$fecha);
        $sql->bindParam(":usuario",$usuario);
        $sql->bindParam(":empresa",$empresa);
        $sql->bindParam(":nom_cliente",$nom_cliente);
        $sql->bindParam(":id_cliente",$id_cliente);
        $sql->bindParam(":dir_cliente",$dir_cliente);
        $sql->bindParam(":tel_cliente",$tel_cliente);
        $sql->bindParam(":email_cliente",$email_cliente);
        $sql->bindParam(":contacto",$contacto);
        $sql->bindParam(":destino",$destino);
        $sql->bindParam(":dias_servicio_destino",$dias_servicio_destino);
        $sql->bindParam(":kms",$kms);
        $sql->bindParam(":peajes",$peajes);
        $sql->bindParam(":dias_espera",$dias_espera);
        $sql->bindParam(":valor_espera",$valor_espera);
        $sql->bindParam(":dias_servicio",$dias_servicio);
        $sql->bindParam(":valor_servicio",$valor_servicio);
        $sql->bindParam(":pax",$pax);
        $sql->bindParam(":valor_parcial",$valor_parcial);
        $sql->bindParam(":descuento",$descuento);
        $sql->bindParam(":valor_desc",$valor_desc);
        $sql->bindParam(":valor_final",$valor_final);
        $sql->bindParam(":observaciones",$observaciones);
        $sql->bindParam(":pdf",$pdf);
        $sql->execute();
        
        return $con->lastInsertId();
        
    }
    public function listarCotizacionPorId($id){
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM cotizador_cotizacion WHERE id_cotizacion = ?");
        $sql->bindParam(1, $id);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }
        return $listar;
    }
    public function buscarClientePorNit($nit){
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT nombre_cliente, ident_cliente, dir_cliente, tel_cliente, email_cliente, contacto_cliente FROM cotizador_cotizacion WHERE ident_cliente = ? order by id_cotizacion limit 1");
        $sql->bindParam(1, $nit);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }
        return $listar;
    }
    /*FIN COTIZACIONES*/
    
    /*INICIO PAGINAS*/
    public function buscarPaginas($empresa){
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM cotizador_paginas_formato WHERE id_empresa = ? order by id_pag Asc");
        $sql->bindParam(1, $empresa);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }
        return $listar;
    }
    /*FIN PAGINAS*/

}

?>