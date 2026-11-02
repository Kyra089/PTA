<?php
// Tetapan e-mel AthleteTrack (Gmail).
// 1. Log masuk ke akaun Gmail kelab > Google Account > Security > 2-Step Verification (hidupkan).
// 2. Google Account > Security > App passwords > cipta kata laluan aplikasi (16 aksara).
// 3. Isi 'pengguna' dan 'kata_laluan' di bawah, kemudian simpan fail ini.
// Selagi 'pengguna' kosong, sistem tidak menghantar e-mel dan akan memaklumkan perkara itu.
return [
    'hos'         => 'smtp.gmail.com',
    'port'        => 465,          // 465 = SSL, 587 = STARTTLS
    'keselamatan' => 'ssl',        // 'ssl', 'tls' atau '' (tanpa penyulitan, untuk ujian sahaja)
    'pengguna'    => '',           // contoh: athleticsshahalam@gmail.com
    'kata_laluan' => '',           // App Password Gmail (bukan kata laluan biasa)
    'nama_pengirim' => 'Kelab Olahraga Shah Alam',
];
