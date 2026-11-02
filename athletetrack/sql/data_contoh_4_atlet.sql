-- Data contoh AthleteTrack: 4 atlet (satu bagi setiap kategori) berserta invois, kehadiran dan prestasi.
-- Cara guna: phpMyAdmin > pilih pangkalan data athletetrack_db > tab SQL > tampal semua > Go.
-- Hanya INSERT. Tiada rekod sedia ada dipadam atau diubah.
-- Kata laluan semua atlet contoh: Atlet123  (log masuk guna No. KP atau e-mel)
--
--   AMIRUL HAKIM   - daftar Ogos 2026, yuran pendaftaran disahkan        -> Atlet Berdaftar
--   NUR AISYAH     - daftar Sep 2026, bukti Oktober ditolak admin        -> Atlet Berdaftar
--   DANIEL LIM     - daftar 25 Okt 2026, yuran pendaftaran disahkan      -> Atlet Baharu
--   SITI HAJAR     - daftar 30 Okt 2026, yuran pendaftaran belum dibayar -> Belum Berdaftar
--
-- Nota: kategori "Atlet Baharu" bertukar kepada "Atlet Berdaftar" secara automatik selepas sebulan.

START TRANSACTION;

SET @hash = '$2y$10$lExs1q8RR28L6xq7Z.1Q1Ou/HEJUKB0t1y2DpwDclW2SmLA6LbMne';

-- 1. AMIRUL HAKIM (Pakej Hari Biasa, RM180)
INSERT INTO atlet (nama, no_kp, email, kata_laluan, tarikh_lahir, pakej_id, pakej, sesi, nama_waris, no_telefon_waris, emel_waris, sekolah, tarikh_daftar)
VALUES ('AMIRUL HAKIM BIN ROSLI', '080315-10-1235', 'amirul.hakim@gmail.com', @hash, '2008-03-15',
        (SELECT id FROM pakej_sukan WHERE nama_pakej = 'Pakej Hari Biasa'), 'Pakej Hari Biasa', 'Sesi Petang (5.00pm – 6.15pm)',
        'ROSLI BIN AHMAD', '012-3344556', 'rosli.ahmad@gmail.com', 'SMK Seksyen 9 Shah Alam', '2026-08-04 10:15:00');
SET @a1 = LAST_INSERT_ID();
INSERT INTO pembayaran (atlet_id, bulan, jumlah, tarikh_akhir, status, bukti_fail, tarikh_bayar) VALUES
  (@a1, 'Ogos 2026',      205.00, '2026-09-05', 'sudah', NULL, '2026-08-04 11:00:00'),
  (@a1, 'September 2026', 180.00, '2026-10-05', 'sudah', NULL, '2026-09-28 20:10:00'),
  (@a1, 'Oktober 2026',   180.00, '2026-11-05', 'sudah', NULL, '2026-10-30 21:05:00'),
  (@a1, 'November 2026',  180.00, '2026-12-05', 'belum', NULL, NULL);

-- 2. NUR AISYAH (Pakej Lompat Tinggi, RM160)
INSERT INTO atlet (nama, no_kp, email, kata_laluan, tarikh_lahir, pakej_id, pakej, sesi, nama_waris, no_telefon_waris, emel_waris, sekolah, tarikh_daftar)
VALUES ('NUR AISYAH BINTI KAMAL', '100722-14-5678', 'aisyah.kamal@gmail.com', @hash, '2010-07-22',
        (SELECT id FROM pakej_sukan WHERE nama_pakej = 'Pakej Lompat Tinggi'), 'Pakej Lompat Tinggi', 'Sesi Petang (5.00pm – 6.30pm)',
        'KAMAL BIN YUSOF', '013-6677889', 'kamal.yusof@gmail.com', 'SMK Seksyen 18 Shah Alam', '2026-09-10 16:40:00');
SET @a2 = LAST_INSERT_ID();
INSERT INTO pembayaran (atlet_id, bulan, jumlah, tarikh_akhir, status, bukti_fail, tarikh_bayar) VALUES
  (@a2, 'September 2026', 185.00, '2026-10-05', 'sudah',   NULL, '2026-09-10 17:00:00'),
  (@a2, 'Oktober 2026',   160.00, '2026-11-05', 'ditolak', NULL, '2026-10-29 22:30:00'),
  (@a2, 'November 2026',  160.00, '2026-12-05', 'belum',   NULL, NULL);

-- 3. DANIEL LIM (Pakej Hari Sabtu, RM160)
INSERT INTO atlet (nama, no_kp, email, kata_laluan, tarikh_lahir, pakej_id, pakej, sesi, nama_waris, no_telefon_waris, emel_waris, sekolah, tarikh_daftar)
VALUES ('DANIEL LIM WEI JIE', '090110-08-4321', 'daniel.lim@gmail.com', @hash, '2009-01-10',
        (SELECT id FROM pakej_sukan WHERE nama_pakej = 'Pakej Hari Sabtu'), 'Pakej Hari Sabtu', 'Sesi Petang (5.00pm – 6.30pm)',
        'LIM CHEE KEONG', '016-2233445', 'lim.ck@gmail.com', 'SMK Seksyen 7 Shah Alam', '2026-10-25 09:20:00');
SET @a3 = LAST_INSERT_ID();
INSERT INTO pembayaran (atlet_id, bulan, jumlah, tarikh_akhir, status, bukti_fail, tarikh_bayar) VALUES
  (@a3, 'Oktober 2026',  185.00, '2026-11-05', 'sudah', NULL, '2026-10-25 09:45:00'),
  (@a3, 'November 2026', 160.00, '2026-12-05', 'belum', NULL, NULL);

-- 4. SITI HAJAR (Pakej Latihan Lontaran, RM160) - belum bayar yuran pendaftaran
INSERT INTO atlet (nama, no_kp, email, kata_laluan, tarikh_lahir, pakej_id, pakej, sesi, nama_waris, no_telefon_waris, emel_waris, sekolah, tarikh_daftar)
VALUES ('SITI HAJAR BINTI OMAR', '110505-10-2468', 'siti.hajar@gmail.com', @hash, '2011-05-05',
        (SELECT id FROM pakej_sukan WHERE nama_pakej = 'Pakej Latihan Lontaran'), 'Pakej Latihan Lontaran', 'Sesi Malam (8.00pm – 9.00pm)',
        'OMAR BIN HASSAN', '019-5566778', 'omar.hassan@gmail.com', NULL, '2026-10-30 20:00:00');
SET @a4 = LAST_INSERT_ID();
INSERT INTO pembayaran (atlet_id, bulan, jumlah, tarikh_akhir, status, bukti_fail, tarikh_bayar) VALUES
  (@a4, 'Oktober 2026', 185.00, '2026-11-05', 'belum', NULL, NULL);

-- Kehadiran Oktober 2026 (atlet berdaftar sahaja)
INSERT INTO kehadiran (atlet_id, tarikh, status) VALUES
  (@a1, '2026-10-06', 'hadir'), (@a1, '2026-10-13', 'hadir'), (@a1, '2026-10-20', 'tidak'), (@a1, '2026-10-27', 'hadir'),
  (@a2, '2026-10-06', 'hadir'), (@a2, '2026-10-13', 'tidak'), (@a2, '2026-10-20', 'hadir'), (@a2, '2026-10-27', 'hadir'),
  (@a3, '2026-10-31', 'hadir');

-- Prestasi (lajur tarikh = hari pertama bulan)
INSERT INTO prestasi (atlet_id, tarikh, acara, catatan, markah) VALUES
  (@a1, '2026-09-01', 'Larian 100m (saat)', NULL, 13.20),
  (@a1, '2026-10-01', 'Larian 100m (saat)', NULL, 12.90),
  (@a1, '2026-10-01', 'Lompat Jauh (m)',    NULL, 5.10),
  (@a2, '2026-09-01', 'Lompat Tinggi (m)',  NULL, 1.35),
  (@a2, '2026-10-01', 'Lompat Tinggi (m)',  NULL, 1.42),
  (@a3, '2026-10-01', 'Larian 100m (saat)', NULL, 13.80);

COMMIT;
