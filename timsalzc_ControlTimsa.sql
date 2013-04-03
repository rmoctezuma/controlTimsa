-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 03-04-2013 a las 12:49:48
-- Versión del servidor: 5.5.30-cll
-- Versión de PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `timsalzc_ControlTimsa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Agencia`
--

CREATE DATABASE CONTROL_TIMSA;
USE CONTROL_TIMSA;

CREATE TABLE IF NOT EXISTS `Agencia` (
  `idAgente` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) DEFAULT NULL,
  `fecha_ingreso` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `statusA` enum('Activo','Deprecated') NOT NULL DEFAULT 'Activo',
  `fecha_deprecated` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idAgente`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `Agencia`
--

INSERT INTO `Agencia` (`idAgente`, `Nombre`, `fecha_ingreso`, `statusA`, `fecha_deprecated`) VALUES
(3, 'MAERSK', '2013-01-28 22:01:51', 'Activo', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Cliente`
--

CREATE TABLE IF NOT EXISTS `Cliente` (
  `idCliente` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) NOT NULL,
  `fecha_ingreso` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `statusA` enum('Activo','Deprecated') NOT NULL DEFAULT 'Activo',
  `fecha_deprecated` timestamp NULL DEFAULT NULL,
  `rutaImagen` varchar(105) NOT NULL DEFAULT '../img/descarga.jpg',
  PRIMARY KEY (`idCliente`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `Cliente`
--

INSERT INTO `Cliente` (`idCliente`, `Nombre`, `fecha_ingreso`, `statusA`, `fecha_deprecated`, `rutaImagen`) VALUES
(11, 'Galatasaray', '2013-04-03 15:40:56', 'Activo', NULL, '../img/descarga.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ClienteDireccion`
--

CREATE TABLE IF NOT EXISTS `ClienteDireccion` (
  `Sucursal` int(11) NOT NULL AUTO_INCREMENT,
  `NombreSucursal` varchar(50) NOT NULL,
  `Calle` varchar(45) DEFAULT NULL,
  `Numero` int(11) DEFAULT NULL,
  `Colonia` varchar(45) DEFAULT NULL,
  `Localidad` varchar(45) DEFAULT NULL,
  `Ciudad` varchar(45) DEFAULT NULL,
  `Estado` varchar(45) DEFAULT NULL,
  `Telefono` varchar(45) DEFAULT NULL,
  `Cliente_idCliente` int(11) NOT NULL,
  `Cuota_idCuota` int(11) NOT NULL,
  `StatusA` enum('Activo','Deprecated') NOT NULL DEFAULT 'Activo',
  `fecha_ingreso` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_deprecated` timestamp NULL DEFAULT NULL,
  `Lat` double NOT NULL,
  `Lon` double NOT NULL,
  PRIMARY KEY (`Sucursal`),
  KEY `clienteDireccionKeyCliente` (`Cliente_idCliente`),
  KEY `clienteDireccionKeyCuota` (`Cuota_idCuota`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Volcado de datos para la tabla `ClienteDireccion`
--

INSERT INTO `ClienteDireccion` (`Sucursal`, `NombreSucursal`, `Calle`, `Numero`, `Colonia`, `Localidad`, `Ciudad`, `Estado`, `Telefono`, `Cliente_idCliente`, `Cuota_idCuota`, `StatusA`, `fecha_ingreso`, `fecha_deprecated`, `Lat`, `Lon`) VALUES
(22, 'hj', NULL, NULL, NULL, NULL, NULL, NULL, 'hjk', 11, 12, 'Activo', '2013-04-03 17:02:30', NULL, 25.20494115356912, -100.1953125),
(23, 'ghjh', NULL, NULL, NULL, NULL, NULL, NULL, 'ghgh', 11, 12, 'Activo', '2013-04-03 17:02:57', NULL, 28.459033019728043, -106.0400390625),
(24, 'ghgh', NULL, NULL, NULL, NULL, NULL, NULL, 'ghjghj', 11, 12, 'Activo', '2013-04-03 17:03:31', NULL, 18.729501999072138, -98.173828125),
(25, 'ghjhj', NULL, NULL, NULL, NULL, NULL, NULL, 'ghjhgj', 11, 12, 'Activo', '2013-04-03 17:03:48', NULL, 20.92039691397189, -89.4287109375),
(26, 'xdf', NULL, NULL, NULL, NULL, NULL, NULL, 'ff', 11, 12, 'Activo', '2013-04-03 17:06:10', NULL, 29.036960648558267, -109.775390625),
(27, 'dfsdfsdf', NULL, NULL, NULL, NULL, NULL, NULL, 'dsffsd', 11, 12, 'Activo', '2013-04-03 17:06:44', NULL, 20.427012814257385, -100.37109375),
(28, 'dssd', NULL, NULL, NULL, NULL, NULL, NULL, 'sdsd', 11, 12, 'Activo', '2013-04-03 17:07:09', NULL, 22.14670778001263, -97.84423828125),
(29, 'h', NULL, NULL, NULL, NULL, NULL, NULL, 'h', 11, 12, 'Activo', '2013-04-03 17:09:38', NULL, 26.43122806450644, -80.15625),
(30, 'hgy', NULL, NULL, NULL, NULL, NULL, NULL, 'hggh', 11, 12, 'Activo', '2013-04-03 17:14:15', NULL, 26.78484736105119, -105.46875),
(31, 'jhkhjhj', NULL, NULL, NULL, NULL, NULL, NULL, 'jhkhj', 11, 12, 'Activo', '2013-04-03 17:14:32', NULL, 24.046463999666567, -104.644775390625),
(32, 'ghgh', NULL, NULL, NULL, NULL, NULL, NULL, 'gfhgf', 11, 12, 'Activo', '2013-04-03 17:14:49', NULL, 22.004174972902003, -100.96435546875),
(33, 'hgh', NULL, NULL, NULL, NULL, NULL, NULL, 'ghjhg', 11, 12, 'Activo', '2013-04-03 17:15:06', NULL, 20.385825381874263, -103.271484375),
(34, 'ghj', NULL, NULL, NULL, NULL, NULL, NULL, 'hgjh', 11, 12, 'Activo', '2013-04-03 17:15:21', NULL, 16.25686733062344, -92.373046875),
(35, 'ghgf', NULL, NULL, NULL, NULL, NULL, NULL, 'fghfg', 11, 12, 'Activo', '2013-04-03 17:17:27', NULL, 26.194876675795218, -112.2802734375),
(36, 'fgfg', NULL, NULL, NULL, NULL, NULL, NULL, 'fgg', 11, 12, 'Activo', '2013-04-03 17:18:47', NULL, 25.601902261115725, -97.55859375),
(37, 'fgfgfg', NULL, NULL, NULL, NULL, NULL, NULL, 'ddffg', 11, 12, 'Activo', '2013-04-03 17:19:01', NULL, 29.53522956294847, -95.2734375),
(38, 'fgghg', NULL, NULL, NULL, NULL, NULL, NULL, 'fggfgh', 11, 12, 'Activo', '2013-04-03 17:19:24', NULL, 32.58384932565662, -96.7236328125),
(39, 'thg', NULL, NULL, NULL, NULL, NULL, NULL, 'fggf', 11, 12, 'Activo', '2013-04-03 17:20:07', NULL, 38.8225909761771, -85.341796875),
(40, 'b', NULL, NULL, NULL, NULL, NULL, NULL, 'vcbv', 11, 12, 'Activo', '2013-04-03 17:22:18', NULL, 31.95216223802497, -110.654296875),
(41, 'asddsa', NULL, NULL, NULL, NULL, NULL, NULL, 'asasd', 11, 12, 'Activo', '2013-04-03 17:24:15', NULL, 33.76088200086917, -84.19921875),
(42, 'dfdf', NULL, NULL, NULL, NULL, NULL, NULL, 'dgddf', 11, 12, 'Activo', '2013-04-03 17:30:48', NULL, 7.885147283424331, -81.474609375),
(43, 'hnh', NULL, NULL, NULL, NULL, NULL, NULL, 'hjgh', 11, 12, 'Activo', '2013-04-03 17:41:25', NULL, 38.856820134743636, -94.4384765625),
(44, 'ggf', NULL, NULL, NULL, NULL, NULL, NULL, 'fggf', 11, 12, 'Activo', '2013-04-03 17:42:35', NULL, 43.96119063892024, -120.9375),
(45, 'gffg', NULL, NULL, NULL, NULL, NULL, NULL, 'fghg', 11, 12, 'Activo', '2013-04-03 17:42:59', NULL, 39.605688178320804, -105.0732421875),
(46, 'gg', NULL, NULL, NULL, NULL, NULL, NULL, 'dgdg', 11, 12, 'Activo', '2013-04-03 17:43:48', NULL, 38.8225909761771, -111.357421875),
(47, 'dgdg', NULL, NULL, NULL, NULL, NULL, NULL, 'dfgdfg', 11, 12, 'Activo', '2013-04-03 17:44:02', NULL, 44.024421519659334, -99.4482421875),
(48, 'gvbc', NULL, NULL, NULL, NULL, NULL, NULL, 'cvbvcb', 11, 12, 'Activo', '2013-04-03 17:44:45', NULL, 40.17887331434696, -74.091796875);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Contenedor`
--

CREATE TABLE IF NOT EXISTS `Contenedor` (
  `idContenedor` varchar(25) NOT NULL,
  `Tipo` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idContenedor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Contenedor`
--

INSERT INTO `Contenedor` (`idContenedor`, `Tipo`) VALUES
('', ' 20DC ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ContenedorSellos`
--

CREATE TABLE IF NOT EXISTS `ContenedorSellos` (
  `Sello` varchar(45) NOT NULL,
  `NumeroSello` char(5) NOT NULL,
  `fecha_sellado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `NumFlete` int(11) NOT NULL,
  `Contenedor` varchar(15) NOT NULL,
  KEY `fk_ContenedorSellos_Contenedor_Viaje1_idx` (`NumFlete`,`Contenedor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ContenedorSellos`
--

INSERT INTO `ContenedorSellos` (`Sello`, `NumeroSello`, `fecha_sellado`, `NumFlete`, `Contenedor`) VALUES
('fghgg', '1', '2013-04-02 20:07:48', 120, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Contenedor_Viaje`
--

CREATE TABLE IF NOT EXISTS `Contenedor_Viaje` (
  `WorkOrder` varchar(45) DEFAULT NULL,
  `Booking` varchar(45) DEFAULT NULL,
  `Flete_idFlete` int(11) NOT NULL,
  `Contenedor` varchar(15) NOT NULL,
  PRIMARY KEY (`Flete_idFlete`,`Contenedor`),
  KEY `fk_Contenedor_Viaje_Contenedor1_idx` (`Contenedor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Contenedor_Viaje`
--

INSERT INTO `Contenedor_Viaje` (`WorkOrder`, `Booking`, `Flete_idFlete`, `Contenedor`) VALUES
('gfh', 'fghgh', 120, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Cuota`
--

CREATE TABLE IF NOT EXISTS `Cuota` (
  `idCuota` int(11) NOT NULL AUTO_INCREMENT,
  `Lugar` varchar(45) NOT NULL,
  PRIMARY KEY (`idCuota`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `Cuota`
--

INSERT INTO `Cuota` (`idCuota`, `Lugar`) VALUES
(12, 'Mexico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CuotaDetalle`
--

CREATE TABLE IF NOT EXISTS `CuotaDetalle` (
  `numero` int(11) NOT NULL AUTO_INCREMENT,
  `Cuota_idCuota` int(11) NOT NULL,
  `Trafico` enum('Importacion','Exportacion','Reutilizado') NOT NULL,
  `TipoViaje` enum('Sencillo','Full') NOT NULL,
  `Tarifa` double NOT NULL,
  `statusA` enum('Activo','Deprecated') NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`numero`,`Cuota_idCuota`),
  KEY `fk_CuotaDetalle_Cuota1_idx` (`Cuota_idCuota`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Volcado de datos para la tabla `CuotaDetalle`
--

INSERT INTO `CuotaDetalle` (`numero`, `Cuota_idCuota`, `Trafico`, `TipoViaje`, `Tarifa`, `statusA`) VALUES
(43, 12, 'Reutilizado', 'Sencillo', 500, 'Activo'),
(44, 12, 'Reutilizado', 'Full', 400, 'Activo'),
(45, 12, 'Importacion', 'Sencillo', 800, 'Activo'),
(46, 12, 'Importacion', 'Full', 4660, 'Activo'),
(47, 12, 'Exportacion', 'Sencillo', 5154, 'Activo'),
(48, 12, 'Exportacion', 'Full', 551, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Cuota_Flete`
--

CREATE TABLE IF NOT EXISTS `Cuota_Flete` (
  `NumFlete` int(11) NOT NULL,
  `TipoCuota` int(11) NOT NULL,
  `Cuota` int(11) NOT NULL,
  `Sucursal` int(11) NOT NULL,
  KEY `fk_Cuota_Flete_CuotaDetalle1_idx` (`TipoCuota`,`Cuota`),
  KEY `fk_Cuota_Flete_Flete1_idx` (`NumFlete`),
  KEY `fk_Cuota_Flete_Sucursal` (`Sucursal`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Economico`
--

CREATE TABLE IF NOT EXISTS `Economico` (
  `Economico` int(11) NOT NULL AUTO_INCREMENT,
  `Placas` varchar(45) NOT NULL,
  `statusA` enum('Libre','Ocupado','Indispuesto','Deprecated') NOT NULL DEFAULT 'Libre',
  `fecha_ingreso` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_deprecated` timestamp NULL DEFAULT NULL,
  `NumeroSerie` varchar(20) NOT NULL,
  `Modelo` varchar(5) NOT NULL,
  `marca` int(29) NOT NULL,
  `tipoVehiculo` int(11) NOT NULL,
  `Transponder` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`Economico`),
  UNIQUE KEY `indicePlacas` (`Placas`),
  KEY `marca` (`marca`),
  KEY `tipoVehiculo` (`tipoVehiculo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=64647 ;

--
-- Volcado de datos para la tabla `Economico`
--

INSERT INTO `Economico` (`Economico`, `Placas`, `statusA`, `fecha_ingreso`, `fecha_deprecated`, `NumeroSerie`, `Modelo`, `marca`, `tipoVehiculo`, `Transponder`) VALUES
(113, 'Gdgdgdgdg', 'Ocupado', '2013-04-02 19:52:20', NULL, 'Gráfico', '2012', 1, 2, '545'),
(1000, 'jklkjlkj', 'Libre', '2013-04-02 19:59:15', NULL, 'hjkjk', '1996', 1, 2, '4554546'),
(45546, 'jkljklklj', 'Libre', '2013-04-02 19:57:47', NULL, 'kjljkkjl', '2011', 1, 2, 'klklj');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Flete`
--

CREATE TABLE IF NOT EXISTS `Flete` (
  `idFlete` int(11) NOT NULL AUTO_INCREMENT,
  `Agencia_idAgente` int(11) NOT NULL,
  `Fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `statusA` enum('Activo','Pendiente Facturacion','Completo','Detenido','Deprecated','Cancelado','Programado') NOT NULL DEFAULT 'Activo',
  `comentarios` text,
  `Operador` int(11) NOT NULL,
  `Economico` int(11) NOT NULL,
  `Socio` int(11) NOT NULL,
  `fecha_llegada` timestamp NULL DEFAULT NULL,
  `fecha_facturacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idFlete`),
  KEY `fk_Flete_Agencia1` (`Agencia_idAgente`),
  KEY `fk_Flete_VehiculoDetalle1_idx` (`Operador`,`Economico`,`Socio`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=124 ;

--
-- Volcado de datos para la tabla `Flete`
--

INSERT INTO `Flete` (`idFlete`, `Agencia_idAgente`, `Fecha`, `statusA`, `comentarios`, `Operador`, `Economico`, `Socio`, `fecha_llegada`, `fecha_facturacion`) VALUES
(120, 3, '2013-04-02 20:07:48', 'Activo', 'ghkjh', 12, 113, 31, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `GPS_Detalle`
--

CREATE TABLE IF NOT EXISTS `GPS_Detalle` (
  `fecha_inicio` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_deprecated` timestamp NULL DEFAULT NULL,
  `NumeroGPS` varchar(45) NOT NULL DEFAULT 'Sin GPS',
  `Economico` int(11) NOT NULL,
  KEY `fk_GPS_Detalle_Vehiculo1_idx` (`Economico`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Licencia_detalle`
--

CREATE TABLE IF NOT EXISTS `Licencia_detalle` (
  `Operador_Eco` int(11) NOT NULL,
  `Licencia` varchar(45) NOT NULL DEFAULT 'Sin Licencia',
  `FechaInicioVigencia` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `FechaTerminoVigencia` timestamp NULL DEFAULT NULL,
  KEY `fk_Licencia_detalle_Operador1_idx` (`Operador_Eco`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Marca`
--

CREATE TABLE IF NOT EXISTS `Marca` (
  `idMarca` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idMarca`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `Marca`
--

INSERT INTO `Marca` (`idMarca`, `Nombre`) VALUES
(1, 'Freigtliner'),
(2, 'International'),
(3, 'Kenwo RT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Operador`
--

CREATE TABLE IF NOT EXISTS `Operador` (
  `Eco` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) NOT NULL,
  `ApellidoP` varchar(45) NOT NULL,
  `ApellidoM` varchar(45) DEFAULT NULL,
  `R.C.` varchar(45) DEFAULT NULL,
  `CURP` varchar(50) NOT NULL,
  `fecha_ingreso` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `statusA` enum('Libre','Ocupado','Indispuesto','Deprecated') NOT NULL DEFAULT 'Libre',
  `fecha_deprecated` date DEFAULT NULL,
  `Telefono` varchar(45) DEFAULT NULL,
  `rutaImagen` varchar(105) NOT NULL DEFAULT '"../img/descarga.jpg"',
  PRIMARY KEY (`Eco`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `Operador`
--

INSERT INTO `Operador` (`Eco`, `Nombre`, `ApellidoP`, `ApellidoM`, `R.C.`, `CURP`, `fecha_ingreso`, `statusA`, `fecha_deprecated`, `Telefono`, `rutaImagen`) VALUES
(12, 'Salvador', 'Sánchez', 'Gdgdg5353', NULL, 'Hfgcvcv', '2013-04-02 19:51:13', 'Ocupado', NULL, '54545', '../img/descarga.jpg'),
(13, 'Fdfdfdfd', 'DVD', 'Chava', NULL, 'Bcbcbcb', '2013-04-02 19:53:52', 'Libre', NULL, 'Bfbcbc', '../img/descarga.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Socio`
--

CREATE TABLE IF NOT EXISTS `Socio` (
  `idSocio` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) NOT NULL,
  `Telefono` varchar(45) DEFAULT NULL,
  `statusA` enum('Activo','Deprecated') NOT NULL DEFAULT 'Activo',
  `fecha_ingreso` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_deprecated` timestamp NULL DEFAULT NULL,
  `rutaImagen` varchar(80) NOT NULL DEFAULT '../img/descarga.jpg',
  PRIMARY KEY (`idSocio`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Volcado de datos para la tabla `Socio`
--

INSERT INTO `Socio` (`idSocio`, `Nombre`, `Telefono`, `statusA`, `fecha_ingreso`, `fecha_deprecated`, `rutaImagen`) VALUES
(31, 'Roberto  Medina  Hecho', '54656', 'Activo', '2013-04-02 19:50:12', NULL, '../img/descarga.jpg'),
(32, 'iikjlkj jklkjl  kjllkjlk', '4545', 'Activo', '2013-04-02 19:57:23', NULL, '../img/descarga.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TipoVehiculo`
--

CREATE TABLE IF NOT EXISTS `TipoVehiculo` (
  `idTipoVehiculo` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idTipoVehiculo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `TipoVehiculo`
--

INSERT INTO `TipoVehiculo` (`idTipoVehiculo`, `Nombre`) VALUES
(2, 'Tractocamion');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `VehiculoDetalle`
--

CREATE TABLE IF NOT EXISTS `VehiculoDetalle` (
  `Operador` int(11) NOT NULL,
  `Economico` int(11) NOT NULL,
  `Socio` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `statusA` enum('Activo','Deprecated') NOT NULL DEFAULT 'Activo',
  `fecha_salida` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Operador`,`Economico`,`Socio`),
  KEY `fk_VehiculoDetalle_Vehiculo1_idx` (`Economico`),
  KEY `fk_VehiculoDetalle_Socio1_idx` (`Socio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `VehiculoDetalle`
--

INSERT INTO `VehiculoDetalle` (`Operador`, `Economico`, `Socio`, `fecha`, `statusA`, `fecha_salida`) VALUES
(12, 113, 31, '2013-04-02 19:52:20', 'Activo', NULL),
(12, 1000, 31, '2013-04-02 20:31:45', 'Activo', NULL),
(12, 45546, 32, '2013-04-02 19:57:47', 'Activo', NULL),
(13, 113, 31, '2013-04-02 19:54:18', 'Activo', NULL),
(13, 1000, 31, '2013-04-02 19:59:15', 'Activo', NULL);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ClienteDireccion`
--

ALTER TABLE `ClienteDireccion`
  ADD CONSTRAINT `clienteDireccionKeyCliente` FOREIGN KEY (`Cliente_idCliente`) REFERENCES `Cliente` (`idCliente`),
  ADD CONSTRAINT `clienteDireccionKeyCuota` FOREIGN KEY (`Cuota_idCuota`) REFERENCES `Cuota` (`idCuota`);

--
-- Filtros para la tabla `ContenedorSellos`
--

ALTER TABLE `ContenedorSellos`
  ADD CONSTRAINT `fk_ContenedorSellos_Contenedor_Viaje1` FOREIGN KEY (`NumFlete`, `Contenedor`) REFERENCES `Contenedor_Viaje` (`Flete_idFlete`, `Contenedor`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `Contenedor_Viaje`
--

ALTER TABLE `Contenedor_Viaje`
  ADD CONSTRAINT `fk_Contenedor_Viaje_Contenedor1` FOREIGN KEY (`Contenedor`) REFERENCES `Contenedor` (`idContenedor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Contenedor_Viaje_Flete1` FOREIGN KEY (`Flete_idFlete`) REFERENCES `Flete` (`idFlete`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `CuotaDetalle`
--

ALTER TABLE `CuotaDetalle`
  ADD CONSTRAINT `fk_CuotaDetalle_Cuota1` FOREIGN KEY (`Cuota_idCuota`) REFERENCES `Cuota` (`idCuota`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `Cuota_Flete`
--

ALTER TABLE `Cuota_Flete`
  ADD CONSTRAINT `fk_Cuota_Flete_CuotaDetalle1` FOREIGN KEY (`TipoCuota`, `Cuota`) REFERENCES `CuotaDetalle` (`numero`, `Cuota_idCuota`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Cuota_Flete_Flete1` FOREIGN KEY (`NumFlete`) REFERENCES `Flete` (`idFlete`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Cuota_Flete_Sucursal` FOREIGN KEY (`Sucursal`) REFERENCES `ClienteDireccion` (`Sucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `Economico`
--

ALTER TABLE `Economico`
  ADD CONSTRAINT `Economico_ibfk_1` FOREIGN KEY (`marca`) REFERENCES `Marca` (`idMarca`),
  ADD CONSTRAINT `Economico_ibfk_2` FOREIGN KEY (`tipoVehiculo`) REFERENCES `TipoVehiculo` (`idTipoVehiculo`);

--
-- Filtros para la tabla `Flete`
--

ALTER TABLE `Flete`
  ADD CONSTRAINT `fk_Flete_Agencia1` FOREIGN KEY (`Agencia_idAgente`) REFERENCES `Agencia` (`idAgente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Flete_VehiculoDetalle1` FOREIGN KEY (`Operador`, `Economico`, `Socio`) REFERENCES `VehiculoDetalle` (`Operador`, `Economico`, `Socio`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `GPS_Detalle`
--

ALTER TABLE `GPS_Detalle`
  ADD CONSTRAINT `fk_GPS_Detalle_Vehiculo1` FOREIGN KEY (`Economico`) REFERENCES `Economico` (`Economico`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `Licencia_detalle`
--

ALTER TABLE `Licencia_detalle`
  ADD CONSTRAINT `fk_Licencia_detalle_Operador1` FOREIGN KEY (`Operador_Eco`) REFERENCES `Operador` (`Eco`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `VehiculoDetalle`
--

ALTER TABLE `VehiculoDetalle`
  ADD CONSTRAINT `fk_VehiculoDetalle_Operador` FOREIGN KEY (`Operador`) REFERENCES `Operador` (`Eco`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_VehiculoDetalle_Socio1` FOREIGN KEY (`Socio`) REFERENCES `Socio` (`idSocio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_VehiculoDetalle_Vehiculo1` FOREIGN KEY (`Economico`) REFERENCES `Economico` (`Economico`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
