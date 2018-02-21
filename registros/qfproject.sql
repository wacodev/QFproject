-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-02-2018 a las 00:53:14
-- Versión del servidor: 10.1.25-MariaDB
-- Versión de PHP: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `qfproject`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `actividades`
--

INSERT INTO `actividades` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Capacitación', NULL, NULL),
(2, 'Clase teórica', NULL, NULL),
(3, 'Discusión', NULL, NULL),
(4, 'Laboratorio', NULL, NULL),
(5, 'Parcial', NULL, NULL),
(6, 'Prelaboratorio', NULL, NULL),
(7, 'Reunión', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaturas`
--

CREATE TABLE `asignaturas` (
  `id` int(10) UNSIGNED NOT NULL,
  `codigo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `asignaturas`
--

INSERT INTO `asignaturas` (`id`, `codigo`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'ABR116', 'Análisis Bromatológico', NULL, NULL),
(2, 'ANI116', 'Análisis Instrumental', NULL, NULL),
(3, 'AOE116', 'Análisis Orgánico Estructural', NULL, NULL),
(4, 'ANT116', 'Anatomía', NULL, NULL),
(5, 'BIG116', 'Biología General', NULL, NULL),
(6, 'BIQ116', 'Bioquímica General', NULL, NULL),
(7, 'BGF116', 'Botánica General y Farmacéutica', NULL, NULL),
(8, 'CAS116', 'Contaminación Ambiental y Salud Pública', NULL, NULL),
(9, 'CPF116', 'Control de Calidad de Productos Farmacéuticas', NULL, NULL),
(10, 'CFC116', 'Control de Calidad de Productos Farmacéuticos y Cosméticos', NULL, NULL),
(11, 'EGE116', 'Estadística', NULL, NULL),
(12, 'FAH116', 'Farmacia Hospitalaria I', NULL, NULL),
(13, 'FAH216', 'Farmacia Hospitalaria II', NULL, NULL),
(14, 'FAH316', 'Farmacia Hospitalaria III', NULL, NULL),
(15, 'FAH416', 'Farmacia Hospitalaria IV', NULL, NULL),
(16, 'FIN116', 'Farmacia Industrial I', NULL, NULL),
(17, 'FIN216', 'Farmacia Industrial II', NULL, NULL),
(18, 'FIN316', 'Farmacia Industrial III', NULL, NULL),
(19, 'FIN416', 'Farmacia Industrial IV', NULL, NULL),
(20, 'FAR116', 'Farmacognosía', NULL, NULL),
(21, 'FRM116', 'Farmacología', NULL, NULL),
(22, 'FMQ116', 'Farmacoquímica', NULL, NULL),
(23, 'FAT115', 'Farmacotécnia', NULL, NULL),
(24, 'FIS116', 'Física I', NULL, NULL),
(25, 'FIS216', 'Física II', NULL, NULL),
(26, 'FQF116', 'Físicofarmacia I', NULL, NULL),
(27, 'FQF216', 'Físicofarmacia II', NULL, NULL),
(28, 'FIG116', 'Fisiología', NULL, NULL),
(29, 'ING116', 'Inglés Técnico I', NULL, NULL),
(30, 'ING216', 'Inglés Técnico II', NULL, NULL),
(31, 'LFD116', 'Legislación Farmacéutica y Deontología', NULL, NULL),
(32, 'MAT116', 'Matemática I', NULL, NULL),
(33, 'MAT216', 'Matemática II', NULL, NULL),
(34, 'MAT316', 'Matemática III', NULL, NULL),
(35, 'MIA116', 'Microbiología Aplicada I', NULL, NULL),
(36, 'MIA216', 'Microbiología Aplicada II', NULL, NULL),
(37, 'MIA316', 'Microbiología Aplicada III', NULL, NULL),
(38, 'MIA416', 'Microbiología Aplicada IV', NULL, NULL),
(39, 'MYP116', 'Microbiología y Parasitología', NULL, NULL),
(40, 'PAD116', 'Principios de Administración', NULL, NULL),
(41, 'PAP116', 'Psicología Aplicada a la Empresa', NULL, NULL),
(42, 'QAA116', 'Química Agrícola Aplicada I', NULL, NULL),
(43, 'QAA216', 'Química Agrícola Aplicada II', NULL, NULL),
(44, 'QAA316', 'Química Agrícola Aplicada III', NULL, NULL),
(45, 'QAA416', 'Química Agrícola Aplicada IV', NULL, NULL),
(46, 'QAQ116', 'Química Analítica Cualitativa', NULL, NULL),
(47, 'QAC116', 'Química Analítica Cuantitativa', NULL, NULL),
(48, 'QFT116', 'Química Forense y Toxicología', NULL, NULL),
(49, 'QUG116', 'Química General I', NULL, NULL),
(50, 'QUG216', 'Química General IÍ', NULL, NULL),
(51, 'QIA116', 'Química Industrial y Aprovechamiento de los Recursos Naturales y Renovables', NULL, NULL),
(52, 'QUI116', 'Química Inorgánica', NULL, NULL),
(53, 'QUO116', 'Química Orgánica I', NULL, NULL),
(54, 'QUO216', 'Química Orgánica II', NULL, NULL),
(55, 'SOG116', 'Sociología', NULL, NULL),
(56, 'TRI116', 'Técnicas de Redacción e Investigación', NULL, NULL),
(57, 'TFA116', 'Tecnología Farmacéutica', NULL, NULL),
(58, 'TFC116', 'Tecnología Farmacéutica y Cosmética', NULL, NULL),
(59, 'ZAF116', 'Zoología Aplicada a la Farmacia', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asuetos`
--

CREATE TABLE `asuetos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dia` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mes` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `locales`
--

CREATE TABLE `locales` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacidad` int(11) NOT NULL,
  `imagen` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'local_default.jpg',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `locales`
--

INSERT INTO `locales` (`id`, `nombre`, `capacidad`, `imagen`, `created_at`, `updated_at`) VALUES
(1, 'Auditorium No. 1', 100, 'local_default.jpg', NULL, NULL),
(2, 'Auditorium No. 2', 100, 'local_default.jpg', NULL, NULL),
(3, 'Aula 201', 75, 'local_default.jpg', NULL, NULL),
(4, 'Aula 202', 75, 'local_default.jpg', NULL, NULL),
(5, 'Aula 205', 75, 'local_default.jpg', NULL, NULL),
(6, 'Aula 206', 75, 'local_default.jpg', NULL, NULL),
(7, 'Aula 207', 75, 'local_default.jpg', NULL, NULL),
(8, 'Aula 208', 75, 'local_default.jpg', NULL, NULL),
(9, 'Aula 209', 75, 'local_default.jpg', NULL, NULL),
(10, 'Aula 210', 75, 'local_default.jpg', NULL, NULL),
(11, 'Aula de farmacología', 75, 'local_default.jpg', NULL, NULL),
(12, 'Aula No. 6', 75, 'local_default.jpg', NULL, NULL),
(13, 'Aula tecnología', 75, 'local_default.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2017_12_07_022900_create_locales_table', 1),
(4, '2017_12_07_023558_create_actividades_table', 1),
(5, '2017_12_07_023742_create_asignaturas_table', 1),
(6, '2017_12_07_024239_create_asuetos_table', 1),
(7, '2017_12_07_024446_create_suspensiones_table', 1),
(8, '2017_12_07_025242_create_reservaciones_table', 1),
(9, '2017_12_27_172901_create_notifications_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` int(10) UNSIGNED NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservaciones`
--

CREATE TABLE `reservaciones` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `local_id` int(10) UNSIGNED NOT NULL,
  `asignatura_id` int(10) UNSIGNED NOT NULL,
  `actividad_id` int(10) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `tema` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `responsable` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo` enum('Ordinaria','Extraordinaria') COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suspensiones`
--

CREATE TABLE `suspensiones` (
  `id` int(10) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` enum('Administrador','Asistente','Docente','Visitante') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Docente',
  `imagen` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user_default.jpg',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `lastname`, `username`, `email`, `password`, `tipo`, `imagen`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Usuario', 'Administrador', 'admin', 'admin@mail.com', '$2y$10$8WXD2acmh0vM8bvOCL4cDeP86VqY7y4WuVp96IUYKkpn7giOIJD.2', 'Administrador', 'user_default.jpg', NULL, '2018-02-17 22:18:49', '2018-02-17 22:18:49');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `actividades_nombre_unique` (`nombre`);

--
-- Indices de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `asignaturas_codigo_unique` (`codigo`);

--
-- Indices de la tabla `asuetos`
--
ALTER TABLE `asuetos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `locales`
--
ALTER TABLE `locales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `locales_nombre_unique` (`nombre`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_id_notifiable_type_index` (`notifiable_id`,`notifiable_type`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `reservaciones`
--
ALTER TABLE `reservaciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reservaciones_codigo_unique` (`codigo`),
  ADD KEY `reservaciones_user_id_foreign` (`user_id`),
  ADD KEY `reservaciones_local_id_foreign` (`local_id`),
  ADD KEY `reservaciones_asignatura_id_foreign` (`asignatura_id`),
  ADD KEY `reservaciones_actividad_id_foreign` (`actividad_id`);

--
-- Indices de la tabla `suspensiones`
--
ALTER TABLE `suspensiones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividades`
--
ALTER TABLE `actividades`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT de la tabla `asuetos`
--
ALTER TABLE `asuetos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `locales`
--
ALTER TABLE `locales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `reservaciones`
--
ALTER TABLE `reservaciones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `suspensiones`
--
ALTER TABLE `suspensiones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `reservaciones`
--
ALTER TABLE `reservaciones`
  ADD CONSTRAINT `reservaciones_actividad_id_foreign` FOREIGN KEY (`actividad_id`) REFERENCES `actividades` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservaciones_asignatura_id_foreign` FOREIGN KEY (`asignatura_id`) REFERENCES `asignaturas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservaciones_local_id_foreign` FOREIGN KEY (`local_id`) REFERENCES `locales` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservaciones_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
