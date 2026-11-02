-- AthleteTrack: migrasi 1 November 2026 (b) — ikut ERD laporan (atlet.pakej_id -> pakej_sukan.id)
-- Lajur lama `pakej` (teks) DIKEKALKAN supaya tiada data hilang.
-- Sandaran sebelum migrasi: C:\xampp\backup_athletetrack_20261101_b\athletetrack_db_SEBELUM.sql

ALTER TABLE `atlet`
  ADD COLUMN `pakej_id` int(11) DEFAULT NULL AFTER `tarikh_lahir`,
  ADD KEY `pakej_id` (`pakej_id`);

-- Isi pakej_id berdasarkan nama pakej sedia ada (dengan atau tanpa awalan "Pakej ").
UPDATE `atlet` a
JOIN `pakej_sukan` p ON p.`nama_pakej` = a.`pakej` OR p.`nama_pakej` = CONCAT('Pakej ', a.`pakej`)
SET a.`pakej_id` = p.`id`, a.`pakej` = p.`nama_pakej`;

-- Pakej yang masih digunakan atlet tidak boleh dipadam; ID pakej yang berubah dikemaskini automatik.
ALTER TABLE `atlet`
  ADD CONSTRAINT `atlet_ibfk_pakej` FOREIGN KEY (`pakej_id`) REFERENCES `pakej_sukan` (`id`) ON UPDATE CASCADE;
