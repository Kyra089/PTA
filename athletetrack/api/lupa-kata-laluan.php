<?php
// Carta alir log masuk: lupa kata laluan -> masukkan e-mel berdaftar -> terima kata laluan baharu melalui e-mel.
require_once __DIR__ . '/_init.php';
require_once __DIR__ . '/emel.php';

perluKaedah('POST');

$email = trim((string)(dataJson()['email'] ?? ''));
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jawab(422, ['success' => false, 'message' => 'Sila masukkan alamat e-mel yang sah.']);
}
if (!emelDikonfigurasi()) {
    jawab(503, ['success' => false, 'message' => 'Fungsi e-mel belum dikonfigurasi. Sila hubungi admin kelab untuk menetapkan semula kata laluan.']);
}

try {
    $akaun = [];
    foreach (['atlet', 'admin'] as $jadual) {
        $stmt = $pdo->prepare("SELECT id, nama FROM $jadual WHERE email = ?");
        $stmt->execute([$email]);
        if ($baris = $stmt->fetch()) {
            $akaun[$jadual] = $baris;
        }
    }
    if (!$akaun) {
        jawab(404, ['success' => false, 'message' => 'E-mel ini tidak berdaftar dalam sistem.']);
    }

    // Kata laluan sementara 10 aksara (tanpa huruf yang mudah keliru seperti O/0, l/1).
    $aksara = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
    $baru = '';
    for ($i = 0; $i < 10; $i++) {
        $baru .= $aksara[random_int(0, strlen($aksara) - 1)];
    }

    $nama = reset($akaun)['nama'];
    $badan = "Assalamualaikum dan salam sejahtera $nama,\n\n"
        . "Kata laluan baharu akaun AthleteTrack anda ialah:\n\n    $baru\n\n"
        . "Sila log masuk menggunakan kata laluan ini dan tukar kata laluan anda di halaman Profil.\n\n"
        . "Jika anda tidak meminta penetapan semula kata laluan, sila hubungi admin kelab.\n\nKelab Olahraga Shah Alam";

    // Hantar e-mel dahulu; kata laluan hanya ditukar jika e-mel berjaya dihantar.
    if (!hantarEmel($email, 'Kata Laluan Baharu AthleteTrack', $badan)) {
        jawab(502, ['success' => false, 'message' => 'E-mel gagal dihantar. Sila cuba lagi atau hubungi admin kelab.']);
    }
    $hash = password_hash($baru, PASSWORD_DEFAULT);
    foreach ($akaun as $jadual => $baris) {
        $pdo->prepare("UPDATE $jadual SET kata_laluan = ? WHERE id = ?")->execute([$hash, $baris['id']]);
    }

    jawab(200, ['success' => true, 'message' => 'Kata laluan baharu telah dihantar ke e-mel anda. Sila semak peti masuk.']);
} catch (PDOException $e) {
    error_log('AthleteTrack forgot password error: ' . $e->getMessage());
    jawab(500, ['success' => false, 'message' => 'Ralat pangkalan data. Sila cuba lagi.']);
}
