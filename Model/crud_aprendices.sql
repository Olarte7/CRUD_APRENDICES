-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for crud_aprendices
CREATE DATABASE IF NOT EXISTS `crud_aprendices` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `crud_aprendices`;

-- Dumping structure for table crud_aprendices.aprendices
CREATE TABLE IF NOT EXISTS `aprendices` (
  `id_aprendiz` int NOT NULL AUTO_INCREMENT,
  `id_persona` int NOT NULL,
  `id_ficha` int NOT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `estado` varchar(50) DEFAULT 'Activo',
  PRIMARY KEY (`id_aprendiz`),
  KEY `id_persona` (`id_persona`),
  KEY `id_ficha` (`id_ficha`),
  CONSTRAINT `aprendices_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`),
  CONSTRAINT `aprendices_ibfk_2` FOREIGN KEY (`id_ficha`) REFERENCES `fichas` (`id_ficha`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table crud_aprendices.aprendices: ~0 rows (approximately)

-- Dumping structure for table crud_aprendices.fichas
CREATE TABLE IF NOT EXISTS `fichas` (
  `id_ficha` int NOT NULL AUTO_INCREMENT,
  `numero_ficha` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_programa` int NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  PRIMARY KEY (`id_ficha`),
  UNIQUE KEY `numero_ficha` (`numero_ficha`),
  KEY `id_programa` (`id_programa`),
  CONSTRAINT `fichas_ibfk_1` FOREIGN KEY (`id_programa`) REFERENCES `programas` (`id_programa`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table crud_aprendices.fichas: ~0 rows (approximately)
INSERT INTO `fichas` (`id_ficha`, `numero_ficha`, `id_programa`, `fecha_inicio`, `fecha_fin`) VALUES
	(1, '2923560', 1, '2024-04-15', '2025-10-30'),
	(2, '2923561', 2, '2024-04-15', '2025-10-30'),
	(3, '3018313', 3, '2024-08-12', '2025-05-21'),
	(4, '3001234', 4, '2025-08-13', '2025-11-13'),
	(5, '2923577', 5, '2024-04-15', '2025-10-30');

-- Dumping structure for table crud_aprendices.grupo_sanguineo
CREATE TABLE IF NOT EXISTS `grupo_sanguineo` (
  `id_grupo_sanguineo` int NOT NULL AUTO_INCREMENT,
  `grupo` varchar(3) NOT NULL,
  PRIMARY KEY (`id_grupo_sanguineo`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table crud_aprendices.grupo_sanguineo: ~8 rows (approximately)
INSERT INTO `grupo_sanguineo` (`id_grupo_sanguineo`, `grupo`) VALUES
	(1, 'A+'),
	(2, 'B+'),
	(3, 'O+'),
	(4, 'AB+'),
	(5, 'A-'),
	(6, 'B-'),
	(7, 'O-'),
	(8, 'AB-');

-- Dumping structure for table crud_aprendices.personas
CREATE TABLE IF NOT EXISTS `personas` (
  `id_persona` int NOT NULL AUTO_INCREMENT,
  `documento` varchar(15) NOT NULL,
  `primer_nombre` varchar(50) NOT NULL,
  `segundo_nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `primer_apellido` varchar(50) NOT NULL,
  `segundo_apellido` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `correo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `telefono` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `direccion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_tipo_documento` int NOT NULL,
  `id_grupo_sanguineo` int NOT NULL,
  `id_sexo` int NOT NULL,
  PRIMARY KEY (`id_persona`),
  UNIQUE KEY `documento` (`documento`),
  KEY `id_tipo_documento` (`id_tipo_documento`),
  KEY `id_grupo_sanguineo` (`id_grupo_sanguineo`),
  KEY `id_sexo` (`id_sexo`),
  CONSTRAINT `personas_ibfk_1` FOREIGN KEY (`id_tipo_documento`) REFERENCES `tipo_documento` (`id_tipo_documento`),
  CONSTRAINT `personas_ibfk_2` FOREIGN KEY (`id_grupo_sanguineo`) REFERENCES `grupo_sanguineo` (`id_grupo_sanguineo`),
  CONSTRAINT `personas_ibfk_3` FOREIGN KEY (`id_sexo`) REFERENCES `sexo` (`id_sexo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table crud_aprendices.personas: ~0 rows (approximately)

-- Dumping structure for table crud_aprendices.programas
CREATE TABLE IF NOT EXISTS `programas` (
  `id_programa` int NOT NULL AUTO_INCREMENT,
  `nombre_programa` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nivel_formacion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_programa`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table crud_aprendices.programas: ~0 rows (approximately)
INSERT INTO `programas` (`id_programa`, `nombre_programa`, `nivel_formacion`) VALUES
	(1, 'Análisis y desarrollo de software', 'Tecnólogo'),
	(2, 'Manejo y aprovechamiento forestal', 'Tecnólogo'),
	(3, 'Panificación', 'Técnico'),
	(4, 'Servicio al Cliente', 'Complementario'),
	(5, 'Gestión del Talento Humano', 'Tecnólogo');

-- Dumping structure for table crud_aprendices.sexo
CREATE TABLE IF NOT EXISTS `sexo` (
  `id_sexo` int NOT NULL AUTO_INCREMENT,
  `sexo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_sexo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table crud_aprendices.sexo: ~3 rows (approximately)
INSERT INTO `sexo` (`id_sexo`, `sexo`) VALUES
	(1, 'Masculino'),
	(2, 'Femenino'),
	(3, 'Otro');

-- Dumping structure for table crud_aprendices.tipo_documento
CREATE TABLE IF NOT EXISTS `tipo_documento` (
  `id_tipo_documento` int NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) NOT NULL,
  PRIMARY KEY (`id_tipo_documento`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table crud_aprendices.tipo_documento: ~3 rows (approximately)
INSERT INTO `tipo_documento` (`id_tipo_documento`, `tipo`) VALUES
	(1, 'Cédula de Ciudadanía'),
	(2, 'Tarjeta de Identidad'),
	(3, 'Cédula de Extranjería');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
