<?php
// Atlet memadam bukti pembayaran yang belum disemak admin (status "Menunggu").
require_once __DIR__ . '/_init.php';

perluKaedah('POST');
$atletId = perluLogin('atlet');

$id = filter_var(dataJson()['pembayaran_id'] ?? null, FILTER_VALIDATE_INT);
if (!$id) {
    jawab(422, ['success' => false, 'message' => 'Invois tidak sah.']);
}

try {
    $stmt = $pdo->prepare('SELECT status, bukti_fail FROM pembayaran WHERE id = ? AND atlet_id = ?');
    $stmt->execute([$id, $atletId]);
    $invois = $stmt->fetch();

    if (!$invois || empty($invois['bukti_fail'])) {
        jawab(404, ['success' => false, 'message' => 'Tiada bukti pembayaran untuk dipadam.']);
    }
    if ($invois['status'] !== 'menunggu_sahkan') {
        jawab(422, ['success' => false, 'message' => 'Bukti yang telah disemak oleh admin tidak boleh dipadam.']);
    }

    // Resit yuran pendaftaran tidak boleh dibiarkan kosong; atlet mesti menggantikannya dengan resit baharu.
    $pertama = $pdo->prepare('SELECT MIN(id) FROM pembayaran WHERE atlet_id = ?');
    $pertama->execute([$atletId]);
    if ((int)$pertama->fetchColumn() === $id) {
        jawab(422, ['success' => false, 'message' => 'Resit yuran pendaftaran tidak boleh dipadam begitu sahaja. Sila muat naik resit baharu untuk menggantikannya.']);
    }

    $pdo->prepare("UPDATE pembayaran SET bukti_fail = NULL, status = 'belum', tarikh_bayar = NULL WHERE id = ?")
        ->execute([$id]);

    $laluan = __DIR__ . '/../uploads/bukti/' . basename($invois['bukti_fail']);
    if (is_file($laluan)) {
        @unlink($laluan);
    }

    jawab(200, ['success' => true, 'message' => 'Bukti pembayaran berjaya dipadam.']);
} catch (PDOException $e) {
    error_log('AthleteTrack delete proof error: ' . $e->getMessage());
    jawab(500, ['success' => false, 'message' => 'Bukti pembayaran gagal dipadam.']);
}
