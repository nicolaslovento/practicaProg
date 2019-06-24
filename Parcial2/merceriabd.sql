-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-06-2019 a las 16:31:46
-- Versión del servidor: 10.1.19-MariaDB
-- Versión de PHP: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `merceriabd`
--
CREATE DATABASE IF NOT EXISTS `merceriabd` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `merceriabd`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medias`
--

CREATE TABLE `medias` (
  `id` int(11) NOT NULL,
  `color` varchar(30) NOT NULL,
  `marca` varchar(30) NOT NULL,
  `precio` double NOT NULL,
  `talle` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `medias`
--

INSERT INTO `medias` (`id`, `color`, `marca`, `precio`, `talle`) VALUES
(5, 'violetaa', 'juancito', 90, 'xl'),
(8, 'verdee', 'adidas', 45, 'm'),
(9, 'azul', 'adidas', 122, 's'),
(10, 'azul', 'adidas', 122, 's'),
(11, 'azul', 'adidas', 122, 's'),
(12, 'azul', 'adidas', 122, 's'),
(13, 'azul', 'adidas', 122, 's'),
(14, 'verdee', 'adidas', 45, 'm'),
(15, 'azul', 'adidas', 122, 's'),
(16, 'azul', 'adidas', 122, 's'),
(17, 'azul', 'adidas', 122, 's'),
(18, 'azul', 'adidas', 122, 's'),
(19, 'azul', 'adidas', 122, 's'),
(20, 'azul', 'adidas', 122, 's'),
(21, 'azul', 'adidas', 122, 's');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `email` varchar(80) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `perfil` varchar(50) NOT NULL,
  `foto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `clave`, `nombre`, `apellido`, `perfil`, `foto`) VALUES
(2, 'nl', '123', 'martin', 'kaka', 'propietario', 'nl.jpg'),
(3, '1', '1', '1', '1', 'encargado', '1.jpg'),
(4, '2', '2', '1', '1', 'encargado', '2.jpg'),
(5, '3', '3', '1', '1', 'encargado', '3.jpg'),
(6, '4', '4', '1', '1', 'encargado', '4.jpg'),
(7, '5', '5', '1', '1', 'encargado', '5.jpg'),
(8, '6', '6', '1', '1', 'encargado', '6.jpg'),
(9, '7', '7', '1', '1', 'propietario', '7.jpg'),
(10, '8', '8', '1', '1', 'propietario', '8.jpg'),
(11, '9', '9', '1', '1', 'propietario', '9.jpg'),
(12, '10', '10', '1', '1', 'empleado', '10.jpg'),
(13, '11', '11', '1', '1', 'empleado', '11.jpg'),
(14, '12', '12', '1', '1', 'empleado', '12.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `medias`
--
ALTER TABLE `medias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `medias`
--
ALTER TABLE `medias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
