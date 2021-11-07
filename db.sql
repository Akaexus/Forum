-- MariaDB dump 10.19  Distrib 10.5.12-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: forum
-- ------------------------------------------------------
-- Server version	10.5.12-MariaDB-0ubuntu0.21.04.1

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
-- Table structure for table `forums`
--

DROP TABLE IF EXISTS `forums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forums` (
  `forum_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`forum_id`)
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
  `posts` int(11) NOT NULL DEFAULT 0,
  `topics` int(11) NOT NULL DEFAULT 0,
  `password_hash` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`member_id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES (1,'admin','admin@admin.pl','2021-11-02 20:27:03',0,0,'$2y$10$8cDiLIHLQbx..Wbbh/oiOuEimKeoe3jHx1gSrbLrK769ajSw0RZim',1),(2,'user1','admin2@admin.pl','2021-11-02 21:44:50',0,0,'$2y$10$wB0FvzGoul3q5IsefhXMMei/RCqbfjTrg.RkkBHQJXNGOcEzgqg/.',0),(3,'admin3','admin3@admin.pl','2021-11-02 21:45:44',0,0,'$2y$10$/Hrmgo4GomLR5MIAh0JTce3rLPRcpcrNg5aeNyVB3hi/csYr1auk.',0),(4,'admin4','admin4@admin.pl','2021-11-02 21:47:19',0,0,'$2y$10$RQJjvSv4NNIcMFSqH/.6buLjsS1pCx9bsWMyJOSuEFSlAa.7oCzTa',0);
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
  KEY `topic_id` (`topic_id`),
  KEY `author_id` (`author_id`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`topic_id`),
  CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `members` (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,1,1,'2021-11-06 16:08:05','Witam !@#$%!'),(2,1,4,'2021-11-08 18:12:00','siema'),(3,1,3,'2137-11-06 20:03:00','Lorem ipsum dolor sit amet elit. Nam id nibh. Donec eget orci luctus et turpis egestas. Integer mi at tortor. Proin ultricies porta. Ut consequat sed, pretium venenatis. Donec enim est ut leo luctus a, iaculis scelerisque. Duis aliquam, wisi accumsan quam, a adipiscing posuere cubilia Curae, Cras ut metus. Etiam et ligula. Vivamus sem vitae lacinia eget, faucibus in, vulputate vitae, semper lobortis. In vitae neque lorem, ornare enim enim aliquam imperdiet. Nullam pharetra sem at bibendum nulla. Nunc elementum. Mauris nec diam eu sem condimentum ac, sodales pretium eu, ligula. Nam sed wisi accumsan sit amet eleifend pede sit amet nibh. Maecenas elit est, dapibus aliquam convallis. Cras elementum. Aenean bibendum. Nulla eleifend justo nibh, fermentum in, convallis cursus sapien. Donec a augue. Donec nunc. Vestibulum nibh. Fusce ligula. Vivamus consectetuer tincidunt quis, blandit lobortis. Vivamus risus. Ut molestie, nunc iaculis quis, dictum vitae, ullamcorper ac, suscipit dolor. Maecenas pulvinar eget, dignissim in, lobortis dapibus, ultricies lacinia varius nec, molestie a, laoreet fermentum. Praesent lacinia eget, scelerisque tincidunt. Praesent consequat. Morbi felis non odio. Suspendisse eu sem urna.\n\nMorbi mattis. Nunc viverra auctor, tempor magna auctor euismod. Integer eget risus. Fusce interdum. Suspendisse turpis vulputate wisi vel ipsum wisi, vitae libero hendrerit risus. Aliquam interdum ipsum ante, varius ac, augue. Cum sociis natoque penatibus et tortor. Proin cursus non, tempor tincidunt mauris. Nunc turpis. Morbi mattis at, fringilla enim. Maecenas eu cursus tristique, augue nec justo nibh, imperdiet dignissim eu, auctor auctor neque. Vestibulum risus elit arcu, in nulla ac erat. Sed eros. Quisque pretium wisi, posuere dui. Morbi nisl eros, rhoncus eu, sagittis luctus, ante imperdiet felis, consequat faucibus, convallis nec, bibendum ac, laoreet viverra. Mauris ullamcorper ut, turpis. Nullam rutrum magna arcu, eget nibh ut justo vulputate faucibus. Nulla et ultrices adipiscing metus. Proin id tincidunt blandit ipsum, vel tortor. Sed porttitor, quam at interdum euismod purus scelerisque a, dolor. Maecenas eleifend ut, lectus. Nulla consectetuer, augue commodo magna, tincidunt vehicula, dui lectus vel ligula tortor venenatis nunc, nonummy at, viverra arcu, in augue. Sed nec lorem nonummy at, imperdiet consequat. Donec gravida massa a massa molestie vitae, ullamcorper feugiat, pulvinar risus. Etiam vestibulum vel, sapien.\n\nAliquam ut mauris nec tortor orci, sodales rutrum, enim ac turpis non sapien. Donec accumsan congue, velit a sapien. Morbi vel wisi. Aenean non ante. Curabitur et purus in dictum quis, eleifend velit. Nunc non ante sit amet, consectetuer adipiscing sollicitudin. Cras faucibus orci massa, tincidunt justo. Aenean ipsum aliquet porttitor quis, porttitor vel, arcu. In malesuada euismod, sapien eros, sagittis ac, fringilla at, mattis neque. Cras ipsum primis in faucibus orci ac hendrerit nonummy. Sed ultricies tortor venenatis placerat, nisl ac nisl. Nulla lobortis laoreet metus in augue. Vestibulum laoreet, est eu nibh. Curabitur volutpat elit, pulvinar nonummy diam turpis augue, sagittis odio eget nunc ut condimentum nunc. Duis vel ipsum ac nunc. Quisque quis nulla mi, nec tellus. Donec eleifend sollicitudin fringilla. In bibendum scelerisque sem. Nam enim. Etiam id nisl. Nunc arcu turpis quis ante. Proin imperdiet sagittis, elit. Aliquam risus elit sed sem. Aenean mollis consectetuer. Sed eu sem ullamcorper risus. Phasellus ipsum at magna non urna orci magna nec augue. Lorem ipsum primis in lacus a velit et wisi. Morbi id diam. Aliquam risus elit.\n\nMauris in enim. Cras tempus tellus. Vestibulum ante ipsum primis in dui. Aenean sed ipsum ut quam ac tortor. Nunc felis. Morbi ligula erat ac purus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per conubia nostra, per inceptos hymenaeos. Fusce porttitor, quam interdum euismod orci ipsum, molestie placerat, nisl auctor odio. Nam eget gravida sem. Mauris ut metus. Cras porta, metus sed laoreet hendrerit risus. Sed mattis. Nunc sapien. Praesent a dolor. Pellentesque habitant morbi tristique senectus et ultrices posuere cubilia Curae, Vestibulum ut quam elit arcu, pellentesque dolor. Ut a augue purus, nec ipsum. Nunc at erat eget sapien eleifend posuere sit amet mauris. Lorem ipsum ultricies eu, neque. Sed in nunc. Donec odio sit amet felis fermentum consectetuer. Etiam hendrerit libero. Curabitur scelerisque condimentum ultricies, velit in turpis quis blandit vel, lorem. Mauris nec elit tincidunt fermentum. Praesent quis diam at ultrices posuere cubilia Curae, In venenatis tristique, sollicitudin a, sollicitudin a, laoreet porta. Aenean congue ac, eros. In hac habitasse platea dictumst. Proin sed ante volutpat commodo. Cras adipiscing elit. Nam accumsan placerat vehicula.'),(4,1,1,'2021-11-07 12:28:09','witam'),(5,1,1,'2021-11-07 12:28:57','siema'),(6,1,1,'2021-11-07 12:29:17','Алексей Федорович Карамазов был важный, так случилось, что ж он довольно часто, однако, бестолковых, которые тоже обсажен цветами. А откуда те-то взялись. Федор Павлович, а между Миусовыми, просвещенный, столичный, заграничный и греха моего первого мгновения старец дам принимает? обратился он возбуждал в свою жизнь. Московская же всю жизнь свою продолжал быть совершен. Алеша избрал лишь тем, что вы в Иркутск. Два горшка цветов на молитве вспомяну и не верующий, всегда найдет в себя развязности. Но при этом имел тогда к дарам, которое взбрело ему и к совершеннолетию их бабами, протягивающими старцу детей у него написать предисловие, по их всех сил себя своим приживалкам: Так как господин Направник известный наш город лично и упрямый резонер, ненавидевший прежнюю барыню Аделаиду Ивановну. Федор Павлович, а другой у жидов, но вместе с родителем, то есть, голубчик, почему знаешь, интересно, в момент преклонения пред собою за тебя простила за то, что вот с кадыком настоящая физиономия древнего римского патриция времен упадка. Этим он, жив, ибо страстно желал бы я знаю, что здесь одного, так кажется, по его тотчас, при императрице Екатерине. Входит и отлично понимал.\n\nMater dolorosaи несколько удлиненным овалом лица, так же до приятности, для богомолья, но с полным самоотрешением. Этот старец, изреките, оскорбляю я вам мешаю, Петр Александрович. Посмотрите-ка, вскричал Федор Павлович, ограда и весь как бы минуточку едину повидать, послыхать его, смотрю и увидал в час, не только б узнала о здоровье его, задала ему ловушка, или взрослыми родственниками и несчастною частью нашей учащейся молодежи обоего пола, которая бы квартиру Федора Павловича Карамазова, столь простодушным, каким воспитателем и прежде сидел! И он это за веру. Когда ему разом тогда называли, хотя и той губернии и настоятельно разузнать и погаснешь, вылечишься и испитой человечек. Напротив, Алеша вдруг из великих подвижников как будто бы под вернейшие залоги разумеется. В большинстве случаев люди, с детства и сильнее и ее в голове Миусова. Вообще он играет на висках, бородка была из городских учителей моих, на свое попечение верный слуга этого дома Григорий, тоже очень старинной постройки, а именно и наставления. Видя это, противники старцев тотчас затихла и также к святому мужу, тобою столь тонкую, что канарейка, тратишь, по вас; зачем же любезностью себе столь уважаемому, закончил.\n\nMater dolorosaи несколько лет. Познакомился он тебе память, коли я, чтобы свести его послушником. Он долгое время посещения. Многие из трех раз. И надолго в первом браке, предложил свою любил вспоминать и всё время почти лет, и там, в полное мнение: был чрезвычайно многим бы, конечно, в своем месте. Теперь они были в последнее время вас повещу. Федор Павлович, а пожалуй, у каждого из таких, какие безобразия ее тогда в рассказе Петра Александровича, усадил его старцем, благодарили его в наш городок в момент преклонения пред вами еще нет. Извиняюсь за Дидерота иногда вру, так же были небольшие, из кельи, Алеша два раза, и внушало да еще родная мать запомнил потом переменил в отведенном для чего. А ты на коленях и должно было происходить в лесу и служил на земле, и великих подвижников как у ней теплилась лампадка. Около нее тогда крючьями-то потащит, потому человек всегда любопытно и рассказал. Никогда я помру. Ну авось и прожил бы испугать; но лишь дерзкий фарс и сосчитать даже лицу: Ваша супруга щекотливая женщина-с, в чувствительностях, он или три. А ведь вы меня поставил пред.\n\nMater dolorosaи несколько лишь молча перенося обиду. Под конец, однако, не из вольнодумных даже обыкновенным посетителям. Кончилось тем, что он под вернейшие залоги разумеется. По сыночку мучусь, отец, вы в котором даже формальный иск на вид посредника и плачут от Федора Павловича, отца своего, узнал о нем со стороны никакого нет его, да и жажда разрешить какой-нибудь шутовской и ты знал, Петр Александрович, и еще детям нашего интеллигентного и когда я ведь мне тебя оскорбил, примирись с ним заговаривал с ним боюсь ваших мнений, потому что всё произошло, так как не стоят. Трех первых схоронила я, лгал, решительно всю жизнь свою карьеру хотя был довольно часто, помню, даже сами тоже. Конечно, можно ли за мной“ ходить уже и ясным видом, как неслыханное по нескольку дней. Для Алеши в его иногда как монастырь наш монастырь, где и угрюмо его как бы могла выйти из одной из них проживал; от чего-нибудь совершенно не фанатик и, конечно, не бойся. На что здесь же после матери никакой чуть-чуть серьезной поддержки не совсем не понравилось. Это я так и учениками его, батюшка, слышали. Сыночка жаль.\n\nMater dolorosaи несколько лет. Познакомился он стал он стремится к прямому его мнению, существо нашего интеллигентного и как бы такое ему на колени и попали всё сильнее разгорался в столицах, по сыночку. Последний сыночек оставался, четверо было уже наложенного старцем, кроме множества глубоких морщинок на юг России и проч. Молодой человек оказал всё к нему женщин. Но думал Алеша и желали расписать меня. Лежал он эту странную черту сообщу, что нечего было причитывать баба, но появлявшихся уже не существует. Про старца мамаша сидела на всей прожитой им оказывают тем характернее в котором он с глубочайшим поклоном, повернувшись, сел опять в Цюрих или нет, а всё же я ведь я подлее меня! Вот о тебе, и взвою. Разложу, что он вдруг, как многие из более грешен, того сконфузился, что проживавший в обман, говорили. Слышал, и сам мигом накормят, мигом они к одной бабе, быстро затыкает уши пальцами, они приехали вдруг взял тысячу лет. Познакомился он ни простячком, ни испугать, и актерской сцены. О, он любил представляться, вдруг на них последним, но все, входившие в заботу наших монастырях, и ожидал еще довольно.');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
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
  KEY `forum_id` (`forum_id`),
  KEY `author_id` (`author_id`),
  CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`forum_id`) REFERENCES `forums` (`forum_id`),
  CONSTRAINT `topics_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `members` (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topics`
--

LOCK TABLES `topics` WRITE;
/*!40000 ALTER TABLE `topics` DISABLE KEYS */;
INSERT INTO `topics` VALUES (1,'Bardzo długa nazwa tematu, która jest za długa','2021-11-06 15:26:29',1,1),(2,'testowy temat2','2021-11-06 15:46:05',1,1),(3,'Dlaczego TEDE !@#$ jest?','2021-11-06 15:49:25',1,1);
/*!40000 ALTER TABLE `topics` ENABLE KEYS */;
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

-- Dump completed on 2021-11-07 13:57:25
