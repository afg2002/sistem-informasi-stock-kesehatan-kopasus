-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 13 Sep 2023 pada 22.04
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kesehatan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alkes`
--

CREATE TABLE `alkes` (
  `id` int NOT NULL,
  `tanggal` date DEFAULT NULL,
  `nama_alkes` varchar(255) DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `alkes`
--

INSERT INTO `alkes` (`id`, `tanggal`, `nama_alkes`, `jumlah`, `jenis`, `keterangan`) VALUES
(27, '2023-09-13', 'Stetoskop', 30, 'Peralatan Medis', 'Stetoskop untuk mendengarkan suara jantung dan pernapasan.'),
(28, '2023-09-13', 'Termometer Digital', 70, 'Peralatan Medis', 'Termometer digital untuk mengukur suhu tubuh.'),
(29, '2023-09-13', 'Plester Luka', 100, 'Pertolongan Pertama', 'Plester luka untuk menutupi luka kecil.'),
(30, '2023-09-13', 'Gunting Medis', 40, 'Peralatan Medis', 'Gunting khusus untuk keperluan medis.'),
(31, '2023-09-13', 'Obat Pereda Nyeri', 60, 'Obat', 'Obat untuk meredakan rasa nyeri.'),
(32, '2023-09-13', 'Sarung Tangan Medis', 120, 'Peralatan Medis', 'Sarung tangan khusus untuk keperluan medis.'),
(33, '2023-09-13', 'Antiseptik Cair', 90, 'Pertolongan Pertama', 'Cairan antiseptik untuk membersihkan luka.'),
(34, '2023-09-13', 'Alat Pemeriksaan Mata', 20, 'Tes Kesehatan', 'Alat untuk memeriksa kesehatan mata.'),
(35, '2023-09-13', 'Masker Medis', 200, 'Peralatan Medis', 'Masker medis untuk melindungi pernapasan.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_obat`
--

CREATE TABLE `kategori_obat` (
  `id` int NOT NULL,
  `nama_kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `kategori_obat`
--

INSERT INTO `kategori_obat` (`id`, `nama_kategori`) VALUES
(1, 'ANALGETIK/ANTIPRETIK'),
(2, 'ANTIBIOTIC'),
(3, 'GIGI'),
(4, 'REAGENT LAB');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kendaraan`
--

CREATE TABLE `kendaraan` (
  `id` int NOT NULL,
  `nama_kendaraan` varchar(255) DEFAULT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  `bbm` varchar(255) DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `keterangan` text,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `kendaraan`
--

INSERT INTO `kendaraan` (`id`, `nama_kendaraan`, `jenis`, `bbm`, `jumlah`, `keterangan`, `timestamp`) VALUES
(13, 'Motor Pengantar Obat', 'Motor', 'Premium', 12, 'Motor untuk mengantar obat ke lokasi pasien...', '2023-09-13 20:00:04'),
(14, 'Mobil Penjemput Pasien', 'Ambulans', 'Solar', 3, 'Unit ambulans untuk menjemput pasien dari lokasi tertentu.', '2023-09-13 03:54:34'),
(15, 'Motor Operasional', 'Motor', 'Premium', 8, 'Motor operasional untuk keperluan tugas sehari-hari.', '2023-09-13 03:54:34'),
(17, 'Sepeda Motor Dinas', 'Motor', 'Pertamax', 15, 'Sepeda motor dinas untuk petugas medis.', '2023-09-13 03:54:34'),
(18, 'Ambulans Gawat Darurat', 'Ambulans', 'Solar', 2, 'Unit ambulans khusus untuk gawat darurat medis.', '2023-09-13 03:54:34'),
(19, 'Mobil Logistik', 'Truk', 'Solar', 4, 'Truk untuk keperluan logistik kesehatan.', '2023-09-13 03:54:34'),
(20, 'Kendaraan Pribadi', 'Sedan', 'Pertamax', 10, 'Kendaraan pribadi untuk keperluan dinas pribadi.', '2023-09-13 03:54:34'),
(21, 'Motor Pengawas', 'Motor', 'Pertamax', 5, 'Motor untuk keperluan pengawasan fasilitas kesehatan.', '2023-09-13 03:54:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `obat`
--

CREATE TABLE `obat` (
  `id` int NOT NULL,
  `tanggal` date DEFAULT NULL,
  `nama_obat` varchar(255) DEFAULT NULL,
  `merk` varchar(255) DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  `keterangan` text,
  `id_kategori_obat` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `obat`
--

INSERT INTO `obat` (`id`, `tanggal`, `nama_obat`, `merk`, `jumlah`, `jenis`, `keterangan`, `id_kategori_obat`) VALUES
(30, '2023-09-01', 'Paracetamol', 'Merk A', 100, 'Tablet', 'Obat penurun demam', 1),
(31, '2023-09-02', 'Amoxicillin', 'Merk B', 150, 'Kapsul', 'Obat antibiotik', 2),
(32, '2023-09-03', 'Ibuprofen', 'Merk C', 200, 'Tablet', 'Obat pereda nyeri', 1),
(33, '2023-09-04', 'Cough Syrup', 'Merk D', 50, 'Sirup', 'Obat batuk', 3),
(34, '2023-09-05', 'Aspirin', 'Merk E', 79, 'Tablet', 'Obat pereda nyeri', 1),
(35, '2023-09-06', 'Cetirizine', 'Merk F', 120, 'Kapsul', 'Obat antialergi', 2),
(36, '2023-09-07', 'Omeprazole', 'Merk G', 90, 'Tablet', 'Obat maag', 1),
(37, '2023-09-08', 'Insulin', 'Merk H', 70, 'Injeksi', 'Obat diabetes', 4),
(38, '2023-09-09', 'Diazepam', 'Merk I', 60, 'Tablet', 'Obat penenang', 1),
(39, '2023-09-10', 'Loratadine', 'Merk J', 110, 'Kapsul', 'Obat antialergi', 2);

--
-- Trigger `obat`
--
DELIMITER $$
CREATE TRIGGER `after_obat_insert` AFTER INSERT ON `obat` FOR EACH ROW BEGIN
    INSERT INTO penerimaan_obat (id_obat, stok_masuk)
    VALUES (NEW.id, NEW.jumlah);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_insert_pengeluaran_obat` AFTER INSERT ON `obat` FOR EACH ROW BEGIN
    INSERT INTO pengeluaran_obat (tanggal, id_obat, stok_keluar)
    VALUES (NEW.tanggal, NEW.id, 0);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penerimaan_obat`
--

CREATE TABLE `penerimaan_obat` (
  `id` int NOT NULL,
  `tanggal` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_obat` int DEFAULT NULL,
  `stok_masuk` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `penerimaan_obat`
--

INSERT INTO `penerimaan_obat` (`id`, `tanggal`, `id_obat`, `stok_masuk`) VALUES
(13, '2023-09-12 17:00:00', 30, 100),
(14, '2023-09-13 16:38:17', 31, 150),
(15, '2023-09-13 16:38:17', 32, 200),
(16, '2023-09-13 16:38:17', 33, 50),
(17, '2023-09-13 16:38:17', 34, 80),
(18, '2023-09-13 16:38:17', 35, 120),
(19, '2023-09-13 16:38:17', 36, 90),
(20, '2023-09-13 16:38:17', 37, 70),
(21, '2023-09-13 16:38:17', 38, 60),
(22, '2023-09-13 16:38:17', 39, 110);

--
-- Trigger `penerimaan_obat`
--
DELIMITER $$
CREATE TRIGGER `trg_update_stok_obat` AFTER UPDATE ON `penerimaan_obat` FOR EACH ROW BEGIN
    -- Update stok di tabel obat
    UPDATE obat
    SET jumlah = jumlah + (NEW.stok_masuk - OLD.stok_masuk)
    WHERE id = NEW.id_obat;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_stok_obat` AFTER UPDATE ON `penerimaan_obat` FOR EACH ROW BEGIN
    -- Perbarui jumlah di tabel obat
    UPDATE obat
    SET jumlah = jumlah + (NEW.stok_masuk - OLD.stok_masuk)
    WHERE id = NEW.id_obat;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengeluaran_obat`
--

CREATE TABLE `pengeluaran_obat` (
  `id` int NOT NULL,
  `tanggal` date NOT NULL,
  `id_obat` int NOT NULL,
  `stok_keluar` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pengeluaran_obat`
--

INSERT INTO `pengeluaran_obat` (`id`, `tanggal`, `id_obat`, `stok_keluar`) VALUES
(3, '2023-09-01', 30, 0),
(4, '2023-09-02', 31, 0),
(5, '2023-09-03', 32, 0),
(6, '2023-09-04', 33, 0),
(7, '2023-09-05', 34, 1),
(8, '2023-09-06', 35, 0),
(9, '2023-09-07', 36, 0),
(10, '2023-09-08', 37, 0),
(11, '2023-09-09', 38, 0),
(12, '2023-09-10', 39, 0);

--
-- Trigger `pengeluaran_obat`
--
DELIMITER $$
CREATE TRIGGER `trg_update_stok_obat_pengeluaran` AFTER UPDATE ON `pengeluaran_obat` FOR EACH ROW BEGIN
    -- Update stok di tabel obat
    UPDATE obat
    SET jumlah = jumlah - (NEW.stok_keluar - OLD.stok_keluar)
    WHERE id = NEW.id_obat;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `full_name`, `role`) VALUES
(7, 'operator', '$2a$12$FYfTN7eDSQO8Pimz7v7h1ez6a80N.HisoKRznpB6kIKAop52xu/La', 'Operator', 'operator'),
(9, 'user', '$2a$12$JWLJQeiLT1jQGnwpYj5e9e7XxWoiHvVyndGyGARQkoAYukvoqqvci', 'User', 'user'),
(10, 'test', '$2y$10$s2ZMH0fupwmC0iTUKeDG4.1mz/5id0COBygnUveF07n36GMUWi0fa', 'test', 'user'),
(11, 'test1', 'test1', 'ya', 'user');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alkes`
--
ALTER TABLE `alkes`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kategori_obat`
--
ALTER TABLE `kategori_obat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_kategori_obat` (`id_kategori_obat`);

--
-- Indeks untuk tabel `penerimaan_obat`
--
ALTER TABLE `penerimaan_obat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penerimaan_obat_ibfk_1` (`id_obat`);

--
-- Indeks untuk tabel `pengeluaran_obat`
--
ALTER TABLE `pengeluaran_obat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengeluaran_obat_ibfk_1` (`id_obat`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alkes`
--
ALTER TABLE `alkes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `kategori_obat`
--
ALTER TABLE `kategori_obat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `kendaraan`
--
ALTER TABLE `kendaraan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `obat`
--
ALTER TABLE `obat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `penerimaan_obat`
--
ALTER TABLE `penerimaan_obat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `pengeluaran_obat`
--
ALTER TABLE `pengeluaran_obat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `obat`
--
ALTER TABLE `obat`
  ADD CONSTRAINT `fk_kategori_obat` FOREIGN KEY (`id_kategori_obat`) REFERENCES `kategori_obat` (`id`);

--
-- Ketidakleluasaan untuk tabel `penerimaan_obat`
--
ALTER TABLE `penerimaan_obat`
  ADD CONSTRAINT `penerimaan_obat_ibfk_1` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengeluaran_obat`
--
ALTER TABLE `pengeluaran_obat`
  ADD CONSTRAINT `pengeluaran_obat_ibfk_1` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
