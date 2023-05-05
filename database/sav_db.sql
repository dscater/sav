-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 05-05-2023 a las 21:57:21
-- Versión del servidor: 8.0.30
-- Versión de PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sav_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anios`
--

CREATE TABLE `anios` (
  `id` bigint UNSIGNED NOT NULL,
  `anio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caracteristica_vehiculos`
--

CREATE TABLE `caracteristica_vehiculos` (
  `id` bigint UNSIGNED NOT NULL,
  `caracteristica` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chats`
--

CREATE TABLE `chats` (
  `id` bigint UNSIGNED NOT NULL,
  `visitante_id` bigint UNSIGNED NOT NULL,
  `emisor_id` bigint UNSIGNED DEFAULT NULL,
  `receptor_id` bigint UNSIGNED DEFAULT NULL,
  `mensaje` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estado` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracions`
--

CREATE TABLE `configuracions` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre_sistema` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `razon_social` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ciudad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fono` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `web` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actividad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `configuracions`
--

INSERT INTO `configuracions` (`id`, `nombre_sistema`, `alias`, `razon_social`, `nit`, `ciudad`, `dir`, `fono`, `web`, `actividad`, `correo`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'SISTEMA DE ASISTENTE VIRTUAL PARA DETERMINAR Y ORIENTAR SOLUCIONES A FALLAS MECÁNICAS DE UN MOTOR', 'SAV', 'EMPRESA NUEVAERA', '10000000000', 'LA PAZ', 'LA PAZ', '222222', '', 'ACTIVIDAD', '', 'logo.png', NULL, '2023-04-24 18:59:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint UNSIGNED NOT NULL,
  `vehiculo_id` bigint UNSIGNED NOT NULL,
  `caracteristica_id` bigint UNSIGNED NOT NULL,
  `pregunta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `respuesta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_accions`
--

CREATE TABLE `historial_accions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `accion` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `datos_original` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `datos_nuevo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `modulo` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `historial_accions`
--

INSERT INTO `historial_accions` (`id`, `user_id`, `accion`, `descripcion`, `datos_original`, `datos_nuevo`, `modulo`, `fecha`, `hora`, `created_at`, `updated_at`) VALUES
(1, 1, 'CREACIÓN', 'EL USUARIO admin REGISTRO UN TIPO DE INGRESO', 'created_at: 2023-04-17 11:04:22<br/>descripcion: <br/>id: 1<br/>nombre: INGRESO TIPO 1<br/>updated_at: 2023-04-17 11:04:22<br/>', NULL, 'TIPO DE INGRESOS', '2023-04-17', '11:04:22', '2023-04-17 15:04:22', '2023-04-17 15:04:22'),
(2, 1, 'MODIFICACIÓN', 'EL USUARIO admin MODIFICÓ UN TIPO DE INGRESO', 'created_at: 2023-04-17 11:04:22<br/>descripcion: <br/>id: 1<br/>nombre: INGRESO TIPO 1<br/>updated_at: 2023-04-17 11:04:22<br/>', 'created_at: 2023-04-17 11:04:22<br/>descripcion: <br/>id: 1<br/>nombre: INGRESO TIPO 1ASD<br/>updated_at: 2023-04-17 11:04:25<br/>', 'TIPO DE INGRESOS', '2023-04-17', '11:04:25', '2023-04-17 15:04:25', '2023-04-17 15:04:25'),
(3, 1, 'MODIFICACIÓN', 'EL USUARIO admin MODIFICÓ UN TIPO DE INGRESO', 'created_at: 2023-04-17 11:04:22<br/>descripcion: <br/>id: 1<br/>nombre: INGRESO TIPO 1ASD<br/>updated_at: 2023-04-17 11:04:25<br/>', 'created_at: 2023-04-17 11:04:22<br/>descripcion: <br/>id: 1<br/>nombre: INGRESO TIPO 1<br/>updated_at: 2023-04-17 11:04:30<br/>', 'TIPO DE INGRESOS', '2023-04-17', '11:04:30', '2023-04-17 15:04:30', '2023-04-17 15:04:30'),
(4, 1, 'MODIFICACIÓN', 'EL USUARIO admin MODIFICÓ LA CONFIGURACIÓN DEL SISTEMA', 'actividad: ACTIVIDAD<br/>alias: SISTEMABI<br/>ciudad: LA PAZ<br/>correo: <br/>created_at: <br/>dir: LA PAZ<br/>fono: 222222<br/>id: 1<br/>logo: logo.png<br/>nit: 10000000000<br/>nombre_sistema: SISTEMA DE INVENTARIO Y VENTAS<br/>razon_social: EMPRESA NUEVAERA<br/>updated_at: 2023-04-15 14:39:44<br/>web: <br/>', 'actividad: ACTIVIDAD<br/>alias: SAV<br/>ciudad: LA PAZ<br/>correo: <br/>created_at: <br/>dir: LA PAZ<br/>fono: 222222<br/>id: 1<br/>logo: logo.png<br/>nit: 10000000000<br/>nombre_sistema: SISTEMA DE INVENTARIO Y VENTAS<br/>razon_social: EMPRESA NUEVAERA<br/>updated_at: 2023-04-24 14:53:48<br/>web: <br/>', 'CONFIGURACIÓN', '2023-04-24', '14:53:48', '2023-04-24 18:53:48', '2023-04-24 18:53:48'),
(5, 1, 'MODIFICACIÓN', 'EL USUARIO admin MODIFICÓ LA CONFIGURACIÓN DEL SISTEMA', 'actividad: ACTIVIDAD<br/>alias: SAV<br/>ciudad: LA PAZ<br/>correo: <br/>created_at: <br/>dir: LA PAZ<br/>fono: 222222<br/>id: 1<br/>logo: logo.png<br/>nit: 10000000000<br/>nombre_sistema: SISTEMA DE INVENTARIO Y VENTAS<br/>razon_social: EMPRESA NUEVAERA<br/>updated_at: 2023-04-24 14:53:48<br/>web: <br/>', 'actividad: ACTIVIDAD<br/>alias: SAV<br/>ciudad: LA PAZ<br/>correo: <br/>created_at: <br/>dir: LA PAZ<br/>fono: 222222<br/>id: 1<br/>logo: logo.png<br/>nit: 10000000000<br/>nombre_sistema: SISTEMA DE ASISTENTE VIRTUAL PARA DETERMINAR Y ORIENTAR SOLUCIONES A FALLAS MECÁNICAS DE UN MOTOR<br/>razon_social: EMPRESA NUEVAERA<br/>updated_at: 2023-04-24 14:59:17<br/>web: <br/>', 'CONFIGURACIÓN', '2023-04-24', '14:59:17', '2023-04-24 18:59:17', '2023-04-24 18:59:17'),
(6, 1, 'MODIFICACIÓN', 'EL USUARIO admin MODIFICÓ LA CONFIGURACIÓN DEL SISTEMA', 'actividad: ACTIVIDAD<br/>alias: SAV<br/>ciudad: LA PAZ<br/>correo: <br/>created_at: <br/>dir: LA PAZ<br/>fono: 222222<br/>id: 1<br/>logo: logo.png<br/>nit: 10000000000<br/>nombre_sistema: SISTEMA DE ASISTENTE VIRTUAL PARA DETERMINAR Y ORIENTAR SOLUCIONES A FALLAS MECÁNICAS DE UN MOTOR<br/>razon_social: EMPRESA NUEVAERA<br/>updated_at: 2023-04-24 14:59:17<br/>web: <br/>', 'actividad: ACTIVIDAD<br/>alias: SAV<br/>ciudad: LA PAZ<br/>correo: <br/>created_at: <br/>dir: LA PAZ<br/>fono: 222222<br/>id: 1<br/>logo: logo.png<br/>nit: 10000000000<br/>nombre_sistema: ASISTENTE VIRTUAL PARA DETERMINAR Y ORIENTAR SOLUCIONES A FALLAS MECÁNICAS DE UN MOTOR<br/>razon_social: EMPRESA NUEVAERA<br/>updated_at: 2023-04-24 14:59:37<br/>web: <br/>', 'CONFIGURACIÓN', '2023-04-24', '14:59:37', '2023-04-24 18:59:37', '2023-04-24 18:59:37'),
(7, 1, 'MODIFICACIÓN', 'EL USUARIO admin MODIFICÓ LA CONFIGURACIÓN DEL SISTEMA', 'actividad: ACTIVIDAD<br/>alias: SAV<br/>ciudad: LA PAZ<br/>correo: <br/>created_at: <br/>dir: LA PAZ<br/>fono: 222222<br/>id: 1<br/>logo: logo.png<br/>nit: 10000000000<br/>nombre_sistema: ASISTENTE VIRTUAL PARA DETERMINAR Y ORIENTAR SOLUCIONES A FALLAS MECÁNICAS DE UN MOTOR<br/>razon_social: EMPRESA NUEVAERA<br/>updated_at: 2023-04-24 14:59:37<br/>web: <br/>', 'actividad: ACTIVIDAD<br/>alias: SAV<br/>ciudad: LA PAZ<br/>correo: <br/>created_at: <br/>dir: LA PAZ<br/>fono: 222222<br/>id: 1<br/>logo: logo.png<br/>nit: 10000000000<br/>nombre_sistema: SISTEMA DE ASISTENTE VIRTUAL PARA DETERMINAR Y ORIENTAR SOLUCIONES A FALLAS MECÁNICAS DE UN MOTOR<br/>razon_social: EMPRESA NUEVAERA<br/>updated_at: 2023-04-24 14:59:56<br/>web: <br/>', 'CONFIGURACIÓN', '2023-04-24', '14:59:56', '2023-04-24 18:59:56', '2023-04-24 18:59:56'),
(8, 1, 'CREACIÓN', 'EL USUARIO admin REGISTRO UN USUARIO', 'acceso: 0<br/>ci: 1234<br/>ci_exp: LP<br/>correo: juan@gmail.com<br/>created_at: 2023-04-26 17:03:04<br/>dir: LOS OLIVOS<br/>fecha_registro: 2023-04-26<br/>fono: 777777<br/>foto: default.png<br/>id: 2<br/>materno: <br/>nombre: JUAN<br/>password: $2y$10$juxx2rS0EjhJksUVl0HLt.0ykkuCStTEPZhM4.UNmMWeL.kZkWLqy<br/>paterno: PERES<br/>tipo: ADMINISTRADOR<br/>updated_at: 2023-04-26 17:03:04<br/>usuario: JUAN@GMAIL.COM<br/>', NULL, 'USUARIOS', '2023-04-26', '17:03:04', '2023-04-26 21:03:04', '2023-04-26 21:03:04'),
(9, 1, 'MODIFICACIÓN', 'EL USUARIO admin MODIFICÓ UN USUARIO', 'acceso: 0<br/>ci: 1234<br/>ci_exp: LP<br/>correo: juan@gmail.com<br/>created_at: 2023-04-26 17:03:04<br/>dir: LOS OLIVOS<br/>fecha_registro: 2023-04-26<br/>fono: 777777<br/>foto: default.png<br/>id: 2<br/>materno: <br/>nombre: JUAN<br/>password: $2y$10$juxx2rS0EjhJksUVl0HLt.0ykkuCStTEPZhM4.UNmMWeL.kZkWLqy<br/>paterno: PERES<br/>tipo: ADMINISTRADOR<br/>updated_at: 2023-04-26 17:03:04<br/>usuario: JUAN@GMAIL.COM<br/>', 'acceso: 1<br/>ci: 1234<br/>ci_exp: LP<br/>correo: juan@gmail.com<br/>created_at: 2023-04-26 17:03:04<br/>dir: LOS OLIVOS<br/>fecha_registro: 2023-04-26<br/>fono: 777777<br/>foto: default.png<br/>id: 2<br/>materno: <br/>nombre: JUAN<br/>password: $2y$10$juxx2rS0EjhJksUVl0HLt.0ykkuCStTEPZhM4.UNmMWeL.kZkWLqy<br/>paterno: PERES<br/>tipo: ADMINISTRADOR<br/>updated_at: 2023-04-26 17:03:08<br/>usuario: JUAN@GMAIL.COM<br/>', 'USUARIOS', '2023-04-26', '17:03:08', '2023-04-26 21:03:08', '2023-04-26 21:03:08'),
(10, 2, 'CREACIÓN', 'EL USUARIO JUAN@GMAIL.COM REGISTRO UN USUARIO', 'acceso: 1<br/>ci: 12345<br/>ci_exp: LP<br/>correo: pedro@gmail.com<br/>created_at: 2023-04-26 17:06:12<br/>dir: LOS OLIVOS<br/>fecha_registro: 2023-04-26<br/>fono: 666666<br/>foto: default.png<br/>id: 4<br/>materno: <br/>nombre: PEDRO<br/>password: $2y$10$XVzw1w6RbsTzFK91EGpOnuU5KmfDxSEVP/1QR0GJY5E/OKvZPZhH6<br/>paterno: MAMANI<br/>tipo: MECÁNICO<br/>updated_at: 2023-04-26 17:06:12<br/>usuario: pedro@gmail.com<br/>', NULL, 'USUARIOS', '2023-04-26', '17:06:12', '2023-04-26 21:06:12', '2023-04-26 21:06:12'),
(11, 2, 'MODIFICACIÓN', 'EL USUARIO JUAN@GMAIL.COM MODIFICÓ UN USUARIO', 'acceso: 1<br/>ci: 1234<br/>ci_exp: LP<br/>correo: juan@gmail.com<br/>created_at: 2023-04-26 17:03:04<br/>dir: LOS OLIVOS<br/>fecha_registro: 2023-04-26<br/>fono: 777777<br/>foto: default.png<br/>id: 2<br/>materno: <br/>nombre: JUAN<br/>password: $2y$10$juxx2rS0EjhJksUVl0HLt.0ykkuCStTEPZhM4.UNmMWeL.kZkWLqy<br/>paterno: PERES<br/>tipo: ADMINISTRADOR<br/>updated_at: 2023-04-26 17:03:08<br/>usuario: JUAN@GMAIL.COM<br/>', 'acceso: 1<br/>ci: 1234<br/>ci_exp: LP<br/>correo: juan@gmail.com<br/>created_at: 2023-04-26 17:03:04<br/>dir: LOS OLIVOS<br/>fecha_registro: 2023-04-26<br/>fono: 777777<br/>foto: default.png<br/>id: 2<br/>materno: <br/>nombre: JUAN<br/>password: $2y$10$juxx2rS0EjhJksUVl0HLt.0ykkuCStTEPZhM4.UNmMWeL.kZkWLqy<br/>paterno: PERES<br/>tipo: ADMINISTRADOR<br/>updated_at: 2023-04-26 17:06:18<br/>usuario: juan@gmail.com<br/>', 'USUARIOS', '2023-04-26', '17:06:18', '2023-04-26 21:06:18', '2023-04-26 21:06:18'),
(12, 1, 'MODIFICACIÓN', 'EL USUARIO admin@gmail.com MODIFICÓ UN USUARIO', 'acceso: 1<br/>ci: 12345<br/>ci_exp: LP<br/>correo: pedro@gmail.com<br/>created_at: 2023-04-26 17:06:12<br/>dir: LOS OLIVOS<br/>fecha_registro: 2023-04-26<br/>fono: 666666<br/>foto: default.png<br/>id: 4<br/>materno: <br/>nombre: PEDRO<br/>password: $2y$10$XVzw1w6RbsTzFK91EGpOnuU5KmfDxSEVP/1QR0GJY5E/OKvZPZhH6<br/>paterno: MAMANI<br/>tipo: MECÁNICO<br/>updated_at: 2023-04-26 17:06:12<br/>usuario: pedro@gmail.com<br/>', 'acceso: 0<br/>ci: 12345<br/>ci_exp: LP<br/>correo: pedro@gmail.com<br/>created_at: 2023-04-26 17:06:12<br/>dir: LOS OLIVOS<br/>fecha_registro: 2023-04-26<br/>fono: 666666<br/>foto: default.png<br/>id: 4<br/>materno: <br/>nombre: PEDRO<br/>password: $2y$10$XVzw1w6RbsTzFK91EGpOnuU5KmfDxSEVP/1QR0GJY5E/OKvZPZhH6<br/>paterno: MAMANI<br/>tipo: MECÁNICO<br/>updated_at: 2023-04-26 17:11:32<br/>usuario: pedro@gmail.com<br/>', 'USUARIOS', '2023-04-26', '17:11:32', '2023-04-26 21:11:32', '2023-04-26 21:11:32'),
(13, 1, 'CREACIÓN', 'EL USUARIO admin@gmail.com REGISTRO UN USUARIO', 'acceso: 1<br/>ci: 1234<br/>ci_exp: LP<br/>correo: juan@gmail.com<br/>created_at: 2023-05-05 15:49:28<br/>dir: LOS OLIVOS<br/>fecha_registro: 2023-05-05<br/>fono: 7777777<br/>foto: default.png<br/>id: 5<br/>materno: <br/>nombre: JUAN<br/>password: $2y$10$1WQ5ZMbVTexsuBy0w8v3lupJ670.PV.TyJTTh69h0H8NQ.ibhy32O<br/>paterno: PERES<br/>tipo: MECÁNICO<br/>updated_at: 2023-05-05 15:49:29<br/>usuario: juan@gmail.com<br/>', NULL, 'USUARIOS', '2023-05-05', '15:49:29', '2023-05-05 19:49:29', '2023-05-05 19:49:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id` bigint UNSIGNED NOT NULL,
  `modelo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2023_05_02_111236_create_visitantes_table', 1),
(2, '2023_05_02_111506_create_modelos_table', 2),
(3, '2023_05_02_111538_create_marcas_table', 3),
(4, '2023_05_02_111554_create_tipos_table', 4),
(5, '2023_05_02_111609_create_anios_table', 5),
(6, '2023_05_02_111637_create_vehiculos_table', 6),
(7, '2023_05_02_111812_create_caracteristica_vehiculos_table', 7),
(8, '2023_05_02_111929_create_faqs_table', 8),
(9, '2023_05_02_112058_create_chats_table', 9),
(10, '2023_05_05_175307_create_recuperacions_table', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelos`
--

CREATE TABLE `modelos` (
  `id` bigint UNSIGNED NOT NULL,
  `modelo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recuperacions`
--

CREATE TABLE `recuperacions` (
  `id` bigint UNSIGNED NOT NULL,
  `registro_id` bigint UNSIGNED NOT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos`
--

CREATE TABLE `tipos` (
  `id` bigint UNSIGNED NOT NULL,
  `modelo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `usuario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paterno` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `materno` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ci` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ci_exp` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fono` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` enum('ADMINISTRADOR','MECÁNICO','VISITANTE') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `acceso` int NOT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `usuario`, `nombre`, `paterno`, `materno`, `ci`, `ci_exp`, `dir`, `correo`, `fono`, `tipo`, `foto`, `password`, `acceso`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, 'admin@gmail.com', 'admin', 'admin', NULL, '', '', '', 'admin@gmail.com', '', 'ADMINISTRADOR', NULL, '$2y$10$RrCZZySOwPej2gMFWsrjMe6dLzfaL5Q88h4J75I1FesEBRNPwq1x.', 1, '2023-01-11', NULL, NULL),
(5, 'juan@gmail.com', 'JUAN', 'PERES', '', '1234', 'LP', 'LOS OLIVOS', 'juan@gmail.com', '7777777', 'MECÁNICO', 'default.png', '$2y$10$1WQ5ZMbVTexsuBy0w8v3lupJ670.PV.TyJTTh69h0H8NQ.ibhy32O', 1, '2023-05-05', '2023-05-05 19:49:28', '2023-05-05 19:49:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id` bigint UNSIGNED NOT NULL,
  `marca_id` bigint UNSIGNED NOT NULL,
  `tipo_id` bigint UNSIGNED NOT NULL,
  `anio_id` bigint UNSIGNED NOT NULL,
  `modelo_id` bigint UNSIGNED NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitantes`
--

CREATE TABLE `visitantes` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_registro` date NOT NULL,
  `estado` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `visitantes`
--

INSERT INTO `visitantes` (`id`, `nombre`, `correo`, `password`, `fecha_registro`, `estado`, `created_at`, `updated_at`) VALUES
(3, 'JOSE PAREDES', 'jose@gmail.com', '$2y$10$NfUGlyEBd3ksosP4Kp0nT.0ACuSz4WMOQ6HL7arq//K6yHsWBQTa6', '2023-05-05', 1, '2023-05-05 21:05:58', '2023-05-05 21:05:58');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anios`
--
ALTER TABLE `anios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `caracteristica_vehiculos`
--
ALTER TABLE `caracteristica_vehiculos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chats_visitante_id_foreign` (`visitante_id`);

--
-- Indices de la tabla `configuracions`
--
ALTER TABLE `configuracions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faqs_vehiculo_id_foreign` (`vehiculo_id`),
  ADD KEY `faqs_caracteristica_id_foreign` (`caracteristica_id`);

--
-- Indices de la tabla `historial_accions`
--
ALTER TABLE `historial_accions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modelos`
--
ALTER TABLE `modelos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `recuperacions`
--
ALTER TABLE `recuperacions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipos`
--
ALTER TABLE `tipos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_usuario_unique` (`usuario`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehiculos_marca_id_foreign` (`marca_id`),
  ADD KEY `vehiculos_tipo_id_foreign` (`tipo_id`),
  ADD KEY `vehiculos_anio_id_foreign` (`anio_id`),
  ADD KEY `vehiculos_modelo_id_foreign` (`modelo_id`);

--
-- Indices de la tabla `visitantes`
--
ALTER TABLE `visitantes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `anios`
--
ALTER TABLE `anios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `caracteristica_vehiculos`
--
ALTER TABLE `caracteristica_vehiculos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `configuracions`
--
ALTER TABLE `configuracions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_accions`
--
ALTER TABLE `historial_accions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `modelos`
--
ALTER TABLE `modelos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recuperacions`
--
ALTER TABLE `recuperacions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipos`
--
ALTER TABLE `tipos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `visitantes`
--
ALTER TABLE `visitantes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_visitante_id_foreign` FOREIGN KEY (`visitante_id`) REFERENCES `visitantes` (`id`);

--
-- Filtros para la tabla `faqs`
--
ALTER TABLE `faqs`
  ADD CONSTRAINT `faqs_caracteristica_id_foreign` FOREIGN KEY (`caracteristica_id`) REFERENCES `caracteristica_vehiculos` (`id`),
  ADD CONSTRAINT `faqs_vehiculo_id_foreign` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos` (`id`);

--
-- Filtros para la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD CONSTRAINT `vehiculos_anio_id_foreign` FOREIGN KEY (`anio_id`) REFERENCES `anios` (`id`),
  ADD CONSTRAINT `vehiculos_marca_id_foreign` FOREIGN KEY (`marca_id`) REFERENCES `marcas` (`id`),
  ADD CONSTRAINT `vehiculos_modelo_id_foreign` FOREIGN KEY (`modelo_id`) REFERENCES `modelos` (`id`),
  ADD CONSTRAINT `vehiculos_tipo_id_foreign` FOREIGN KEY (`tipo_id`) REFERENCES `tipos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
