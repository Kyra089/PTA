<?php
require_once __DIR__ . '/_init.php';

perluKaedah('GET');

// Pastikan pengguna ialah admin yang telah log masuk
$adminId = perluLogin('admin');

try {
    $stmt = $pdo->prepare(
        'SELECT id, nama, no_kp, tarikh_lahir, telefon, email FROM admin WHERE id = ?'
    );

    $stmt->execute([$adminId]);

    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$admin) {
        jawab(404, [
            'success' => false,
            'message' => 'Maklumat admin tidak dijumpai.'
        ]);
    }

    jawab(200, [
        'success' => true,
        'data' => $admin
    ]);

} catch (PDOException $e) {
    error_log('AthleteTrack admin profile error: ' . $e->getMessage());

    jawab(500, [
        'success' => false,
        'message' => 'Gagal mendapatkan maklumat admin.'
    ]);
}
