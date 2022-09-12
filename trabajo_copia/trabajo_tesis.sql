-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-09-2022 a las 04:05:44
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `trabajo_tesis`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `celular` int(10) NOT NULL,
  `rol` varchar(50) NOT NULL,
  `tipoUser` int(5) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`id`, `username`, `password`, `nombres`, `apellidos`, `correo`, `celular`, `rol`, `tipoUser`, `fecha`) VALUES
(1, 'admin', 'admin', 'secretaria', 'udenar', 'secretaria@udenar.edu.co', 1234567890, 'ADMINISTRADOR', 1, '2022-09-02 02:40:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

CREATE TABLE `docentes` (
  `id` int(11) NOT NULL,
  `cedula` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `celular` int(10) NOT NULL,
  `rol` enum('Estudiante','Docente') NOT NULL,
  `tipoUser` int(10) NOT NULL,
  `fecha` date NOT NULL DEFAULT current_timestamp(),
  `idEstudiante` int(11) DEFAULT NULL,
  `idTesis` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `id` int(11) NOT NULL,
  `cedula` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `celular` int(10) NOT NULL,
  `programa` varchar(100) NOT NULL,
  `sede` varchar(50) NOT NULL,
  `rol` enum('Estudiante','Docente') NOT NULL,
  `tipoUser` int(10) NOT NULL,
  `fecha` date NOT NULL DEFAULT current_timestamp(),
  `idDocente` int(11) DEFAULT NULL,
  `idTesis` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tesis`
--

CREATE TABLE `tesis` (
  `numTesis` int(11) NOT NULL,
  `idE` int(11) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(2000) NOT NULL,
  `url` varchar(1000) NOT NULL,
  `asesor` varchar(100) NOT NULL,
  `idDocente` int(11) DEFAULT NULL,
  `calificacion` varchar(11) NOT NULL,
  `comentarios` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idEstudiante` (`idEstudiante`),
  ADD KEY `idTesis` (`idTesis`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idDocente` (`idDocente`),
  ADD KEY `idTesis` (`idTesis`);

--
-- Indices de la tabla `tesis`
--
ALTER TABLE `tesis`
  ADD PRIMARY KEY (`numTesis`),
  ADD KEY `idE` (`idE`),
  ADD KEY `idDocente` (`idDocente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `docentes`
--
ALTER TABLE `docentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21454764;

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10357;

--
-- AUTO_INCREMENT de la tabla `tesis`
--
ALTER TABLE `tesis`
  MODIFY `numTesis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
