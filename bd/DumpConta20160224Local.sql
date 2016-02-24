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
INSERT INTO `clase_cuenta` VALUES (1,'Activo','Activo','1','Activo'),(2,'Cuentas Regularizadoras del Activo','Activo','2','Cuentas Regularizadoras del Activo'),(3,'Pasivo','Activo','3','Pasivo'),(4,'Otras Cuentas Acreedoras','Activo','4','Otras Cuentas Acreedoras'),(5,'Capital Contable','Activo','5','Capital Contable'),(6,'Cuentas de Orden per Contra','Activo','6','Cuentas de Orden per Contra'),(7,'Productos ','Activo','7','Productos '),(8,'Gastos','Activo','8','Gastos');
/*!40000 ALTER TABLE `clase_cuenta` ENABLE KEYS */;
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
  `nomeclatura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `definicion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idcuenta_mayor_auxiliar`),
  KEY `fk_cuenta_mayor_auxiliar_idcuenta_mayor_principal_idx` (`idcuenta_mayor_principal`),
  CONSTRAINT `fk_cuenta_mayor_auxiliar_idcuenta_mayor_principal` FOREIGN KEY (`idcuenta_mayor_principal`) REFERENCES `cuenta_mayor_principal` (`idcuenta_mayor_principal`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cuenta_mayor_auxiliar`
--

LOCK TABLES `cuenta_mayor_auxiliar` WRITE;
/*!40000 ALTER TABLE `cuenta_mayor_auxiliar` DISABLE KEYS */;
INSERT INTO `cuenta_mayor_auxiliar` VALUES (6,6,'Efectivo en Casa Matriz','111.101.01','Efectivo en Casa Matriz','Activo'),(7,6,'Efectivo en Sucursales','111.101.02','','Activo'),(8,7,'Dólares','111.102.01','Dólares','Activo'),(9,7,'Euros','111.102.02','','Activo'),(10,7,'Otras Monedas','111.102.99','Otras Monedas','Activo'),(11,11,'Depósitos Monetarios','111.106.01','','Activo'),(12,11,'Depósitos de Ahorro','111.106.02','','Activo'),(13,11,'Depósitos a Plazo Fijo','111.106.03','','Activo'),(14,11,'Otros Depósitos a Corto Plazo','111.106.99','','Activo'),(15,9,'Otros Depósitos a Corto Plazo','111.104.99','','Activo'),(16,9,'Depósitos a Plazo Fijo','111.104.03','','Activo'),(17,9,'Depósitos de Ahorro','111.104.02','','Activo'),(18,9,'Depósitos Monetarios','111.104.01','','Activo'),(19,10,'Depósitos Monetarios','111.105.01','','Activo'),(20,10,'Depósitos de Ahorro','111.105.02','','Activo'),(21,10,'Depósitos a Plazo Fijo','111.105.03','','Activo'),(22,10,'Otros Depósitos a Corto Plazo','111.105.99','','Activo'),(23,8,'Caja Chica en Casa Matriz','111.103.01','','Activo'),(24,8,'Caja Chica en Sucursales','111.103.02','','Activo'),(25,12,'Inversiones en Titulos-Valores de Emisores Nacionales','111.107.01','','Activo'),(26,12,'Inversiones en Titulos-Valores de Emisores Extranjeros','111.107.02','','Activo'),(27,13,'Clientes Nacionales','112.101.01','','Activo'),(28,13,'Clientes del Extranjero','112.101.02','','Activo'),(29,14,'Boucher de Tarjetas de Crédito','112.102.01','','Activo'),(30,14,'Facturas Cambiares','112.102.02','','Activo'),(31,14,'Letras','112.102.03','','Activo'),(32,14,'Pagarés','112.102.04','','Activo'),(33,14,'Otros Documentos por Cobrar','112.102.05','','Activo'),(34,15,'Anticipo a Proveedores Nacionales','112.103.01','','Activo'),(35,15,'Anticipo a Proveedores del Extranjero','112.103.02','','Activo'),(36,16,'Deudores por Venta de Activos Inmovilizados','112.104.01','','Activo'),(37,16,'Deudores por Faltante de Caja','112.104.02','','Activo'),(38,16,'Otros Deudores','112.104.99','','Activo'),(39,17,'Préstamos a Empleados','112.105.01','','Activo'),(40,17,'Préstamos a Directivos y/o Gerentes','112.105.02','','Activo'),(41,17,'Préstamos a Accionistas','112.105.03','','Activo'),(42,17,'Anticipos Sobre Sueldos','112.105.04','','Activo'),(43,18,'Intereses por Cobrar','112.106.01','','Activo'),(44,19,'Alquileres por Cobrar','112.107.01','','Activo'),(45,20,'Comisiones por Cobrar','112.108.01','','Activo'),(46,21,'Reclamaciones a Terceros','112.109.01','','Activo'),(47,21,'Depósitos Aduanales SAT','112.109.02','','Activo'),(48,21,'Otras Cuentas por Cobrar','112.109.99','','Activo'),(49,22,'IVA Crédito en Compras Locales','112.110.01','','Activo'),(50,22,'IVA Crédito en Importaciones','112.110.02','','Activo'),(51,23,'IVA Retenciones por Compensar','112.111.01','','Activo'),(52,24,'ISR por Cobrar','112.112.01','','Activo'),(53,24,'ISO Crédito Fiscal','112.112.02','','Activo'),(54,24,'Otros Créditos Fiscales','112.112.99','','Activo'),(55,25,'Impuesto Sobre la Renta Pagado Anticipado','113.101.01','','Activo'),(56,26,'Seguros Pagados por Anticipado','113.102.01','','Activo'),(57,27,'Alquileres Pagados por Anticipado','113.103.01','','Activo'),(58,28,'Intereses Pagados por Anticipado','113.104.01','','Activo'),(59,29,'Comisiones Pagadas por Anticipado','113.105.01','','Activo'),(60,30,'Publicidad Pagadas por Anticipada','113.106.01','','Activo'),(61,31,'Al Costo','114.101.01','','Activo'),(62,31,'A su Valor Neto Realizable','114.101.02','','Activo'),(63,32,'A su Valor Neto Realizable','114.102.02','A su Valor Neto Realizable','Activo'),(64,32,'Al Costo','114.102.01','Al Costo','Activo'),(65,33,'A su Valor Neto Realizable','114.103.02','A su Valor Neto Realizable','Activo'),(66,33,'Al Costo','114.103.01','Al Costo','Activo'),(67,34,'A su Valor Neto Realizable','114.104.02','A su Valor Neto Realizable','Activo'),(68,34,'Al Costo','114.104.01','Al Costo','Activo'),(69,35,'Mercancías en Tránsito','114.105.01','','Activo'),(70,36,'Mercaderías en Aduana','114.106.01','','Activo'),(71,37,'Papelería y Útiles','114.107.01','','Activo'),(72,38,'Suministros y Repuestos','114.108.01','','Activo'),(73,39,'Material de Empaque','114.109.01','','Activo'),(74,40,'Valores Emitidos y Garantizados por Entidades Estatales','121.101.01','','Activo'),(75,40,'Valores Emitidos por el Sistema Financiero Privado','121.101.02','','Activo'),(76,40,'Valores Emitidos por Empresas No Financieras Privadas','121.101.03','','Activo'),(77,40,'Valores Emitidos por Gobiernos Extranjeros','121.101.04','','Activo'),(78,40,'Valores Emitidos por Empresas Privadas del Extranjero','121.101.05','','Activo'),(79,41,'Preparación del Terreno','122.102.01','','Activo'),(80,41,'Construcción en Curso','122.102.02','','Activo'),(81,42,'Costo','122.103.01','','Activo'),(82,42,'Valor por Revaluación','122.103.02','','Activo'),(83,43,'Mobiliario','122.104.01','','Activo'),(84,43,'Equipo Electrónico','122.104.02','','Activo'),(85,43,'Equipo de Comunicación','122.104.03','','Activo'),(86,43,'Equipo de Seguridad','122.104.04','','Activo'),(87,44,'Costo','122.105.01','','Activo'),(88,44,'Valor por Revaluación','122.105.02','','Activo'),(89,46,'Costo','122.107.01','','Activo'),(90,46,'Valor por Revaluación','122.107.02','','Activo'),(91,47,'Costo','122.108.01','','Activo'),(92,47,'Valor por Revaluación','122.108.02','','Activo'),(93,48,'Costo','122.109.01','','Activo'),(94,48,'Valor por Revaluación','122.109.02','','Activo'),(95,49,'Costo','122.199.01','','Activo'),(96,49,'Valor por Revaluación','122.199.02','','Activo'),(97,50,'Costo','123.101.01','','Activo'),(98,50,'Valor por Revaluación','123.101.02','','Activo'),(99,51,'Costo','123.102.01','','Activo'),(100,51,'Valor por Revaluación','123.102.02','','Activo'),(101,52,'Costo','123.103.01','','Activo'),(102,52,'Valor por Revaluación','123.103.02','','Activo'),(103,53,'Costo','123.104.01','','Activo'),(104,53,'Valor por Revaluación','123.104.02','','Activo'),(105,54,'Costo','123.105.01','','Activo'),(106,54,'Valor por Revaluación','123.105.02','','Activo'),(107,55,'Crédito o Plusvalía Mercantil','123.106.01','','Activo'),(108,56,'Otros Activos Intangibles','123.199.01','','Activo'),(109,57,'Gastos de Organización','124.101.01','','Activo'),(110,58,'Gastos de Instalación y Remodelación','124.102.01','','Activo'),(111,59,'ISR Diferido','124.103.01','','Activo'),(112,60,'Provisión para Cuentas Incobrables','211.101.01','','Activo'),(113,61,'Depreciación Acumulada Vehículos','212.101.01','','Activo'),(114,62,'Depreciación Acumulada Edificios','212.102.01','','Activo'),(115,63,'Depreciación Acumulada Mobiliario y Equipo','212.103.01','','Activo'),(116,64,'Depreciación Acumulada Equipo de Cómputo','212.104.01','','Activo'),(117,65,'Depreciación Acumulada Programas y Licencias','212.105.01','','Activo'),(118,66,'Depreciación Acumulada Maquinaria','212.106.01','','Activo'),(119,67,'Depreciación Acumulada Herramientas','212.107.01','','Activo'),(120,68,'Otras Depreciaciones Acumuladas','212.199.01','','Activo'),(121,69,'Amortización Acumulada Concesiones y Franquicias','213.101.01','','Activo'),(122,70,'Amortización Acumulada Licencias','213.102.01','','Activo'),(123,71,'Amortización Acumulada Derechos de Llave','213.103.01','','Activo'),(124,72,'Amortización Acumulada Marcas','213.104.01','','Activo'),(125,73,'Amortización Acumulada Patentes','213.105.01','','Activo'),(126,74,'Amortización Acumulada Crédito Mercantil','213.106.01','','Activo'),(127,75,'Amortización Acumulada Gastos de Organización','213.107.01','','Activo'),(128,76,'Amortización Acumulada Gastos de Instalación','213.108.01','','Activo'),(129,77,'Otras Amortizaciones Acumuladas','213.199.01','','Activo');
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
  `nomeclatura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `definicion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idcuenta_mayor_principal`),
  KEY `fk_cuenta_mayor_principal_idsubgrupo_cuenta_idx` (`idsubgrupo_cuenta`),
  CONSTRAINT `fk_cuenta_mayor_principal_idsubgrupo_cuenta` FOREIGN KEY (`idsubgrupo_cuenta`) REFERENCES `subgrupo_cuenta` (`idsubgrupo_cuenta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cuenta_mayor_principal`
--

LOCK TABLES `cuenta_mayor_principal` WRITE;
/*!40000 ALTER TABLE `cuenta_mayor_principal` DISABLE KEYS */;
INSERT INTO `cuenta_mayor_principal` VALUES (6,6,'Caja Moneda Nacional','111.101','Caja Moneda Nacional','Activo'),(7,6,'Caja Moneda Extranjera','111.102','','Activo'),(8,6,'Caja Chica','111.103','','Activo'),(9,6,'Bancos del País Moneda Nacional','111.104','','Activo'),(10,6,'Bancos del País Moneda Extranjera','111.105','','Activo'),(11,6,'Bancos del Exterior','111.106','','Activo'),(12,6,'Inversiones a Corto Plazo','111.107','','Activo'),(13,7,'Cuentas por Cobrar Comerciales','112.101','','Activo'),(14,7,'Documentos por Cobrar','112.102','','Activo'),(15,7,'Anticipo a Proveedores','112.103','','Activo'),(16,7,'Cuentas por Cobrar No Comerciales','112.104','','Activo'),(17,7,'Prestamos y Anticipos a Personal','112.105','','Activo'),(18,7,'Intereses por Cobrar','112.106','','Activo'),(19,7,'Alquileres por Cobrar','112.107','','Activo'),(20,7,'Comisiones por Cobrar','112.108','','Activo'),(21,7,'Otras Cuentas por Cobrar','112.109','','Activo'),(22,7,'IVA Crédito Fiscal','112.110','','Activo'),(23,7,'IVA Retenciones por Compensar','112.111','','Activo'),(24,7,'Otros Créditos Fiscales','112.112','','Activo'),(25,8,'Impuesto Sobre la Renta Pagado Anticipado','113.101','','Activo'),(26,8,'Seguros Pagados por Anticipado','113.102','','Activo'),(27,8,'Alquileres Pagados por Anticipado','113.103','','Activo'),(28,8,'Intereses Pagados por Anticipado','113.104','','Activo'),(29,8,'Comisiones Pagadas por Anticipado','113.105','','Activo'),(30,8,'Publicidad Pagadas por Anticipada','113.106','','Activo'),(31,9,'Inventario de Mercaderías','114.101','','Activo'),(32,9,'Inventario de Materia Prima','114.102','','Activo'),(33,9,'Inventario de Artículos en Proceso','114.103','','Activo'),(34,9,'Inventario de Artículos Terminados','114.104','','Activo'),(35,9,'Mercancías en Tránsito','114.105','','Activo'),(36,9,'Mercaderías en Aduana','114.106','','Activo'),(37,9,'Papelería y Útiles','114.107','','Activo'),(38,9,'Suministros y Repuestos','114.108','','Activo'),(39,9,'Material de Empaque','114.109','','Activo'),(40,10,'Inversión en Títulos-Valores al Vencimiento','121.101','','Activo'),(41,11,'Construcciones en Proceso','122.102','','Activo'),(42,11,'Terrenos','122.103','','Activo'),(43,11,'Mobiliario y Equipo','122.104','','Activo'),(44,11,'Equipo de Computación','122.105','','Activo'),(45,11,'Programas y Licencias de Computación','122.106','','Activo'),(46,11,'Vehículos','122.107','','Activo'),(47,11,'Maquinaria','122.108','','Activo'),(48,11,'Herramientas','122.109','','Activo'),(49,11,'Otros Equipos Inmovilizados','122.199','','Activo'),(50,12,'Concesiones y Franquicias','123.101','','Activo'),(51,12,'Licencias','123.102','','Activo'),(52,12,'Derecho de Llave','123.103','','Activo'),(53,12,'Marcas','123.104','','Activo'),(54,12,'Patentes','123.105','','Activo'),(55,12,'Crédito o Plusvalía Mercantil','123.106','','Activo'),(56,12,'Otros Activos Intangibles','123.199','','Activo'),(57,13,'Gastos de Organización','124.101','','Activo'),(58,13,'Gastos de Instalación y Remodelación','124.102','','Activo'),(59,13,'ISR Diferido','124.103','','Activo'),(60,14,'Provisión para Cuentas Incobrables','211.101','','Activo'),(61,15,'Depreciación Acumulada Vehículos','212.101','','Activo'),(62,15,'Depreciación Acumulada Edificios','212.102','','Activo'),(63,15,'Depreciación Acumulada Mobiliario y Equipo','212.103','','Activo'),(64,15,'Depreciación Acumulada Equipo de Cómputo','212.104','','Activo'),(65,15,'Depreciación Acumulada Programas y Licencias','212.105','','Activo'),(66,15,'Depreciación Acumulada Maquinaria','212.106','','Activo'),(67,15,'Depreciación Acumulada Herramientas','212.107','','Activo'),(68,15,'Otras Depreciaciones Acumuladas','212.199','','Activo'),(69,16,'Amortización Acumulada Concesiones y Franquicias','213.101','','Activo'),(70,16,'Amortización Acumulada Licencias','213.102','','Activo'),(71,16,'Amortización Acumulada Derechos de Llave','213.103','','Activo'),(72,16,'Amortización Acumulada Marcas','213.104','','Activo'),(73,16,'Amortización Acumulada Patentes','213.105','','Activo'),(74,16,'Amortización Acumulada Crédito Mercantil','213.106','','Activo'),(75,16,'Amortización Acumulada Gastos de Organización','213.107','','Activo'),(76,16,'Amortización Acumulada Gastos de Instalación','213.108','','Activo'),(77,16,'Otras Amortizaciones Acumuladas','213.199','','Activo');
/*!40000 ALTER TABLE `cuenta_mayor_principal` ENABLE KEYS */;
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
  `nomeclatura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `definicion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idgrupo_cuenta`),
  KEY `fk_grupo_cuenta_idclase_cuenta_idx` (`idclase_cuenta`),
  CONSTRAINT `fk_grupo_cuenta_idclase_cuenta` FOREIGN KEY (`idclase_cuenta`) REFERENCES `clase_cuenta` (`idclase_cuenta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_cuenta`
--

LOCK TABLES `grupo_cuenta` WRITE;
/*!40000 ALTER TABLE `grupo_cuenta` DISABLE KEYS */;
INSERT INTO `grupo_cuenta` VALUES (1,1,'Activo Corriente','11','Corriente','Activo'),(2,1,'No Corriente','12','No Corriente','Activo'),(3,2,'Prevision para cuentas incobrables, depreciac','21','Prevision para cuentas incobrables, depreciac','Activo'),(4,3,'Corriente ','31','Corriente ','Activo'),(5,3,'No Corriente','32','No Corriente','Activo');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pais`
--

LOCK TABLES `pais` WRITE;
/*!40000 ALTER TABLE `pais` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona`
--

LOCK TABLES `persona` WRITE;
/*!40000 ALTER TABLE `persona` DISABLE KEYS */;
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
  `nomeclatura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
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
  `nomeclatura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `definicion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idsubgrupo_cuenta`),
  KEY `fk_subgrupo_cuenta_idgrupo_cuenta_idx` (`idgrupo_cuenta`),
  CONSTRAINT `fk_subgrupo_cuenta_idgrupo_cuenta` FOREIGN KEY (`idgrupo_cuenta`) REFERENCES `grupo_cuenta` (`idgrupo_cuenta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subgrupo_cuenta`
--

LOCK TABLES `subgrupo_cuenta` WRITE;
/*!40000 ALTER TABLE `subgrupo_cuenta` DISABLE KEYS */;
INSERT INTO `subgrupo_cuenta` VALUES (6,1,'Efectivo y Equivalentes de Efectivo','111','Efectivo y Equivalentes de Efectivo','Activo'),(7,1,'Cuentas por Cobrar','112','Cuentas por Cobrar','Activo'),(8,1,'Pagos Anticipados','113','Pagos Anticipados','Activo'),(9,1,'Inventarios o Existencias','114','Inventarios o Existencias','Activo'),(10,2,'Inversiones a Largo Plazo','121','','Activo'),(11,2,'Mobiliario y Equipo','122','','Activo'),(12,2,'Activos Intangibles','123','','Activo'),(13,2,'Cargos por Amortizar','124','','Activo'),(14,3,'Provisión para Cuentas Incobrables','211','','Activo'),(15,3,'Depreciaciones Acumuladas','212','','Activo'),(16,3,'Amortizaciones Acumuladas','213','','Activo');
/*!40000 ALTER TABLE `subgrupo_cuenta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'contable'
--

--
-- Dumping routines for database 'contable'
--
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

-- Dump completed on 2016-02-24  8:46:00
