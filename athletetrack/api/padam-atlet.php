<?php
require_once __DIR__ . '/_init.php';

perluKaedah('POST');
perluLogin('admin');

$data = json_decode(file_get_contents('php://input'), true);

if (!is_array($data) || empty($data['id'])) {
    jawab(422, [
        'success' => false,
        'message' => 'ID atlet tidak sah.'
    ]);
}

$id = filter_var($data['id'], FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    jawab(422, [
        'success' => false,
        'message' => 'ID atlet tidak sah.'
    ]);
}

try {
    $pdo->beginTransaction();

    $bukti = $pdo->prepare('SELECT bukti_fail FROM pembayaran WHERE atlet_id = ? AND bukti_fail IS NOT NULL');
    $bukti->execute([$id]);
    $failBukti = $bukti->fetchAll(PDO::FETCH_COLUMN);

    // Rekod berkaitan (foreign key) mesti dipadam dahulu, jika tidak atlet tidak boleh dipadam.
    foreach (['kehadiran', 'prestasi', 'pembayaran'] as $jadual) {
        $pdo->prepare("DELETE FROM $jadual WHERE atlet_id = ?")->execute([$id]);
    }

    $stmt = $pdo->prepare('DELETE FROM atlet WHERE id = ?');
    $stmt->execute([$id]);

    if ($stmt->rowCount() === 0) {
        $pdo->rollBack();
        jawab(404, [
            'success' => false,
            'message' => 'Rekod atlet tidak dijumpai.'
        ]);
    }

    $pdo->commit();

    foreach ($failBukti as $fail) {
        $laluan = __DIR__ . '/../uploads/bukti/' . basename($fail);
        if (is_file($laluan)) {
            @unlink($laluan);
        }
    }

    jawab(200, [
        'success' => true,
        'message' => 'Rekod atlet berjaya dipadam.'
    ]);

} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log('AthleteTrack delete athlete error: ' . $e->getMessage());

    jawab(500, [
        'success' => false,
        'message' => 'Rekod gagal dipadam. Sila semak data berkaitan.'
    ]);
}
