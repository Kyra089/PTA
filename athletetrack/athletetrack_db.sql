-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: athletetrack_db
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `no_kp` varchar(20) DEFAULT NULL,
  `tarikh_lahir` date DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `kata_laluan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `atlet`
--

DROP TABLE IF EXISTS `atlet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atlet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `no_kp` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `kata_laluan` varchar(255) DEFAULT NULL,
  `tarikh_lahir` date DEFAULT NULL,
  `pakej_id` int(11) DEFAULT NULL,
  `pakej` varchar(100) DEFAULT NULL,
  `sesi` varchar(100) DEFAULT NULL,
  `nama_waris` varchar(100) DEFAULT NULL,
  `no_telefon_waris` varchar(20) DEFAULT NULL,
  `emel_waris` varchar(100) DEFAULT NULL,
  `sekolah` varchar(150) DEFAULT NULL,
  `tarikh_daftar` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `no_kp` (`no_kp`),
  UNIQUE KEY `email` (`email`),
  KEY `pakej_id` (`pakej_id`),
  CONSTRAINT `atlet_ibfk_pakej` FOREIGN KEY (`pakej_id`) REFERENCES `pakej_sukan` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jurulatih`
--

DROP TABLE IF EXISTS `jurulatih`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jurulatih` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `no_kp` varchar(20) DEFAULT NULL,
  `tarikh_lahir` date DEFAULT NULL,
  `kepakaran` varchar(100) DEFAULT NULL,
  `pakej` varchar(100) DEFAULT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `nama_waris` varchar(100) DEFAULT NULL,
  `telefon_waris` varchar(20) DEFAULT NULL,
  `emel_waris` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kehadiran`
--

DROP TABLE IF EXISTS `kehadiran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kehadiran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `atlet_id` int(11) DEFAULT NULL,
  `tarikh` date DEFAULT NULL,
  `status` enum('hadir','tidak') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `atlet_id` (`atlet_id`),
  CONSTRAINT `kehadiran_ibfk_1` FOREIGN KEY (`atlet_id`) REFERENCES `atlet` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pakej_sukan`
--

DROP TABLE IF EXISTS `pakej_sukan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pakej_sukan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pakej` varchar(100) DEFAULT NULL,
  `sukan` varchar(150) DEFAULT NULL,
  `hari` varchar(100) DEFAULT NULL,
  `sesi` varchar(150) DEFAULT NULL,
  `harga` decimal(6,2) DEFAULT NULL,
  `poster` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pembayaran`
--

DROP TABLE IF EXISTS `pembayaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `atlet_id` int(11) DEFAULT NULL,
  `bulan` varchar(20) DEFAULT NULL,
  `jumlah` decimal(6,2) DEFAULT NULL,
  `tarikh_akhir` date DEFAULT NULL,
  `status` enum('belum','menunggu_sahkan','sudah','ditolak') DEFAULT 'belum',
  `bukti_fail` varchar(255) DEFAULT NULL,
  `tarikh_bayar` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `atlet_id` (`atlet_id`),
  CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`atlet_id`) REFERENCES `atlet` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prestasi`
--

DROP TABLE IF EXISTS `prestasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prestasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `atlet_id` int(11) DEFAULT NULL,
  `tarikh` date DEFAULT NULL,
  `acara` varchar(100) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `markah` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `atlet_id` (`atlet_id`),
  CONSTRAINT `prestasi_ibfk_1` FOREIGN KEY (`atlet_id`) REFERENCES `atlet` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed

-- Senarai pakej sukan
-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: athletetrack_db
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `pakej_sukan`
--

LOCK TABLES `pakej_sukan` WRITE;
/*!40000 ALTER TABLE `pakej_sukan` DISABLE KEYS */;
INSERT INTO `pakej_sukan` VALUES (1,'Pakej Hari Biasa','Track & Field (Larian Pecut & Asas)','Isnin & Khamis','Petang / Malam',180.00,'weekday package.jfif'),(2,'Pakej Hari Sabtu','Track & Field (Larian Pecut & Asas)','Sabtu','Petang',160.00,'weekend package.jfif'),(3,'Pakej Lompat Tinggi','Lompat Tinggi (High Jump)','Sabtu','Petang',160.00,'high jump.jfif'),(4,'Pakej Latihan Lontaran','Javelin, Shot Put, Discus','Isnin','Malam',160.00,'lontar peluru.jfif'),(5,'Pakej Larian Jarak Jauh (Dewasa)','Larian Jarak Jauh (Dewasa)','Isnin & Khamis','Malam',180.00,'mid long distance.jfif'),(6,'Pakej Larian Jarak Jauh (9-18 Tahun)','Larian Jarak Jauh (9-18 Tahun)','Isnin & Khamis','Malam',180.00,'mid long distance (9-18).jfif');
/*!40000 ALTER TABLE `pakej_sukan` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed
