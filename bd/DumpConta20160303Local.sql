CREATE DATABASE  IF NOT EXISTS `contable` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci */;
USE `contable`;
-- MySQL dump 10.13  Distrib 5.6.24, for Win32 (x86)
--
-- Host: localhost    Database: contable
-- ------------------------------------------------------
-- Server version	5.6.17

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `clase_cuenta`
--

DROP TABLE IF EXISTS `clase_cuenta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clase_cuenta` (
  `idclase_cuenta` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  `nomenclatura` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `definicion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idclase_cuenta`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clase_cuenta`
--

LOCK TABLES `clase_cuenta` WRITE;
/*!40000 ALTER TABLE `clase_cuenta` DISABLE KEYS */;
INSERT INTO `clase_cuenta` VALUES (1,'Activo','Activo','1','Activo'),(2,'Cuentas Regularizadoras del Activo','Activo','2','Cuentas Regularizadoras del Activo'),(3,'Pasivo','Activo','3','Pasivo'),(4,'Otras Cuentas Acreedoras','Activo','4','Otras Cuentas Acreedoras'),(5,'Patrimonio (Capital Contable)','Activo','5','Capital Contable'),(6,'Cuentas de Orden per Contra','Activo','6','Cuentas de Orden per Contra'),(7,'Productos ','Activo','7','Productos '),(8,'Gastos','Activo','8','Gastos');
/*!40000 ALTER TABLE `clase_cuenta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nit` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idpersona` int(11) NOT NULL DEFAULT '1',
  `codigo` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  `idempresa` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idcliente`),
  KEY `fk_cliente_idpersona_idx` (`idpersona`),
  KEY `fk_cliente_idempresa_idx` (`idempresa`),
  CONSTRAINT `fk_cliente_idempresa` FOREIGN KEY (`idempresa`) REFERENCES `empresa` (`idempresa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cliente_idpersona` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (1,'Nestor José','9842','Ciudad',1,NULL,'Activo',1),(2,'Nestor José 2','9842','Ciudad',1,'7','Activo',1),(3,'Nestor José 2','9842','Ciudadjk',1,'C8','Activo',1);
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `contable`.`cliente_BEFORE_INSERT` BEFORE INSERT ON `cliente` FOR EACH ROW
BEGIN
	set new.codigo = concat(obtener_configuracion('codigo_cliente',new.idempresa), obtener_correlativo('codigo_cliente', new.idempresa));
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `contable`.`cliente_BEFORE_UPDATE` BEFORE UPDATE ON `cliente` FOR EACH ROW
BEGIN
	set new.codigo = old.codigo;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `configuracion`
--

DROP TABLE IF EXISTS `configuracion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configuracion` (
  `idconfiguracion` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `descripcion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `valor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  `idempresa` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idconfiguracion`),
  KEY `fk_configuracion_idempresa_idx` (`idempresa`),
  CONSTRAINT `fk_configuracion_idempresa` FOREIGN KEY (`idempresa`) REFERENCES `empresa` (`idempresa`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuracion`
--

LOCK TABLES `configuracion` WRITE;
/*!40000 ALTER TABLE `configuracion` DISABLE KEYS */;
INSERT INTO `configuracion` VALUES (1,'codigo_cliente','codigo_prefijo','C','Activo',1);
/*!40000 ALTER TABLE `configuracion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `correlativo`
--

DROP TABLE IF EXISTS `correlativo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `correlativo` (
  `idcorrelativo` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `valor` int(11) NOT NULL DEFAULT '0',
  `idempresa` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idcorrelativo`),
  UNIQUE KEY `codigo_UNIQUE` (`codigo`),
  KEY `fk_correlativo_idx` (`idempresa`),
  CONSTRAINT `fk_correlativo` FOREIGN KEY (`idempresa`) REFERENCES `empresa` (`idempresa`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `correlativo`
--

LOCK TABLES `correlativo` WRITE;
/*!40000 ALTER TABLE `correlativo` DISABLE KEYS */;
INSERT INTO `correlativo` VALUES (1,'codigo_cliente',8,1),(2,'codigo_cliente2',5,1);
/*!40000 ALTER TABLE `correlativo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cuenta`
--

DROP TABLE IF EXISTS `cuenta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cuenta` (
  `idcuenta` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `debe` decimal(10,2) NOT NULL DEFAULT '0.00',
  `haber` decimal(10,2) NOT NULL DEFAULT '0.00',
  `saldo` decimal(10,2) NOT NULL DEFAULT '0.00',
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idcuenta`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cuenta`
--

LOCK TABLES `cuenta` WRITE;
/*!40000 ALTER TABLE `cuenta` DISABLE KEYS */;
INSERT INTO `cuenta` VALUES (1,'111.111','Caja Moneda Nacional',1000.00,850.00,150.00,'Activo'),(2,NULL,'Bancos',850.00,0.00,850.00,'Activo');
/*!40000 ALTER TABLE `cuenta` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`%`*/ /*!50003 TRIGGER `contable`.`cuenta_BEFORE_UPDATE` BEFORE UPDATE ON `cuenta` FOR EACH ROW
BEGIN
	set new.saldo = new.debe - new.haber;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `cuenta_mayor_auxiliar`
--

DROP TABLE IF EXISTS `cuenta_mayor_auxiliar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cuenta_mayor_auxiliar` (
  `idcuenta_mayor_auxiliar` int(11) NOT NULL AUTO_INCREMENT,
  `idcuenta_mayor_principal` int(11) NOT NULL,
  `nombre` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `nomenclatura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `definicion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idcuenta_mayor_auxiliar`),
  KEY `fk_cuenta_mayor_auxiliar_idcuenta_mayor_principal_idx` (`idcuenta_mayor_principal`),
  CONSTRAINT `fk_cuenta_mayor_auxiliar_idcuenta_mayor_principal` FOREIGN KEY (`idcuenta_mayor_principal`) REFERENCES `cuenta_mayor_principal` (`idcuenta_mayor_principal`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=320 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cuenta_mayor_auxiliar`
--

LOCK TABLES `cuenta_mayor_auxiliar` WRITE;
/*!40000 ALTER TABLE `cuenta_mayor_auxiliar` DISABLE KEYS */;
INSERT INTO `cuenta_mayor_auxiliar` VALUES (6,6,'Efectivo en Casa Matriz','111.101.01','Efectivo en Casa Matriz','Activo'),(7,6,'Efectivo en Sucursales','111.101.02','','Activo'),(8,7,'Dólares','111.102.01','Dólares','Activo'),(9,7,'Euros','111.102.02','','Activo'),(10,7,'Otras Monedas','111.102.99','Otras Monedas','Activo'),(11,11,'Depósitos Monetarios','111.106.01','','Activo'),(12,11,'Depósitos de Ahorro','111.106.02','','Activo'),(13,11,'Depósitos a Plazo Fijo','111.106.03','','Activo'),(14,11,'Otros Depósitos a Corto Plazo','111.106.99','','Activo'),(15,9,'Otros Depósitos a Corto Plazo','111.104.99','','Activo'),(16,9,'Depósitos a Plazo Fijo','111.104.03','','Activo'),(17,9,'Depósitos de Ahorro','111.104.02','','Activo'),(18,9,'Depósitos Monetarios','111.104.01','','Activo'),(19,10,'Depósitos Monetarios','111.105.01','','Activo'),(20,10,'Depósitos de Ahorro','111.105.02','','Activo'),(21,10,'Depósitos a Plazo Fijo','111.105.03','','Activo'),(22,10,'Otros Depósitos a Corto Plazo','111.105.99','','Activo'),(23,8,'Caja Chica en Casa Matriz','111.103.01','','Activo'),(24,8,'Caja Chica en Sucursales','111.103.02','','Activo'),(25,12,'Inversiones en Titulos-Valores de Emisores Nacionales','111.107.01','','Activo'),(26,12,'Inversiones en Titulos-Valores de Emisores Extranjeros','111.107.02','','Activo'),(27,13,'Clientes Nacionales','112.101.01','','Activo'),(28,13,'Clientes del Extranjero','112.101.02','','Activo'),(29,14,'Boucher de Tarjetas de Crédito','112.102.01','','Activo'),(30,14,'Facturas Cambiares','112.102.02','','Activo'),(31,14,'Letras','112.102.03','','Activo'),(32,14,'Pagarés','112.102.04','','Activo'),(33,14,'Otros Documentos por Cobrar','112.102.05','','Activo'),(34,15,'Anticipo a Proveedores Nacionales','112.103.01','','Activo'),(35,15,'Anticipo a Proveedores del Extranjero','112.103.02','','Activo'),(36,16,'Deudores por Venta de Activos Inmovilizados','112.104.01','','Activo'),(37,16,'Deudores por Faltante de Caja','112.104.02','','Activo'),(38,16,'Otros Deudores','112.104.99','','Activo'),(39,17,'Préstamos a Empleados','112.105.01','','Activo'),(40,17,'Préstamos a Directivos y/o Gerentes','112.105.02','','Activo'),(41,17,'Préstamos a Accionistas','112.105.03','','Activo'),(42,17,'Anticipos Sobre Sueldos','112.105.04','','Activo'),(43,18,'Intereses por Cobrar','112.106.01','','Activo'),(44,19,'Alquileres por Cobrar','112.107.01','','Activo'),(45,20,'Comisiones por Cobrar','112.108.01','','Activo'),(46,21,'Reclamaciones a Terceros','112.109.01','','Activo'),(47,21,'Depósitos Aduanales SAT','112.109.02','','Activo'),(48,21,'Otras Cuentas por Cobrar','112.109.99','','Activo'),(49,22,'IVA Crédito en Compras Locales','112.110.01','','Activo'),(50,22,'IVA Crédito en Importaciones','112.110.02','','Activo'),(51,23,'IVA Retenciones por Compensar','112.111.01','','Activo'),(52,24,'ISR por Cobrar','112.112.01','','Activo'),(53,24,'ISO Crédito Fiscal','112.112.02','','Activo'),(54,24,'Otros Créditos Fiscales','112.112.99','','Activo'),(55,25,'Impuesto Sobre la Renta Pagado Anticipado','113.101.01','','Activo'),(56,26,'Seguros Pagados por Anticipado','113.102.01','','Activo'),(57,27,'Alquileres Pagados por Anticipado','113.103.01','','Activo'),(58,28,'Intereses Pagados por Anticipado','113.104.01','','Activo'),(59,29,'Comisiones Pagadas por Anticipado','113.105.01','','Activo'),(60,30,'Publicidad Pagadas por Anticipada','113.106.01','','Activo'),(61,31,'Al Costo','114.101.01','','Activo'),(62,31,'A su Valor Neto Realizable','114.101.02','','Activo'),(63,32,'A su Valor Neto Realizable','114.102.02','A su Valor Neto Realizable','Activo'),(64,32,'Al Costo','114.102.01','Al Costo','Activo'),(65,33,'A su Valor Neto Realizable','114.103.02','A su Valor Neto Realizable','Activo'),(66,33,'Al Costo','114.103.01','Al Costo','Activo'),(67,34,'A su Valor Neto Realizable','114.104.02','A su Valor Neto Realizable','Activo'),(68,34,'Al Costo','114.104.01','Al Costo','Activo'),(69,35,'Mercancías en Tránsito','114.105.01','','Activo'),(70,36,'Mercaderías en Aduana','114.106.01','','Activo'),(71,37,'Papelería y Útiles','114.107.01','','Activo'),(72,38,'Suministros y Repuestos','114.108.01','','Activo'),(73,39,'Material de Empaque','114.109.01','','Activo'),(74,40,'Valores Emitidos y Garantizados por Entidades Estatales','121.101.01','','Activo'),(75,40,'Valores Emitidos por el Sistema Financiero Privado','121.101.02','','Activo'),(76,40,'Valores Emitidos por Empresas No Financieras Privadas','121.101.03','','Activo'),(77,40,'Valores Emitidos por Gobiernos Extranjeros','121.101.04','','Activo'),(78,40,'Valores Emitidos por Empresas Privadas del Extranjero','121.101.05','','Activo'),(79,41,'Preparación del Terreno','122.102.01','','Activo'),(80,41,'Construcción en Curso','122.102.02','','Activo'),(81,42,'Costo','122.103.01','','Activo'),(82,42,'Valor por Revaluación','122.103.02','','Activo'),(83,43,'Mobiliario','122.104.01','','Activo'),(84,43,'Equipo Electrónico','122.104.02','','Activo'),(85,43,'Equipo de Comunicación','122.104.03','','Activo'),(86,43,'Equipo de Seguridad','122.104.04','','Activo'),(87,44,'Costo','122.105.01','','Activo'),(88,44,'Valor por Revaluación','122.105.02','','Activo'),(89,46,'Costo','122.107.01','','Activo'),(90,46,'Valor por Revaluación','122.107.02','','Activo'),(91,47,'Costo','122.108.01','','Activo'),(92,47,'Valor por Revaluación','122.108.02','','Activo'),(93,48,'Costo','122.109.01','','Activo'),(94,48,'Valor por Revaluación','122.109.02','','Activo'),(95,49,'Costo','122.199.01','','Activo'),(96,49,'Valor por Revaluación','122.199.02','','Activo'),(97,50,'Costo','123.101.01','','Activo'),(98,50,'Valor por Revaluación','123.101.02','','Activo'),(99,51,'Costo','123.102.01','','Activo'),(100,51,'Valor por Revaluación','123.102.02','','Activo'),(101,52,'Costo','123.103.01','','Activo'),(102,52,'Valor por Revaluación','123.103.02','','Activo'),(103,53,'Costo','123.104.01','','Activo'),(104,53,'Valor por Revaluación','123.104.02','','Activo'),(105,54,'Costo','123.105.01','','Activo'),(106,54,'Valor por Revaluación','123.105.02','','Activo'),(107,55,'Crédito o Plusvalía Mercantil','123.106.01','','Activo'),(108,56,'Otros Activos Intangibles','123.199.01','','Activo'),(109,57,'Gastos de Organización','124.101.01','','Activo'),(110,58,'Gastos de Instalación y Remodelación','124.102.01','','Activo'),(111,59,'ISR Diferido','124.103.01','','Activo'),(112,60,'Provisión para Cuentas Incobrables','211.101.01','','Activo'),(113,61,'Depreciación Acumulada Vehículos','212.101.01','','Activo'),(114,62,'Depreciación Acumulada Edificios','212.102.01','','Activo'),(115,63,'Depreciación Acumulada Mobiliario y Equipo','212.103.01','','Activo'),(116,64,'Depreciación Acumulada Equipo de Cómputo','212.104.01','','Activo'),(117,65,'Depreciación Acumulada Programas y Licencias','212.105.01','','Activo'),(118,66,'Depreciación Acumulada Maquinaria','212.106.01','','Activo'),(119,67,'Depreciación Acumulada Herramientas','212.107.01','','Activo'),(120,68,'Otras Depreciaciones Acumuladas','212.199.01','','Activo'),(121,69,'Amortización Acumulada Concesiones y Franquicias','213.101.01','','Activo'),(122,70,'Amortización Acumulada Licencias','213.102.01','','Activo'),(123,71,'Amortización Acumulada Derechos de Llave','213.103.01','','Activo'),(124,72,'Amortización Acumulada Marcas','213.104.01','','Activo'),(125,73,'Amortización Acumulada Patentes','213.105.01','','Activo'),(126,74,'Amortización Acumulada Crédito Mercantil','213.106.01','','Activo'),(127,75,'Amortización Acumulada Gastos de Organización','213.107.01','','Activo'),(128,76,'Amortización Acumulada Gastos de Instalación','213.108.01','','Activo'),(129,77,'Otras Amortizaciones Acumuladas','213.199.01','','Activo'),(130,78,'Proveedores Nacionales','311.101.01','','Activo'),(131,78,'Proveedores del Extranjero','311.101.02','','Activo'),(132,79,'ISR por Pagar','311.103.01','','Activo'),(133,80,'ISR - Retenciones por Pagar','311.104.01','','Activo'),(134,81,'IVA Débito de Ventas','311.105.01','','Activo'),(135,81,'IVA Débito de Facturas Especiales','311.105.02','','Activo'),(136,82,'IVA - Retenciones por Pagar','311.106.01','','Activo'),(137,83,'ISO por Pagar','311.107.01','','Activo'),(138,83,'IUSI por Pagar','311.107.02','','Activo'),(139,83,'Impuestos Municipales por Pagar','311.107.03','','Activo'),(140,83,'Contribuciones por Pagar','311.107.04','','Activo'),(141,83,'Intereses y Multas por Pagar de Impuestos','311.107.05','','Activo'),(142,83,'Otros Impuestos y Contribuciones por Pagar','311.107.99','','Activo'),(143,84,'Sueldos Ordinarios y Extraordinarios por Pagar','311.108.01','','Activo'),(144,85,'Bonificaciones Incentivos por Pagar','311.109.01','','Activo'),(145,85,'Otras Bonificaciones por Pagar','311.109.99','','Activo'),(146,86,'Cuota Laboral IGSS por Pagar','311.110.01','','Activo'),(147,86,'Cuota Patronal (IGSS, IRTRA, INTECAP) por Pagar','311.110.02','','Activo'),(148,87,'Prestaciones Laborales por Pagar','311.111.01','','Activo'),(149,88,'Almacenadoras','311.112.01','','Activo'),(150,88,'Compañías de Seguros','311.112.02','','Activo'),(151,88,'Otros Acreedores','311.112.99','','Activo'),(152,89,'Intereses por Pagar','311.113.01','','Activo'),(153,90,'Comisiones por Pagar','311.114.01','','Activo'),(154,91,'Alquileres por Pagar','311.115.01','','Activo'),(155,92,'Facturas Cambiarias','311.116.01','','Activo'),(156,92,'Letras','311.116.02','','Activo'),(157,92,'Pagarés','311.116.03','','Activo'),(158,92,'Otros Documentos por Pagar','311.116.99','','Activo'),(159,93,'Préstamos en Moneda Nacional','311.117.01','','Activo'),(160,93,'Préstamos en Moneda Extranjera','311.117.02','','Activo'),(161,94,'Servicios Generales por pagar (Agua,electricidad,comunicaciones)','311.118.01','','Activo'),(162,94,'Otros Servicios y Cuentas por Pagar a Corto Plazo','311.118.99','','Activo'),(163,95,'Comisiones Cobradas Anticipadas','312.101.01','','Activo'),(164,96,'Intereses Cobrados Anticipados','312.102.01','','Activo'),(165,97,'Anticipos de Clientes Nacionales','312.103.01','','Activo'),(166,97,'Anticipos de Clientes del Extranjero','312.103.02','','Activo'),(167,98,'Dividendos por Pagar','312.104.01','','Activo'),(168,99,'Letras','321.101.01','','Activo'),(169,99,'Pagarés','321.101.02','','Activo'),(170,99,'Otros Documentos por Pagar a Largo Plazo','321.101.99','','Activo'),(171,100,'Préstamos en Moneda Nacional','321.102.01','','Activo'),(172,100,'Préstamos en Moneda Extranjera','321.102.02','','Activo'),(173,101,'Intereses Devengados No Percibidos','401.101.01','','Activo'),(174,104,'Capital Autorizado','511.101.01','','Activo'),(175,105,'Acciones por Suscribir','511.102.01','','Activo'),(176,105,'Suscriptores de Acciones','511.102.02','','Activo'),(177,106,'Reserva Legal Acumulada','512.101.01','','Activo'),(178,107,'Reserva para Futuros Dividendos','512.102.01','','Activo'),(179,108,'Reserva para Eventualidades','512.103.01','','Activo'),(180,109,'Otras Reservas de Capital','512.199.01','','Activo'),(181,110,'Revaluación de Inmuebles (+)','513.101.01','','Activo'),(182,111,'Revaluación de Bienes Muebles (+)','513.102.01','','Activo'),(183,112,'Pérdida por Bajas en el Valor de Mercado en Inversiones (-)','513.103.01','','Activo'),(184,113,'Pérdida en Negociación de Activos (-)','513.104.01','','Activo'),(185,114,'Ganancia por Altas en el Valor de Mercado en Inversiones (+)','513.105.01','','Activo'),(186,115,'Ganancia en Negociación de activos (+)','513.106.01','','Activo'),(187,121,'Mercaderías en Comisión P-C','611.101.01','','Activo'),(188,122,'Mercaderías en Consignación P-C','611.102.01','','Activo'),(189,125,'Ventas Locales','711.101.01','','Activo'),(190,125,'Ventas en el Exterior - Exportaciones','711.101.02','','Activo'),(191,126,'Devoluciones Sobre Ventas','711.102.01','','Activo'),(192,126,'Rebajas Sobre Ventas','711.102.02','','Activo'),(193,127,'Intereses Producto (Ganados o Cobrados)','712.101.01','','Activo'),(194,128,'Comisiones Cobradas','712.102.01','','Activo'),(195,129,'Alquileres Cobrados','712.103.01','','Activo'),(196,130,'Regalías Recibidas','712.104.01','','Activo'),(197,131,'Ganancias Cambiarias','712.105.01','','Activo'),(198,132,'Descuentos por Pronto Pago','712.106.01','','Activo'),(199,133,'Sobrantes de Caja','712.107.01','','Activo'),(200,134,'Créditos Recuperados','712.108.01','','Activo'),(201,135,'Otros Ingresos de Operación','712.199.01','','Activo'),(202,136,'Compras en el Mercado Local','810.101.01','','Activo'),(203,136,'Compras en el Extranjero-Importaciones','810.101.02','','Activo'),(204,137,'Devoluciones Sobre Compra de Materia Prima','810.102.01','','Activo'),(205,137,'Rebajas Sobre Compra de Materia Prima (-)','810.102.02','','Activo'),(206,138,'Impuestos Aduanales','810.103.01','','Activo'),(207,138,'Fletes Sobre Compra','810.103.02','','Activo'),(208,138,'Seguros Contra Riesgo de Transporte','810.103.03','','Activo'),(209,138,'Otros Gastos de Compra','810.103.99','','Activo'),(210,139,'Sueldos Ordinarios y Extraordinarios de Fábrica','810.104.01','','Activo'),(211,139,'Sueldos Extraordinarios de Fábrica','810.104.02','','Activo'),(212,140,'Sueldos Ordinarios','810.105.01','','Activo'),(213,140,'Sueldos Extraordinarios','810.105.02','','Activo'),(214,141,'Bonificaciones Incentivo de Fábrica','810.106.01','Bonificaciones Incentivo de Fábrica','Activo'),(215,142,'Cuotas Patronales de Fábrica','810.107.01','Cuotas Patronales de Fábrica','Activo'),(216,143,'Alquileres de Fábrica','810.108.01','Alquileres de Fábrica','Activo'),(217,144,'Depreciación Mobiliario y Equipo de Fábrica','810.109.01','Depreciación Mobiliario y Equipo de Fábrica','Activo'),(218,145,'Depreciación Equipo de Cómputo de Fábrica','810.110.01','Depreciación Equipo de Cómputo de Fábrica','Activo'),(219,146,'Depreciación Maquinaria','810.111.01','Depreciación Maquinaria','Activo'),(220,147,'Depreciación de Herramientas','810.112.01','Depreciación de Herramientas','Activo'),(221,148,'Combustibles Consumidos Fábrica','810.113.01','Combustibles Consumidos Fábrica','Activo'),(222,149,'Material de Empaque Consumidos Fábrica','810.114.01','Material de Empaque Consumidos Fábrica','Activo'),(223,150,'Seguros Vencidos de Fábrica','810.115.01','Seguros Vencidos de Fábrica','Activo'),(224,151,'IUSI Pagado de Fábrica','810.116.01','IUSI Pagado de Fábrica','Activo'),(225,152,'Indemnización de Fábrica','810.117.01','','Activo'),(226,152,'Bono Legal (Bono 14) de Fábrica','810.117.02','','Activo'),(227,152,'Aguinaldos de Fábrica','810.117.03','','Activo'),(228,152,'Vacaciones de Fábrica','810.117.04','','Activo'),(229,153,'Energía Eléctrica','810.118.01','','Activo'),(230,153,'Agua','810.118.02','','Activo'),(231,153,'Comunicaciones','810.118.03','','Activo'),(232,153,'Extracción de Basura','810.118.04','','Activo'),(233,153,'Seguridad','810.118.05','','Activo'),(234,153,'Otros','810.118.99','','Activo'),(235,154,'Costo de Producción','810.119.01','','Activo'),(236,155,'Compras en el Mercado Local','811.101.01','','Activo'),(237,155,'Compras en el Extranjero-Importaciones','811.101.02','','Activo'),(238,156,'Devoluciones Sobre Compra','811.102.01','','Activo'),(239,156,'Rebajas Sobre Compra','811.102.02','','Activo'),(240,157,'Impuestos Aduanales','811.103.01','','Activo'),(241,157,'Fletes Sobre Compra','811.103.02','','Activo'),(242,157,'Seguros Contra Riesgo de Transporte','811.103.03','','Activo'),(243,157,'Otros Gastos de Compra','811.103.99','','Activo'),(244,158,'Costo de Venta','811.104.01','','Activo'),(245,159,'Sueldos Ordinarios','812.101.01','Sueldos y Salarios de Vendedores','Activo'),(246,160,'Comisiones Sobre Ventas','812.102.01','Comisiones Sobre Ventas','Activo'),(247,161,'Bonificaciones Sobre Ventas','812.103.01','Bonificaciones Sobre Ventas','Activo'),(248,162,'IGSS','812.104.01','Cuotas Patronales de Vendedores','Activo'),(249,163,'Indemnización de Vendedores','812.105.01','Prestaciones Laborales de Vendedores','Activo'),(250,164,'Alquileres Sala de Venta o Locales Comerciales','812.106.01','Alquileres Sala de Venta o Locales Comerciale','Activo'),(251,165,'IUSI Sala de Venta','812.107.01','IUSI Sala de Venta','Activo'),(252,166,'Depreciación Vehículos de Reparto','812.108.01','Depreciación Vehículos de Reparto','Activo'),(253,167,'Depreciación Edificios Sala de Venta','812.109.01','Depreciación Edificios Sala de Venta','Activo'),(254,168,'Depreciación Mobiliario y Equipo Sala de Venta','812.110.01','Depreciación Mobiliario y Equipo Sala de Vent','Activo'),(255,169,'Depreciación Equipo de Computación Sala de Venta','812.111.01','Depreciación Equipo de Computación Sala de Ve','Activo'),(256,170,'Amortización Gastos de Instalación Sala de Venta','812.112.01','Amortización Gastos de Instalación Sala de Ve','Activo'),(257,171,'Gastos de Publicidad - Publicidad y Propaganda','812.113.01','Gastos de Publicidad - Publicidad y Propagand','Activo'),(258,172,'Material de Empaque Consumido','812.114.01','Material de Empaque Consumido','Activo'),(259,173,'Fletes y Acarreos de Venta','812.115.01','Fletes y Acarreos de Venta','Activo'),(260,174,'Seguros Vencidos de Sala de Ventas','812.116.01','Seguros Vencidos de Sala de Ventas','Activo'),(261,175,'Alquileres Vencidos Sala de Venta','812.117.01','Alquileres Vencidos Sala de Venta','Activo'),(262,176,'Cuota Incobrables','812.118.01','Cuota Incobrables','Activo'),(263,177,'Combustibles Consumidos','812.119.01','Combustibles Consumidos','Activo'),(264,178,'Agua','812.120.01','Agua','Activo'),(265,179,'Otros Gastos de Distribución','812.199.01','Otros Gastos de Distribución','Activo'),(266,159,'Sueldos Extraordinarios','812.101.02','','Activo'),(267,162,'IRTRA','812.104.02','','Activo'),(268,162,'INTECAP','812.104.03','','Activo'),(269,163,'Bono Legal (Bono 14) de Vendedores','812.105.02','','Activo'),(270,163,'Aguinaldos de Vendedores','812.105.03','','Activo'),(271,163,'Vacaciones de Vendedores','812.105.04','','Activo'),(272,178,'Energía Eléctrica','812.120.02','','Activo'),(273,178,'Comunicaciones (telefonía, internet, otros)','812.120.03','','Activo'),(274,181,'Bonificaciones Incentivos Personal Administrativo','813.102.01','Bonificaciones Incentivos Personal Administra','Activo'),(275,182,'IGSS','813.103.01','IGSS','Activo'),(276,183,'Indemnización de Personal Administrativo','813.104.01','Indemnización de Personal Administrativo','Activo'),(277,184,'Alquileres de Oficinas y Bodegas','813.105.01','Alquileres de Oficinas y Bodegas','Activo'),(278,185,'IUSI de Oficinas','813.106.01','IUSI de Oficinas','Activo'),(279,186,'Depreciación Vehículos de Oficina','813.107.01','Depreciación Vehículos de Oficina','Activo'),(280,187,'Depreciación Edificios de Oficina','813.108.01','Depreciación Edificios de Oficina','Activo'),(281,188,'Depreciación Mobiliario y Equipo de Oficina','813.109.01','Depreciación Mobiliario y Equipo de Oficina','Activo'),(282,189,'Depreciación Equipo de Computación de Oficina','813.110.01','Depreciación Equipo de Computación de Oficina','Activo'),(283,190,'Amortización Gastos de Origanización','813.111.01','Amortización Gastos de Origanización','Activo'),(284,191,'Amortización Concesiones y Franquicias','813.112.01','Amortización Concesiones y Franquicias','Activo'),(285,192,'Amortización Licencias','813.113.01','Amortización Licencias','Activo'),(286,193,'Amortización Derecho de Llave','813.114.01','Amortización Derecho de Llave','Activo'),(287,194,'Amortización Marcas y Patentes','813.115.01','Amortización Marcas y Patentes','Activo'),(288,195,'Amortización Crédito Mercantil','813.116.01','Amortización Crédito Mercantil','Activo'),(289,196,'Amortización Gastos de Instalación de Oficina','813.117.01','Amortización Gastos de Instalación de Oficina','Activo'),(290,197,'Papelería y Útiles Consumidos','813.118.01','Papelería y Útiles Consumidos','Activo'),(291,198,'Suministros y Repuestos Consumidos','813.119.01','Suministros y Repuestos Consumidos','Activo'),(292,199,'Agua','813.120.01','Agua','Activo'),(293,200,'Servicios de Vigilancia y Seguridad','813.121.01','Servicios de Vigilancia y Seguridad','Activo'),(294,201,'Gastos de Organización','813.122.01','Gastos de Organización','Activo'),(295,202,'Seguros Vencidos','813.123.01','Seguros Vencidos','Activo'),(296,203,'Alquileres Vencidos de Oficina','813.124.01','Alquileres Vencidos de Oficina','Activo'),(297,204,'Otros Gastos de Administración','813.199.01','Otros Gastos de Administración','Activo'),(298,180,'Sueldos Ordinarios','813.101.01','','Activo'),(299,180,'Sueldos Extraordinarios','813.101.02','','Activo'),(300,182,'IRTRA','813.103.02','','Activo'),(301,182,'INTECAP','813.103.03','','Activo'),(302,183,'Bono Legal (Bono 14) de Personal Administrativo','813.104.02','','Activo'),(303,183,'Aguinaldos de Personal Administrativo','813.104.03','','Activo'),(304,183,'Vacaciones de Personal Administrativo','813.104.04','','Activo'),(305,199,'Energía Eléctrica','813.120.02','','Activo'),(306,199,'Comunicaciones (telefonía, internet, otros)','813.120.03','','Activo'),(307,200,'Servicios de Limpieza y Extracción de Basura','813.121.02','','Activo'),(308,200,'Servicios de Fontanería, Albañilería y Electricidad','813.121.03','','Activo'),(309,200,'Servicios de Mensajería y Correos','813.121.04','','Activo'),(310,200,'Otros Servicios','813.121.99','','Activo'),(311,206,'Pérdida Cambiaria','814.102.01','Pérdida Cambiaria','Activo'),(312,207,'Bajas y Pérdida de Inventario','814.103.01','Bajas y Pérdida de Inventario','Activo'),(313,208,'Faltantes de Caja','814.104.01','Faltantes de Caja','Activo'),(314,209,'Donaciones','814.105.01','Donaciones','Activo'),(315,210,'Impuestos Pagados','814.106.01','Impuestos Pagados','Activo'),(316,211,'Multas y Recargos','814.107.01','Multas y Recargos','Activo'),(317,212,'Otros Gastos','814.199.01','Otros Gastos','Activo'),(318,205,'Intereses Bancarios','814.101.01','','Activo'),(319,205,'Intereses Comerciales','814.101.02','','Activo');
/*!40000 ALTER TABLE `cuenta_mayor_auxiliar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cuenta_mayor_principal`
--

DROP TABLE IF EXISTS `cuenta_mayor_principal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cuenta_mayor_principal` (
  `idcuenta_mayor_principal` int(11) NOT NULL AUTO_INCREMENT,
  `idsubgrupo_cuenta` int(11) NOT NULL,
  `nombre` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `nomenclatura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `definicion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idcuenta_mayor_principal`),
  KEY `fk_cuenta_mayor_principal_idsubgrupo_cuenta_idx` (`idsubgrupo_cuenta`),
  CONSTRAINT `fk_cuenta_mayor_principal_idsubgrupo_cuenta` FOREIGN KEY (`idsubgrupo_cuenta`) REFERENCES `subgrupo_cuenta` (`idsubgrupo_cuenta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=213 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cuenta_mayor_principal`
--

LOCK TABLES `cuenta_mayor_principal` WRITE;
/*!40000 ALTER TABLE `cuenta_mayor_principal` DISABLE KEYS */;
INSERT INTO `cuenta_mayor_principal` VALUES (6,6,'Caja Moneda Nacional','111.101','Caja Moneda Nacional','Activo'),(7,6,'Caja Moneda Extranjera','111.102','','Activo'),(8,6,'Caja Chica','111.103','','Activo'),(9,6,'Bancos del País Moneda Nacional','111.104','','Activo'),(10,6,'Bancos del País Moneda Extranjera','111.105','','Activo'),(11,6,'Bancos del Exterior','111.106','','Activo'),(12,6,'Inversiones a Corto Plazo','111.107','','Activo'),(13,7,'Cuentas por Cobrar Comerciales','112.101','','Activo'),(14,7,'Documentos por Cobrar','112.102','','Activo'),(15,7,'Anticipo a Proveedores','112.103','','Activo'),(16,7,'Cuentas por Cobrar No Comerciales','112.104','','Activo'),(17,7,'Prestamos y Anticipos a Personal','112.105','','Activo'),(18,7,'Intereses por Cobrar','112.106','','Activo'),(19,7,'Alquileres por Cobrar','112.107','','Activo'),(20,7,'Comisiones por Cobrar','112.108','','Activo'),(21,7,'Otras Cuentas por Cobrar','112.109','','Activo'),(22,7,'IVA Crédito Fiscal','112.110','','Activo'),(23,7,'IVA Retenciones por Compensar','112.111','','Activo'),(24,7,'Otros Créditos Fiscales','112.112','','Activo'),(25,8,'Impuesto Sobre la Renta Pagado Anticipado','113.101','','Activo'),(26,8,'Seguros Pagados por Anticipado','113.102','','Activo'),(27,8,'Alquileres Pagados por Anticipado','113.103','','Activo'),(28,8,'Intereses Pagados por Anticipado','113.104','','Activo'),(29,8,'Comisiones Pagadas por Anticipado','113.105','','Activo'),(30,8,'Publicidad Pagadas por Anticipada','113.106','','Activo'),(31,9,'Inventario de Mercaderías','114.101','','Activo'),(32,9,'Inventario de Materia Prima','114.102','','Activo'),(33,9,'Inventario de Artículos en Proceso','114.103','','Activo'),(34,9,'Inventario de Artículos Terminados','114.104','','Activo'),(35,9,'Mercancías en Tránsito','114.105','','Activo'),(36,9,'Mercaderías en Aduana','114.106','','Activo'),(37,9,'Papelería y Útiles','114.107','','Activo'),(38,9,'Suministros y Repuestos','114.108','','Activo'),(39,9,'Material de Empaque','114.109','','Activo'),(40,10,'Inversión en Títulos-Valores al Vencimiento','121.101','','Activo'),(41,11,'Construcciones en Proceso','122.102','','Activo'),(42,11,'Terrenos','122.103','','Activo'),(43,11,'Mobiliario y Equipo','122.104','','Activo'),(44,11,'Equipo de Computación','122.105','','Activo'),(45,11,'Programas y Licencias de Computación','122.106','','Activo'),(46,11,'Vehículos','122.107','','Activo'),(47,11,'Maquinaria','122.108','','Activo'),(48,11,'Herramientas','122.109','','Activo'),(49,11,'Otros Equipos Inmovilizados','122.199','','Activo'),(50,12,'Concesiones y Franquicias','123.101','','Activo'),(51,12,'Licencias','123.102','','Activo'),(52,12,'Derecho de Llave','123.103','','Activo'),(53,12,'Marcas','123.104','','Activo'),(54,12,'Patentes','123.105','','Activo'),(55,12,'Crédito o Plusvalía Mercantil','123.106','','Activo'),(56,12,'Otros Activos Intangibles','123.199','','Activo'),(57,13,'Gastos de Organización','124.101','','Activo'),(58,13,'Gastos de Instalación y Remodelación','124.102','','Activo'),(59,13,'ISR Diferido','124.103','','Activo'),(60,14,'Provisión para Cuentas Incobrables','211.101','','Activo'),(61,15,'Depreciación Acumulada Vehículos','212.101','','Activo'),(62,15,'Depreciación Acumulada Edificios','212.102','','Activo'),(63,15,'Depreciación Acumulada Mobiliario y Equipo','212.103','','Activo'),(64,15,'Depreciación Acumulada Equipo de Cómputo','212.104','','Activo'),(65,15,'Depreciación Acumulada Programas y Licencias','212.105','','Activo'),(66,15,'Depreciación Acumulada Maquinaria','212.106','','Activo'),(67,15,'Depreciación Acumulada Herramientas','212.107','','Activo'),(68,15,'Otras Depreciaciones Acumuladas','212.199','','Activo'),(69,16,'Amortización Acumulada Concesiones y Franquicias','213.101','','Activo'),(70,16,'Amortización Acumulada Licencias','213.102','','Activo'),(71,16,'Amortización Acumulada Derechos de Llave','213.103','','Activo'),(72,16,'Amortización Acumulada Marcas','213.104','','Activo'),(73,16,'Amortización Acumulada Patentes','213.105','','Activo'),(74,16,'Amortización Acumulada Crédito Mercantil','213.106','','Activo'),(75,16,'Amortización Acumulada Gastos de Organización','213.107','','Activo'),(76,16,'Amortización Acumulada Gastos de Instalación','213.108','','Activo'),(77,16,'Otras Amortizaciones Acumuladas','213.199','','Activo'),(78,17,'Cuentas por Pagar Comerciales - Proveedores','311.101','','Activo'),(79,17,'Impuesto Sobre la Renta por Pagar','311.103','','Activo'),(80,17,'ISR - Retenciones por Pagar','311.104','','Activo'),(81,17,'IVA Débito Fiscal','311.105','','Activo'),(82,17,'IVA - Retenciones por Pagar','311.106','','Activo'),(83,17,'Otros Impuestos y Contribuciones por Pagar','311.107','','Activo'),(84,17,'Sueldos y Salarios por Pagar','311.108','','Activo'),(85,17,'Bonificaciones por Pagar','311.109','','Activo'),(86,17,'Cuotas Patronales y Laborales por Pagar','311.110','','Activo'),(87,17,'Prestaciones Laborales por Pagar','311.111','','Activo'),(88,17,'Cuentas por Pagar No Comerciales - Acreedores Varios','311.112','','Activo'),(89,17,'Intereses por Pagar','311.113','','Activo'),(90,17,'Comisiones por Pagar','311.114','','Activo'),(91,17,'Alquileres por Pagar','311.115','','Activo'),(92,17,'Documentos por Pagar a Corto Plazo','311.116','','Activo'),(93,17,'Préstamos a Corto Plazo','311.117','Préstamos a Corto Plazo','Activo'),(94,17,'Otras Cuentas por Pagar a Corto Plazo','311.118','','Activo'),(95,18,'Comisiones Cobradas Anticipadas','312.101','','Activo'),(96,18,'Intereses Cobrados Anticipados','312.102','','Activo'),(97,18,'Anticipos de Clientes','312.103','','Activo'),(98,18,'Dividendos por Pagar','312.104','','Activo'),(99,19,'Documentos por Pagar a Largo Plazo','321.101','','Activo'),(100,19,'Préstamos a Largo Plazo','321.102','','Activo'),(101,20,'Intereses Devengados No Percibidos','401.101','','Activo'),(102,20,'Comisiones Devengadas No Percibidas','401.102','','Activo'),(103,20,'Reserva para Prestaciones Laborales','401.103','','Activo'),(104,21,'Capital Autorizado','511.101','','Activo'),(105,21,'Capital No Pagado (-)','511.102','','Activo'),(106,22,'Reserva Legal Acumulada','512.101','','Activo'),(107,22,'Reserva para Futuros Dividendos','512.102','','Activo'),(108,22,'Reserva para Eventualidades','512.103','','Activo'),(109,22,'Otras Reservas de Capital','512.199','','Activo'),(110,23,'Revaluación de Inmuebles (+)','513.101','','Activo'),(111,23,'Revaluación de Bienes Muebles (+)','513.102','','Activo'),(112,23,'Pérdida por Bajas en el Valor de Mercado en Inversiones (-)','513.103','','Activo'),(113,23,'Pérdida en Negociación de Activos (-)','513.104','','Activo'),(114,23,'Ganancia por Altas en el Valor de Mercado en Inversiones (+)','513.105','','Activo'),(115,23,'Ganancia en Negociación de activos (+)','513.106','','Activo'),(116,24,'Utilidades Acumuladas','514.101','','Activo'),(117,24,'Pérdidas Acumuladas','514.102','','Activo'),(118,24,'Pérdidas y Ganancias','514.103','','Activo'),(119,24,'Utilidades a Repartir','514.104','','Activo'),(120,24,'Pérdidas por Repartir','514.105','','Activo'),(121,25,'Mercaderías en Comisión P-C','611.101','','Activo'),(122,25,'Mercaderías en Consignación P-C','611.102','','Activo'),(123,26,'Comitentes por Mercaderías P-C','612.101','','Activo'),(124,26,'Ventas por Realizar P-C','612.102','','Activo'),(125,27,'Ventas Brutas','711.101','','Activo'),(126,27,'Devoluciones y Rebajas Sobre Ventas (-)','711.102','','Activo'),(127,28,'Intereses Producto (Ganados o Cobrados)','712.101','','Activo'),(128,28,'Comisiones Cobradas','712.102','','Activo'),(129,28,'Alquileres Cobrados','712.103','','Activo'),(130,28,'Regalías Recibidas','712.104','','Activo'),(131,28,'Ganancias Cambiarias','712.105','','Activo'),(132,28,'Descuentos por Pronto Pago','712.106','','Activo'),(133,28,'Sobrantes de Caja','712.107','','Activo'),(134,28,'Créditos Recuperados','712.108','','Activo'),(135,28,'Otros Ingresos de Operación','712.199','','Activo'),(136,29,'Compras de Materia Prima','810.101','','Activo'),(137,29,'Devoluciones y Rebajas Sobre Compra de Materia Prima (-)','810.102','','Activo'),(138,29,'Gastos Sobre Compra de Materia Prima','810.103','','Activo'),(139,29,'Mano de Obra Directa','810.104','','Activo'),(140,29,'Mano de Obra Indirecta','810.105','','Activo'),(141,29,'Bonificaciones Incentivo de Fábrica','810.106','','Activo'),(142,29,'Cuotas Patronales de Fábrica','810.107','','Activo'),(143,29,'Alquileres de Fábrica','810.108','','Activo'),(144,29,'Depreciación Mobiliario y Equipo de Fábrica','810.109','','Activo'),(145,29,'Depreciación Equipo de Cómputo de Fábrica','810.110','','Activo'),(146,29,'Depreciación Maquinaria','810.111','','Activo'),(147,29,'Depreciación de Herramientas','810.112','','Activo'),(148,29,'Combustibles Consumidos Fábrica','810.113','','Activo'),(149,29,'Material de Empaque Consumidos Fábrica','810.114','','Activo'),(150,29,'Seguros Vencidos de Fábrica','810.115','','Activo'),(151,29,'IUSI Pagado de Fábrica','810.116','','Activo'),(152,29,'Prestaciones Laborales de Fábrica','810.117','','Activo'),(153,29,'Gastos Diversos de Fábrica','810.118','','Activo'),(154,29,'Costo de Producción','810.119','','Activo'),(155,30,'Compras','811.101','','Activo'),(156,30,'Devoluciones y Rebajas Sobre Compra (-)','811.102','','Activo'),(157,30,'Gastos Sobre Compra','811.103','','Activo'),(158,30,'Costo de Venta','811.104','','Activo'),(159,31,'Sueldos y Salarios de Vendedores','812.101','','Activo'),(160,31,'Comisiones Sobre Ventas','812.102','','Activo'),(161,31,'Bonificaciones Sobre Ventas','812.103','','Activo'),(162,31,'Cuotas Patronales de Vendedores','812.104','','Activo'),(163,31,'Prestaciones Laborales de Vendedores','812.105','','Activo'),(164,31,'Alquileres Sala de Venta o Locales Comerciales','812.106','','Activo'),(165,31,'IUSI Sala de Venta','812.107','','Activo'),(166,31,'Depreciación Vehículos de Reparto','812.108','','Activo'),(167,31,'Depreciación Edificios Sala de Venta','812.109','','Activo'),(168,31,'Depreciación Mobiliario y Equipo Sala de Venta','812.110','','Activo'),(169,31,'Depreciación Equipo de Computación Sala de Venta','812.111','','Activo'),(170,31,'Amortización Gastos de Instalación Sala de Venta','812.112','','Activo'),(171,31,'Gastos de Publicidad - Publicidad y Propaganda','812.113','','Activo'),(172,31,'Material de Empaque Consumido','812.114','','Activo'),(173,31,'Fletes y Acarreos de Venta','812.115','','Activo'),(174,31,'Seguros Vencidos de Sala de Ventas','812.116','','Activo'),(175,31,'Alquileres Vencidos Sala de Venta','812.117','','Activo'),(176,31,'Cuota Incobrables','812.118','','Activo'),(177,31,'Combustibles Consumidos','812.119','','Activo'),(178,31,'Gastos Diversos Sala de Venta','812.120','','Activo'),(179,31,'Otros Gastos de Distribución','812.199','','Activo'),(180,32,'Sueldos y Salarios de Personal Administrativo','813.101','','Activo'),(181,32,'Bonificaciones Incentivos Personal Administrativo','813.102','','Activo'),(182,32,'Cuotas Patronales de Personal Administrativo','813.103','','Activo'),(183,32,'Prestaciones Laborales de Personal Administrativo','813.104','','Activo'),(184,32,'Alquileres de Oficinas y Bodegas','813.105','','Activo'),(185,32,'IUSI de Oficinas','813.106','','Activo'),(186,32,'Depreciación Vehículos de Oficina','813.107','','Activo'),(187,32,'Depreciación Edificios de Oficina','813.108','','Activo'),(188,32,'Depreciación Mobiliario y Equipo de Oficina','813.109','','Activo'),(189,32,'Depreciación Equipo de Computación de Oficina','813.110','','Activo'),(190,32,'Amortización Gastos de Origanización','813.111','','Activo'),(191,32,'Amortización Concesiones y Franquicias','813.112','','Activo'),(192,32,'Amortización Licencias','813.113','','Activo'),(193,32,'Amortización Derecho de Llave','813.114','','Activo'),(194,32,'Amortización Marcas y Patentes','813.115','','Activo'),(195,32,'Amortización Crédito Mercantil','813.116','','Activo'),(196,32,'Amortización Gastos de Instalación de Oficina','813.117','','Activo'),(197,32,'Papelería y Útiles Consumidos','813.118','','Activo'),(198,32,'Suministros y Repuestos Consumidos','813.119','','Activo'),(199,32,'Gastos Diversos','813.120','','Activo'),(200,32,'Servicios Varios','813.121','','Activo'),(201,32,'Gastos de Organización','813.122','','Activo'),(202,32,'Seguros Vencidos','813.123','','Activo'),(203,32,'Alquileres Vencidos de Oficina','813.124','','Activo'),(204,32,'Otros Gastos de Administración','813.199','','Activo'),(205,33,'Intereses Gasto','814.101','','Activo'),(206,33,'Pérdida Cambiaria','814.102','','Activo'),(207,33,'Bajas y Pérdida de Inventario','814.103','','Activo'),(208,33,'Faltantes de Caja','814.104','','Activo'),(209,33,'Donaciones','814.105','','Activo'),(210,33,'Impuestos Pagados','814.106','','Activo'),(211,33,'Multas y Recargos','814.107','','Activo'),(212,33,'Otros Gastos','814.199','','Activo');
/*!40000 ALTER TABLE `cuenta_mayor_principal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresa`
--

DROP TABLE IF EXISTS `empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empresa` (
  `idempresa` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nit` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  `idpais` int(11) DEFAULT NULL,
  PRIMARY KEY (`idempresa`),
  KEY `fk_empresa_idpais_idx` (`idpais`),
  CONSTRAINT `fk_empresa_idpais` FOREIGN KEY (`idpais`) REFERENCES `pais` (`idpais`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` VALUES (1,'Distribuidora Carlos','ciudad','22312','Activo',1);
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo_cuenta`
--

DROP TABLE IF EXISTS `grupo_cuenta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo_cuenta` (
  `idgrupo_cuenta` int(11) NOT NULL AUTO_INCREMENT,
  `idclase_cuenta` int(11) NOT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `nomenclatura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `definicion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idgrupo_cuenta`),
  KEY `fk_grupo_cuenta_idclase_cuenta_idx` (`idclase_cuenta`),
  CONSTRAINT `fk_grupo_cuenta_idclase_cuenta` FOREIGN KEY (`idclase_cuenta`) REFERENCES `clase_cuenta` (`idclase_cuenta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_cuenta`
--

LOCK TABLES `grupo_cuenta` WRITE;
/*!40000 ALTER TABLE `grupo_cuenta` DISABLE KEYS */;
INSERT INTO `grupo_cuenta` VALUES (1,1,'Activo Corriente','11','Corriente','Activo'),(2,1,'No Corriente','12','No Corriente','Activo'),(3,2,'Prevision para cuentas incobrables, depreciac','21','Prevision para cuentas incobrables, depreciac','Activo'),(4,3,'Corriente ','31','Corriente ','Activo'),(5,3,'No Corriente','32','No Corriente','Activo'),(6,4,'Otras Cuentas Acreedoras','40','','Activo'),(7,5,'Capital, Reservas y Resultados','51','','Activo'),(8,6,'Cuentas de Orden per Contra','61','','Activo'),(9,7,'Ingresos','71','','Activo'),(10,8,'Gastos de Operación','81','','Activo');
/*!40000 ALTER TABLE `grupo_cuenta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pais`
--

DROP TABLE IF EXISTS `pais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pais` (
  `idpais` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  PRIMARY KEY (`idpais`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pais`
--

LOCK TABLES `pais` WRITE;
/*!40000 ALTER TABLE `pais` DISABLE KEYS */;
INSERT INTO `pais` VALUES (1,'Guatemala','Activo','2016-03-01 23:20:57');
/*!40000 ALTER TABLE `pais` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `contable`.`pais_BEFORE_INSERT` BEFORE INSERT ON `pais` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `partida`
--

DROP TABLE IF EXISTS `partida`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partida` (
  `idpartida` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `idcuenta_cargo` int(11) NOT NULL,
  `idcuenta_abono` int(11) NOT NULL,
  `monto` decimal(10,0) NOT NULL DEFAULT '0',
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  `descripcion` varchar(128) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idpartida`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partida`
--

LOCK TABLES `partida` WRITE;
/*!40000 ALTER TABLE `partida` DISABLE KEYS */;
INSERT INTO `partida` VALUES (1,'2016-01-04',2,1,250,'Activo','deposito al banco no 323i9'),(2,'2016-02-16',2,1,100,'Activo','factura'),(3,NULL,2,1,500,'Activo','deposito numero io23849230');
/*!40000 ALTER TABLE `partida` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`%`*/ /*!50003 TRIGGER `contable`.`partida_BEFORE_INSERT` BEFORE INSERT ON `partida` FOR EACH ROW
BEGIN
	call pr_cargar_cuenta(new.idcuenta_cargo,new.monto);
	call pr_abonar_cuenta(new.idcuenta_abono,new.monto);

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `persona`
--

DROP TABLE IF EXISTS `persona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `persona` (
  `idpersona` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_persona` enum('Individual','Juridica') NOT NULL DEFAULT 'Individual',
  `nombre` varchar(45) DEFAULT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  `cui` varchar(45) DEFAULT NULL,
  `idpais` int(11) NOT NULL DEFAULT '1',
  `fecha_nacimiento` date DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `sexo` enum('Masculino','Femenino') NOT NULL DEFAULT 'Masculino',
  `fecha_insercion` datetime DEFAULT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idpersona`),
  KEY `fk_persona_idpais_idx` (`idpais`),
  CONSTRAINT `fk_persona_idpais` FOREIGN KEY (`idpais`) REFERENCES `pais` (`idpais`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona`
--

LOCK TABLES `persona` WRITE;
/*!40000 ALTER TABLE `persona` DISABLE KEYS */;
INSERT INTO `persona` VALUES (1,'Individual','Nestor José','Fock Aguirre','ciudad','3123123',1,'2016-03-01','njfock@hotmail.com','Masculino','2016-03-01 23:24:23','Activo');
/*!40000 ALTER TABLE `persona` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `contable`.`persona_BEFORE_INSERT` BEFORE INSERT ON `persona` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `subcuenta`
--

DROP TABLE IF EXISTS `subcuenta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subcuenta` (
  `idsubcuenta` int(11) NOT NULL AUTO_INCREMENT,
  `idcuenta_mayor_auxiliar` int(11) NOT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `nomenclatura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `definicion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idsubcuenta`),
  KEY `fk_subcuenta_idcuenta_mayor_auxiliar_idx` (`idcuenta_mayor_auxiliar`),
  CONSTRAINT `fk_subcuenta_idcuenta_mayor_auxiliar` FOREIGN KEY (`idcuenta_mayor_auxiliar`) REFERENCES `cuenta_mayor_auxiliar` (`idcuenta_mayor_auxiliar`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subcuenta`
--

LOCK TABLES `subcuenta` WRITE;
/*!40000 ALTER TABLE `subcuenta` DISABLE KEYS */;
/*!40000 ALTER TABLE `subcuenta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subgrupo_cuenta`
--

DROP TABLE IF EXISTS `subgrupo_cuenta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subgrupo_cuenta` (
  `idsubgrupo_cuenta` int(11) NOT NULL AUTO_INCREMENT,
  `idgrupo_cuenta` int(11) NOT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `nomenclatura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `definicion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idsubgrupo_cuenta`),
  KEY `fk_subgrupo_cuenta_idgrupo_cuenta_idx` (`idgrupo_cuenta`),
  CONSTRAINT `fk_subgrupo_cuenta_idgrupo_cuenta` FOREIGN KEY (`idgrupo_cuenta`) REFERENCES `grupo_cuenta` (`idgrupo_cuenta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subgrupo_cuenta`
--

LOCK TABLES `subgrupo_cuenta` WRITE;
/*!40000 ALTER TABLE `subgrupo_cuenta` DISABLE KEYS */;
INSERT INTO `subgrupo_cuenta` VALUES (6,1,'Efectivo y Equivalentes de Efectivo','111','Efectivo y Equivalentes de Efectivo','Activo'),(7,1,'Cuentas por Cobrar','112','Cuentas por Cobrar','Activo'),(8,1,'Pagos Anticipados','113','Pagos Anticipados','Activo'),(9,1,'Inventarios o Existencias','114','Inventarios o Existencias','Activo'),(10,2,'Inversiones a Largo Plazo','121','','Activo'),(11,2,'Mobiliario y Equipo','122','','Activo'),(12,2,'Activos Intangibles','123','','Activo'),(13,2,'Cargos por Amortizar','124','','Activo'),(14,3,'Provisión para Cuentas Incobrables','211','','Activo'),(15,3,'Depreciaciones Acumuladas','212','','Activo'),(16,3,'Amortizaciones Acumuladas','213','','Activo'),(17,4,'Cuentas por Pagar a Corto Plazo','311','','Activo'),(18,4,'Cobros Anticipados','312','','Activo'),(19,5,'Cuentas por Pagar a Largo Plazo','321','','Activo'),(20,6,'Otras Cuentas Acreedoras','401','','Activo'),(21,7,'Capital Social','511','','Activo'),(22,7,'Reservas de Capital','512','','Activo'),(23,7,'Perdidas y/o Ganancias de Capital','513','','Activo'),(24,7,'Resultados Acumulados','514','','Activo'),(25,8,'Cuentas de Orden Débito','611','','Activo'),(26,8,'Cuentas de Orden Crédito','612','','Activo'),(27,9,'Ingresos de Operación','711','','Activo'),(28,9,'Otros Ingresos de Operación','712','','Activo'),(29,10,'Costo de Producción','810','','Activo'),(30,10,'Costo de Venta','811','','Activo'),(31,10,'Gastos de Distribución','812','','Activo'),(32,10,'Gastos de Administración','813','','Activo'),(33,10,'Otros Gastos','814','','Activo');
/*!40000 ALTER TABLE `subgrupo_cuenta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sucursal`
--

DROP TABLE IF EXISTS `sucursal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sucursal` (
  `idsucursal` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  `idpais` int(11) NOT NULL DEFAULT '1',
  `idempresa` int(11) NOT NULL DEFAULT '1',
  `casa_matriz` enum('Si','No') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'No',
  PRIMARY KEY (`idsucursal`),
  KEY `fk_sucursal_idempresa_idx` (`idempresa`),
  KEY `fk_sucursal_idpais_idx` (`idpais`),
  CONSTRAINT `fk_sucursal_idempresa` FOREIGN KEY (`idempresa`) REFERENCES `empresa` (`idempresa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_sucursal_idpais` FOREIGN KEY (`idpais`) REFERENCES `pais` (`idpais`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sucursal`
--

LOCK TABLES `sucursal` WRITE;
/*!40000 ALTER TABLE `sucursal` DISABLE KEYS */;
INSERT INTO `sucursal` VALUES (1,'Ciudad Pedro de Alvarado','eqwe','Activo',1,1,'No'),(2,'Petapa','eqasdas','Activo',1,1,'No'),(3,'Taxisco','12131','Activo',1,1,'No'),(4,'Jutiapa','eqwe','Activo',1,1,'No'),(5,'Pasaco','weqwer','Activo',1,1,'No'),(6,'Escuintla','adasd','Activo',1,1,'No'),(7,'Peten','wqeqwe','Activo',1,1,'No'),(8,'Zacapa','qwewqdas','Activo',1,1,'Si');
/*!40000 ALTER TABLE `sucursal` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `contable`.`sucursal_BEFORE_INSERT` BEFORE INSERT ON `sucursal` FOR EACH ROW
BEGIN
	if new.casa_matriz = 'Si' then
		set new.casa_matriz = validar_sucursal_casa_matriz(new.idempresa,0);
	end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `contable`.`sucursal_BEFORE_UPDATE` BEFORE UPDATE ON `sucursal` FOR EACH ROW

	if new.casa_matriz != old.casa_matriz then
		if new.casa_matriz = 1 then
			set new.casa_matriz = validar_sucursal_casa_matriz(new.idempresa, new.idsucursal);
        end if;
	end if */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Dumping events for database 'contable'
--

--
-- Dumping routines for database 'contable'
--
/*!50003 DROP FUNCTION IF EXISTS `obtener_configuracion` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `obtener_configuracion`(pcodigo varchar(45), pidempresa int) RETURNS varchar(45) CHARSET utf8 COLLATE utf8_spanish_ci
BEGIN
	declare respuesta varchar(45) default '';
    select valor into respuesta from configuracion where codigo = pcodigo and idempresa = pidempresa;
	RETURN respuesta;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `obtener_correlativo` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `obtener_correlativo`(pcodigo varchar(45), pidempresa int) RETURNS int(11)
BEGIN
	declare respuesta int default 0;
    select valor+1 into respuesta from correlativo where codigo = pcodigo and idempresa = pidempresa;
    if respuesta = 0 then
		insert into correlativo(codigo, valor, idempresa) values (pcodigo,1, pidempresa);
        set respuesta = 1;
    else
		update correlativo set valor = respuesta where codigo = pcodigo and idempresa = pidempresa;
    end if;
RETURN respuesta;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `validar_sucursal_casa_matriz` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `validar_sucursal_casa_matriz`(pidempresa int, pidsucursal int) RETURNS int(11)
BEGIN
	declare respuesta int default 1;
    select count(*) into respuesta from sucursal where idempresa = pidempresa and idsucursal != pidsucursal and casa_matriz = 1;
    if respuesta > 0 then
		set respuesta = 2;
	else 
		set respuesta = 1;
    end if;
RETURN respuesta;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `pr_abonar_cuenta` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`%` PROCEDURE `pr_abonar_cuenta`(in p_idcuenta int, in p_monto decimal(10,2))
BEGIN
	update cuenta set haber = haber + p_monto where idcuenta = p_idcuenta;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `pr_cargar_cuenta` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`%` PROCEDURE `pr_cargar_cuenta`(in p_idcuenta int, in p_monto decimal(10,2))
BEGIN
	update cuenta set debe = debe + p_monto where idcuenta = p_idcuenta;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-03-03  0:06:34
