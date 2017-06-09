-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-06-2017 a las 02:14:52
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
  `id` int(11) NOT NULL,
  `Cochera` varchar(30) NOT NULL,
  `Caracteristica` varchar(30) NOT NULL,
  `Cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cocheras`
--

INSERT INTO `cocheras` (`id`, `Cochera`, `Caracteristica`, `Cantidad`) VALUES
(1, 'P2A', 'Mas utilizada', 2),
(1, 'P1G', 'Menos utilizada', 1),
(1, 'P2B', 'Menos utilizada', 1),
(1, 'P3A', 'Menos utilizada', 1),
(1, 'P1A', 'No utilizada', 0),
(1, 'P1B', 'No utilizada', 0),
(1, 'P1C', 'No utilizada', 0),
(1, 'P1D', 'No utilizada', 0),
(1, 'P1E', 'No utilizada', 0),
(1, 'P1F', 'No utilizada', 0),
(1, 'P1H', 'No utilizada', 0),
(1, 'P1I', 'No utilizada', 0),
(1, 'P1J', 'No utilizada', 0),
(1, 'P2C', 'No utilizada', 0),
(1, 'P2D', 'No utilizada', 0),
(1, 'P2E', 'No utilizada', 0),
(1, 'P2F', 'No utilizada', 0),
(1, 'P2G', 'No utilizada', 0),
(1, 'P2H', 'No utilizada', 0),
(1, 'P2I', 'No utilizada', 0),
(1, 'P2J', 'No utilizada', 0),
(1, 'P3B', 'No utilizada', 0),
(1, 'P3C', 'No utilizada', 0),
(1, 'P3D', 'No utilizada', 0),
(1, 'P3E', 'No utilizada', 0),
(1, 'P3F', 'No utilizada', 0),
(1, 'P3G', 'No utilizada', 0),
(1, 'P3H', 'No utilizada', 0),
(1, 'P3I', 'No utilizada', 0),
(1, 'P3J', 'No utilizada', 0),
(2, 'P1D', 'Mas utilizada', 2),
(2, 'P1G', 'Menos utilizada', 1),
(2, 'P2A', 'Menos utilizada', 1),
(2, 'P2B', 'Menos utilizada', 1),
(2, 'P1A', 'No utilizada', 0),
(2, 'P1B', 'No utilizada', 0),
(2, 'P1C', 'No utilizada', 0),
(2, 'P1E', 'No utilizada', 0),
(2, 'P1F', 'No utilizada', 0),
(2, 'P1H', 'No utilizada', 0),
(2, 'P1I', 'No utilizada', 0),
(2, 'P1J', 'No utilizada', 0),
(2, 'P2C', 'No utilizada', 0),
(2, 'P2D', 'No utilizada', 0),
(2, 'P2E', 'No utilizada', 0),
(2, 'P2F', 'No utilizada', 0),
(2, 'P2G', 'No utilizada', 0),
(2, 'P2H', 'No utilizada', 0),
(2, 'P2I', 'No utilizada', 0),
(2, 'P2J', 'No utilizada', 0),
(2, 'P3A', 'No utilizada', 0),
(2, 'P3B', 'No utilizada', 0),
(2, 'P3C', 'No utilizada', 0),
(2, 'P3D', 'No utilizada', 0),
(2, 'P3E', 'No utilizada', 0),
(2, 'P3F', 'No utilizada', 0),
(2, 'P3G', 'No utilizada', 0),
(2, 'P3H', 'No utilizada', 0),
(2, 'P3I', 'No utilizada', 0),
(2, 'P3J', 'No utilizada', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `Legajo` int(11) DEFAULT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Apellido` varchar(50) DEFAULT NULL,
  `Turno` varchar(30) DEFAULT NULL,
  `Dia` int(11) DEFAULT NULL,
  `Mes` int(11) DEFAULT NULL,
  `Anio` int(11) DEFAULT NULL,
  `CantidadOperaciones` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `Nivel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`Legajo`, `Nombre`, `Apellido`, `Turno`, `Dia`, `Mes`, `Anio`, `CantidadOperaciones`, `id`, `Nivel`) VALUES
(7, 'matias', 'binevies', 'noche', 26, 5, 2017, 1, 1, 0),
(7, 'matias', 'binevies', 'tarde', 26, 5, 2017, 1, 4, 0),
(8, 'david', 'pinel', 'tarde', 26, 5, 2017, 2, 5, 0),
(8, 'david', 'pinel', 'tarde', 26, 5, 2017, 1, 6, 0),
(7, 'matias', 'binevies', 'noche', 26, 5, 2017, 1, 7, 0),
(7, 'matias', 'binevies', 'noche', 28, 5, 2017, 4, 8, 0),
(8, 'david', 'pinel', 'tarde', 3, 6, 2017, 2, 14, 0),
(7, 'matias', 'binevies', 'tarde', 3, 6, 2017, 1, 15, 0),
(1, 'Rodrigo', 'Balabasquer', 'tarde', 3, 6, 2017, 0, 16, 1),
(9, 'Ezequile', 'Balneares', 'tarde', 3, 6, 2017, 0, 17, 0),
(1, 'Rodrigo', 'Balabasquer', 'noche', 3, 6, 2017, 2, 18, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estacionamiento`
--

CREATE TABLE `estacionamiento` (
  `Piso` int(11) NOT NULL,
  `Cochera` varchar(30) NOT NULL,
  `Condicion` varchar(30) NOT NULL,
  `Estado` varchar(30) NOT NULL,
  `Cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estacionamiento`
--

INSERT INTO `estacionamiento` (`Piso`, `Cochera`, `Condicion`, `Estado`, `Cantidad`) VALUES
(1, 'P1A', 'DISCAPACITADO', 'Disponible', 0),
(1, 'P1B', 'DISCAPACITADO', 'Disponible', 0),
(1, 'P1C', 'DISCAPACITADO', 'Disponible', 0),
(1, 'P1D', 'NORMAL', 'Disponible', 0),
(1, 'P1E', 'NORMAL', 'Disponible', 0),
(1, 'P1F', 'NORMAL', 'Disponible', 0),
(1, 'P1G', 'NORMAL', 'Disponible', 0),
(1, 'P1H', 'NORMAL', 'Disponible', 0),
(1, 'P1I', 'NORMAL', 'Disponible', 0),
(1, 'P1J', 'NORMAL', 'Disponible', 0),
(2, 'P2A', 'NORMAL', 'Disponible', 0),
(2, 'P2B', 'NORMAL', 'Disponible', 0),
(2, 'P2C', 'NORMAL', 'Disponible', 0),
(2, 'P2D', 'NORMAL', 'Disponible', 0),
(2, 'P2E', 'NORMAL', 'Disponible', 0),
(2, 'P2F', 'NORMAL', 'Disponible', 0),
(2, 'P2G', 'NORMAL', 'Disponible', 0),
(2, 'P2H', 'NORMAL', 'Disponible', 0),
(2, 'P2I', 'NORMAL', 'Disponible', 0),
(2, 'P2J', 'NORMAL', 'Disponible', 0),
(3, 'P3A', 'NORMAL', 'Disponible', 0),
(3, 'P3B', 'NORMAL', 'Disponible', 0),
(3, 'P3C', 'NORMAL', 'Disponible', 0),
(3, 'P3D', 'NORMAL', 'Disponible', 0),
(3, 'P3E', 'NORMAL', 'Disponible', 0),
(3, 'P3F', 'NORMAL', 'Disponible', 0),
(3, 'P3G', 'NORMAL', 'Disponible', 0),
(3, 'P3H', 'NORMAL', 'Disponible', 0),
(3, 'P3I', 'NORMAL', 'Disponible', 0),
(3, 'P3J', 'NORMAL', 'Disponible', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fechas`
--

CREATE TABLE `fechas` (
  `id` int(11) NOT NULL,
  `Dia` int(11) NOT NULL,
  `Mes` int(11) NOT NULL,
  `Anio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `fechas`
--

INSERT INTO `fechas` (`id`, `Dia`, `Mes`, `Anio`) VALUES
(1, 28, 5, 2017),
(2, 3, 6, 2017);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `Legajo` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Apellido` varchar(50) NOT NULL,
  `DNI` int(11) NOT NULL,
  `Contrasenia` int(11) NOT NULL,
  `Edad` int(11) NOT NULL,
  `Estado` varchar(30) NOT NULL,
  `Nivel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`Legajo`, `Nombre`, `Apellido`, `DNI`, `Contrasenia`, `Edad`, `Estado`, `Nivel`) VALUES
(1, 'Rodrigo', 'Balabasquer', 40346261, 40346261, 20, 'Activo', 1),
(7, 'matias', 'binevies', 85241236, 85241236, 20, 'Activo', 0),
(8, 'david', 'pinel', 48752196, 48752196, 21, 'Activo', 0),
(9, 'Ezequile', 'Balneares', 75102547, 75102547, 30, 'Despedido', 0),
(12, 'Julian', 'Cuba', 11235945, 11235945, 24, 'Despedido', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `Patente` varchar(30) NOT NULL,
  `Color` varchar(30) NOT NULL,
  `Marca` varchar(30) NOT NULL,
  `Hora` int(11) NOT NULL,
  `Minuto` int(11) NOT NULL,
  `Dia` int(11) NOT NULL,
  `Mes` int(11) NOT NULL,
  `Anio` int(11) NOT NULL,
  `Operacion` varchar(30) NOT NULL,
  `Pago` int(11) NOT NULL,
  `Cochera` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`Patente`, `Color`, `Marca`, `Hora`, `Minuto`, `Dia`, `Mes`, `Anio`, `Operacion`, `Pago`, `Cochera`) VALUES
('AQC548', 'Rojo', 'FIAT', 0, 9, 26, 5, 2017, 'IngresoFin', 0, 'P2D'),
('AQC548', 'Rojo', 'FIAT', 17, 25, 26, 5, 2017, 'Egreso', 140, 'P2D'),
('QOD872', 'Verde', 'Chevrolet', 17, 50, 26, 5, 2017, 'IngresoFin', 0, 'P1G'),
('XSN810', 'Violeta', 'FORT', 17, 51, 26, 5, 2017, 'IngresoFin', 0, 'P3A'),
('QOD872', 'Verde', 'Chevrolet', 18, 45, 26, 5, 2017, 'IngresoFin', 0, 'P1G'),
('WTX045', 'Naranja', 'FIAT', 22, 1, 26, 5, 2017, 'IngresoFin', 0, 'P1G'),
('QZC111', 'Gris', 'XXX', 20, 0, 28, 5, 2017, 'IngresoFin', 0, 'P2B'),
('XSN810', 'Violeta', 'FORT', 20, 2, 28, 5, 2017, 'Egreso', 360, 'P3A'),
('AZF806', 'Verde', 'Z', 20, 3, 28, 5, 2017, 'IngresoFin', 0, 'P2A'),
('QZC903', 'Negro', 'FIAT', 15, 15, 3, 6, 2017, 'IngresoFin', 0, 'P1D'),
('AZF806', 'Verde', 'Z', 15, 16, 3, 6, 2017, 'Egreso', 1010, 'P2A'),
('QZC903', 'Negro', 'FIAT', 16, 20, 3, 6, 2017, 'Egreso', 10, 'P1D'),
('MND123', 'Blanco', 'Chevrolet', 20, 41, 3, 6, 2017, 'Ingreso', 0, 'P1D'),
('QZC111', 'Gris', 'XXX', 20, 42, 3, 6, 2017, 'Egreso', 1020, 'P2B'),
('WTX045', 'Naranja', 'FIAT', 22, 55, 7, 6, 2017, 'Egreso', 2040, 'P1G');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `fechas`
--
ALTER TABLE `fechas`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT de la tabla `fechas`
--
ALTER TABLE `fechas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `Legajo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
