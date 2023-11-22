/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE IF NOT EXISTS `trackpak` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `trackpak`;

CREATE TABLE IF NOT EXISTS `events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `codigo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `events_user_id_foreign` (`user_id`),
  CONSTRAINT `events_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `events` (`id`, `action`, `user_id`, `codigo`, `created_at`, `updated_at`, `descripcion`) VALUES
	(1, 'ADMITIDO', 20, 'RR935638274ES', '2023-11-22 22:28:45', '2023-11-22 22:28:45', 'Clasificación del Paquete en Oficina Postal Regional'),
	(2, 'ADMISION', 20, 'RR935638274ES', '2023-11-22 22:28:45', '2023-11-22 22:28:45', 'Llegada de Paquete en Oficina Postal Regional');

CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2023_10_02_211831_create_packages_table', 1),
	(6, '2023_10_06_163017_add_soft_deletes_to_packages_table', 1),
	(7, '2023_10_10_151859_create_permission_tables', 1),
	(8, '2023_10_14_120013_add_aduana_to_packages', 1),
	(9, '2023_10_23_115728_add_redirigido_to_packages_table', 1),
	(10, '2023_10_23_152118_add_date_redirigido_to_packages_table', 1),
	(11, '2023_10_23_174631_add_regional_to_users_table', 1),
	(12, '2023_10_30_150455_create_events_table', 1),
	(13, '2023_11_01_085232_add_descripcion_to_events', 1),
	(14, '2023_11_08_140849_add_ci_to_users', 2),
	(15, '2023_11_08_141224_add_ci_to_users', 3),
	(16, '2023_11_08_150634_add_cuidadre_to_packages', 4);

CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(6, 'App\\Models\\User', 7),
	(6, 'App\\Models\\User', 8),
	(6, 'App\\Models\\User', 9),
	(4, 'App\\Models\\User', 10),
	(3, 'App\\Models\\User', 12),
	(5, 'App\\Models\\User', 13),
	(1, 'App\\Models\\User', 20),
	(6, 'App\\Models\\User', 21),
	(6, 'App\\Models\\User', 22);

CREATE TABLE IF NOT EXISTS `packages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `CODIGO` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `DESTINATARIO` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TELEFONO` int DEFAULT NULL,
  `PAIS` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CUIDAD` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ZONA` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `VENTANILLA` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PESO` double(8,2) DEFAULT NULL,
  `TIPO` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ADUANA` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ESTADO` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'CLASIFICACION',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `redirigido` tinyint(1) DEFAULT '0',
  `date_redirigido` timestamp NULL DEFAULT NULL,
  `cuidadre` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ISO` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `PRECIO` float DEFAULT NULL,
  `OBSERVACIONES` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `packages` (`id`, `CODIGO`, `DESTINATARIO`, `TELEFONO`, `PAIS`, `CUIDAD`, `ZONA`, `VENTANILLA`, `PESO`, `TIPO`, `ADUANA`, `ESTADO`, `created_at`, `updated_at`, `deleted_at`, `redirigido`, `date_redirigido`, `cuidadre`, `ISO`, `PRECIO`, `OBSERVACIONES`) VALUES
	(1, 'RR935638274ES', 'ARCOS VASQUEZ ANTONIO', 75867594, 'ES', 'LA PAZ', 'DND', 'DND', 1.80, 'PAQUETE', 'SI', 'CLASIFICACION', '2023-11-22 22:28:45', '2023-11-22 22:28:45', NULL, 0, NULL, NULL, 'SPAIN', 10, NULL);

CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'users.index', 'web', '2023-11-06 14:18:18', '2023-11-06 14:18:18'),
	(2, 'users.create', 'web', '2023-11-06 14:18:18', '2023-11-06 14:18:18'),
	(3, 'users.edit', 'web', '2023-11-06 14:18:18', '2023-11-06 14:18:18'),
	(4, 'users.destroy', 'web', '2023-11-06 14:18:18', '2023-11-06 14:18:18'),
	(5, 'users.delete', 'web', '2023-11-06 14:18:18', '2023-11-06 14:18:18'),
	(6, 'packages.delete', 'web', '2023-11-06 14:18:19', '2023-11-06 14:18:19'),
	(7, 'packages.clasificacion', 'web', '2023-11-06 14:18:19', '2023-11-06 14:18:19'),
	(8, 'packages.ventanilla', 'web', '2023-11-06 14:18:19', '2023-11-06 14:18:19'),
	(9, 'packages.redirigidos', 'web', '2023-11-06 14:18:19', '2023-11-06 14:18:19');

CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'SuperAdmin', 'web', '2023-11-06 14:18:18', '2023-11-06 14:18:18'),
	(2, 'Administrador', 'web', '2023-11-06 14:18:18', '2023-11-06 14:18:18'),
	(3, 'Urbano', 'web', '2023-11-06 14:18:18', '2023-11-06 14:18:18'),
	(4, 'Auxiliar Urbano', 'web', '2023-11-06 14:18:18', '2023-11-06 14:18:18'),
	(5, 'Clasificacion', 'web', '2023-11-06 14:18:18', '2023-11-06 14:18:18'),
	(6, 'Auxiliar Clasificacion', 'web', '2023-11-06 14:18:18', '2023-11-06 14:18:18'),
	(7, 'Adminsion', 'web', '2023-11-06 14:18:18', '2023-11-06 14:18:18'),
	(8, 'Auxiliar Adminsion', 'web', '2023-11-06 14:18:18', '2023-11-06 14:18:18'),
	(9, 'Despacho', 'web', '2023-11-06 14:18:18', '2023-11-06 14:18:18'),
	(10, 'Auxiliar Despacho', 'web', '2023-11-06 14:18:18', '2023-11-06 14:18:18'),
	(11, 'Enlace', 'web', '2023-11-06 14:18:18', '2023-11-06 14:18:18'),
	(12, 'Expedicion', 'web', '2023-11-06 14:18:18', '2023-11-06 14:18:18'),
	(13, 'Auxiliar Expedicion', 'web', '2023-11-06 14:18:18', '2023-11-06 14:18:18'),
	(14, 'Ventanilla', 'web', '2023-11-06 14:18:18', '2023-11-06 14:18:18'),
	(15, 'Almacen', 'web', '2023-11-06 14:18:18', '2023-11-06 14:18:18'),
	(16, 'Auxiliar Almacen', 'web', '2023-11-06 14:18:18', '2023-11-06 14:18:18'),
	(17, 'Cartero', 'web', '2023-11-06 14:18:18', '2023-11-06 14:18:18'),
	(18, 'Operador', 'web', '2023-11-06 14:18:18', '2023-11-06 14:18:18'),
	(19, 'Auxiliar Operador', 'web', '2023-11-06 14:18:18', '2023-11-06 14:18:18'),
	(20, 'Cajero', 'web', '2023-11-06 14:18:18', '2023-11-06 14:18:18');

CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
	(1, 1),
	(2, 1),
	(3, 1),
	(4, 1),
	(5, 1),
	(6, 1),
	(7, 1),
	(8, 1),
	(9, 1),
	(1, 2),
	(2, 2),
	(3, 2),
	(5, 2),
	(6, 2),
	(7, 2),
	(8, 2),
	(9, 2),
	(6, 3),
	(8, 3),
	(6, 4),
	(8, 4),
	(7, 5),
	(9, 5),
	(7, 6),
	(9, 6);

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Regional` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ci` int DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `Regional`, `ci`, `remember_token`, `created_at`, `updated_at`) VALUES
	(7, 'Rodrigo Villa Sanjines', 'rodrigo.villa@correos.gob.bo', NULL, '$2y$10$b6aDZSzXjhB8LyewKqoEjOAvIeYFks32wmX/teQfsLn/Bz43mccxK', 'LA PAZ', 9883740, NULL, '2023-10-26 18:19:40', '2023-10-26 18:19:40'),
	(8, 'Victor Antonio Tapia Quisbert', 'victor.tapia@correos.gob.bo', NULL, '$2y$10$gtWuAzWdTp9ZB9IWoqxDWu6z/jLb3Za86w8BNHszGQMEHfmY08xuq', 'LA PAZ', 6978733, NULL, '2023-10-26 18:20:40', '2023-10-26 18:20:40'),
	(10, 'Luisa Gutierrez Arroyo', 'luisa.gutierrez@correos.gob.bo', NULL, '$2y$10$TaD.egiUuukEL8.wUcdmOupYpmZUR9vd/6ea6bgw/z7IblIwIaPe6', 'LA PAZ', 8277686, NULL, '2023-10-26 20:41:30', '2023-10-26 20:41:30'),
	(12, 'Caleb Conde Huanca', 'caleb.conde@correos.gob.bo', NULL, '$2y$10$JoWeg7Kz.NHfh4dJHc/L6e/1qvgIZP37H3pM7IR8q0E4M1cs2Afve', 'LA PAZ', 12767384, NULL, '2023-10-26 20:43:05', '2023-10-26 20:43:05'),
	(13, 'Omar Quispe Condori', 'omar.quispe@correos.gob.bo', NULL, '$2y$10$zZ/Ejx.ySxyCfucNThuReemHBpEqmcHV/C0jTo7BHMAFDNsFAi3VC', 'LA PAZ', NULL, NULL, '2023-11-06 14:21:40', '2023-11-06 14:21:40'),
	(20, 'Marco Antonio Espinoza Rojas', 'marco.espinoza@correos.gob.bo', NULL, '$2y$10$qqtW5Vo8krRvo5H.5JhKLOyHNpBNXtLe2Tk2//tMyxtb54E5l/t22', 'LA PAZ', 10909669, 'yeFNtS8nP91PqlnsMixmMtSvwyYc6YdBwiSltYjVhkxxK9MRyIiZP3UmDcIJ', '2023-11-17 18:01:08', '2023-11-17 18:01:08'),
	(21, 'Jose Luis Rodriguez Alvarez', 'jose.rodriguez@correos.gob.bo', NULL, '$2y$10$efOk9thUfdZbrMdVBnALPukoqJlqDJNI490CbFH68Mql69lFZBTQC', 'LA PAZ', 6950366, NULL, '2023-11-17 18:07:31', '2023-11-17 18:07:31'),
	(22, 'Wike Mamani Apaza', 'wike.mamani@correos.gob.bo', NULL, '$2y$10$RS4SgMBy8.NiujCGasv1x.Bo9GIJPgHWYhNqzlqEOpMezzMi6Itma', 'LA PAZ', 6841118, 'xvDjF6SGhcFUU45a9qsZKtmFEzVqN5HMVj560BPGgCND9f8VVTdNSdnOJD9J', '2023-11-17 18:14:21', '2023-11-17 18:14:21');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
