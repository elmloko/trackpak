-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para trackpak
CREATE DATABASE IF NOT EXISTS `trackpak` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `trackpak`;

-- Volcando estructura para tabla trackpak.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla trackpak.failed_jobs: ~0 rows (aproximadamente)

-- Volcando estructura para tabla trackpak.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla trackpak.migrations: ~8 rows (aproximadamente)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2023_10_02_205137_create_packages_table', 2),
	(6, '2023_10_02_211831_create_packages_table', 3),
	(7, '2023_10_03_134847_create_packagesr_table', 4),
	(8, '2023_10_03_140525_create_pcertificate_table', 5),
	(9, '2023_10_03_141018_create_pcertificates_table', 6);

-- Volcando estructura para tabla trackpak.packages
CREATE TABLE IF NOT EXISTS `packages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `CODIGO` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DESTINATARIO` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TELEFONO` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `PAIS` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CUIDAD` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ZONA` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `VENTANILLA` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PESO` float NOT NULL DEFAULT '0',
  `TIPO` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ESTADO` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla trackpak.packages: ~1 rows (aproximadamente)
INSERT INTO `packages` (`id`, `CODIGO`, `DESTINATARIO`, `TELEFONO`, `PAIS`, `CUIDAD`, `ZONA`, `VENTANILLA`, `PESO`, `TIPO`, `ESTADO`, `created_at`, `updated_at`) VALUES
	(2, 'UV643247440UZ', 'FLAVIA JHULIANA GONZALES ROCA', '71495885', 'UZ', 'LA PAZ', 'DND', '33', 0.03, 'PAQUETE', 'ALMACEN', '2023-10-03 18:39:46', '2023-10-04 03:02:30');

-- Volcando estructura para tabla trackpak.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla trackpak.password_reset_tokens: ~0 rows (aproximadamente)

-- Volcando estructura para tabla trackpak.pcertificates
CREATE TABLE IF NOT EXISTS `pcertificates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `CODIGO` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DESTINATARIO` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DIRECCION` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TELEFONO` int NOT NULL,
  `PAIS` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CUIDAD` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ZONA` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `VENTANILLA` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PESO` double(8,2) NOT NULL,
  `TIPO` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ESTADO` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla trackpak.pcertificates: ~0 rows (aproximadamente)
INSERT INTO `pcertificates` (`id`, `CODIGO`, `DESTINATARIO`, `DIRECCION`, `TELEFONO`, `PAIS`, `CUIDAD`, `ZONA`, `VENTANILLA`, `PESO`, `TIPO`, `ESTADO`, `created_at`, `updated_at`) VALUES
	(1, 'RR935638274ES', 'ARCOS VASQUEZ ANTONIO', '--', 0, 'ES', 'COCHABAMBA', '--', 'UNICA', 0.00, 'PAQUETE', 'ALMACEN', '2023-10-03 18:25:22', '2023-10-04 03:02:16');

-- Volcando estructura para tabla trackpak.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla trackpak.personal_access_tokens: ~0 rows (aproximadamente)

-- Volcando estructura para tabla trackpak.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla trackpak.users: ~0 rows (aproximadamente)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Marco Espinoza', 'marco@gmail.com', NULL, '$2y$10$ogrSrJRSIDk6DyyFsxMKau6TIuEHYrrK3C.u.tRJd4Qyr7HeV3VfK', 'uNuV8V4fi6PNjhSmpmL7RBcjq3yPn2arITg2K9DNOpbRqYdJlu9ayRDLiNki', '2023-10-02 23:45:13', '2023-10-02 23:45:13');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
