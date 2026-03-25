-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-03-2026 a las 07:26:54
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
-- Estructura de tabla para la tabla `notificaciones_internas_conductor`
--

CREATE TABLE `notificaciones_internas_conductor` (
  `id_notificacion` int(11) NOT NULL,
  `id_conductor` int(11) NOT NULL,
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
-- Volcado de datos para la tabla `notificaciones_internas_conductor`
--

INSERT INTO `notificaciones_internas_conductor` (`id_notificacion`, `id_conductor`, `id_usuario_remitente`, `remitente`, `area`, `modulo`, `id_referencia`, `fecha_hora`, `contenido`, `leido`) VALUES
(1, 3244, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 4, '2026-03-17 15:08:53', 'YEIN STEFANNY VARGAS ZORRO te asignó a la reserva ocasional #4 (BELLER ARLEY HERNANDEZ PEREZ) el 2026-03-17 15:08:53.', 0),
(2, 3558, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 4, '2026-03-17 15:08:55', 'YEIN STEFANNY VARGAS ZORRO retiró tu asignación de la reserva ocasional #4 (STEFANNY VARGAS) el 2026-03-17 15:08:55.', 0),
(3, 3558, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 4, '2026-03-17 15:10:41', 'YEIN STEFANNY VARGAS ZORRO te asignó a la reserva ocasional #4 (STEFANNY VARGAS) el 2026-03-17 15:10:41.', 0),
(4, 3244, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 4, '2026-03-17 15:10:42', 'YEIN STEFANNY VARGAS ZORRO retiró tu asignación de la reserva ocasional #4 (BELLER ARLEY HERNANDEZ PEREZ) el 2026-03-17 15:10:42.', 0),
(5, 3558, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 8, '2026-03-17 16:47:35', 'YEIN STEFANNY VARGAS ZORRO te asignó a la reserva ocasional #8 (STEFANNY VARGAS) el 2026-03-17 16:47:35.', 0),
(6, 3558, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 8, '2026-03-17 16:54:32', 'YEIN STEFANNY VARGAS ZORRO subió el FUEC de la placa JTP626 para tu servicio en la reserva #8 el 2026-03-17 16:54:32.', 0),
(7, 3558, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 9, '2026-03-18 08:19:51', 'YEIN STEFANNY VARGAS ZORRO te asignó a la reserva ocasional #9 (STEFANNY VARGAS) el 2026-03-18 08:19:51.', 0),
(8, 3558, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 9, '2026-03-18 08:22:50', 'YEIN STEFANNY VARGAS ZORRO subió el FUEC de la placa JTP626 para tu servicio en la reserva #9 el 2026-03-18 08:22:49.', 0),
(9, 3558, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 9, '2026-03-18 15:17:01', 'YEIN STEFANNY VARGAS ZORRO te asignó a la reserva ocasional #9 (STEFANNY VARGAS) el 2026-03-18 15:17:01.', 0),
(10, 1025, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 9, '2026-03-18 15:17:03', 'YEIN STEFANNY VARGAS ZORRO te asignó a la reserva ocasional #9 (ADONIAS HERNAN TOCASUCHE BERMUDEZ) el 2026-03-18 15:17:03.', 0),
(11, 3138, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 9, '2026-03-18 15:17:03', 'YEIN STEFANNY VARGAS ZORRO te asignó a la reserva ocasional #9 (EVER EDUARDO ARISTIZABAL LONDOÑO) el 2026-03-18 15:17:03.', 0),
(12, 3535, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 9, '2026-03-18 15:17:06', 'YEIN STEFANNY VARGAS ZORRO te asignó a la reserva ocasional #9 (RENE SASTOQUE ARIZA) el 2026-03-18 15:17:06.', 0),
(13, 2366, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 9, '2026-03-18 15:17:09', 'YEIN STEFANNY VARGAS ZORRO te asignó a la reserva ocasional #9 (YEFERSON DAVID SANABRIA SANCHEZ ) el 2026-03-18 15:17:09.', 0),
(14, 2945, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 9, '2026-03-18 15:17:12', 'YEIN STEFANNY VARGAS ZORRO te asignó a la reserva ocasional #9 (FERNANDO CASTRO MOLANO ) el 2026-03-18 15:17:12.', 0),
(15, 3558, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 10, '2026-03-19 16:35:01', 'YEIN STEFANNY VARGAS ZORRO te asignó a la reserva ocasional #10 (STEFANNY VARGAS) el 2026-03-19 16:35:01.', 0),
(16, 3558, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 10, '2026-03-19 16:36:25', 'YEIN STEFANNY VARGAS ZORRO subió el FUEC de la placa EQX848 para tu servicio en la reserva #10 el 2026-03-19 16:36:25.', 0),
(17, 3558, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 10, '2026-03-19 16:36:44', 'YEIN STEFANNY VARGAS ZORRO subió el FUEC de la placa ERL151 para tu servicio en la reserva #10 el 2026-03-19 16:36:44.', 0),
(18, 3558, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 10, '2026-03-19 16:37:03', 'YEIN STEFANNY VARGAS ZORRO subió el FUEC de la placa EQX848 para tu servicio en la reserva #10 el 2026-03-19 16:37:03.', 0),
(19, 3558, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 10, '2026-03-20 09:54:17', 'YEIN STEFANNY VARGAS ZORRO registró convenio de colaboración para la placa EQX848 en tu servicio de la reserva #10 el 2026-03-20 09:54:17.', 0),
(20, 3558, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 10, '2026-03-20 09:54:35', 'YEIN STEFANNY VARGAS ZORRO registró convenio de colaboración para la placa EQX848 en tu servicio de la reserva #10 el 2026-03-20 09:54:35.', 0),
(21, 3558, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 10, '2026-03-20 11:02:57', 'YEIN STEFANNY VARGAS ZORRO registró convenio de colaboración para la placa ERL151 en tu servicio de la reserva #10 el 2026-03-20 11:02:56.', 0),
(22, 3558, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 10, '2026-03-20 11:27:46', 'YEIN STEFANNY VARGAS ZORRO te asignó a la reserva ocasional #10 (STEFANNY VARGAS) el 2026-03-20 11:27:46.', 0),
(23, 3558, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'OPERACIONES', 'servicios_ocasionales', 11, '2026-03-20 12:10:53', 'YEIN STEFANNY VARGAS ZORRO te asignó a la reserva ocasional #11 (STEFANNY VARGAS) el 2026-03-20 12:10:53.', 0),
(24, 3558, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 11, '2026-03-20 12:17:05', 'YEIN STEFANNY VARGAS ZORRO registró convenio de colaboración para la placa ETM421 en tu servicio de la reserva #11 el 2026-03-20 12:17:05.', 0),
(25, 3558, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 11, '2026-03-20 12:17:25', 'YEIN STEFANNY VARGAS ZORRO subió el FUEC de la placa FSQ695 para tu servicio en la reserva #11 el 2026-03-20 12:17:25.', 0),
(26, 3558, 3851, 'YEIN STEFANNY VARGAS ZORRO', 'DOCUMENTAL', 'servicios_ocasionales', 11, '2026-03-20 12:17:43', 'YEIN STEFANNY VARGAS ZORRO subió el FUEC de la placa ETM421 para tu servicio en la reserva #11 el 2026-03-20 12:17:43.', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `notificaciones_internas_conductor`
--
ALTER TABLE `notificaciones_internas_conductor`
  ADD PRIMARY KEY (`id_notificacion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `notificaciones_internas_conductor`
--
ALTER TABLE `notificaciones_internas_conductor`
  MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
