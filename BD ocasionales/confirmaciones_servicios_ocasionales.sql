-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-03-2026 a las 07:28:36
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
-- Estructura de tabla para la tabla `confirmaciones_servicios_ocasionales`
--

CREATE TABLE `confirmaciones_servicios_ocasionales` (
  `id_servicio_ocasional` int(11) NOT NULL,
  `confirmacion_contabilidad` tinyint(1) NOT NULL DEFAULT 0,
  `usuario_contabilidad` int(11) DEFAULT NULL,
  `fecha_contabilidad` datetime DEFAULT NULL,
  `documentos_contabilidad` text DEFAULT NULL,
  `confirmacion_operaciones` tinyint(1) NOT NULL DEFAULT 0,
  `usuario_operaciones` int(11) DEFAULT NULL,
  `fecha_operaciones` datetime DEFAULT NULL,
  `confirmacion_documental` tinyint(1) NOT NULL DEFAULT 0,
  `usuario_documental` int(11) DEFAULT NULL,
  `fecha_documental` datetime DEFAULT NULL,
  `confirmacion_conductor` tinyint(1) NOT NULL DEFAULT 0,
  `usuario_conductor` int(11) DEFAULT NULL,
  `fecha_conductor` datetime DEFAULT NULL,
  `estado_contabilidad` varchar(30) DEFAULT NULL,
  `estado_operaciones` varchar(30) DEFAULT NULL,
  `estado_documental` varchar(30) DEFAULT NULL,
  `estado_conductor` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `confirmaciones_servicios_ocasionales`
--

INSERT INTO `confirmaciones_servicios_ocasionales` (`id_servicio_ocasional`, `confirmacion_contabilidad`, `usuario_contabilidad`, `fecha_contabilidad`, `documentos_contabilidad`, `confirmacion_operaciones`, `usuario_operaciones`, `fecha_operaciones`, `confirmacion_documental`, `usuario_documental`, `fecha_documental`, `confirmacion_conductor`, `usuario_conductor`, `fecha_conductor`, `estado_contabilidad`, `estado_operaciones`, `estado_documental`, `estado_conductor`) VALUES
(3, 1, 3851, '2026-02-16 16:08:01', '{\"primer_abono\":1,\"segundo_abono\":1,\"orden_compra\":1,\"segundo_abono_existe\":1}', 1, 3851, '2026-02-16 16:08:41', 1, 3851, '2026-03-12 14:40:25', 0, NULL, NULL, 'CONFIRMAR', 'CONFIRMAR', 'CONFIRMAR', NULL),
(4, 1, 1433, '2026-03-16 15:07:48', '{\"primer_abono\":1,\"segundo_abono\":1,\"orden_compra\":1,\"segundo_abono_existe\":1}', 1, 3851, '2026-03-17 15:10:45', 1, 3851, '2026-02-16 15:47:49', 1, 3851, '2026-02-16 15:47:49', 'CONFIRMAR', 'CONFIRMAR', 'CONFIRMAR', 'CONFIRMAR'),
(5, 1, 3851, '2026-03-05 16:10:04', '{\"primer_abono\":1,\"segundo_abono\":1,\"orden_compra\":1,\"segundo_abono_existe\":1}', 1, 3851, '2026-03-17 08:05:30', 1, 3851, '2026-03-17 08:21:01', 1, 3851, '2026-03-05 16:10:10', 'CONFIRMAR', 'CONFIRMAR', 'CONFIRMAR', 'CONFIRMAR'),
(6, 1, 1433, '2026-03-16 15:46:52', '{\"primer_abono\":1,\"segundo_abono\":1,\"orden_compra\":1,\"segundo_abono_existe\":1}', 1, 1433, '2026-03-16 16:04:27', 1, 3851, '2026-03-09 13:29:15', 0, 4280, '2026-03-17 15:46:17', 'CONFIRMAR', 'CONFIRMAR', 'CONFIRMAR', 'NO CONFIRMADO'),
(7, 1, 3851, '2026-03-17 09:05:44', '{\"primer_abono\":1,\"segundo_abono\":1,\"orden_compra\":1,\"segundo_abono_existe\":1}', 1, 3851, '2026-03-17 08:51:15', 1, 3851, '2026-03-13 08:48:46', 1, 4280, '2026-03-13 10:06:44', 'CONFIRMAR', 'CONFIRMAR', 'CONFIRMAR', 'CONFIRMADO'),
(8, 1, 3851, '2026-03-17 16:45:14', '{\"primer_abono\":1,\"segundo_abono\":1,\"orden_compra\":1,\"segundo_abono_existe\":1}', 1, 3851, '2026-03-17 16:47:36', 1, 3851, '2026-03-17 16:54:34', 0, NULL, NULL, 'CONFIRMAR', 'CONFIRMAR', 'CONFIRMAR', NULL),
(9, 1, 3851, '2026-03-18 08:09:52', '{\"primer_abono\":1,\"segundo_abono\":1,\"orden_compra\":1,\"segundo_abono_existe\":1}', 1, 3851, '2026-03-18 15:17:15', 1, 3851, '2026-03-18 08:22:53', 1, 4280, '2026-03-18 08:34:35', 'CONFIRMAR', 'CONFIRMAR', 'CONFIRMAR', 'CONFIRMADO'),
(10, 1, 3851, '2026-03-19 16:24:41', '{\"primer_abono\":1,\"segundo_abono\":1,\"orden_compra\":1,\"segundo_abono_existe\":1}', 1, 3851, '2026-03-20 11:27:49', 1, 3851, '2026-03-20 11:02:59', 0, NULL, NULL, 'CONFIRMAR', 'CONFIRMAR', 'CONFIRMAR', NULL),
(11, 1, 3851, '2026-03-20 12:06:58', '{\"primer_abono\":1,\"segundo_abono\":1,\"orden_compra\":1,\"segundo_abono_existe\":1}', 1, 3851, '2026-03-20 12:10:56', 1, 3851, '2026-03-20 12:17:46', 0, NULL, NULL, 'CONFIRMAR', 'CONFIRMAR', 'CONFIRMAR', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `confirmaciones_servicios_ocasionales`
--
ALTER TABLE `confirmaciones_servicios_ocasionales`
  ADD PRIMARY KEY (`id_servicio_ocasional`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
