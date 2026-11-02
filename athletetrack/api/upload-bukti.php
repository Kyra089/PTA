<?php
// Atlet memuat naik bukti pembayaran bagi satu invois miliknya.
require_once __DIR__ . '/_init.php';

perluKaedah('POST');
$atletId = perluLogin('atlet');

$pembayaranId = filter_var($_POST['pembayaran_id'] ?? null, FILTER_VALIDATE_INT);
$fail = $_FILES['bukti'] ?? null;

if (!$pembayaranId) {
    jawab(422, ['success' => false, 'message' => 'Gagal muat naik. Sila pilih invois yang hendak dibayar.']);
}
if (!$fail || ($fail['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
    jawab(422, ['success' => false, 'message' => 'Gagal muat naik. Sila pilih fail bukti pembayaran.']);
}
if ($fail['error'] === UPLOAD_ERR_INI_SIZE || $fail['error'] === UPLOAD_ERR_FORM_SIZE || $fail['size'] > 5 * 1024 * 1024) {
    jawab(422, ['success' => false, 'message' => 'Gagal muat naik. Saiz fail melebihi 5MB.']);
}
if ($fail['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($fail['tmp_name'])) {
    jawab(400, ['success' => false, 'message' => 'Gagal muat naik. Sila cuba lagi.']);
}

$jenisDibenarkan = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'application/pdf' => 'pdf'];
$mime = (new finfo(FILEINFO_MIME_TYPE))->file($fail['tmp_name']);
if (!isset($jenisDibenarkan[$mime])) {
    jawab(422, ['success' => false, 'message' => 'Gagal muat naik. Jenis fail tidak dibenarkan. Gunakan JPG, PNG atau PDF.']);
}

try {
    $stmt = $pdo->prepare('SELECT id, status, bukti_fail FROM pembayaran WHERE id = ? AND atlet_id = ?');
    $stmt->execute([$pembayaranId, $atletId]);
    $invois = $stmt->fetch();

    if (!$invois) {
        jawab(404, ['success' => false, 'message' => 'Gagal muat naik. Invois tidak dijumpai.']);
    }
    if ($invois['status'] === 'sudah') {
        jawab(422, ['success' => false, 'message' => 'Gagal muat naik. Invois ini telah disahkan. Tiada bayaran diperlukan.']);
    }

    $folder = __DIR__ . '/../uploads/bukti';
    if (!is_dir($folder) && !mkdir($folder, 0775, true)) {
        jawab(500, ['success' => false, 'message' => 'Gagal muat naik. Folder muat naik tidak dapat dicipta.']);
    }

    $namaFail = sprintf('bukti_%d_%d_%s.%s', $atletId, $pembayaranId, bin2hex(random_bytes(6)), $jenisDibenarkan[$mime]);
    if (!move_uploaded_file($fail['tmp_name'], $folder . '/' . $namaFail)) {
        jawab(500, ['success' => false, 'message' => 'Gagal muat naik. Fail gagal disimpan.']);
    }

    $pdo->prepare("UPDATE pembayaran SET bukti_fail = ?, status = 'menunggu_sahkan', tarikh_bayar = NOW() WHERE id = ?")
        ->execute([$namaFail, $pembayaranId]);

    // Buang fail bukti lama (contohnya bukti yang telah ditolak).
    if (!empty($invois['bukti_fail']) && is_file($folder . '/' . basename($invois['bukti_fail']))) {
        @unlink($folder . '/' . basename($invois['bukti_fail']));
    }

    jawab(200, ['success' => true, 'message' => 'Fail berjaya dimuat naik. Menunggu pengesahan admin.']);
} catch (PDOException $e) {
    error_log('AthleteTrack upload proof error: ' . $e->getMessage());
    jawab(500, ['success' => false, 'message' => 'Gagal muat naik. Bukti pembayaran gagal disimpan.']);
}
