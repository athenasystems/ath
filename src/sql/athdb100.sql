-- MySQL dump 10.13  Distrib 5.5.47, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: athdb100
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
-- Current Database: `athdb100`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `athdb100` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `athdb100`;

--
-- Table structure for table `adds`
--

DROP TABLE IF EXISTS `adds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adds` (
  `addsid` INT unsigned NOT NULL AUTO_INCREMENT,
  `add1` varchar(128) DEFAULT NULL,
  `add2` varchar(128) DEFAULT NULL,
  `add3` varchar(128) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `county` varchar(128) DEFAULT NULL,
  `country` varchar(128) DEFAULT NULL,
  `postcode` varchar(128) DEFAULT NULL,
  `tel` varchar(45) DEFAULT NULL,
  `mob` varchar(56) DEFAULT NULL,
  `fax` varchar(45) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `web` varchar(128) DEFAULT NULL,
  `facebook` varchar(256) DEFAULT NULL,
  `twitter` varchar(256) DEFAULT NULL,
  `linkedin` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`addsid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts` (
  `contactsid` INT unsigned NOT NULL AUTO_INCREMENT,
  `title` enum('Mr','Ms','Mrs','Dr','Sir') DEFAULT NULL,
  `fname` varchar(45) DEFAULT NULL,
  `sname` varchar(45) DEFAULT NULL,
  `co_name` varchar(128) DEFAULT NULL,
  `role` varchar(128) DEFAULT NULL,
  `custid` INT unsigned DEFAULT NULL,
  `suppid` INT unsigned DEFAULT NULL,
  `addsid` INT unsigned DEFAULT '100',
  `notes` text,
  `lastlogin` INT unsigned DEFAULT NULL,
  PRIMARY KEY (`contactsid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `costs`
--

DROP TABLE IF EXISTS `costs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `costs` (
  `costsid` INT unsigned NOT NULL AUTO_INCREMENT,
  `expsid` INT unsigned NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `incept` INT unsigned NOT NULL,
  `supplier` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`costsid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `cust`
--

DROP TABLE IF EXISTS `cust`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cust` (
  `custid` INT unsigned NOT NULL AUTO_INCREMENT,
  `co_name` varchar(128) NOT NULL,
  `contact` varchar(128) DEFAULT NULL,
  `addsid` INT unsigned DEFAULT NULL,
  `inv_email` varchar(255) DEFAULT NULL,
  `inv_contact` INT unsigned DEFAULT NULL,
  `colour` varchar(7) DEFAULT '#2c0673',
  `filestr` varchar(256) DEFAULT NULL,
  `live` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`custid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*!40101 SET character_set_client = @saved_cs_client */;


INSERT INTO `cust` (`custid`, `co_name`, `contact`, `addsid`, `inv_email`) VALUES ('0', 'No Customer', '', '0', '');


--
-- Table structure for table `diary`
--

DROP TABLE IF EXISTS `diary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `diary` (
  `diaryid` INT unsigned NOT NULL AUTO_INCREMENT,
  `incept` INT unsigned NOT NULL,
  `duration` varchar(256) DEFAULT NULL,
  `title` varchar(256) DEFAULT NULL,
  `content` text,
  `location` varchar(512) DEFAULT NULL,
  `staffid` INT unsigned DEFAULT NULL,
  `done` INT unsigned DEFAULT NULL,
  `every` varchar(45) DEFAULT NULL,
  `end` INT unsigned DEFAULT NULL,
  `origin` INT unsigned DEFAULT NULL,
  PRIMARY KEY (`diaryid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `invoices`
--

CREATE TABLE `iitems` (
  `iitemsid` int(11) NOT NULL AUTO_INCREMENT,
  `invoicesid` int(10) unsigned NOT NULL,
  `quantity` tinyint(3) unsigned DEFAULT '1',
  `jobsid` int(11) unsigned NOT NULL,
  `content` text,
  `price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`iitemsid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoices` (
  `invoicesid` INT unsigned NOT NULL AUTO_INCREMENT,
  `invoiceno` varchar(45) DEFAULT NULL,
  `incept` INT unsigned NOT NULL,
  `paid` INT unsigned DEFAULT '0',
  `content` text,
  `notes` text,
  PRIMARY KEY (`invoicesid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `itemsid` INT unsigned NOT NULL AUTO_INCREMENT,
  `price` decimal(18,2) DEFAULT NULL,
  `incept` INT unsigned DEFAULT '0',
  `currency` varchar(4) DEFAULT 'GBP',
  `content` text,
  `qitemsid` INT DEFAULT NULL,
  PRIMARY KEY (`itemsid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1070 DEFAULT CHARSET=utf8;


/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `jobsid` INT unsigned NOT NULL AUTO_INCREMENT,
  `custid` INT NOT NULL,
  `itemsid` INT unsigned DEFAULT NULL,
  `quantity` tinyint(3) unsigned DEFAULT '1',
  `invoicesid` INT unsigned NOT NULL DEFAULT '0',
  `jobno` varchar(45) NOT NULL,
  `incept` INT unsigned NOT NULL,
  `done` INT unsigned DEFAULT '0',
  `notes` text,
  `custref` varchar(256) DEFAULT NULL,
  `datedel` INT unsigned DEFAULT NULL,
  `datereq` INT unsigned DEFAULT NULL,
  PRIMARY KEY (`jobsid`) USING BTREE,
  KEY `FK_jobs_2` (`itemsid`),
  CONSTRAINT `FK_jobs_2` FOREIGN KEY (`itemsid`) REFERENCES `items` (`itemsid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;



/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mail`
--

DROP TABLE IF EXISTS `mail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mail` (
  `mailid` INT unsigned NOT NULL AUTO_INCREMENT,
  `addto` varchar(256) DEFAULT NULL,
  `addname` varchar(256) DEFAULT NULL,
  `subject` varchar(256) DEFAULT NULL,
  `body` text,
  `sent` INT unsigned DEFAULT '0',
  `incept` INT unsigned DEFAULT NULL,
  `timesent` INT unsigned DEFAULT NULL,
  `docname` varchar(256) DEFAULT NULL,
  `doctitle` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`mailid`)
) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pwd`
--

DROP TABLE IF EXISTS `pwd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pwd` (
  `usr` varchar(45) NOT NULL,
  `staffid` INT unsigned DEFAULT NULL,
  `custid` INT unsigned DEFAULT NULL,
  `suppid` INT unsigned DEFAULT NULL,
  `contactsid` INT unsigned DEFAULT NULL,
  `seclev` smallint(5) unsigned DEFAULT '10',
  `pw` varchar(512) NOT NULL,
  `init` varchar(512) NOT NULL,
  UNIQUE KEY `usr_UNIQUE` (`usr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `quotes`
--

DROP TABLE IF EXISTS `quotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quotes` (
  `quotesid` INT unsigned NOT NULL AUTO_INCREMENT,
  `staffid` INT unsigned DEFAULT '1',
  `custid` INT unsigned NOT NULL,
  `contactsid` INT unsigned DEFAULT NULL,
  `quoteno` varchar(45) NOT NULL,
  `incept` INT unsigned NOT NULL,
  `origin` enum('int','ext','tasks') DEFAULT 'int',
  `agree` INT unsigned NOT NULL,
  `live` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `notes` text,
  PRIMARY KEY (`quotesid`) USING BTREE,
  KEY `FK_quotes_1` (`custid`),
  KEY `FK_quotes_2` (`staffid`),
  KEY `index_4` (`quoteno`),
  KEY `FK_quotes_3` (`contactsid`),
  CONSTRAINT `FK_quotes_1` FOREIGN KEY (`custid`) REFERENCES `cust` (`custid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

INSERT INTO `quotes` (`quotesid`, `staffid`, `custid`, `contactsid`, `quoteno`, `incept`, `live`, `content`, `notes`) VALUES ('0', '0', '0', '0', '0', '0', '0', 'No Quote', 'No Quote');

CREATE TABLE `qitems` (
  `qitemsid` INT NOT NULL AUTO_INCREMENT,
  `quotesid` INT unsigned NOT NULL,
  `quantity` tinyint(3) unsigned DEFAULT '1',
  `itemno` tinyint(3) unsigned DEFAULT '1',
  `agreed` INT unsigned DEFAULT NULL,
  `content` text,
  `price` decimal(10,2) DEFAULT NULL,
  `datereq` int(11) DEFAULT NULL,
  PRIMARY KEY (`qitemsid`),
  KEY `fk_qitems_2_idx` (`quotesid`),
  CONSTRAINT `fk_qitems_2` FOREIGN KEY (`quotesid`) REFERENCES `quotes` (`quotesid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=250 DEFAULT CHARSET=utf8;



CREATE TABLE `rfq` (
  `rfqid` INT NOT NULL AUTO_INCREMENT,
  `content` TEXT NOT NULL,
  `quantity` INT NULL DEFAULT 1,
  `fname` VARCHAR(128) NULL,
  `sname` VARCHAR(128) NULL,
  `email` VARCHAR(256) NULL,
  `tel` VARCHAR(45) NULL,
  `co_name` VARCHAR(128) NULL,
  `incept` INT unsigned NOT NULL,
  PRIMARY KEY (`rfqid`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

--
-- Table structure for table `sitelog`
--

DROP TABLE IF EXISTS `sitelog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sitelog` (
  `sitelogid` INT unsigned NOT NULL AUTO_INCREMENT,
  `incept` INT unsigned NOT NULL,
  `staffid` INT unsigned DEFAULT NULL,
  `contactsid` INT DEFAULT NULL,
  `level` smallint(5) unsigned NOT NULL,
  `content` text NOT NULL,
  `eventsid` INT unsigned NOT NULL,
  PRIMARY KEY (`sitelogid`)
) ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff` (
  `staffid` INT unsigned NOT NULL AUTO_INCREMENT,
  `fname` varchar(45) NOT NULL,
  `sname` varchar(45) DEFAULT NULL,
  `addsid` INT unsigned DEFAULT NULL,
  `notes` text,
  `jobtitle` varchar(128) DEFAULT NULL,
  `content` text,
  `status` enum('active','retired','left','temp') NOT NULL,
  `level` smallint(5) unsigned NOT NULL DEFAULT '10',
  `teamsid` INT unsigned NOT NULL,
  `timesheet` tinyint(3) unsigned DEFAULT '1',
  `holiday` smallint(6) DEFAULT '34',
  `lastlogin` INT unsigned DEFAULT NULL,
  PRIMARY KEY (`staffid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `supp`
--

DROP TABLE IF EXISTS `supp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supp` (
  `suppid` INT unsigned NOT NULL AUTO_INCREMENT,
  `co_name` varchar(128) NOT NULL,
  `contact` varchar(128) DEFAULT NULL,
  `addsid` INT unsigned DEFAULT NULL,
  `inv_email` varchar(255) DEFAULT NULL,
  `inv_contact` INT unsigned DEFAULT NULL,
  `colour` varchar(7) DEFAULT '#2c0673',
  `sagecode` varchar(12) DEFAULT NULL,
  `appr_class` tinyint(3) unsigned DEFAULT NULL,
  `appr_scope` varchar(45) DEFAULT NULL,
  `appr_types` text,
  `appr_certno` varchar(45) DEFAULT NULL,
  `appr_status` enum('Approved','Conditionally Approved','Dissapproved') DEFAULT NULL,
  `appr_cert_date` INT unsigned DEFAULT NULL,
  `appr_cert_val_type` varchar(256) DEFAULT NULL,
  `appr_cert_online` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`suppid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks` (
  `tasksid` INT unsigned NOT NULL AUTO_INCREMENT,
  `custid` INT unsigned NOT NULL,
  `jobsid` INT DEFAULT NULL,
  `notes` text NOT NULL,
  `incept` INT unsigned NOT NULL,
  `staffid` INT unsigned DEFAULT NULL,
  `hours` decimal(5,2) unsigned DEFAULT NULL,
  `rate` smallint(5) unsigned DEFAULT NULL,
  `invoicesid` INT unsigned NOT NULL DEFAULT '0',
  `contactsid` INT unsigned DEFAULT NULL,
  PRIMARY KEY (`tasksid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `times`
--

DROP TABLE IF EXISTS `times`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `times` (
  `timesid` INT unsigned NOT NULL AUTO_INCREMENT,
  `staffid` INT unsigned NOT NULL,
  `incept` INT unsigned NOT NULL,
  `start` INT unsigned NOT NULL,
  `finish` INT unsigned NOT NULL,
  `notes` text,
  `day` INT unsigned DEFAULT NULL,
  `times_typesid` INT unsigned DEFAULT NULL,
  `lstart` INT unsigned DEFAULT NULL,
  `lfinish` INT unsigned DEFAULT NULL,
  PRIMARY KEY (`timesid`) USING BTREE,
  KEY `FK_manhours_1` (`staffid`)
) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `web`
--

DROP TABLE IF EXISTS `web`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `web` (
  `webid` INT unsigned NOT NULL AUTO_INCREMENT,
  `text` text,
  `place` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`webid`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `web`
--

LOCK TABLES `web` WRITE;
/*!40000 ALTER TABLE `web` DISABLE KEYS */;
INSERT INTO `web` VALUES (1,'Home','head'),(2,'Welcome to your new Starter Web Site powered by Athena Systems','headtag'),(3,'About','abouthead'),(4,'About Us Text','abouttxt'),(5,'Service','srv1head'),(6,'Services text','srv1txt'),(7,'Service','srv2head'),(8,'Services text','srv2txt'),(9,'Service','srv3head'),(10,'Services text','srv3txt'),(11,'Service','srv4head'),(12,'Services text','srv4txt'),(13,'How to find us...','directions');
/*!40000 ALTER TABLE `web` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;




/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-02-14 18:30:32
