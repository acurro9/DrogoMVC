-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-11-2023 a las 00:20:56
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4
drop database if exists drogoDB;
create database drogoDB;
use drogoDB;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `drogodb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bloqueado`
--

CREATE TABLE `bloqueado` (
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bloqueado`
--

INSERT INTO `bloqueado` (`username`, `email`, `id`) VALUES
('Amin', 'amin@gmail.com', '5263e1ca9ee19731fa47f23846410f44'),
('Ivan', 'ivan@gmail.com', '6886f02315466ee4a74a401be38774dc');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `refCompra` char(32) NOT NULL,
  `hash_comprador` char(32) DEFAULT NULL,
  `hash_vendedor` char(32) DEFAULT NULL,
  `fechaCompra` date DEFAULT NULL,
  `importe` decimal(10,2) DEFAULT NULL,
  `cargoTransporte` decimal(10,2) DEFAULT NULL,
  `cargosAdicionales` decimal(10,2) DEFAULT NULL,
  `fechaDeposito` date DEFAULT NULL,
  `fechaRecogida` date DEFAULT NULL,
  `refLocker` char(32) DEFAULT NULL,
  `distribuidor` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`refCompra`, `hash_comprador`, `hash_vendedor`, `fechaCompra`, `importe`, `cargoTransporte`, `cargosAdicionales`, `fechaDeposito`, `fechaRecogida`, `refLocker`, `distribuidor`) VALUES
('24149c5699cb0022c8961f7546ac72b1', '019ab87a4bfd785acb9758c3ea34aa53', 'a4ccf4be80e92a24f3a3cad35f09a516', '2023-11-16', 99.00, 10.00, 5.00, '2023-11-27', '2023-11-30', '2', 0),
('35e7913c0f699d58ee9b933efdbd50fc', '26706ab0ea93fa3f8d139c32e6174809', 'a4ccf4be80e92a24f3a3cad35f09a516', '2023-11-16', 2500.00, 100.00, 10.00, '2023-11-21', '2023-11-25', '1', 0),
('53a9e8b21083ead172193c497952f9f7', '26706ab0ea93fa3f8d139c32e6174809', 'a7ceb0de1bce60956191c8d72015665d', '2023-11-16', 230.00, 15.00, 10.00, '2023-11-17', '2023-11-19', '3', 1),
('752948ccc71bb8222cba3ec2b682b258', '019ab87a4bfd785acb9758c3ea34aa53', 'a4ccf4be80e92a24f3a3cad35f09a516', '2023-11-16', 1000.00, 50.00, 20.00, '2023-11-19', '2023-11-20', '1', 1),
('9c58f1cf54517e5ddde4e46bf5095041', '019ab87a4bfd785acb9758c3ea34aa53', 'a7ceb0de1bce60956191c8d72015665d', '2023-11-16', 550.00, 25.00, 10.00, '2023-11-21', '2023-11-27', '2', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprador`
--

CREATE TABLE `comprador` (
  `hash_comprador` char(32) NOT NULL,
  `hash_carteraComprador` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comprador`
--

INSERT INTO `comprador` (`hash_comprador`, `hash_carteraComprador`) VALUES
('019ab87a4bfd785acb9758c3ea34aa53', '$2y$10$YXEDVFY98gAsreDPzz6NBugx52H7WF2XGte2C2RB2s0hYlobHldWG'),
('26706ab0ea93fa3f8d139c32e6174809', '$2y$10$7lZjevqZMWPq9YUI9VUtsu/ReGpKQAVjQ/5H.FhpChoelsoO5Nbe6'),
('6886f02315466ee4a74a401be38774dc', '$2y$10$BYaDs/phgaJZb4N3MgzJlOSK.bYR0NN03VBkCot1lQutYaQETtRKC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto`
--

CREATE TABLE `contacto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefono` int(9) NOT NULL,
  `mensaje` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contacto`
--

INSERT INTO `contacto` (`id`, `nombre`, `email`, `telefono`, `mensaje`) VALUES
(2, 'Luis', 'luis@gmail.com', 654398977, 'Hola, tengo que realizar un envio nacional a la península y me gustaría conocer los precios que manejais'),
(3, 'Julian Alvarez ', 'juli@gmail.com', 677433126, 'Me gustaría saber las tarifas que teneis para envios internacionales'),
(4, 'Manuel Hernesto', 'manuH@gmail.com', 699088767, 'Hola, soy un Youtuber que hace un podcast y me gustaría traer a los tres fundadores de Drogo al Podcast'),
(5, 'Paula Forlan', 'forli44@gmail.com', 689763454, 'Hola, soy una repartidora con más de 10 años de experiencia y queria dejar mi curriculum para futuras contrataciones. Espero su respuesta, un saludo y gracias.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distribuidor`
--

CREATE TABLE `distribuidor` (
  `hash_distribuidor` char(32) NOT NULL,
  `hash_carteraDistribuidor` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `distribuidor`
--

INSERT INTO `distribuidor` (`hash_distribuidor`, `hash_carteraDistribuidor`) VALUES
('0b8fb0e363169a7e789cc1416cbcf65d', '$2y$10$5eCEo.M9wcgWRusW3Kq9me8uPURaR3CkgObbo2hYdkFAHNhOBWN7i'),
('9c7d16390a52ef1f1bc15c604c8799df', '$2y$10$XdRrtsrJIhk8eIBl3d2u2u3vZcVd3vxtAFYmHAQXOOY6kiu7LzsBy');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrega`
--

CREATE TABLE `entrega` (
  `id` int(11) NOT NULL,
  `hash_distribuidor` varchar(32) DEFAULT NULL,
  `refCompra` varchar(32) DEFAULT NULL,
  `fechaRecogida` date DEFAULT NULL,
  `fechaDeposito` date DEFAULT NULL,
  `lockerOrigen` varchar(32) DEFAULT NULL,
  `lockerDeposito` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `entrega`
--

INSERT INTO `entrega` (`id`, `hash_distribuidor`, `refCompra`, `fechaRecogida`, `fechaDeposito`, `lockerOrigen`, `lockerDeposito`) VALUES
(6, NULL, '752948ccc71bb8222cba3ec2b682b258', NULL, NULL, NULL, NULL),
(7, '0b8fb0e363169a7e789cc1416cbcf65d', '9c58f1cf54517e5ddde4e46bf5095041', '2023-11-17', '2023-11-18', '2', '1'),
(8, NULL, '6bbac43c4d1537fbf9417c2ce34d1d58', NULL, NULL, NULL, NULL),
(9, '9c7d16390a52ef1f1bc15c604c8799df', '53a9e8b21083ead172193c497952f9f7', '2023-11-19', '2023-11-25', '2', '3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `locker`
--

CREATE TABLE `locker` (
  `refLocker` char(32) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `passwordLocker` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `locker`
--

INSERT INTO `locker` (`refLocker`, `direccion`, `passwordLocker`) VALUES
('1', 'Calle los Guaniles 39, Santa Lucia de Tirajana', '1234'),
('2', 'Calle Manuel de fallo 33, Las Palmas de GC', '1234'),
('3', 'Calle Alonso Quejada 34, Madrid', '123456');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `newsletter`
--

CREATE TABLE `newsletter` (
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `newsletter`
--

INSERT INTO `newsletter` (`email`) VALUES
('acurrosolla@gmail.com'),
('angel29@gmail.com'),
('eliazaralonsosantana@gmail.com'),
('ismaapa05@gmail.com'),
('mariaTenorio@gmail.com'),
('nacho9@hotmail.es');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` char(32) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `tipo` enum('Comprador','Vendedor','Distribuidor','Administrador') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `username`, `email`, `password_hash`, `tipo`) VALUES
('0', 'admin', 'admin@gmail.com', '$2y$10$ECdV0o2aQh7oubU2Z1kPb.glG0GshHrdfEhucoBmp/WRRm2d6RzVS', 'Administrador'),
('019ab87a4bfd785acb9758c3ea34aa53', 'Aaron', 'aaron@gmail.com', '$2y$10$iz5dkTjq.hW2atuCg6XTwOXPWVpJfHohZ7S/Kw6EfZwo216MgHhJe', 'Comprador'),
('0b8fb0e363169a7e789cc1416cbcf65d', 'Ismael', 'isma@gmail.com', '$2y$10$NIAWRD3sRd8uYN.qFgp.x.xu9HgGK.nvV6SI01gt15UvBHn2jKdkK', 'Distribuidor'),
('26706ab0ea93fa3f8d139c32e6174809', 'Javier', 'javi@gmail.com', '$2y$10$UI7Begi0LBVoD.v.XvUr6uYVOttHTxGRyFCRdRnodBLXHuIsQmTou', 'Comprador'),
('5263e1ca9ee19731fa47f23846410f44', 'Amin', 'amin@gmail.com', '$2y$10$KRvSQPKAV8vG/5zTjece/OREA5Gumsht95xaKq4erKohBNXGEQ2zS', 'Vendedor'),
('6886f02315466ee4a74a401be38774dc', 'Ivan', 'ivan@gmail.com', '$2y$10$1NU7l21E7p8x.5J/ffiKm.Ov/muYXTeIs7P0B0rvi8Tii/RIBUq2O', 'Comprador'),
('9c7d16390a52ef1f1bc15c604c8799df', 'Cristina', 'cristina@gmail.com', '$2y$10$PSMVnbkqSyF8jFsDyMfMmOS0shJEcrQa28C7n.RLgpo2URcwo18Gy', 'Distribuidor'),
('a4ccf4be80e92a24f3a3cad35f09a516', 'Eliazar', 'eliazar@gmail.com', '$2y$10$YmLhq7nKL9T0ITKtbJRzJecTtfcMQDNKKh4A8Hw9H24Dg2smBnaky', 'Vendedor'),
('a7ceb0de1bce60956191c8d72015665d', 'Oscar', 'oscar@gmail.com', '$2y$10$34t3A7aOAjtC/Qx5r8uJDej/fccnzcuX6zc4F8bdJL1IRMbQbqNkK', 'Vendedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vendedor`
--

CREATE TABLE `vendedor` (
  `hash_vendedor` char(32) NOT NULL,
  `hash_carteraVendedor` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vendedor`
--

INSERT INTO `vendedor` (`hash_vendedor`, `hash_carteraVendedor`) VALUES
('5263e1ca9ee19731fa47f23846410f44', '$2y$10$mJGoe8nijNm9MW/zyr0vUu15SilU7DXHHyFaQHe8m0ffXG9fUL56i'),
('a4ccf4be80e92a24f3a3cad35f09a516', '$2y$10$P8JSVZk.Jpx8Elgxwxkv/uOh0pGcenfA1fqFyrJHLuuUn4aaR7udK'),
('a7ceb0de1bce60956191c8d72015665d', '$2y$10$GPgDMOeaC5Vb0ehOIKE6SOhEY.WxyjiR6a2rK4POiIhyJUY5cUphy');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bloqueado`
--
ALTER TABLE `bloqueado`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`refCompra`),
  ADD KEY `hash_comprador` (`hash_comprador`),
  ADD KEY `hash_vendedor` (`hash_vendedor`),
  ADD KEY `refLocker` (`refLocker`);

--
-- Indices de la tabla `comprador`
--
ALTER TABLE `comprador`
  ADD PRIMARY KEY (`hash_comprador`);

--
-- Indices de la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `distribuidor`
--
ALTER TABLE `distribuidor`
  ADD PRIMARY KEY (`hash_distribuidor`);

--
-- Indices de la tabla `entrega`
--
ALTER TABLE `entrega`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `locker`
--
ALTER TABLE `locker`
  ADD PRIMARY KEY (`refLocker`);

--
-- Indices de la tabla `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `vendedor`
--
ALTER TABLE `vendedor`
  ADD PRIMARY KEY (`hash_vendedor`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contacto`
--
ALTER TABLE `contacto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `entrega`
--
ALTER TABLE `entrega`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`hash_comprador`) REFERENCES `comprador` (`hash_comprador`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `compra_ibfk_2` FOREIGN KEY (`hash_vendedor`) REFERENCES `vendedor` (`hash_vendedor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `compra_ibfk_3` FOREIGN KEY (`refLocker`) REFERENCES `locker` (`refLocker`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `comprador`
--
ALTER TABLE `comprador`
  ADD CONSTRAINT `comprador_ibfk_1` FOREIGN KEY (`hash_comprador`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `distribuidor`
--
ALTER TABLE `distribuidor`
  ADD CONSTRAINT `distribuidor_ibfk_1` FOREIGN KEY (`hash_distribuidor`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `vendedor`
--
ALTER TABLE `vendedor`
  ADD CONSTRAINT `vendedor_ibfk_1` FOREIGN KEY (`hash_vendedor`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
