-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-06-2017 a las 21:29:03
-- Versión del servidor: 10.1.21-MariaDB
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tp-estacionamiento`
--
CREATE DATABASE IF NOT EXISTS `tp-estacionamiento` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `tp-estacionamiento`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cocheras`
--

CREATE TABLE `cocheras` (
  `Fecha` date NOT NULL,
  `Cochera` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cocheras`
--

INSERT INTO `cocheras` (`Fecha`, `Cochera`) VALUES
('2017-06-14', 'P3E'),
('2017-06-14', 'P3E'),
('2017-06-14', 'P2D');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `Legajo` int(11) DEFAULT NULL,
  `Turno` varchar(30) DEFAULT NULL,
  `Fecha` datetime NOT NULL,
  `CantidadOperaciones` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `Nivel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`Legajo`, `Turno`, `Fecha`, `CantidadOperaciones`, `id`, `Nivel`) VALUES
(7, 'noche', '2017-05-26 19:00:00', 1, 1, 0),
(7, 'tarde', '2017-05-26 12:00:00', 1, 4, 0),
(8, 'tarde', '2017-05-26 12:00:00', 2, 5, 0),
(8, 'tarde', '2017-05-26 12:00:00', 1, 6, 0),
(7, 'noche', '2017-05-26 19:00:00', 1, 7, 0),
(7, 'noche', '2017-05-28 19:00:00', 4, 8, 0),
(8, 'tarde', '2017-06-03 12:00:00', 2, 14, 0),
(7, 'tarde', '2017-06-03 12:00:00', 1, 15, 0),
(1, 'tarde', '2017-06-03 12:00:00', 0, 16, 1),
(9, 'tarde', '2017-06-03 12:00:00', 0, 17, 0),
(1, 'noche', '2017-06-03 19:00:00', 2, 18, 1),
(1, 'noche', '2017-06-09 20:23:58', 2, 26, 1),
(1, 'tarde', '2017-06-14 14:30:16', 6, 27, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estacionamiento`
--

CREATE TABLE `estacionamiento` (
  `Piso` int(11) NOT NULL,
  `Cochera` varchar(30) NOT NULL,
  `Condicion` varchar(30) NOT NULL,
  `Estado` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estacionamiento`
--

INSERT INTO `estacionamiento` (`Piso`, `Cochera`, `Condicion`, `Estado`) VALUES
(1, 'P1A', 'DISCAPACITADO', 'Disponible'),
(1, 'P1B', 'DISCAPACITADO', 'Disponible'),
(1, 'P1C', 'DISCAPACITADO', 'Disponible'),
(1, 'P1D', 'NORMAL', 'Disponible'),
(1, 'P1E', 'NORMAL', 'Ocupado'),
(1, 'P1F', 'NORMAL', 'Disponible'),
(1, 'P1G', 'NORMAL', 'Disponible'),
(1, 'P1H', 'NORMAL', 'Disponible'),
(1, 'P1I', 'NORMAL', 'Disponible'),
(1, 'P1J', 'NORMAL', 'Disponible'),
(2, 'P2A', 'NORMAL', 'Ocupado'),
(2, 'P2B', 'NORMAL', 'Disponible'),
(2, 'P2C', 'NORMAL', 'Disponible'),
(2, 'P2D', 'NORMAL', 'Ocupado'),
(2, 'P2E', 'NORMAL', 'Disponible'),
(2, 'P2F', 'NORMAL', 'Disponible'),
(2, 'P2G', 'NORMAL', 'Disponible'),
(2, 'P2H', 'NORMAL', 'Disponible'),
(2, 'P2I', 'NORMAL', 'Disponible'),
(2, 'P2J', 'NORMAL', 'Disponible'),
(3, 'P3A', 'NORMAL', 'Disponible'),
(3, 'P3B', 'NORMAL', 'Disponible'),
(3, 'P3C', 'NORMAL', 'Disponible'),
(3, 'P3D', 'NORMAL', 'Disponible'),
(3, 'P3E', 'NORMAL', 'Ocupado'),
(3, 'P3F', 'NORMAL', 'Disponible'),
(3, 'P3G', 'NORMAL', 'Disponible'),
(3, 'P3H', 'NORMAL', 'Disponible'),
(3, 'P3I', 'NORMAL', 'Disponible'),
(3, 'P3J', 'NORMAL', 'Disponible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `Legajo` int(11) NOT NULL,
  `Usuario` varchar(50) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Apellido` varchar(50) NOT NULL,
  `DNI` int(11) NOT NULL,
  `Contrasenia` varchar(30) NOT NULL,
  `Edad` int(11) NOT NULL,
  `Estado` varchar(30) NOT NULL,
  `Nivel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`Legajo`, `Usuario`, `Nombre`, `Apellido`, `DNI`, `Contrasenia`, `Edad`, `Estado`, `Nivel`) VALUES
(1, '40346261', 'Rodrigo', 'Balabasquer', 40346261, '40346261', 20, 'Activo', 1),
(7, '85241236', 'matias', 'binevies', 85241236, '85241236', 20, 'Activo', 0),
(8, '48752196', 'david', 'pinel', 48752196, '48752196', 21, 'Activo', 0),
(9, '75102547', 'Ezequile', 'Balneares', 75102547, '75102547', 30, 'Despedido', 0),
(12, '11235945', 'Julian', 'Cuba', 11235945, '11235945', 24, 'Despedido', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `Patente` varchar(30) NOT NULL,
  `Color` varchar(30) NOT NULL,
  `Marca` varchar(30) NOT NULL,
  `Fecha` datetime NOT NULL,
  `Operacion` varchar(30) NOT NULL,
  `Pago` int(11) NOT NULL,
  `Cochera` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`Patente`, `Color`, `Marca`, `Fecha`, `Operacion`, `Pago`, `Cochera`) VALUES
('AQC548', 'Rojo', 'FIAT', '2017-05-26 00:09:00', 'IngresoFin', 0, 'P2D'),
('AQC548', 'Rojo', 'FIAT', '2017-05-26 17:25:00', 'Egreso', 140, 'P2D'),
('QOD872', 'Verde', 'Chevrolet', '2017-05-26 17:50:00', 'IngresoFin', 0, 'P1G'),
('XSN810', 'Violeta', 'FORT', '2017-05-26 17:51:00', 'IngresoFin', 0, 'P3A'),
('QOD872', 'Verde', 'Chevrolet', '2017-05-26 18:45:00', 'IngresoFin', 0, 'P1G'),
('WTX045', 'Naranja', 'FIAT', '2017-05-26 22:01:00', 'IngresoFin', 0, 'P1G'),
('QZC111', 'Gris', 'XXX', '2017-05-28 20:00:00', 'IngresoFin', 0, 'P2B'),
('XSN810', 'Violeta', 'FORT', '2017-05-28 20:02:00', 'Egreso', 360, 'P3A'),
('AZF806', 'Verde', 'Z', '2017-05-28 20:03:00', 'IngresoFin', 0, 'P2A'),
('QZC903', 'Negro', 'FIAT', '2017-06-03 15:15:00', 'IngresoFin', 0, 'P1D'),
('AZF806', 'Verde', 'Z', '2017-06-03 15:16:00', 'Egreso', 1010, 'P2A'),
('QZC903', 'Negro', 'FIAT', '2017-06-03 16:20:00', 'IngresoFin', 10, 'P1D'),
('MND123', 'Blanco', 'Chevrolet', '2017-06-03 20:41:00', 'IngresoFin', 0, 'P1D'),
('QZC111', 'Gris', 'XXX', '2017-06-03 20:42:00', 'Egreso', 1020, 'P2B'),
('WTX045', 'Naranja', 'FIAT', '2017-06-07 22:55:00', 'Egreso', 2040, 'P1G'),
('MND123', 'Blanco', 'Chevrolet', '2017-06-08 22:18:00', 'IngresoFin', 860, 'P1D'),
('QWE456', 'Rojo', 'FIAT', '2017-06-09 17:28:19', 'IngresoFin', 0, 'P1C'),
('QWE456', 'Rojo', 'FIAT', '2017-06-09 18:38:38', 'Egreso', 20, 'P1C'),
('QSZ684', 'Rojo', 'FIAT', '2017-06-09 20:25:59', 'IngresoFin', 0, 'P1D'),
('QSR684', 'Azul', 'FIAT', '2017-06-09 20:26:48', 'Ingreso', 0, 'P1E'),
('AQZ945', 'Blanco', 'Nokia', '2017-06-14 14:34:51', 'Ingreso', 0, 'P2A'),
('QSZ684', 'Rojo', 'FIAT', '2017-06-14 14:35:24', 'Egreso', 840, 'P1D'),
('HJF562', 'Dorado', 'Chevrolet', '2017-06-14 15:08:31', 'IngresoFin', 0, 'P3E'),
('HJF562', 'Dorado', 'Chevrolet', '2017-06-14 15:45:50', 'Egreso', 10, 'P3E'),
('adsas', 'qdsasd', 'asdads', '2017-06-14 15:46:18', 'Ingreso', 0, 'P3E'),
('qew', 'asd', 'zcx', '2017-06-14 15:46:30', 'Ingreso', 0, 'P2D');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`Legajo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `Legajo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
