-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-03-2026 a las 07:29:14
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistemakv2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doc_servicios_ocasionales`
--

CREATE TABLE `doc_servicios_ocasionales` (
  `id_servicio_ocasional` int(11) NOT NULL,
  `doc_rut` varchar(255) DEFAULT NULL,
  `doc_camara` varchar(255) DEFAULT NULL,
  `doc_cedula_rl` varchar(255) DEFAULT NULL,
  `doc_aceptacion` varchar(255) DEFAULT NULL,
  `doc_contrato` varchar(255) DEFAULT NULL,
  `doc_primer_abono` varchar(255) DEFAULT NULL,
  `doc_segundo_abono` varchar(255) DEFAULT NULL,
  `doc_prefactura` varchar(255) DEFAULT NULL,
  `doc_fuec_generado` varchar(255) DEFAULT NULL,
  `doc_contrato_generado` varchar(255) DEFAULT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `doc_fuec_documental` text DEFAULT NULL,
  `doc_recibo_caja_abono_1` varchar(255) DEFAULT NULL,
  `doc_recibo_caja_abono_2` varchar(255) DEFAULT NULL,
  `doc_factura` varchar(255) DEFAULT NULL,
  `doc_convenio_documental` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `doc_servicios_ocasionales`
--

INSERT INTO `doc_servicios_ocasionales` (`id_servicio_ocasional`, `doc_rut`, `doc_camara`, `doc_cedula_rl`, `doc_aceptacion`, `doc_contrato`, `doc_primer_abono`, `doc_segundo_abono`, `doc_prefactura`, `doc_fuec_generado`, `doc_contrato_generado`, `fecha_registro`, `doc_fuec_documental`, `doc_recibo_caja_abono_1`, `doc_recibo_caja_abono_2`, `doc_factura`, `doc_convenio_documental`) VALUES
(2, '2_doc_rut_20260214082248.pdf', '2_doc_camara_20260214082248.pdf', '2_doc_cedula_rl_20260214082248.pdf', '2_doc_aceptacion_20260214082248.pdf', '2_doc_contrato_20260214082248.pdf', '2_doc_primer_abono_20260214082248.pdf', '2_doc_segundo_abono_20260214082248.pdf', '2_doc_prefactura_20260214082248.pdf', 'SO_2_fuec_generado_20260214082248.html', 'SO_2_contrato_generado_20260214082248.html', '2026-02-14 08:22:48', NULL, NULL, NULL, NULL, NULL),
(3, '3_doc_rut_20260216073657.pdf', '3_doc_camara_20260216073657.pdf', '3_doc_cedula_rl_20260216073657.pdf', '3_doc_aceptacion_20260216073657.pdf', '3_doc_contrato_20260216073657.pdf', '3_doc_primer_abono_20260216073657.pdf', '3_doc_segundo_abono_20260216073657.pdf', '3_doc_prefactura_20260216073657.pdf', 'SO_3_fuec_generado_20260216073657.html', 'SO_3_contrato_generado_20260216073657.html', '2026-03-12 14:40:25', '{\"1\":{\"INICIO\":{\"documento_fuec\":\"fuec_so_3_1_inicio_20260312144025_4023.pdf\",\"fecha_registro\":\"2026-03-12 14:40:25\",\"id_usuario\":3851}}}', NULL, NULL, NULL, NULL),
(4, '4_doc_rut_20260216093612.pdf', '4_doc_camara_20260216093612.pdf', '4_doc_cedula_rl_20260216093612.pdf', '4_doc_aceptacion_20260216093612.pdf', '4_doc_contrato_20260216093612.pdf', '4_doc_primer_abono_20260216093612.pdf', '4_doc_segundo_abono_20260216093612.pdf', '4_doc_prefactura_20260216093612.pdf', 'SO_4_fuec_generado_20260216093612.html', 'SO_4_contrato_generado_20260216093612.html', '2026-02-16 09:36:12', NULL, NULL, NULL, NULL, NULL),
(5, '5_doc_rut_20260216160609.pdf', '5_doc_camara_20260216160609.pdf', '5_doc_cedula_rl_20260216160609.pdf', '5_doc_aceptacion_20260216160609.pdf', '5_doc_contrato_20260216160609.pdf', '5_doc_primer_abono_20260216160609.pdf', '5_doc_segundo_abono_20260216160609.pdf', '5_doc_prefactura_20260216160609.pdf', 'SO_5_fuec_generado_20260216160609.html', 'SO_5_contrato_generado_20260216160609.html', '2026-03-17 08:20:54', '{\"1\":{\"INICIO\":{\"documento_fuec\":\"fuec_so_5_1_inicio_20260317082046_4762.pdf\",\"fecha_registro\":\"2026-03-17 08:20:46\",\"id_usuario\":3851}},\"2\":{\"INICIO\":{\"documento_fuec\":\"fuec_so_5_2_inicio_20260317082053_5133.pdf\",\"fecha_registro\":\"2026-03-17 08:20:54\",\"id_usuario\":3851}}}', NULL, NULL, NULL, NULL),
(6, '6_doc_rut_20260309075735.pdf', '6_doc_camara_20260309075735.pdf', '6_doc_cedula_rl_20260309075735.pdf', '6_doc_aceptacion_20260309075735.pdf', '6_doc_contrato_20260309075735.pdf', '6_doc_primer_abono_20260309075735.pdf', '6_doc_segundo_abono_20260309075735.pdf', '6_doc_prefactura_20260309075735.pdf', 'SO_6_fuec_generado_20260309075735.html', 'SO_6_contrato_generado_20260309075735.html', '2026-03-16 15:46:40', '{\"1\":{\"INICIO\":{\"documento_fuec\":\"fuec_so_6_1_inicio_20260309132915_3193.pdf\",\"fecha_registro\":\"2026-03-09 13:29:15\",\"id_usuario\":3851},\"FIN\":{\"documento_fuec\":\"fuec_so_6_1_fin_20260309132915_8375.pdf\",\"fecha_registro\":\"2026-03-09 13:29:15\",\"id_usuario\":3851}},\"2\":{\"INICIO\":{\"documento_fuec\":\"fuec_so_6_2_inicio_20260309132915_8925.pdf\",\"fecha_registro\":\"2026-03-09 13:29:15\",\"id_usuario\":3851}}}', 'recibo_caja_abono_1_so_6_20260316154615_2412.pdf', 'recibo_caja_abono_2_so_6_20260316154628_2253.pdf', 'factura_so_6_20260316154640_4850.pdf', NULL),
(7, '7_doc_rut_20260313083410.pdf', '7_doc_camara_20260313083410.pdf', '7_doc_cedula_rl_20260313083410.pdf', '7_doc_aceptacion_20260313083410.pdf', '7_doc_contrato_20260313083410.pdf', '7_doc_primer_abono_20260313083410.pdf', '7_doc_segundo_abono_20260313083410.pdf', '7_doc_prefactura_20260313083410.pdf', 'SO_7_fuec_generado_20260313083410.html', 'SO_7_contrato_generado_20260313083410.html', '2026-03-17 09:05:30', '{\"1\":{\"INICIO\":{\"documento_fuec\":\"fuec_so_7_1_inicio_20260313084846_4440.pdf\",\"fecha_registro\":\"2026-03-13 08:48:46\",\"id_usuario\":3851}}}', 'recibo_caja_abono_1_so_7_20260317090457_8906.pdf', 'recibo_caja_abono_2_so_7_20260317090511_5987.pdf', 'factura_so_7_20260317090530_9085.pdf', NULL),
(8, '8_doc_rut_20260317164101.pdf', '8_doc_camara_20260317164101.pdf', '8_doc_cedula_rl_20260317164101.pdf', '8_doc_aceptacion_20260317164101.pdf', '8_doc_contrato_20260317164101.pdf', '8_doc_primer_abono_20260317164101.pdf', '8_doc_segundo_abono_20260317164101.pdf', '8_doc_prefactura_20260317164101.pdf', 'SO_8_fuec_generado_20260317164101.html', 'SO_8_contrato_generado_20260317164101.html', '2026-03-17 16:54:23', '{\"1\":{\"INICIO\":{\"documento_fuec\":\"fuec_so_8_1_inicio_20260317165423_5591.pdf\",\"fecha_registro\":\"2026-03-17 16:54:23\",\"id_usuario\":3851}}}', 'recibo_caja_abono_1_so_8_20260317164445_9654.pdf', 'recibo_caja_abono_2_so_8_20260317164455_6084.pdf', 'factura_so_8_20260317164504_1410.pdf', NULL),
(9, '9_doc_rut_20260318080140.pdf', '9_doc_camara_20260318080140.pdf', '9_doc_cedula_rl_20260318080140.pdf', '9_doc_aceptacion_20260318080140.pdf', '9_doc_contrato_20260318080140.pdf', '9_doc_primer_abono_20260318080140.pdf', '9_doc_segundo_abono_20260318080140.pdf', '9_doc_prefactura_20260318080140.pdf', 'SO_9_fuec_generado_20260318080140.html', 'SO_9_contrato_generado_20260318080140.html', '2026-03-18 08:22:32', '{\"1\":{\"INICIO\":{\"documento_fuec\":\"fuec_so_9_1_inicio_20260318082232_2332.pdf\",\"fecha_registro\":\"2026-03-18 08:22:32\",\"id_usuario\":3851}}}', 'recibo_caja_abono_1_so_9_20260318080305_8032.pdf', 'recibo_caja_abono_2_so_9_20260318080949_8504.pdf', 'factura_so_9_20260318080950_8527.pdf', NULL),
(10, '10_doc_rut_20260319152310.pdf', '10_doc_camara_20260319152310.pdf', '10_doc_cedula_rl_20260319152310.pdf', '10_doc_aceptacion_20260319152310.pdf', '10_doc_contrato_20260319152310.pdf', '10_doc_primer_abono_20260319152310.pdf', '10_doc_segundo_abono_20260319152310.pdf', '10_doc_prefactura_20260319152310.pdf', 'SO_10_fuec_generado_20260319152310.html', 'SO_10_contrato_generado_20260319152310.html', '2026-03-20 11:02:59', '{\"1\":{\"INICIO\":{\"documento_fuec\":\"fuec_so_10_1_inicio_20260319163609_8543.pdf\",\"fecha_registro\":\"2026-03-19 16:36:09\",\"id_usuario\":3851},\"FIN\":{\"documento_fuec\":\"fuec_so_10_1_fin_20260319163628_7100.pdf\",\"fecha_registro\":\"2026-03-19 16:36:28\",\"id_usuario\":3851}},\"2\":{\"INICIO\":{\"documento_fuec\":\"fuec_so_10_2_inicio_20260319163647_2873.pdf\",\"fecha_registro\":\"2026-03-19 16:36:47\",\"id_usuario\":3851}}}', 'recibo_caja_abono_1_so_10_20260319162351_5600.pdf', 'recibo_caja_abono_2_so_10_20260319162408_5512.pdf', 'factura_so_10_20260319162424_4253.pdf', '{\"1\":{\"INICIO\":{\"aplica\":0,\"documento_convenio\":\"\",\"fecha_registro\":\"2026-03-20 11:02:40\",\"id_usuario\":0},\"FIN\":{\"aplica\":1,\"documento_convenio\":\"convenio_so_10_1_fin_20260320110240_5811.pdf\",\"fecha_registro\":\"2026-03-20 11:02:40\",\"id_usuario\":3851}},\"2\":{\"INICIO\":{\"aplica\":0,\"documento_convenio\":\"\",\"fecha_registro\":\"2026-03-20 11:02:59\",\"id_usuario\":0}}}'),
(11, '11_doc_rut_20260320115618.pdf', '11_doc_camara_20260320115618.pdf', '11_doc_cedula_rl_20260320115618.pdf', '11_doc_aceptacion_20260320115618.pdf', '11_doc_contrato_20260320115618.pdf', '11_doc_primer_abono_20260320115618.pdf', '11_doc_segundo_abono_20260320115618.pdf', '11_doc_prefactura_20260320115618.pdf', 'SO_11_fuec_generado_20260320115618.html', 'SO_11_contrato_generado_20260320115618.html', '2026-03-20 12:17:27', '{\"1\":{\"INICIO\":{\"documento_fuec\":\"fuec_so_11_1_inicio_20260320121708_9925.pdf\",\"fecha_registro\":\"2026-03-20 12:17:08\",\"id_usuario\":3851}},\"2\":{\"INICIO\":{\"documento_fuec\":\"fuec_so_11_2_inicio_20260320121727_4243.pdf\",\"fecha_registro\":\"2026-03-20 12:17:27\",\"id_usuario\":3851}}}', 'recibo_caja_abono_1_so_11_20260320120611_9118.pdf', 'recibo_caja_abono_2_so_11_20260320120627_2387.pdf', 'factura_so_11_20260320120642_5641.pdf', '{\"1\":{\"INICIO\":{\"aplica\":0,\"documento_convenio\":\"\",\"fecha_registro\":\"2026-03-20 12:16:48\",\"id_usuario\":0}},\"2\":{\"INICIO\":{\"aplica\":1,\"documento_convenio\":\"convenio_so_11_2_inicio_20260320121648_7330.pdf\",\"fecha_registro\":\"2026-03-20 12:16:48\",\"id_usuario\":3851}}}');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `doc_servicios_ocasionales`
--
ALTER TABLE `doc_servicios_ocasionales`
  ADD PRIMARY KEY (`id_servicio_ocasional`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
