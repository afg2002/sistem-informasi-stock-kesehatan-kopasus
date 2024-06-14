-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_kesehatan
CREATE DATABASE IF NOT EXISTS `db_kesehatan` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_kesehatan`;

-- Dumping structure for table db_kesehatan.alkes
CREATE TABLE IF NOT EXISTS `alkes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_materil` varchar(255) DEFAULT NULL,
  `merk_type` varchar(255) DEFAULT NULL,
  `satuan` varchar(50) DEFAULT NULL,
  `kategori_id` int DEFAULT NULL,
  `keterangan` text,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `kondisi_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_kondisi` (`kondisi_id`),
  CONSTRAINT `fk_kondisi` FOREIGN KEY (`kondisi_id`) REFERENCES `kondisi` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Dumping data for table db_kesehatan.alkes: ~1 rows (approximately)
INSERT IGNORE INTO `alkes` (`id`, `nama_materil`, `merk_type`, `satuan`, `kategori_id`, `keterangan`, `tanggal`, `kondisi_id`) VALUES
	(8, 'materil', 'merk', 'satuan', 1, 'keterangan', '2024-06-14 13:55:05', 1);

-- Dumping structure for table db_kesehatan.kategori_alkes
CREATE TABLE IF NOT EXISTS `kategori_alkes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Dumping data for table db_kesehatan.kategori_alkes: ~7 rows (approximately)
INSERT IGNORE INTO `kategori_alkes` (`id`, `nama_kategori`) VALUES
	(1, 'Alkes Polma Kes Kopassus'),
	(2, 'Alkes Pusdiklatpassus Kes Kopassus'),
	(3, 'Alkes Grup 1 Kes Kopassus'),
	(4, 'Alkes Yon 14 Kes Kopassus'),
	(5, 'Alkes Grup 2 Kes Kopassus'),
	(6, 'Alkes Grup 3 Kes Kopassus'),
	(7, 'Alkes Sat 81 Kes Kopassus');

-- Dumping structure for table db_kesehatan.kategori_obat
CREATE TABLE IF NOT EXISTS `kategori_obat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Dumping data for table db_kesehatan.kategori_obat: ~4 rows (approximately)
INSERT IGNORE INTO `kategori_obat` (`id`, `nama_kategori`) VALUES
	(1, 'ANALGETIK/ANTIPRETIK'),
	(2, 'ANTIBIOTIC'),
	(3, 'GIGI'),
	(4, 'REAGENT LAB');

-- Dumping structure for table db_kesehatan.kendaraan
CREATE TABLE IF NOT EXISTS `kendaraan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_kendaraan` varchar(255) DEFAULT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  `bbm` varchar(255) DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `keterangan` text,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Dumping data for table db_kesehatan.kendaraan: ~8 rows (approximately)
INSERT IGNORE INTO `kendaraan` (`id`, `nama_kendaraan`, `jenis`, `bbm`, `jumlah`, `keterangan`, `timestamp`) VALUES
	(13, 'Motor Pengantar Obat', 'Motor', 'Premium', 12, 'Motor untuk mengantar obat ke lokasi pasien...', '2023-09-13 20:00:04'),
	(14, 'Mobil Penjemput Pasien', 'Ambulans', 'Solar', 3, 'Unit ambulans untuk menjemput pasien dari lokasi tertentu.', '2023-09-13 03:54:34'),
	(15, 'Motor Operasional', 'Motor', 'Premium', 8, 'Motor operasional untuk keperluan tugas sehari-hari.', '2023-09-13 03:54:34'),
	(17, 'Sepeda Motor Dinas', 'Motor', 'Pertamax', 15, 'Sepeda motor dinas untuk petugas medis.', '2023-09-13 03:54:34'),
	(18, 'Ambulans Gawat Darurat', 'Ambulans', 'Solar', 2, 'Unit ambulans khusus untuk gawat darurat medis.', '2023-09-13 03:54:34'),
	(19, 'Mobil Logistik', 'Truk', 'Solar', 4, 'Truk untuk keperluan logistik kesehatan.', '2023-09-13 03:54:34'),
	(20, 'Kendaraan Pribadi', 'Sedan', 'Pertamax', 10, 'Kendaraan pribadi untuk keperluan dinas pribadi.', '2023-09-13 03:54:34'),
	(21, 'Motor Pengawas', 'Motor', 'Pertamax', 5, 'Motor untuk keperluan pengawasan fasilitas kesehatan.', '2023-09-13 03:54:34');

-- Dumping structure for table db_kesehatan.kondisi
CREATE TABLE IF NOT EXISTS `kondisi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_kondisi` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Dumping data for table db_kesehatan.kondisi: ~3 rows (approximately)
INSERT IGNORE INTO `kondisi` (`id`, `nama_kondisi`) VALUES
	(1, 'Baik'),
	(2, 'Rusak Ringan'),
	(3, 'Rusak Berat');

-- Dumping structure for table db_kesehatan.obat
CREATE TABLE IF NOT EXISTS `obat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  `nama_obat` varchar(255) DEFAULT NULL,
  `merk` varchar(255) DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  `keterangan` text,
  `id_kategori_obat` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_kategori_obat` (`id_kategori_obat`),
  CONSTRAINT `fk_kategori_obat` FOREIGN KEY (`id_kategori_obat`) REFERENCES `kategori_obat` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Dumping data for table db_kesehatan.obat: ~10 rows (approximately)
INSERT IGNORE INTO `obat` (`id`, `tanggal`, `nama_obat`, `merk`, `jumlah`, `jenis`, `keterangan`, `id_kategori_obat`) VALUES
	(30, '2023-09-01', 'Paracetamol', 'Merk A', 100, 'Tablet', 'Obat penurun demam', 1),
	(31, '2023-09-02', 'Amoxicillin', 'Merk B', 150, 'Kapsul', 'Obat antibiotik', 2),
	(32, '2023-09-03', 'Ibuprofen', 'Merk C', 200, 'Tablet', 'Obat pereda nyeri', 1),
	(33, '2023-09-04', 'Cough Syrup', 'Merk D', 50, 'Sirup', 'Obat batuk', 3),
	(34, '2023-09-05', 'Aspirin', 'Merk E', 79, 'Tablet', 'Obat pereda nyeri', 1),
	(35, '2023-09-06', 'Cetirizine', 'Merk F', 120, 'Kapsul', 'Obat antialergi', 2),
	(36, '2023-09-07', 'Omeprazole', 'Merk G', 90, 'Tablet', 'Obat maag', 1),
	(37, '2023-09-08', 'Insulin', 'Merk H', 70, 'Injeksi', 'Obat diabetes', 4),
	(39, '2023-09-10', 'Loratadine', 'Merk J', 110, 'Kapsul', 'Obat antialergi', 2);

-- Dumping structure for table db_kesehatan.penerimaan_obat
CREATE TABLE IF NOT EXISTS `penerimaan_obat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tanggal` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_obat` int DEFAULT NULL,
  `stok_masuk` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penerimaan_obat_ibfk_1` (`id_obat`),
  CONSTRAINT `penerimaan_obat_ibfk_1` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Dumping data for table db_kesehatan.penerimaan_obat: ~10 rows (approximately)
INSERT IGNORE INTO `penerimaan_obat` (`id`, `tanggal`, `id_obat`, `stok_masuk`) VALUES
	(13, '2023-09-12 17:00:00', 30, 100),
	(14, '2023-09-13 16:38:17', 31, 150),
	(15, '2023-09-13 16:38:17', 32, 200),
	(16, '2023-09-13 16:38:17', 33, 50),
	(17, '2023-09-13 16:38:17', 34, 80),
	(18, '2023-09-13 16:38:17', 35, 120),
	(19, '2023-09-13 16:38:17', 36, 90),
	(20, '2023-09-13 16:38:17', 37, 70),
	(22, '2023-09-13 16:38:17', 39, 110);

-- Dumping structure for table db_kesehatan.pengeluaran_obat
CREATE TABLE IF NOT EXISTS `pengeluaran_obat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `id_obat` int NOT NULL,
  `stok_keluar` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pengeluaran_obat_ibfk_1` (`id_obat`),
  CONSTRAINT `pengeluaran_obat_ibfk_1` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Dumping data for table db_kesehatan.pengeluaran_obat: ~10 rows (approximately)
INSERT IGNORE INTO `pengeluaran_obat` (`id`, `tanggal`, `id_obat`, `stok_keluar`) VALUES
	(3, '2023-09-01', 30, 0),
	(4, '2023-09-02', 31, 0),
	(5, '2023-09-03', 32, 0),
	(6, '2023-09-04', 33, 0),
	(7, '2023-09-05', 34, 1),
	(8, '2023-09-06', 35, 0),
	(9, '2023-09-07', 36, 0),
	(10, '2023-09-08', 37, 0),
	(12, '2023-09-10', 39, 0);

-- Dumping structure for table db_kesehatan.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Dumping data for table db_kesehatan.user: ~4 rows (approximately)
INSERT IGNORE INTO `user` (`id`, `username`, `password`, `full_name`, `role`) VALUES
	(7, 'operator', '$2a$12$FYfTN7eDSQO8Pimz7v7h1ez6a80N.HisoKRznpB6kIKAop52xu/La', 'Operator', 'operator'),
	(9, 'user', '$2a$12$JWLJQeiLT1jQGnwpYj5e9e7XxWoiHvVyndGyGARQkoAYukvoqqvci', 'User', 'user'),
	(10, 'test', '$2y$10$s2ZMH0fupwmC0iTUKeDG4.1mz/5id0COBygnUveF07n36GMUWi0fa', 'test', 'user'),
	(11, 'test1', 'test1', 'ya', 'user');

-- Dumping structure for trigger db_kesehatan.after_obat_insert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `after_obat_insert` AFTER INSERT ON `obat` FOR EACH ROW BEGIN
    INSERT INTO penerimaan_obat (id_obat, stok_masuk)
    VALUES (NEW.id, NEW.jumlah);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger db_kesehatan.trg_insert_pengeluaran_obat
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `trg_insert_pengeluaran_obat` AFTER INSERT ON `obat` FOR EACH ROW BEGIN
    INSERT INTO pengeluaran_obat (tanggal, id_obat, stok_keluar)
    VALUES (NEW.tanggal, NEW.id, 0);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger db_kesehatan.trg_update_stok_obat
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `trg_update_stok_obat` AFTER UPDATE ON `penerimaan_obat` FOR EACH ROW BEGIN
    -- Update stok di tabel obat
    UPDATE obat
    SET jumlah = jumlah + (NEW.stok_masuk - OLD.stok_masuk)
    WHERE id = NEW.id_obat;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger db_kesehatan.trg_update_stok_obat_pengeluaran
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `trg_update_stok_obat_pengeluaran` AFTER UPDATE ON `pengeluaran_obat` FOR EACH ROW BEGIN
    -- Update stok di tabel obat
    UPDATE obat
    SET jumlah = jumlah - (NEW.stok_keluar - OLD.stok_keluar)
    WHERE id = NEW.id_obat;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger db_kesehatan.update_stok_obat
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `update_stok_obat` AFTER UPDATE ON `penerimaan_obat` FOR EACH ROW BEGIN
    -- Perbarui jumlah di tabel obat
    UPDATE obat
    SET jumlah = jumlah + (NEW.stok_masuk - OLD.stok_masuk)
    WHERE id = NEW.id_obat;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
