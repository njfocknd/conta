-- MySQL dump 10.13  Distrib 5.6.24, for Win32 (x86)
--
-- Host: nexthordb.cquvmppcukva.us-west-2.rds.amazonaws.com    Database: contable
-- ------------------------------------------------------
-- Server version	5.6.23-log

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
-- Table structure for table `balance_general`
--

DROP TABLE IF EXISTS `balance_general`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `balance_general` (
  `idbalance_general` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) NOT NULL DEFAULT '1',
  `idperiodo_contable` int(11) NOT NULL DEFAULT '1',
  `activo_circulante` decimal(10,2) NOT NULL DEFAULT '0.00',
  `activo_fijo` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pasivo_circulante` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pasivo_fijo` decimal(10,2) NOT NULL DEFAULT '0.00',
  `capital_contable` decimal(10,2) NOT NULL DEFAULT '0.00',
  `estado` enum('Activo','Inactivo') COLLATE utf8_bin NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  PRIMARY KEY (`idbalance_general`),
  KEY `fk_balance_general_idempresa_idx` (`idempresa`),
  KEY `fk_balance_general_idperiodo_contable_idx` (`idperiodo_contable`),
  CONSTRAINT `fk_balance_general_idempresa` FOREIGN KEY (`idempresa`) REFERENCES `empresa` (`idempresa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_balance_general_idperiodo_contable` FOREIGN KEY (`idperiodo_contable`) REFERENCES `periodo_contable` (`idperiodo_contable`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `balance_general`
--

LOCK TABLES `balance_general` WRITE;
/*!40000 ALTER TABLE `balance_general` DISABLE KEYS */;
INSERT INTO `balance_general` VALUES (1,1,1,22709180.00,54724506.00,24638514.00,43927205.00,8867967.00,'Activo',NULL),(2,1,2,21095624.00,67161825.00,25929271.00,48289925.00,14038253.00,'Activo',NULL),(3,2,2,642.00,2731.00,543.00,531.00,2299.00,'Activo',NULL),(4,2,1,708.00,2880.00,540.00,457.00,2591.00,'Activo',NULL),(5,1,3,18871844.00,60234049.00,20917142.00,41935601.00,16253150.00,'Activo',NULL),(6,1,4,16318418.00,59953291.00,18918948.00,38227765.00,19124996.00,'Activo',NULL),(7,1,5,24980098.00,60196956.60,27102365.40,48319925.50,9754763.70,'Activo',NULL);
/*!40000 ALTER TABLE `balance_general` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_ALL_TABLES,NO_AUTO_CREATE_USER' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 */ /*!50003 TRIGGER `contable`.`balance_general_BEFORE_INSERT` BEFORE INSERT ON `balance_general` FOR EACH ROW
BEGIN
	set new.activo_circulante = 0;
	set new.activo_fijo = 0;
	set new.pasivo_circulante = 0;
	set new.pasivo_fijo = 0;
	set new.capital_contable = 0;
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
/*!50003 SET sql_mode              = 'STRICT_ALL_TABLES,NO_AUTO_CREATE_USER' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 */ /*!50003 TRIGGER `contable`.`balance_general_BEFORE_UPDATE` BEFORE UPDATE ON `balance_general` FOR EACH ROW
BEGIN
	set new.capital_contable = (new.activo_circulante +new.activo_fijo) -  (new.pasivo_circulante +new.pasivo_fijo);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `balance_general_detalle`
--

DROP TABLE IF EXISTS `balance_general_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `balance_general_detalle` (
  `idbalance_general_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `idbalance_general` int(11) NOT NULL DEFAULT '1',
  `idclase_cuenta` int(11) NOT NULL DEFAULT '1',
  `idgrupo_cuenta` int(11) NOT NULL DEFAULT '1',
  `idsubgrupo_cuenta` int(11) NOT NULL DEFAULT '6',
  `monto` decimal(10,2) NOT NULL DEFAULT '0.00',
  `estado` enum('Activo','Inactivo') COLLATE utf8_bin NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  PRIMARY KEY (`idbalance_general_detalle`),
  KEY `fk_balance_general_detalle_idbalance_general_idx` (`idbalance_general`),
  KEY `fk_balance_general_detalle_idclase_cuenta_idx` (`idclase_cuenta`),
  KEY `fk_balance_general_detalle_idgrupo_cuenta_idx` (`idgrupo_cuenta`),
  KEY `fk_balance_general_detalle__idsubgrupo_cuenta_idx` (`idsubgrupo_cuenta`),
  CONSTRAINT `fk_balance_general_detalle__idsubgrupo_cuenta` FOREIGN KEY (`idsubgrupo_cuenta`) REFERENCES `subgrupo_cuenta` (`idsubgrupo_cuenta`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_balance_general_detalle_idbalance_general` FOREIGN KEY (`idbalance_general`) REFERENCES `balance_general` (`idbalance_general`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_balance_general_detalle_idclase_cuenta` FOREIGN KEY (`idclase_cuenta`) REFERENCES `clase_cuenta` (`idclase_cuenta`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_balance_general_detalle_idgrupo_cuenta` FOREIGN KEY (`idgrupo_cuenta`) REFERENCES `grupo_cuenta` (`idgrupo_cuenta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `balance_general_detalle`
--

LOCK TABLES `balance_general_detalle` WRITE;
/*!40000 ALTER TABLE `balance_general_detalle` DISABLE KEYS */;
INSERT INTO `balance_general_detalle` VALUES (2,1,1,1,6,7348905.00,'Activo',NULL),(3,1,1,2,10,180102.00,'Activo',NULL),(4,1,3,4,17,15349007.00,'Activo',NULL),(5,1,3,5,19,0.00,'Inactivo',NULL),(6,2,1,1,6,0.00,'Inactivo',NULL),(7,2,1,1,7,0.00,'Inactivo',NULL),(8,2,1,1,9,0.00,'Inactivo',NULL),(9,2,1,2,11,0.00,'Inactivo',NULL),(10,2,3,4,17,0.00,'Inactivo',NULL),(11,2,3,5,19,0.00,'Inactivo',NULL),(12,3,1,1,6,84.00,'Activo',NULL),(13,3,1,1,7,165.00,'Activo',NULL),(14,3,1,1,9,393.00,'Activo',NULL),(15,3,1,2,34,2731.00,'Activo',NULL),(16,3,3,4,17,312.00,'Activo',NULL),(17,3,3,4,35,231.00,'Activo',NULL),(18,3,3,5,36,531.00,'Activo',NULL),(19,3,5,7,37,500.00,'Activo',NULL),(20,3,5,7,38,1799.00,'Activo',NULL),(21,4,1,1,6,98.00,'Activo',NULL),(22,4,1,1,7,188.00,'Activo',NULL),(23,4,1,1,9,422.00,'Activo',NULL),(24,4,3,4,17,344.00,'Activo',NULL),(25,4,3,4,35,196.00,'Activo',NULL),(26,4,3,5,36,457.00,'Activo',NULL),(27,4,5,7,37,550.00,'Activo',NULL),(28,4,5,7,38,2041.00,'Activo',NULL),(29,4,1,2,34,2880.00,'Activo',NULL),(30,1,1,1,39,3262520.00,'Activo',NULL),(31,1,1,1,7,9037427.00,'Activo',NULL),(32,1,1,1,9,2059936.00,'Activo',NULL),(33,1,1,1,40,1000392.00,'Activo',NULL),(34,1,1,2,12,7222741.00,'Activo',NULL),(35,1,1,2,41,33207336.00,'Activo',NULL),(36,1,1,2,42,7938887.00,'Activo',NULL),(37,1,1,2,43,1461972.00,'Activo',NULL),(38,1,1,2,44,4713468.00,'Activo',NULL),(39,1,3,4,35,7355652.00,'Activo',NULL),(40,1,3,4,45,1933855.00,'Activo',NULL),(41,1,3,5,36,32825903.00,'Activo',NULL),(42,1,3,5,46,7556721.00,'Activo',NULL),(43,1,3,5,47,732018.00,'Activo',NULL),(44,1,3,5,48,2812563.00,'Activo',NULL),(45,2,1,1,6,7567688.00,'Activo',NULL),(46,2,1,2,10,3342159.00,'Activo',NULL),(47,2,3,4,17,19294317.00,'Activo',NULL),(48,2,1,1,39,0.00,'Inactivo',NULL),(49,2,1,1,7,9966554.00,'Activo',NULL),(50,2,1,1,9,2437645.00,'Activo',NULL),(51,2,1,1,40,1123737.00,'Activo',NULL),(52,2,1,2,12,7959415.00,'Activo',NULL),(53,2,1,2,41,39899332.00,'Activo',NULL),(54,2,1,2,42,9559415.00,'Activo',NULL),(55,2,1,2,43,1889858.00,'Activo',NULL),(56,2,1,2,44,4511646.00,'Activo',NULL),(57,2,3,4,35,4500302.00,'Activo',NULL),(58,2,3,4,45,2134652.00,'Activo',NULL),(59,2,3,5,36,37039263.00,'Activo',NULL),(60,2,3,5,46,6788173.00,'Activo',NULL),(61,2,3,5,47,1053017.00,'Activo',NULL),(62,2,3,5,48,3409472.00,'Activo',NULL),(63,5,1,1,6,5276123.00,'Activo',NULL),(64,5,1,2,10,6786746.00,'Activo',NULL),(65,5,3,4,17,16471584.00,'Activo',NULL),(66,5,1,1,7,9866196.00,'Activo',NULL),(67,5,1,1,9,2803583.00,'Activo',NULL),(68,5,1,1,40,925942.00,'Activo',NULL),(69,5,1,2,12,2918203.00,'Activo',NULL),(70,5,1,2,41,38260763.00,'Activo',NULL),(71,5,1,2,42,7061558.00,'Activo',NULL),(72,5,1,2,43,1323974.00,'Activo',NULL),(73,5,1,2,44,3882805.00,'Activo',NULL),(74,5,3,4,35,2382793.00,'Activo',NULL),(75,5,3,4,45,2062765.00,'Activo',NULL),(76,5,3,5,36,35464079.00,'Activo',NULL),(77,5,3,5,46,5659577.00,'Activo',NULL),(78,5,3,5,47,208725.00,'Activo',NULL),(79,5,3,5,48,603220.00,'Activo',NULL),(80,6,1,1,6,3930902.00,'Activo',NULL),(81,6,1,2,10,5630393.00,'Activo',NULL),(82,6,3,4,17,15638200.00,'Activo',NULL),(83,6,1,1,7,9309641.00,'Activo',NULL),(84,6,1,1,9,2209905.00,'Activo',NULL),(85,6,1,1,40,867970.00,'Activo',NULL),(86,6,1,2,12,3480344.00,'Activo',NULL),(87,6,1,2,41,38536445.00,'Activo',NULL),(88,6,1,2,42,7677950.00,'Activo',NULL),(89,6,1,2,43,1211239.00,'Activo',NULL),(90,6,1,2,44,3416920.00,'Activo',NULL),(91,6,3,4,35,1435920.00,'Activo',NULL),(92,6,3,4,45,1844828.00,'Activo',NULL),(93,6,3,5,36,31114145.00,'Activo',NULL),(94,6,3,5,46,5668917.00,'Activo',NULL),(95,6,3,5,47,730798.00,'Activo',NULL),(96,6,3,5,48,713905.00,'Activo',NULL),(97,1,1,1,8,0.00,'Inactivo',NULL),(98,7,1,1,6,8083795.50,'Activo',NULL),(99,7,1,2,10,198112.20,'Activo',NULL),(100,7,3,4,17,16883907.70,'Activo',NULL),(101,7,1,1,39,3588772.00,'Activo',NULL),(102,7,1,1,7,9941169.70,'Activo',NULL),(103,7,1,1,9,2265929.60,'Activo',NULL),(104,7,1,1,40,1100431.20,'Activo',NULL),(105,7,1,2,12,7945015.10,'Activo',NULL),(106,7,1,2,41,36528069.60,'Activo',NULL),(107,7,1,2,42,8732775.70,'Activo',NULL),(108,7,1,2,43,1608169.20,'Activo',NULL),(109,7,1,2,44,5184814.80,'Activo',NULL),(110,7,3,4,35,8091217.20,'Activo',NULL),(111,7,3,4,45,2127240.50,'Activo',NULL),(112,7,3,5,36,36108493.30,'Activo',NULL),(113,7,3,5,46,8312393.10,'Activo',NULL),(114,7,3,5,47,805219.80,'Activo',NULL),(115,7,3,5,48,3093819.30,'Activo',NULL);
/*!40000 ALTER TABLE `balance_general_detalle` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_ALL_TABLES,NO_AUTO_CREATE_USER' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 */ /*!50003 TRIGGER `contable`.`balance_general_detalle_AFTER_INSERT` AFTER INSERT ON `balance_general_detalle` FOR EACH ROW
BEGIN
	if new.idclase_cuenta = 1 and new.idgrupo_cuenta = 1 then
		update balance_general set activo_circulante = activo_circulante + new.monto where idbalance_general = new.idbalance_general;
	elseif new.idclase_cuenta = 1 then
		update balance_general set activo_fijo = activo_fijo + new.monto where idbalance_general = new.idbalance_general;
	elseif new.idclase_cuenta = 3 and new.idgrupo_cuenta = 4 then
		update balance_general set pasivo_circulante = pasivo_circulante + new.monto where idbalance_general = new.idbalance_general;
	elseif new.idclase_cuenta = 3 then
		update balance_general set pasivo_fijo = pasivo_fijo + new.monto where idbalance_general = new.idbalance_general;
	else
		update balance_general set capital_contable = capital_contable + new.monto where idbalance_general = new.idbalance_general;
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
/*!50003 SET sql_mode              = 'STRICT_ALL_TABLES,NO_AUTO_CREATE_USER' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 */ /*!50003 TRIGGER `contable`.`balance_general_detalle_BEFORE_UPDATE` BEFORE UPDATE ON `balance_general_detalle` FOR EACH ROW
BEGIN
	if new.monto = 0 then
		set new.estado = 'Inactivo';
    end if;
	if new.estado != old.estado then
		if new.estado = 'Inactivo' then
			set new.monto = 0;
        end if;
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
/*!50003 SET sql_mode              = 'STRICT_ALL_TABLES,NO_AUTO_CREATE_USER' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 */ /*!50003 TRIGGER `contable`.`balance_general_detalle_AFTER_UPDATE` AFTER UPDATE ON `balance_general_detalle` FOR EACH ROW
BEGIN
	
	if new.monto != old.monto then
		if new.idclase_cuenta = 1 and new.idgrupo_cuenta = 1 then
			update balance_general set activo_circulante = activo_circulante + (new.monto-old.monto) where idbalance_general = new.idbalance_general;
		elseif new.idclase_cuenta = 1 then
			update balance_general set activo_fijo = activo_fijo + (new.monto-old.monto) where idbalance_general = new.idbalance_general;
		elseif new.idclase_cuenta = 3 and new.idgrupo_cuenta = 4 then
			update balance_general set pasivo_circulante = pasivo_circulante + (new.monto-old.monto) where idbalance_general = new.idbalance_general;
		elseif new.idclase_cuenta = 3 then
			update balance_general set pasivo_fijo = pasivo_fijo + (new.monto-old.monto) where idbalance_general = new.idbalance_general;
		else
			update balance_general set capital_contable = capital_contable + (new.monto-old.monto) where idbalance_general = new.idbalance_general;
		end if;
	end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
INSERT INTO `clase_cuenta` VALUES (1,'Activo','Activo','1','Activo'),(2,'Cuentas Regularizadoras del Activo','Inactivo','2','Cuentas Regularizadoras del Activo'),(3,'Pasivo','Activo','3','Pasivo'),(4,'Otras Cuentas Acreedoras','Inactivo','4','Otras Cuentas Acreedoras'),(5,'Capital Contable','Activo','5','Capital Contable'),(6,'Cuentas de Orden per Contra','Inactivo','6','Cuentas de Orden per Contra'),(7,'Productos ','Inactivo','7','Productos '),(8,'Gastos','Inactivo','8','Gastos');
/*!40000 ALTER TABLE `clase_cuenta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clase_resultado`
--

DROP TABLE IF EXISTS `clase_resultado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clase_resultado` (
  `idclase_resultado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_bin NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idclase_resultado`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clase_resultado`
--

LOCK TABLES `clase_resultado` WRITE;
/*!40000 ALTER TABLE `clase_resultado` DISABLE KEYS */;
INSERT INTO `clase_resultado` VALUES (1,'Venta netas','Activo'),(2,'Costo de ventas','Activo'),(3,'Depreciación y gastos','Activo'),(4,'Intereses pagados','Activo'),(5,'Impuestos','Activo'),(6,'Dividendos','Activo'),(7,'Aumento en las utilidades retenidas','Activo');
/*!40000 ALTER TABLE `clase_resultado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cuenta`
--

DROP TABLE IF EXISTS `cuenta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cuenta` (
  `idcuenta` int(11) NOT NULL AUTO_INCREMENT,
  `nomenclatura` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `debe` decimal(10,2) NOT NULL DEFAULT '0.00',
  `haber` decimal(10,2) NOT NULL DEFAULT '0.00',
  `saldo` decimal(10,2) NOT NULL DEFAULT '0.00',
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  `idsubcuenta` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idcuenta`),
  KEY `fk_cuenta_idsubcuenta_idx` (`idsubcuenta`),
  CONSTRAINT `fk_cuenta_idsubcuenta` FOREIGN KEY (`idsubcuenta`) REFERENCES `subcuenta` (`idsubcuenta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cuenta`
--

LOCK TABLES `cuenta` WRITE;
/*!40000 ALTER TABLE `cuenta` DISABLE KEYS */;
INSERT INTO `cuenta` VALUES (3,'111.103.01.01.01','Caja Chica TI',0.00,0.00,0.00,'Activo',1),(4,'111.103.01.01.02','Caja Chica Operaciones',0.00,0.00,0.00,'Activo',1);
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
/*!50003 CREATE*/ /*!50017 */ /*!50003 TRIGGER `contable`.`cuenta_BEFORE_UPDATE` BEFORE UPDATE ON `cuenta` FOR EACH ROW
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
  `nombre` varchar(45) COLLATE utf8_bin NOT NULL,
  `ticker` varchar(45) COLLATE utf8_bin NOT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_bin NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idempresa`),
  UNIQUE KEY `ticker_UNIQUE` (`ticker`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` VALUES (1,'America Movil, S.A.B. de C.V.','AMX','Activo'),(2,'PRUFROCK','PF','Activo');
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado_resultado`
--

DROP TABLE IF EXISTS `estado_resultado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estado_resultado` (
  `idestado_resultado` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) NOT NULL DEFAULT '1',
  `idperiodo_contable` int(11) NOT NULL DEFAULT '1',
  `venta_netas` decimal(10,2) NOT NULL DEFAULT '0.00',
  `costo_ventas` decimal(10,2) NOT NULL DEFAULT '0.00',
  `depreciacion` decimal(10,2) NOT NULL DEFAULT '0.00',
  `interes_pagado` decimal(10,2) NOT NULL DEFAULT '0.00',
  `impuestos` decimal(10,2) NOT NULL DEFAULT '0.00',
  `utilidad_neta` decimal(10,2) NOT NULL DEFAULT '0.00',
  `dividendos` decimal(10,2) NOT NULL DEFAULT '0.00',
  `utilidades_retenidas` decimal(10,2) NOT NULL DEFAULT '0.00',
  `estado` enum('Activo','Inactivo') COLLATE utf8_bin NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idestado_resultado`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado_resultado`
--

LOCK TABLES `estado_resultado` WRITE;
/*!40000 ALTER TABLE `estado_resultado` DISABLE KEYS */;
INSERT INTO `estado_resultado` VALUES (1,1,1,200.00,0.00,50.00,0.00,0.00,150.00,0.00,0.00,'Inactivo'),(2,2,1,2311.00,1344.00,276.00,141.00,187.00,363.00,121.00,242.00,'Inactivo'),(3,1,1,51775164.00,24205792.00,19379168.00,4939672.00,1110502.00,2140030.00,0.00,0.00,'Activo'),(4,1,2,57549268.00,26194619.00,20733420.00,4704896.00,2693909.00,3222424.00,0.00,0.00,'Activo'),(5,1,3,60020769.00,27356423.00,20886383.00,3732913.00,2320561.00,5724489.00,0.00,0.00,'Activo'),(6,1,4,59685018.00,26268584.00,21006918.00,1810964.00,3541002.00,7057550.00,220.00,0.00,'Activo'),(7,1,5,56952680.40,26626371.20,21317084.80,5433639.20,1221552.20,2354033.00,0.00,0.00,'Activo');
/*!40000 ALTER TABLE `estado_resultado` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_ALL_TABLES,NO_AUTO_CREATE_USER' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 */ /*!50003 TRIGGER `contable`.`estado_resultado_BEFORE_INSERT` BEFORE INSERT ON `estado_resultado` FOR EACH ROW
BEGIN
 set new.venta_netas = 0;
 set new.costo_ventas = 0;
 set new.depreciacion = 0;
 set new.interes_pagado = 0;
 set new.impuestos = 0;
 set new.utilidad_neta = 0;
 set new.dividendos = 0;
 set new.utilidades_retenidas = 0;
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
/*!50003 CREATE*/ /*!50017 */ /*!50003 TRIGGER `contable`.`estado_resultado_BEFORE_UPDATE` BEFORE UPDATE ON `estado_resultado` FOR EACH ROW
BEGIN
 set new.utilidad_neta = new.venta_netas -(new.costo_ventas+new.depreciacion+new.interes_pagado+new.impuestos);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `estado_resultado_detalle`
--

DROP TABLE IF EXISTS `estado_resultado_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estado_resultado_detalle` (
  `idestado_resultado_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `idestado_resultado` int(11) NOT NULL DEFAULT '1',
  `idclase_resultado` int(11) NOT NULL DEFAULT '1',
  `idgrupo_resultado` int(11) NOT NULL DEFAULT '1',
  `monto` decimal(10,2) NOT NULL DEFAULT '0.00',
  `estado` enum('Activo','Inactivo') COLLATE utf8_bin NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idestado_resultado_detalle`),
  KEY `fk_estado_resultado_detalle_idestado_resultado_idx` (`idestado_resultado`),
  KEY `fk_estado_resultado_detalle_idclase_resultado_idx` (`idclase_resultado`),
  KEY `fk_estado_resultado_detalle_idgrupo_resultado_idx` (`idgrupo_resultado`),
  CONSTRAINT `fk_estado_resultado_detalle_idclase_resultado` FOREIGN KEY (`idclase_resultado`) REFERENCES `clase_resultado` (`idclase_resultado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_estado_resultado_detalle_idestado_resultado` FOREIGN KEY (`idestado_resultado`) REFERENCES `estado_resultado` (`idestado_resultado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_estado_resultado_detalle_idgrupo_resultado` FOREIGN KEY (`idgrupo_resultado`) REFERENCES `grupo_resultado` (`idgrupo_resultado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado_resultado_detalle`
--

LOCK TABLES `estado_resultado_detalle` WRITE;
/*!40000 ALTER TABLE `estado_resultado_detalle` DISABLE KEYS */;
INSERT INTO `estado_resultado_detalle` VALUES (1,1,1,1,100.00,'Activo'),(2,1,2,2,50.00,'Activo'),(3,1,1,8,200.00,'Activo'),(4,1,3,3,50.00,'Activo'),(5,2,1,1,2311.00,'Activo'),(6,2,2,2,1344.00,'Activo'),(7,2,3,3,276.00,'Activo'),(8,2,4,4,141.00,'Activo'),(9,2,5,5,187.00,'Activo'),(10,2,6,6,121.00,'Activo'),(11,2,7,7,242.00,'Activo'),(12,3,1,8,51775164.00,'Activo'),(13,3,2,9,24205792.00,'Activo'),(14,3,3,10,12099086.00,'Activo'),(15,3,3,11,7280082.00,'Activo'),(16,3,4,4,1806497.00,'Activo'),(17,3,5,5,1110502.00,'Activo'),(18,3,4,12,3133175.00,'Activo'),(19,4,1,8,57549268.00,'Activo'),(20,4,2,9,26194619.00,'Activo'),(21,4,3,10,12931826.00,'Activo'),(22,4,3,11,7801594.00,'Activo'),(23,4,4,4,2138606.00,'Activo'),(24,4,5,5,2693909.00,'Activo'),(25,4,4,12,2566290.00,'Activo'),(26,5,1,8,60020769.00,'Activo'),(27,5,2,9,27356423.00,'Activo'),(28,5,3,10,13133946.00,'Activo'),(29,5,3,11,7752437.00,'Activo'),(30,5,4,4,1828692.00,'Activo'),(31,5,5,5,2320561.00,'Activo'),(32,5,4,12,1904221.00,'Activo'),(33,6,1,8,59685018.00,'Activo'),(34,6,2,9,26268584.00,'Activo'),(35,6,3,10,13030271.00,'Activo'),(36,6,3,11,7976647.00,'Activo'),(37,6,4,4,1714752.00,'Activo'),(38,6,5,5,3541002.00,'Activo'),(39,6,4,12,96212.00,'Activo'),(40,6,6,6,220.00,'Activo'),(41,6,2,2,0.00,'Inactivo'),(42,7,1,8,56952680.40,'Activo'),(43,7,2,9,26626371.20,'Activo'),(44,7,3,10,13308994.60,'Activo'),(45,7,3,11,8008090.20,'Activo'),(46,7,4,4,1987146.70,'Activo'),(47,7,5,5,1221552.20,'Activo'),(48,7,4,12,3446492.50,'Activo');
/*!40000 ALTER TABLE `estado_resultado_detalle` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_ALL_TABLES,NO_AUTO_CREATE_USER' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 */ /*!50003 TRIGGER `contable`.`estado_resultado_detalle_AFTER_INSERT` AFTER INSERT ON `estado_resultado_detalle` FOR EACH ROW
BEGIN
	
		if new.idclase_resultado = 1 then
			update estado_resultado set venta_netas = venta_netas + new.monto where idestado_resultado = new.idestado_resultado;
		elseif new.idclase_resultado = 2 then
			update estado_resultado set costo_ventas = costo_ventas + new.monto where idestado_resultado = new.idestado_resultado;
		elseif new.idclase_resultado = 3 then
			update estado_resultado set depreciacion = depreciacion + new.monto where idestado_resultado = new.idestado_resultado;
		elseif new.idclase_resultado = 4 then
			update estado_resultado set interes_pagado = interes_pagado + new.monto where idestado_resultado = new.idestado_resultado;
		elseif new.idclase_resultado = 5 then
			update estado_resultado set impuestos = impuestos + new.monto where idestado_resultado = new.idestado_resultado;
		elseif new.idclase_resultado = 6 then
			update estado_resultado set dividendos = dividendos + new.monto where idestado_resultado = new.idestado_resultado;
		else
			update estado_resultado set utilidades_retenidas = utilidades_retenidas + new.monto where idestado_resultado = new.idestado_resultado;
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
/*!50003 SET sql_mode              = 'STRICT_ALL_TABLES,NO_AUTO_CREATE_USER' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 */ /*!50003 TRIGGER `contable`.`estado_resultado_detalle_BEFORE_UPDATE` BEFORE UPDATE ON `estado_resultado_detalle` FOR EACH ROW
BEGIN
	if new.monto = 0 then
		set new.estado = 'Inactivo';
    end if;
	if new.estado != old.estado then
		if new.estado = 'Inactivo' then
			set new.monto = 0;
        end if;
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
/*!50003 SET sql_mode              = 'STRICT_ALL_TABLES,NO_AUTO_CREATE_USER' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 */ /*!50003 TRIGGER `contable`.`estado_resultado_detalle_AFTER_UPDATE` AFTER UPDATE ON `estado_resultado_detalle` FOR EACH ROW
BEGIN
	if new.monto != old.monto then
		if new.idclase_resultado = 1 then
			update estado_resultado set venta_netas = venta_netas  + (new.monto-old.monto)  where idestado_resultado = new.idestado_resultado;
		elseif new.idclase_resultado = 2 then
			update estado_resultado set costo_ventas = costo_ventas  + (new.monto-old.monto)  where idestado_resultado = new.idestado_resultado;
		elseif new.idclase_resultado = 3 then
			update estado_resultado set depreciacion = depreciacion  + (new.monto-old.monto)  where idestado_resultado = new.idestado_resultado;
		elseif new.idclase_resultado = 4 then
			update estado_resultado set interes_pagado = interes_pagado  + (new.monto-old.monto)  where idestado_resultado = new.idestado_resultado;
		elseif new.idclase_resultado = 5 then
			update estado_resultado set impuestos = impuestos  + (new.monto-old.monto)  where idestado_resultado = new.idestado_resultado;
		elseif new.idclase_resultado = 6 then
			update estado_resultado set dividendos = dividendos  + (new.monto-old.monto)  where idestado_resultado = new.idestado_resultado;
		else
			update estado_resultado set utilidades_retenidas = utilidades_retenidas  + (new.monto-old.monto)  where idestado_resultado = new.idestado_resultado;
		end if;
    end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `flujo_efectivo`
--

DROP TABLE IF EXISTS `flujo_efectivo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `flujo_efectivo` (
  `idflujo_efectivo` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) NOT NULL DEFAULT '0',
  `idperiodo_contable` int(11) NOT NULL DEFAULT '0',
  `fecha` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idflujo_efectivo`),
  KEY `FK_flujo_efectivo_periodo_contable` (`idperiodo_contable`),
  KEY `FK_flujo_efectivo_empresa` (`idempresa`),
  CONSTRAINT `FK_flujo_efectivo_empresa` FOREIGN KEY (`idempresa`) REFERENCES `empresa` (`idempresa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_flujo_efectivo_periodo_contable` FOREIGN KEY (`idperiodo_contable`) REFERENCES `periodo_contable` (`idperiodo_contable`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flujo_efectivo`
--

LOCK TABLES `flujo_efectivo` WRITE;
/*!40000 ALTER TABLE `flujo_efectivo` DISABLE KEYS */;
INSERT INTO `flujo_efectivo` VALUES (7,1,1,'2016-06-18 03:55:51'),(8,1,2,'2016-06-18 09:54:31');
/*!40000 ALTER TABLE `flujo_efectivo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `flujo_efectivo_detalle`
--

DROP TABLE IF EXISTS `flujo_efectivo_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `flujo_efectivo_detalle` (
  `idflujo_efectivo_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `idflujo_efectivo` int(11) NOT NULL DEFAULT '0',
  `idgrupo_flujo_efectivo` int(11) NOT NULL DEFAULT '0',
  `idsubgrupo_cuenta_balance` int(11) DEFAULT NULL,
  `descripcion` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`idflujo_efectivo_detalle`),
  KEY `FK_flujo_efectivo_detalle_subgrupo_cuenta` (`idsubgrupo_cuenta_balance`),
  KEY `FK_flujo_efectivo_detalle_flujo_efectivo` (`idflujo_efectivo`),
  KEY `FK_flujo_efectivo_detalle_grupo_flujo_efectivo` (`idgrupo_flujo_efectivo`),
  CONSTRAINT `FK_flujo_efectivo_detalle_flujo_efectivo` FOREIGN KEY (`idflujo_efectivo`) REFERENCES `flujo_efectivo` (`idflujo_efectivo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_flujo_efectivo_detalle_grupo_flujo_efectivo` FOREIGN KEY (`idgrupo_flujo_efectivo`) REFERENCES `grupo_flujo_efectivo` (`idgrupo_flujo_efectivo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_flujo_efectivo_detalle_subgrupo_cuenta` FOREIGN KEY (`idsubgrupo_cuenta_balance`) REFERENCES `subgrupo_cuenta` (`idsubgrupo_cuenta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2576 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flujo_efectivo_detalle`
--

LOCK TABLES `flujo_efectivo_detalle` WRITE;
/*!40000 ALTER TABLE `flujo_efectivo_detalle` DISABLE KEYS */;
INSERT INTO `flujo_efectivo_detalle` VALUES (2522,7,1,6,NULL,7567688.00),(2523,7,2,NULL,'Utilidad neta',2140030.00),(2524,7,2,NULL,'Depreciacion',19379168.00),(2525,7,2,7,NULL,929127.00),(2526,7,2,9,NULL,377709.00),(2527,7,3,39,NULL,-3262520.00),(2528,7,3,40,NULL,123345.00),(2529,7,3,10,NULL,3162057.00),(2530,7,3,12,NULL,736674.00),(2531,7,3,41,NULL,6691996.00),(2532,7,3,42,NULL,1620528.00),(2533,7,3,43,NULL,427886.00),(2534,7,3,44,NULL,-201822.00),(2540,7,2,17,NULL,-11255626.00),(2541,7,2,45,NULL,-200797.00),(2542,7,2,47,NULL,-320999.00),(2543,7,2,48,NULL,-596909.00),(2544,7,3,46,NULL,768548.00),(2545,7,4,35,NULL,2855350.00),(2546,7,4,36,NULL,-4213360.00),(2547,7,3,NULL,'Depreciacion',-19379168.00),(2548,7,4,NULL,'Dividendos pagados',0.00),(2549,8,1,6,NULL,5276123.00),(2550,8,2,NULL,'Utilidad neta',3222424.00),(2551,8,2,NULL,'Depreciacion',20733420.00),(2552,8,2,7,NULL,-100358.00),(2553,8,2,9,NULL,365938.00),(2554,8,3,40,NULL,-197795.00),(2555,8,3,10,NULL,3444587.00),(2556,8,3,12,NULL,-5041212.00),(2557,8,3,41,NULL,-1638569.00),(2558,8,3,42,NULL,-2497857.00),(2559,8,3,43,NULL,-565884.00),(2560,8,3,44,NULL,-628841.00),(2567,8,2,17,NULL,-2614588.00),(2568,8,2,45,NULL,71887.00),(2569,8,2,47,NULL,844292.00),(2570,8,2,48,NULL,2806252.00),(2571,8,3,46,NULL,1128596.00),(2572,8,4,35,NULL,2117509.00),(2573,8,4,36,NULL,1575184.00),(2574,8,3,NULL,'Depreciacion',-20733420.00),(2575,8,4,NULL,'Dividendos pagados',0.00);
/*!40000 ALTER TABLE `flujo_efectivo_detalle` ENABLE KEYS */;
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
INSERT INTO `grupo_cuenta` VALUES (1,1,'Circulante','11','Corriente','Activo'),(2,1,'Fijo','12','No Corriente','Activo'),(3,2,'Prevision para cuentas incobrables, depreciac','21','Prevision para cuentas incobrables, depreciac','Activo'),(4,3,'Circulante','31','Corriente','Activo'),(5,3,'Fijo','32','No Corriente','Activo'),(6,4,'Otras Cuentas Acreedoras','40','','Activo'),(7,5,'Capital, Reservas y Resultados','51','','Activo'),(8,6,'Cuentas de Orden per Contra','61','','Activo'),(9,7,'Ingresos','71','','Activo'),(10,8,'Gastos de Operación','81','','Activo');
/*!40000 ALTER TABLE `grupo_cuenta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo_flujo_efectivo`
--

DROP TABLE IF EXISTS `grupo_flujo_efectivo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo_flujo_efectivo` (
  `idgrupo_flujo_efectivo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT ' ',
  `tipo_saldo` enum('+','-') CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '+',
  PRIMARY KEY (`idgrupo_flujo_efectivo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_flujo_efectivo`
--

LOCK TABLES `grupo_flujo_efectivo` WRITE;
/*!40000 ALTER TABLE `grupo_flujo_efectivo` DISABLE KEYS */;
INSERT INTO `grupo_flujo_efectivo` VALUES (1,'Efectivo al inicio del periodo','+'),(2,'Actividades de operacion','+'),(3,'Actividades de inversion','-'),(4,'Actividades de financiamiento','-'),(6,'Efectivo al final del periodo','+');
/*!40000 ALTER TABLE `grupo_flujo_efectivo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo_resultado`
--

DROP TABLE IF EXISTS `grupo_resultado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo_resultado` (
  `idgrupo_resultado` int(11) NOT NULL AUTO_INCREMENT,
  `idclase_resultado` int(11) NOT NULL DEFAULT '1',
  `nombre` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_bin NOT NULL DEFAULT 'Activo',
  `idgrupo_flujo_efectivo` int(11) DEFAULT NULL,
  PRIMARY KEY (`idgrupo_resultado`),
  KEY `fk_grupo_resultado_idclase_resultado_idx` (`idclase_resultado`),
  KEY `FK_grupo_resultado_grupo_flujo_efectivo` (`idgrupo_flujo_efectivo`),
  CONSTRAINT `FK_grupo_resultado_grupo_flujo_efectivo` FOREIGN KEY (`idgrupo_flujo_efectivo`) REFERENCES `grupo_flujo_efectivo` (`idgrupo_flujo_efectivo`),
  CONSTRAINT `fk_grupo_resultado_idclase_resultado` FOREIGN KEY (`idclase_resultado`) REFERENCES `clase_resultado` (`idclase_resultado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_resultado`
--

LOCK TABLES `grupo_resultado` WRITE;
/*!40000 ALTER TABLE `grupo_resultado` DISABLE KEYS */;
INSERT INTO `grupo_resultado` VALUES (1,1,'Venta netas','Activo',NULL),(2,2,'Costo de ventas','Activo',NULL),(3,3,'Depreciación','Activo',NULL),(4,4,'Intereses pagados','Activo',NULL),(5,5,'Impuestos','Activo',NULL),(6,6,'Dividendos','Activo',NULL),(7,7,'Aumento en las utilidades retenidas','Activo',NULL),(8,1,'Ingresos totales','Activo',NULL),(9,2,'Costo de los ingresos','Activo',NULL),(10,3,'Gasto de ventas y administración','Activo',NULL),(11,3,'Gastos operativos','Activo',NULL),(12,4,'Otros intereses','Activo',NULL);
/*!40000 ALTER TABLE `grupo_resultado` ENABLE KEYS */;
UNLOCK TABLES;

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
/*!50003 CREATE*/ /*!50017 */ /*!50003 TRIGGER `contable`.`partida_BEFORE_INSERT` BEFORE INSERT ON `partida` FOR EACH ROW
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
-- Table structure for table `periodo_contable`
--

DROP TABLE IF EXISTS `periodo_contable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `periodo_contable` (
  `idperiodo_contable` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_bin DEFAULT 'Activo',
  `estatus` enum('Pasado','Presente','Futuro') COLLATE utf8_bin NOT NULL DEFAULT 'Futuro',
  PRIMARY KEY (`idperiodo_contable`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `periodo_contable`
--

LOCK TABLES `periodo_contable` WRITE;
/*!40000 ALTER TABLE `periodo_contable` DISABLE KEYS */;
INSERT INTO `periodo_contable` VALUES (1,'2015','2015-01-11','2015-12-31','Activo','Pasado'),(2,'2014','2014-01-11','2014-12-31','Activo','Pasado'),(3,'2013','2013-01-11','2013-12-31','Activo','Pasado'),(4,'2012','2012-01-11','2012-12-31','Activo','Pasado'),(5,'2016','2016-01-11','2016-12-31','Activo','Futuro'),(6,'2017','2017-01-11','2017-12-31','Activo','Futuro'),(7,'2018','2018-01-11','2018-12-31','Activo','Futuro'),(8,'2019','2019-01-11','2019-12-31','Activo','Futuro'),(9,'2020','2020-01-11','2020-12-31','Activo','Futuro');
/*!40000 ALTER TABLE `periodo_contable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `razones_financieras`
--

DROP TABLE IF EXISTS `razones_financieras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `razones_financieras` (
  `idrazon_financiera` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) NOT NULL DEFAULT '0',
  `idperiodo_contable` int(11) NOT NULL DEFAULT '0',
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idrazon_financiera`),
  KEY `fk_razones_financieras_empresa` (`idempresa`),
  KEY `fk_razones_financieras_periodo_contable` (`idperiodo_contable`),
  CONSTRAINT `fk_razones_financieras_empresa` FOREIGN KEY (`idempresa`) REFERENCES `empresa` (`idempresa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_razones_financieras_periodo_contable` FOREIGN KEY (`idperiodo_contable`) REFERENCES `periodo_contable` (`idperiodo_contable`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `razones_financieras`
--

LOCK TABLES `razones_financieras` WRITE;
/*!40000 ALTER TABLE `razones_financieras` DISABLE KEYS */;
INSERT INTO `razones_financieras` VALUES (4,1,1,'Activo'),(5,1,2,'Activo'),(6,1,3,'Activo'),(7,1,4,'Activo');
/*!40000 ALTER TABLE `razones_financieras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `razones_financieras_detalle`
--

DROP TABLE IF EXISTS `razones_financieras_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `razones_financieras_detalle` (
  `idrazon_financiera_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `idrazon_financiera` int(11) NOT NULL DEFAULT '0',
  `idtipo_razon_financiera` int(11) NOT NULL DEFAULT '0',
  `valor` float NOT NULL DEFAULT '0',
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idrazon_financiera_detalle`),
  KEY `fk_tipo_razon_financiera` (`idtipo_razon_financiera`),
  KEY `fk_razones_financieras_razones_financieras_detalle` (`idrazon_financiera`),
  CONSTRAINT `fk_razones_financieras_razones_financieras_detalle` FOREIGN KEY (`idrazon_financiera`) REFERENCES `razones_financieras` (`idrazon_financiera`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tipo_razon_financiera` FOREIGN KEY (`idtipo_razon_financiera`) REFERENCES `tipo_razon_financiera` (`idtipo_razon_financiera`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2083 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `razones_financieras_detalle`
--

LOCK TABLES `razones_financieras_detalle` WRITE;
/*!40000 ALTER TABLE `razones_financieras_detalle` DISABLE KEYS */;
INSERT INTO `razones_financieras_detalle` VALUES (1797,6,1,0.9,'Activo'),(1798,6,2,0.77,'Activo'),(1799,6,3,0.25,'Activo'),(1800,6,4,-2.59,'Activo'),(1801,6,5,251,'Activo'),(1802,6,6,0.79,'Activo'),(1803,6,7,3.76,'Activo'),(1804,6,8,4.76,'Activo'),(1805,6,9,0.69,'Activo'),(1806,6,10,3.16,'Activo'),(1807,6,11,8.75,'Activo'),(1808,6,12,9.76,'Activo'),(1809,6,13,37,'Activo'),(1810,6,14,6.08,'Activo'),(1811,6,15,59,'Activo'),(1812,6,16,-29.35,'Activo'),(1813,6,17,1,'Activo'),(1814,6,18,0.76,'Activo'),(1815,6,19,9.54,'Activo'),(1816,6,20,7.24,'Activo'),(1817,6,21,35.22,'Activo'),(1818,6,22,0.24,'Activo'),(1819,7,1,0.86,'Activo'),(1820,7,2,0.75,'Activo'),(1821,7,3,0.21,'Activo'),(1822,7,4,-3.41,'Activo'),(1823,7,5,226,'Activo'),(1824,7,6,0.75,'Activo'),(1825,7,7,3,'Activo'),(1826,7,8,4,'Activo'),(1827,7,9,0.62,'Activo'),(1828,7,10,6.85,'Activo'),(1829,7,11,18.45,'Activo'),(1830,7,12,11.89,'Activo'),(1831,7,13,30,'Activo'),(1832,7,14,6.41,'Activo'),(1833,7,15,56,'Activo'),(1834,7,16,-22.95,'Activo'),(1835,7,17,1,'Activo'),(1836,7,18,0.78,'Activo'),(1837,7,19,11.82,'Activo'),(1838,7,20,9.25,'Activo'),(1839,7,21,36.9,'Activo'),(1840,7,22,0.4,'Activo'),(2039,4,1,0.92,'Activo'),(2040,4,2,0.84,'Activo'),(2041,4,3,0.3,'Activo'),(2042,4,4,-2.49,'Activo'),(2043,4,5,342,'Activo'),(2044,4,6,0.89,'Activo'),(2045,4,7,8.09,'Activo'),(2046,4,8,9.09,'Activo'),(2047,4,9,0.79,'Activo'),(2048,4,10,1.66,'Activo'),(2049,4,11,5.58,'Activo'),(2050,4,12,11.75,'Activo'),(2051,4,13,31,'Activo'),(2052,4,14,5.73,'Activo'),(2053,4,15,63,'Activo'),(2054,4,16,-26.84,'Activo'),(2055,4,17,0.95,'Activo'),(2056,4,18,0.67,'Activo'),(2057,4,19,4.13,'Activo'),(2058,4,20,2.76,'Activo'),(2059,4,21,24.13,'Activo'),(2060,4,22,0.03,'Activo'),(2061,5,1,0.81,'Activo'),(2062,5,2,0.72,'Activo'),(2063,5,3,0.29,'Activo'),(2064,5,4,-5.48,'Activo'),(2065,5,5,293,'Activo'),(2066,5,6,0.84,'Activo'),(2067,5,7,5.25,'Activo'),(2068,5,8,6.25,'Activo'),(2069,5,9,0.73,'Activo'),(2070,5,10,2.26,'Activo'),(2071,5,11,6.66,'Activo'),(2072,5,12,10.75,'Activo'),(2073,5,13,33,'Activo'),(2074,5,14,5.77,'Activo'),(2075,5,15,63,'Activo'),(2076,5,16,-11.91,'Activo'),(2077,5,17,0.86,'Activo'),(2078,5,18,0.65,'Activo'),(2079,5,19,5.6,'Activo'),(2080,5,20,3.65,'Activo'),(2081,5,21,22.95,'Activo'),(2082,5,22,0.05,'Activo');
/*!40000 ALTER TABLE `razones_financieras_detalle` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subcuenta`
--

LOCK TABLES `subcuenta` WRITE;
/*!40000 ALTER TABLE `subcuenta` DISABLE KEYS */;
INSERT INTO `subcuenta` VALUES (1,23,'Caja Chica TI','111.103.01.01','','Activo');
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
  `idgrupo_flujo_efectivo` int(11) DEFAULT NULL,
  `tendencia` enum('Positiva','Negativa') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Positiva',
  PRIMARY KEY (`idsubgrupo_cuenta`),
  KEY `fk_subgrupo_cuenta_idgrupo_cuenta_idx` (`idgrupo_cuenta`),
  KEY `FK_subgrupo_cuenta_grupo_flujo_efectivo` (`idgrupo_flujo_efectivo`),
  CONSTRAINT `FK_subgrupo_cuenta_grupo_flujo_efectivo` FOREIGN KEY (`idgrupo_flujo_efectivo`) REFERENCES `grupo_flujo_efectivo` (`idgrupo_flujo_efectivo`),
  CONSTRAINT `fk_subgrupo_cuenta_idgrupo_cuenta` FOREIGN KEY (`idgrupo_cuenta`) REFERENCES `grupo_cuenta` (`idgrupo_cuenta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subgrupo_cuenta`
--

LOCK TABLES `subgrupo_cuenta` WRITE;
/*!40000 ALTER TABLE `subgrupo_cuenta` DISABLE KEYS */;
INSERT INTO `subgrupo_cuenta` VALUES (6,1,'Efectivo y Equivalentes de Efectivo','111','Efectivo y Equivalentes de Efectivo','Activo',NULL,'Positiva'),(7,1,'Cuentas por Cobrar','112','Cuentas por Cobrar','Activo',2,'Positiva'),(8,1,'Pagos Anticipados','113','Pagos Anticipados','Activo',NULL,'Positiva'),(9,1,'Inventarios o Existencias','114','Inventarios o Existencias','Activo',2,'Positiva'),(10,2,'Inversiones a Largo Plazo','121','','Activo',3,'Positiva'),(11,2,'Mobiliario y Equipo','122','','Activo',NULL,'Positiva'),(12,2,'Activos Intangibles','123','','Activo',3,'Positiva'),(13,2,'Cargos por Amortizar','124','','Activo',NULL,'Positiva'),(14,3,'Provisión para Cuentas Incobrables','211','','Activo',NULL,'Positiva'),(15,3,'Depreciaciones Acumuladas','212','','Activo',NULL,'Positiva'),(16,3,'Amortizaciones Acumuladas','213','','Activo',NULL,'Positiva'),(17,4,'Cuentas por Pagar a Corto Plazo','311','','Activo',2,'Positiva'),(18,4,'Cobros Anticipados','312','','Activo',NULL,'Positiva'),(19,5,'Cuentas por Pagar a Largo Plazo','321','','Activo',NULL,'Positiva'),(20,6,'Otras Cuentas Acreedoras','401','','Activo',NULL,'Positiva'),(21,7,'Capital Social','511','','Activo',NULL,'Positiva'),(22,7,'Reservas de Capital','512','','Activo',NULL,'Positiva'),(23,7,'Perdidas y/o Ganancias de Capital','513','','Activo',NULL,'Positiva'),(24,7,'Resultados Acumulados','514','','Activo',NULL,'Positiva'),(25,8,'Cuentas de Orden Débito','611','','Activo',NULL,'Positiva'),(26,8,'Cuentas de Orden Crédito','612','','Activo',NULL,'Positiva'),(27,9,'Ingresos de Operación','711','','Activo',NULL,'Positiva'),(28,9,'Otros Ingresos de Operación','712','','Activo',NULL,'Positiva'),(29,10,'Costo de Producción','810','','Activo',NULL,'Positiva'),(30,10,'Costo de Venta','811','','Activo',NULL,'Positiva'),(31,10,'Gastos de Distribución','812','','Activo',NULL,'Positiva'),(32,10,'Gastos de Administración','813','','Activo',NULL,'Positiva'),(33,10,'Otros Gastos','814','','Activo',NULL,'Positiva'),(34,2,'Planta y equipo neto','125','Planta y equipo neto','Activo',3,'Positiva'),(35,4,'Deuda corto plazo','313','Documentos por pagar a corto plazo','Activo',4,'Positiva'),(36,5,'Deuda a largo plazo','322','Deuda a largo plazo','Activo',4,'Positiva'),(37,7,'Acciones comunes y superavit pagados','515','Acciones comunes y superavit pagados','Activo',4,'Positiva'),(38,7,'Utilidades Retenidas','516','Utilidades Retenidas','Activo',NULL,'Positiva'),(39,1,'Inversiones a corto plazo','115','Inversiones a corto plazo','Activo',3,'Positiva'),(40,1,'Otros activos corrientes','116','Otros activos corrientes','Activo',3,'Positiva'),(41,2,'Activos fijos','126','Activos fijos','Activo',3,'Positiva'),(42,2,'Buena voluntad','127','Buena voluntad','Activo',3,'Positiva'),(43,2,'Otros activos fijos','128','Otros activos fijos','Activo',3,'Positiva'),(44,2,'Cargos por activos diferidos','129','Cargos por activos diferidos','Activo',3,'Positiva'),(45,4,'Otros pasivos corrientes','314','Otros pasivos corrientes','Activo',2,'Positiva'),(46,5,'Otros pasivos fijos','323','Otros pasivos fijos','Activo',3,'Positiva'),(47,5,'Cargos por pasivos diferidos','324','Cargos por pasivos diferidos','Activo',2,'Positiva'),(48,5,'Interés minoritario','325','Interés minoritario','Activo',2,'Positiva');
/*!40000 ALTER TABLE `subgrupo_cuenta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_razon_financiera`
--

DROP TABLE IF EXISTS `tipo_razon_financiera`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_razon_financiera` (
  `idtipo_razon_financiera` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  `estado` enum('Activo','Inactivo') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'Activo',
  `agrupacion` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT ' ',
  `interpretacion` varchar(10) COLLATE utf8_spanish_ci DEFAULT ' ',
  PRIMARY KEY (`idtipo_razon_financiera`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_razon_financiera`
--

LOCK TABLES `tipo_razon_financiera` WRITE;
/*!40000 ALTER TABLE `tipo_razon_financiera` DISABLE KEYS */;
INSERT INTO `tipo_razon_financiera` VALUES (1,'Razon circulante','Activo','I','veces'),(2,'Razon rapida','Activo','I','veces'),(3,'Razon de efectivo','Activo','I','veces'),(4,'Capital de trabajo neto a activos totales','Activo','I','%'),(5,'Medida del intervalo','Activo','I','dias'),(6,'Razon de deduda total','Activo','II','%'),(7,'Razon deuda-capital','Activo','II','veces'),(8,'Multiplicador del capital','Activo','II','veces'),(9,'Razon de deuda a largo plazo','Activo','II','veces'),(10,'Razon de veces que se ha ganado el interes','Activo','II','veces'),(11,'Razon de cobertura de efectivo','Activo','II','veces'),(12,'Rotacion de inventario','Activo','III','veces'),(13,'Dias de ventas en inventario','Activo','III','dias'),(14,'Rotacion de cuentas por cobrar','Activo','III','veces'),(15,'Dias de ventas en cuentas por cobrar','Activo','III','dias'),(16,'Rotacion de capital de trabajo neto','Activo','III','veces'),(17,'Rotacion de activos fijos','Activo','III','veces'),(18,'Rotacion de activos totales','Activo','III','veces'),(19,'Margen de utilidad','Activo','IV','%'),(20,'Rendimiento sobre los activos','Activo','IV','%'),(21,'Rendimiento sobre el capital','Activo','IV','%'),(22,'ROE','Activo','IV','%');
/*!40000 ALTER TABLE `tipo_razon_financiera` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `view_estado_flujo_efectivo`
--

DROP TABLE IF EXISTS `view_estado_flujo_efectivo`;
/*!50001 DROP VIEW IF EXISTS `view_estado_flujo_efectivo`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_estado_flujo_efectivo` AS SELECT 
 1 AS `idempresa`,
 1 AS `nombre_empresa`,
 1 AS `ticker`,
 1 AS `idperiodo_contable`,
 1 AS `anio`,
 1 AS `idgrupo_flujo_efectivo`,
 1 AS `tipo_saldo`,
 1 AS `actividad`,
 1 AS `subactividad`,
 1 AS `monto`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_razones_financieras`
--

DROP TABLE IF EXISTS `view_razones_financieras`;
/*!50001 DROP VIEW IF EXISTS `view_razones_financieras`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_razones_financieras` AS SELECT 
 1 AS `idrazon_financiera_detalle`,
 1 AS `idrazon_financiera`,
 1 AS `idempresa`,
 1 AS `idperiodo_contable`,
 1 AS `agrupacion`,
 1 AS `nombre`,
 1 AS `valor`,
 1 AS `interpretacion`*/;
SET character_set_client = @saved_cs_client;

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
CREATE  FUNCTION `obtener_configuracion`(pcodigo varchar(45), pidempresa int) RETURNS varchar(45) CHARSET utf8 COLLATE utf8_spanish_ci
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
CREATE  FUNCTION `obtener_correlativo`(pcodigo varchar(45), pidempresa int) RETURNS int(11)
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
/*!50003 DROP FUNCTION IF EXISTS `obtener_idclase_cuenta` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  FUNCTION `obtener_idclase_cuenta`(pid int) RETURNS int(11)
BEGIN
	declare respuesta int default 0;
    select gc.idclase_cuenta into respuesta 
	from grupo_cuenta gc
    inner join subgrupo_cuenta sc on gc.idgrupo_cuenta = sc.idgrupo_cuenta
    where sc.idsubgrupo_cuenta = pid;
    
RETURN respuesta;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `obtener_idclase_resultado` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  FUNCTION `obtener_idclase_resultado`(pid int) RETURNS int(11)
BEGIN
	declare respuesta int default 0;
    select cr.idclase_resultado into respuesta 
	from grupo_resultado cr 
    where cr.idgrupo_resultado = pid;
    
RETURN respuesta;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `obtener_idgrupo_cuenta` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  FUNCTION `obtener_idgrupo_cuenta`(pid int) RETURNS int(11)
BEGIN
	declare respuesta int default 0;
    select gc.idgrupo_cuenta into respuesta 
	from subgrupo_cuenta gc
    where gc.idsubgrupo_cuenta = pid;
    
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
CREATE  FUNCTION `validar_sucursal_casa_matriz`(pidempresa int, pidsucursal int) RETURNS int(11)
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
CREATE  PROCEDURE `pr_abonar_cuenta`(in p_idcuenta int, in p_monto decimal(10,2))
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
CREATE  PROCEDURE `pr_cargar_cuenta`(in p_idcuenta int, in p_monto decimal(10,2))
BEGIN
	update cuenta set debe = debe + p_monto where idcuenta = p_idcuenta;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `pr_generar_flujo_efectivo` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `pr_generar_flujo_efectivo`(IN `anio_inicio` VARCHAR(4), IN `anio_fin` VARCHAR(4), IN `idempresa` INT)
BEGIN

	set @año1 = anio_inicio;
	set @año2 = anio_fin;
	set @idempresa=idempresa;
	set @idcuenta_efectivo=6;

	
	select 
		p.idperiodo_contable into	@idperiodo_contable
	from periodo_contable p
	where p.nombre=@año2;


	if not exists(select * from flujo_efectivo f inner join periodo_contable p on f.idperiodo_contable=p.idperiodo_contable where  p.nombre=@año2 and f.idempresa=@idempresa limit 1) then

		insert into flujo_efectivo 
			(idempresa,idperiodo_contable,fecha)
		values
			(@idempresa,@idperiodo_contable,NOW());
	end if;


	select 
		f.idflujo_efectivo into @idflujo_efectivo
	from 
		flujo_efectivo f
		inner join periodo_contable p on f.idperiodo_contable=p.idperiodo_contable
	where 
		f.idempresa=@idempresa and p.nombre=@año2;

			
	delete from flujo_efectivo_detalle where idflujo_efectivo =@idflujo_efectivo;

	
	#Obtiene los datos del estado de resultados
	select 
		resultado.utilidad_neta,
		resultado.depreciacion,
		resultado.dividendos,
		resultado.utilidades_retenidas
		into
		@UtilidadNeta,
		@Depreciacion,
		@DividendosPagados,
		@AccionesRetenidas
	from
		estado_resultado resultado
		inner join periodo_contable periodo on resultado.idperiodo_contable=periodo.idperiodo_contable
	where 
		resultado.idempresa=@idempresa and periodo.nombre=@año2 and resultado.estado='Activo';


	#Inserta efectivo
	set @idgrupoefectivo:=1;
	insert into flujo_efectivo_detalle (idflujo_efectivo, idgrupo_flujo_efectivo,idsubgrupo_cuenta_balance,monto)
	select 
		@idflujo_efectivo,
		@idgrupoefectivo, 
		subgrupo.idsubgrupo_cuenta,
		detalle.monto 		
	from 
		balance_general balance
		inner join balance_general_detalle detalle on balance.idbalance_general=detalle.idbalance_general
		inner join subgrupo_cuenta subgrupo on detalle.idsubgrupo_cuenta=subgrupo.idsubgrupo_cuenta 	
		inner join grupo_cuenta grupo on subgrupo.idgrupo_cuenta=grupo.idgrupo_cuenta
		inner join periodo_contable periodo on balance.idperiodo_contable=periodo.idperiodo_contable
		inner join clase_cuenta clase on  grupo.idclase_cuenta=clase.idclase_cuenta
	where
	   balance.idempresa=@idempresa and	periodo.nombre=@año1
	   and subgrupo.idsubgrupo_cuenta=@idcuenta_efectivo #cuenta de efectivo
	   and balance.estado='Activo' and detalle.estado='Activo';

	

	#*******************actividad de operacion*************************

	#Insertar Utilidad
	set @idgrupoefectivo:=2;
	insert into flujo_efectivo_detalle
		(idflujo_efectivo, idgrupo_flujo_efectivo,descripcion,monto)
	values
		(@idflujo_efectivo,@idgrupoefectivo,'Utilidad neta',@UtilidadNeta);	

	#Insertar depreciacion
	set @idgrupoefectivo:=2; 
	insert into flujo_efectivo_detalle 
		(idflujo_efectivo, idgrupo_flujo_efectivo,descripcion,monto)
	values
		(@idflujo_efectivo,@idgrupoefectivo,'Depreciacion',@Depreciacion );

	

	#Inserta Cuentas de operacion

	
	#cuentas de activo

	insert into flujo_efectivo_detalle
		(idflujo_efectivo, idgrupo_flujo_efectivo,idsubgrupo_cuenta_balance,monto)
	select 
		@idflujo_efectivo,
		efectivo.idgrupo_flujo_efectivo,
		subgrupo.idsubgrupo_cuenta,
		sum(case @año1 
			when periodo.nombre then detalle.monto 
			else 0
		end)-
		sum(case @año2 
			when periodo.nombre then detalle.monto 
			else 0
		end)	
	from 
		balance_general balance
		inner join balance_general_detalle detalle on balance.idbalance_general=detalle.idbalance_general
		inner join subgrupo_cuenta subgrupo on detalle.idsubgrupo_cuenta=subgrupo.idsubgrupo_cuenta
		inner join grupo_flujo_efectivo efectivo on subgrupo.idgrupo_flujo_efectivo=efectivo.idgrupo_flujo_efectivo 	
		inner join grupo_cuenta grupo on subgrupo.idgrupo_cuenta=grupo.idgrupo_cuenta
		inner join periodo_contable periodo on balance.idperiodo_contable=periodo.idperiodo_contable
		inner join clase_cuenta clase on  grupo.idclase_cuenta=clase.idclase_cuenta
	where
	   balance.idempresa=@idempresa and	periodo.nombre between @año1 and @año2
	   and clase.idclase_cuenta=1 #ACTIVO
	   and balance.estado='Activo' and detalle.estado='Activo'
	group by
		efectivo.idgrupo_flujo_efectivo,
		grupo.idgrupo_cuenta,
		subgrupo.idsubgrupo_cuenta;
	

	#cuentas de pasivo
	
	
	select 
		detalle.monto into @efectivoFinal 		
	from 
		balance_general balance
		inner join balance_general_detalle detalle on balance.idbalance_general=detalle.idbalance_general
		inner join subgrupo_cuenta subgrupo on detalle.idsubgrupo_cuenta=subgrupo.idsubgrupo_cuenta 	
		inner join grupo_cuenta grupo on subgrupo.idgrupo_cuenta=grupo.idgrupo_cuenta
		inner join periodo_contable periodo on balance.idperiodo_contable=periodo.idperiodo_contable
		inner join clase_cuenta clase on  grupo.idclase_cuenta=clase.idclase_cuenta
	where
	   balance.idempresa=@idempresa and	periodo.nombre=@año2
	   and subgrupo.idsubgrupo_cuenta=@idcuenta_efectivo #cuenta de efectivo
	   and balance.estado='Activo' and detalle.estado='Activo';
	
	
	select 
		detalle.monto into @efectivoInicial
	from 
		balance_general balance
		inner join balance_general_detalle detalle on balance.idbalance_general=detalle.idbalance_general
		inner join subgrupo_cuenta subgrupo on detalle.idsubgrupo_cuenta=subgrupo.idsubgrupo_cuenta 	
		inner join grupo_cuenta grupo on subgrupo.idgrupo_cuenta=grupo.idgrupo_cuenta
		inner join periodo_contable periodo on balance.idperiodo_contable=periodo.idperiodo_contable
		inner join clase_cuenta clase on  grupo.idclase_cuenta=clase.idclase_cuenta
	where
	   balance.idempresa=@idempresa and	periodo.nombre=@año1
	   and subgrupo.idsubgrupo_cuenta=@idcuenta_efectivo #cuenta de efectivo
	   and balance.estado='Activo' and detalle.estado='Activo';
	
		
	


	insert into flujo_efectivo_detalle 
		(idflujo_efectivo, idgrupo_flujo_efectivo,idsubgrupo_cuenta_balance,monto)
	select 
		@idflujo_efectivo,
		efectivo.idgrupo_flujo_efectivo,
		subgrupo.idsubgrupo_cuenta,
		sum(case @año2 
			when periodo.nombre then detalle.monto 
			else 0
		end)-
		sum(case @año1 
			when periodo.nombre then detalle.monto 
			else 0
		end)
	from 
		balance_general balance
		inner join balance_general_detalle detalle on balance.idbalance_general=detalle.idbalance_general
		inner join subgrupo_cuenta subgrupo on detalle.idsubgrupo_cuenta=subgrupo.idsubgrupo_cuenta
		inner join grupo_flujo_efectivo efectivo on subgrupo.idgrupo_flujo_efectivo=efectivo.idgrupo_flujo_efectivo 	
		inner join grupo_cuenta grupo on subgrupo.idgrupo_cuenta=grupo.idgrupo_cuenta
		inner join periodo_contable periodo on balance.idperiodo_contable=periodo.idperiodo_contable
		inner join clase_cuenta clase on  grupo.idclase_cuenta=clase.idclase_cuenta
	where
	   balance.idempresa=@idempresa and	periodo.nombre between @año1 and @año2
	   and clase.idclase_cuenta=3 #PASIVO
	   and balance.estado='Activo' and detalle.estado='Activo'
	group by
		efectivo.idgrupo_flujo_efectivo,
		grupo.idgrupo_cuenta,
		subgrupo.idsubgrupo_cuenta;
		
	SET @last_id = LAST_INSERT_ID();	
	#	
		

	#cuentas de capital
	insert into flujo_efectivo_detalle 
		(idflujo_efectivo, idgrupo_flujo_efectivo,idsubgrupo_cuenta_balance,monto)
	select 
		@idflujo_efectivo,
		efectivo.idgrupo_flujo_efectivo,
		subgrupo.idsubgrupo_cuenta,
		sum(case @año2 
			when periodo.nombre then detalle.monto 
			else 0
		end)-
		sum(case @año1 
			when periodo.nombre then detalle.monto 
			else 0
		end)
	from 
		balance_general balance
		inner join balance_general_detalle detalle on balance.idbalance_general=detalle.idbalance_general
		inner join subgrupo_cuenta subgrupo on detalle.idsubgrupo_cuenta=subgrupo.idsubgrupo_cuenta
		inner join grupo_flujo_efectivo efectivo on subgrupo.idgrupo_flujo_efectivo=efectivo.idgrupo_flujo_efectivo 	
		inner join grupo_cuenta grupo on subgrupo.idgrupo_cuenta=grupo.idgrupo_cuenta
		inner join periodo_contable periodo on balance.idperiodo_contable=periodo.idperiodo_contable
		inner join clase_cuenta clase on  grupo.idclase_cuenta=clase.idclase_cuenta
	where
	   balance.idempresa=@idempresa and	periodo.nombre between @año1 and @año2
	   and clase.idclase_cuenta=5 #capital
	   and balance.estado='Activo' and detalle.estado='Activo'
	group by
		efectivo.idgrupo_flujo_efectivo,
		grupo.idgrupo_cuenta,
		subgrupo.idsubgrupo_cuenta;
	
	#Insertar Depreciaciones
	set @idgrupoefectivo:=3; 
	insert into flujo_efectivo_detalle
		(idflujo_efectivo, idgrupo_flujo_efectivo,descripcion,monto)
	values
		(@idflujo_efectivo,@idgrupoefectivo,'Depreciacion',@Depreciacion*-1 );

	
	#Insertar Dividendo
	set @idgrupoefectivo:=4; 
	insert into flujo_efectivo_detalle 
		(idflujo_efectivo, idgrupo_flujo_efectivo,descripcion,monto)
	values
		(@idflujo_efectivo,@idgrupoefectivo,'Dividendos pagados',@DividendosPagados*-1 );
		
	
	select sum(detalle.monto) into @sumatotal from flujo_efectivo_detalle detalle where detalle.idflujo_efectivo=@idflujo_efectivo;
	
	set @diferencial:= @efectivoFinal-@sumatotal;

	#select @diferencial,@sumatotal;
	update flujo_efectivo_detalle detalle  set detalle.monto=detalle.monto+@diferencial where detalle.idflujo_efectivo_detalle=@last_id;
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `pr_razones_financieras` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `pr_razones_financieras`(IN `idempresa` INT, IN `idperiodo_contable` INT)
BEGIN


#Parametros

set @idempresa:=idempresa;

#cuentas balance general

set @idcuentaefectivo:=6;

set @idcuentas_x_cobrar:=7;

set @idinventarios:=9;

set @iddeuda_largo_plazo := 36;


set @idperiodo = idperiodo_contable;



/*--Datos de estados de resultados--*/

select

	resultado.venta_netas,resultado.costo_ventas,resultado.depreciacion,

	resultado.venta_netas -  resultado.costo_ventas - resultado.depreciacion, #Utilidades Antes de los Intereses e Impuestos

	resultado.interes_pagado,resultado.utilidad_neta

	 into 

	 @ventas,@costos,@depreciacion,

	 @uaii,

	 @intereses_pagados, @utilidad_neta

from 

	estado_resultado resultado

where

	resultado.idempresa=@idempresa

	and resultado.idperiodo_contable=@idperiodo

	and resultado.estado = 'Activo';

/*--Datos de estados del balance general--*/

select 

	balance.activo_circulante+balance.activo_fijo, 

	balance.pasivo_circulante+balance.pasivo_fijo,

	balance.activo_circulante-balance.pasivo_circulante,

	(balance.activo_circulante + balance.activo_fijo)-(balance.pasivo_circulante + balance.pasivo_fijo),

	sum(if(detalle.idsubgrupo_cuenta=@idinventarios, detalle.monto, 0)),

	sum(if(detalle.idsubgrupo_cuenta=@idcuentaefectivo,detalle.monto,0)),

	sum(if(detalle.idsubgrupo_cuenta=@iddeuda_largo_plazo,detalle.monto,0)),

	sum(if(detalle.idsubgrupo_cuenta=@idcuentas_x_cobrar,detalle.monto,0))

	into

	@activo_total,

	@pasivo_total,

	@capital_trabajo,

	@capital_contable,

	@inventarios,

	@efectivo,

	@deuda_largo_plazo,

	@cuentas_x_cobrar

from 

	balance_general balance

	inner join balance_general_detalle detalle on balance.idbalance_general=detalle.idbalance_general

where

	balance.idempresa=@idempresa 

	and balance.idperiodo_contable=@idperiodo
	
	and balance.estado = 'Activo'

group by

	balance.activo_circulante,

	balance.activo_fijo,

	balance.pasivo_circulante,

	balance.pasivo_fijo;



SET @deuda_total:=(@activo_total-@capital_contable)/(@activo_total);





	

/*----------------------RAZONES FINANCIERAS------------------*/

select 

	#-----Medidas de liquidez a corto plazo

	round(balance.activo_circulante/balance.pasivo_circulante,2),

	round((balance.activo_circulante-@inventarios)/balance.pasivo_circulante,2),

	round(@efectivo/balance.pasivo_circulante,2),

	round((@capital_trabajo/@activo_total)*100,2),

	floor(balance.activo_circulante/(@costos/365)),

	

	round(@deuda_total,2),

	round(@deuda_total/(1-@deuda_total),2),

	round(1/(1-@deuda_total),2),

	round(@deuda_largo_plazo/(@deuda_largo_plazo+@capital_contable),2),

	round(@uaii / @intereses_pagados,2),

	round((@uaii + @depreciacion)/@intereses_pagados,2),

	

	round(@costos/@inventarios,2),

	floor(365/(@costos/@inventarios)),

	round(@ventas/@cuentas_x_cobrar,2),

	floor(365/(@ventas/@cuentas_x_cobrar)),

	round(@ventas/@capital_trabajo,2),

	round(@ventas/balance.activo_fijo,2),

	round(@ventas/@activo_total,2),

	round((@utilidad_neta / @ventas)*100,2),

	round((@utilidad_neta / @activo_total)*100,2),

	round((@utilidad_neta / @capital_contable)*100,2) 

	into

	@razon_circulante,

	@razon_rapida,

	@razon_de_efectivo,

	@cap_trab_neto,

	@medida_intervalo,

	#-----Medidas de liquidez a largo plazo o de apalancamiento 

	@deuda_total,

	@razon_deuda_capital,

	@multiplicador_capital,

	@deuda_largo_plazo,

	@veces_interes_ganado,

	@cobertura_efectivo,

	 #-----Medidas de actividad o rotacion de activos

	@rotacion_inventario,

	@dias_venta_inventario,

	@rotacion_cuentas_x_cobrar,

	@dias_ventas_cxc,

	@rotacion_capital_trabajo,

	@rotacion_activos_fijos,

	@rotacion_activo_total,

	 #Medidas de rentabilidad

	@margen_utilidad,

	@rendimiento_activos,

	@rendimiento_sobre_capital

from 

	balance_general balance

	inner join balance_general_detalle detalle on balance.idbalance_general=detalle.idbalance_general

where

	balance.idempresa=@idempresa 

	and balance.idperiodo_contable=@idperiodo
	
	and balance.estado = 'Activo'

group by

	balance.activo_circulante,

	balance.pasivo_circulante;




select  
	razones.idrazon_financiera into @idrazon_financiera
from razones_financieras razones
where razones.idempresa= @idempresa and razones.idperiodo_contable=@idperiodo;


if @idrazon_financiera is null then

	insert into razones_financieras 

		(idempresa,idperiodo_contable)

	values

		(@idempresa,@idperiodo);

	select  
		razones.idrazon_financiera into @idrazon_financiera
	from razones_financieras razones
	where razones.idempresa= @idempresa and razones.idperiodo_contable=@idperiodo;
	
	
end if;








delete from razones_financieras_detalle

where 

	idrazon_financiera=@idrazon_financiera;



#RAZON CIRCULANTE

insert into razones_financieras_detalle

	(idrazon_financiera, idtipo_razon_financiera,valor)

values

	(@idrazon_financiera,1,@razon_circulante);



#RAZON RAPIDA

insert into razones_financieras_detalle

	(idrazon_financiera, idtipo_razon_financiera,valor)

values

	(@idrazon_financiera,2,@razon_rapida);





#RAZON DE EFECTIVO

insert into razones_financieras_detalle

	(idrazon_financiera, idtipo_razon_financiera,valor)

values

	(@idrazon_financiera,3,@razon_de_efectivo);





#RAZON CAPITAL TRABAJO NETO

insert into razones_financieras_detalle

	(idrazon_financiera, idtipo_razon_financiera,valor)

values

	(@idrazon_financiera,4,@cap_trab_neto);



#RAZON MEDIDA DEL INTERVALO

insert into razones_financieras_detalle

	(idrazon_financiera, idtipo_razon_financiera,valor)

values

	(@idrazon_financiera,5,@medida_intervalo);





#RAZON DEUDA TOTAL

insert into razones_financieras_detalle

	(idrazon_financiera, idtipo_razon_financiera,valor)

values

	(@idrazon_financiera,6,@deuda_total);





#RAZON DEUDA-CAPITAL

insert into razones_financieras_detalle

	(idrazon_financiera, idtipo_razon_financiera,valor)

values

	(@idrazon_financiera,7,@razon_deuda_capital);





#RAZON MULTIPLICADOR DE CAPITAL

insert into razones_financieras_detalle

	(idrazon_financiera, idtipo_razon_financiera,valor)

values

	(@idrazon_financiera,8,@multiplicador_capital);





#RAZON DEUDA A LARGO PLAZO

insert into razones_financieras_detalle

	(idrazon_financiera, idtipo_razon_financiera,valor)

values

	(@idrazon_financiera,9,@deuda_largo_plazo);





#RAZON DE VECES QUE SE HA GANADO INTERES

insert into razones_financieras_detalle

	(idrazon_financiera, idtipo_razon_financiera,valor)

values

	(@idrazon_financiera,10,@veces_interes_ganado);



#RAZON DE COBERTURA DE EFECTIVO

insert into razones_financieras_detalle

	(idrazon_financiera, idtipo_razon_financiera,valor)

values

	(@idrazon_financiera,11,@cobertura_efectivo);

	

	

#RAZON ROTACION DE INVENTARIO

insert into razones_financieras_detalle

	(idrazon_financiera, idtipo_razon_financiera,valor)

values

	(@idrazon_financiera,12,@rotacion_inventario);

	



#RAZON DIAS DE VENTA EN INVENTARIO

insert into razones_financieras_detalle

	(idrazon_financiera, idtipo_razon_financiera,valor)

values

	(@idrazon_financiera,13,@dias_venta_inventario);

	

	

#RAZON ROTACION DE CUENTAS POR COBRAR

insert into razones_financieras_detalle

	(idrazon_financiera, idtipo_razon_financiera,valor)

values

	(@idrazon_financiera,14,@rotacion_cuent