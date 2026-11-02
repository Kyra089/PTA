<?php
// Maklumat pengguna yang sedang log masuk (digunakan semasa halaman dimuat semula).
require_once __DIR__ . '/_init.php';

perluKaedah('GET');

$peranan = $_SESSION['peranan'] ?? '';

if (empty($_SESSION['user_id']) || !in_array($peranan, ['admin', 'atlet'], true)) {
    jawab(200, ['success' => true, 'data' => null]);
}

try {
    // Nama sentiasa dibaca semula daripada pangkalan data supaya sentiasa terkini.
    $stmt = $pdo->prepare($peranan === 'admin'
        ? 'SELECT id, nama FROM admin WHERE id = ?'
        : 'SELECT id, nama FROM atlet WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $pengguna = $stmt->fetch();

    if (!$pengguna) {
        // Akaun telah dipadam: tamatkan sesi.
        $_SESSION = [];
        session_destroy();
        jawab(200, ['success' => true, 'data' => null]);
    }

    $_SESSION['nama'] = $pengguna['nama'];

    jawab(200, [
        'success' => true,
        'data' => [
            'id' => (int)$pengguna['id'],
            'nama' => $pengguna['nama'],
            'peranan' => $peranan,
            'invois_daftar' => $peranan === 'atlet' ? invoisDaftarBelumBayar($pdo, (int)$pengguna['id']) : null
        ]
    ]);
} catch (PDOException $e) {
    error_log('AthleteTrack session error: ' . $e->getMessage());
    jawab(500, ['success' => false, 'message' => 'Gagal menyemak sesi.']);
}
