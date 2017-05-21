-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-05-2017 a las 23:00:23
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
  `CantidadOperaciones` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`Legajo`, `Nombre`, `Apellido`, `Turno`, `Dia`, `Mes`, `Anio`, `CantidadOperaciones`) VALUES
(3, 'leonardo', 'orlando', 'noche', 21, 5, 2017, 0);

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
(1, 'P1E', 'NORMAL', 'Disponible'),
(1, 'P1F', 'NORMAL', 'Disponible'),
(1, 'P1G', 'NORMAL', 'Disponible'),
(1, 'P1H', 'NORMAL', 'Disponible'),
(1, 'P1I', 'NORMAL', 'Disponible'),
(1, 'P1J', 'NORMAL', 'Ocupado'),
(2, 'P2A', 'NORMAL', 'Disponible'),
(2, 'P2B', 'NORMAL', 'Disponible'),
(2, 'P2C', 'NORMAL', 'Disponible'),
(2, 'P2D', 'NORMAL', 'Disponible'),
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
(3, 'P3E', 'NORMAL', 'Disponible'),
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
  `Nombre` varchar(50) NOT NULL,
  `Apellido` varchar(50) NOT NULL,
  `Contrasenia` varchar(30) NOT NULL,
  `Edad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`Legajo`, `Nombre`, `Apellido`, `Contrasenia`, `Edad`) VALUES
(1, 'Rodrigo', 'Balabasquer', '29deseptiembre1774', 20),
(3, 'leonardo', 'orlando', 'leonardoorlando', 22);

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
  `Anio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`Patente`, `Color`, `Marca`, `Hora`, `Minuto`, `Dia`, `Mes`, `Anio`) VALUES
('APS547', 'Rojo', 'Fiat', 22, 33, 21, 5, 2017);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`Legajo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `Legajo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
