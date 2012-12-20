-- MySQL dump 10.13  Distrib 5.1.62, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: evimail
-- ------------------------------------------------------
-- Server version	5.1.62-0ubuntu0.11.10.1

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
-- Table structure for table `credits`
--

DROP TABLE IF EXISTS `credits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `credits` (
  `cre_id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_id` int(11) NOT NULL,
  `cre_type` char(1) NOT NULL,
  `cre_value` decimal(10,2) NOT NULL,
  `cre_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cre_payed` char(1) NOT NULL,
  PRIMARY KEY (`cre_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `credits`
--

LOCK TABLES `credits` WRITE;
/*!40000 ALTER TABLE `credits` DISABLE KEYS */;
/*!40000 ALTER TABLE `credits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email`
--

DROP TABLE IF EXISTS `email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email` (
  `ema_id` int(11) NOT NULL AUTO_INCREMENT,
  `ema_userfrom` int(11) NOT NULL,
  `ema_userto` int(11) NOT NULL,
  `ema_emailfrom` varchar(255) NOT NULL,
  `ema_emailto` varchar(255) NOT NULL,
  `ema_cc` varchar(255) DEFAULT NULL,
  `ema_bcc` varchar(255) DEFAULT NULL,
  `ema_hash` varchar(60) NOT NULL,
  `ema_subject` varchar(255) NOT NULL,
  `ema_senddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ema_confirmed` char(1) NOT NULL,
  PRIMARY KEY (`ema_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email`
--

LOCK TABLES `email` WRITE;
/*!40000 ALTER TABLE `email` DISABLE KEYS */;
/*!40000 ALTER TABLE `email` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `usr_id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_email` varchar(150) NOT NULL,
  `usr_name` varchar(45) NOT NULL,
  `usr_nickname` varchar(45) NOT NULL,
  `usr_birthDate` date DEFAULT NULL,
  `usr_activeKey` char(40) DEFAULT NULL,
  `usr_status` tinyint(4) NOT NULL,
  `usr_password` varchar(32) NOT NULL,
  `usr_gender` char(1) DEFAULT NULL,
  `usr_insertDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usr_celular` varchar(20) DEFAULT NULL,
  `usr_lastlogin` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `usr_country` varchar(255) DEFAULT NULL,
  `usr_plano` char(1) DEFAULT NULL,
  `usr_cep` varchar(9) NOT NULL,
  `usr_logradouro` varchar(255) DEFAULT NULL,
  `usr_numero` varchar(5) DEFAULT NULL,
  `usr_complemento` varchar(255) DEFAULT NULL,
  `usr_bairro` varchar(50) DEFAULT NULL,
  `usr_cidade` varchar(100) DEFAULT NULL,
  `usr_estado` varchar(100) DEFAULT NULL,
  `usr_telefone` varchar(20) DEFAULT NULL,
  `usr_comercial` varchar(20) DEFAULT NULL,
  `usr_comercialramal` char(4) NOT NULL,
  `usr_deleted` char(1) NOT NULL DEFAULT '0',
  `usr_facebooktoken` varchar(255) DEFAULT NULL,
  `usr_facebookid` bigint(11) DEFAULT NULL,
  `usr_credits` int(11) NOT NULL,
  `usr_document` varchar(150) NOT NULL,
  `usr_type` char(1) NOT NULL,
  PRIMARY KEY (`usr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (10,'diogo.azzi@webneural.com','Diogo Azzi','diogoazzi','0000-00-00','feca510db7fde13f3d47d7f842261c36',1,'164859283bc453f20875c169942e720c','M','2012-10-01 10:37:20','23123213','0000-00-00 00:00:00','76',NULL,'','R Carlos Silva','395',NULL,'dsdasdas','São Paulo','22','23231232','32321321','','0',NULL,NULL,0,'','');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-11-14 12:16:54
