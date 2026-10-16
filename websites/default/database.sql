
-- Host: localhost    Database: v.je


-- Table structure for table course_modules
--

DROP TABLE IF EXISTS `course_modules`;

CREATE TABLE `course_modules` (
  `course_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  PRIMARY KEY (`course_id`,`module_id`),
  KEY `module_id` (`module_id`),
  CONSTRAINT `1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  CONSTRAINT `2` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_modules`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `course_modules` WRITE;
/*!40000 ALTER TABLE `course_modules` DISABLE KEYS */;
/*!40000 ALTER TABLE `course_modules` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_area_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL,
  `duration` int(11) NOT NULL,
  `description` text NOT NULL,
  `part_time` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `subject_area_id` (`subject_area_id`),
  CONSTRAINT `1` FOREIGN KEY (`subject_area_id`) REFERENCES `subject_areas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES
(1,1,'Software Engineering','Bsc',5,'A course covering software design, development and engineering principles.',1),
(2,1,'Cloud computing','Bsc',3,'An indepth course focused on cloud computing',1),
(3,2,'America history','msc',1,'an introduction and study of modern american history',1),
(4,3,'psycology','Bsc',4,'Study the latest curricullum on psycology in the uk',1),
(5,1,'Cyber Security','Bsc',3,'This course equips students with the skills to protect digital systems and networks from cyber threats. You will study ethical hacking, penetration testing, digital forensics, cryptography, and risk management. Graduates go on to work as security analysts, ethical hackers, and IT consultants across a wide range of industries.',1),
(6,1,'Data Science','Bsc',3,'This course develops your ability to collect, analyse, and interpret large datasets to drive real-world decision making. Topics include statistical modelling, Python programming, machine learning, data visualisation, and database management. Graduates are in high demand across finance, healthcare, retail, and technology sectors',1),
(7,1,'Artificial Intelligence','msc',1,' This advanced postgraduate course explores the theory and application of intelligent systems. You will study neural networks, natural language processing, computer vision, reinforcement learning, and AI ethics. The course is designed for graduates looking to specialise in one of the fastest growing fields in technology.',1),
(8,2,'Modern European History','BA',3,' This course traces the major political, social, and cultural transformations that have shaped Europe from the 18th century to the present day. You will examine revolutions, world wars, the Cold War, and the rise of the European Union through primary sources and historical debate. Graduates pursue careers in education, journalism, law, and public policy.',1),
(9,2,'Ancient Civilizations','Bsc',3,'This course takes you on a journey through the ancient world, exploring the societies of Greece, Rome, Egypt, and Mesopotamia. You will study archaeology, mythology, philosophy, and the political structures that laid the foundations of modern western culture. Graduates go on to work in heritage, museums, academia, and cultural organisations',1),
(10,3,'Biomedical Science','msc',2,'This course provides a thorough grounding in human biology, disease mechanisms, and laboratory diagnostic techniques used in clinical settings. You will study biochemistry, microbiology, haematology, and immunology with significant practical lab work throughout. Graduates are well prepared for careers in the NHS, pharmaceutical industry, and biomedical research.',1),
(11,3,'Environmental science','Bsc',3,'This course examines the relationship between human activity and the natural environment, with a focus on climate change, biodiversity, and sustainable resource management. You will carry out fieldwork alongside lectures covering ecology, geology, environmental law, and pollution control. Graduates work in conservation, government agencies, environmental consultancy, and international NGOs.',0),
(12,1,'Database Administration','Bsc',3,'Covers relational and non-relational databases, query optimisation, data modelling and database security.',1),
(13,1,'Computer systems','Bsc',3,'Study of operating systems, computer architecture, hardware design and low-level programming.',0),
(14,1,'Mobile App Development','Bsc',2,'Students learn to design and build mobile applications for iOS and Android platforms using industry-standard tools.',1),
(15,1,'Web development','msc',3,'Covers frontend and backend development, databases, APIs and modern frameworks for building professional web applications.',1),
(16,1,'Data Science','msc',2,'Advanced study of statistical analysis, machine learning, big data technologies and data visualisation techniques.',0),
(17,1,'Cybersecurity','Bsc',3,'Covers ethical hacking, digital forensics, cryptography and security risk management to protect organisations from cyber threats.',1),
(18,1,'Network Engineering ','Bsc',3,'Students learn network design, routing protocols, network security and infrastructure management across both wired and wireless environments.',1),
(19,2,'Medieval history','Bsc',3,'Explores the political, social and cultural developments of medieval Europe from the fall of Rome to the Renaissance.',1),
(20,2,'World History','msc',2,'Advanced study of global historical events, cross-cultural interactions and the development of world civilisations.',0),
(21,2,'Ancient history','BA',3,'Examines the civilisations of ancient Greece, Rome, Egypt and Mesopotamia through archaeological and written sources.',1),
(22,2,'British History','Bsc',3,'A focused study of British political, social and economic history from the Tudor period to the modern era.',1),
(23,2,'Military History','Bsc',4,'Explores the history of warfare, military strategy and the impact of conflict on societies throughout the ages.',0),
(24,2,'History of art','Bsc',4,'Examines artistic movements and cultural expression from ancient times through to contemporary art.',1),
(25,2,'African History','Bsc',3,'Covers the rich history of African civilisations, colonialism, independence movements and modern African states.',1),
(26,2,'History of science','msc',1,'Explores how scientific knowledge has developed over time and the relationship between science, society and culture.',1),
(27,3,'Biology','Bsc',4,'Study of living organisms, cell biology, genetics, evolution and ecosystems preparing students for careers in life sciences.',1),
(28,3,'Chemistry','Bsc',3,'Covers organic and inorganic chemistry, laboratory techniques, chemical reactions and industrial applications.',1),
(29,3,'physics','msc',3,'Study of matter, energy, forces and the fundamental laws governing the universe from quantum mechanics to astrophysics.',1),
(31,3,'Forensic Science','msc',2,'Applies scientific techniques to criminal investigations including DNA analysis, toxicology and crime scene examination.',1),
(32,1,'Astronomy','Bsc',4,'Study of stars, galaxies, planetary systems and the origins and evolution of the universe',1),
(33,3,'Neuroscience','msc',1,'Covers the structure and function of the nervous system, brain disorders, behaviour and cutting-edge research in brain science.',1),
(34,3,'Biochemistry','msc',2,'Advanced study of chemical processes within living organisms including metabolism, molecular biology and enzyme function',1),
(35,3,'Marine Biology','Bsc',4,'Explores ocean ecosystems, marine organisms, conservation and the impact of human activity on marine environments.',1);
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `enquiries`
--

DROP TABLE IF EXISTS `enquiries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `enquiries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT '',
  `course_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `is_responded` tinyint(1) NOT NULL DEFAULT 0,
  `responded_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enquiries`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `enquiries` WRITE;
/*!40000 ALTER TABLE `enquiries` DISABLE KEYS */;
INSERT INTO `enquiries` VALUES
(1,'Abuchi obi','obiabuchi81@gmail.com','07918849050',1,'i want to enquire about how the modules for softwarte engineering are delivered and also the intensity of the course','2026-04-06 07:53:44',1,'superadmin'),
(2,'jasmine','jasyu87@gmail.com','',28,'i want to enquire about enrollment deadline','2026-04-09 12:50:22',0,NULL),
(3,'Test Student','test@test.com','',1,'I want to know more','2026-04-13 17:12:14',0,NULL);
/*!40000 ALTER TABLE `enquiries` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modules`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `modules` WRITE;
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `subject_areas`
--

DROP TABLE IF EXISTS `subject_areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `subject_areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject_areas`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `subject_areas` WRITE;
/*!40000 ALTER TABLE `subject_areas` DISABLE KEYS */;
INSERT INTO `subject_areas` VALUES
(1,'Computer'),
(2,'History'),
(3,'Science');
/*!40000 ALTER TABLE `subject_areas` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('superadmin','admin') NOT NULL DEFAULT 'admin',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'superadmin','$2y$12$.rrEZ4i5v5tRfAlfUBPUquS89odtmYqktb02dlVyuKijRaUFLt4Vi','superadmin');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-04-13 18:12:25
