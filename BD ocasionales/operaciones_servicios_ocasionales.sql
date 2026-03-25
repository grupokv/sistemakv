-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-03-2026 a las 07:20:40
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
-- Estructura de tabla para la tabla `operaciones_servicios_ocasionales`
--

CREATE TABLE `operaciones_servicios_ocasionales` (
  `id_operacion` int(11) NOT NULL,
  `id_servicio_ocasional` int(11) NOT NULL,
  `consecutivo` int(11) NOT NULL,
  `id_vehiculo_inicio` int(11) DEFAULT NULL,
  `id_vehiculo_fin` int(11) DEFAULT NULL,
  `id_conductor_inicio` int(11) DEFAULT NULL,
  `id_conductor_fin` int(11) DEFAULT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `direccion_origen` varchar(255) DEFAULT NULL,
  `direccion_destino` varchar(255) DEFAULT NULL,
  `tipo_recorrido` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `operaciones_servicios_ocasionales`
--

INSERT INTO `operaciones_servicios_ocasionales` (`id_operacion`, `id_servicio_ocasional`, `consecutivo`, `id_vehiculo_inicio`, `id_vehiculo_fin`, `id_conductor_inicio`, `id_conductor_fin`, `fecha_registro`, `direccion_origen`, `direccion_destino`, `tipo_recorrido`) VALUES
(2, 3, 1, 637, 637, 2356, 2356, '2026-02-16 16:08:41', NULL, NULL, NULL),
(39, 6, 1, 1007, 1007, 3558, 3558, '2026-03-16 16:04:14', 'CALLE TAL HASTA LA CALLE TAL', 'DESDE LA CALLE TOL HASTA LA CALLE TOL', 'IDA_Y_REGRESO'),
(40, 6, 2, 1007, 1007, 3, 3, '2026-03-16 16:04:14', 'CALLE TAL HASTA LA CALLE TAL', 'DESDE LA CALLE TOL HASTA LA CALLE TOL', 'IDA_Y_REGRESO'),
(41, 5, 1, 1007, 1007, 3, 3558, '2026-03-17 08:05:21', 'CARRERA 13 #14-24 LOCALIDAD DE ENGATIVA', 'ALLE 15 #85-2 SUR BARRIO LA VEGA', 'DISPONIBILIDAD_DIA'),
(42, 5, 2, 637, 637, 2356, 2356, '2026-03-17 08:05:21', 'CALLE TAL HASTA LA CALLE TAL', 'DESDE LA CALLE TOL HASTA LA CALLE TOL', 'IDA_Y_REGRESO'),
(43, 7, 1, 1007, 1733, 3558, 3558, '2026-03-17 08:51:07', 'CARRERA 13 #14-24 LOCALIDAD DE ENGATIVA', 'ALLE 15 #85-2 SUR BARRIO LA VEGA', 'DISPONIBILIDAD_DIA'),
(44, 7, 2, 1007, 1007, 3558, 3386, '2026-03-17 08:51:07', 'CALLE TAL HASTA LA CALLE TAL', 'DESDE LA CALLE TOL HASTA LA CALLE TOL', 'IDA_Y_REGRESO'),
(47, 4, 1, 1668, 1668, 3558, 3558, '2026-03-17 15:10:21', 'CARRERA 13 #14-24 LOCALIDAD DE ENGATIVA', 'ALLE 15 #85-2 SUR BARRIO LA VEGA', 'DISPONIBILIDAD_DIA'),
(48, 8, 1, 1007, 1007, 3558, 3558, '2026-03-17 16:47:24', 'AC 116 #70C 58, SUBA, BOGOTÁ, CUNDINAMARCA', 'CENTRO HISTÓRICO, CL. 41 #44 - 72, NTE. CENTRO HISTORICO, BARRANQUILLA, ATLÁNTICO', 'IDA_Y_REGRESO'),
(50, 9, 1, 1007, 1007, 3558, 3558, '2026-03-18 15:16:44', 'AC 116 #70C 58, SUBA, BOGOTÁ, CUNDINAMARCA', 'CL. 41 #44 - 72, NTE. CENTRO HISTORICO, BARRANQUILLA, ATLÁNTICO', 'IDA_Y_REGRESO'),
(51, 9, 2, 1868, 589, 1025, 3558, '2026-03-18 15:16:44', 'AC 116 #70C 58, SUBA, BOGOTÁ, CUNDINAMARCA', 'AC 116 #70C 58, SUBA, BOGOTÁ, CUNDINAMARCA', 'DISPONIBILIDAD_DIA'),
(52, 9, 3, 1933, 829, 3138, 3535, '2026-03-18 15:16:44', 'AC 116 #70C 58, SUBA, BOGOTÁ, CUNDINAMARCA', 'AC 116 #70C 58, SUBA, BOGOTÁ, CUNDINAMARCA', 'REGRESO'),
(53, 9, 4, 1535, 2111, 2366, 2945, '2026-03-18 15:16:44', 'AC 116 #70C 58, SUBA, BOGOTÁ, CUNDINAMARCA', 'AC 116 #70C 58, SUBA, BOGOTÁ, CUNDINAMARCA', 'DISPONIBILIDAD_DIA'),
(56, 10, 1, 1900, 21, 3558, 3558, '2026-03-20 11:27:30', 'asdfasdf', '2fdddsssdddddfdsfsfsd', 'IDA_Y_REGRESO'),
(57, 10, 2, 1900, 1900, 3558, 3558, '2026-03-20 11:27:30', 'asdffffdsasdfasdf', 'fasdffffdsasdfasdf', 'DISPONIBILIDAD_DIA'),
(58, 11, 1, 589, 589, 3558, 3558, '2026-03-20 12:10:36', 'CALLE 26 #68C-61, SECTOR SALITRE – BOGOTÁ', 'HOTEL TAMACÁ BEACH RESORT', 'IDA_Y_REGRESO'),
(59, 11, 2, 1678, 1678, 3558, 3558, '2026-03-20 12:10:36', 'CALLE 26 #68C-61, SECTOR SALITRE – BOGOTÁ', 'HOTEL TAMACÁ BEACH RESORT', 'IDA_Y_REGRESO');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `operaciones_servicios_ocasionales`
--
ALTER TABLE `operaciones_servicios_ocasionales`
  ADD PRIMARY KEY (`id_operacion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `operaciones_servicios_ocasionales`
--
ALTER TABLE `operaciones_servicios_ocasionales`
  MODIFY `id_operacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
