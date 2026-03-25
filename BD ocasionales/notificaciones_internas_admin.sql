-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-03-2026 a las 07:27:17
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
-- Estructura de tabla para la tabla `notificaciones_internas_admin`
--

CREATE TABLE `notificaciones_internas_admin` (
  `id_notificacion` int(11) NOT NULL,
  `id_usuario_destino` int(11) NOT NULL,
  `id_usuario_remitente` int(11) DEFAULT NULL,
  `remitente` varchar(180) NOT NULL,
  `area` varchar(80) NOT NULL,
  `modulo` varchar(80) NOT NULL,
  `id_referencia` int(11) DEFAULT NULL,
  `fecha_hora` datetime NOT NULL,
  `contenido` text NOT NULL,
  `leido` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `notificaciones_internas_admin`
--

INSERT INTO `notificaciones_internas_admin` (`id_notificacion`, `id_usuario_destino`, `id_usuario_remitente`, `remitente`, `area`, `modulo`, `id_referencia`, `fecha_hora`, `contenido`, `leido`) VALUES
(50, 0, 0, 'OPERACIONES', 'OPERACIONES', 'servicios_ocasionales', 6, '2026-03-16 16:04:15', 'Se ancló vehículo/conductor en la reserva #6 el 2026-03-16 16:04:14.', 0),
(51, 0, 1433, 'SANDRA GARCIA', 'OPERACIONES', 'servicios_ocasionales', 6, '2026-03-16 16:04:27', 'SANDRA GARCIA realizó acción CONFIRMAR en OPERACIONES para reserva #6 el 2026-03-16 16:04:27.', 0),
(52, 0, 1433, 'SANDRA GARCIA', 'CONTABILIDAD', 'servicios_ocasionales', 7, '2026-03-16 16:49:12', 'SANDRA GARCIA realizó acción CONFIRMAR en CONTABILIDAD para reserva #7 el 2026-03-16 16:49:12.', 0),
(53, 0, 0, 'OPERACIONES', 'OPERACIONES', 'servicios_ocasionales', 5, '2026-03-17 08:05:21', 'Se ancló vehículo/conductor en la reserva #5 el 2026-03-17 08:05:21.', 0),
(54, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 5, '2026-03-17 08:05:30', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en OPERACIONES para reserva #5 el 2026-03-17 08:05:30.', 0),
(55, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 5, '2026-03-17 08:20:46', 'YEIN STEFANNY VARGAS ZORRO subió el FUEC de la placa JTP626 para la reserva #5 el 2026-03-17 08:20:46.', 0),
(56, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 5, '2026-03-17 08:20:54', 'YEIN STEFANNY VARGAS ZORRO subió el FUEC de la placa WGQ950 para la reserva #5 el 2026-03-17 08:20:54.', 0),
(57, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 5, '2026-03-17 08:21:01', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en DOCUMENTAL para reserva #5 el 2026-03-17 08:21:01.', 0),
(58, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'COMERCIAL', 'servicios_ocasionales', 7, '2026-03-17 08:30:45', 'Se editó la reserva ocasional #7 el 2026-03-17 08:30:45.', 0),
(59, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 7, '2026-03-17 08:51:08', 'YEIN STEFANNY VARGAS ZORRO ancló placa JTP626 y conductor STEFANNY VARGAS (INICIO, consecutivo 1); placa JTP102 y conductor STEFANNY VARGAS (FIN, consecutivo 1); placa JTP626 y conductor STEFANNY VARGAS (INICIO, consecutivo 2); placa JTP626 y conductor JUAN DAVID BATISTA RESTREPO (FIN, consecutivo 2) a la reserva #7 el 2026-03-17 08:51:08.', 0),
(60, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 7, '2026-03-17 08:51:15', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en OPERACIONES para reserva #7 el 2026-03-17 08:51:15.', 0),
(61, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 7, '2026-03-17 09:04:57', 'YEIN STEFANNY VARGAS ZORRO subió el recibo de caja abono 1 de la reserva #7 el 2026-03-17 09:04:57.', 0),
(62, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 7, '2026-03-17 09:05:11', 'YEIN STEFANNY VARGAS ZORRO subió el recibo de caja abono 2 de la reserva #7 el 2026-03-17 09:05:11.', 0),
(63, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 7, '2026-03-17 09:05:30', 'YEIN STEFANNY VARGAS ZORRO subió el factura de la reserva #7 el 2026-03-17 09:05:30.', 0),
(64, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 7, '2026-03-17 09:05:45', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en CONTABILIDAD para reserva #7 el 2026-03-17 09:05:44.', 0),
(65, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 4, '2026-03-17 15:01:39', 'YEIN STEFANNY VARGAS ZORRO ancló placa LSY733 y conductor STEFANNY VARGAS (INICIO, consecutivo 1); placa LSY733 y conductor STEFANNY VARGAS (FIN, consecutivo 1) a la reserva #4 el 2026-03-17 15:01:39.', 0),
(66, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 4, '2026-03-17 15:01:54', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en OPERACIONES para reserva #4 el 2026-03-17 15:01:54.', 0),
(67, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 4, '2026-03-17 15:08:39', 'YEIN STEFANNY VARGAS ZORRO ancló placa LSY733 y conductor BELLER ARLEY HERNANDEZ PEREZ (INICIO, consecutivo 1); placa LSY733 y conductor BELLER ARLEY HERNANDEZ PEREZ (FIN, consecutivo 1) a la reserva #4 el 2026-03-17 15:08:39.', 0),
(68, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 4, '2026-03-17 15:08:57', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en OPERACIONES para reserva #4 el 2026-03-17 15:08:57.', 0),
(69, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 4, '2026-03-17 15:10:21', 'YEIN STEFANNY VARGAS ZORRO ancló placa LSY733 y conductor STEFANNY VARGAS (INICIO, consecutivo 1); placa LSY733 y conductor STEFANNY VARGAS (FIN, consecutivo 1) a la reserva #4 el 2026-03-17 15:10:21.', 0),
(70, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 4, '2026-03-17 15:10:45', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en OPERACIONES para reserva #4 el 2026-03-17 15:10:45.', 0),
(71, 0, 4280, 'STEFANNY VARGAS', 'CONDUCTOR', 'servicios_ocasionales', 6, '2026-03-17 15:46:17', 'STEFANNY VARGAS no confirmó el recibido de la reserva #6 el 2026-03-17 15:46:17.', 0),
(72, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'COMERCIAL', 'servicios_ocasionales', 7, '2026-03-17 16:17:50', 'Se editó la reserva ocasional #7 el 2026-03-17 16:17:50.', 0),
(73, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'COMERCIAL', 'servicios_ocasionales', 8, '2026-03-17 16:40:51', 'Se creó la reserva ocasional #8 el 2026-03-17 16:40:51.', 0),
(74, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 8, '2026-03-17 16:43:24', 'YEIN STEFANNY VARGAS ZORRO realizó acción SOPORTE_PENDIENTE en CONTABILIDAD para reserva #8 el 2026-03-17 16:43:24.', 0),
(75, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 8, '2026-03-17 16:44:45', 'YEIN STEFANNY VARGAS ZORRO subió el recibo de caja abono 1 de la reserva #8 el 2026-03-17 16:44:45.', 0),
(76, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 8, '2026-03-17 16:44:55', 'YEIN STEFANNY VARGAS ZORRO subió el recibo de caja abono 2 de la reserva #8 el 2026-03-17 16:44:55.', 0),
(77, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 8, '2026-03-17 16:45:04', 'YEIN STEFANNY VARGAS ZORRO subió el factura de la reserva #8 el 2026-03-17 16:45:04.', 0),
(78, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 8, '2026-03-17 16:45:14', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en CONTABILIDAD para reserva #8 el 2026-03-17 16:45:14.', 0),
(79, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 8, '2026-03-17 16:47:25', 'YEIN STEFANNY VARGAS ZORRO ancló placa JTP626 y conductor STEFANNY VARGAS (INICIO, consecutivo 1); placa JTP626 y conductor STEFANNY VARGAS (FIN, consecutivo 1) a la reserva #8 el 2026-03-17 16:47:24.', 0),
(80, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 8, '2026-03-17 16:47:36', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en OPERACIONES para reserva #8 el 2026-03-17 16:47:36.', 0),
(81, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 8, '2026-03-17 16:54:23', 'YEIN STEFANNY VARGAS ZORRO subió el FUEC de la placa JTP626 para la reserva #8 el 2026-03-17 16:54:23.', 0),
(82, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 8, '2026-03-17 16:54:34', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en DOCUMENTAL para reserva #8 el 2026-03-17 16:54:34.', 0),
(83, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'COMERCIAL', 'servicios_ocasionales', 8, '2026-03-17 16:57:53', 'Se actualizó el estado de la reserva ocasional #8 a F el 2026-03-17 16:57:53.', 0),
(84, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'COMERCIAL', 'servicios_ocasionales', 9, '2026-03-18 08:01:25', 'Se creó la reserva ocasional #9 el 2026-03-18 08:01:25.', 0),
(85, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:03:05', 'YEIN STEFANNY VARGAS ZORRO subió el recibo de caja abono 1 de la reserva #9 el 2026-03-18 08:03:05.', 0),
(86, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:03:18', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en CONTABILIDAD para reserva #9 el 2026-03-18 08:03:18.', 0),
(87, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:03:57', 'YEIN STEFANNY VARGAS ZORRO subió el recibo de caja abono 2 de la reserva #9 el 2026-03-18 08:03:57.', 0),
(88, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:04:09', 'YEIN STEFANNY VARGAS ZORRO subió el factura de la reserva #9 el 2026-03-18 08:04:09.', 0),
(89, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:04:21', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en CONTABILIDAD para reserva #9 el 2026-03-18 08:04:21.', 0),
(90, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:04:32', 'YEIN STEFANNY VARGAS ZORRO subió el recibo de caja abono 2 de la reserva #9 el 2026-03-18 08:04:32.', 0),
(91, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:04:44', 'YEIN STEFANNY VARGAS ZORRO subió el factura de la reserva #9 el 2026-03-18 08:04:44.', 0),
(92, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:04:56', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en CONTABILIDAD para reserva #9 el 2026-03-18 08:04:56.', 0),
(93, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:05:07', 'YEIN STEFANNY VARGAS ZORRO subió el recibo de caja abono 2 de la reserva #9 el 2026-03-18 08:05:07.', 0),
(94, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:05:20', 'YEIN STEFANNY VARGAS ZORRO subió el factura de la reserva #9 el 2026-03-18 08:05:20.', 0),
(95, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:05:31', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en CONTABILIDAD para reserva #9 el 2026-03-18 08:05:31.', 0),
(96, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:05:43', 'YEIN STEFANNY VARGAS ZORRO subió el recibo de caja abono 2 de la reserva #9 el 2026-03-18 08:05:43.', 0),
(97, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:05:56', 'YEIN STEFANNY VARGAS ZORRO subió el factura de la reserva #9 el 2026-03-18 08:05:56.', 0),
(98, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:06:08', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en CONTABILIDAD para reserva #9 el 2026-03-18 08:06:08.', 0),
(99, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:06:19', 'YEIN STEFANNY VARGAS ZORRO subió el recibo de caja abono 2 de la reserva #9 el 2026-03-18 08:06:19.', 0),
(100, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:06:29', 'YEIN STEFANNY VARGAS ZORRO subió el factura de la reserva #9 el 2026-03-18 08:06:29.', 0),
(101, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:06:31', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en CONTABILIDAD para reserva #9 el 2026-03-18 08:06:31.', 0),
(102, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:06:34', 'YEIN STEFANNY VARGAS ZORRO subió el recibo de caja abono 2 de la reserva #9 el 2026-03-18 08:06:34.', 0),
(103, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:06:37', 'YEIN STEFANNY VARGAS ZORRO subió el factura de la reserva #9 el 2026-03-18 08:06:37.', 0),
(104, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:06:40', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en CONTABILIDAD para reserva #9 el 2026-03-18 08:06:40.', 0),
(105, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:07:16', 'YEIN STEFANNY VARGAS ZORRO subió el recibo de caja abono 2 de la reserva #9 el 2026-03-18 08:07:16.', 0),
(106, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:07:19', 'YEIN STEFANNY VARGAS ZORRO subió el factura de la reserva #9 el 2026-03-18 08:07:19.', 0),
(107, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:07:30', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en CONTABILIDAD para reserva #9 el 2026-03-18 08:07:30.', 0),
(108, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:08:04', 'YEIN STEFANNY VARGAS ZORRO subió el recibo de caja abono 2 de la reserva #9 el 2026-03-18 08:08:04.', 0),
(109, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:08:06', 'YEIN STEFANNY VARGAS ZORRO subió el factura de la reserva #9 el 2026-03-18 08:08:06.', 0),
(110, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:08:08', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en CONTABILIDAD para reserva #9 el 2026-03-18 08:08:08.', 0),
(111, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:08:58', 'YEIN STEFANNY VARGAS ZORRO subió el recibo de caja abono 2 de la reserva #9 el 2026-03-18 08:08:58.', 0),
(112, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:09:00', 'YEIN STEFANNY VARGAS ZORRO subió el factura de la reserva #9 el 2026-03-18 08:09:00.', 0),
(113, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:09:02', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en CONTABILIDAD para reserva #9 el 2026-03-18 08:09:01.', 0),
(114, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:09:03', 'YEIN STEFANNY VARGAS ZORRO subió el recibo de caja abono 2 de la reserva #9 el 2026-03-18 08:09:03.', 0),
(115, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:09:04', 'YEIN STEFANNY VARGAS ZORRO subió el factura de la reserva #9 el 2026-03-18 08:09:04.', 0),
(116, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:09:06', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en CONTABILIDAD para reserva #9 el 2026-03-18 08:09:06.', 0),
(117, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:09:07', 'YEIN STEFANNY VARGAS ZORRO subió el recibo de caja abono 2 de la reserva #9 el 2026-03-18 08:09:07.', 0),
(118, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:09:09', 'YEIN STEFANNY VARGAS ZORRO subió el factura de la reserva #9 el 2026-03-18 08:09:09.', 0),
(119, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:09:23', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en CONTABILIDAD para reserva #9 el 2026-03-18 08:09:23.', 0),
(120, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:09:49', 'YEIN STEFANNY VARGAS ZORRO subió el recibo de caja abono 2 de la reserva #9 el 2026-03-18 08:09:49.', 0),
(121, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:09:50', 'YEIN STEFANNY VARGAS ZORRO subió el factura de la reserva #9 el 2026-03-18 08:09:50.', 0),
(122, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 9, '2026-03-18 08:09:52', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en CONTABILIDAD para reserva #9 el 2026-03-18 08:09:52.', 0),
(123, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 9, '2026-03-18 08:19:24', 'YEIN STEFANNY VARGAS ZORRO ancló placa JTP626 y conductor STEFANNY VARGAS (INICIO, consecutivo 1); placa JTP626 y conductor STEFANNY VARGAS (FIN, consecutivo 1) a la reserva #9 el 2026-03-18 08:19:24.', 0),
(124, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 9, '2026-03-18 08:19:54', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en OPERACIONES para reserva #9 el 2026-03-18 08:19:54.', 0),
(125, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 9, '2026-03-18 08:22:32', 'YEIN STEFANNY VARGAS ZORRO subió el FUEC de la placa JTP626 para la reserva #9 el 2026-03-18 08:22:32.', 0),
(126, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 9, '2026-03-18 08:22:53', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en DOCUMENTAL para reserva #9 el 2026-03-18 08:22:53.', 0),
(127, 0, 4280, 'STEFANNY VARGAS', 'CONDUCTOR', 'servicios_ocasionales', 9, '2026-03-18 08:34:00', 'STEFANNY VARGAS confirmó el recibido de la reserva #9 el 2026-03-18 08:34:00.', 0),
(128, 0, 4280, 'STEFANNY VARGAS', 'CONDUCTOR', 'servicios_ocasionales', 9, '2026-03-18 08:34:35', 'STEFANNY VARGAS confirmó el recibido de la reserva #9 el 2026-03-18 08:34:35.', 0),
(129, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'COMERCIAL', 'servicios_ocasionales', 9, '2026-03-18 15:03:45', 'Se editó la reserva ocasional #9 el 2026-03-18 15:03:45.', 0),
(130, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 9, '2026-03-18 15:16:45', 'YEIN STEFANNY VARGAS ZORRO ancló placa JTP626 y conductor STEFANNY VARGAS (INICIO, consecutivo 1); placa JTP626 y conductor STEFANNY VARGAS (FIN, consecutivo 1); placa NUX320 y conductor ADONIAS HERNAN TOCASUCHE BERMUDEZ (INICIO, consecutivo 2); placa FSQ695 y conductor STEFANNY VARGAS (FIN, consecutivo 2); placa EQT560 y conductor EVER EDUARDO ARISTIZABAL LONDOÑO (INICIO, consecutivo 3); placa EQO370 y conductor RENE SASTOQUE ARIZA (FIN, consecutivo 3); placa JTS110 y conductor YEFERSON DAVID SANABRIA SANCHEZ  (INICIO, consecutivo 4); placa GVK199 y conductor FERNANDO CASTRO MOLANO  (FIN, consecutivo 4) a la reserva #9 el 2026-03-18 15:16:44.', 0),
(131, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 9, '2026-03-18 15:17:15', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en OPERACIONES para reserva #9 el 2026-03-18 15:17:15.', 0),
(132, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'COMERCIAL', 'servicios_ocasionales', 9, '2026-03-19 14:06:36', 'Se editó la reserva ocasional #9 el 2026-03-19 14:06:36.', 0),
(133, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'COMERCIAL', 'servicios_ocasionales', 10, '2026-03-19 15:22:52', 'Se creó la reserva ocasional #10 el 2026-03-19 15:22:51.', 0),
(134, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'COMERCIAL', 'servicios_ocasionales', 9, '2026-03-19 16:20:58', 'Se editó la reserva ocasional #9 el 2026-03-19 16:20:58.', 0),
(135, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 10, '2026-03-19 16:23:51', 'YEIN STEFANNY VARGAS ZORRO subió el recibo de caja abono 1 de la reserva #10 el 2026-03-19 16:23:51.', 0),
(136, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 10, '2026-03-19 16:24:08', 'YEIN STEFANNY VARGAS ZORRO subió el recibo de caja abono 2 de la reserva #10 el 2026-03-19 16:24:08.', 0),
(137, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 10, '2026-03-19 16:24:24', 'YEIN STEFANNY VARGAS ZORRO subió el factura de la reserva #10 el 2026-03-19 16:24:24.', 0),
(138, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 10, '2026-03-19 16:24:41', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en CONTABILIDAD para reserva #10 el 2026-03-19 16:24:41.', 0),
(139, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 10, '2026-03-19 16:34:45', 'YEIN STEFANNY VARGAS ZORRO ancló placa EQX848 y conductor STEFANNY VARGAS (INICIO, consecutivo 1); placa ERL151 y conductor STEFANNY VARGAS (FIN, consecutivo 1); placa EQX848 y conductor STEFANNY VARGAS (INICIO, consecutivo 2); placa EQX848 y conductor STEFANNY VARGAS (FIN, consecutivo 2) a la reserva #10 el 2026-03-19 16:34:45.', 0),
(140, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 10, '2026-03-19 16:35:04', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en OPERACIONES para reserva #10 el 2026-03-19 16:35:04.', 0),
(141, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 10, '2026-03-19 16:36:09', 'YEIN STEFANNY VARGAS ZORRO subió el FUEC de la placa EQX848 para la reserva #10 el 2026-03-19 16:36:09.', 0),
(142, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 10, '2026-03-19 16:36:28', 'YEIN STEFANNY VARGAS ZORRO subió el FUEC de la placa ERL151 para la reserva #10 el 2026-03-19 16:36:28.', 0),
(143, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 10, '2026-03-19 16:36:47', 'YEIN STEFANNY VARGAS ZORRO subió el FUEC de la placa EQX848 para la reserva #10 el 2026-03-19 16:36:47.', 0),
(144, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 10, '2026-03-19 16:37:06', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en DOCUMENTAL para reserva #10 el 2026-03-19 16:37:06.', 0),
(145, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 10, '2026-03-20 08:50:18', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en DOCUMENTAL para reserva #10 el 2026-03-20 08:50:18.', 0),
(146, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 10, '2026-03-20 09:54:01', 'YEIN STEFANNY VARGAS ZORRO registró convenio de colaboración para la placa EQX848 en la reserva #10 el 2026-03-20 09:54:01.', 0),
(147, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 10, '2026-03-20 09:54:20', 'YEIN STEFANNY VARGAS ZORRO registró convenio de colaboración para la placa EQX848 en la reserva #10 el 2026-03-20 09:54:20.', 0),
(148, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 10, '2026-03-20 09:54:38', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en DOCUMENTAL para reserva #10 el 2026-03-20 09:54:38.', 0),
(149, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 10, '2026-03-20 11:02:40', 'YEIN STEFANNY VARGAS ZORRO registró convenio de colaboración para la placa ERL151 en la reserva #10 el 2026-03-20 11:02:40.', 0),
(150, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 10, '2026-03-20 11:02:59', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en DOCUMENTAL para reserva #10 el 2026-03-20 11:02:59.', 0),
(151, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 10, '2026-03-20 11:27:30', 'YEIN STEFANNY VARGAS ZORRO ancló placa EQX848 y conductor STEFANNY VARGAS (INICIO, consecutivo 1); placa ERL151 y conductor STEFANNY VARGAS (FIN, consecutivo 1); placa EQX848 y conductor STEFANNY VARGAS (INICIO, consecutivo 2); placa EQX848 y conductor STEFANNY VARGAS (FIN, consecutivo 2) a la reserva #10 el 2026-03-20 11:27:30.', 0),
(152, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 10, '2026-03-20 11:27:49', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en OPERACIONES para reserva #10 el 2026-03-20 11:27:49.', 0),
(153, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'COMERCIAL', 'servicios_ocasionales', 11, '2026-03-20 11:56:02', 'Se creó la reserva ocasional #11 el 2026-03-20 11:56:02.', 0),
(154, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 11, '2026-03-20 12:06:11', 'YEIN STEFANNY VARGAS ZORRO subió el recibo de caja abono 1 de la reserva #11 el 2026-03-20 12:06:11.', 0),
(155, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 11, '2026-03-20 12:06:27', 'YEIN STEFANNY VARGAS ZORRO subió el recibo de caja abono 2 de la reserva #11 el 2026-03-20 12:06:27.', 0),
(156, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 11, '2026-03-20 12:06:42', 'YEIN STEFANNY VARGAS ZORRO subió el factura de la reserva #11 el 2026-03-20 12:06:42.', 0),
(157, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'CONTABILIDAD', 'servicios_ocasionales', 11, '2026-03-20 12:06:58', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en CONTABILIDAD para reserva #11 el 2026-03-20 12:06:58.', 0),
(158, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 11, '2026-03-20 12:10:36', 'YEIN STEFANNY VARGAS ZORRO ancló placa FSQ695 y conductor STEFANNY VARGAS (INICIO, consecutivo 1); placa FSQ695 y conductor STEFANNY VARGAS (FIN, consecutivo 1); placa ETM421 y conductor STEFANNY VARGAS (INICIO, consecutivo 2); placa ETM421 y conductor STEFANNY VARGAS (FIN, consecutivo 2) a la reserva #11 el 2026-03-20 12:10:36.', 0),
(159, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 11, '2026-03-20 12:10:56', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en OPERACIONES para reserva #11 el 2026-03-20 12:10:56.', 0),
(160, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 11, '2026-03-20 12:16:48', 'YEIN STEFANNY VARGAS ZORRO registró convenio de colaboración para la placa ETM421 en la reserva #11 el 2026-03-20 12:16:48.', 0),
(161, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 11, '2026-03-20 12:17:08', 'YEIN STEFANNY VARGAS ZORRO subió el FUEC de la placa FSQ695 para la reserva #11 el 2026-03-20 12:17:08.', 0),
(162, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 11, '2026-03-20 12:17:27', 'YEIN STEFANNY VARGAS ZORRO subió el FUEC de la placa ETM421 para la reserva #11 el 2026-03-20 12:17:27.', 0),
(163, 0, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 11, '2026-03-20 12:17:46', 'YEIN STEFANNY VARGAS ZORRO realizó acción CONFIRMAR en DOCUMENTAL para reserva #11 el 2026-03-20 12:17:46.', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `notificaciones_internas_admin`
--
ALTER TABLE `notificaciones_internas_admin`
  ADD PRIMARY KEY (`id_notificacion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `notificaciones_internas_admin`
--
ALTER TABLE `notificaciones_internas_admin`
  MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
