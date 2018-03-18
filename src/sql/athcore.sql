-- MySQL dump 10.13  Distrib 5.5.47, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: athcore
-- ------------------------------------------------------
-- Server version	5.5.47-0+deb8u1

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
-- Current Database: `athcore`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `athcore` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `athcore`;

--
-- Table structure for table `exps`
--

DROP TABLE IF EXISTS `exps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exps` (
  `expsid` INT unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `periodical` INT NOT NULL DEFAULT '0',
  PRIMARY KEY (`expsid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exps`
--

LOCK TABLES `exps` WRITE;
/*!40000 ALTER TABLE `exps` DISABLE KEYS */;
INSERT INTO `exps` VALUES (1,'Financial costs',1),(2,'Costs of your business premises',1),(3,'Staff costs',0),(4,'Travel costs',0),(5,'Clothing expenses',1),(6,'Office costs',1),(7,'Stock or raw materials',0),(8,'Advertising or marketing',0);
/*!40000 ALTER TABLE `exps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `eventsid` INT unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  PRIMARY KEY (`eventsid`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (1,'Quote Added'),(2,'Quote Emailed to customer'),(3,'Job Created'),(4,'Invoice Created'),(5,'Quote Edited'),(6,'New Contact Added'),(7,'New External Contact Added'),(8,'Edited an External Contact'),(9,'New Job Folders Added'),(10,'New Quote Folder Added'),(11,'Quote Files Moved'),(13,'New Customer'),(14,'Invoice Emailed to customer'),(15,'New Staff Member Added'),(16,'Job Stage Change'),(17,'Job Priority Change'),(18,'SMS Received'),(19,'SMS Sent'),(20,'Request for Quote from Supplier Added'),(21,'Stock Added'),(22,'Supplier Quoted on Stock'),(23,'Stock Quote Agree'),(24,'Supplier sent a request to Quote'),(25,'Goods Deleivered and Signed for'),(26,'Staff Login'),(27,'Customer Login'),(28,'Supplier Login'),(29,'Management Login'),(30,'Failed Login'),(31,'Logout');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mods`
--

DROP TABLE IF EXISTS `mods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mods` (
  `modsid` INT unsigned NOT NULL AUTO_INCREMENT,
  `sitesid` INT unsigned NOT NULL,
  `modulesid` INT unsigned DEFAULT NULL,
  PRIMARY KEY (`modsid`)
) ENGINE=InnoDB AUTO_INCREMENT=138 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Dumping data for table `mods`
--

LOCK TABLES `mods` WRITE;
/*!40000 ALTER TABLE `mods` DISABLE KEYS */;
/*!40000 ALTER TABLE `mods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules` (
  `modulesid` INT unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `section` varchar(45) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `display` tinyint(4) DEFAULT '1',
  `base` tinyint(4) DEFAULT '1',
  `url` varchar(255) NOT NULL,
  `ordernum` int(2) NOT NULL DEFAULT '999',
  `level` smallint(5) unsigned NOT NULL DEFAULT '10',
  `description` text,
  PRIMARY KEY (`modulesid`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modules`
--

LOCK TABLES `modules` WRITE;
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
INSERT INTO `modules` VALUES (0,'Base','base',575.00,0,1,'',0,0,NULL),(1,'Quotes','quotes',125.00,1,0,'/quotes',10,1,'Allows you to send and recieve quotes to your customers. Customers can log in and agree to quotes'),(2,'Jobs','jobs',0.00,1,1,'/jobs',20,1,NULL),(3,'Invoices','invoices',0.00,1,1,'/invoices',30,1,NULL),(4,'Orders','orders',NULL,0,0,'',0,0,NULL),(5,'Customer Portal','custport',125.00,1,0,'',0,0,'Allows your customer to log into and view their quotes and invoices.'),(6,'Supplier Portal','suppport',125.00,0,0,'',0,0,NULL),(7,'Staff Portal','staffport',125.00,1,0,'',0,0,'Allows staff to log in and access those other modules that have been purchased.'),(8,'Costs','costs',0.00,1,1,'/costs',50,1,NULL),(9,'Reports','reports',NULL,0,0,'',0,0,NULL),(10,'Customers','cust',0.00,1,1,'',0,0,NULL),(11,'Suppliers','supp',0.00,0,0,'',0,0,NULL),(12,'Contacts','contacts',0.00,1,1,'',0,0,NULL),(13,'Staff','staff',0.00,1,1,'',0,0,NULL),(14,'Staff Timesheets','timesheets',125.00,0,0,'/timesheets',60,1,'Allows your staff to log in and submit timesheets each week, and allows you to see all their hours.'),(15,'Staff Holidays','holidays',125.00,0,0,'/holidays',70,1,'Allows staff to log in and request/record holiday times, up to a maximum set per year.'),(16,'Web Site','base',0.00,1,0,'/web',80,1,NULL),(17,'Staff Tasks','tasks',125.00,0,0,'/task',90,1,'Allows staff to login and report on ongoing work, allowing you to track costs across a single job, or just have details of what everyone is up to.'),(25,'Chat','chat',100.00,0,0,'',0,0,'Adds a chat layer to all the portals as required, allowing you to chat with other staff, customers and suppliers, and even people who visit your web site.'),(26,'Diary','diary',125.00,0,0,'/diary',40,1,'A day diary that intergrates with many other modules and allows you to set up diary items for your staff.'),(27,'VAT','vat',125.00,1,0,'',999,10,'Adds VAT to your Quotes and Invoices if you are VAT Registered'),(28,'Stock','stock',125.00,1,0,'/stock',71,1,'A very basic stock system. Helps add regular items to quotes and invoices');
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `productsid` INT unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `price` decimal(10,2) unsigned DEFAULT NULL,
  `setup` decimal(10,2) unsigned DEFAULT NULL,
  `discount` decimal(4,2) unsigned DEFAULT NULL,
  `option` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`productsid`)
) ENGINE=InnoDB AUTO_INCREMENT=1002 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1000,'Starter Web Site',0,NULL,NULL,NULL),(1001,'Athena Tools - Starter Edition',486.00,NULL,NULL,NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales` (
  `salesid` INT unsigned NOT NULL AUTO_INCREMENT,
  `sitesid` INT unsigned NOT NULL,
  `productsid` INT unsigned NOT NULL,
  `incept` INT unsigned NOT NULL,
  PRIMARY KEY (`salesid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
INSERT INTO `sales` VALUES (2,100,1001,1456149412),(3,100,1,1456149414);
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `sales`
--

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `signups`
--

DROP TABLE IF EXISTS `signups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `signups` (
  `signupsid` INT unsigned NOT NULL AUTO_INCREMENT,
  `incept` INT unsigned DEFAULT NULL,
  `fname` varchar(64) DEFAULT NULL,
  `sname` varchar(64) DEFAULT NULL,
  `co_name` varchar(256) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `tel` varchar(45) DEFAULT NULL,
  `status` enum('new','active','paused','dead') DEFAULT 'new',
  `brand` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`signupsid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `signups`
--

LOCK TABLES `signups` WRITE;
/*!40000 ALTER TABLE `signups` DISABLE KEYS */;
/*!40000 ALTER TABLE `signups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sites`
--

DROP TABLE IF EXISTS `sites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sites` (
  `sitesid` INT unsigned NOT NULL AUTO_INCREMENT,
  `co_name` varchar(128) NOT NULL,
  `co_nick` varchar(45) DEFAULT NULL,
  `addsid` INT unsigned DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `inv_email` varchar(255) DEFAULT NULL,
  `inv_contact` INT unsigned DEFAULT NULL,
  `colour` varchar(7) DEFAULT '#2c0673',
  `status` enum('active','onhold','closed','new') DEFAULT NULL,
  `pid` INT unsigned DEFAULT NULL,
  `vat_no` varchar(45) DEFAULT NULL,
  `co_no` varchar(45) DEFAULT NULL,
  `gmailpw` varchar(45) DEFAULT NULL,
  `gmail` varchar(127) DEFAULT NULL,
  `incept` INT unsigned DEFAULT NULL,
  `subdom` varchar(45) DEFAULT NULL,
  `domain` varchar(256) DEFAULT NULL,
  `filestr` varchar(256) DEFAULT NULL,
  `eoymonth` tinyint(3) unsigned DEFAULT NULL,
  `eoyday` tinyint(3) unsigned DEFAULT NULL,
  `brand` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`sitesid`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sites`
--

LOCK TABLES `sites` WRITE;
/*!40000 ALTER TABLE `sites` DISABLE KEYS */;
/*!40000 ALTER TABLE `sites` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

--
-- Table structure for table `times_types`
--

DROP TABLE IF EXISTS `times_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `times_types` (
  `times_typesid` INT NOT NULL AUTO_INCREMENT,
  `sitesid` INT unsigned DEFAULT NULL,
  `name` varchar(72) DEFAULT NULL,
  PRIMARY KEY (`times_typesid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `times_types`
--

LOCK TABLES `times_types` WRITE;
/*!40000 ALTER TABLE `times_types` DISABLE KEYS */;
INSERT INTO `times_types` VALUES (1,NULL,'Work'),(2,NULL,'Overtime'),(3,NULL,'Holiday'),(4,NULL,'Sickness'),(5,NULL,'Special Overtime'),(6,NULL,'Other');
/*!40000 ALTER TABLE `times_types` ENABLE KEYS */;
UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-02-14 15:23:32
