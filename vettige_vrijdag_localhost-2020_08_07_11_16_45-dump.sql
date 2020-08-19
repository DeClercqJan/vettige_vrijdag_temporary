-- MySQL dump 10.13  Distrib 5.7.31, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: vettige_vrijdag
-- ------------------------------------------------------
-- Server version	5.7.31-0ubuntu0.18.04.1

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
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_on` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `is_historical` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Burgers','hamburger-small-5f2d0eb3f290d.svg','hamburger-big-5f2d0eb3f27b3.svg','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(2,'Snacks','sauce-small-5f2d0ec80b852.svg','snack-big-5f2d0ec80b746.svg','2020-08-07 10:20:24','2020-08-07 10:20:24',0),(3,'Frieten','fries-small-5f2d0edbb70d9.svg','fries-big-5f2d0edbb6f88.svg','2020-08-07 10:20:43','2020-08-07 10:20:43',0),(4,'Sauzen','sauce-small-5f2d0eea7f345.svg','sauce-big-5f2d0eea7f187.svg','2020-08-07 10:20:58','2020-08-07 10:20:58',0),(5,'Drank','drink-small-5f2d0ef98d18f.svg','drink-big-5f2d0ef98d035.svg','2020-08-07 10:21:13','2020-08-07 10:21:13',0);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_versions`
--

DROP TABLE IF EXISTS `category_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category_versions` (
  `category_id` int(11) NOT NULL,
  `category_old_id` int(11) NOT NULL,
  PRIMARY KEY (`category_id`,`category_old_id`),
  KEY `IDX_AEA6C4A912469DE2` (`category_id`),
  KEY `IDX_AEA6C4A9360E306D` (`category_old_id`),
  CONSTRAINT `FK_AEA6C4A912469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  CONSTRAINT `FK_AEA6C4A9360E306D` FOREIGN KEY (`category_old_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_versions`
--

LOCK TABLES `category_versions` WRITE;
/*!40000 ALTER TABLE `category_versions` DISABLE KEYS */;
/*!40000 ALTER TABLE `category_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20200519170051','2020-08-07 10:19:08',495),('DoctrineMigrations\\Version20200527114558','2020-08-07 10:19:09',701),('DoctrineMigrations\\Version20200528142950','2020-08-07 10:19:10',1165),('DoctrineMigrations\\Version20200602134237','2020-08-07 10:19:11',384),('DoctrineMigrations\\Version20200615085021','2020-08-07 10:19:11',3605),('DoctrineMigrations\\Version20200622121239','2020-08-07 10:19:15',100),('DoctrineMigrations\\Version20200703090043','2020-08-07 10:19:15',41),('DoctrineMigrations\\Version20200708090551','2020-08-07 10:19:15',58),('DoctrineMigrations\\Version20200806155755','2020-08-07 10:19:15',5064),('DoctrineMigrations\\Version20200807075259','2020-08-07 10:19:20',49);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vettige_vrijdag_id` int(11) DEFAULT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F52993986729F458` (`vettige_vrijdag_id`),
  CONSTRAINT `FK_F52993986729F458` FOREIGN KEY (`vettige_vrijdag_id`) REFERENCES `vettige_vrijdag` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_line`
--

DROP TABLE IF EXISTS `order_line`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `amount` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9CE58EE18D9F6D38` (`order_id`),
  KEY `IDX_9CE58EE14584665A` (`product_id`),
  CONSTRAINT `FK_9CE58EE14584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_9CE58EE18D9F6D38` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_line`
--

LOCK TABLES `order_line` WRITE;
/*!40000 ALTER TABLE `order_line` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_line` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_on` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `is_historical` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D34A04AD12469DE2` (`category_id`),
  CONSTRAINT `FK_D34A04AD12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,5,'Chaudfontaine bruis','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(2,5,'Chaudfontaine plat','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(3,5,'Cola','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(4,5,'Cola zero','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(5,5,'Fanta','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(6,5,'Fanta zero','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(7,5,'Finley','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(8,5,'Gini','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(9,5,'Ice tea','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(10,5,'Ice tea zero','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(11,5,'Minute maid','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(12,5,'Schweppes Agrum','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(13,5,'Sprite','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(14,5,'Sprite zero','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(15,1,'Hamburger','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(16,1,'Bicky burger','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(17,1,'Bicky cheese','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(18,1,'Cheese burger','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(19,1,'Vegiburger','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(20,1,'Chickenburger','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(21,1,'Bicky chicken','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(22,1,'Double bicky chicken','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(23,1,'Fishburger','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(24,1,'Hambuger op oude wijze','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(25,1,'Dampoortburger','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(26,1,'Maison special burger','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(27,1,'Cheese special burger','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(28,1,'Bacon special burger','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(29,1,'Look special burger','2020-08-07 10:20:04','2020-08-07 10:20:04',0),(30,1,'Franse hamburger','2020-08-07 10:20:04','2020-08-07 10:20:04',0),(31,1,'Hawaiburger','2020-08-07 10:20:04','2020-08-07 10:20:04',0),(32,1,'Broodje frikandel','2020-08-07 10:20:04','2020-08-07 10:20:04',0),(33,1,'Broodje mexicano','2020-08-07 10:20:04','2020-08-07 10:20:04',0),(53,2,'Ardeense saté','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(54,2,'Bami','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(55,2,'Berepoot','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(56,2,'Bicky Bouletstick','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(57,2,'Bitterballen','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(58,2,'Bockworst','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(59,2,'Boulet','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(60,2,'Boulet special met curry ketchup','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(61,2,'Boulet special met tomatenketchup','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(62,2,'Cheese-crack','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(63,2,'Chixfingers','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(64,2,'Frikandel','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(65,2,'Frikandel Special met curry Ketchup','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(66,2,'Frikandel Special met tomatenketchup','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(67,2,'Garnaalkroket','2020-08-07 10:20:04','2020-08-07 10:20:04',0),(68,2,'Gigantico','2020-08-07 10:20:04','2020-08-07 10:20:04',0),(69,2,'Groenten kaasschijf','2020-08-07 10:20:04','2020-08-07 10:20:04',0),(70,2,'Kaaskroket','2020-08-07 10:20:04','2020-08-07 10:20:04',0),(71,2,'Kaassoufflé','2020-08-07 10:20:04','2020-08-07 10:20:04',0),(72,2,'Kabeljauwstick','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(73,2,'Kip kaaspunt','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(74,2,'Kipcorn','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(75,2,'Kippeboutjes','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(76,2,'Kippets','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(77,2,'Loempia','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(78,2,'Lookworst','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(79,2,'Lookworst special met curryketchup','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(80,2,'Lookworst special met tomatenketchup','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(81,2,'Lucifer','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(82,2,'Mammoet','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(83,2,'Mammoet met saus','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(84,2,'Megamix','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(85,2,'Mergeuz','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(86,2,'Mexicano','2020-08-07 10:20:04','2020-08-07 10:20:04',0),(87,2,'Mosselen','2020-08-07 10:20:04','2020-08-07 10:20:04',0),(88,2,'Paardenlookworst','2020-08-07 10:20:04','2020-08-07 10:20:04',0),(89,2,'Paardenlookworst speciaal met curryketchup','2020-08-07 10:20:04','2020-08-07 10:20:04',0),(90,2,'Paardenlookworst speciaal met tomatenketchup','2020-08-07 10:20:04','2020-08-07 10:20:04',0),(91,2,'Pikanto','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(92,2,'Ragouzi','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(93,2,'Ribster','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(94,2,'Saté groot','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(95,2,'Saté groot met kruiden','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(96,2,'Saté klein','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(97,2,'Saté klein met kruiden','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(98,2,'Sito Stick','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(99,2,'Taco','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(100,2,'Viandel','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(101,2,'Viandel special met curry ketchup','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(102,2,'Viandel special met tomatenketchup','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(103,2,'Viandel spicy','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(104,2,'Viandel spicy special met curry ketchup','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(105,2,'Viandel spicy special met tomatenketchup','2020-08-07 10:20:04','2020-08-07 10:20:04',0),(106,2,'Vlampijp','2020-08-07 10:20:04','2020-08-07 10:20:04',0),(107,2,'Vlees-Goulashkroket','2020-08-07 10:20:04','2020-08-07 10:20:04',0),(108,2,'Vuurvreter','2020-08-07 10:20:04','2020-08-07 10:20:04',0),(109,2,'Zigeunerstick','2020-08-07 10:20:04','2020-08-07 10:20:04',0),(110,3,'Klein','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(111,3,'Medium','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(112,3,'Groot','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(113,4,'Andalouse','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(114,4,'Cocktailsaus','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(115,4,'Curry ketchup','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(116,4,'Gele currysaus','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(117,4,'Joppiesaus','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(118,4,'Mamoetsaus','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(119,4,'Mayonaise','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(120,4,'Samuaraisaus','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(121,4,'Stoofvleessaus','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(122,4,'Tartaar','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(123,4,'Tomatenketchup','2020-08-07 10:20:03','2020-08-07 10:20:03',0),(124,4,'Zoetzure saus','2020-08-07 10:20:04','2020-08-07 10:20:04',0);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_versions`
--

DROP TABLE IF EXISTS `product_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_versions` (
  `product_id` int(11) NOT NULL,
  `product_old_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`product_old_id`),
  KEY `IDX_D26C2A454584665A` (`product_id`),
  KEY `IDX_D26C2A455B9ABBB2` (`product_old_id`),
  CONSTRAINT `FK_D26C2A454584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_D26C2A455B9ABBB2` FOREIGN KEY (`product_old_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_versions`
--

LOCK TABLES `product_versions` WRITE;
/*!40000 ALTER TABLE `product_versions` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vettige_vrijdag`
--

DROP TABLE IF EXISTS `vettige_vrijdag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vettige_vrijdag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `closed_on` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vettige_vrijdag`
--

LOCK TABLES `vettige_vrijdag` WRITE;
/*!40000 ALTER TABLE `vettige_vrijdag` DISABLE KEYS */;
INSERT INTO `vettige_vrijdag` VALUES (1,'open','f48a5','2020-08-07 11:04:42',NULL);
/*!40000 ALTER TABLE `vettige_vrijdag` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-08-07 11:16:45
