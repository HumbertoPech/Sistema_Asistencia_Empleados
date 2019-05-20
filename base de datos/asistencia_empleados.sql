-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-05-2019 a las 08:41:21
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `asistencia_empleados`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id` int(11) NOT NULL,
  `contrasena` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`id`, `contrasena`) VALUES
(1, '123456');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `id` int(11) NOT NULL,
  `hora` time NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dias_festivos`
--

CREATE TABLE `dias_festivos` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `dias_festivos`
--

INSERT INTO `dias_festivos` (`id`, `fecha`) VALUES
(1, '2019-03-20'),
(2, '2019-04-04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dias_nomina_semanal`
--

CREATE TABLE `dias_nomina_semanal` (
  `id` int(11) NOT NULL,
  `id_nomina_semanal` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `pago` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL,
  `nombres` varchar(45) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  `usuario` varchar(15) NOT NULL,
  `contrasena` varchar(10) NOT NULL,
  `sueldo_base` double NOT NULL,
  `id_estado` int(11) NOT NULL,
  `direccion` varchar(45) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `sexo` varchar(45) NOT NULL,
  `estado_civil` varchar(45) NOT NULL,
  `curp` varchar(45) NOT NULL,
  `fecha_inicio` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `nombres`, `apellidos`, `usuario`, `contrasena`, `sueldo_base`, `id_estado`, `direccion`, `fecha_nacimiento`, `sexo`, `estado_civil`, `curp`, `fecha_inicio`) VALUES
(1, 'Humberto', 'BEtoque', 'hp1998', '123456', 45.67, 2, 'Calle 54 845 x 129 y 131 San Jose Tecoh', '1998-05-18', 'Hombre', 'Soltero', 'PEHH2334455w454545asd', '2000-04-08'),
(2, 'Ulises Alexander', 'Ancona', 'ua1998', '123456', 45.67, 1, 'Calle 25a x 36 y 38 Chenku', '2019-05-19', 'Masculino', 'Casado', 'AOGU2334455454545', '2019-05-19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado_intentos`
--

CREATE TABLE `empleado_intentos` (
  `id` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `estado` varchar(15) NOT NULL,
  `numero_intentos` int(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empleado_intentos`
--

INSERT INTO `empleado_intentos` (`id`, `id_empleado`, `estado`, `numero_intentos`) VALUES
(1, 1, 'estado', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id`, `nombre`) VALUES
(1, 'activo'),
(2, 'baja');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `id` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `dia` varchar(15) NOT NULL,
  `hora_entrada` time NOT NULL,
  `hora_salida` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `horarios`
--

INSERT INTO `horarios` (`id`, `id_empleado`, `dia`, `hora_entrada`, `hora_salida`) VALUES
(1, 1, 'Lunes', '08:00:00', '16:00:00'),
(2, 1, 'Martes', '08:00:00', '16:00:00'),
(3, 1, 'Miercoles', '08:00:00', '16:00:00'),
(4, 1, 'Jueves', '08:00:00', '16:00:00'),
(5, 1, 'Viernes', '09:00:00', '17:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nomina_semanal`
--

CREATE TABLE `nomina_semanal` (
  `id` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `horas_trabajadas` double NOT NULL,
  `sueldo_total` double NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_termino` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solucion_pendientes`
--

CREATE TABLE `solucion_pendientes` (
  `id` int(11) NOT NULL,
  `id_trabajo_diario` int(11) NOT NULL,
  `dato_original` time NOT NULL,
  `dato_final` time NOT NULL,
  `tipo` char(1) NOT NULL,
  `descripcion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suspension_empleados`
--

CREATE TABLE `suspension_empleados` (
  `id` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_termino` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajo_diario`
--

CREATE TABLE `trabajo_diario` (
  `id` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `en_nomina` varchar(2) NOT NULL,
  `hora_entrada` time DEFAULT NULL,
  `hora_salida` time DEFAULT NULL,
  `fecha` date NOT NULL,
  `horas_trabajadas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacaciones_empleados`
--

CREATE TABLE `vacaciones_empleados` (
  `id` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_termino` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `dias_festivos`
--
ALTER TABLE `dias_festivos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `dias_nomina_semanal`
--
ALTER TABLE `dias_nomina_semanal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nomina_semanal` (`id_nomina_semanal`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_estado` (`id_estado`);

--
-- Indices de la tabla `empleado_intentos`
--
ALTER TABLE `empleado_intentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_empleado` (`id_empleado`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_empleado` (`id_empleado`);

--
-- Indices de la tabla `nomina_semanal`
--
ALTER TABLE `nomina_semanal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_empleado` (`id_empleado`);

--
-- Indices de la tabla `solucion_pendientes`
--
ALTER TABLE `solucion_pendientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_trabajo_diario` (`id_trabajo_diario`);

--
-- Indices de la tabla `suspension_empleados`
--
ALTER TABLE `suspension_empleados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_empleado` (`id_empleado`);

--
-- Indices de la tabla `trabajo_diario`
--
ALTER TABLE `trabajo_diario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_empleado` (`id_empleado`);

--
-- Indices de la tabla `vacaciones_empleados`
--
ALTER TABLE `vacaciones_empleados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_empleado` (`id_empleado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `dias_festivos`
--
ALTER TABLE `dias_festivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `dias_nomina_semanal`
--
ALTER TABLE `dias_nomina_semanal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `empleado_intentos`
--
ALTER TABLE `empleado_intentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `nomina_semanal`
--
ALTER TABLE `nomina_semanal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solucion_pendientes`
--
ALTER TABLE `solucion_pendientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `suspension_empleados`
--
ALTER TABLE `suspension_empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trabajo_diario`
--
ALTER TABLE `trabajo_diario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `vacaciones_empleados`
--
ALTER TABLE `vacaciones_empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `dias_nomina_semanal`
--
ALTER TABLE `dias_nomina_semanal`
  ADD CONSTRAINT `dias_nomina_semanal_ibfk_1` FOREIGN KEY (`id_nomina_semanal`) REFERENCES `nomina_semanal` (`id`);

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id`);

--
-- Filtros para la tabla `empleado_intentos`
--
ALTER TABLE `empleado_intentos`
  ADD CONSTRAINT `empleado_intentos_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id`);

--
-- Filtros para la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD CONSTRAINT `horarios_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id`);

--
-- Filtros para la tabla `nomina_semanal`
--
ALTER TABLE `nomina_semanal`
  ADD CONSTRAINT `nomina_semanal_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id`);

--
-- Filtros para la tabla `solucion_pendientes`
--
ALTER TABLE `solucion_pendientes`
  ADD CONSTRAINT `solucion_pendientes_ibfk_1` FOREIGN KEY (`id_trabajo_diario`) REFERENCES `trabajo_diario` (`id`);

--
-- Filtros para la tabla `suspension_empleados`
--
ALTER TABLE `suspension_empleados`
  ADD CONSTRAINT `suspension_empleados_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id`);

--
-- Filtros para la tabla `trabajo_diario`
--
ALTER TABLE `trabajo_diario`
  ADD CONSTRAINT `trabajo_diario_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id`);

--
-- Filtros para la tabla `vacaciones_empleados`
--
ALTER TABLE `vacaciones_empleados`
  ADD CONSTRAINT `vacaciones_empleados_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
