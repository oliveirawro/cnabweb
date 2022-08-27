-- MySQL dump 10.13  Distrib 5.6.49, for Linux (x86_64)
--
-- Host: localhost    Database: cnabweb
-- ------------------------------------------------------
-- Server version	5.6.49-log

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
-- Table structure for table `Enterprise`
--

DROP TABLE IF EXISTS `Enterprise`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Enterprise` (
  `Code` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `LanguageCode` int(10) unsigned DEFAULT NULL,
  `TimeZoneCode` int(10) unsigned DEFAULT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Contact` varchar(100) DEFAULT NULL,
  `Phone` varchar(30) DEFAULT NULL,
  `NationalRegister` varchar(20) DEFAULT NULL,
  `Active` char(1) DEFAULT NULL,
  PRIMARY KEY (`Code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Enterprise`
--

LOCK TABLES `Enterprise` WRITE;
/*!40000 ALTER TABLE `Enterprise` DISABLE KEYS */;
INSERT INTO `Enterprise` VALUES (1,NULL,NULL,'bycoders','Jessica Lansky','+55 11 93217-2616',NULL,'1');
/*!40000 ALTER TABLE `Enterprise` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `FilesCnab`
--

DROP TABLE IF EXISTS `FilesCnab`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `FilesCnab` (
  `Code` int(10) NOT NULL AUTO_INCREMENT,
  `UserCode` int(10) unsigned NOT NULL,
  `FileName` text NOT NULL,
  `Amount` decimal(10,2) DEFAULT NULL,
  `Parsed` char(1) DEFAULT NULL,
  `DateTimeLoaded` datetime NOT NULL,
  PRIMARY KEY (`Code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `FilesCnab`
--

LOCK TABLES `FilesCnab` WRITE;
/*!40000 ALTER TABLE `FilesCnab` DISABLE KEYS */;
/*!40000 ALTER TABLE `FilesCnab` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TransactionCnab`
--

DROP TABLE IF EXISTS `TransactionCnab`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TransactionCnab` (
  `Code` int(10) NOT NULL AUTO_INCREMENT,
  `FilesCnabCode` int(10) DEFAULT NULL,
  `TransactionTypeCode` int(10) unsigned DEFAULT NULL,
  `DateOccurrence` date DEFAULT NULL,
  `Value` decimal(10,2) DEFAULT NULL,
  `NationalRegister` varchar(20) DEFAULT NULL,
  `Card` varchar(20) DEFAULT NULL,
  `TimeOccurrence` time DEFAULT NULL,
  `NameStoreOwner` varchar(200) DEFAULT NULL,
  `NameStore` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TransactionCnab`
--

LOCK TABLES `TransactionCnab` WRITE;
/*!40000 ALTER TABLE `TransactionCnab` DISABLE KEYS */;
/*!40000 ALTER TABLE `TransactionCnab` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TransactionType`
--

DROP TABLE IF EXISTS `TransactionType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TransactionType` (
  `Code` int(10) NOT NULL DEFAULT '0',
  `Description` varchar(100) DEFAULT NULL,
  `Category` varchar(100) DEFAULT NULL,
  `Signal` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`Code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TransactionType`
--

LOCK TABLES `TransactionType` WRITE;
/*!40000 ALTER TABLE `TransactionType` DISABLE KEYS */;
INSERT INTO `TransactionType` VALUES (1,'Débito','Entrada','+'),(2,'Boleto','Saída','-'),(3,'Financiamento','Saída','-'),(4,'Crédito','Entrada','+'),(5,'Recebimento Empréstimo','Entrada','+'),(6,'Vendas','Entrada','+'),(7,'Recebimento TED','Entrada','+'),(8,'Recebimento DOC','Entrada','+'),(9,'Aluguel','Saída','-');
/*!40000 ALTER TABLE `TransactionType` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User` (
  `Code` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EnterpriseCode` int(10) unsigned NOT NULL,
  `Name` varchar(80) DEFAULT NULL,
  `Login` varchar(80) NOT NULL,
  `Password` varchar(60) NOT NULL,
  `Phone` varchar(60) DEFAULT NULL,
  `Active` char(1) DEFAULT NULL,
  PRIMARY KEY (`Code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES (1,1,'Administrador','admin','10c4981bb793e1698a83aea43030a388',NULL,'1');
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-08-26 10:45:59
