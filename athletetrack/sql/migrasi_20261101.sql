-- AthleteTrack: migrasi 1 November 2026
-- Hanya MENAMBAH lajur (semua boleh NULL). Tiada jadual atau rekod dipadam.
-- Sandaran sebelum migrasi: C:\xampp\backup_athletetrack_20261101\athletetrack_db_SEBELUM.sql
-- Cara jalankan: phpMyAdmin > athletetrack_db > tab SQL > tampal kandungan fail ini > Go

ALTER TABLE `admin`
  ADD COLUMN `no_kp` varchar(20) DEFAULT NULL AFTER `nama`,
  ADD COLUMN `tarikh_lahir` date DEFAULT NULL AFTER `no_kp`,
  ADD COLUMN `telefon` varchar(20) DEFAULT NULL AFTER `email`;

ALTER TABLE `atlet`
  ADD COLUMN `nama_waris` varchar(100) DEFAULT NULL AFTER `sesi`,
  ADD COLUMN `emel_waris` varchar(100) DEFAULT NULL AFTER `no_telefon_waris`,
  ADD COLUMN `sekolah` varchar(150) DEFAULT NULL AFTER `emel_waris`,
  ADD COLUMN `tarikh_daftar` datetime DEFAULT NULL AFTER `sekolah`;

ALTER TABLE `jurulatih`
  ADD COLUMN `no_kp` varchar(20) DEFAULT NULL AFTER `nama`,
  ADD COLUMN `tarikh_lahir` date DEFAULT NULL AFTER `no_kp`,
  ADD COLUMN `kepakaran` varchar(100) DEFAULT NULL AFTER `tarikh_lahir`,
  ADD COLUMN `email` varchar(100) DEFAULT NULL AFTER `telefon`,
  ADD COLUMN `nama_waris` varchar(100) DEFAULT NULL AFTER `email`,
  ADD COLUMN `telefon_waris` varchar(20) DEFAULT NULL AFTER `nama_waris`,
  ADD COLUMN `emel_waris` varchar(100) DEFAULT NULL AFTER `telefon_waris`;

ALTER TABLE `pakej_sukan`
  ADD COLUMN `sukan` varchar(150) DEFAULT NULL AFTER `nama_pakej`,
  ADD COLUMN `hari` varchar(100) DEFAULT NULL AFTER `sukan`,
  ADD COLUMN `poster` varchar(255) DEFAULT NULL AFTER `harga`;

ALTER TABLE `pembayaran`
  MODIFY `status` enum('belum','menunggu_sahkan','sudah','ditolak') DEFAULT 'belum',
  ADD COLUMN `tarikh_bayar` datetime DEFAULT NULL AFTER `bukti_fail`;

ALTER TABLE `prestasi`
  ADD COLUMN `acara` varchar(100) DEFAULT NULL AFTER `tarikh`;

-- Jadual pakej_sukan masih kosong. Isi dengan 6 pakej yang sedia dipaparkan
-- pada halaman Pakej Sukan (bukan data contoh), hanya jika belum wujud.
INSERT INTO `pakej_sukan` (`nama_pakej`, `sukan`, `hari`, `sesi`, `harga`, `poster`)
SELECT * FROM (
  SELECT 'Pakej Hari Biasa' AS n, 'Track & Field (Larian Pecut & Asas)' AS s, 'Isnin & Khamis' AS h, 'Petang / Malam' AS se, 180.00 AS hg, 'weekday package.jfif' AS p UNION ALL
  SELECT 'Pakej Hari Sabtu', 'Track & Field (Larian Pecut & Asas)', 'Sabtu', 'Petang', 160.00, 'weekend package.jfif' UNION ALL
  SELECT 'Pakej Lompat Tinggi', 'Lompat Tinggi (High Jump)', 'Sabtu', 'Petang', 160.00, 'high jump.jfif' UNION ALL
  SELECT 'Pakej Latihan Lontaran', 'Javelin, Shot Put, Discus', 'Isnin', 'Malam', 160.00, 'lontar peluru.jfif' UNION ALL
  SELECT 'Pakej Larian Jarak Jauh (Dewasa)', 'Larian Jarak Jauh (Dewasa)', 'Isnin & Khamis', 'Malam', 180.00, 'mid long distance.jfif' UNION ALL
  SELECT 'Pakej Larian Jarak Jauh (9-18 Tahun)', 'Larian Jarak Jauh (9-18 Tahun)', 'Isnin & Khamis', 'Malam', 180.00, 'mid long distance (9-18).jfif'
) AS baru
WHERE NOT EXISTS (SELECT 1 FROM `pakej_sukan` WHERE `nama_pakej` = baru.n);
