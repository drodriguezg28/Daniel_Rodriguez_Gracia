/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `agentes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `agentes` (
  `ID_Agente` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(30) DEFAULT NULL,
  `Apellido1` varchar(30) DEFAULT NULL,
  `Apellido2` varchar(30) DEFAULT NULL,
  `Email` int DEFAULT NULL,
  `Telefono` int DEFAULT NULL,
  `Nacionalidad` int DEFAULT NULL,
  `Usuario` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`ID_Agente`),
  KEY `nacionalidad_agentes` (`Nacionalidad`),
  KEY `agentes_usuario` (`Usuario`),
  CONSTRAINT `agentes_usuario` FOREIGN KEY (`Usuario`) REFERENCES `users` (`id`),
  CONSTRAINT `nacionalidad_agentes` FOREIGN KEY (`Nacionalidad`) REFERENCES `paises` (`ID_Pais`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `clubes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clubes` (
  `ID_Club` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(30) DEFAULT NULL,
  `Pais` int DEFAULT NULL,
  `Teléfono` int DEFAULT NULL,
  `Email` int DEFAULT NULL,
  `Usuario` bigint unsigned DEFAULT NULL,
  `url_logo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_Club`),
  KEY `nacionalidad_clubes` (`Pais`),
  KEY `clubes_usuario` (`Usuario`),
  CONSTRAINT `clubes_usuario` FOREIGN KEY (`Usuario`) REFERENCES `users` (`id`),
  CONSTRAINT `nacionalidad_clubes` FOREIGN KEY (`Pais`) REFERENCES `paises` (`ID_Pais`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `competi_clubes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `competi_clubes` (
  `ID_Club` int NOT NULL,
  `ID_Competicion` int NOT NULL,
  PRIMARY KEY (`ID_Club`,`ID_Competicion`),
  KEY `competicion_competi_clubes` (`ID_Competicion`),
  CONSTRAINT `club_competi_clubes` FOREIGN KEY (`ID_Club`) REFERENCES `clubes` (`ID_Club`),
  CONSTRAINT `competicion_competi_clubes` FOREIGN KEY (`ID_Competicion`) REFERENCES `competicion` (`ID_Competicion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `competicion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `competicion` (
  `ID_Competicion` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) DEFAULT NULL,
  `Pais` int DEFAULT NULL,
  `Tipo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_Competicion`),
  KEY `pais_competicion` (`Pais`),
  CONSTRAINT `pais_competicion` FOREIGN KEY (`Pais`) REFERENCES `paises` (`ID_Pais`),
  CONSTRAINT `competicion_chk_1` CHECK ((`Tipo` in (_utf8mb4'Liga',_utf8mb4'Copa Nacional',_utf8mb4'Copa de la Liga',_utf8mb4'Supercopa',_utf8mb4'Copa Continental',_utf8mb4'Copa Intercontinental',_utf8mb4'Torneo Amistoso')))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `contrataciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contrataciones` (
  `ID_Contratacion` int NOT NULL AUTO_INCREMENT,
  `Jugador` int DEFAULT NULL,
  `Club` int DEFAULT NULL,
  `Fecha_Inicio_Contrato` date DEFAULT NULL,
  `Fecha_Fin_Contrato` date DEFAULT NULL,
  `Sueldo` decimal(10,2) DEFAULT NULL,
  `Porcentaje_Comision` decimal(5,2) DEFAULT NULL,
  `Duracion_restante` int GENERATED ALWAYS AS ((to_days(`Fecha_Fin_Contrato`) - to_days(`Fecha_Inicio_Contrato`))) VIRTUAL,
  `Tipo_Contrato` varchar(10) DEFAULT NULL,
  `Rol_Equipo` varchar(12) DEFAULT NULL,
  `Fecha_Rescision_Cancelacion` date DEFAULT NULL,
  PRIMARY KEY (`ID_Contratacion`),
  KEY `jugador_contrataciones` (`Jugador`),
  KEY `club_contrataciones` (`Club`),
  CONSTRAINT `club_contrataciones` FOREIGN KEY (`Club`) REFERENCES `clubes` (`ID_Club`),
  CONSTRAINT `jugador_contrataciones` FOREIGN KEY (`Jugador`) REFERENCES `jugadores` (`ID_Jugador`),
  CONSTRAINT `contrataciones_chk_1` CHECK ((`Porcentaje_Comision` <= 10.00)),
  CONSTRAINT `contrataciones_chk_2` CHECK ((`Tipo_Contrato` in (_utf8mb4'Cesión',_utf8mb4'Renovación',_utf8mb4'Compra',_utf8mb4'Libre'))),
  CONSTRAINT `contrataciones_chk_3` CHECK ((`Rol_Equipo` in (_utf8mb4'Titular',_utf8mb4'Suplente',_utf8mb4'Cantera')))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `contratos_representacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contratos_representacion` (
  `ID_Contrato` int NOT NULL AUTO_INCREMENT,
  `Jugador` int DEFAULT NULL,
  `Agente` int DEFAULT NULL,
  `Fecha_Inicio` date NOT NULL,
  `Fecha_Fin` date DEFAULT NULL,
  `Tiempo_Restante` int GENERATED ALWAYS AS ((to_days(`Fecha_Fin`) - to_days(`Fecha_Inicio`))) VIRTUAL,
  `Porcentaje_Comision` decimal(5,2) DEFAULT '0.00',
  `Clausulas` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`ID_Contrato`),
  KEY `jugador_contratos_representacion` (`Jugador`),
  KEY `agente_contratos_representacion` (`Agente`),
  CONSTRAINT `agente_contratos_representacion` FOREIGN KEY (`Agente`) REFERENCES `agentes` (`ID_Agente`),
  CONSTRAINT `jugador_contratos_representacion` FOREIGN KEY (`Jugador`) REFERENCES `jugadores` (`ID_Jugador`),
  CONSTRAINT `contratos_representacion_chk_1` CHECK ((`Porcentaje_Comision` <= 10.00))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `email` (
  `ID_Email` int NOT NULL AUTO_INCREMENT,
  `Email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_Email`),
  CONSTRAINT `email_chk_1` CHECK (regexp_like(`Email`,_utf8mb4'^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,}$'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `email_agente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `email_agente` (
  `ID_Email` int NOT NULL,
  `ID_Agente` int NOT NULL,
  PRIMARY KEY (`ID_Email`,`ID_Agente`),
  KEY `agente_email_agente` (`ID_Agente`),
  CONSTRAINT `agente_email_agente` FOREIGN KEY (`ID_Agente`) REFERENCES `agentes` (`ID_Agente`),
  CONSTRAINT `email_email_agente` FOREIGN KEY (`ID_Email`) REFERENCES `email` (`ID_Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `email_club`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `email_club` (
  `ID_Email` int NOT NULL,
  `ID_Club` int NOT NULL,
  PRIMARY KEY (`ID_Email`,`ID_Club`),
  KEY `club_email_club` (`ID_Club`),
  CONSTRAINT `club_email_club` FOREIGN KEY (`ID_Club`) REFERENCES `clubes` (`ID_Club`),
  CONSTRAINT `email_email_club` FOREIGN KEY (`ID_Email`) REFERENCES `email` (`ID_Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `email_ojeador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `email_ojeador` (
  `ID_Email` int NOT NULL,
  `ID_Ojeador` int NOT NULL,
  PRIMARY KEY (`ID_Email`,`ID_Ojeador`),
  KEY `ojeador_email_ojeador` (`ID_Ojeador`),
  CONSTRAINT `email_email_ojeador` FOREIGN KEY (`ID_Email`) REFERENCES `email` (`ID_Email`),
  CONSTRAINT `ojeador_email_ojeador` FOREIGN KEY (`ID_Ojeador`) REFERENCES `ojeadores` (`ID_Ojeador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `estadisticas_jugador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estadisticas_jugador` (
  `ID_Estadisticas` int NOT NULL AUTO_INCREMENT,
  `Jugador` int DEFAULT NULL,
  `Club` int DEFAULT NULL,
  `Temporada` int DEFAULT NULL,
  `Competicion` int DEFAULT NULL,
  `Partidos_jugados` int DEFAULT NULL,
  `Goles` int DEFAULT NULL,
  `Asistencias` int DEFAULT NULL,
  `Tarjetas_amarillas` int DEFAULT NULL,
  `Tarjetas_rojas` int DEFAULT NULL,
  PRIMARY KEY (`ID_Estadisticas`),
  KEY `jugador_estadisticas_jugador` (`Jugador`),
  KEY `club_estadisticas_jugador` (`Club`),
  KEY `temporada_estadisticas_jugador` (`Temporada`),
  KEY `competicion_estadisticas_jugador` (`Competicion`),
  CONSTRAINT `club_estadisticas_jugador` FOREIGN KEY (`Club`) REFERENCES `clubes` (`ID_Club`),
  CONSTRAINT `competicion_estadisticas_jugador` FOREIGN KEY (`Competicion`) REFERENCES `competicion` (`ID_Competicion`),
  CONSTRAINT `jugador_estadisticas_jugador` FOREIGN KEY (`Jugador`) REFERENCES `jugadores` (`ID_Jugador`),
  CONSTRAINT `temporada_estadisticas_jugador` FOREIGN KEY (`Temporada`) REFERENCES `temporada` (`ID_Temporada`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
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
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `informes_scouting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `informes_scouting` (
  `ID_Informe` int NOT NULL AUTO_INCREMENT,
  `Jugador` int DEFAULT NULL,
  `Ojeador` int DEFAULT NULL,
  `Partido_Cubierto` int DEFAULT NULL,
  `Fecha_Informe` date DEFAULT NULL,
  `Valoraciones` varchar(2000) DEFAULT NULL,
  `Potencial` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID_Informe`),
  KEY `jugadores_informes_socuting` (`Jugador`),
  KEY `ojeadores_informes_socuting` (`Ojeador`),
  KEY `partido_informes_socuting` (`Partido_Cubierto`),
  CONSTRAINT `jugadores_informes_socuting` FOREIGN KEY (`Jugador`) REFERENCES `jugadores` (`ID_Jugador`),
  CONSTRAINT `ojeadores_informes_socuting` FOREIGN KEY (`Ojeador`) REFERENCES `ojeadores` (`ID_Ojeador`),
  CONSTRAINT `partido_informes_socuting` FOREIGN KEY (`Partido_Cubierto`) REFERENCES `partidos_cubiertos` (`ID_Partido_Cubierto`),
  CONSTRAINT `informes_scouting_chk_1` CHECK ((`Potencial` in (_utf8mb4'Bajo',_utf8mb4'Medio',_utf8mb4'Alto',_utf8mb4'Élite',_utf8mb4'Generacional',_utf8mb4'Estable',_utf8mb4'En Declive',_utf8mb4'Últimos Años')))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jugadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jugadores` (
  `ID_Jugador` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(30) DEFAULT NULL,
  `Apellido1` varchar(30) DEFAULT NULL,
  `Apellido2` varchar(30) DEFAULT NULL,
  `Apodo` varchar(30) DEFAULT NULL,
  `Fecha_Nacimiento` date DEFAULT NULL,
  `Nacionalidad` int DEFAULT NULL,
  `Altura` decimal(3,2) DEFAULT NULL,
  `Peso` decimal(5,2) DEFAULT NULL,
  `Posicion_Principal` enum('Portero','Defensa Central','Lateral Derecho','Lateral Izquierdo','Carrilero','Pivote','Mediocentro','Mediapunta','Interior Derecho','Interior Izquierdo','Extremo Derecho','Extremo Izquierdo','Segundo Delantero','Delantero Centro') DEFAULT NULL,
  `Posicion_Secundaria` enum('Ninguna','Portero','Defensa Central','Lateral Derecho','Lateral Izquierdo','Carrilero','Pivote','Mediocentro','Mediapunta','Interior Derecho','Interior Izquierdo','Extremo Derecho','Extremo Izquierdo','Segundo Delantero','Delantero Centro') NOT NULL DEFAULT 'Ninguna',
  `Dorsal_actual` int DEFAULT NULL,
  `Club_Actual` int DEFAULT NULL,
  `Valor_Mercado` decimal(12,2) DEFAULT NULL,
  `Agente` int DEFAULT NULL,
  `Usuario` bigint unsigned DEFAULT NULL,
  `Foto_Perfil` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_Jugador`),
  KEY `nacionalidad_jugadores` (`Nacionalidad`),
  KEY `club_jugadores` (`Club_Actual`),
  KEY `agente_jugadores` (`Agente`),
  KEY `jugadores_usuario` (`Usuario`),
  CONSTRAINT `agente_jugadores` FOREIGN KEY (`Agente`) REFERENCES `agentes` (`ID_Agente`),
  CONSTRAINT `club_jugadores` FOREIGN KEY (`Club_Actual`) REFERENCES `clubes` (`ID_Club`),
  CONSTRAINT `jugadores_usuario` FOREIGN KEY (`Usuario`) REFERENCES `users` (`id`),
  CONSTRAINT `nacionalidad_jugadores` FOREIGN KEY (`Nacionalidad`) REFERENCES `paises` (`ID_Pais`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ojeadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ojeadores` (
  `ID_Ojeador` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(30) DEFAULT NULL,
  `Apellido1` varchar(30) DEFAULT NULL,
  `Apellido2` varchar(30) DEFAULT NULL,
  `Apodo` varchar(50) DEFAULT NULL,
  `Email` int DEFAULT NULL,
  `Telefono` int DEFAULT NULL,
  `Nacionalidad` int DEFAULT NULL,
  `Usuario` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`ID_Ojeador`),
  KEY `ojeadores_pais` (`Nacionalidad`),
  KEY `ojeadores_usuario` (`Usuario`),
  CONSTRAINT `ojeadores_pais` FOREIGN KEY (`Nacionalidad`) REFERENCES `paises` (`ID_Pais`),
  CONSTRAINT `ojeadores_usuario` FOREIGN KEY (`Usuario`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ojeadores_partidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ojeadores_partidos` (
  `ID_Ojeador` int NOT NULL,
  `ID_Partido_Cubierto` int NOT NULL,
  PRIMARY KEY (`ID_Ojeador`,`ID_Partido_Cubierto`),
  KEY `partido_ojeadores_partidos` (`ID_Partido_Cubierto`),
  CONSTRAINT `ojeadores_ojeadores_partidos` FOREIGN KEY (`ID_Ojeador`) REFERENCES `ojeadores` (`ID_Ojeador`),
  CONSTRAINT `partido_ojeadores_partidos` FOREIGN KEY (`ID_Partido_Cubierto`) REFERENCES `partidos_cubiertos` (`ID_Partido_Cubierto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `paises`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `paises` (
  `ID_Pais` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(40) DEFAULT NULL,
  `Continente` varchar(30) DEFAULT NULL,
  `Bandera` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_Pais`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `partidos_cubiertos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `partidos_cubiertos` (
  `ID_Partido_Cubierto` int NOT NULL AUTO_INCREMENT,
  `Equipo_Local` int DEFAULT NULL,
  `Equipo_Visitante` int DEFAULT NULL,
  `Goles_Local` int DEFAULT NULL,
  `Goles_Visitante` int DEFAULT NULL,
  `Ganador` varchar(9) DEFAULT NULL,
  `Fecha` date DEFAULT (curdate()),
  `Pais` int DEFAULT NULL,
  `Localidad` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`ID_Partido_Cubierto`),
  KEY `equipoL_partidos_cubiertos` (`Equipo_Local`),
  KEY `equipoV_partidos_cubiertos` (`Equipo_Visitante`),
  KEY `pais_partidos_cubiertos` (`Pais`),
  CONSTRAINT `equipoL_partidos_cubiertos` FOREIGN KEY (`Equipo_Local`) REFERENCES `clubes` (`ID_Club`),
  CONSTRAINT `equipoV_partidos_cubiertos` FOREIGN KEY (`Equipo_Visitante`) REFERENCES `clubes` (`ID_Club`),
  CONSTRAINT `pais_partidos_cubiertos` FOREIGN KEY (`Pais`) REFERENCES `paises` (`ID_Pais`),
  CONSTRAINT `partidos_cubiertos_chk_1` CHECK ((`Ganador` in (_utf8mb4'Local',_utf8mb4'Empate',_utf8mb4'Visitante')))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `partidos_jugadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `partidos_jugadores` (
  `ID_Partido_Cubierto` int NOT NULL,
  `ID_Jugador` int NOT NULL,
  PRIMARY KEY (`ID_Jugador`,`ID_Partido_Cubierto`),
  KEY `partido_partidos_jugadores` (`ID_Partido_Cubierto`),
  CONSTRAINT `jugadores_partidos_jugadores` FOREIGN KEY (`ID_Jugador`) REFERENCES `jugadores` (`ID_Jugador`),
  CONSTRAINT `partido_partidos_jugadores` FOREIGN KEY (`ID_Partido_Cubierto`) REFERENCES `partidos_cubiertos` (`ID_Partido_Cubierto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `telefono`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `telefono` (
  `ID_Telefono` int NOT NULL AUTO_INCREMENT,
  `Telefono` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_Telefono`),
  CONSTRAINT `telefono_chk_1` CHECK (regexp_like(`Telefono`,_utf8mb4'^\\+[1-9][0-9]{7,14}$'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `telefono_agente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `telefono_agente` (
  `ID_Telefono` int NOT NULL,
  `ID_Agente` int NOT NULL,
  PRIMARY KEY (`ID_Telefono`,`ID_Agente`),
  KEY `agente_Telefono_agente` (`ID_Agente`),
  CONSTRAINT `agente_Telefono_agente` FOREIGN KEY (`ID_Agente`) REFERENCES `agentes` (`ID_Agente`),
  CONSTRAINT `telefono_Telefono_agente` FOREIGN KEY (`ID_Telefono`) REFERENCES `telefono` (`ID_Telefono`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `telefono_club`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `telefono_club` (
  `ID_Telefono` int NOT NULL,
  `ID_Club` int NOT NULL,
  PRIMARY KEY (`ID_Telefono`,`ID_Club`),
  KEY `club_telefono_club` (`ID_Club`),
  CONSTRAINT `club_telefono_club` FOREIGN KEY (`ID_Club`) REFERENCES `clubes` (`ID_Club`),
  CONSTRAINT `telefono_telefono_club` FOREIGN KEY (`ID_Telefono`) REFERENCES `telefono` (`ID_Telefono`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `telefono_ojeador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `telefono_ojeador` (
  `ID_Telefono` int NOT NULL,
  `ID_Ojeador` int NOT NULL,
  PRIMARY KEY (`ID_Telefono`,`ID_Ojeador`),
  KEY `ojeador_telefono_ojeador` (`ID_Ojeador`),
  CONSTRAINT `ojeador_telefono_ojeador` FOREIGN KEY (`ID_Ojeador`) REFERENCES `ojeadores` (`ID_Ojeador`),
  CONSTRAINT `telefono_telefono_ojeador` FOREIGN KEY (`ID_Telefono`) REFERENCES `telefono` (`ID_Telefono`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `temporada`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `temporada` (
  `ID_Temporada` int NOT NULL AUTO_INCREMENT,
  `Nombre_Temporada` varchar(7) DEFAULT NULL,
  PRIMARY KEY (`ID_Temporada`),
  CONSTRAINT `temporada_chk_1` CHECK (((length(`Nombre_Temporada`) = 7) and regexp_like(`Nombre_Temporada`,_utf8mb4'^[0-9]{4}/[0-9]{2}$')))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `temporada_jugador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `temporada_jugador` (
  `ID_Jugador` int NOT NULL,
  `ID_Temporada` int NOT NULL,
  PRIMARY KEY (`ID_Jugador`,`ID_Temporada`),
  KEY `temporada_temporada_jugador` (`ID_Temporada`),
  CONSTRAINT `jugador_temporada_jugador` FOREIGN KEY (`ID_Jugador`) REFERENCES `jugadores` (`ID_Jugador`),
  CONSTRAINT `temporada_temporada_jugador` FOREIGN KEY (`ID_Temporada`) REFERENCES `temporada` (`ID_Temporada`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `transferencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transferencias` (
  `ID_Transferencia` int NOT NULL AUTO_INCREMENT,
  `Jugador` int DEFAULT NULL,
  `Club_Origen` int DEFAULT NULL,
  `Club_Destino` int DEFAULT NULL,
  `Fecha_Transferencia` date DEFAULT NULL,
  `Valor_Operacion` decimal(12,2) DEFAULT NULL,
  `Comision_Agente` decimal(10,2) DEFAULT NULL,
  `Agente` int DEFAULT NULL,
  PRIMARY KEY (`ID_Transferencia`),
  KEY `jugador_transferencias` (`Jugador`),
  KEY `club_Origen_transferencias` (`Club_Origen`),
  KEY `club_Destino_transferencias` (`Club_Destino`),
  KEY `agente_transferencias` (`Agente`),
  CONSTRAINT `agente_transferencias` FOREIGN KEY (`Agente`) REFERENCES `agentes` (`ID_Agente`),
  CONSTRAINT `club_Destino_transferencias` FOREIGN KEY (`Club_Destino`) REFERENCES `clubes` (`ID_Club`),
  CONSTRAINT `club_Origen_transferencias` FOREIGN KEY (`Club_Origen`) REFERENCES `clubes` (`ID_Club`),
  CONSTRAINT `jugador_transferencias` FOREIGN KEY (`Jugador`) REFERENCES `jugadores` (`ID_Jugador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `calcular_comision` BEFORE INSERT ON `transferencias` FOR EACH ROW BEGIN
    IF NEW.Comision_Agente IS NULL THEN
        SET NEW.Comision_Agente = NEW.Valor_Operacion * 0.10;
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_usuario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'0001_01_01_000000_create_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3,'0001_01_01_000002_create_jobs_table',1);
