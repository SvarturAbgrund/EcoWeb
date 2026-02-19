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

CREATE DATABASE IF NOT EXISTS `ecoweb`;
USE `ecoweb`;

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
(1, 3, 'Juan Usuarios', 'juan@ecoweb.com', 'Excelente página sobre ecosistemas, muy informativa', '2026-02-15 08:30:00', 'Gracias Juan, nos alegra te haya sido útil'),
(2, 4, 'Maria Test', 'maria@ecoweb.com', 'Me encanta el enfoque educativo del proyecto', '2026-02-15 09:15:00', NULL),
(3, 5, 'Carlos Demo', 'carlos@ecoweb.com', 'Muy bueno el contenido sobre conservación ambiental', '2026-02-15 10:45:00', 'Gracias por tu feedback Carlos'),
(4, 6, 'Sofia Prueba', 'sofia@ecoweb.com', 'El diseño es muy limpio y fácil de navegar', '2026-02-15 11:20:00', NULL);

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
(1, 'Administrador Principal', 'admin@ecoweb.com', '$2y$10$K1L9m8N6O5P4Q3R2S1T0UvWxYzA9bC8dE7fG6hI5jK4lM3nO2pQ1', 'admin', NULL),
(2, 'Admin Secundario', 'admin2@ecoweb.com', '$2y$10$A2B3C4D5E6F7G8H9I0J1K2L3M4N5O6P7Q8R9S0T1U2V3W4X5Y6Z7', 'admin', NULL),
(3, 'Juan Usuarios', 'juan@ecoweb.com', '$2y$10$Z8Y7X6W5V4U3T2S1R0Q9P8O7N6M5L4K3J2I1H0G9F8E7D6C5B4A3', 'usuario', NULL),
(4, 'Maria Test', 'maria@ecoweb.com', '$2y$10$A1B2C3D4E5F6G7H8I9J0K1L2M3N4O5P6Q7R8S9T0U1V2W3X4Y5Z6', 'usuario', NULL),
(5, 'Carlos Demo', 'carlos@ecoweb.com', '$2y$10$L9K8J7I6H5G4F3E2D1C0B9A8Z7Y6X5W4V3U2T1S0R9Q8P7O6N5M4', 'usuario', NULL),
(6, 'Sofia Prueba', 'sofia@ecoweb.com', '$2y$10$M1N2O3P4Q5R6S7T8U9V0W1X2Y3Z4A5B6C7D8E9F0G1H2I3J4K5L6', 'usuario', NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
