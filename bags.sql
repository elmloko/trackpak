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

-- Volcando estructura para tabla trackpak.bags
CREATE TABLE IF NOT EXISTS `bags` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `NRODESPACHO` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NROSACA` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `OFCAMBIO` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `OFDESTINO` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TRASPORTE` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `HORARIO` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `FIN` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PESO` double(8,3) DEFAULT NULL,
  `PESOF` double(8,3) DEFAULT NULL,
  `PAQUETES` int DEFAULT NULL,
  `ITINERARIO` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ESTADO` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'APERTURA',
  `OBSERVACIONES` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `MARBETE` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `RECEPTACULO` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `OFCAM108` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `OFDES108` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ano_creacion` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla trackpak.events
CREATE TABLE IF NOT EXISTS `events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `events_user_id_foreign` (`user_id`),
  CONSTRAINT `events_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9725 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

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

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla trackpak.mensajes
CREATE TABLE IF NOT EXISTS `mensajes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `estado` char(20) NOT NULL,
  `mensajes` text NOT NULL,
  `observacion` varchar(255) NOT NULL,
  `Intentos` int DEFAULT '0',
  `entrega` varchar(20) DEFAULT NULL,
  `id_telefono` bigint unsigned NOT NULL,
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `telefono` (`id_telefono`),
  CONSTRAINT `telefono` FOREIGN KEY (`id_telefono`) REFERENCES `packages` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=206 DEFAULT CHARSET=utf8mb3;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla trackpak.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla trackpak.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla trackpak.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla trackpak.nationals
CREATE TABLE IF NOT EXISTS `nationals` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `CODIGO` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CANTIDAD` int DEFAULT NULL,
  `PESO` double(8,2) DEFAULT NULL,
  `DESTINO` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `FACTURA` int DEFAULT NULL,
  `IMPORTE` int DEFAULT NULL,
  `TIPOSERVICIO` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TIPOCORRESPONDENCIA` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NOMBRESDESTINATARIO` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TELEFONODESTINATARIO` int DEFAULT NULL,
  `CIDESTINATARIO` int DEFAULT NULL,
  `NOMBRESREMITENTE` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TELEFONOREMITENTE` int DEFAULT NULL,
  `CIREMITENTE` int DEFAULT NULL,
  `ESTADO` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'ADMISION',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `DIRECCION` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PROVINCIA` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `MUNICIPIO` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ORIGEN` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `USER` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datedespachoadmision` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla trackpak.packages
CREATE TABLE IF NOT EXISTS `packages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `CODIGO` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DESTINATARIO` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TELEFONO` int DEFAULT NULL,
  `PAIS` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CUIDAD` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ZONA` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `VENTANILLA` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PESO` double(8,3) DEFAULT NULL,
  `TIPO` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ADUANA` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ESTADO` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'CLASIFICACION',
  `ISO` text COLLATE utf8mb4_unicode_ci,
  `PRECIO` text COLLATE utf8mb4_unicode_ci,
  `OBSERVACIONES` text COLLATE utf8mb4_unicode_ci,
  `FACTURA` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `datedespachoclasificacion` timestamp NULL DEFAULT NULL,
  `date_redirigido` timestamp NULL DEFAULT NULL,
  `redirigido` tinyint(1) DEFAULT '0',
  `cuidadre` text COLLATE utf8mb4_unicode_ci,
  `REENCAMINAR` text COLLATE utf8mb4_unicode_ci,
  `usercartero` text COLLATE utf8mb4_unicode_ci,
  `dateprerezago` timestamp NULL DEFAULT NULL,
  `daterezago` timestamp NULL DEFAULT NULL,
  `nrocasilla` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24577 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla trackpak.packages_has_bags
CREATE TABLE IF NOT EXISTS `packages_has_bags` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bags_id` bigint unsigned NOT NULL DEFAULT '0',
  `packages_id` bigint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bags_id` (`bags_id`),
  KEY `packages_id` (`packages_id`),
  CONSTRAINT `bags_has_packages_bags_id_foreign` FOREIGN KEY (`bags_id`) REFERENCES `bags` (`id`),
  CONSTRAINT `packages_has_bags_packages_id_foreign` FOREIGN KEY (`packages_id`) REFERENCES `packages` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=170 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla trackpak.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla trackpak.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

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

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla trackpak.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla trackpak.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla trackpak.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Regional` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ci` int DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
