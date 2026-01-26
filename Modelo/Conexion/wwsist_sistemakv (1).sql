-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 26, 2026 at 02:51 PM
-- Server version: 5.7.44
-- PHP Version: 8.1.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wwsist_sistemakv`
--

-- --------------------------------------------------------

--
-- Table structure for table `actas`
--

CREATE TABLE `actas` (
  `id_acta` int(11) NOT NULL,
  `cliente` varchar(500) NOT NULL,
  `empresa` int(11) NOT NULL,
  `nombre_acta` varchar(500) NOT NULL,
  `fecha_reunion` date NOT NULL,
  `hora_inicial_acta` time NOT NULL,
  `hora_final_acta` time NOT NULL,
  `id_responsable` int(11) NOT NULL,
  `fecha_hora_creacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `acta_agenda`
--

CREATE TABLE `acta_agenda` (
  `id_agenda` int(11) NOT NULL,
  `id_acta` int(11) NOT NULL,
  `nombre_tema` longtext NOT NULL,
  `descripcion_tema` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `acta_estado_situacion`
--

CREATE TABLE `acta_estado_situacion` (
  `id_estado` int(11) NOT NULL,
  `detalle` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `acta_invitados`
--

CREATE TABLE `acta_invitados` (
  `id_invitado` int(11) NOT NULL,
  `nombre_usuario_externo` varchar(100) DEFAULT NULL,
  `numero_documento_externo` varchar(20) DEFAULT NULL,
  `proveniente_de` varchar(500) DEFAULT NULL,
  `id_usuario_interno` int(11) NOT NULL,
  `id_acta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `acta_situaciones`
--

CREATE TABLE `acta_situaciones` (
  `id_situacion` int(11) NOT NULL,
  `id_acta` int(11) NOT NULL,
  `descripcion_situacion` varchar(1000) NOT NULL,
  `solucion_situacion` varchar(1000) NOT NULL,
  `estado_solucion` int(11) DEFAULT NULL,
  `id_responsable` varchar(100) NOT NULL,
  `id_reportar_a` int(11) NOT NULL,
  `fecha_limite` date NOT NULL,
  `prioridad` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `acuerdos_pago`
--

CREATE TABLE `acuerdos_pago` (
  `id` int(11) NOT NULL,
  `zona_nomina` text NOT NULL,
  `mes` text NOT NULL,
  `tipo_servicio` varchar(100) NOT NULL,
  `cc_propietario` int(11) NOT NULL,
  `propietario` varchar(1000) NOT NULL,
  `conductor` varchar(1000) NOT NULL,
  `placa` varchar(10) NOT NULL,
  `tipo_vehiculo` varchar(1000) NOT NULL,
  `ciudad_servicio` varchar(1000) DEFAULT NULL,
  `tarifa_mensual` int(11) DEFAULT NULL,
  `base_ss` int(11) DEFAULT NULL,
  `dias_laborados_contrato` int(11) DEFAULT NULL,
  `dias_adicionales_dominicales` int(11) DEFAULT NULL,
  `servicios_adicionales` int(11) DEFAULT NULL,
  `adicionales_fuera_ciudad` int(11) DEFAULT NULL,
  `horas_adicionales` int(11) DEFAULT NULL,
  `total_horas_adicionales` int(11) DEFAULT NULL,
  `base_descuentos` int(11) DEFAULT NULL,
  `porcentaje_retefuente` varchar(11) DEFAULT NULL,
  `retefuente` int(11) DEFAULT NULL,
  `porcentaje_ica` varchar(11) DEFAULT NULL,
  `reteica` int(11) DEFAULT NULL,
  `otros_descuentos` int(11) DEFAULT NULL,
  `total_descuentos` int(11) DEFAULT NULL,
  `peajes` int(11) DEFAULT NULL,
  `parqueadero` int(11) DEFAULT NULL,
  `cant_pernotadas` int(11) DEFAULT NULL,
  `pernotadas` int(11) DEFAULT NULL,
  `total_reembolsables` int(11) DEFAULT NULL,
  `total_pagar` int(11) DEFAULT NULL,
  `estado` varchar(100) DEFAULT NULL,
  `observaciones` longtext
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `acuerdos_pago_cobro`
--

CREATE TABLE `acuerdos_pago_cobro` (
  `id_acuerdo` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `valor` int(11) NOT NULL,
  `fecha_pago` date NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_acuerdo` datetime NOT NULL,
  `doc_firmado` varchar(1000) DEFAULT NULL,
  `estado` int(11) NOT NULL,
  `fecha_cambio_estado` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `afiliados`
--

CREATE TABLE `afiliados` (
  `id` int(10) NOT NULL,
  `fechaenvio` varchar(15) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `cargo` varchar(100) NOT NULL,
  `emailcorp` varchar(100) NOT NULL,
  `telefono` varchar(25) NOT NULL,
  `placa` varchar(25) NOT NULL,
  `nombrep` varchar(100) NOT NULL,
  `emailp` varchar(100) NOT NULL,
  `telefono1` varchar(25) NOT NULL,
  `telefono2` varchar(25) NOT NULL,
  `cedula` varchar(25) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `tipologia` varchar(100) NOT NULL,
  `linea` varchar(100) NOT NULL,
  `cilindraje` varchar(25) NOT NULL,
  `empresaorigen` varchar(100) NOT NULL,
  `valorafiliacion` varchar(100) NOT NULL,
  `metodopago` varchar(100) NOT NULL,
  `abono1` varchar(100) NOT NULL,
  `fechapago` varchar(100) NOT NULL,
  `pregunta1` varchar(25) NOT NULL,
  `pregunta2` varchar(25) NOT NULL,
  `pregunta3` varchar(25) NOT NULL,
  `pregunta4` varchar(25) NOT NULL,
  `pregunta5` varchar(25) NOT NULL,
  `pregunta6` varchar(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `anticipo_cartera`
--

CREATE TABLE `anticipo_cartera` (
  `id_anticipo` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `valor_anticipo` int(11) NOT NULL,
  `num_id_comprobante` varchar(100) NOT NULL,
  `id_concepto` int(11) NOT NULL,
  `fecha_inicial_valido` date NOT NULL,
  `fecha_final_valido` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `aprobacion_fuec`
--

CREATE TABLE `aprobacion_fuec` (
  `id` int(11) NOT NULL,
  `num_aprobacion` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `cod_ciudad` varchar(10) NOT NULL,
  `id_empresa` double NOT NULL,
  `firma_fuec` varchar(100) NOT NULL,
  `estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id_area` int(11) NOT NULL,
  `nombre_area` varchar(50) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `estado_area` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `asignaciones`
--

CREATE TABLE `asignaciones` (
  `id_asignacion` int(11) NOT NULL,
  `id_servicio` int(11) NOT NULL,
  `id_contrato` int(11) DEFAULT NULL,
  `id_proyecto` int(11) DEFAULT NULL,
  `id_tarifa_proyecto` int(11) DEFAULT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `id_conductor` int(11) NOT NULL,
  `estado` char(1) NOT NULL,
  `fecha_asignacion` datetime NOT NULL,
  `tipo_asignacion` char(2) NOT NULL,
  `costo` double NOT NULL,
  `seguimiento_pre` longtext,
  `id_usuario_seg_pre` int(11) DEFAULT NULL,
  `fecha_seg_pre` datetime DEFAULT NULL,
  `seguimiento_pos` longtext,
  `id_usuario_seg_pos` int(11) DEFAULT NULL,
  `fecha_seg_pos` datetime DEFAULT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `kms_inicio` double DEFAULT NULL,
  `fecha_final` datetime DEFAULT NULL,
  `kms_final` double DEFAULT NULL,
  `combustible` char(1) DEFAULT NULL,
  `galones_combustible` varchar(20) DEFAULT NULL,
  `valor_total_combustible` int(11) DEFAULT NULL,
  `peajes` char(20) DEFAULT NULL,
  `cant_peajes` varchar(20) DEFAULT NULL,
  `valor_total_peajes` varchar(20) DEFAULT NULL,
  `soportes_peajes` json DEFAULT NULL,
  `parqueadero` char(1) DEFAULT NULL,
  `valor_total_parqueadero` varchar(20) DEFAULT NULL,
  `pernoctada` char(1) DEFAULT NULL,
  `valor_total_pernoctada` varchar(20) DEFAULT NULL,
  `funcionario_transportado` varchar(100) DEFAULT NULL,
  `estado_adicionales` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `aval_vehiculos`
--

CREATE TABLE `aval_vehiculos` (
  `id_aval` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `id_contrato` int(11) NOT NULL,
  `valor` int(11) NOT NULL,
  `estado` varchar(100) NOT NULL COMMENT 'A - Activo | F - Finalizado | E - Eximido | I - Inactivo',
  `mes` int(11) NOT NULL,
  `anio` int(11) NOT NULL,
  `fecha_activacion` date NOT NULL,
  `id_usuario_activacion` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `base_servicios`
--

CREATE TABLE `base_servicios` (
  `id_servicio_base` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_contrato` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `division_cliente` text,
  `tipo_servicio` varchar(100) NOT NULL,
  `grupo` text,
  `solicitante` text,
  `fecha_inicio` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `origen` text NOT NULL,
  `destino` text NOT NULL,
  `fecha_final` date NOT NULL,
  `hora_final` time NOT NULL,
  `observaciones` longtext,
  `requisitos` longtext,
  `estado_servicio` varchar(100) NOT NULL COMMENT 'A = ACTIVO |-| I = INHABILITADO O ANULADO |-| PA = PENDIENTE ASIGNACIÓN |-| E= ELIMINADO',
  `novedad` longtext,
  `id_usuario_creador` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `base_servicio_vehiculos`
--

CREATE TABLE `base_servicio_vehiculos` (
  `id` int(11) NOT NULL,
  `id_servicio` int(11) NOT NULL,
  `servicio` json DEFAULT NULL,
  `clase_vehiculo` json DEFAULT NULL,
  `id_vehiculo` json DEFAULT NULL,
  `id_conductor` json DEFAULT NULL,
  `id_vehiculo_relevo` json DEFAULT NULL,
  `cant_pasajeros` json DEFAULT NULL,
  `kms` json DEFAULT NULL,
  `valor_cliente` json DEFAULT NULL,
  `descuento_cliente` json DEFAULT NULL,
  `valor_movil` json DEFAULT NULL,
  `descuento_movil` json DEFAULT NULL,
  `disp` json DEFAULT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bitacora_acciones`
--

CREATE TABLE `bitacora_acciones` (
  `id_bitacora` int(11) NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `id_registro` int(11) NOT NULL,
  `tipo_actividad` varchar(100) NOT NULL,
  `columnas_modulo` longtext NOT NULL,
  `valores_antiguos` longtext NOT NULL,
  `valores_nuevos` longtext NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_actividad` date NOT NULL,
  `hora_actividad` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bitacora_transacciones`
--

CREATE TABLE `bitacora_transacciones` (
  `id_transaccion` int(11) NOT NULL,
  `referencia` varchar(50) NOT NULL,
  `requestID` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `data` json NOT NULL,
  `fecha` datetime NOT NULL,
  `estado` varchar(100) DEFAULT NULL,
  `resultado` json DEFAULT NULL,
  `extraGeneralInfo` json DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cargos`
--

CREATE TABLE `cargos` (
  `id_cargo` int(11) NOT NULL,
  `nombre_cargo` varchar(50) NOT NULL,
  `id_area` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cargo_cliente`
--

CREATE TABLE `cargo_cliente` (
  `id_cargo` int(11) NOT NULL,
  `detalle` varchar(250) NOT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `categoria_mantenimiento`
--

CREATE TABLE `categoria_mantenimiento` (
  `id_categoria` int(11) NOT NULL,
  `detalle_categoria` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `centro_costo_cliente`
--

CREATE TABLE `centro_costo_cliente` (
  `id_centro_costo` int(11) NOT NULL,
  `detalle` varchar(250) NOT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ciudades`
--

CREATE TABLE `ciudades` (
  `id_ciudad` int(11) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `id_pais` int(11) NOT NULL,
  `ciudad` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ciudades_fuec`
--

CREATE TABLE `ciudades_fuec` (
  `id` double NOT NULL,
  `ciudad` longtext NOT NULL,
  `codigo` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clases_movil_cliente`
--

CREATE TABLE `clases_movil_cliente` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `clase_movil_producto` text NOT NULL,
  `capacidad` int(11) NOT NULL,
  `id_tipo_vehiculo` int(11) NOT NULL,
  `observaciones` longtext,
  `estado` varchar(100) NOT NULL,
  `id_usuario_creacion` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `razon_social` varchar(1000) NOT NULL,
  `sigla` varchar(100) DEFAULT NULL,
  `nit_cliente` varchar(1000) NOT NULL,
  `direccionC` varchar(1000) NOT NULL,
  `correo_electronico` text,
  `telefonoC` varchar(1000) NOT NULL,
  `representante_legalC` varchar(1000) NOT NULL,
  `ciudad_residencia_rl` int(11) DEFAULT '0',
  `numero_documentoC` varchar(50) NOT NULL,
  `fecha_expedicionC` date DEFAULT '0000-00-00',
  `lugar_expedicionC` int(11) DEFAULT '0',
  `id_ciudad` int(11) DEFAULT NULL,
  `id_departamento` int(11) DEFAULT NULL,
  `id_pais` int(11) DEFAULT NULL,
  `id_segmento` int(11) DEFAULT NULL,
  `estado` int(1) DEFAULT NULL,
  `logo_cliente` varchar(200) DEFAULT NULL,
  `id_usuario_registro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clientesConvenio_vehiculos`
--

CREATE TABLE `clientesConvenio_vehiculos` (
  `id` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clientes_convenios`
--

CREATE TABLE `clientes_convenios` (
  `id_cliente` int(11) NOT NULL,
  `razon_social` varchar(1000) NOT NULL,
  `nit_cliente` varchar(1000) NOT NULL,
  `direccionC` varchar(1000) DEFAULT NULL,
  `telefonoC` varchar(1000) DEFAULT NULL,
  `representante_legalC` varchar(1000) DEFAULT NULL,
  `ciudad_residencia_rl` int(11) DEFAULT NULL,
  `numero_documentoC` varchar(50) DEFAULT NULL,
  `fecha_expedicionC` date DEFAULT NULL,
  `lugar_expedicionC` int(11) DEFAULT NULL,
  `id_ciudad` int(11) DEFAULT NULL,
  `id_departamento` int(11) DEFAULT NULL,
  `id_pais` int(11) DEFAULT NULL,
  `estado` int(1) DEFAULT NULL,
  `firma_empresa` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clientes_propietarios`
--

CREATE TABLE `clientes_propietarios` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cliente_prospecto`
--

CREATE TABLE `cliente_prospecto` (
  `id_prospecto` int(11) NOT NULL,
  `razon_social` varchar(500) NOT NULL,
  `nit` varchar(50) NOT NULL,
  `direccion` longtext NOT NULL,
  `telefono` varchar(100) NOT NULL,
  `status` int(1) NOT NULL,
  `volumen_venta` int(1) NOT NULL,
  `frecuencia_compra` int(1) NOT NULL,
  `estado` int(1) NOT NULL,
  `usuario_creador` int(1) NOT NULL,
  `fecha_creacion` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cobro_cartera`
--

CREATE TABLE `cobro_cartera` (
  `id` int(11) NOT NULL,
  `id_vehiculo` int(10) NOT NULL,
  `num_movil` varchar(10) NOT NULL,
  `placa` varchar(10) NOT NULL,
  `saldo_30_dias` int(11) DEFAULT '0',
  `saldo_60_dias` int(11) DEFAULT '0',
  `saldo_90_dias` int(11) DEFAULT '0',
  `saldo_mayor_90_dias` int(11) DEFAULT '0',
  `total` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cobro_propietario`
--

CREATE TABLE `cobro_propietario` (
  `id_cobro` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `id_concepto` int(11) NOT NULL,
  `valor` double NOT NULL,
  `estado` char(1) NOT NULL,
  `fecha_cobro` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cobro_tipo_vehiculo`
--

CREATE TABLE `cobro_tipo_vehiculo` (
  `id` int(11) NOT NULL,
  `id_concepto` int(11) NOT NULL,
  `id_tipo_vehiculo` int(11) NOT NULL,
  `valor` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comprobantes_cobro_cartera`
--

CREATE TABLE `comprobantes_cobro_cartera` (
  `id_comprobante` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `fecha_pago` date NOT NULL,
  `valor` int(11) NOT NULL,
  `archivo` varchar(1000) NOT NULL,
  `id_acuerdo` int(11) NOT NULL,
  `fecha_carga` datetime NOT NULL,
  `usuario_carga` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `usuario_aceptacion` int(11) DEFAULT NULL,
  `fecha_aceptacion` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comprobantes_pagos_propietarios`
--

CREATE TABLE `comprobantes_pagos_propietarios` (
  `id_comprobante` int(11) NOT NULL,
  `id_cobro_propietario` int(11) NOT NULL,
  `valor_servicio` double NOT NULL,
  `fecha_pago` date NOT NULL,
  `valor_pagado` double NOT NULL,
  `banco_consignacion` int(11) DEFAULT NULL,
  `num_id_comprobante` varchar(50) NOT NULL,
  `comprobante_pago` varchar(1000) DEFAULT NULL,
  `referencia_transaccion` varchar(100) DEFAULT NULL,
  `detalle` varchar(1000) DEFAULT NULL,
  `fecha_registro_comprobante` datetime NOT NULL,
  `usuario_registro` int(11) NOT NULL,
  `estado` char(1) DEFAULT NULL,
  `novedad` varchar(1000) DEFAULT NULL,
  `revisado_por` int(11) DEFAULT NULL,
  `fecha_revision` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `conceptos_cobro`
--

CREATE TABLE `conceptos_cobro` (
  `id_concepto` int(11) NOT NULL,
  `detalle_concepto` varchar(500) NOT NULL,
  `cuenta_puc` int(11) NOT NULL,
  `contra_cuenta_puc` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `frecuencia` char(1) NOT NULL,
  `siguiente_fecha` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `conductores`
--

CREATE TABLE `conductores` (
  `id_conductor` int(11) NOT NULL,
  `nombre_conductor` varchar(100) NOT NULL,
  `numero_documento_conductor` varchar(15) NOT NULL,
  `correo_electronico` varchar(250) DEFAULT NULL,
  `fecha_nacimiento_conductor` date NOT NULL,
  `fotocopia_documento` text NOT NULL,
  `fotocopia_licencia` text NOT NULL,
  `categoria_licencia` varchar(10) NOT NULL,
  `num_licencia` varchar(100) NOT NULL,
  `fecha_vencimiento_licencia` date NOT NULL,
  `direccion` varchar(500) NOT NULL,
  `genero` varchar(15) NOT NULL,
  `grupo_sanguineo` varchar(5) NOT NULL,
  `estado_civil` varchar(15) NOT NULL,
  `telefono1` varchar(15) NOT NULL,
  `telefono2` varchar(15) DEFAULT NULL,
  `telefono3` varchar(15) DEFAULT NULL,
  `pago_pactado` double NOT NULL,
  `certificados_laborales` varchar(500) DEFAULT NULL,
  `certificados_estudios` varchar(500) DEFAULT NULL,
  `certificados_cursos` varchar(500) NOT NULL,
  `libreta_militar` varchar(500) DEFAULT NULL,
  `examen_medico` varchar(500) DEFAULT NULL,
  `fecha_expedicion_examen_medico` date NOT NULL,
  `planilla_ss` varchar(500) DEFAULT NULL,
  `fotografia_conductor` text NOT NULL,
  `hoja_vida` varchar(500) DEFAULT NULL,
  `procuraduria` varchar(500) DEFAULT NULL,
  `fecha_procuraduria` date DEFAULT NULL,
  `contraloria` varchar(500) DEFAULT NULL,
  `fecha_contraloria` date DEFAULT NULL,
  `personeria` varchar(500) DEFAULT NULL,
  `fecha_personeria` date DEFAULT NULL,
  `simit` varchar(500) DEFAULT NULL,
  `fecha_simit` date DEFAULT NULL,
  `policia` varchar(500) DEFAULT NULL,
  `fecha_policia` date DEFAULT NULL,
  `rut` varchar(100) DEFAULT NULL,
  `vacunas` varchar(100) DEFAULT NULL,
  `contrato_trabajo` varchar(100) DEFAULT NULL,
  `fecha_contrato` date DEFAULT NULL,
  `estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `conductor_seg_social`
--

CREATE TABLE `conductor_seg_social` (
  `id` int(11) NOT NULL,
  `id_conductor` int(11) NOT NULL,
  `anno` double NOT NULL,
  `enero` varchar(100) DEFAULT NULL,
  `febrero` varchar(100) DEFAULT NULL,
  `marzo` varchar(100) DEFAULT NULL,
  `abril` varchar(100) DEFAULT NULL,
  `mayo` varchar(100) DEFAULT NULL,
  `junio` varchar(100) DEFAULT NULL,
  `julio` varchar(100) DEFAULT NULL,
  `agosto` varchar(100) DEFAULT NULL,
  `septiembre` varchar(100) DEFAULT NULL,
  `octubre` varchar(100) DEFAULT NULL,
  `noviembre` varchar(100) DEFAULT NULL,
  `diciembre` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contacto_cliente`
--

CREATE TABLE `contacto_cliente` (
  `id_contacto` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(500) NOT NULL,
  `cargo` varchar(500) NOT NULL,
  `telefono` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `estado` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contratos`
--

CREATE TABLE `contratos` (
  `id_contrato` int(11) NOT NULL,
  `numero_contrato` varchar(50) NOT NULL,
  `id_tipo_contrato` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `objeto_contrato` longtext NOT NULL,
  `fecha_inicial_contrato` date NOT NULL,
  `fecha_final_contrato` date NOT NULL,
  `fecha_creacion_contrato` date NOT NULL,
  `hora_creacion_contrato` time NOT NULL,
  `id_ciudad` int(11) NOT NULL,
  `id_responsable` int(11) NOT NULL,
  `doc_fotocopia_contrato` text NOT NULL,
  `nombre_responsable` varchar(100) NOT NULL,
  `numero_documento_responsable` int(15) NOT NULL,
  `direccion_responsable` varchar(100) NOT NULL,
  `telefono_responsable` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `contratos_ocasionales`
--

CREATE TABLE `contratos_ocasionales` (
  `id_contrato_ocasional` int(11) NOT NULL,
  `objeto_contrato` text NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `origen` int(11) NOT NULL,
  `destino` int(11) NOT NULL,
  `ruta1` text,
  `ruta2` text,
  `id_ciudad` int(11) NOT NULL,
  `fecha_inicial_contrato_ocasional` date NOT NULL,
  `fecha_final_contrato_ocasional` date NOT NULL,
  `fecha_creacion` date NOT NULL,
  `hora_creacion` time NOT NULL,
  `valor_contrato` double NOT NULL,
  `id_responsable` int(11) NOT NULL,
  `estado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `control_mantenimientos`
--

CREATE TABLE `control_mantenimientos` (
  `id_mantenimiento` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `tipo_servicio` varchar(100) NOT NULL,
  `enviado_por` varchar(100) NOT NULL,
  `fecha_mtto` date NOT NULL,
  `detalle_mtto` longtext NOT NULL,
  `valor_mtto` int(11) NOT NULL,
  `forma_pago` varchar(100) NOT NULL,
  `estado` int(11) NOT NULL,
  `observaciones` longtext,
  `id_usuario_creador` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `fecha_finalizacion` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `convenios`
--

CREATE TABLE `convenios` (
  `id_convenio` int(11) NOT NULL,
  `doc_convenio` text,
  `id_empresa` int(11) NOT NULL,
  `fecha_inicio_convenio` date NOT NULL,
  `fecha_final_convenio` date NOT NULL,
  `id_ciudad_convenio` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `id_conductor` varchar(100) DEFAULT NULL,
  `id_contrato` varchar(100) DEFAULT NULL,
  `objeto` longtext NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `fecha_creacion_convenio` date NOT NULL,
  `hora_creacion_convenio` time NOT NULL,
  `id_responsable` int(11) NOT NULL,
  `tipo_registro_conv` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `correspondencia_docs`
--

CREATE TABLE `correspondencia_docs` (
  `id_doc` int(11) NOT NULL,
  `id_tipo_doc` int(11) NOT NULL,
  `detalle` varchar(500) NOT NULL,
  `fecha_recibido` date NOT NULL,
  `remitente` varchar(500) NOT NULL,
  `destino` varchar(500) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `usuario_creador` int(11) NOT NULL,
  `usuario_destino` int(11) NOT NULL,
  `fecha_entrega` datetime DEFAULT NULL,
  `firma` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `correspondencia_tipos`
--

CREATE TABLE `correspondencia_tipos` (
  `id_tipo` int(11) NOT NULL,
  `detalle` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cotizacion_concepto_general`
--

CREATE TABLE `cotizacion_concepto_general` (
  `id` int(11) NOT NULL,
  `galon_combustible` double NOT NULL,
  `alimentacion_dia` int(11) NOT NULL,
  `hospedaje_dia` int(11) NOT NULL,
  `porc_pernotado` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cotizacion_concepto_vehiculo`
--

CREATE TABLE `cotizacion_concepto_vehiculo` (
  `id` int(11) NOT NULL,
  `tipo_vehiculo` varchar(500) NOT NULL,
  `rendimiento_kms` double NOT NULL,
  `valor_parqueadero` double NOT NULL,
  `valor_lavado` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cotizacion_costo_conductor`
--

CREATE TABLE `cotizacion_costo_conductor` (
  `id_costo_conductor` int(11) NOT NULL,
  `porcentaje_total` double NOT NULL,
  `porcentaje_pago` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cotizacion_destino`
--

CREATE TABLE `cotizacion_destino` (
  `id_destino` int(11) NOT NULL,
  `ciudad` varchar(500) NOT NULL,
  `departamento` varchar(500) NOT NULL,
  `dias` double NOT NULL,
  `kilometros` double NOT NULL,
  `kms_ida_retorno` double NOT NULL,
  `total_peaje_viaje` int(11) NOT NULL,
  `peaje_campero` double NOT NULL,
  `valor_campero` double NOT NULL,
  `peaje_doblecabina` double NOT NULL,
  `valor_doblecabina` double NOT NULL,
  `peaje_van` double NOT NULL,
  `valor_van` double NOT NULL,
  `peaje_microbus` double NOT NULL,
  `valor_microbus` double NOT NULL,
  `peaje_buseta` double NOT NULL,
  `valor_buseta` double NOT NULL,
  `peaje_buseton` double NOT NULL,
  `valor_buseton` double NOT NULL,
  `peaje_bus` double NOT NULL,
  `valor_bus` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cotizador_cotizacion`
--

CREATE TABLE `cotizador_cotizacion` (
  `id_cotizacion` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `id_creador` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `nombre_cliente` varchar(1000) NOT NULL,
  `ident_cliente` varchar(100) DEFAULT NULL,
  `dir_cliente` varchar(500) DEFAULT NULL,
  `tel_cliente` varchar(500) DEFAULT NULL,
  `email_cliente` varchar(500) DEFAULT NULL,
  `contacto_cliente` varchar(1000) NOT NULL,
  `destino` varchar(1000) NOT NULL,
  `dias_servicio` double NOT NULL,
  `kms` double NOT NULL,
  `cant_peajes` double DEFAULT NULL,
  `dia_espera` double DEFAULT NULL,
  `valor_espera` double DEFAULT NULL,
  `dia_servicio` double DEFAULT NULL,
  `valor_servicio` double DEFAULT NULL,
  `cant_pax` double NOT NULL,
  `valor_estandar` double NOT NULL,
  `descuento` double DEFAULT NULL,
  `valor_descuento` double DEFAULT NULL,
  `valor_final` double NOT NULL,
  `observaciones` longtext,
  `pdf` varchar(1000) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cotizador_descuento`
--

CREATE TABLE `cotizador_descuento` (
  `id_descuento` int(11) NOT NULL,
  `valor` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cotizador_destinos`
--

CREATE TABLE `cotizador_destinos` (
  `id_destino` int(11) NOT NULL,
  `nombre` varchar(1000) NOT NULL,
  `kms` double DEFAULT NULL,
  `dias_viaje` double NOT NULL,
  `valor_4_pax` double DEFAULT NULL,
  `valor_19_pax` double DEFAULT NULL,
  `valor_24_pax` double DEFAULT NULL,
  `valor_30_pax` double DEFAULT NULL,
  `valor_40_pax` double DEFAULT NULL,
  `valor_45_pax` double DEFAULT NULL,
  `cant_peajes` int(11) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cotizador_empresa`
--

CREATE TABLE `cotizador_empresa` (
  `id_empresa` int(11) NOT NULL,
  `razon_social` varchar(500) NOT NULL,
  `nit` varchar(50) NOT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `telefono` varchar(100) DEFAULT NULL,
  `logo` varchar(500) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cotizador_paginas_formato`
--

CREATE TABLE `cotizador_paginas_formato` (
  `id_pag` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `nombre` varchar(500) NOT NULL,
  `pag_valores` char(1) NOT NULL DEFAULT 'N',
  `estado` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cotizador_tarifa_individual`
--

CREATE TABLE `cotizador_tarifa_individual` (
  `id_tarifa` int(11) NOT NULL,
  `cant_pax` int(11) NOT NULL,
  `precio` double NOT NULL,
  `espera` double NOT NULL,
  `servicio` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cotizador_usuario`
--

CREATE TABLE `cotizador_usuario` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `nombre` varchar(500) NOT NULL,
  `correo` varchar(200) NOT NULL,
  `telefono` varchar(200) DEFAULT NULL,
  `cargo` varchar(200) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cruce_saldos_anticipos`
--

CREATE TABLE `cruce_saldos_anticipos` (
  `id_cruce` int(11) NOT NULL,
  `id_anticipo` int(11) NOT NULL,
  `valor_anticipo` int(11) NOT NULL,
  `valor_a_pagar` int(11) NOT NULL,
  `valor_total` int(11) NOT NULL,
  `num_id_comprobante` varchar(50) NOT NULL,
  `fecha_cruce` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cuentas_bancos`
--

CREATE TABLE `cuentas_bancos` (
  `id_cuenta` int(11) NOT NULL,
  `cuenta_puc` int(11) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `tipo_cuenta` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `curso`
--

CREATE TABLE `curso` (
  `id_curso` double NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `departamentos`
--

CREATE TABLE `departamentos` (
  `id_departamento` int(11) NOT NULL,
  `id_pais` int(11) NOT NULL,
  `departamento` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `descuentos_cartera`
--

CREATE TABLE `descuentos_cartera` (
  `id_descuento` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `id_concepto` int(11) NOT NULL,
  `tipo_descuento` varchar(100) NOT NULL,
  `descuento` int(11) NOT NULL,
  `fecha_inicial_valido` date NOT NULL,
  `fecha_final_valido` date NOT NULL,
  `id_usuario_creador` int(11) NOT NULL,
  `fecha_creacion_descuento` datetime NOT NULL,
  `estado` char(1) NOT NULL,
  `descuento_nomina` char(1) NOT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `descuentos_cruzados`
--

CREATE TABLE `descuentos_cruzados` (
  `id_cruce` int(11) NOT NULL,
  `id_cobro` int(11) NOT NULL,
  `id_descuento` int(11) NOT NULL,
  `fecha_cruce` date NOT NULL,
  `hora_cruce` time NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `descuentos_flota_propia`
--

CREATE TABLE `descuentos_flota_propia` (
  `id_descuento` int(11) NOT NULL,
  `id_flota_propia` int(11) NOT NULL,
  `detalle` varchar(1000) NOT NULL,
  `valor_descuento` double NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `desinfeccion`
--

CREATE TABLE `desinfeccion` (
  `id_desinfeccion` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `id_conductor` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_servicio` int(11) DEFAULT NULL,
  `lavado_manos` char(2) NOT NULL,
  `desinfectante` char(2) NOT NULL,
  `elementos_proteccion` char(2) NOT NULL,
  `bayetillas` char(2) NOT NULL,
  `escoba` char(2) NOT NULL,
  `alisto_toalla` char(2) NOT NULL,
  `balde` char(2) NOT NULL,
  `bolsa` char(2) NOT NULL,
  `productos` char(2) NOT NULL,
  `tapetes` char(2) NOT NULL,
  `volante` char(2) NOT NULL,
  `zona_pasajeros` char(2) NOT NULL,
  `zona_conductor` char(2) NOT NULL,
  `piso_vehiculo` char(2) NOT NULL,
  `aspersion` char(2) NOT NULL,
  `disposicion` char(2) NOT NULL,
  `bodega` char(2) NOT NULL,
  `hidratacion` char(2) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `destino`
--

CREATE TABLE `destino` (
  `id_destino` int(11) NOT NULL,
  `detalle` varchar(500) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `destino_cliente`
--

CREATE TABLE `destino_cliente` (
  `id_destino` int(11) NOT NULL,
  `detalle` varchar(500) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_centro_costo` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `detalle`
--

CREATE TABLE `detalle` (
  `id` double NOT NULL,
  `id_recorrido` int(11) NOT NULL,
  `id_pasajero` int(11) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `novedad` varchar(1) NOT NULL,
  `id_novedad` int(11) NOT NULL,
  `id_fuente` int(11) NOT NULL,
  `detalle` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `detalles_operaciones`
--

CREATE TABLE `detalles_operaciones` (
  `id_detalle` int(11) NOT NULL,
  `id_operacion` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `precio` float NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `novedad` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `detalle_gastos_personales`
--

CREATE TABLE `detalle_gastos_personales` (
  `id_detalle_gasto` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `nombre_persona` varchar(50) NOT NULL,
  `fecha_detalle` date NOT NULL,
  `precio` int(11) NOT NULL,
  `estado` int(1) NOT NULL,
  `novedad_finalizacion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `detalle_orden_servicio`
--

CREATE TABLE `detalle_orden_servicio` (
  `id_servicio` int(11) NOT NULL,
  `id_orden_servicio` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_subcategoria` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `valor` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `detalle_recorrido_fijo`
--

CREATE TABLE `detalle_recorrido_fijo` (
  `id_detalle` int(11) NOT NULL,
  `id_pasajero` int(11) NOT NULL,
  `id_recorrido` int(11) NOT NULL,
  `id_ruta` int(11) NOT NULL,
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  `hora` time NOT NULL DEFAULT '00:00:00',
  `us_registra` int(11) NOT NULL,
  `hora_recogida` time NOT NULL DEFAULT '00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `detalle_solicitud`
--

CREATE TABLE `detalle_solicitud` (
  `id_detalle` int(11) NOT NULL,
  `id_solicitud` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `fecha_solicitud` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fecha_servicio` date NOT NULL,
  `hora_servicio` time NOT NULL,
  `contacto` varchar(500) NOT NULL,
  `telefono_contacto` varchar(50) NOT NULL,
  `cantidad` double NOT NULL,
  `listado` varchar(1000) DEFAULT NULL,
  `id_tipovehiculo` int(11) NOT NULL,
  `id_tiposervicio` int(11) NOT NULL,
  `ciudad` varchar(500) NOT NULL,
  `origen` varchar(500) NOT NULL,
  `destino` varchar(500) NOT NULL,
  `centro_costo` varchar(500) DEFAULT NULL,
  `solicitante` varchar(500) DEFAULT NULL,
  `estado` char(1) NOT NULL,
  `relevo` char(1) DEFAULT 'N',
  `valor` double DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `documento_contrato_ocasional_propietario`
--

CREATE TABLE `documento_contrato_ocasional_propietario` (
  `id` int(11) NOT NULL,
  `id_contrato_ocasional` int(11) NOT NULL,
  `documento` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `empleado`
--

CREATE TABLE `empleado` (
  `id_empleado` int(11) NOT NULL,
  `nombres` varchar(200) NOT NULL,
  `apellidos` varchar(200) NOT NULL,
  `num_documento` varchar(50) NOT NULL,
  `hoja_vida` varchar(250) DEFAULT NULL,
  `correo` varchar(100) NOT NULL,
  `fotocopia_doc` varchar(250) DEFAULT NULL,
  `contrato` varchar(250) DEFAULT NULL,
  `examen_medico` varchar(250) DEFAULT NULL,
  `empresa` varchar(100) DEFAULT NULL,
  `contraloria` varchar(100) DEFAULT NULL,
  `procuraduria` varchar(100) DEFAULT NULL,
  `policia` varchar(100) DEFAULT NULL,
  `simit` varchar(100) DEFAULT NULL,
  `personeria` varchar(100) DEFAULT NULL,
  `actualizacion_datos` varchar(100) DEFAULT NULL,
  `manual_funciones` varchar(100) DEFAULT NULL,
  `fecha_nac` date NOT NULL,
  `direccion` varchar(500) NOT NULL,
  `telefono` varchar(200) DEFAULT NULL,
  `celular` varchar(200) NOT NULL,
  `cargo` varchar(100) NOT NULL,
  `fecha_contrato` date DEFAULT NULL,
  `eps` varchar(100) DEFAULT NULL,
  `arl` varchar(100) DEFAULT NULL,
  `pension` varchar(200) DEFAULT NULL,
  `cesantias` varchar(200) DEFAULT NULL,
  `caja_compensacion` varchar(200) DEFAULT NULL,
  `afiliacion_eps` varchar(250) DEFAULT NULL,
  `afiliacion_arl` varchar(250) DEFAULT NULL,
  `afiliacion_caja` varchar(2500) DEFAULT NULL,
  `fecha_examen` date DEFAULT NULL,
  `fecha_actualizacion` date DEFAULT NULL,
  `tipo_contrato` varchar(50) DEFAULT NULL,
  `fecha_fin_contrato` date DEFAULT NULL,
  `induccion` varchar(200) DEFAULT NULL,
  `fecha_exp_induccion` date DEFAULT NULL,
  `evaluacion` varchar(200) DEFAULT NULL,
  `fecha_exp_evaluacion` date DEFAULT NULL,
  `estado` int(1) NOT NULL,
  `fecha_creacion` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `empleado_cursos`
--

CREATE TABLE `empleado_cursos` (
  `id` int(11) NOT NULL,
  `nombre_curso` varchar(500) NOT NULL,
  `intensidad_horas` varchar(50) NOT NULL,
  `institucion` varchar(500) NOT NULL,
  `certificado` varchar(250) NOT NULL,
  `fecha_curso` date NOT NULL,
  `id_empleado` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `empleado_estudio`
--

CREATE TABLE `empleado_estudio` (
  `id` int(11) NOT NULL,
  `titulo` varchar(500) NOT NULL,
  `universidad` varchar(500) NOT NULL,
  `nivel` varchar(100) NOT NULL,
  `fecha_grado` date NOT NULL,
  `diploma` varchar(250) NOT NULL,
  `id_empleado` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `empleado_experiencia`
--

CREATE TABLE `empleado_experiencia` (
  `id` int(11) NOT NULL,
  `nombre_empresa` varchar(500) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  `cargo` varchar(200) NOT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `jefe_inmediato` varchar(200) DEFAULT NULL,
  `certificado` varchar(200) NOT NULL,
  `id_empleado` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `empleado_otros_docs`
--

CREATE TABLE `empleado_otros_docs` (
  `id_doc` int(11) NOT NULL,
  `nombre_doc` varchar(250) NOT NULL,
  `archivo` varchar(250) NOT NULL,
  `id_empleado` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `empresas`
--

CREATE TABLE `empresas` (
  `id_empresa` int(11) NOT NULL,
  `nombre_empresa` varchar(100) NOT NULL,
  `nit_empresa` varchar(15) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `id_pais` int(11) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `id_ciudad` int(11) NOT NULL,
  `representante_legal` varchar(100) NOT NULL,
  `numero_documento` int(11) NOT NULL,
  `fecha_expedicion` date NOT NULL,
  `lugar_expedicion` int(11) NOT NULL,
  `ciudad_residencia` int(11) NOT NULL,
  `logo` text NOT NULL,
  `estado` int(1) NOT NULL,
  `num_registro_mercantil` int(11) NOT NULL,
  `num_resolucion_ministerio` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `encuesta`
--

CREATE TABLE `encuesta` (
  `id_encuesta` int(11) NOT NULL,
  `nombre_encuesta` varchar(250) NOT NULL,
  `descripcion` longtext,
  `id_tipo_encuesta` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `encuesta_data_operativa`
--

CREATE TABLE `encuesta_data_operativa` (
  `id_data_operativa` int(11) NOT NULL,
  `id_referenciador` int(11) NOT NULL,
  `id_usuario_registro` int(11) NOT NULL,
  `departamento` varchar(100) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `nombres_apellidos` varchar(1000) NOT NULL,
  `telefono_celular` varchar(20) NOT NULL,
  `telefono_fijo` varchar(20) NOT NULL,
  `correo_electronico` text NOT NULL,
  `transporte_logistica` varchar(100) NOT NULL,
  `logistica_producto` varchar(1000) DEFAULT NULL,
  `logistica_ambas_prod` varchar(1000) DEFAULT NULL,
  `logistica_ambas_serv` varchar(1000) DEFAULT NULL,
  `logistica_servicio` varchar(1000) DEFAULT NULL,
  `propietario` varchar(1) DEFAULT NULL,
  `tipo_vehiculo` varchar(1000) DEFAULT NULL,
  `otro` text,
  `modelo` varchar(4) DEFAULT NULL,
  `capacidad` varchar(20) DEFAULT NULL,
  `disponibilidad_horario_inicial` time NOT NULL,
  `disponibilidad_horario_final` time NOT NULL,
  `vinculo` varchar(20) DEFAULT NULL,
  `empresaAfiliada` varchar(100) DEFAULT NULL,
  `ubicacion_vehiculo` varchar(15) NOT NULL,
  `direccion_ubicacion` varchar(1000) NOT NULL,
  `envio_papeles` char(1) DEFAULT NULL,
  `status_propuesta` varchar(50) DEFAULT NULL,
  `observaciones` longtext NOT NULL,
  `fecha_registro` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `encuesta_diligenciada`
--

CREATE TABLE `encuesta_diligenciada` (
  `id` int(11) NOT NULL,
  `id_encuesta` int(11) NOT NULL,
  `id_pregunta` int(11) NOT NULL,
  `id_respuesta` int(11) NOT NULL,
  `ampliacion` longtext,
  `tipo_usuario` char(1) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `encuesta_notificacion_positiva`
--

CREATE TABLE `encuesta_notificacion_positiva` (
  `id_notificacion` int(11) NOT NULL,
  `nombres_trabajador` varchar(100) NOT NULL,
  `apellidos_trabajador` varchar(100) NOT NULL,
  `telefono` int(11) NOT NULL,
  `direccion` varchar(1000) NOT NULL,
  `correo_electronico` varchar(1000) NOT NULL,
  `id_referenciador` int(11) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `cant_personas_contacto` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `encuesta_notificacion_positiva_personas_contacto`
--

CREATE TABLE `encuesta_notificacion_positiva_personas_contacto` (
  `id` int(11) NOT NULL,
  `id_notificacion` int(11) NOT NULL,
  `nombre_persona` varchar(1000) NOT NULL,
  `fecha_contacto` date NOT NULL,
  `lugar_contacto` varchar(1000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `encuesta_pregunta`
--

CREATE TABLE `encuesta_pregunta` (
  `id_pregunta` int(11) NOT NULL,
  `id_tipo_pregunta` int(11) NOT NULL,
  `detalle` varchar(500) NOT NULL,
  `orden` int(11) NOT NULL,
  `id_encuesta` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `encuesta_respuesta`
--

CREATE TABLE `encuesta_respuesta` (
  `id_respuesta` int(11) NOT NULL,
  `detalle` varchar(500) NOT NULL,
  `id_pregunta` int(11) NOT NULL,
  `ampliacion` char(1) NOT NULL,
  `orden` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `encuesta_salud`
--

CREATE TABLE `encuesta_salud` (
  `id_respuesta` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `celular` varchar(100) NOT NULL,
  `direccion` varchar(250) NOT NULL,
  `empresa` varchar(100) NOT NULL,
  `fechanac` date NOT NULL,
  `eps` varchar(100) NOT NULL,
  `arl` varchar(100) NOT NULL,
  `cargo` varchar(250) NOT NULL,
  `contrato` int(11) NOT NULL,
  `transporte` varchar(100) NOT NULL,
  `nombre_contacto` varchar(250) NOT NULL,
  `tel_contacto` varchar(250) NOT NULL,
  `hipertension` char(1) NOT NULL,
  `epoc` char(1) NOT NULL,
  `cancer` char(1) NOT NULL,
  `diabetes` char(1) NOT NULL,
  `vih` char(1) NOT NULL,
  `cardiaca` char(1) NOT NULL,
  `renal` char(1) NOT NULL,
  `asma` char(1) NOT NULL,
  `ninguna` char(1) NOT NULL,
  `medicamentos` char(1) NOT NULL,
  `edad` char(1) NOT NULL,
  `dolor_garganta` char(1) NOT NULL,
  `malestar_general` char(1) NOT NULL,
  `fiebre` char(1) NOT NULL,
  `tos` char(1) NOT NULL,
  `respirar` char(1) NOT NULL,
  `olfato` char(1) NOT NULL,
  `aislamiento_sin` char(1) NOT NULL,
  `aislamiento_con` char(1) NOT NULL,
  `caso_confirmado` char(1) NOT NULL,
  `contacto_estrecho` char(1) NOT NULL,
  `vulnerables` char(1) NOT NULL,
  `temperatura` double NOT NULL,
  `prueba_covid` char(1) NOT NULL,
  `fecha_prueba` date DEFAULT NULL,
  `resultado` char(1) DEFAULT NULL,
  `fecha_resultado` date DEFAULT NULL,
  `aplicacion_vacuna` char(1) NOT NULL,
  `terminos` char(1) NOT NULL,
  `fecha_diligenciamiento` datetime NOT NULL,
  `horas_descanso` char(1) NOT NULL,
  `horas_totales_suenio` varchar(50) NOT NULL,
  `fatiga` char(1) NOT NULL,
  `situacion_personal` char(1) NOT NULL,
  `medicamento` char(1) NOT NULL,
  `medicamento_suenio` char(1) NOT NULL,
  `condicion_trabajo` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `encuesta_vulnerabilidad`
--

CREATE TABLE `encuesta_vulnerabilidad` (
  `id_respuesta` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `celular` varchar(100) NOT NULL,
  `direccion` varchar(250) NOT NULL,
  `empresa` varchar(100) NOT NULL,
  `fechanac` date NOT NULL,
  `eps` varchar(100) NOT NULL,
  `arl` varchar(100) NOT NULL,
  `cargo` varchar(250) NOT NULL,
  `contrato` int(11) NOT NULL,
  `transporte` varchar(100) NOT NULL,
  `nombre_contacto` varchar(250) NOT NULL,
  `tel_contacto` varchar(250) NOT NULL,
  `hipertension` char(1) NOT NULL,
  `epoc` char(1) NOT NULL,
  `cancer` char(1) NOT NULL,
  `diabetes` char(1) NOT NULL,
  `vih` char(1) NOT NULL,
  `cardiaca` char(1) NOT NULL,
  `renal` char(1) NOT NULL,
  `asma` char(1) NOT NULL,
  `otra_enfermedad` char(1) DEFAULT NULL,
  `cual` varchar(200) DEFAULT NULL,
  `ninguna` char(1) NOT NULL,
  `embarazo` char(1) NOT NULL,
  `obesidad` char(1) NOT NULL,
  `medicamentos` char(1) NOT NULL,
  `edad` char(1) NOT NULL,
  `dolor_garganta` char(1) NOT NULL,
  `malestar_general` char(1) NOT NULL,
  `fiebre` char(1) NOT NULL,
  `tos` char(1) NOT NULL,
  `respirar` char(1) NOT NULL,
  `olfato` char(1) NOT NULL,
  `aislamiento_sin` char(1) NOT NULL,
  `aislamiento_con` char(1) NOT NULL,
  `caso_confirmado` char(1) NOT NULL,
  `contacto_estrecho` char(1) NOT NULL,
  `vulnerables` char(1) NOT NULL,
  `temperatura` double NOT NULL,
  `prueba_covid` char(1) NOT NULL,
  `fecha_prueba` date DEFAULT NULL,
  `resultado` char(1) DEFAULT NULL,
  `fecha_resultado` date DEFAULT NULL,
  `terminos` char(1) NOT NULL,
  `fecha_diligenciamiento` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `enfoque_objetivo`
--

CREATE TABLE `enfoque_objetivo` (
  `id_enfoque` int(11) NOT NULL,
  `detalle` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `estado_acuerdos_pago`
--

CREATE TABLE `estado_acuerdos_pago` (
  `id_estado` int(11) NOT NULL,
  `detalle` varchar(50) NOT NULL,
  `posicion` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `facturaciones`
--

CREATE TABLE `facturaciones` (
  `id_facturacion` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `mes` date NOT NULL,
  `dias_facturados` int(11) NOT NULL,
  `valor_total_facturado` int(11) NOT NULL,
  `valor_total_pagar_terceros` int(11) NOT NULL,
  `fecha_factura` date NOT NULL,
  `fecha_recibo_pago` date NOT NULL,
  `id_contrato` int(11) NOT NULL,
  `estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `finalizacion_servicio`
--

CREATE TABLE `finalizacion_servicio` (
  `id` int(11) NOT NULL,
  `id_solicitud` int(11) NOT NULL,
  `id_servicio` int(11) NOT NULL,
  `detalle` longtext NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flota_propia`
--

CREATE TABLE `flota_propia` (
  `id_flota_propia` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `id_contrato_fijo` int(11) DEFAULT NULL,
  `id_contrato_ocasional` int(11) DEFAULT NULL,
  `numero_recorridos` int(11) NOT NULL,
  `dias_laborados` int(11) NOT NULL,
  `dias_laborados_gps` int(11) NOT NULL,
  `valor_generado` double NOT NULL,
  `fecha_creacion` date NOT NULL,
  `fecha_movimiento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fotografias_vehiculos`
--

CREATE TABLE `fotografias_vehiculos` (
  `id_fotografia` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `fotografia_frontal` text NOT NULL,
  `fotografia_trasera` text NOT NULL,
  `fotografia_lateral_izq` text NOT NULL,
  `fotografia_lateral_der` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `foto_vehiculo`
--

CREATE TABLE `foto_vehiculo` (
  `id` int(11) NOT NULL,
  `foto` varchar(500) NOT NULL,
  `id_vehiculo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `frecuencia_cliente`
--

CREATE TABLE `frecuencia_cliente` (
  `id_frecuencia` int(11) NOT NULL,
  `detalle_frecuencia` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fuec`
--

CREATE TABLE `fuec` (
  `id_fuec` double NOT NULL,
  `num_interno` varchar(500) NOT NULL,
  `num_comprobante` varchar(500) NOT NULL,
  `num_unico_emision` int(11) NOT NULL,
  `origen` longtext NOT NULL,
  `destino` longtext NOT NULL,
  `tipo_fuec` varchar(50) DEFAULT NULL,
  `con_fuec` longtext,
  `ruta1` longtext,
  `ruta2` longtext,
  `id_vehiculo` int(11) NOT NULL,
  `fecha_inicial_fuec` date NOT NULL,
  `fecha_final_fuec` date NOT NULL,
  `id_contrato` int(11) NOT NULL,
  `id_contrato_ocasional` int(11) NOT NULL,
  `responsable` varchar(1000) NOT NULL,
  `idResponsable` varchar(100) DEFAULT NULL,
  `dirResponsable` varchar(1000) DEFAULT NULL,
  `telResponsable` varchar(100) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `anexo` char(1) DEFAULT NULL,
  `estado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fuec_preliminar`
--

CREATE TABLE `fuec_preliminar` (
  `id_fuec` double NOT NULL,
  `origen` longtext NOT NULL,
  `destino` longtext NOT NULL,
  `tipo_fuec` varchar(50) DEFAULT NULL,
  `con_fuec` longtext,
  `ruta1` longtext,
  `ruta2` longtext,
  `id_vehiculo` int(11) NOT NULL,
  `id_contrato` int(11) NOT NULL,
  `responsable` varchar(1000) NOT NULL,
  `idResponsable` varchar(100) DEFAULT NULL,
  `dirResponsable` varchar(1000) DEFAULT NULL,
  `telResponsable` varchar(100) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fuente`
--

CREATE TABLE `fuente` (
  `id_fuente` double NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `posicion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gestion_cobro`
--

CREATE TABLE `gestion_cobro` (
  `id_gestion` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `tipo` int(11) NOT NULL,
  `detalle` longtext,
  `id_usuario` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inspeccion_evidencias`
--

CREATE TABLE `inspeccion_evidencias` (
  `id_evidencia` int(11) NOT NULL,
  `id_inspeccion` int(11) NOT NULL,
  `archivo` varchar(500) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inspeccion_vehicular`
--

CREATE TABLE `inspeccion_vehicular` (
  `id_inspeccion` int(11) NOT NULL,
  `entrega_vehiculo` char(2) NOT NULL,
  `empresa` varchar(500) DEFAULT NULL,
  `contrato` varchar(500) DEFAULT NULL,
  `vehiculo_nuevo` char(2) NOT NULL,
  `id_vehiculo` int(11) DEFAULT NULL,
  `movil` varchar(20) DEFAULT NULL,
  `placa` varchar(20) DEFAULT NULL,
  `capacidad` varchar(20) DEFAULT NULL,
  `modelo` varchar(20) DEFAULT NULL,
  `tipo_vehiculo` varchar(50) DEFAULT NULL,
  `tipo_combustible` varchar(50) DEFAULT NULL,
  `conductor_nuevo` char(2) NOT NULL,
  `id_conductor` int(11) NOT NULL,
  `nombre` varchar(500) DEFAULT NULL,
  `num_cedula` varchar(50) DEFAULT NULL,
  `celular` varchar(500) DEFAULT NULL,
  `num_licencia` varchar(50) DEFAULT NULL,
  `fecha_venc_licencia` date DEFAULT NULL,
  `kilometraje` int(11) NOT NULL,
  `nivel_gasolina` varchar(50) NOT NULL,
  `fecha_proximo_mtto` date NOT NULL,
  `rev_tecnomecanica` char(3) NOT NULL,
  `polizas_extra_contra` char(3) NOT NULL,
  `preventiva` char(3) NOT NULL,
  `tarjeta_operacion` char(3) NOT NULL,
  `soat` char(3) NOT NULL,
  `fuec` char(3) NOT NULL,
  `dispositivo_velocidad` char(3) NOT NULL,
  `tarjeta_operacion_fecha` date DEFAULT NULL,
  `soat_fecha` date DEFAULT NULL,
  `poliza_extra_fecha` date DEFAULT NULL,
  `tecnomecanica_fecha` date DEFAULT NULL,
  `preventiva_fecha` date DEFAULT NULL,
  `fuec_fecha` date DEFAULT NULL,
  `disp_velocidad_fecha` date DEFAULT NULL,
  `licencia_transito` char(3) DEFAULT NULL,
  `licencia_transito_fv` date DEFAULT NULL,
  `licencia_conduccion` char(3) DEFAULT NULL,
  `licencia_conduccion_fv` date DEFAULT NULL,
  `seguridad_social` char(3) DEFAULT NULL,
  `seguridad_social_fv` date DEFAULT NULL,
  `gato` char(3) NOT NULL,
  `cruceta` char(3) NOT NULL,
  `seniales_carretera` char(3) NOT NULL,
  `tacos` char(3) NOT NULL,
  `linterna` char(3) NOT NULL,
  `llaves_fijas` char(3) NOT NULL,
  `alicates` char(3) NOT NULL,
  `llave_expansiva` char(3) NOT NULL,
  `destornillador` char(3) NOT NULL,
  `chaleco_reflectivo` char(3) NOT NULL,
  `martillo_frag` char(3) NOT NULL,
  `extintor` char(3) NOT NULL,
  `extintor_cap` varchar(20) DEFAULT NULL,
  `extintor_fv` date DEFAULT NULL,
  `gasas_esteriles` char(3) NOT NULL,
  `gasas_esteriles_fv` date DEFAULT NULL,
  `algodon` char(3) NOT NULL,
  `algodon_fv` date DEFAULT NULL,
  `venda_elastica` char(3) NOT NULL,
  `venda_elastica_fv` date DEFAULT NULL,
  `micropore` char(3) NOT NULL,
  `micropore_fv` date DEFAULT NULL,
  `curas` char(3) NOT NULL,
  `curas_fv` date DEFAULT NULL,
  `bajalenguas` char(3) NOT NULL,
  `bajalenguas_fv` date DEFAULT NULL,
  `guantes_latex` char(3) NOT NULL,
  `guantes_fv` date DEFAULT NULL,
  `copitos` char(3) NOT NULL,
  `copitos_fv` date DEFAULT NULL,
  `pito_botiquin` char(3) NOT NULL,
  `bolsas_rojas` char(3) DEFAULT NULL,
  `suero` char(3) NOT NULL,
  `suero_fv` date DEFAULT NULL,
  `antiseptico` char(3) NOT NULL,
  `antiseptico_fv` date DEFAULT NULL,
  `tijeras` char(3) NOT NULL,
  `tijeras_fv` date DEFAULT NULL,
  `aseo_personal` char(3) NOT NULL,
  `sistema_comunicacion` char(3) NOT NULL,
  `gps` char(3) DEFAULT NULL,
  `rutero` char(3) NOT NULL,
  `aseo_interno` char(3) NOT NULL,
  `aseo_externo` char(3) DEFAULT NULL,
  `luces` char(3) DEFAULT NULL,
  `luces_obs` longtext,
  `direccionales` char(3) DEFAULT NULL,
  `direccionales_obs` longtext,
  `panoramico` char(3) DEFAULT NULL,
  `panoramico_obs` longtext,
  `limpiabrisas` char(3) DEFAULT NULL,
  `limpiabrisas_obs` longtext,
  `stops` char(3) DEFAULT NULL,
  `stops_obs` longtext,
  `luces_internas` char(3) DEFAULT NULL,
  `luces_internas_obs` longtext,
  `luces_tablero` char(3) DEFAULT NULL,
  `luces_tablero_obs` longtext,
  `aire_acondicionado` char(3) DEFAULT NULL,
  `aire_acondicionado_obs` longtext,
  `radio` char(3) DEFAULT NULL,
  `radio_obs` longtext,
  `televisor` char(3) DEFAULT NULL,
  `televisor_obs` longtext,
  `boceles` char(3) DEFAULT NULL,
  `boceles_obs` longtext,
  `antenas` char(3) DEFAULT NULL,
  `antenas_obs` longtext,
  `rines` char(3) DEFAULT NULL,
  `rines_obs` longtext,
  `airbag` char(3) DEFAULT NULL,
  `airbag_obs` longtext,
  `tapiceria` char(3) DEFAULT NULL,
  `tapiceria_obs` longtext,
  `silleteria` char(3) DEFAULT NULL,
  `silleteria_obs` longtext,
  `disp_velocidad` char(3) DEFAULT NULL,
  `disp_velocidad_obs` longtext,
  `cinturon_seguridad` char(3) DEFAULT NULL,
  `cinturon_seguridad_obs` longtext,
  `cortinas` char(3) DEFAULT NULL,
  `cortinas_obs` longtext,
  `salida_emergencia` char(3) DEFAULT NULL,
  `salida_emergencia_obs` longtext,
  `martillos` char(3) DEFAULT NULL,
  `martillos_obs` longtext,
  `estado_bano` char(3) DEFAULT NULL,
  `estado_bano_obs` longtext,
  `vidrios` char(3) DEFAULT NULL,
  `vidrios_obs` longtext,
  `llantas` char(3) DEFAULT NULL,
  `llantas_obs` longtext,
  `repuesto` char(3) DEFAULT NULL,
  `repuesto_obs` longtext,
  `tapetes` char(3) DEFAULT NULL,
  `tapetes_obs` longtext,
  `encendedor` char(3) DEFAULT NULL,
  `encendedor_obs` longtext,
  `latoneria` char(3) DEFAULT NULL,
  `latoneria_obs` longtext,
  `distintivos` char(3) DEFAULT NULL,
  `distintivos_obs` longtext,
  `bodegas` char(3) DEFAULT NULL,
  `bodegas_obs` longtext,
  `fluidos` char(3) DEFAULT NULL,
  `fluidos_obs` longtext,
  `palomeras` char(3) DEFAULT NULL,
  `palomeras_obs` longtext,
  `calcomania` char(3) DEFAULT NULL,
  `calcomania_obs` longtext,
  `como_conduzco` char(3) DEFAULT NULL,
  `como_conduzco_obs` longtext,
  `cierre_puertas` char(3) DEFAULT NULL,
  `cierre_puertas_obs` longtext,
  `frenos` char(3) DEFAULT NULL,
  `frenos_obs` longtext,
  `embrague` char(3) DEFAULT NULL,
  `embrague_obs` longtext,
  `suspension` char(3) DEFAULT NULL,
  `suspension_obs` longtext,
  `cambios` char(3) DEFAULT NULL,
  `cambios_obs` longtext,
  `pito` char(3) DEFAULT NULL,
  `pito_obs` longtext,
  `bateria` char(3) DEFAULT NULL,
  `bateria_obs` longtext,
  `freno_mano` char(3) DEFAULT NULL,
  `freno_mano_obs` longtext,
  `direccion` char(3) DEFAULT NULL,
  `direccion_obs` longtext,
  `descripcion_danos_observados` longtext NOT NULL,
  `observaciones` longtext NOT NULL,
  `entregado_por` varchar(500) DEFAULT NULL,
  `firma_entrega` varchar(500) DEFAULT NULL,
  `recibido_por` varchar(500) DEFAULT NULL,
  `firma_recibido` varchar(500) DEFAULT NULL,
  `observaciones_entrega` longtext,
  `id_usuario_registro` int(11) NOT NULL,
  `fecha_registro` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `intranet_banners`
--

CREATE TABLE `intranet_banners` (
  `id_banner` int(11) NOT NULL,
  `titulo` varchar(1000) NOT NULL,
  `descripcion` longtext NOT NULL,
  `img` text NOT NULL,
  `link` text NOT NULL,
  `estado` char(1) NOT NULL,
  `posicion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `intranet_categorias`
--

CREATE TABLE `intranet_categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(1000) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `intranet_clasificados`
--

CREATE TABLE `intranet_clasificados` (
  `id_clasificado` int(11) NOT NULL,
  `titulo` varchar(1000) NOT NULL,
  `descripcion` longtext NOT NULL,
  `img` text NOT NULL,
  `link` text NOT NULL,
  `estado` char(1) NOT NULL,
  `posicion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `intranet_galeria_imgs`
--

CREATE TABLE `intranet_galeria_imgs` (
  `id_imagen` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `estado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `intranet_noticias`
--

CREATE TABLE `intranet_noticias` (
  `id_noticia` int(11) NOT NULL,
  `titulo` varchar(1000) NOT NULL,
  `descripcion` longtext NOT NULL,
  `img` text NOT NULL,
  `link` text NOT NULL,
  `estado` char(1) NOT NULL,
  `posicion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `intranet_publicaciones`
--

CREATE TABLE `intranet_publicaciones` (
  `id_publicacion` int(11) NOT NULL,
  `titulo` varchar(1000) NOT NULL,
  `descripcion` longtext NOT NULL,
  `img` text NOT NULL,
  `link` text NOT NULL,
  `estado` char(1) NOT NULL,
  `posicion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mantenimineto_fp`
--

CREATE TABLE `mantenimineto_fp` (
  `id` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `kilometraje` double DEFAULT NULL,
  `estado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mensajes_afiliados`
--

CREATE TABLE `mensajes_afiliados` (
  `id_mensaje` int(11) NOT NULL,
  `id_usuario_destinatario` int(11) NOT NULL,
  `mensaje` longtext NOT NULL,
  `id_usuario_remitente` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `modulos`
--

CREATE TABLE `modulos` (
  `id_modulo` int(11) NOT NULL,
  `nombre_modulo` varchar(60) NOT NULL,
  `estado` int(1) NOT NULL,
  `id_padre` int(11) NOT NULL,
  `link` varchar(1000) NOT NULL,
  `menu` char(1) NOT NULL,
  `icono` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notificaciones_comprobantesPagos`
--

CREATE TABLE `notificaciones_comprobantesPagos` (
  `id_notificacion_comprobante` int(11) NOT NULL,
  `comunicado` varchar(1000) NOT NULL,
  `num_id_comprobante` varchar(50) NOT NULL,
  `id_usuario_comprobante` int(11) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `id_usuario_notificacion` int(11) NOT NULL,
  `estado` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `novedad`
--

CREATE TABLE `novedad` (
  `id_novedad` double NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `posicion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `novedad_pasajero`
--

CREATE TABLE `novedad_pasajero` (
  `id` double NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `id_ruta_origen` int(11) NOT NULL,
  `id_ruta_destino` int(11) NOT NULL,
  `detalle` longtext NOT NULL,
  `fecha_novedad` datetime NOT NULL,
  `id_pasajero` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `novedad_servicio`
--

CREATE TABLE `novedad_servicio` (
  `id` int(11) NOT NULL,
  `id_tipo_novedad` int(11) NOT NULL,
  `detalle_adicional` longtext CHARACTER SET utf8 NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `id_conductor` int(11) NOT NULL,
  `id_servicio` int(11) NOT NULL,
  `fecha_novedad` datetime NOT NULL,
  `estado` char(1) NOT NULL,
  `revisado_por` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `objetivo_general`
--

CREATE TABLE `objetivo_general` (
  `id_objetivo` int(11) NOT NULL,
  `detalle_objetivo` longtext NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `vigencia` int(11) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `operaciones`
--

CREATE TABLE `operaciones` (
  `id_operacion` int(11) NOT NULL,
  `nombre_operacion` varchar(100) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `orden_servicio`
--

CREATE TABLE `orden_servicio` (
  `id_orden` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `tipo_combustible` varchar(100) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `id_tipo_servicio` int(11) NOT NULL,
  `solicitado_por` varchar(150) NOT NULL,
  `fecha_inicial` date NOT NULL,
  `fecha_final` date NOT NULL,
  `detalle` longtext NOT NULL,
  `valor_total` double NOT NULL,
  `valor_final` double DEFAULT NULL,
  `motivo_cancelacion` longtext,
  `comprobante` varchar(150) DEFAULT NULL,
  `fecha_ejecucion` date DEFAULT NULL,
  `prioridad` int(11) DEFAULT NULL,
  `estado` char(1) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `origen`
--

CREATE TABLE `origen` (
  `id_origen` int(11) NOT NULL,
  `detalle` varchar(500) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pagos`
--

CREATE TABLE `pagos` (
  `id` int(50) NOT NULL,
  `movil` varchar(15) NOT NULL,
  `placa` varchar(25) NOT NULL,
  `fechapago` varchar(25) NOT NULL,
  `conceptorecaudo` varchar(100) NOT NULL,
  `valorrecaudado` varchar(100) NOT NULL,
  `responsablerecaudo` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pago_recibido`
--

CREATE TABLE `pago_recibido` (
  `id_pago` int(11) NOT NULL,
  `id_banco` int(11) NOT NULL,
  `fecha_pago` date NOT NULL,
  `valor` double NOT NULL,
  `comprobante` varchar(500) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `paises`
--

CREATE TABLE `paises` (
  `id_pais` int(11) NOT NULL,
  `pais` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `paquetes_plus_vehiculos`
--

CREATE TABLE `paquetes_plus_vehiculos` (
  `id` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `id_transaccion` int(11) NOT NULL,
  `id_usuario_activacion` int(11) NOT NULL,
  `fecha_inicial` date NOT NULL,
  `fecha_final` date NOT NULL,
  `estado` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pasajero`
--

CREATE TABLE `pasajero` (
  `id_pasajero` double NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(1000) NOT NULL,
  `hora_subida` time NOT NULL,
  `hora_bajada` time NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `id_colegio` int(11) NOT NULL,
  `estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pasajero_ruta_fija`
--

CREATE TABLE `pasajero_ruta_fija` (
  `id_pasajero` int(11) NOT NULL,
  `nombres` varchar(250) NOT NULL,
  `apellidos` varchar(250) NOT NULL,
  `estado` char(1) NOT NULL,
  `sucursal` varchar(250) DEFAULT NULL,
  `ciudad` varchar(500) DEFAULT NULL,
  `direccion` varchar(500) DEFAULT NULL,
  `barrio` varchar(500) DEFAULT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `perfiles`
--

CREATE TABLE `perfiles` (
  `id_perfil` int(11) NOT NULL,
  `nombre_perfil` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `permisos_usuarios_mod_operativo`
--

CREATE TABLE `permisos_usuarios_mod_operativo` (
  `id` int(11) NOT NULL,
  `rol` varchar(100) NOT NULL,
  `tipo_usuario` varchar(100) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_cliente` varchar(1000) NOT NULL,
  `registro` varchar(100) NOT NULL,
  `consulta` varchar(100) NOT NULL,
  `valor_cliente` int(11) NOT NULL,
  `lectura_reportes` varchar(100) NOT NULL,
  `anulacion` varchar(100) NOT NULL,
  `opciones_adicionales` int(11) DEFAULT NULL,
  `fecha_asignacion` datetime NOT NULL,
  `id_usuario_asignacion` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `permisos_usuarios_mod_vehiculos`
--

CREATE TABLE `permisos_usuarios_mod_vehiculos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `perfil` varchar(100) NOT NULL,
  `tipo_consulta` varchar(100) NOT NULL,
  `fecha_asignacion` datetime NOT NULL,
  `id_usuario_asignacion` int(11) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `polizas_cartera`
--

CREATE TABLE `polizas_cartera` (
  `id_poliza` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `nombre_cliente` varchar(100) NOT NULL,
  `tipo_identificacion` varchar(100) NOT NULL,
  `num_identificacion` int(11) NOT NULL,
  `valor_total` double NOT NULL,
  `por_vencer` double NOT NULL,
  `dias_mora_1_30` double NOT NULL,
  `dias_mora_31_60` double NOT NULL,
  `dias_mora_61_90` double NOT NULL,
  `dias_mora_mayor_90` double NOT NULL,
  `id_usuario_creador` int(11) NOT NULL,
  `fecha_creacion` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `preoperacionales`
--

CREATE TABLE `preoperacionales` (
  `id` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `id_conductor` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `puertas` char(2) NOT NULL DEFAULT 'C',
  `espejos_retrovisores` char(2) NOT NULL DEFAULT 'C',
  `ventanas` char(2) NOT NULL DEFAULT 'C',
  `vidrio_frontal` char(2) NOT NULL DEFAULT 'C',
  `llantas_rines` char(2) NOT NULL DEFAULT 'C',
  `llanta_repuesto` char(2) NOT NULL DEFAULT 'C',
  `luces_delanteras` char(2) NOT NULL DEFAULT 'C',
  `luces_freno` char(2) NOT NULL DEFAULT 'C',
  `luces_reserva` char(2) NOT NULL DEFAULT 'C',
  `luces_parqueo_direccionales` char(2) NOT NULL DEFAULT 'C',
  `sistema_suspension` char(2) NOT NULL DEFAULT 'C',
  `sistema_frenos` char(2) NOT NULL DEFAULT 'C',
  `sistema_direccion` char(2) NOT NULL DEFAULT 'C',
  `tapas` char(2) NOT NULL DEFAULT 'C',
  `niveles_aceite_motor` char(2) NOT NULL DEFAULT 'C',
  `radiador_ventilador_correas` char(2) NOT NULL DEFAULT 'C',
  `mangueras` char(2) NOT NULL DEFAULT 'C',
  `transmision` char(2) NOT NULL DEFAULT 'C',
  `filtro_aire` char(2) NOT NULL DEFAULT 'C',
  `fugas_motor` char(2) NOT NULL DEFAULT 'C',
  `bomba_freno_clutch` char(2) NOT NULL DEFAULT 'C',
  `bateria_bornes_soporte` char(2) NOT NULL DEFAULT 'C',
  `direccion_nivel_aceite_hidraulico` char(2) NOT NULL DEFAULT 'C',
  `depositivo_lavabrisas` char(2) NOT NULL DEFAULT 'C',
  `conexiones_electricas` char(2) NOT NULL DEFAULT 'C',
  `plumillas_limpiavidrios` char(2) NOT NULL DEFAULT 'C',
  `indicadores_luces_tablero` char(2) NOT NULL DEFAULT 'C',
  `indicador_velocidad` char(2) NOT NULL DEFAULT 'C',
  `indicador_combustible` char(2) NOT NULL DEFAULT 'C',
  `indicador_aceite_motor` char(2) NOT NULL DEFAULT 'C',
  `pito` char(2) NOT NULL DEFAULT 'C',
  `freno_emergencia` char(2) NOT NULL DEFAULT 'C',
  `pito_reserva` char(2) NOT NULL DEFAULT 'C',
  `botiquin` char(2) NOT NULL DEFAULT 'C',
  `equipo_carretera` char(2) NOT NULL DEFAULT 'C',
  `kilometraje` double NOT NULL DEFAULT '0',
  `lavado_manos` char(2) NOT NULL DEFAULT 'C',
  `desinfectante` char(2) NOT NULL DEFAULT 'C',
  `elementos_proteccion` char(2) NOT NULL DEFAULT 'C',
  `bayetillas` char(2) NOT NULL DEFAULT 'C',
  `escoba` char(2) NOT NULL DEFAULT 'C',
  `alisto_toalla` char(2) NOT NULL DEFAULT 'C',
  `balde` char(2) NOT NULL DEFAULT 'C',
  `bolsa` char(2) NOT NULL DEFAULT 'C',
  `productos` char(2) NOT NULL DEFAULT 'C',
  `tapetes` char(2) NOT NULL DEFAULT 'C',
  `volante` char(2) NOT NULL DEFAULT 'C',
  `zona_pasajeros` char(2) NOT NULL DEFAULT 'C',
  `zona_conductor` char(2) NOT NULL DEFAULT 'C',
  `piso_vehiculo` char(2) NOT NULL DEFAULT 'C',
  `aspersion` char(2) NOT NULL DEFAULT 'C',
  `disposicion` char(2) NOT NULL DEFAULT 'C',
  `bodega` char(2) NOT NULL DEFAULT 'C',
  `hidratacion` char(2) NOT NULL DEFAULT 'C'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `preoperacionalGEB`
--

CREATE TABLE `preoperacionalGEB` (
  `id_preoperacional` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `id_conductor` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `botiquin` char(2) NOT NULL,
  `extintor_cargado` char(2) NOT NULL,
  `gato` char(2) NOT NULL,
  `cruceta_copa` char(2) NOT NULL,
  `triangulos` char(2) NOT NULL,
  `tacos_cunias` char(2) NOT NULL,
  `llanta_repuesto` char(2) NOT NULL,
  `herramientas` char(2) NOT NULL,
  `chaleco_refractivo` char(2) NOT NULL,
  `aviso_conduzco` char(2) NOT NULL,
  `nivel_liquido` char(2) NOT NULL,
  `nivel_aceite` char(2) NOT NULL,
  `fuga_aceite` char(2) NOT NULL,
  `estado_filtro_combustible` char(2) NOT NULL,
  `sistema_embrague` char(2) NOT NULL,
  `cierre_puertas_ventanas` char(2) NOT NULL,
  `seguro_puertas` char(2) NOT NULL,
  `cinturones_seguridad` char(2) NOT NULL,
  `control_fugas` char(2) NOT NULL,
  `estado_cojineria` char(2) NOT NULL,
  `fijacion_asientos` char(2) NOT NULL,
  `ajuste_silla_conductor` char(2) NOT NULL,
  `estado_retrovisores` char(2) NOT NULL,
  `pisos_cabina` char(2) NOT NULL,
  `llanta_trasera_izq` char(2) NOT NULL,
  `llanta_trasera_der` char(2) NOT NULL,
  `llanta_delantera_izq` char(2) NOT NULL,
  `llanta_delantera_der` char(2) NOT NULL,
  `estado_latoneria` char(2) NOT NULL,
  `pito` char(2) NOT NULL,
  `aire_acondicionado` char(2) NOT NULL,
  `apoya_cabezas` char(2) NOT NULL,
  `alarma_retroceso` char(2) NOT NULL,
  `freno_parqueo` char(2) NOT NULL,
  `lvl_liquido_freno` char(2) NOT NULL,
  `limpia_brisas` char(2) NOT NULL,
  `parabrisas` char(2) NOT NULL,
  `sistema_parabrisas` char(2) NOT NULL,
  `estado_vidrio_trasero` char(2) NOT NULL,
  `indicadores` char(2) NOT NULL,
  `indicadores_luces_altas` char(2) NOT NULL,
  `indicador_luces_parqueo` char(2) NOT NULL,
  `indicador_lvl_gasolina` char(2) NOT NULL,
  `sistema_escape` char(2) NOT NULL,
  `emanacion_gases` char(2) NOT NULL,
  `luces_posicion_delantera` char(2) NOT NULL,
  `luces_posicion_trasera` char(2) NOT NULL,
  `luces_freno` char(2) NOT NULL,
  `direccionales` char(2) NOT NULL,
  `luces_emergencia` char(2) NOT NULL,
  `luces_retroceso` char(2) NOT NULL,
  `luz_placa` char(2) NOT NULL,
  `luces_bajas` char(2) NOT NULL,
  `luces_altas` char(2) NOT NULL,
  `luces_interiores` char(2) NOT NULL,
  `luces_tablero` char(2) NOT NULL,
  `sistema_electrico_aislado` char(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `productos_clientes`
--

CREATE TABLE `productos_clientes` (
  `id_producto` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `detalle_producto` text NOT NULL,
  `tipo_producto` text NOT NULL,
  `dias_aplicados_mensualidad` varchar(100) DEFAULT NULL,
  `dia_corte` int(11) DEFAULT NULL,
  `observaciones` longtext,
  `estado` varchar(50) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `id_usuario_creacion` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `programacion_servicios`
--

CREATE TABLE `programacion_servicios` (
  `id_programacion` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `localidad` varchar(100) NOT NULL,
  `codigo_identificativo` varchar(100) DEFAULT NULL,
  `proyecto` varchar(100) NOT NULL,
  `unidad_operativa` int(11) NOT NULL,
  `punto_inicio` varchar(1000) NOT NULL,
  `punto_final` varchar(1000) NOT NULL,
  `entrada_salida` char(1) NOT NULL,
  `horario` time NOT NULL,
  `frecuencia` varchar(1000) NOT NULL,
  `observaciones` longtext,
  `capacidad_servicio` int(11) NOT NULL,
  `programado` varchar(10) DEFAULT NULL,
  `nombre_monitora` varchar(100) NOT NULL,
  `telefono_monitora` varchar(100) NOT NULL,
  `novedades` longtext,
  `id_vehiculo_facturacion` int(11) NOT NULL,
  `id_vehiculo_liquidacion` int(11) NOT NULL,
  `id_conductor` int(11) NOT NULL,
  `valor_pagar` double NOT NULL,
  `valor_pagar_monitora` double NOT NULL,
  `valor_facturar` double NOT NULL,
  `programacion` char(1) NOT NULL,
  `id_padre_programacion` int(11) NOT NULL,
  `estado` char(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `propietarios`
--

CREATE TABLE `propietarios` (
  `id_propietario` int(11) NOT NULL,
  `nombre` varchar(1000) NOT NULL,
  `tipo_documento` varchar(10) NOT NULL,
  `numero_documento` int(11) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `correo` text NOT NULL,
  `ciudad` text NOT NULL,
  `direccion` text NOT NULL,
  `entidad_bancaria` text,
  `titular_cuenta` text,
  `cc_titular` int(11) DEFAULT NULL,
  `tipo_cuenta` varchar(50) DEFAULT NULL,
  `num_cuenta` int(100) DEFAULT NULL,
  `estado` int(11) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `fecha_ultima_modificacion` datetime NOT NULL,
  `id_usuario_registro` int(11) NOT NULL,
  `id_usuario_ultima_modificacion` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `proveedor_mantenimiento`
--

CREATE TABLE `proveedor_mantenimiento` (
  `id_proveedor` int(11) NOT NULL,
  `razon_social` varchar(100) NOT NULL,
  `nit` varchar(20) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `proyectos_contratos`
--

CREATE TABLE `proyectos_contratos` (
  `id_proyecto` int(11) NOT NULL,
  `id_contrato` int(11) NOT NULL,
  `nombre_proyecto` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `proyectos_data_operativa`
--

CREATE TABLE `proyectos_data_operativa` (
  `id_proyecto` int(11) NOT NULL,
  `nombre_proyecto` varchar(1000) NOT NULL,
  `fecha_creacion_proyecto` date NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `recibosCaja`
--

CREATE TABLE `recibosCaja` (
  `id_recibo_caja` int(11) NOT NULL,
  `nombre_documento` varchar(1000) NOT NULL,
  `fecha_creacion` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `recorrido`
--

CREATE TABLE `recorrido` (
  `id_recorrido` double NOT NULL,
  `id_tipo_recorrido` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `salida` time NOT NULL,
  `llegada` time NOT NULL,
  `estado` varchar(1) NOT NULL,
  `id_monitor` int(11) NOT NULL,
  `hora_monitor` datetime NOT NULL,
  `id_conductor` int(11) NOT NULL,
  `id_ruta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `recorrido_ruta_fija`
--

CREATE TABLE `recorrido_ruta_fija` (
  `id_recorrido` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL DEFAULT '0000-00-00',
  `hora_inicio` time NOT NULL DEFAULT '00:00:00',
  `id_usuario` int(11) NOT NULL,
  `id_ruta` int(11) NOT NULL,
  `tipo_usuario` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `referencias_conductor`
--

CREATE TABLE `referencias_conductor` (
  `id_referencia` int(11) NOT NULL,
  `id_conductor` int(11) NOT NULL,
  `tipo_referencia` varchar(50) NOT NULL,
  `nombre_referencia` varchar(100) NOT NULL,
  `telefono_referencia` varchar(15) NOT NULL,
  `direccion_referencia` varchar(100) NOT NULL,
  `estado` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `referencias_propietariovehiculo`
--

CREATE TABLE `referencias_propietariovehiculo` (
  `id_referencia` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `tipo_referencia` varchar(50) NOT NULL,
  `nombre_referencia` varchar(100) NOT NULL,
  `telefono_referencia` varchar(100) NOT NULL,
  `direccion_referencia` varchar(100) NOT NULL,
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `responsable_pasajero`
--

CREATE TABLE `responsable_pasajero` (
  `id_responsable` int(11) NOT NULL,
  `id_pasajero` int(11) NOT NULL,
  `nombre` varchar(1000) NOT NULL,
  `email` varchar(500) NOT NULL,
  `telefono1` int(11) NOT NULL,
  `telefono2` int(11) NOT NULL,
  `direccion` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rodamientos`
--

CREATE TABLE `rodamientos` (
  `id_rodamiento` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `nombre_cliente` varchar(100) NOT NULL,
  `tipo_identificacion` varchar(100) NOT NULL,
  `num_identificacion` int(11) NOT NULL,
  `valor_total` double NOT NULL,
  `por_vencer` double NOT NULL,
  `dias_mora_1_30` double NOT NULL,
  `dias_mora_31_60` double NOT NULL,
  `dias_mora_61_90` double NOT NULL,
  `dias_mora_mayor_90` double NOT NULL,
  `id_usuario_creador` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `consulta` int(1) NOT NULL,
  `edicion` int(1) NOT NULL,
  `agregacion` int(1) NOT NULL,
  `eliminacion` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ruta_pasajero`
--

CREATE TABLE `ruta_pasajero` (
  `id` double NOT NULL,
  `id_pasajero` int(11) NOT NULL,
  `id_ruta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `segmentos`
--

CREATE TABLE `segmentos` (
  `id_segmento` int(11) NOT NULL,
  `detalle` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `seguimientos_actualizaciones_documentos`
--

CREATE TABLE `seguimientos_actualizaciones_documentos` (
  `id_seguimiento` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_modulo` varchar(5) NOT NULL,
  `columnas` varchar(100) NOT NULL,
  `estado` varchar(1) NOT NULL,
  `novedad_rechazo` text,
  `documento` varchar(100) NOT NULL,
  `nueva_fecha_vencimiento` date NOT NULL,
  `id_registro` int(11) NOT NULL,
  `id_revision` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `seguridad_social_empleados`
--

CREATE TABLE `seguridad_social_empleados` (
  `id` int(11) NOT NULL,
  `nombre_documento` varchar(1000) NOT NULL,
  `seguridad_social` longtext NOT NULL,
  `anio` int(11) NOT NULL,
  `mes` int(11) NOT NULL,
  `usuario_carga_doc` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `servicios_variables`
--

CREATE TABLE `servicios_variables` (
  `id_servicio` int(11) NOT NULL,
  `id_solicitante` int(11) DEFAULT NULL,
  `unidad_operativa` varchar(1000) CHARACTER SET utf8 NOT NULL,
  `fecha_inicial` date NOT NULL,
  `fecha_final` date NOT NULL,
  `direccion` varchar(1000) CHARACTER SET utf8 NOT NULL,
  `lugar_destino` varchar(1000) CHARACTER SET utf8 NOT NULL,
  `hora_encuentro` time NOT NULL,
  `hora_regreso` time NOT NULL,
  `capacidad` int(11) NOT NULL,
  `cant_pax` int(11) NOT NULL,
  `observaciones` longtext CHARACTER SET utf8 NOT NULL,
  `tipo_servicio` varchar(1000) CHARACTER SET utf8 NOT NULL,
  `num_buses` int(11) NOT NULL,
  `estado` varchar(100) CHARACTER SET utf8 NOT NULL,
  `obsEstado` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  `fecha_registro` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sillas_viaje`
--

CREATE TABLE `sillas_viaje` (
  `id` int(11) NOT NULL,
  `numero_silla` char(2) NOT NULL,
  `estado` char(1) NOT NULL,
  `id_viaje` int(11) NOT NULL,
  `id_pasajero` int(11) DEFAULT NULL,
  `fecha_reserva` datetime DEFAULT NULL,
  `estado_reserva` char(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `solicitudes_vinculaciones`
--

CREATE TABLE `solicitudes_vinculaciones` (
  `id_solicitud_vinculacion` int(11) NOT NULL,
  `nombres_apellidos` varchar(1000) NOT NULL,
  `num_documento` int(11) NOT NULL,
  `telefono` int(15) NOT NULL,
  `correo_electronico` varchar(1000) NOT NULL,
  `ciudad_residencia` varchar(1000) NOT NULL,
  `placa` varchar(6) NOT NULL,
  `tipo_vehiculo` varchar(100) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `modelo` varchar(4) NOT NULL,
  `motivo` varchar(100) NOT NULL,
  `fecha` datetime NOT NULL,
  `estado` char(1) NOT NULL,
  `id_revisado_por` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `solicitud_cliente`
--

CREATE TABLE `solicitud_cliente` (
  `id_solicitud` int(11) NOT NULL,
  `servicios_ida` int(11) NOT NULL,
  `servicios_retorno` int(11) NOT NULL,
  `fecha_solicitud` datetime NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `estado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `status_cliente`
--

CREATE TABLE `status_cliente` (
  `id_status` int(11) NOT NULL,
  `detalle_status` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subcategoria_mantenimiento`
--

CREATE TABLE `subcategoria_mantenimiento` (
  `id_subcategoria` int(11) NOT NULL,
  `detalle_subcategoria` varchar(150) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subcategoria_proveedor`
--

CREATE TABLE `subcategoria_proveedor` (
  `id` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `id_subcategoria` int(11) NOT NULL,
  `costo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tarifas_productos_clientes`
--

CREATE TABLE `tarifas_productos_clientes` (
  `id_tarifa` int(11) NOT NULL,
  `id_tipo_vehiculo` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `valor_recorrido` json DEFAULT NULL,
  `valor_hora` json DEFAULT NULL,
  `recorridos_x_dia` json DEFAULT NULL,
  `valor_mensual` json DEFAULT NULL,
  `valor_relevo_sencillo` json DEFAULT NULL,
  `valor_relevo_doble` json DEFAULT NULL,
  `costo_disponibilidad` json DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tarifas_proyectos`
--

CREATE TABLE `tarifas_proyectos` (
  `id_tarifa_proyecto` int(11) NOT NULL,
  `id_proyecto` int(11) NOT NULL,
  `detalle` varchar(1000) NOT NULL,
  `id_tipo_vehiculo` int(11) NOT NULL,
  `tiempo_cobro` char(1) NOT NULL,
  `costo_servicio` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tarifas_terceros_proyectos`
--

CREATE TABLE `tarifas_terceros_proyectos` (
  `id_tarifa_tercero` int(11) NOT NULL,
  `id_proyecto` int(11) NOT NULL,
  `id_tarifa` int(11) NOT NULL,
  `valor` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tipos_servicios`
--

CREATE TABLE `tipos_servicios` (
  `id_tipo_servicio` int(11) NOT NULL,
  `nombre_tipo_servicio` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tipos_servicios_variables`
--

CREATE TABLE `tipos_servicios_variables` (
  `id` int(11) NOT NULL,
  `codigo` varchar(100) NOT NULL,
  `tipo_servicio` varchar(1000) NOT NULL,
  `pago_propietario` int(11) NOT NULL,
  `recorrido_adicional` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tipos_vehiculos`
--

CREATE TABLE `tipos_vehiculos` (
  `id_tipo_vehiculo` int(11) NOT NULL,
  `nombre_tipo_vehiculo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_actividad`
--

CREATE TABLE `tipo_actividad` (
  `id_tipo_actividad` int(11) NOT NULL,
  `detalle` varchar(100) NOT NULL,
  `posicion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_combustible`
--

CREATE TABLE `tipo_combustible` (
  `id_tipo` int(11) NOT NULL,
  `detalle` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_contacto_cobro`
--

CREATE TABLE `tipo_contacto_cobro` (
  `id` int(11) NOT NULL,
  `detalle` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_contrato`
--

CREATE TABLE `tipo_contrato` (
  `id_tipo_contrato` int(11) NOT NULL,
  `tipo_contrato` varchar(50) NOT NULL,
  `objeto_tipo_contrato` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_encuesta`
--

CREATE TABLE `tipo_encuesta` (
  `id_tipo_encuesta` int(11) NOT NULL,
  `detalle_tipo` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_movil`
--

CREATE TABLE `tipo_movil` (
  `id_tipo` int(11) NOT NULL,
  `tipo_movil` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_novedad`
--

CREATE TABLE `tipo_novedad` (
  `id_novedad` int(11) NOT NULL,
  `detalle` varchar(250) NOT NULL,
  `posicion` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_novedades_servicios`
--

CREATE TABLE `tipo_novedades_servicios` (
  `id_tipo_novedad` int(11) NOT NULL,
  `tipo_novedad` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_pasajero`
--

CREATE TABLE `tipo_pasajero` (
  `id_tipo` double NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_pregunta`
--

CREATE TABLE `tipo_pregunta` (
  `id_tipo_pregunta` int(11) NOT NULL,
  `detalle` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_servicio_cliente`
--

CREATE TABLE `tipo_servicio_cliente` (
  `id_tipo_servicio` int(11) NOT NULL,
  `nombre_tipo_servicio` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_servicio_mantenimiento`
--

CREATE TABLE `tipo_servicio_mantenimiento` (
  `id_tipo_servicio` int(11) NOT NULL,
  `detalle_tipo` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_servicio_solicitud`
--

CREATE TABLE `tipo_servicio_solicitud` (
  `id_tipo_servicio` int(11) NOT NULL,
  `detalle` varchar(250) NOT NULL,
  `id_tipo_vehiculo` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `unidades_operativas_programacion`
--

CREATE TABLE `unidades_operativas_programacion` (
  `id_unidad` int(11) NOT NULL,
  `unidad_operativa` varchar(1000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `id_perfil` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `correo_electronico` varchar(50) NOT NULL,
  `estado` int(1) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `id_cargo` int(11) NOT NULL,
  `cant_ingresos` int(11) NOT NULL,
  `fecha_ultimo_ingreso` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios_contratos_fijos`
--

CREATE TABLE `usuarios_contratos_fijos` (
  `id` int(11) NOT NULL,
  `id_contrato` int(11) NOT NULL,
  `nombre_usuario` varchar(500) NOT NULL,
  `numero_documento` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios_contratos_ocasionales`
--

CREATE TABLE `usuarios_contratos_ocasionales` (
  `id` int(11) NOT NULL,
  `id_contrato` int(11) NOT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `numero_documento` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios_internos_firmas`
--

CREATE TABLE `usuarios_internos_firmas` (
  `id_usuario_firma` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `firma` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `usuario_cliente`
--

CREATE TABLE `usuario_cliente` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vales_generados`
--

CREATE TABLE `vales_generados` (
  `id` int(11) NOT NULL,
  `empresa` varchar(3) NOT NULL,
  `num_inicial` int(11) NOT NULL,
  `num_final` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id_vehiculo` int(11) NOT NULL,
  `placa` varchar(8) NOT NULL,
  `modelo` year(4) NOT NULL,
  `marca` varchar(1000) NOT NULL,
  `cant_pasajeros` int(11) NOT NULL,
  `id_tipo_movil` int(11) DEFAULT NULL,
  `id_tipo_servicio` int(11) NOT NULL,
  `id_tipo_vehiculo` int(11) NOT NULL,
  `tipo_afiliacion` text,
  `empresa_afiliada` varchar(100) DEFAULT NULL,
  `nit_empresa_afiliada` varchar(100) DEFAULT NULL,
  `numero_movil` varchar(50) DEFAULT '0',
  `numero_motor` varchar(50) NOT NULL,
  `numero_chasis` varchar(50) NOT NULL,
  `id_propietario` int(11) NOT NULL,
  `telefono_propietario` varchar(20) NOT NULL,
  `fotocopia_cedula_propietario` text NOT NULL,
  `fecha_nac_propietario` date DEFAULT '0000-00-00',
  `direccion_propietario` varchar(500) DEFAULT NULL,
  `ciudad_propietario` varchar(500) DEFAULT NULL,
  `tarjeta_operacion` text NOT NULL,
  `num_tarjeta_operacion` varchar(100) NOT NULL,
  `fecha_vencimiento_to` date DEFAULT NULL,
  `licencia_transito` text NOT NULL,
  `num_licencia_transito` text,
  `fecha_vencimiento_lt` date DEFAULT NULL,
  `soat` text NOT NULL,
  `num_soat` text,
  `fecha_vencimiento_soat` date DEFAULT NULL,
  `revision_tecnomecanica` text NOT NULL,
  `num_revision_tecnomecanica` text,
  `fecha_vencimiento_rt` date DEFAULT NULL,
  `revision_preventiva` text NOT NULL,
  `fecha_vencimiento_rp` date DEFAULT NULL,
  `poliza_contra` text NOT NULL,
  `num_poliza_contra` text,
  `fecha_vencimiento_contra` date DEFAULT NULL,
  `poliza_extra` text NOT NULL,
  `num_poliza_extra` text,
  `fecha_vencimiento_extra` date DEFAULT NULL,
  `disp_velocidad` varchar(500) DEFAULT NULL,
  `fecha_exp_disp_velocidad` date DEFAULT NULL,
  `tipo_propietario` varchar(50) NOT NULL,
  `propiedad` varchar(50) NOT NULL,
  `camara_comercio` varchar(500) DEFAULT NULL,
  `contrato_banco` varchar(500) DEFAULT NULL,
  `contrato_vinculacion` varchar(500) DEFAULT NULL,
  `fecha_exp_contrato_vinculacion` date NOT NULL,
  `ficha_tecnica_homologacion` varchar(500) NOT NULL,
  `seguro_todo_riesgo` varchar(500) NOT NULL,
  `num_seguro_todo_riesgo` text,
  `fecha_vencimiento_seguro_todo_riesgo` date NOT NULL,
  `hoja_vida` varchar(500) NOT NULL,
  `rut` varchar(500) NOT NULL,
  `poder_apoderado` varchar(500) NOT NULL,
  `flota_propia` varchar(1) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `fecha_registro` date DEFAULT '0000-00-00',
  `ciudad_registro` varchar(500) DEFAULT NULL,
  `num_puertas` int(11) DEFAULT NULL,
  `cilindraje` int(11) DEFAULT NULL,
  `tipo_carroceria` varchar(100) DEFAULT NULL,
  `tipo_combustible` varchar(100) DEFAULT NULL,
  `estado` int(1) NOT NULL,
  `soporte_cambio_estado` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vehiculos_conductores`
--

CREATE TABLE `vehiculos_conductores` (
  `id` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `id_conductor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vehiculos_contratos`
--

CREATE TABLE `vehiculos_contratos` (
  `id` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `id_contrato` int(11) NOT NULL,
  `tipo_contrato` varchar(10) DEFAULT NULL,
  `id_centro_costo` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vehiculos_eximidos_pagos`
--

CREATE TABLE `vehiculos_eximidos_pagos` (
  `id_eximido` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `fecha_inicial_validez` date NOT NULL,
  `fecha_final_validez` date NOT NULL,
  `comprobante_eximido` text NOT NULL,
  `fecha_activacion` datetime NOT NULL,
  `id_usuario_activacion` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vehiculo_ruta`
--

CREATE TABLE `vehiculo_ruta` (
  `id` double NOT NULL,
  `id_vehiculo` double NOT NULL,
  `id_cliente` double NOT NULL,
  `id_conductor` double DEFAULT NULL,
  `id_monitor` double DEFAULT NULL,
  `num_ruta` varchar(25) DEFAULT NULL,
  `sigla` varchar(50) NOT NULL,
  `recorrido` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vehiculo_servicio`
--

CREATE TABLE `vehiculo_servicio` (
  `id_asignacion` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `id_conductor` int(11) NOT NULL,
  `id_servicio` int(11) NOT NULL,
  `estado` char(1) NOT NULL,
  `seguimiento1` longtext NOT NULL,
  `seguimiento2` longtext NOT NULL,
  `seguimiento3` longtext NOT NULL,
  `id_usu_seguimiento` int(11) NOT NULL,
  `id_usu_asignacion` int(11) NOT NULL,
  `fecha_asignacion` datetime NOT NULL,
  `firma` varchar(500) NOT NULL,
  `valor_pagar` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `viaje`
--

CREATE TABLE `viaje` (
  `id_viaje` int(11) NOT NULL,
  `id_ruta` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `id_conductor` int(11) NOT NULL,
  `estado` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vinculacion_clientes`
--

CREATE TABLE `vinculacion_clientes` (
  `id_cliente` int(11) NOT NULL,
  `razon_social` varchar(1000) NOT NULL,
  `nit` varchar(100) NOT NULL,
  `direccion` varchar(1000) NOT NULL,
  `telefono` int(11) NOT NULL,
  `tipo_cliente` int(11) NOT NULL,
  `representante_legal` varchar(1000) NOT NULL,
  `ciudad_residencia` varchar(1000) NOT NULL,
  `num_documento` int(11) NOT NULL,
  `fecha_expedicion` date NOT NULL,
  `lugar_expedicion` varchar(1000) NOT NULL,
  `logo_cliente` varchar(1000) NOT NULL,
  `estado` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vinculacion_contratos`
--

CREATE TABLE `vinculacion_contratos` (
  `id_contrato` int(11) NOT NULL,
  `numero_contrato` int(11) NOT NULL,
  `id_tipo_contrato` varchar(100) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `fecha_inicial` date NOT NULL,
  `fecha_final` date NOT NULL,
  `fotocopia_contrato` longtext NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `creador` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `volumen_venta_cliente`
--

CREATE TABLE `volumen_venta_cliente` (
  `id_volumen` int(11) NOT NULL,
  `detalle_volumen` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actas`
--
ALTER TABLE `actas`
  ADD PRIMARY KEY (`id_acta`);

--
-- Indexes for table `acta_agenda`
--
ALTER TABLE `acta_agenda`
  ADD PRIMARY KEY (`id_agenda`);

--
-- Indexes for table `acta_estado_situacion`
--
ALTER TABLE `acta_estado_situacion`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indexes for table `acta_invitados`
--
ALTER TABLE `acta_invitados`
  ADD PRIMARY KEY (`id_invitado`);

--
-- Indexes for table `acta_situaciones`
--
ALTER TABLE `acta_situaciones`
  ADD PRIMARY KEY (`id_situacion`);

--
-- Indexes for table `acuerdos_pago`
--
ALTER TABLE `acuerdos_pago`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `acuerdos_pago_cobro`
--
ALTER TABLE `acuerdos_pago_cobro`
  ADD PRIMARY KEY (`id_acuerdo`);

--
-- Indexes for table `afiliados`
--
ALTER TABLE `afiliados`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `anticipo_cartera`
--
ALTER TABLE `anticipo_cartera`
  ADD PRIMARY KEY (`id_anticipo`);

--
-- Indexes for table `aprobacion_fuec`
--
ALTER TABLE `aprobacion_fuec`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id_area`);

--
-- Indexes for table `asignaciones`
--
ALTER TABLE `asignaciones`
  ADD PRIMARY KEY (`id_asignacion`);

--
-- Indexes for table `aval_vehiculos`
--
ALTER TABLE `aval_vehiculos`
  ADD PRIMARY KEY (`id_aval`);

--
-- Indexes for table `base_servicios`
--
ALTER TABLE `base_servicios`
  ADD PRIMARY KEY (`id_servicio_base`);

--
-- Indexes for table `base_servicio_vehiculos`
--
ALTER TABLE `base_servicio_vehiculos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bitacora_acciones`
--
ALTER TABLE `bitacora_acciones`
  ADD PRIMARY KEY (`id_bitacora`);

--
-- Indexes for table `bitacora_transacciones`
--
ALTER TABLE `bitacora_transacciones`
  ADD PRIMARY KEY (`id_transaccion`);

--
-- Indexes for table `cargos`
--
ALTER TABLE `cargos`
  ADD PRIMARY KEY (`id_cargo`);

--
-- Indexes for table `cargo_cliente`
--
ALTER TABLE `cargo_cliente`
  ADD PRIMARY KEY (`id_cargo`);

--
-- Indexes for table `categoria_mantenimiento`
--
ALTER TABLE `categoria_mantenimiento`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indexes for table `centro_costo_cliente`
--
ALTER TABLE `centro_costo_cliente`
  ADD PRIMARY KEY (`id_centro_costo`);

--
-- Indexes for table `ciudades`
--
ALTER TABLE `ciudades`
  ADD PRIMARY KEY (`id_ciudad`);

--
-- Indexes for table `ciudades_fuec`
--
ALTER TABLE `ciudades_fuec`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clases_movil_cliente`
--
ALTER TABLE `clases_movil_cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indexes for table `clientesConvenio_vehiculos`
--
ALTER TABLE `clientesConvenio_vehiculos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clientes_convenios`
--
ALTER TABLE `clientes_convenios`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indexes for table `clientes_propietarios`
--
ALTER TABLE `clientes_propietarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cliente_prospecto`
--
ALTER TABLE `cliente_prospecto`
  ADD PRIMARY KEY (`id_prospecto`);

--
-- Indexes for table `cobro_cartera`
--
ALTER TABLE `cobro_cartera`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cobro_propietario`
--
ALTER TABLE `cobro_propietario`
  ADD PRIMARY KEY (`id_cobro`);

--
-- Indexes for table `cobro_tipo_vehiculo`
--
ALTER TABLE `cobro_tipo_vehiculo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comprobantes_cobro_cartera`
--
ALTER TABLE `comprobantes_cobro_cartera`
  ADD PRIMARY KEY (`id_comprobante`);

--
-- Indexes for table `comprobantes_pagos_propietarios`
--
ALTER TABLE `comprobantes_pagos_propietarios`
  ADD PRIMARY KEY (`id_comprobante`);

--
-- Indexes for table `conceptos_cobro`
--
ALTER TABLE `conceptos_cobro`
  ADD PRIMARY KEY (`id_concepto`);

--
-- Indexes for table `conductores`
--
ALTER TABLE `conductores`
  ADD PRIMARY KEY (`id_conductor`);

--
-- Indexes for table `conductor_seg_social`
--
ALTER TABLE `conductor_seg_social`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacto_cliente`
--
ALTER TABLE `contacto_cliente`
  ADD PRIMARY KEY (`id_contacto`);

--
-- Indexes for table `contratos`
--
ALTER TABLE `contratos`
  ADD PRIMARY KEY (`id_contrato`);

--
-- Indexes for table `contratos_ocasionales`
--
ALTER TABLE `contratos_ocasionales`
  ADD PRIMARY KEY (`id_contrato_ocasional`);

--
-- Indexes for table `control_mantenimientos`
--
ALTER TABLE `control_mantenimientos`
  ADD PRIMARY KEY (`id_mantenimiento`);

--
-- Indexes for table `convenios`
--
ALTER TABLE `convenios`
  ADD PRIMARY KEY (`id_convenio`);

--
-- Indexes for table `correspondencia_docs`
--
ALTER TABLE `correspondencia_docs`
  ADD PRIMARY KEY (`id_doc`);

--
-- Indexes for table `correspondencia_tipos`
--
ALTER TABLE `correspondencia_tipos`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indexes for table `cotizacion_concepto_general`
--
ALTER TABLE `cotizacion_concepto_general`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cotizacion_concepto_vehiculo`
--
ALTER TABLE `cotizacion_concepto_vehiculo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cotizacion_costo_conductor`
--
ALTER TABLE `cotizacion_costo_conductor`
  ADD PRIMARY KEY (`id_costo_conductor`);

--
-- Indexes for table `cotizacion_destino`
--
ALTER TABLE `cotizacion_destino`
  ADD PRIMARY KEY (`id_destino`);

--
-- Indexes for table `cotizador_cotizacion`
--
ALTER TABLE `cotizador_cotizacion`
  ADD PRIMARY KEY (`id_cotizacion`);

--
-- Indexes for table `cotizador_descuento`
--
ALTER TABLE `cotizador_descuento`
  ADD PRIMARY KEY (`id_descuento`);

--
-- Indexes for table `cotizador_destinos`
--
ALTER TABLE `cotizador_destinos`
  ADD PRIMARY KEY (`id_destino`);

--
-- Indexes for table `cotizador_empresa`
--
ALTER TABLE `cotizador_empresa`
  ADD PRIMARY KEY (`id_empresa`);

--
-- Indexes for table `cotizador_paginas_formato`
--
ALTER TABLE `cotizador_paginas_formato`
  ADD PRIMARY KEY (`id_pag`);

--
-- Indexes for table `cotizador_tarifa_individual`
--
ALTER TABLE `cotizador_tarifa_individual`
  ADD PRIMARY KEY (`id_tarifa`);

--
-- Indexes for table `cotizador_usuario`
--
ALTER TABLE `cotizador_usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indexes for table `cruce_saldos_anticipos`
--
ALTER TABLE `cruce_saldos_anticipos`
  ADD PRIMARY KEY (`id_cruce`);

--
-- Indexes for table `cuentas_bancos`
--
ALTER TABLE `cuentas_bancos`
  ADD PRIMARY KEY (`id_cuenta`);

--
-- Indexes for table `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`id_curso`);

--
-- Indexes for table `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id_departamento`);

--
-- Indexes for table `descuentos_cartera`
--
ALTER TABLE `descuentos_cartera`
  ADD PRIMARY KEY (`id_descuento`);

--
-- Indexes for table `descuentos_cruzados`
--
ALTER TABLE `descuentos_cruzados`
  ADD PRIMARY KEY (`id_cruce`);

--
-- Indexes for table `descuentos_flota_propia`
--
ALTER TABLE `descuentos_flota_propia`
  ADD PRIMARY KEY (`id_descuento`);

--
-- Indexes for table `desinfeccion`
--
ALTER TABLE `desinfeccion`
  ADD PRIMARY KEY (`id_desinfeccion`);

--
-- Indexes for table `destino`
--
ALTER TABLE `destino`
  ADD PRIMARY KEY (`id_destino`);

--
-- Indexes for table `destino_cliente`
--
ALTER TABLE `destino_cliente`
  ADD PRIMARY KEY (`id_destino`);

--
-- Indexes for table `detalle`
--
ALTER TABLE `detalle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detalles_operaciones`
--
ALTER TABLE `detalles_operaciones`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_operacion` (`id_operacion`),
  ADD KEY `id_vehiculo` (`id_vehiculo`);

--
-- Indexes for table `detalle_gastos_personales`
--
ALTER TABLE `detalle_gastos_personales`
  ADD PRIMARY KEY (`id_detalle_gasto`);

--
-- Indexes for table `detalle_orden_servicio`
--
ALTER TABLE `detalle_orden_servicio`
  ADD PRIMARY KEY (`id_servicio`);

--
-- Indexes for table `detalle_recorrido_fijo`
--
ALTER TABLE `detalle_recorrido_fijo`
  ADD PRIMARY KEY (`id_detalle`);

--
-- Indexes for table `detalle_solicitud`
--
ALTER TABLE `detalle_solicitud`
  ADD PRIMARY KEY (`id_detalle`);

--
-- Indexes for table `documento_contrato_ocasional_propietario`
--
ALTER TABLE `documento_contrato_ocasional_propietario`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id_empleado`);

--
-- Indexes for table `empleado_cursos`
--
ALTER TABLE `empleado_cursos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `empleado_estudio`
--
ALTER TABLE `empleado_estudio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `empleado_experiencia`
--
ALTER TABLE `empleado_experiencia`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `empleado_otros_docs`
--
ALTER TABLE `empleado_otros_docs`
  ADD PRIMARY KEY (`id_doc`);

--
-- Indexes for table `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id_empresa`);

--
-- Indexes for table `encuesta`
--
ALTER TABLE `encuesta`
  ADD PRIMARY KEY (`id_encuesta`),
  ADD KEY `fk_id_tipo_encuesta` (`id_tipo_encuesta`);

--
-- Indexes for table `encuesta_data_operativa`
--
ALTER TABLE `encuesta_data_operativa`
  ADD PRIMARY KEY (`id_data_operativa`);

--
-- Indexes for table `encuesta_diligenciada`
--
ALTER TABLE `encuesta_diligenciada`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_encuesta` (`id_encuesta`),
  ADD KEY `fk_id_pregunta` (`id_pregunta`);

--
-- Indexes for table `encuesta_notificacion_positiva`
--
ALTER TABLE `encuesta_notificacion_positiva`
  ADD PRIMARY KEY (`id_notificacion`);

--
-- Indexes for table `encuesta_notificacion_positiva_personas_contacto`
--
ALTER TABLE `encuesta_notificacion_positiva_personas_contacto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `encuesta_pregunta`
--
ALTER TABLE `encuesta_pregunta`
  ADD PRIMARY KEY (`id_pregunta`),
  ADD KEY `fk_id_tipo_pregunta` (`id_tipo_pregunta`),
  ADD KEY `fk_id_encuesta` (`id_encuesta`);

--
-- Indexes for table `encuesta_respuesta`
--
ALTER TABLE `encuesta_respuesta`
  ADD PRIMARY KEY (`id_respuesta`),
  ADD KEY `fk_id_pregunta` (`id_pregunta`);

--
-- Indexes for table `encuesta_salud`
--
ALTER TABLE `encuesta_salud`
  ADD PRIMARY KEY (`id_respuesta`);

--
-- Indexes for table `encuesta_vulnerabilidad`
--
ALTER TABLE `encuesta_vulnerabilidad`
  ADD PRIMARY KEY (`id_respuesta`);

--
-- Indexes for table `enfoque_objetivo`
--
ALTER TABLE `enfoque_objetivo`
  ADD PRIMARY KEY (`id_enfoque`);

--
-- Indexes for table `estado_acuerdos_pago`
--
ALTER TABLE `estado_acuerdos_pago`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indexes for table `facturaciones`
--
ALTER TABLE `facturaciones`
  ADD PRIMARY KEY (`id_facturacion`);

--
-- Indexes for table `finalizacion_servicio`
--
ALTER TABLE `finalizacion_servicio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flota_propia`
--
ALTER TABLE `flota_propia`
  ADD PRIMARY KEY (`id_flota_propia`);

--
-- Indexes for table `fotografias_vehiculos`
--
ALTER TABLE `fotografias_vehiculos`
  ADD PRIMARY KEY (`id_fotografia`);

--
-- Indexes for table `foto_vehiculo`
--
ALTER TABLE `foto_vehiculo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frecuencia_cliente`
--
ALTER TABLE `frecuencia_cliente`
  ADD PRIMARY KEY (`id_frecuencia`);

--
-- Indexes for table `fuec`
--
ALTER TABLE `fuec`
  ADD PRIMARY KEY (`id_fuec`);

--
-- Indexes for table `fuec_preliminar`
--
ALTER TABLE `fuec_preliminar`
  ADD PRIMARY KEY (`id_fuec`);

--
-- Indexes for table `fuente`
--
ALTER TABLE `fuente`
  ADD PRIMARY KEY (`id_fuente`);

--
-- Indexes for table `gestion_cobro`
--
ALTER TABLE `gestion_cobro`
  ADD PRIMARY KEY (`id_gestion`);

--
-- Indexes for table `inspeccion_evidencias`
--
ALTER TABLE `inspeccion_evidencias`
  ADD PRIMARY KEY (`id_evidencia`);

--
-- Indexes for table `inspeccion_vehicular`
--
ALTER TABLE `inspeccion_vehicular`
  ADD PRIMARY KEY (`id_inspeccion`);

--
-- Indexes for table `intranet_banners`
--
ALTER TABLE `intranet_banners`
  ADD PRIMARY KEY (`id_banner`);

--
-- Indexes for table `intranet_categorias`
--
ALTER TABLE `intranet_categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indexes for table `intranet_clasificados`
--
ALTER TABLE `intranet_clasificados`
  ADD PRIMARY KEY (`id_clasificado`);

--
-- Indexes for table `intranet_galeria_imgs`
--
ALTER TABLE `intranet_galeria_imgs`
  ADD PRIMARY KEY (`id_imagen`);

--
-- Indexes for table `intranet_noticias`
--
ALTER TABLE `intranet_noticias`
  ADD PRIMARY KEY (`id_noticia`);

--
-- Indexes for table `intranet_publicaciones`
--
ALTER TABLE `intranet_publicaciones`
  ADD PRIMARY KEY (`id_publicacion`);

--
-- Indexes for table `mantenimineto_fp`
--
ALTER TABLE `mantenimineto_fp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mensajes_afiliados`
--
ALTER TABLE `mensajes_afiliados`
  ADD PRIMARY KEY (`id_mensaje`);

--
-- Indexes for table `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id_modulo`);

--
-- Indexes for table `notificaciones_comprobantesPagos`
--
ALTER TABLE `notificaciones_comprobantesPagos`
  ADD PRIMARY KEY (`id_notificacion_comprobante`);

--
-- Indexes for table `novedad`
--
ALTER TABLE `novedad`
  ADD PRIMARY KEY (`id_novedad`);

--
-- Indexes for table `novedad_pasajero`
--
ALTER TABLE `novedad_pasajero`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `novedad_servicio`
--
ALTER TABLE `novedad_servicio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `objetivo_general`
--
ALTER TABLE `objetivo_general`
  ADD PRIMARY KEY (`id_objetivo`);

--
-- Indexes for table `operaciones`
--
ALTER TABLE `operaciones`
  ADD PRIMARY KEY (`id_operacion`);

--
-- Indexes for table `orden_servicio`
--
ALTER TABLE `orden_servicio`
  ADD PRIMARY KEY (`id_orden`);

--
-- Indexes for table `origen`
--
ALTER TABLE `origen`
  ADD PRIMARY KEY (`id_origen`);

--
-- Indexes for table `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pago_recibido`
--
ALTER TABLE `pago_recibido`
  ADD PRIMARY KEY (`id_pago`);

--
-- Indexes for table `paises`
--
ALTER TABLE `paises`
  ADD PRIMARY KEY (`id_pais`);

--
-- Indexes for table `paquetes_plus_vehiculos`
--
ALTER TABLE `paquetes_plus_vehiculos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pasajero`
--
ALTER TABLE `pasajero`
  ADD PRIMARY KEY (`id_pasajero`);

--
-- Indexes for table `pasajero_ruta_fija`
--
ALTER TABLE `pasajero_ruta_fija`
  ADD PRIMARY KEY (`id_pasajero`);

--
-- Indexes for table `perfiles`
--
ALTER TABLE `perfiles`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Indexes for table `permisos_usuarios_mod_operativo`
--
ALTER TABLE `permisos_usuarios_mod_operativo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permisos_usuarios_mod_vehiculos`
--
ALTER TABLE `permisos_usuarios_mod_vehiculos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `polizas_cartera`
--
ALTER TABLE `polizas_cartera`
  ADD PRIMARY KEY (`id_poliza`);

--
-- Indexes for table `preoperacionales`
--
ALTER TABLE `preoperacionales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `preoperacionalGEB`
--
ALTER TABLE `preoperacionalGEB`
  ADD PRIMARY KEY (`id_preoperacional`);

--
-- Indexes for table `productos_clientes`
--
ALTER TABLE `productos_clientes`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indexes for table `programacion_servicios`
--
ALTER TABLE `programacion_servicios`
  ADD PRIMARY KEY (`id_programacion`);

--
-- Indexes for table `propietarios`
--
ALTER TABLE `propietarios`
  ADD PRIMARY KEY (`id_propietario`);

--
-- Indexes for table `proveedor_mantenimiento`
--
ALTER TABLE `proveedor_mantenimiento`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indexes for table `proyectos_contratos`
--
ALTER TABLE `proyectos_contratos`
  ADD PRIMARY KEY (`id_proyecto`);

--
-- Indexes for table `proyectos_data_operativa`
--
ALTER TABLE `proyectos_data_operativa`
  ADD PRIMARY KEY (`id_proyecto`);

--
-- Indexes for table `recibosCaja`
--
ALTER TABLE `recibosCaja`
  ADD PRIMARY KEY (`id_recibo_caja`);

--
-- Indexes for table `recorrido`
--
ALTER TABLE `recorrido`
  ADD PRIMARY KEY (`id_recorrido`);

--
-- Indexes for table `recorrido_ruta_fija`
--
ALTER TABLE `recorrido_ruta_fija`
  ADD PRIMARY KEY (`id_recorrido`);

--
-- Indexes for table `referencias_conductor`
--
ALTER TABLE `referencias_conductor`
  ADD PRIMARY KEY (`id_referencia`);

--
-- Indexes for table `referencias_propietariovehiculo`
--
ALTER TABLE `referencias_propietariovehiculo`
  ADD PRIMARY KEY (`id_referencia`);

--
-- Indexes for table `rodamientos`
--
ALTER TABLE `rodamientos`
  ADD PRIMARY KEY (`id_rodamiento`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indexes for table `ruta_pasajero`
--
ALTER TABLE `ruta_pasajero`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `segmentos`
--
ALTER TABLE `segmentos`
  ADD PRIMARY KEY (`id_segmento`);

--
-- Indexes for table `seguimientos_actualizaciones_documentos`
--
ALTER TABLE `seguimientos_actualizaciones_documentos`
  ADD PRIMARY KEY (`id_seguimiento`);

--
-- Indexes for table `seguridad_social_empleados`
--
ALTER TABLE `seguridad_social_empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `servicios_variables`
--
ALTER TABLE `servicios_variables`
  ADD PRIMARY KEY (`id_servicio`);

--
-- Indexes for table `sillas_viaje`
--
ALTER TABLE `sillas_viaje`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `solicitudes_vinculaciones`
--
ALTER TABLE `solicitudes_vinculaciones`
  ADD PRIMARY KEY (`id_solicitud_vinculacion`);

--
-- Indexes for table `solicitud_cliente`
--
ALTER TABLE `solicitud_cliente`
  ADD PRIMARY KEY (`id_solicitud`);

--
-- Indexes for table `status_cliente`
--
ALTER TABLE `status_cliente`
  ADD PRIMARY KEY (`id_status`);

--
-- Indexes for table `subcategoria_mantenimiento`
--
ALTER TABLE `subcategoria_mantenimiento`
  ADD PRIMARY KEY (`id_subcategoria`);

--
-- Indexes for table `subcategoria_proveedor`
--
ALTER TABLE `subcategoria_proveedor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tarifas_productos_clientes`
--
ALTER TABLE `tarifas_productos_clientes`
  ADD PRIMARY KEY (`id_tarifa`);

--
-- Indexes for table `tarifas_proyectos`
--
ALTER TABLE `tarifas_proyectos`
  ADD PRIMARY KEY (`id_tarifa_proyecto`);

--
-- Indexes for table `tarifas_terceros_proyectos`
--
ALTER TABLE `tarifas_terceros_proyectos`
  ADD PRIMARY KEY (`id_tarifa_tercero`);

--
-- Indexes for table `tipos_servicios`
--
ALTER TABLE `tipos_servicios`
  ADD PRIMARY KEY (`id_tipo_servicio`);

--
-- Indexes for table `tipos_servicios_variables`
--
ALTER TABLE `tipos_servicios_variables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipos_vehiculos`
--
ALTER TABLE `tipos_vehiculos`
  ADD PRIMARY KEY (`id_tipo_vehiculo`);

--
-- Indexes for table `tipo_actividad`
--
ALTER TABLE `tipo_actividad`
  ADD PRIMARY KEY (`id_tipo_actividad`);

--
-- Indexes for table `tipo_combustible`
--
ALTER TABLE `tipo_combustible`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indexes for table `tipo_contacto_cobro`
--
ALTER TABLE `tipo_contacto_cobro`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipo_contrato`
--
ALTER TABLE `tipo_contrato`
  ADD PRIMARY KEY (`id_tipo_contrato`);

--
-- Indexes for table `tipo_encuesta`
--
ALTER TABLE `tipo_encuesta`
  ADD PRIMARY KEY (`id_tipo_encuesta`);

--
-- Indexes for table `tipo_movil`
--
ALTER TABLE `tipo_movil`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indexes for table `tipo_novedad`
--
ALTER TABLE `tipo_novedad`
  ADD PRIMARY KEY (`id_novedad`);

--
-- Indexes for table `tipo_novedades_servicios`
--
ALTER TABLE `tipo_novedades_servicios`
  ADD PRIMARY KEY (`id_tipo_novedad`);

--
-- Indexes for table `tipo_pasajero`
--
ALTER TABLE `tipo_pasajero`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indexes for table `tipo_pregunta`
--
ALTER TABLE `tipo_pregunta`
  ADD PRIMARY KEY (`id_tipo_pregunta`);

--
-- Indexes for table `tipo_servicio_cliente`
--
ALTER TABLE `tipo_servicio_cliente`
  ADD PRIMARY KEY (`id_tipo_servicio`);

--
-- Indexes for table `tipo_servicio_mantenimiento`
--
ALTER TABLE `tipo_servicio_mantenimiento`
  ADD PRIMARY KEY (`id_tipo_servicio`);

--
-- Indexes for table `tipo_servicio_solicitud`
--
ALTER TABLE `tipo_servicio_solicitud`
  ADD PRIMARY KEY (`id_tipo_servicio`);

--
-- Indexes for table `unidades_operativas_programacion`
--
ALTER TABLE `unidades_operativas_programacion`
  ADD PRIMARY KEY (`id_unidad`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`,`usuario`);

--
-- Indexes for table `usuarios_contratos_fijos`
--
ALTER TABLE `usuarios_contratos_fijos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios_contratos_ocasionales`
--
ALTER TABLE `usuarios_contratos_ocasionales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios_internos_firmas`
--
ALTER TABLE `usuarios_internos_firmas`
  ADD PRIMARY KEY (`id_usuario_firma`);

--
-- Indexes for table `usuario_cliente`
--
ALTER TABLE `usuario_cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vales_generados`
--
ALTER TABLE `vales_generados`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id_vehiculo`);

--
-- Indexes for table `vehiculos_conductores`
--
ALTER TABLE `vehiculos_conductores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehiculos_contratos`
--
ALTER TABLE `vehiculos_contratos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehiculos_eximidos_pagos`
--
ALTER TABLE `vehiculos_eximidos_pagos`
  ADD PRIMARY KEY (`id_eximido`);

--
-- Indexes for table `vehiculo_ruta`
--
ALTER TABLE `vehiculo_ruta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehiculo_servicio`
--
ALTER TABLE `vehiculo_servicio`
  ADD PRIMARY KEY (`id_asignacion`);

--
-- Indexes for table `viaje`
--
ALTER TABLE `viaje`
  ADD PRIMARY KEY (`id_viaje`);

--
-- Indexes for table `vinculacion_clientes`
--
ALTER TABLE `vinculacion_clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indexes for table `vinculacion_contratos`
--
ALTER TABLE `vinculacion_contratos`
  ADD PRIMARY KEY (`id_contrato`);

--
-- Indexes for table `volumen_venta_cliente`
--
ALTER TABLE `volumen_venta_cliente`
  ADD PRIMARY KEY (`id_volumen`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actas`
--
ALTER TABLE `actas`
  MODIFY `id_acta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acta_agenda`
--
ALTER TABLE `acta_agenda`
  MODIFY `id_agenda` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acta_estado_situacion`
--
ALTER TABLE `acta_estado_situacion`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acta_invitados`
--
ALTER TABLE `acta_invitados`
  MODIFY `id_invitado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acta_situaciones`
--
ALTER TABLE `acta_situaciones`
  MODIFY `id_situacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acuerdos_pago`
--
ALTER TABLE `acuerdos_pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acuerdos_pago_cobro`
--
ALTER TABLE `acuerdos_pago_cobro`
  MODIFY `id_acuerdo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `afiliados`
--
ALTER TABLE `afiliados`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `anticipo_cartera`
--
ALTER TABLE `anticipo_cartera`
  MODIFY `id_anticipo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `aprobacion_fuec`
--
ALTER TABLE `aprobacion_fuec`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id_area` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asignaciones`
--
ALTER TABLE `asignaciones`
  MODIFY `id_asignacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `aval_vehiculos`
--
ALTER TABLE `aval_vehiculos`
  MODIFY `id_aval` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `base_servicios`
--
ALTER TABLE `base_servicios`
  MODIFY `id_servicio_base` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `base_servicio_vehiculos`
--
ALTER TABLE `base_servicio_vehiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bitacora_acciones`
--
ALTER TABLE `bitacora_acciones`
  MODIFY `id_bitacora` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bitacora_transacciones`
--
ALTER TABLE `bitacora_transacciones`
  MODIFY `id_transaccion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cargos`
--
ALTER TABLE `cargos`
  MODIFY `id_cargo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cargo_cliente`
--
ALTER TABLE `cargo_cliente`
  MODIFY `id_cargo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categoria_mantenimiento`
--
ALTER TABLE `categoria_mantenimiento`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `centro_costo_cliente`
--
ALTER TABLE `centro_costo_cliente`
  MODIFY `id_centro_costo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ciudades`
--
ALTER TABLE `ciudades`
  MODIFY `id_ciudad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ciudades_fuec`
--
ALTER TABLE `ciudades_fuec`
  MODIFY `id` double NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clases_movil_cliente`
--
ALTER TABLE `clases_movil_cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clientesConvenio_vehiculos`
--
ALTER TABLE `clientesConvenio_vehiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clientes_convenios`
--
ALTER TABLE `clientes_convenios`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clientes_propietarios`
--
ALTER TABLE `clientes_propietarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cliente_prospecto`
--
ALTER TABLE `cliente_prospecto`
  MODIFY `id_prospecto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cobro_cartera`
--
ALTER TABLE `cobro_cartera`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cobro_propietario`
--
ALTER TABLE `cobro_propietario`
  MODIFY `id_cobro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cobro_tipo_vehiculo`
--
ALTER TABLE `cobro_tipo_vehiculo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comprobantes_cobro_cartera`
--
ALTER TABLE `comprobantes_cobro_cartera`
  MODIFY `id_comprobante` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comprobantes_pagos_propietarios`
--
ALTER TABLE `comprobantes_pagos_propietarios`
  MODIFY `id_comprobante` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conceptos_cobro`
--
ALTER TABLE `conceptos_cobro`
  MODIFY `id_concepto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conductores`
--
ALTER TABLE `conductores`
  MODIFY `id_conductor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conductor_seg_social`
--
ALTER TABLE `conductor_seg_social`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacto_cliente`
--
ALTER TABLE `contacto_cliente`
  MODIFY `id_contacto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contratos`
--
ALTER TABLE `contratos`
  MODIFY `id_contrato` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contratos_ocasionales`
--
ALTER TABLE `contratos_ocasionales`
  MODIFY `id_contrato_ocasional` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `control_mantenimientos`
--
ALTER TABLE `control_mantenimientos`
  MODIFY `id_mantenimiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `convenios`
--
ALTER TABLE `convenios`
  MODIFY `id_convenio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `correspondencia_docs`
--
ALTER TABLE `correspondencia_docs`
  MODIFY `id_doc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `correspondencia_tipos`
--
ALTER TABLE `correspondencia_tipos`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cotizacion_concepto_general`
--
ALTER TABLE `cotizacion_concepto_general`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cotizacion_concepto_vehiculo`
--
ALTER TABLE `cotizacion_concepto_vehiculo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cotizacion_costo_conductor`
--
ALTER TABLE `cotizacion_costo_conductor`
  MODIFY `id_costo_conductor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cotizacion_destino`
--
ALTER TABLE `cotizacion_destino`
  MODIFY `id_destino` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cotizador_cotizacion`
--
ALTER TABLE `cotizador_cotizacion`
  MODIFY `id_cotizacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cotizador_descuento`
--
ALTER TABLE `cotizador_descuento`
  MODIFY `id_descuento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cotizador_destinos`
--
ALTER TABLE `cotizador_destinos`
  MODIFY `id_destino` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cotizador_empresa`
--
ALTER TABLE `cotizador_empresa`
  MODIFY `id_empresa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cotizador_paginas_formato`
--
ALTER TABLE `cotizador_paginas_formato`
  MODIFY `id_pag` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cotizador_tarifa_individual`
--
ALTER TABLE `cotizador_tarifa_individual`
  MODIFY `id_tarifa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cotizador_usuario`
--
ALTER TABLE `cotizador_usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cruce_saldos_anticipos`
--
ALTER TABLE `cruce_saldos_anticipos`
  MODIFY `id_cruce` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cuentas_bancos`
--
ALTER TABLE `cuentas_bancos`
  MODIFY `id_cuenta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `curso`
--
ALTER TABLE `curso`
  MODIFY `id_curso` double NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `descuentos_cartera`
--
ALTER TABLE `descuentos_cartera`
  MODIFY `id_descuento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `descuentos_cruzados`
--
ALTER TABLE `descuentos_cruzados`
  MODIFY `id_cruce` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `descuentos_flota_propia`
--
ALTER TABLE `descuentos_flota_propia`
  MODIFY `id_descuento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `desinfeccion`
--
ALTER TABLE `desinfeccion`
  MODIFY `id_desinfeccion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `destino`
--
ALTER TABLE `destino`
  MODIFY `id_destino` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `destino_cliente`
--
ALTER TABLE `destino_cliente`
  MODIFY `id_destino` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detalle`
--
ALTER TABLE `detalle`
  MODIFY `id` double NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detalles_operaciones`
--
ALTER TABLE `detalles_operaciones`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detalle_gastos_personales`
--
ALTER TABLE `detalle_gastos_personales`
  MODIFY `id_detalle_gasto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detalle_orden_servicio`
--
ALTER TABLE `detalle_orden_servicio`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detalle_recorrido_fijo`
--
ALTER TABLE `detalle_recorrido_fijo`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detalle_solicitud`
--
ALTER TABLE `detalle_solicitud`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documento_contrato_ocasional_propietario`
--
ALTER TABLE `documento_contrato_ocasional_propietario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `empleado_cursos`
--
ALTER TABLE `empleado_cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `empleado_estudio`
--
ALTER TABLE `empleado_estudio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `empleado_experiencia`
--
ALTER TABLE `empleado_experiencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `empleado_otros_docs`
--
ALTER TABLE `empleado_otros_docs`
  MODIFY `id_doc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id_empresa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `encuesta`
--
ALTER TABLE `encuesta`
  MODIFY `id_encuesta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `encuesta_data_operativa`
--
ALTER TABLE `encuesta_data_operativa`
  MODIFY `id_data_operativa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `encuesta_diligenciada`
--
ALTER TABLE `encuesta_diligenciada`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `encuesta_notificacion_positiva`
--
ALTER TABLE `encuesta_notificacion_positiva`
  MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `encuesta_notificacion_positiva_personas_contacto`
--
ALTER TABLE `encuesta_notificacion_positiva_personas_contacto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `encuesta_pregunta`
--
ALTER TABLE `encuesta_pregunta`
  MODIFY `id_pregunta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `encuesta_respuesta`
--
ALTER TABLE `encuesta_respuesta`
  MODIFY `id_respuesta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `encuesta_salud`
--
ALTER TABLE `encuesta_salud`
  MODIFY `id_respuesta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `encuesta_vulnerabilidad`
--
ALTER TABLE `encuesta_vulnerabilidad`
  MODIFY `id_respuesta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enfoque_objetivo`
--
ALTER TABLE `enfoque_objetivo`
  MODIFY `id_enfoque` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estado_acuerdos_pago`
--
ALTER TABLE `estado_acuerdos_pago`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `facturaciones`
--
ALTER TABLE `facturaciones`
  MODIFY `id_facturacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `finalizacion_servicio`
--
ALTER TABLE `finalizacion_servicio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flota_propia`
--
ALTER TABLE `flota_propia`
  MODIFY `id_flota_propia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fotografias_vehiculos`
--
ALTER TABLE `fotografias_vehiculos`
  MODIFY `id_fotografia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `foto_vehiculo`
--
ALTER TABLE `foto_vehiculo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frecuencia_cliente`
--
ALTER TABLE `frecuencia_cliente`
  MODIFY `id_frecuencia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fuec`
--
ALTER TABLE `fuec`
  MODIFY `id_fuec` double NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fuec_preliminar`
--
ALTER TABLE `fuec_preliminar`
  MODIFY `id_fuec` double NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fuente`
--
ALTER TABLE `fuente`
  MODIFY `id_fuente` double NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gestion_cobro`
--
ALTER TABLE `gestion_cobro`
  MODIFY `id_gestion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inspeccion_evidencias`
--
ALTER TABLE `inspeccion_evidencias`
  MODIFY `id_evidencia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inspeccion_vehicular`
--
ALTER TABLE `inspeccion_vehicular`
  MODIFY `id_inspeccion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `intranet_banners`
--
ALTER TABLE `intranet_banners`
  MODIFY `id_banner` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `intranet_categorias`
--
ALTER TABLE `intranet_categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `intranet_clasificados`
--
ALTER TABLE `intranet_clasificados`
  MODIFY `id_clasificado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `intranet_galeria_imgs`
--
ALTER TABLE `intranet_galeria_imgs`
  MODIFY `id_imagen` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `intranet_noticias`
--
ALTER TABLE `intranet_noticias`
  MODIFY `id_noticia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `intranet_publicaciones`
--
ALTER TABLE `intranet_publicaciones`
  MODIFY `id_publicacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mantenimineto_fp`
--
ALTER TABLE `mantenimineto_fp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mensajes_afiliados`
--
ALTER TABLE `mensajes_afiliados`
  MODIFY `id_mensaje` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notificaciones_comprobantesPagos`
--
ALTER TABLE `notificaciones_comprobantesPagos`
  MODIFY `id_notificacion_comprobante` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `novedad`
--
ALTER TABLE `novedad`
  MODIFY `id_novedad` double NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `novedad_pasajero`
--
ALTER TABLE `novedad_pasajero`
  MODIFY `id` double NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `novedad_servicio`
--
ALTER TABLE `novedad_servicio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `objetivo_general`
--
ALTER TABLE `objetivo_general`
  MODIFY `id_objetivo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `operaciones`
--
ALTER TABLE `operaciones`
  MODIFY `id_operacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orden_servicio`
--
ALTER TABLE `orden_servicio`
  MODIFY `id_orden` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `origen`
--
ALTER TABLE `origen`
  MODIFY `id_origen` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pago_recibido`
--
ALTER TABLE `pago_recibido`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paises`
--
ALTER TABLE `paises`
  MODIFY `id_pais` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paquetes_plus_vehiculos`
--
ALTER TABLE `paquetes_plus_vehiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pasajero`
--
ALTER TABLE `pasajero`
  MODIFY `id_pasajero` double NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pasajero_ruta_fija`
--
ALTER TABLE `pasajero_ruta_fija`
  MODIFY `id_pasajero` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `id_perfil` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permisos_usuarios_mod_operativo`
--
ALTER TABLE `permisos_usuarios_mod_operativo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permisos_usuarios_mod_vehiculos`
--
ALTER TABLE `permisos_usuarios_mod_vehiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `polizas_cartera`
--
ALTER TABLE `polizas_cartera`
  MODIFY `id_poliza` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `preoperacionales`
--
ALTER TABLE `preoperacionales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `preoperacionalGEB`
--
ALTER TABLE `preoperacionalGEB`
  MODIFY `id_preoperacional` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `productos_clientes`
--
ALTER TABLE `productos_clientes`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `programacion_servicios`
--
ALTER TABLE `programacion_servicios`
  MODIFY `id_programacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `propietarios`
--
ALTER TABLE `propietarios`
  MODIFY `id_propietario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `proveedor_mantenimiento`
--
ALTER TABLE `proveedor_mantenimiento`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `proyectos_contratos`
--
ALTER TABLE `proyectos_contratos`
  MODIFY `id_proyecto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `proyectos_data_operativa`
--
ALTER TABLE `proyectos_data_operativa`
  MODIFY `id_proyecto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recibosCaja`
--
ALTER TABLE `recibosCaja`
  MODIFY `id_recibo_caja` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recorrido`
--
ALTER TABLE `recorrido`
  MODIFY `id_recorrido` double NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recorrido_ruta_fija`
--
ALTER TABLE `recorrido_ruta_fija`
  MODIFY `id_recorrido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `referencias_conductor`
--
ALTER TABLE `referencias_conductor`
  MODIFY `id_referencia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `referencias_propietariovehiculo`
--
ALTER TABLE `referencias_propietariovehiculo`
  MODIFY `id_referencia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rodamientos`
--
ALTER TABLE `rodamientos`
  MODIFY `id_rodamiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ruta_pasajero`
--
ALTER TABLE `ruta_pasajero`
  MODIFY `id` double NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `segmentos`
--
ALTER TABLE `segmentos`
  MODIFY `id_segmento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seguimientos_actualizaciones_documentos`
--
ALTER TABLE `seguimientos_actualizaciones_documentos`
  MODIFY `id_seguimiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seguridad_social_empleados`
--
ALTER TABLE `seguridad_social_empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `servicios_variables`
--
ALTER TABLE `servicios_variables`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sillas_viaje`
--
ALTER TABLE `sillas_viaje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `solicitudes_vinculaciones`
--
ALTER TABLE `solicitudes_vinculaciones`
  MODIFY `id_solicitud_vinculacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `solicitud_cliente`
--
ALTER TABLE `solicitud_cliente`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status_cliente`
--
ALTER TABLE `status_cliente`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subcategoria_mantenimiento`
--
ALTER TABLE `subcategoria_mantenimiento`
  MODIFY `id_subcategoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subcategoria_proveedor`
--
ALTER TABLE `subcategoria_proveedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tarifas_productos_clientes`
--
ALTER TABLE `tarifas_productos_clientes`
  MODIFY `id_tarifa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tarifas_proyectos`
--
ALTER TABLE `tarifas_proyectos`
  MODIFY `id_tarifa_proyecto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tarifas_terceros_proyectos`
--
ALTER TABLE `tarifas_terceros_proyectos`
  MODIFY `id_tarifa_tercero` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipos_servicios`
--
ALTER TABLE `tipos_servicios`
  MODIFY `id_tipo_servicio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipos_servicios_variables`
--
ALTER TABLE `tipos_servicios_variables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipos_vehiculos`
--
ALTER TABLE `tipos_vehiculos`
  MODIFY `id_tipo_vehiculo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipo_actividad`
--
ALTER TABLE `tipo_actividad`
  MODIFY `id_tipo_actividad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipo_combustible`
--
ALTER TABLE `tipo_combustible`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipo_contacto_cobro`
--
ALTER TABLE `tipo_contacto_cobro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipo_contrato`
--
ALTER TABLE `tipo_contrato`
  MODIFY `id_tipo_contrato` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipo_encuesta`
--
ALTER TABLE `tipo_encuesta`
  MODIFY `id_tipo_encuesta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipo_movil`
--
ALTER TABLE `tipo_movil`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipo_novedad`
--
ALTER TABLE `tipo_novedad`
  MODIFY `id_novedad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipo_novedades_servicios`
--
ALTER TABLE `tipo_novedades_servicios`
  MODIFY `id_tipo_novedad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipo_pasajero`
--
ALTER TABLE `tipo_pasajero`
  MODIFY `id_tipo` double NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipo_pregunta`
--
ALTER TABLE `tipo_pregunta`
  MODIFY `id_tipo_pregunta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipo_servicio_cliente`
--
ALTER TABLE `tipo_servicio_cliente`
  MODIFY `id_tipo_servicio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipo_servicio_mantenimiento`
--
ALTER TABLE `tipo_servicio_mantenimiento`
  MODIFY `id_tipo_servicio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipo_servicio_solicitud`
--
ALTER TABLE `tipo_servicio_solicitud`
  MODIFY `id_tipo_servicio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unidades_operativas_programacion`
--
ALTER TABLE `unidades_operativas_programacion`
  MODIFY `id_unidad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios_contratos_fijos`
--
ALTER TABLE `usuarios_contratos_fijos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios_contratos_ocasionales`
--
ALTER TABLE `usuarios_contratos_ocasionales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios_internos_firmas`
--
ALTER TABLE `usuarios_internos_firmas`
  MODIFY `id_usuario_firma` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuario_cliente`
--
ALTER TABLE `usuario_cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vales_generados`
--
ALTER TABLE `vales_generados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id_vehiculo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehiculos_conductores`
--
ALTER TABLE `vehiculos_conductores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehiculos_contratos`
--
ALTER TABLE `vehiculos_contratos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehiculos_eximidos_pagos`
--
ALTER TABLE `vehiculos_eximidos_pagos`
  MODIFY `id_eximido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehiculo_ruta`
--
ALTER TABLE `vehiculo_ruta`
  MODIFY `id` double NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehiculo_servicio`
--
ALTER TABLE `vehiculo_servicio`
  MODIFY `id_asignacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `viaje`
--
ALTER TABLE `viaje`
  MODIFY `id_viaje` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vinculacion_clientes`
--
ALTER TABLE `vinculacion_clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vinculacion_contratos`
--
ALTER TABLE `vinculacion_contratos`
  MODIFY `id_contrato` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `volumen_venta_cliente`
--
ALTER TABLE `volumen_venta_cliente`
  MODIFY `id_volumen` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
