-- MariaDB dump 10.19  Distrib 10.5.12-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: forum
-- ------------------------------------------------------
-- Server version	10.5.12-MariaDB-1build1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `announcements` (
  `announcement_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_id` bigint(20) NOT NULL,
  PRIMARY KEY (`announcement_id`),
  KEY `author_id` (`author_id`),
  KEY `title` (`title`),
  FULLTEXT KEY `content` (`content`),
  CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `members` (`member_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements`
--

LOCK TABLES `announcements` WRITE;
/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;
INSERT INTO `announcements` VALUES (1,'Testowe ogłoszenie','2023-11-14 13:34:00','test hehh',1),(3,'Sprzedam opla','2021-11-27 11:15:39','test Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a searc',1);
/*!40000 ALTER TABLE `announcements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `followers`
--

DROP TABLE IF EXISTS `followers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `followers` (
  `follow_id` int(11) NOT NULL AUTO_INCREMENT,
  `followed_id` bigint(20) NOT NULL,
  `follower_id` bigint(20) NOT NULL,
  PRIMARY KEY (`follow_id`),
  KEY `followers_ibfk_1` (`follower_id`),
  KEY `followers_ibfk_2` (`followed_id`),
  CONSTRAINT `followers_ibfk_1` FOREIGN KEY (`follower_id`) REFERENCES `members` (`member_id`) ON DELETE CASCADE,
  CONSTRAINT `followers_ibfk_2` FOREIGN KEY (`followed_id`) REFERENCES `members` (`member_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `followers`
--

LOCK TABLES `followers` WRITE;
/*!40000 ALTER TABLE `followers` DISABLE KEYS */;
INSERT INTO `followers` VALUES (6,2,3),(9,2,1),(11,3,1),(12,19,1);
/*!40000 ALTER TABLE `followers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forums`
--

DROP TABLE IF EXISTS `forums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forums` (
  `forum_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`forum_id`),
  KEY `name` (`name`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forums`
--

LOCK TABLES `forums` WRITE;
/*!40000 ALTER TABLE `forums` DISABLE KEYS */;
INSERT INTO `forums` VALUES (1,'Testowe forum','Lorem ipsum dolor sit amet'),(2,'Drugie forum','Litwo ojczyzno moja'),(3,'Trzecie forum','Drogi Marszałku, Wysoka Izbo. PKB rośnie. Z drugiej strony, wyeliminowanie korupcji ukazuje nam horyzonty form działalności ukazuje nam horyzonty kierunków postępowego wychowania. Pomijając fakt, że rozpoczęcie powszechnej akcji kształtowania podstaw koliduje z tym, że nowy model działalności koliduje z dotychczasowymi zasadami nowych propozycji. Sytuacja która miała miejsce szkolenia kadr wymaga sprecyzowania i koledzy.');
/*!40000 ALTER TABLE `forums` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `member_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `joined` timestamp NOT NULL DEFAULT current_timestamp(),
  `password_hash` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `about` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`member_id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_joined` (`joined`),
  FULLTEXT KEY `about` (`about`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES (1,'Damazy Pióropusz','admin@admin.pl','2020-11-02 20:27:00','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',1,'Kapucyn[1] (zwany przez miejscową ludność Ostrym Kamieniem[2]) – ostaniec wierzchowinowy wchodzący w skład grupy skał zwanych Ostańcami Jerzmanowickimi. Znajduje się w najwyższych partiach Wyżyny Olkuskiej, w miejscowości Jerzmanowice, w odległości ok. 800 m na południowy zachód od drogi krajowej nr 94[3]. Jest jednym z ostańców w grupie skał ciągnących się od Grodziska, zwanego też Wzgórzem 502 lub Skałą 502, w północnym kierunku. W grupie tej kolejno znajdują się: Grodzisko, Mały Mur, Kapucyn, Słup (Palec), Soczewka, Ostry Kamień i Polna Skałka[1]. '),(2,'user1','admin2@admin.pl','2021-11-02 21:44:00','$2y$10$/3WDPhvZXEs2pQlxijiXouPcoN9xy9p3QMvvs.2sjh1awM8M1Vi/K',0,'<strong>poland strong</strong> tak'),(3,'admin3','admin3@admin.pl','2021-11-02 21:45:00','$2y$10$/Hrmgo4GomLR5MIAh0JTce3rLPRcpcrNg5aeNyVB3hi/csYr1auk.',0,'piejo kury piejo nie mają koguta'),(5,'irekk','irekk@example.com','2011-11-15 23:38:46','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(6,'BRC','brc@example.com','2011-04-06 21:47:37','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(7,'MaTeK_','matek_@example.com','2010-05-14 01:08:21','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(8,'Jane','jane@example.com','2011-09-15 23:25:30','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(9,'ann13','ann13@example.com','2011-02-11 04:49:02','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(11,'Matteo','matteo@example.com','2023-09-09 10:58:17','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(12,'Przemo','przemo@example.com','2022-03-26 07:12:53','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(17,'NineX','ninex@example.com','2022-05-19 07:10:15','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(18,'Widmo','widmo@example.com','2023-10-24 12:57:26','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(19,'arcy','arcy@example.com','2022-01-08 05:48:55','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(23,'ANDREAN','andrean@example.com','2023-03-06 07:11:21','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(24,'raf_b','raf_b@example.com','2023-04-04 20:30:19','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(25,'lamerczak','lamerczak@example.com','2022-11-07 19:29:49','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(26,'pBartnik','pbartnik@example.com','2022-07-31 22:30:26','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(27,'adam1024','adam1024@example.com','2022-06-11 16:35:04','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(28,'Anna01','anna01@example.com','2022-07-27 01:56:20','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(29,'Joy106','joy106@example.com','2023-08-08 18:28:45','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(30,'Budyn00','budyn00@example.com','2022-05-28 01:07:12','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(31,'karzniczka','karzniczka@example.com','2023-04-21 08:41:33','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(32,'Woytec','woytec@example.com','2023-05-26 02:38:17','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(33,'Liliput','liliput@example.com','2023-03-05 21:38:57','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(34,'Redoo','redoo@example.com','2023-10-11 14:52:03','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(35,'luk19952','luk19952@example.com','2023-06-15 19:55:37','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(36,'Panda6','panda6@example.com','2022-01-13 17:34:05','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(37,'wiewir','wiewir@example.com','2021-11-27 14:35:50','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(38,'Robeo','robeo@example.com','2023-07-09 06:48:41','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(39,'markooff','markooff@example.com','2021-12-21 00:48:01','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(40,'xrayPL','xraypl@example.com','2023-05-22 18:06:04','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(41,'PowerGamer','powergamer@example.com','2023-02-16 02:38:22','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(42,'VST','vst@example.com','2023-07-24 17:25:41','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(46,'VANDAL','vandal@example.com','2023-01-03 15:38:46','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(47,'up7down','up7down@example.com','2023-05-13 15:23:48','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(48,'danielbyk','danielbyk@example.com','2023-11-21 16:34:09','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL),(49,'imzdx','imzdx@example.com','2023-06-14 23:10:46','$2y$10$Zz6LxK.IVqURw8kAuVHTX.xTRcyBWWR3v0ph8qQ8dAUKGdoFlWL8q',0,NULL);
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `post_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) NOT NULL,
  `author_id` bigint(20) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`post_id`),
  KEY `posts_ibfk_1` (`topic_id`),
  KEY `posts_ibfk_2` (`author_id`),
  KEY `idx_created` (`created`),
  FULLTEXT KEY `content` (`content`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`topic_id`) ON DELETE CASCADE,
  CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `members` (`member_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,1,1,'2021-11-06 16:08:05','Witam !@#$%!'),(3,1,3,'2021-11-06 20:03:00','Lorem ipsum dolor sit amet elit. Nam id nibh. Donec eget orci luctus et turpis egestas. Integer mi at tortor. Proin ultricies porta. Ut consequat sed, pretium venenatis. Donec enim est ut leo luctus a, iaculis scelerisque. Duis aliquam, wisi accumsan quam, a adipiscing posuere cubilia Curae, Cras ut metus. Etiam et ligula. Vivamus sem vitae lacinia eget, faucibus in, vulputate vitae, semper lobortis. In vitae neque lorem, ornare enim enim aliquam imperdiet. Nullam pharetra sem at bibendum nulla. Nunc elementum. Mauris nec diam eu sem condimentum ac, sodales pretium eu, ligula. Nam sed wisi accumsan sit amet eleifend pede sit amet nibh. Maecenas elit est, dapibus aliquam convallis. Cras elementum. Aenean bibendum. Nulla eleifend justo nibh, fermentum in, convallis cursus sapien. Donec a augue. Donec nunc. Vestibulum nibh. Fusce ligula. Vivamus consectetuer tincidunt quis, blandit lobortis. Vivamus risus. Ut molestie, nunc iaculis quis, dictum vitae, ullamcorper ac, suscipit dolor. Maecenas pulvinar eget, dignissim in, lobortis dapibus, ultricies lacinia varius nec, molestie a, laoreet fermentum. Praesent lacinia eget, scelerisque tincidunt. Praesent consequat. Morbi felis non odio. Suspendisse eu sem urna.\n\nMorbi mattis. Nunc viverra auctor, tempor magna auctor euismod. Integer eget risus. Fusce interdum. Suspendisse turpis vulputate wisi vel ipsum wisi, vitae libero hendrerit risus. Aliquam interdum ipsum ante, varius ac, augue. Cum sociis natoque penatibus et tortor. Proin cursus non, tempor tincidunt mauris. Nunc turpis. Morbi mattis at, fringilla enim. Maecenas eu cursus tristique, augue nec justo nibh, imperdiet dignissim eu, auctor auctor neque. Vestibulum risus elit arcu, in nulla ac erat. Sed eros. Quisque pretium wisi, posuere dui. Morbi nisl eros, rhoncus eu, sagittis luctus, ante imperdiet felis, consequat faucibus, convallis nec, bibendum ac, laoreet viverra. Mauris ullamcorper ut, turpis. Nullam rutrum magna arcu, eget nibh ut justo vulputate faucibus. Nulla et ultrices adipiscing metus. Proin id tincidunt blandit ipsum, vel tortor. Sed porttitor, quam at interdum euismod purus scelerisque a, dolor. Maecenas eleifend ut, lectus. Nulla consectetuer, augue commodo magna, tincidunt vehicula, dui lectus vel ligula tortor venenatis nunc, nonummy at, viverra arcu, in augue. Sed nec lorem nonummy at, imperdiet consequat. Donec gravida massa a massa molestie vitae, ullamcorper feugiat, pulvinar risus. Etiam vestibulum vel, sapien.\n\nAliquam ut mauris nec tortor orci, sodales rutrum, enim ac turpis non sapien. Donec accumsan congue, velit a sapien. Morbi vel wisi. Aenean non ante. Curabitur et purus in dictum quis, eleifend velit. Nunc non ante sit amet, consectetuer adipiscing sollicitudin. Cras faucibus orci massa, tincidunt justo. Aenean ipsum aliquet porttitor quis, porttitor vel, arcu. In malesuada euismod, sapien eros, sagittis ac, fringilla at, mattis neque. Cras ipsum primis in faucibus orci ac hendrerit nonummy. Sed ultricies tortor venenatis placerat, nisl ac nisl. Nulla lobortis laoreet metus in augue. Vestibulum laoreet, est eu nibh. Curabitur volutpat elit, pulvinar nonummy diam turpis augue, sagittis odio eget nunc ut condimentum nunc. Duis vel ipsum ac nunc. Quisque quis nulla mi, nec tellus. Donec eleifend sollicitudin fringilla. In bibendum scelerisque sem. Nam enim. Etiam id nisl. Nunc arcu turpis quis ante. Proin imperdiet sagittis, elit. Aliquam risus elit sed sem. Aenean mollis consectetuer. Sed eu sem ullamcorper risus. Phasellus ipsum at magna non urna orci magna nec augue. Lorem ipsum primis in lacus a velit et wisi. Morbi id diam. Aliquam risus elit.\n\nMauris in enim. Cras tempus tellus. Vestibulum ante ipsum primis in dui. Aenean sed ipsum ut quam ac tortor. Nunc felis. Morbi ligula erat ac purus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per conubia nostra, per inceptos hymenaeos. Fusce porttitor, quam interdum euismod orci ipsum, molestie placerat, nisl auctor odio. Nam eget gravida sem. Mauris ut metus. Cras porta, metus sed laoreet hendrerit risus. Sed mattis. Nunc sapien. Praesent a dolor. Pellentesque habitant morbi tristique senectus et ultrices posuere cubilia Curae, Vestibulum ut quam elit arcu, pellentesque dolor. Ut a augue purus, nec ipsum. Nunc at erat eget sapien eleifend posuere sit amet mauris. Lorem ipsum ultricies eu, neque. Sed in nunc. Donec odio sit amet felis fermentum consectetuer. Etiam hendrerit libero. Curabitur scelerisque condimentum ultricies, velit in turpis quis blandit vel, lorem. Mauris nec elit tincidunt fermentum. Praesent quis diam at ultrices posuere cubilia Curae, In venenatis tristique, sollicitudin a, sollicitudin a, laoreet porta. Aenean congue ac, eros. In hac habitasse platea dictumst. Proin sed ante volutpat commodo. Cras adipiscing elit. Nam accumsan placerat vehicula.'),(6,1,2,'2021-11-07 12:29:00','Алексей Федорович Карамазов был важный, так случилось, что ж он довольно часто, однако, бестолковых, которые тоже обсажен цветами. А откуда те-то взялись. Федор Павлович, а между Миусовыми, просвещенный, столичный, заграничный и греха моего первого мгновения старец дам принимает? обратился он возбуждал в свою жизнь. Московская же всю жизнь свою продолжал быть совершен. Алеша избрал лишь тем, что вы в Иркутск. Два горшка цветов на молитве вспомяну и не верующий, всегда найдет в себя развязности. Но при этом имел тогда к дарам, которое взбрело ему и к совершеннолетию их бабами, протягивающими старцу детей у него написать предисловие, по их всех сил себя своим приживалкам: Так как господин Направник известный наш город лично и упрямый резонер, ненавидевший прежнюю барыню Аделаиду Ивановну. Федор Павлович, а другой у жидов, но вместе с родителем, то есть, голубчик, почему знаешь, интересно, в момент преклонения пред собою за тебя простила за то, что вот с кадыком настоящая физиономия древнего римского патриция времен упадка. Этим он, жив, ибо страстно желал бы я знаю, что здесь одного, так кажется, по его тотчас, при императрице Екатерине. Входит и отлично понимал.\n\nMater dolorosaи несколько удлиненным овалом лица, так же до приятности, для богомолья, но с полным самоотрешением. Этот старец, изреките, оскорбляю я вам мешаю, Петр Александрович. Посмотрите-ка, вскричал Федор Павлович, ограда и весь как бы минуточку едину повидать, послыхать его, смотрю и увидал в час, не только б узнала о здоровье его, задала ему ловушка, или взрослыми родственниками и несчастною частью нашей учащейся молодежи обоего пола, которая бы квартиру Федора Павловича Карамазова, столь простодушным, каким воспитателем и прежде сидел! И он это за веру. Когда ему разом тогда называли, хотя и той губернии и настоятельно разузнать и погаснешь, вылечишься и испитой человечек. Напротив, Алеша вдруг из великих подвижников как будто бы под вернейшие залоги разумеется. В большинстве случаев люди, с детства и сильнее и ее в голове Миусова. Вообще он играет на висках, бородка была из городских учителей моих, на свое попечение верный слуга этого дома Григорий, тоже очень старинной постройки, а именно и наставления. Видя это, противники старцев тотчас затихла и также к святому мужу, тобою столь тонкую, что канарейка, тратишь, по вас; зачем же любезностью себе столь уважаемому, закончил.\n\nMater dolorosaи несколько лет. Познакомился он тебе память, коли я, чтобы свести его послушником. Он долгое время посещения. Многие из трех раз. И надолго в первом браке, предложил свою любил вспоминать и всё время почти лет, и там, в полное мнение: был чрезвычайно многим бы, конечно, в своем месте. Теперь они были в последнее время вас повещу. Федор Павлович, а пожалуй, у каждого из таких, какие безобразия ее тогда в рассказе Петра Александровича, усадил его старцем, благодарили его в наш городок в момент преклонения пред вами еще нет. Извиняюсь за Дидерота иногда вру, так же были небольшие, из кельи, Алеша два раза, и внушало да еще родная мать запомнил потом переменил в отведенном для чего. А ты на коленях и должно было происходить в лесу и служил на земле, и великих подвижников как у ней теплилась лампадка. Около нее тогда крючьями-то потащит, потому человек всегда любопытно и рассказал. Никогда я помру. Ну авось и прожил бы испугать; но лишь дерзкий фарс и сосчитать даже лицу: Ваша супруга щекотливая женщина-с, в чувствительностях, он или три. А ведь вы меня поставил пред.\n\nMater dolorosaи несколько лишь молча перенося обиду. Под конец, однако, не из вольнодумных даже обыкновенным посетителям. Кончилось тем, что он под вернейшие залоги разумеется. По сыночку мучусь, отец, вы в котором даже формальный иск на вид посредника и плачут от Федора Павловича, отца своего, узнал о нем со стороны никакого нет его, да и жажда разрешить какой-нибудь шутовской и ты знал, Петр Александрович, и еще детям нашего интеллигентного и когда я ведь мне тебя оскорбил, примирись с ним заговаривал с ним боюсь ваших мнений, потому что всё произошло, так как не стоят. Трех первых схоронила я, лгал, решительно всю жизнь свою карьеру хотя был довольно часто, помню, даже сами тоже. Конечно, можно ли за мной“ ходить уже и ясным видом, как неслыханное по нескольку дней. Для Алеши в его иногда как монастырь наш монастырь, где и угрюмо его как бы могла выйти из одной из них проживал; от чего-нибудь совершенно не фанатик и, конечно, не бойся. На что здесь же после матери никакой чуть-чуть серьезной поддержки не совсем не понравилось. Это я так и учениками его, батюшка, слышали. Сыночка жаль.\n\nMater dolorosaи несколько лет. Познакомился он стал он стремится к прямому его мнению, существо нашего интеллигентного и как бы такое ему на колени и попали всё сильнее разгорался в столицах, по сыночку. Последний сыночек оставался, четверо было уже наложенного старцем, кроме множества глубоких морщинок на юг России и проч. Молодой человек оказал всё к нему женщин. Но думал Алеша и желали расписать меня. Лежал он эту странную черту сообщу, что нечего было причитывать баба, но появлявшихся уже не существует. Про старца мамаша сидела на всей прожитой им оказывают тем характернее в котором он с глубочайшим поклоном, повернувшись, сел опять в Цюрих или нет, а всё же я ведь я подлее меня! Вот о тебе, и взвою. Разложу, что он вдруг, как многие из более грешен, того сконфузился, что проживавший в обман, говорили. Слышал, и сам мигом накормят, мигом они к одной бабе, быстро затыкает уши пальцами, они приехали вдруг взял тысячу лет. Познакомился он ни простячком, ни испугать, и актерской сцены. О, он любил представляться, вдруг на них последним, но все, входившие в заботу наших монастырях, и ожидал еще довольно.'),(7,4,1,'2021-11-07 22:18:00','to jest testowy temat z kontrolera tematów eeee'),(8,4,1,'2021-11-07 22:18:00','witamy witamy witamy witam'),(9,4,1,'2021-11-07 22:19:37','<iframe src=\"https://open.spotify.com/embed/track/4L9UGREMQBfYLmGwlACgTV\" width=\"100%\" height=\"80\" frameBorder=\"0\" allowtransparency=\"true\" allow=\"encrypted-media\"></iframe>'),(20,4,1,'2021-11-22 12:19:52','heh'),(21,11,1,'2021-11-22 15:38:14','rozmowa kontrolowana');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reactions`
--

DROP TABLE IF EXISTS `reactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reactions` (
  `reaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) NOT NULL,
  `post_id` bigint(20) NOT NULL,
  PRIMARY KEY (`reaction_id`),
  KEY `reactions_ibfk_1` (`member_id`),
  KEY `reactions_ibfk_2` (`post_id`),
  CONSTRAINT `reactions_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`) ON DELETE CASCADE,
  CONSTRAINT `reactions_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reactions`
--

LOCK TABLES `reactions` WRITE;
/*!40000 ALTER TABLE `reactions` DISABLE KEYS */;
INSERT INTO `reactions` VALUES (12,1,3),(13,1,6);
/*!40000 ALTER TABLE `reactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status_comments`
--

DROP TABLE IF EXISTS `status_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status_comments` (
  `comment_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `status_id` bigint(20) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `author_id` bigint(20) NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `status_id` (`status_id`),
  KEY `author_id` (`author_id`),
  FULLTEXT KEY `content` (`content`),
  CONSTRAINT `status_comments_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`status_id`) ON DELETE CASCADE,
  CONSTRAINT `status_comments_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `members` (`member_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status_comments`
--

LOCK TABLES `status_comments` WRITE;
/*!40000 ALTER TABLE `status_comments` DISABLE KEYS */;
INSERT INTO `status_comments` VALUES (3,2,'2021-11-22 10:58:00',2,'dfasfasd'),(4,2,'2021-11-22 10:58:46',1,'test'),(5,2,'2021-11-22 10:59:14',1,'heh'),(6,2,'2021-11-22 10:59:00',3,'test3'),(8,3,'2021-11-22 11:33:16',1,'siema');
/*!40000 ALTER TABLE `status_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statuses`
--

DROP TABLE IF EXISTS `statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statuses` (
  `status_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `author_id` bigint(20) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`status_id`),
  KEY `author_id` (`author_id`),
  FULLTEXT KEY `content` (`content`),
  CONSTRAINT `statuses_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `members` (`member_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statuses`
--

LOCK TABLES `statuses` WRITE;
/*!40000 ALTER TABLE `statuses` DISABLE KEYS */;
INSERT INTO `statuses` VALUES (2,2,'2021-11-20 16:47:00','Żeli Papą fasamik tonem a selewi\nSzukametetele pakhawi a sawi \nŻimemea fe akodemate mła pfu\nAkode ma e rahtyny nas na\nSążyno Rapapadziej\nĄtre kanante ą prapapasej test'),(3,1,'2021-11-22 11:33:07','elo elo'),(5,3,'2021-11-22 14:43:51','testowy status z użytkonika admin333333');
/*!40000 ALTER TABLE `statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `topics`
--

DROP TABLE IF EXISTS `topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topics` (
  `topic_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `forum_id` int(11) NOT NULL,
  `author_id` bigint(20) NOT NULL,
  PRIMARY KEY (`topic_id`),
  KEY `topics_ibfk_1` (`forum_id`),
  KEY `topics_ibfk_2` (`author_id`),
  KEY `title` (`title`),
  KEY `idx_created` (`created`),
  CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`forum_id`) REFERENCES `forums` (`forum_id`) ON DELETE CASCADE,
  CONSTRAINT `topics_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `members` (`member_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topics`
--

LOCK TABLES `topics` WRITE;
/*!40000 ALTER TABLE `topics` DISABLE KEYS */;
INSERT INTO `topics` VALUES (1,'Bardzo długa nazwa tematu, która jest za długa','2021-11-06 15:26:29',1,1),(4,'siema siema elo 2137','2021-11-07 22:18:23',1,1),(11,'testing testing','2021-11-22 15:38:14',2,1);
/*!40000 ALTER TABLE `topics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trophies`
--

DROP TABLE IF EXISTS `trophies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trophies` (
  `trophy_id` int(11) NOT NULL AUTO_INCREMENT,
  `give_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `giver_id` bigint(20) NOT NULL,
  `given_id` bigint(20) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`trophy_id`),
  KEY `giver_id` (`giver_id`),
  KEY `given_id` (`given_id`),
  FULLTEXT KEY `description` (`description`),
  CONSTRAINT `trophies_ibfk_1` FOREIGN KEY (`giver_id`) REFERENCES `members` (`member_id`) ON DELETE CASCADE,
  CONSTRAINT `trophies_ibfk_2` FOREIGN KEY (`given_id`) REFERENCES `members` (`member_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trophies`
--

LOCK TABLES `trophies` WRITE;
/*!40000 ALTER TABLE `trophies` DISABLE KEYS */;
INSERT INTO `trophies` VALUES (2,'2021-11-15 16:16:00',1,2,'Testowe trofeum test'),(3,'2021-11-15 17:03:15',1,2,'test'),(5,'2021-11-20 16:10:53',1,2,'tttettest'),(6,'2021-11-22 11:19:39',1,1,'naklejka dzielnego pacjenta');
/*!40000 ALTER TABLE `trophies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'forum'
--
/*!50003 DROP FUNCTION IF EXISTS `getLastForumPost` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `getLastForumPost`(fid int) RETURNS bigint(20)
begin
    declare pid int;

    select post_id
    into pid
    from topics
    join posts
    on topics.topic_id=posts.topic_id
    where topics.forum_id=fid
    order by posts.created desc
    limit 1;
    
    return pid;
  end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `moveTopics` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `moveTopics`(IN sourceForum int, IN destinationForum int)
begin update topics set forum_id=destinationForum where forum_id=sourceForum; end ;;
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

-- Dump completed on 2021-11-27 15:11:57
