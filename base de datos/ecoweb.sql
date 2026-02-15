-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-02-2026 a las 04:04:54
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ecoweb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `comentario` text DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `respuesta` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id`, `usuario_id`, `nombre`, `correo`, `comentario`, `fecha`, `respuesta`) VALUES
(2, 0, 'Brayan Escalante', 'brayan@gmail.com', 'hola mundo', '2026-02-10 01:48:52', NULL),
(3, 0, ' christian refugio ', 'christian@gmail.com', '.........................................................................', '2026-02-13 01:49:57', NULL),
(4, 0, ' christian refugio ', 'brayan@gmail.com', 'mmmmm', '2026-02-13 03:01:01', NULL),
(5, 0, 'Hector del Toro', 'torito@gmail.com', 'muuuuuuuuuuuu\r\n', '2026-02-13 03:23:09', NULL),
(6, 0, 'Hector del Toro', 'torito@gmail.com', 'muuuuuuuuuuuu\r\n', '2026-02-13 03:25:31', NULL),
(9, 4, NULL, NULL, 'hola a todos', '2026-02-15 02:54:55', 'hola'),
(10, 2, NULL, NULL, 'hola a todos', '2026-02-15 02:57:04', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','usuario') DEFAULT 'usuario',
  `token_recuperacion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `password`, `rol`, `token_recuperacion`) VALUES
(2, 'Administrador', 'admin@eco.com', '$2y$10$7MWD4K3OKpGHgg29Wn5Lv.g869T0YtoR5zgJxViSX41kbT7bcJpIu', 'admin', NULL),
(3, 'Hector del Toro', 'torito@gmail.com', '$2y$10$DdcQysYB8/qIlAZOwU6F/u/Ktuzo6WfnP83hBdSQEEpNHe8zgE7mi', 'usuario', NULL),
(4, 'lucero martinez', 'luz@gmail.com', '$2y$10$PLdkKTX9lD2IevSFqrEzAuzh9YE89ZT4r1rWS9V4.o6ndgtaO3Cau', 'usuario', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
