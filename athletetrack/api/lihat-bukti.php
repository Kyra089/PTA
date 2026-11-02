<?php
// Papar fail bukti pembayaran. Hanya admin atau atlet pemilik invois dibenarkan.
require_once __DIR__ . '/_init.php';

perluKaedah('GET');

$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
$peranan = $_SESSION['peranan'] ?? '';

if (empty($_SESSION['user_id']) || !in_array($peranan, ['admin', 'atlet'], true)) {
    jawab(401, ['success' => false, 'message' => 'Sila log masuk.']);
}
if (!$id) {
    jawab(422, ['success' => false, 'message' => 'ID pembayaran tidak sah.']);
}

try {
    $stmt = $pdo->prepare('SELECT atlet_id, bukti_fail FROM pembayaran WHERE id = ?');
    $stmt->execute([$id]);
    $rekod = $stmt->fetch();
} catch (PDOException $e) {
    error_log('AthleteTrack view proof error: ' . $e->getMessage());
    jawab(500, ['success' => false, 'message' => 'Bukti gagal dimuatkan.']);
}

if (!$rekod || ($peranan === 'atlet' && (int)$rekod['atlet_id'] !== (int)$_SESSION['user_id'])) {
    jawab(404, ['success' => false, 'message' => 'Bukti pembayaran tidak dijumpai.']);
}

$laluan = __DIR__ . '/../uploads/bukti/' . basename((string)$rekod['bukti_fail']);
if (empty($rekod['bukti_fail']) || !is_file($laluan)) {
    jawab(404, ['success' => false, 'message' => 'Fail bukti tidak dijumpai.']);
}

header('Content-Type: ' . (new finfo(FILEINFO_MIME_TYPE))->file($laluan));
header('Content-Length: ' . filesize($laluan));
header('Content-Disposition: inline; filename="' . basename($laluan) . '"');
header('X-Content-Type-Options: nosniff');
readfile($laluan);
