-- MySQL dump 10.13  Distrib 5.7.21, for Linux (x86_64)
--
-- Host: localhost    Database: Car34
-- ------------------------------------------------------
-- Server version	5.7.21-0ubuntu0.17.10.1

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
-- Table structure for table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration_versions`
--

LOCK TABLES `migration_versions` WRITE;
/*!40000 ALTER TABLE `migration_versions` DISABLE KEYS */;
INSERT INTO `migration_versions` VALUES ('20180301223013'),('20180324155100'),('20180326142451'),('20180326143116');
/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cost` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_7332E1695E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,'pavyzdysPav',695,1,1),(4,'pridetas',55,2,1),(5,'remontas69',1259,10,0);
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `passwordResetToken` varchar(255) DEFAULT NULL,
  `role` int(11) NOT NULL,
  `registrationDate` datetime NOT NULL,
  `lastLoginTime` datetime NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E9F85E0677` (`username`),
  UNIQUE KEY `UNIQ_1483A5E9E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'mantinjio','mantas@ktu.lt','nera','negalima',0,'2011-05-03 00:00:00','2011-08-14 00:00:00',1,0),(3,'negalima','jopapa@gmail.com','$2y$13$N6kueokZSl4NyH/oPMFkz.rQqIo0bwlstRefJar/5..A.e2OBOrNC',NULL,2,'2018-03-18 03:31:06','2018-03-18 03:31:06',1,0),(4,'fasdfasdf','fasdfasdf@fsdfsdf.asdasd','$2y$13$Nj232tdEgLSQ61WIkesuX.0BvKhzvGUSowNVDAtD4zMWzPxpdxA6W',NULL,1,'2018-03-18 04:24:52','2018-03-18 04:24:52',1,0),(5,'mantukas','jopapa@gmail.c','$2y$13$j4EPoIsJ5usTzvBaV2BLu.phGqXqG8Yu3b1GEwRKW3jwRfyCB0/dW',NULL,2,'2018-03-18 04:54:48','2018-03-18 04:54:48',1,0),(6,'labas','ka@tu.lt','$2y$13$PO432k3FxjK997IGSiCAy.pkvWQX8oH/I9UKcjpRMOTRg1m1qXqNO',NULL,1,'2018-03-19 19:41:35','2018-03-19 19:41:35',1,0),(7,'labutis','kaip@tu.lt','$2y$13$Kc0M/QV9Gj7/a4xfaNydreIF8mKwvVqxfbgCj3fMU87fq16p7bxU2',NULL,1,'2018-03-23 01:26:19','2018-03-23 01:26:19',1,0),(8,'nuikas','nu@i.nk','$2y$13$5xUPww6mbvq8gqb789HnEuQ8uva7w8KgpH9ZN5/Kfy.OFf1inXa7O',NULL,1,'2018-03-23 01:46:12','2018-03-23 01:46:12',1,0),(9,'akauntas','nene@jojo.eu','$2y$13$W3EeEcL.O4cPx1CbrCj61eWMq7GHCSeG.BTyX1RKVEb4AqLWz2nQK',NULL,1,'2018-03-23 01:58:00','2018-03-23 01:58:00',1,0),(10,'akauntass','e@mail.lt','$2y$13$LnShtMFhcJO6r5LVfGGy7.PAli38bA4bww7jNv/KU4DWpDfySSyVi',NULL,1,'2018-03-23 02:06:10','2018-03-23 02:06:10',1,0),(11,'mechanikas','owneris@mechanikas.lt','$2y$13$WEQsk67EETioEOSsvL2RdOXEazGsqx549EbvBmLjeRw9.kpfSc3wq',NULL,2,'2018-03-26 17:44:41','2018-03-26 17:44:41',1,0),(12,'klientas','klientas@gg.lt','$2y$13$BNXXDqp80W/GP1fsIGpo4OWPG4PcjObh1OoXSTSGYs0cFqEvhwr7m',NULL,1,'2018-03-26 17:55:48','2018-03-26 17:55:48',1,0),(13,'Dievas','me@aurimasrimkus.eu','$2y$13$4kOrbq69ZXHgj9Umg4RuseVSpcG.e/3z7vFmnr7PoNLSucXt1o6xO',NULL,1,'2018-03-26 23:13:47','2018-03-26 23:13:47',1,0), (14,'ggMechanic', 'babushki@gmail.com', '$2y$13$QPjhz6WIWFmY3nTS6P.VIu6N.BSb\/g0w.OfCcH24EnTfyMKEB95WW', null, 2, '2018-03-28 18:56:30', '2018-03-28 18:56:30',1,0);
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

-- Dump completed on 2018-03-27 14:23:18
