
-- MySQL dump 10.13  Distrib 8.0.34, for Linux (x86_64)
--
-- Host: localhost    Database: pos
-- ------------------------------------------------------
-- Server version	8.0.34

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `buying_price` decimal(10,2) DEFAULT NULL,
  `selling_price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (7,'Belted Pants',400.00,1000.00),(8,'Blazers',500.00,1300.00),(10,'Cotton Shirt',350.00,700.00),(11,'Sleeved Tops',300.00,700.00),(12,'Shorts',350.00,800.00),(13,'Pants',400.00,900.00),(14,'Zara Pants',400.00,1500.00),(15,'Jeans',0.00,1200.00),(16,'Mom Jeans',600.00,1300.00),(17,'Mother&#039;s Jeans',800.00,1300.00),(18,'Jumpsuits',800.00,1500.00),(19,'Camo/Cargo',600.00,1200.00),(21,'Sleeveless Tops',0.00,600.00),(22,'Camisole',0.00,500.00),(23,'Pleated Skirt',0.00,500.00),(24,'Pencil Skirt',0.00,1200.00),(27,'Prime Dress',0.00,2000.00),(28,'Designer Blazers',700.00,1500.00),(29,'Desinger Trenchcoat',1000.00,2000.00),(30,'Trenchcoats',500.00,1500.00),(31,'Pallazos',700.00,1200.00),(32,'Bodysuits',350.00,700.00),(33,'Rompers',400.00,800.00),(34,'Tshirts',350.00,600.00),(35,'socks',20.00,30.00),(37,'cvc',20.00,30.00);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `customer_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `birthday` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'John Doe','123-456-7890','15th February'),(2,'Jane Smith','987-654-3210','7th September'),(14,'sd','444',' 21 jan'),(15,'ww','4445','21 se'),(16,'','',''),(17,'',NULL,''),(18,'sdf',NULL,'21 ja'),(19,'ddd','555','21 '),(20,'John','445','0705480313'),(21,'new','07548978','3rd june'),(22,'customer name','5666666','birthday '),(23,'peter','12555','21 June'),(24,'','',''),(25,'','123-456-7890',''),(26,'','',''),(27,'','',''),(28,'','',''),(29,'6','6666','5'),(30,'','',''),(31,'','',''),(32,'','',''),(33,'joyce','0727742823','21 Jan'),(34,'','',''),(35,'','',''),(36,'','',''),(37,'','',''),(38,'5','12344','1'),(39,'','',''),(40,'','',''),(41,'','',''),(42,'','',''),(43,'','',''),(44,'','',''),(45,'','',''),(46,'','',''),(47,'','',''),(48,'4','22','4'),(49,'','12344',''),(50,'','12555',''),(51,'','',''),(52,'','',''),(53,'latest','2222','latest Birthday '),(54,'eee','122','111'),(55,'Mwangi','444455',''),(56,'Mwangi','444455',''),(57,'Mwang\'i','333','22 jan'),(58,'c','3333','22'),(59,'latest','3335','latest Birthday '),(60,'John','0705480313','21st Aug'),(61,'j','0707841673','21'),(62,'Peter','0000','21 Feb'),(63,'john','0707841678','March 3'),(64,'sdf','0707841283','21'),(65,'sdf','0707841222','21'),(66,'c','0707841111','21'),(67,'cv','0707841254','23'),(68,'John','0724909024','23'),(69,'Peter','0707451256','21'),(70,'j','0724909023','21'),(71,'1','0707842223','24'),(72,'s','12312345122','22'),(73,'s','5678','21'),(74,'h','5677','21'),(75,'sdf','1235','1'),(76,'e','456','123'),(77,'c','33333','3'),(78,'4','12333','21');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expense`
--

DROP TABLE IF EXISTS `expense`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expense` (
  `expense_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `description` text,
  `expense_date` date DEFAULT NULL,
  PRIMARY KEY (`expense_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `expense_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expense`
--

LOCK TABLES `expense` WRITE;
/*!40000 ALTER TABLE `expense` DISABLE KEYS */;
/*!40000 ALTER TABLE `expense` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `category_id` int DEFAULT NULL,
  `num_pieces` int DEFAULT NULL,
  PRIMARY KEY (`product_id`),
  KEY `fk_category` (`category_id`),
  CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,7,0),(2,8,0),(4,10,0),(5,11,0),(6,12,0),(7,23,1),(8,34,0),(9,30,0),(10,21,0),(11,35,0),(13,37,99),(14,13,71);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reps`
--

DROP TABLE IF EXISTS `reps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reps` (
  `rep_id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `id_number` varchar(20) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `pin` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`rep_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reps`
--

LOCK TABLES `reps` WRITE;
/*!40000 ALTER TABLE `reps` DISABLE KEYS */;
INSERT INTO `reps` VALUES (2,'Janes','Smith','987654321','555-5678','1234'),(3,'ss','sss','34','11','124'),(6,'john','w','1234555','12345','4'),(11,'john','wanjiru','123456666','12345','333');
/*!40000 ALTER TABLE `reps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `role_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin'),(2,'Employee');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sales` (
  `sale_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `rep_id` int DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `sale_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `buying_price` decimal(10,2) DEFAULT NULL,
  `profit` decimal(10,2) GENERATED ALWAYS AS ((`total` - `buying_price`)) VIRTUAL,
  `customer_id` int DEFAULT NULL,
  `paymentMode` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`sale_id`),
  KEY `product_id` (`product_id`),
  KEY `rep_id` (`rep_id`),
  KEY `fk_sales_customers` (`customer_id`),
  CONSTRAINT `fk_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  CONSTRAINT `fk_sales_customers` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON UPDATE CASCADE,
  CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`rep_id`) REFERENCES `reps` (`rep_id`)
) ENGINE=InnoDB AUTO_INCREMENT=299 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales`
--

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
INSERT INTO `sales` (`sale_id`, `product_id`, `rep_id`, `item_name`, `price`, `quantity`, `total`, `discount`, `sale_date`, `buying_price`, `customer_id`, `paymentMode`) VALUES (2,2,2,'Blazers',30.00,1,30.00,0.00,'2023-11-23 15:42:14',20.00,NULL,NULL),(3,2,2,'Blazers',30.00,1,30.00,0.00,'2023-11-23 15:44:42',22.00,NULL,NULL),(4,2,2,'Blazers',30.00,1,30.00,0.00,'2023-11-23 15:52:53',25.00,NULL,NULL),(5,1,6,'Pants',30.00,1,30.00,0.00,'2023-11-23 15:53:46',20.00,NULL,NULL),(7,1,3,'Pants',30.00,2,53.33,6.67,'2023-11-26 07:40:18',40.00,NULL,NULL),(8,2,3,'Blazers',30.00,1,26.67,3.33,'2023-11-26 07:40:18',25.00,NULL,NULL),(9,5,2,'jackets',200.00,2,396.67,3.33,'2023-11-26 07:47:24',200.00,NULL,NULL),(10,6,2,'Shorts',120.00,1,118.33,1.67,'2023-11-26 07:47:24',100.00,NULL,NULL),(11,2,6,'Blazers',30.00,1,30.00,0.00,'2023-11-26 08:20:39',25.00,NULL,NULL),(12,1,3,'Pants',30.00,1,30.00,0.00,'2023-11-26 09:10:55',20.00,NULL,NULL),(13,1,2,'Pants',30.00,1,25.00,5.00,'2023-11-26 16:32:36',20.00,NULL,NULL),(14,2,2,'Blazers',30.00,1,25.00,5.00,'2023-11-26 16:32:36',25.00,NULL,NULL),(15,1,6,'Pants',30.00,2,60.00,0.00,'2023-11-27 15:27:35',40.00,NULL,NULL),(16,2,11,'Blazers',30.00,1,30.00,0.00,'2023-11-27 15:28:21',25.00,NULL,NULL),(17,2,11,'Blazers',30.00,1,30.00,0.00,'2023-11-27 15:28:43',25.00,NULL,NULL),(18,1,3,'Pants',30.00,2,60.00,0.00,'2023-11-27 15:41:40',40.00,NULL,NULL),(19,1,2,'Pants',30.00,1,25.00,5.00,'2023-11-30 10:19:51',20.00,NULL,NULL),(20,1,2,'Pants',30.00,1,10.00,20.00,'2023-11-30 15:35:35',20.00,NULL,NULL),(21,5,2,'jackets',200.00,2,360.00,40.00,'2023-11-30 15:35:35',200.00,NULL,NULL),(22,5,2,'jackets',200.00,1,200.00,0.00,'2023-11-30 15:36:11',100.00,NULL,NULL),(23,1,2,'Pants',30.00,1,30.00,0.00,'2023-12-29 14:59:13',20.00,NULL,NULL),(24,1,6,'Pants',30.00,1,30.00,0.00,'2023-12-30 10:10:26',20.00,NULL,NULL),(25,1,6,'Belted Pants',1000.00,1,990.00,10.00,'2024-01-01 20:35:22',400.00,NULL,NULL),(26,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-01-02 11:00:12',NULL,NULL,NULL),(27,5,2,'jackets',200.00,1,200.00,0.00,'2024-01-02 11:52:17',100.00,NULL,NULL),(28,5,2,'jackets',200.00,1,200.00,0.00,'2024-01-02 11:52:53',100.00,NULL,NULL),(29,5,2,'jackets',200.00,1,200.00,0.00,'2024-01-02 13:42:06',100.00,NULL,NULL),(31,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-01-04 10:58:33',400.00,NULL,NULL),(36,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-01-06 04:32:47',400.00,NULL,NULL),(45,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-01-06 04:55:46',400.00,1,NULL),(53,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-01-06 05:09:22',25.00,NULL,NULL),(54,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-01-06 05:09:58',25.00,NULL,NULL),(55,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-01-06 05:10:18',400.00,NULL,NULL),(56,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-06 05:11:19',300.00,NULL,NULL),(57,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-06 05:18:10',300.00,1,NULL),(58,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-06 05:19:38',300.00,1,NULL),(59,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-06 05:20:05',300.00,1,NULL),(60,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-06 05:30:45',300.00,17,NULL),(61,5,3,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-06 05:36:41',300.00,18,NULL),(62,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-06 05:44:23',300.00,19,NULL),(63,4,2,'Cotton Shirt',700.00,1,700.00,0.00,'2024-01-06 05:48:06',350.00,20,NULL),(64,5,3,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-06 05:49:56',300.00,19,NULL),(65,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-01-06 05:51:12',25.00,21,NULL),(66,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-06 05:52:12',300.00,22,NULL),(67,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-06 05:54:29',300.00,23,NULL),(68,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-06 05:54:38',300.00,24,NULL),(69,9,2,'Trenchcoats',1500.00,1,1500.00,0.00,'2024-01-06 06:01:15',500.00,19,NULL),(70,8,2,'Tshirts',600.00,1,600.00,0.00,'2024-01-06 06:09:17',350.00,25,NULL),(71,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-06 06:09:57',300.00,26,NULL),(74,5,3,'Sleeved Tops',700.00,2,1400.00,0.00,'2024-01-06 06:12:52',600.00,1,NULL),(81,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-06 06:15:17',300.00,27,NULL),(82,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-06 06:18:38',300.00,28,NULL),(83,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-06 06:19:03',300.00,29,NULL),(84,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-06 06:37:59',300.00,30,NULL),(85,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-06 07:09:24',300.00,1,NULL),(86,4,2,'Cotton Shirt',700.00,1,700.00,0.00,'2024-01-06 07:09:24',350.00,1,NULL),(87,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-06 07:32:57',300.00,1,NULL),(88,5,2,'Sleeved Tops',700.00,2,1400.00,0.00,'2024-01-06 07:45:27',600.00,31,NULL),(89,10,2,'Sleeveless Tops',600.00,2,1200.00,0.00,'2024-01-06 08:04:12',0.00,32,NULL),(90,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-01-06 08:04:12',400.00,32,NULL),(91,1,2,'Belted Pants',1000.00,2,2000.00,0.00,'2024-01-06 08:41:53',800.00,33,NULL),(92,2,3,'Blazers',1300.00,1,1300.00,0.00,'2024-01-06 08:42:08',25.00,34,NULL),(93,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-01-06 09:08:43',400.00,1,NULL),(94,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-01-06 09:09:18',400.00,1,NULL),(95,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-01-06 09:11:36',400.00,35,NULL),(96,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-01-06 09:11:42',400.00,1,NULL),(97,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-01-06 09:12:28',400.00,1,NULL),(98,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-01-06 09:12:40',25.00,36,NULL),(99,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-01-06 09:13:47',25.00,37,NULL),(101,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-01-06 09:26:50',400.00,1,NULL),(102,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-01-06 09:29:35',25.00,NULL,NULL),(103,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-01-06 09:30:05',25.00,NULL,NULL),(104,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-06 09:37:30',300.00,NULL,NULL),(105,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-01-06 09:38:00',25.00,NULL,NULL),(106,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-01-06 09:38:32',25.00,NULL,NULL),(107,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-01-06 09:39:17',25.00,NULL,NULL),(108,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-01-06 09:40:52',400.00,NULL,NULL),(109,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-01-06 09:42:29',25.00,38,NULL),(110,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-01-06 09:48:49',25.00,40,NULL),(111,2,2,'Blazers',1300.00,8,10400.00,0.00,'2024-01-06 09:49:20',200.00,42,NULL),(112,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-06 09:54:35',300.00,47,NULL),(113,2,3,'Blazers',1300.00,1,1300.00,0.00,'2024-01-06 09:59:35',25.00,1,NULL),(114,5,3,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-06 10:00:56',300.00,48,NULL),(115,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-01-07 06:07:08',400.00,NULL,NULL),(116,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-01-07 06:08:28',400.00,49,NULL),(117,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-01-07 06:09:22',400.00,50,NULL),(118,1,3,'Belted Pants',1000.00,1,1000.00,0.00,'2024-01-07 06:13:58',400.00,21,NULL),(119,2,2,'Blazers',1300.00,2,2500.00,100.00,'2024-01-07 06:47:53',1000.00,51,NULL),(123,4,2,'Cotton Shirt',700.00,1,700.00,0.00,'2024-01-10 20:28:43',350.00,NULL,NULL),(124,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-10 20:29:28',300.00,NULL,NULL),(126,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-10 20:37:35',300.00,NULL,NULL),(127,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-10 20:38:01',300.00,1,NULL),(128,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-10 20:38:43',300.00,53,NULL),(129,13,2,'cvc',30.00,1,30.00,0.00,'2024-01-10 20:55:23',20.00,1,NULL),(130,4,2,'Cotton Shirt',700.00,1,700.00,0.00,'2024-01-16 23:24:20',350.00,NULL,NULL),(131,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-01-16 23:24:20',500.00,NULL,NULL),(132,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-16 23:26:22',300.00,NULL,NULL),(133,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-16 23:26:56',300.00,NULL,NULL),(134,5,3,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-16 23:30:16',300.00,NULL,NULL),(135,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-01-16 23:30:46',500.00,NULL,NULL),(136,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-01-16 23:31:32',500.00,NULL,NULL),(137,14,2,'Pants',900.00,2,1800.00,0.00,'2024-01-25 11:50:19',800.00,NULL,NULL),(138,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-01-25 11:50:20',400.00,NULL,NULL),(139,14,2,'Pants',900.00,4,3600.00,0.00,'2024-01-25 12:03:31',1600.00,NULL,NULL),(140,14,2,'Pants',900.00,1,900.00,0.00,'2024-01-25 12:03:40',400.00,NULL,NULL),(141,14,2,'Pants',900.00,5,4500.00,0.00,'2024-01-25 12:05:19',2000.00,NULL,NULL),(142,5,2,'Sleeved Tops',700.00,3,2100.00,0.00,'2024-01-25 12:06:04',900.00,NULL,NULL),(143,5,2,'Sleeved Tops',700.00,3,2100.00,0.00,'2024-01-25 12:06:43',900.00,NULL,NULL),(144,2,2,'Blazers',1300.00,3,3900.00,0.00,'2024-01-25 12:07:04',1500.00,NULL,NULL),(145,4,11,'Cotton Shirt',700.00,2,1400.00,0.00,'2024-01-25 12:14:52',700.00,NULL,NULL),(146,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-25 13:31:45',300.00,NULL,NULL),(147,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-01-28 20:12:13',400.00,NULL,NULL),(148,4,2,'Cotton Shirt',700.00,1,700.00,0.00,'2024-01-28 20:13:50',350.00,NULL,NULL),(149,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-01-28 20:26:28',400.00,NULL,NULL),(150,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-01-28 20:27:57',400.00,NULL,NULL),(151,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-01-28 20:31:28',300.00,NULL,NULL),(152,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-01-28 20:48:55',400.00,25,NULL),(153,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-01-28 20:56:06',500.00,NULL,NULL),(154,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-01-28 21:06:38',500.00,NULL,NULL),(155,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-01-28 21:10:23',500.00,NULL,NULL),(156,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-01-28 21:11:11',500.00,1,NULL),(157,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-01-28 21:37:58',500.00,54,NULL),(158,4,2,'Cotton Shirt',700.00,1,700.00,0.00,'2024-01-29 15:37:52',350.00,NULL,'0'),(159,4,2,'Cotton Shirt',700.00,1,700.00,0.00,'2024-01-29 15:37:54',350.00,NULL,'0'),(160,4,2,'Cotton Shirt',700.00,1,700.00,0.00,'2024-01-29 15:38:00',350.00,NULL,'0'),(161,4,2,'Cotton Shirt',700.00,1,700.00,0.00,'2024-01-29 15:38:29',350.00,NULL,'0'),(162,4,2,'Cotton Shirt',700.00,1,700.00,0.00,'2024-01-29 15:40:13',350.00,NULL,'Cash'),(163,4,2,'Cotton Shirt',700.00,1,500.00,200.00,'2024-02-01 15:08:02',350.00,NULL,NULL),(164,5,2,'Sleeved Tops',700.00,1,500.00,200.00,'2024-02-01 15:08:03',300.00,NULL,NULL),(165,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-02-02 08:36:51',300.00,NULL,'Cash'),(166,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-02-02 08:37:37',300.00,NULL,NULL),(167,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-02-02 08:38:32',300.00,NULL,NULL),(168,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-02-02 08:43:22',400.00,NULL,'Cash'),(169,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-02-02 08:44:13',400.00,NULL,NULL),(170,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-02-02 08:45:46',400.00,NULL,'Cash'),(171,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-02-02 08:46:12',400.00,NULL,'Cash'),(172,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-02-02 08:47:40',400.00,NULL,'Cash'),(173,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-02-02 08:48:32',400.00,NULL,'Cash'),(174,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-02-02 08:48:36',400.00,NULL,'Cash'),(175,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-02-02 08:56:30',400.00,NULL,'Cash'),(176,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-02-02 09:00:11',400.00,NULL,NULL),(177,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-02-02 09:00:42',400.00,NULL,'Cash'),(178,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-02-02 09:01:55',400.00,38,'M-Pesa Till'),(179,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-02-02 09:02:34',400.00,NULL,'Cash'),(180,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-02-02 09:03:44',400.00,NULL,'Cash'),(181,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-02-02 09:04:26',300.00,NULL,'Cash'),(182,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-02-02 09:06:14',400.00,NULL,'Cash'),(183,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-02-02 09:14:13',500.00,NULL,'Cash'),(184,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-02-02 09:19:19',500.00,NULL,'Cash'),(185,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-02-02 09:20:52',500.00,NULL,'Cash'),(186,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-02-02 09:21:26',400.00,1,'Bank Transfer'),(187,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-02-02 09:23:06',400.00,1,'Cash'),(188,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-02-02 09:23:09',400.00,1,'Cash'),(189,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-02-02 09:23:49',400.00,NULL,'Send Money'),(190,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-02-02 09:25:33',300.00,NULL,NULL),(191,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-02-02 09:27:32',500.00,NULL,'Cash'),(192,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-02-02 09:28:01',500.00,NULL,'M-Pesa Till'),(193,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-02-02 09:43:26',300.00,NULL,'Cash'),(194,2,2,'Blazers',1300.00,3,3900.00,0.00,'2024-02-02 09:45:31',1500.00,NULL,'Cash'),(195,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-02-02 09:47:14',300.00,NULL,'Bank Transfer'),(196,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-02-02 09:48:05',300.00,NULL,'Cash'),(197,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-02-02 09:50:51',300.00,NULL,'Send Money'),(198,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-02-02 09:51:42',300.00,NULL,'Cash'),(199,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-02-02 09:52:52',300.00,NULL,'Cash'),(200,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-02-02 09:54:00',300.00,NULL,'Cash'),(201,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-02-02 09:54:20',300.00,NULL,'Cash'),(202,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-02-02 09:55:31',300.00,NULL,'Cash'),(203,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-02-02 09:56:03',300.00,NULL,'Cash'),(204,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-02-02 09:56:58',300.00,NULL,'Bank Transfer'),(205,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-02-02 09:58:06',500.00,NULL,'Cash'),(206,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-02-02 10:00:11',300.00,NULL,'Cash'),(207,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-02-02 10:10:26',500.00,NULL,'Cash'),(208,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-02-02 10:10:35',500.00,NULL,'Cash'),(209,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-02-02 10:13:38',500.00,NULL,'Cash'),(210,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-02-02 10:14:15',400.00,1,'Cash'),(211,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-02-02 10:22:59',500.00,NULL,NULL),(212,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-02-02 10:25:36',400.00,48,'M-Pesa Till'),(213,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-02-02 10:34:26',300.00,1,'Cash'),(214,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-02-02 10:37:01',500.00,NULL,'Bank Transfer'),(215,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-02-02 10:38:00',500.00,1,'Bank Transfer'),(216,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-02-02 10:39:05',400.00,NULL,'Cash'),(217,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-02-02 10:41:32',400.00,NULL,'Cash'),(218,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-02-02 10:43:12',500.00,NULL,'Cash'),(219,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-02-02 10:44:49',300.00,23,'Cash'),(220,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-02-02 10:53:35',300.00,NULL,NULL),(221,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-02-02 10:54:40',300.00,NULL,NULL),(222,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-02-02 10:57:06',300.00,NULL,NULL),(223,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-02-02 10:59:07',300.00,NULL,NULL),(224,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-02-02 11:03:19',300.00,NULL,''),(225,8,2,'Tshirts',600.00,1,600.00,0.00,'2024-02-02 11:04:40',350.00,NULL,''),(226,9,2,'Trenchcoats',1500.00,1,1500.00,0.00,'2024-02-02 11:07:13',500.00,NULL,'Cash'),(227,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-02-19 08:26:02',400.00,NULL,'Cash'),(228,5,2,'Sleeved Tops',700.00,1,700.00,0.00,'2024-02-19 08:29:11',300.00,1,'Cash'),(229,5,2,'Sleeved Tops',700.00,2,1400.00,0.00,'2024-02-19 08:46:20',600.00,NULL,'Cash'),(230,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-02-19 08:46:20',500.00,NULL,'Cash'),(231,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-02-19 08:46:20',400.00,NULL,'Cash'),(232,5,2,'Sleeved Tops',700.00,3,2100.00,0.00,'2024-02-19 09:14:32',900.00,1,'Cash'),(233,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-02-19 09:17:03',400.00,57,'Cash'),(234,11,2,'socks',30.00,3,90.00,0.00,'2024-02-19 09:17:47',60.00,55,'Cash'),(235,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-02-19 21:50:22',500.00,57,'Cash'),(236,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-02-19 21:50:47',500.00,58,'M-Pesa Till'),(237,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-02-19 21:52:36',400.00,59,'Cash'),(238,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-02-19 22:03:40',400.00,38,'Cash'),(239,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-03-04 08:30:05',400.00,60,'Cash'),(240,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-03-04 09:15:10',400.00,60,'M-Pesa Till'),(241,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-03-04 09:20:22',500.00,60,'M-Pesa Till'),(242,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-03-04 09:24:41',500.00,61,'Cash'),(243,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-03-04 09:27:09',400.00,60,'Cash'),(244,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-03-04 09:31:03',400.00,60,'M-Pesa Till'),(245,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-03-04 09:33:26',400.00,60,'Cash'),(246,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-03-04 09:37:21',400.00,60,'Send Money'),(247,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-03-04 09:40:56',400.00,60,'M-Pesa Till'),(248,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-03-04 09:43:44',400.00,60,'Cash'),(249,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-03-04 09:44:45',400.00,60,'Cash'),(250,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-03-04 09:46:08',400.00,60,'Cash'),(251,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-03-04 09:49:16',400.00,60,'M-Pesa Till'),(252,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-03-04 09:58:28',500.00,60,'Cash'),(253,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-03-04 09:58:28',400.00,60,'Cash'),(254,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-03-04 10:02:45',500.00,60,'Cash'),(255,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-03-04 10:02:45',400.00,60,'Cash'),(256,1,11,'Belted Pants',1000.00,1,1000.00,0.00,'2024-03-08 11:47:11',400.00,NULL,'Cash'),(257,6,2,'Shorts',800.00,1,800.00,0.00,'2024-03-08 11:58:08',350.00,NULL,'Cash'),(258,2,3,'Blazers',1300.00,1,1300.00,0.00,'2024-03-08 12:03:17',500.00,NULL,'Cash'),(259,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-03-08 12:10:23',500.00,NULL,'Array'),(260,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-03-08 12:11:51',500.00,NULL,'Array'),(261,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-03-08 12:15:53',500.00,NULL,'Send Money, Bank Transfer'),(262,2,6,'Blazers',1300.00,1,1300.00,0.00,'2024-03-08 12:16:38',500.00,NULL,'PDQ'),(263,2,3,'Blazers',1300.00,1,1300.00,0.00,'2024-03-08 12:21:58',500.00,NULL,''),(264,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-03-08 12:22:19',500.00,NULL,''),(265,2,3,'Blazers',1300.00,1,1300.00,0.00,'2024-03-08 12:22:51',500.00,NULL,''),(266,2,3,'Blazers',1300.00,1,1300.00,0.00,'2024-03-08 12:31:41',500.00,33,'M-Pesa Till'),(267,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-03-08 12:34:48',500.00,21,''),(268,2,3,'Blazers',1300.00,1,1300.00,0.00,'2024-03-08 12:36:08',500.00,62,'PDQ'),(269,1,3,'Belted Pants',1000.00,1,1000.00,0.00,'2024-03-08 12:36:08',400.00,62,'PDQ'),(270,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-03-08 12:37:57',500.00,60,'PDQ'),(271,2,3,'Blazers',1300.00,1,1300.00,0.00,'2024-03-08 12:38:42',500.00,NULL,'M-Pesa Till, Bank Transfer'),(272,1,3,'Belted Pants',1000.00,1,1000.00,0.00,'2024-03-08 12:38:42',400.00,NULL,'M-Pesa Till, Bank Transfer'),(273,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-03-08 12:41:02',500.00,NULL,'PDQ'),(274,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-03-08 12:43:20',500.00,NULL,'M-Pesa Till'),(275,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-03-08 12:44:00',500.00,25,'PDQ'),(276,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-03-08 12:45:11',500.00,NULL,'M-Pesa Till'),(277,10,6,'Sleeveless Tops',600.00,1,600.00,0.00,'2024-03-08 12:47:14',0.00,21,'PDQ'),(278,10,2,'Sleeveless Tops',600.00,1,600.00,0.00,'2024-03-08 12:48:17',0.00,21,'PDQ'),(279,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-03-08 12:48:17',500.00,21,'PDQ'),(280,2,3,'Blazers',1300.00,1,1300.00,0.00,'2024-03-08 12:54:05',500.00,NULL,'PDQ'),(281,1,3,'Belted Pants',1000.00,1,1000.00,0.00,'2024-03-08 12:54:06',400.00,NULL,'PDQ'),(282,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-03-08 12:54:55',500.00,38,'PDQ'),(283,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-03-08 12:54:55',400.00,38,'PDQ'),(284,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-03-08 12:55:27',500.00,38,'PDQ'),(285,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-03-08 12:55:27',400.00,38,'PDQ'),(286,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-03-08 12:56:27',500.00,63,'M-Pesa Till'),(287,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-03-08 12:56:27',400.00,63,'M-Pesa Till'),(288,10,2,'Sleeveless Tops',600.00,1,600.00,0.00,'2024-03-08 12:59:45',0.00,33,'PDQ'),(289,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-03-08 12:59:45',500.00,33,'PDQ'),(290,6,2,'Shorts',800.00,1,800.00,0.00,'2024-03-08 13:00:23',350.00,1,'M-Pesa Till'),(291,6,2,'Shorts',800.00,1,800.00,0.00,'2024-03-08 13:00:57',350.00,NULL,'PDQ'),(292,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-03-08 13:04:20',500.00,25,'M-Pesa Till'),(293,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-03-08 13:04:20',400.00,25,'M-Pesa Till'),(294,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-03-08 13:04:30',500.00,25,'M-Pesa Till'),(295,2,3,'Blazers',1300.00,1,1300.00,0.00,'2024-03-08 13:04:55',500.00,NULL,'Send Money'),(296,2,2,'Blazers',1300.00,1,1300.00,0.00,'2024-03-08 13:05:40',500.00,1,'PDQ'),(297,6,2,'Shorts',800.00,1,800.00,0.00,'2024-03-08 13:07:45',350.00,23,'PDQ'),(298,1,2,'Belted Pants',1000.00,1,1000.00,0.00,'2024-03-08 13:08:55',400.00,25,'PDQ');
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales2`
--

DROP TABLE IF EXISTS `sales2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sales2` (
  `sales_id` int NOT NULL AUTO_INCREMENT,
  `discount` decimal(10,2) NOT NULL,
  `customer_id` int DEFAULT NULL,
  `paymentMode` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `rep_id` int DEFAULT NULL,
  PRIMARY KEY (`sales_id`),
  KEY `customer_id` (`customer_id`),
  KEY `fk_rep_id` (`rep_id`),
  CONSTRAINT `fk_rep_id` FOREIGN KEY (`rep_id`) REFERENCES `reps` (`rep_id`),
  CONSTRAINT `sales2_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales2`
--

LOCK TABLES `sales2` WRITE;
/*!40000 ALTER TABLE `sales2` DISABLE KEYS */;
INSERT INTO `sales2` VALUES (1,0.00,63,'s:4:\"Cash\";','2024-03-26 12:55:59',NULL),(2,0.00,60,'s:4:\"Cash\";','2024-03-26 12:57:18',NULL),(3,0.00,60,'s:4:\"Cash\";','2024-03-26 12:58:26',NULL),(4,0.00,63,'s:4:\"Cash\";','2024-03-26 12:59:56',NULL),(6,0.00,33,'s:4:\"Cash\";','2024-03-26 13:10:20',NULL),(7,0.00,60,'s:4:\"Cash\";','2024-03-26 13:10:54',NULL),(8,0.00,60,'s:4:\"Cash\";','2024-03-26 13:11:53',NULL),(9,0.00,60,'s:4:\"Cash\";','2024-03-26 13:16:02',NULL),(10,0.00,61,'s:4:\"Cash\";','2024-03-26 13:18:53',NULL),(11,0.00,60,'s:4:\"Cash\";','2024-03-26 13:19:32',NULL),(12,0.00,60,'s:4:\"Cash\";','2024-03-26 13:21:09',NULL),(13,0.00,60,'s:4:\"Cash\";','2024-03-26 13:29:10',NULL),(14,400.00,61,'s:4:\"Cash\";','2024-03-26 13:31:04',NULL),(21,0.00,NULL,'s:4:\"Cash\";','2024-03-26 14:25:25',NULL),(22,0.00,61,'s:11:\"M-Pesa Till\";','2024-03-26 14:26:24',NULL),(23,0.00,NULL,'s:4:\"Cash\";','2024-03-26 14:41:25',NULL),(24,0.00,NULL,'s:10:\"Send Money\";','2024-03-26 14:42:15',NULL),(25,0.00,NULL,'s:4:\"Cash\";','2024-03-26 14:43:25',NULL),(26,0.00,66,'s:10:\"Send Money\";','2024-03-26 14:51:35',NULL),(27,0.00,NULL,'s:4:\"Cash\";','2024-03-26 14:53:20',NULL),(28,0.00,NULL,'s:4:\"Cash\";','2024-03-26 14:53:43',NULL),(29,0.00,NULL,'s:11:\"M-Pesa Till\";','2024-03-26 14:55:19',NULL),(30,0.00,NULL,'s:11:\"M-Pesa Till\";','2024-03-26 14:55:58',NULL),(31,0.00,NULL,'s:13:\"Bank Transfer\";','2024-03-26 14:57:13',NULL),(32,0.00,67,'s:11:\"M-Pesa Till\";','2024-03-26 14:57:57',NULL),(33,0.00,61,'s:4:\"Cash\";','2024-03-26 15:02:22',NULL),(34,0.00,68,'s:11:\"M-Pesa Till\";','2024-03-26 15:03:02',NULL),(35,0.00,NULL,'s:11:\"M-Pesa Till\";','2024-03-26 15:05:24',2),(36,0.00,NULL,'N;','2024-03-26 15:10:23',2),(37,0.00,NULL,'s:4:\"Cash\";','2024-03-26 15:11:17',2),(38,0.00,61,'s:10:\"Send Money\";','2024-03-26 15:13:06',2),(39,0.00,64,'s:4:\"Cash\";','2024-03-26 15:14:37',11),(40,0.00,65,'s:4:\"Cash\";','2024-03-26 15:16:14',2),(41,0.00,69,'s:4:\"Cash\";','2024-03-26 15:20:54',2),(42,0.00,NULL,'s:4:\"Cash\";','2024-03-26 15:27:39',6),(43,100.00,NULL,'s:10:\"Send Money\";','2024-03-26 15:48:51',11),(44,100.00,NULL,'s:4:\"Cash\";','2024-03-26 15:56:12',11),(45,0.00,70,'s:4:\"Cash\";','2024-03-28 07:22:28',2),(46,0.00,NULL,'s:4:\"Cash\";','2024-03-28 07:27:00',3),(47,0.00,71,'s:4:\"Cash\";','2024-03-28 08:23:49',3),(48,0.00,38,'s:4:\"Cash\";','2024-03-28 08:28:26',3),(49,0.00,72,'s:4:\"Cash\";','2024-03-28 08:29:09',2),(50,0.00,73,'s:10:\"Send Money\";','2024-03-28 08:30:06',3),(51,0.00,74,'s:4:\"Cash\";','2024-03-28 08:31:29',2),(52,0.00,75,'s:4:\"Cash\";','2024-03-28 08:33:32',2),(53,0.00,NULL,'s:4:\"Cash\";','2024-03-28 08:39:48',2),(54,0.00,49,'s:11:\"M-Pesa Till\";','2024-03-28 08:41:19',2),(55,0.00,76,'s:4:\"Cash\";','2024-03-28 08:43:13',2),(56,0.00,77,'s:4:\"Cash\";','2024-03-28 08:47:00',2),(57,0.00,78,'s:4:\"Cash\";','2024-03-28 08:48:59',2),(58,0.00,NULL,'s:4:\"Cash\";','2024-03-28 11:07:02',2),(59,0.00,63,'s:4:\"Cash\";','2024-04-09 08:50:01',2),(60,0.00,61,'s:4:\"Cash\";','2024-04-09 10:49:59',2),(61,0.00,61,'s:13:\"Bank Transfer\";','2024-04-22 08:24:08',2),(62,0.00,61,'s:11:\"M-Pesa Till\";','2024-04-22 08:27:17',11);
/*!40000 ALTER TABLE `sales2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales_details`
--

DROP TABLE IF EXISTS `sales_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sales_details` (
  `detail_id` int NOT NULL AUTO_INCREMENT,
  `sales_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `item_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `totalBuying_price` decimal(10,2) DEFAULT NULL,
  `profit` decimal(10,2) GENERATED ALWAYS AS ((`total` - `totalBuying_price`)) VIRTUAL,
  PRIMARY KEY (`detail_id`),
  KEY `sales_id` (`sales_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `sales_details_ibfk_1` FOREIGN KEY (`sales_id`) REFERENCES `sales2` (`sales_id`),
  CONSTRAINT `sales_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_details`
--

LOCK TABLES `sales_details` WRITE;
/*!40000 ALTER TABLE `sales_details` DISABLE KEYS */;
INSERT INTO `sales_details` (`detail_id`, `sales_id`, `product_id`, `item_name`, `price`, `quantity`, `discount`, `total`, `totalBuying_price`) VALUES (1,11,2,'Blazers',1300.00,1,0.00,500.00,NULL),(2,12,2,'Blazers',1300.00,1,0.00,500.00,NULL),(3,12,1,'Belted Pants',1000.00,3,0.00,1200.00,NULL),(4,13,13,'cvc',30.00,1,0.00,30.00,20.00),(5,13,14,'Pants',900.00,3,0.00,2700.00,1200.00),(6,14,14,'Pants',900.00,4,320.00,3280.00,1600.00),(7,14,2,'Blazers',1300.00,1,80.00,1220.00,500.00),(9,21,1,'Belted Pants',1000.00,1,0.00,1000.00,400.00),(10,22,1,'Belted Pants',1000.00,1,0.00,1000.00,400.00),(11,23,1,'Belted Pants',1000.00,1,0.00,1000.00,400.00),(12,24,1,'Belted Pants',1000.00,1,0.00,1000.00,400.00),(13,25,1,'Belted Pants',1000.00,1,0.00,1000.00,400.00),(14,26,1,'Belted Pants',1000.00,1,0.00,1000.00,400.00),(15,27,1,'Belted Pants',1000.00,1,0.00,1000.00,400.00),(16,28,1,'Belted Pants',1000.00,1,0.00,1000.00,400.00),(17,29,1,'Belted Pants',1000.00,1,0.00,1000.00,400.00),(18,30,1,'Belted Pants',1000.00,1,0.00,1000.00,400.00),(19,31,2,'Blazers',1300.00,1,0.00,1300.00,500.00),(20,32,6,'Shorts',800.00,1,0.00,800.00,350.00),(21,33,1,'Belted Pants',1000.00,1,0.00,1000.00,400.00),(22,34,1,'Belted Pants',1000.00,1,0.00,1000.00,400.00),(23,35,1,'Belted Pants',1000.00,1,0.00,1000.00,400.00),(24,37,2,'Blazers',1300.00,2,0.00,2600.00,1000.00),(25,38,2,'Blazers',1300.00,1,0.00,1300.00,500.00),(26,39,2,'Blazers',1300.00,2,0.00,2600.00,1000.00),(27,40,2,'Blazers',1300.00,2,0.00,2600.00,1000.00),(28,41,2,'Blazers',1300.00,2,0.00,2600.00,1000.00),(29,42,13,'cvc',30.00,1,0.00,30.00,20.00),(30,43,6,'Shorts',800.00,2,100.00,1500.00,700.00),(31,44,6,'Shorts',800.00,1,50.00,750.00,350.00),(32,44,2,'Blazers',1300.00,1,50.00,1250.00,500.00),(33,45,14,'Pants',900.00,1,0.00,900.00,400.00),(34,46,14,'Pants',900.00,1,0.00,900.00,400.00),(35,46,6,'Shorts',800.00,1,0.00,800.00,350.00),(36,47,6,'Shorts',800.00,1,0.00,800.00,350.00),(37,48,2,'Blazers',1300.00,1,0.00,1300.00,500.00),(38,49,6,'Shorts',800.00,1,0.00,800.00,350.00),(39,50,14,'Pants',900.00,1,0.00,900.00,400.00),(40,50,6,'Shorts',800.00,1,0.00,800.00,350.00),(41,51,14,'Pants',900.00,1,0.00,900.00,400.00),(42,52,14,'Pants',900.00,1,0.00,900.00,400.00),(43,53,14,'Pants',900.00,1,0.00,900.00,400.00),(44,54,14,'Pants',900.00,1,0.00,900.00,400.00),(45,55,14,'Pants',900.00,1,0.00,900.00,400.00),(46,56,11,'socks',30.00,1,0.00,30.00,20.00),(47,57,6,'Shorts',800.00,1,0.00,800.00,350.00),(48,58,11,'socks',30.00,1,0.00,30.00,20.00),(49,59,13,'cvc',30.00,2,0.00,60.00,40.00),(50,60,14,'Pants',900.00,1,0.00,900.00,400.00),(51,61,14,'Pants',900.00,1,0.00,900.00,400.00),(52,62,13,'cvc',30.00,1,0.00,30.00,20.00);
/*!40000 ALTER TABLE `sales_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test`
--

DROP TABLE IF EXISTS `test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `test` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `customer_birthday` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test`
--

LOCK TABLES `test` WRITE;
/*!40000 ALTER TABLE `test` DISABLE KEYS */;
INSERT INTO `test` VALUES (1,'sdf','0707841222','21'),(2,'Peter','0707451256','21'),(3,'j','0724909023','21'),(4,'1','0707842223','24'),(5,'5','12344','1'),(6,'s','12312345122','22'),(7,'s','5678','21'),(8,'s','5678','21'),(9,'h','5677','21'),(10,'sdf','1235','1'),(11,'','12344',''),(12,'e','456','123'),(13,'c','33333','3'),(14,'4','12333','21');
/*!40000 ALTER TABLE `test` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int DEFAULT NULL,
  `salt` varchar(64) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (5,'ss','sss','123','admin@email.com','$2y$10$etUcFHB.Z2ihTSK6su4quu1jroTM.N0K/iyNKIt5RMjaBU1UcQvAa',1,'06699c5c58354b1c02e28c65f2d4a913c1d3398398761ebdae2f9de69fad0fe6'),(10,'sss','Mugwe','123','ann@example.com','$2y$10$MpGZbWmvNzNJ2uuCM7MGCu2qwWFF4WFhJnk35sUeC/7bx7mvK.EqC',1,'40923e330bdf0615e05b62345b6ba6f79f95f8b1d1432e0c55328f42650a71a9'),(11,'Fred','Mugwe','123','fred@defasa.co.ke','$2y$10$pMV55T5xm/3POTTKuupBCeYhX8TEehX1VAGGD.XzMPEY5lzy1yf3W',1,'75d068a5d4952ded8f69add2d1b38c31a6729f8d87e5a2f5a5ad55d101cd774d'),(12,'john','Migwe','123','john@defasa.co.ke','$2y$10$L2lILz33233oyK1SZycHler4OeAu2vY/rXuWuK2Ero1C1WNWmFf3y',1,'1ed371de6f8aef169b0d92a55e68c233a0e1ccbdd287e570552539da13737802'),(13,'Triza','Mugwe','123','triza@defasa.co.ke','$2y$10$I9OKQs4QAwrIP5VjKDpk2Ourj/Xcv3j6o4gd4UeUiYucPeY4GkZE2',1,'3cfedceacc81224ff66ed1ed8144e8bab6f9e0fec0c75235d50b599d3639bf34'),(14,'sss','sss','123','ann1@example.com','$2y$10$h/DY/eV5ytbb.OIZ4TvnIuLxCVExy3mQg3QFcNP1J3DhMSHdSgCI2',2,'a61e8c281bcd08a9a3bb334fc94d6ebe68e19c11519ea2481625410e18b12205'),(15,'sss','Mugwe','123','john@example.com','$2y$10$raj2jzwKSrPazGjBaPGyQ.RdhEHrYUBPUrw0hLfd3vpzzumQ/TYpO',1,'90e3802ad4d9b5722f705a014545058d54b02dc8a7b3d3c6f1383b2e9b444bf1');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-04-24  2:28:04
