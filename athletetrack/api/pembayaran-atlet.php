<?php
// Senarai invois milik atlet yang sedang log masuk.
require_once __DIR__ . '/_init.php';

perluKaedah('GET');
$atletId = perluLogin('atlet');

try {
    pastikanInvoisBulanSemasa($pdo, $atletId);

    $stmt = $pdo->prepare('SELECT ' . SQL_NAMA_PAKEJ . ' FROM atlet a ' . SQL_PAKEJ_ATLET . ' WHERE a.id = ?');
    $stmt->execute([$atletId]);
    $pakej = normalPakej($stmt->fetchColumn() ?: '');

    $stmt = $pdo->prepare(
        'SELECT id, bulan, jumlah, tarikh_akhir, status, tarikh_bayar, bukti_fail IS NOT NULL AS ada_bukti
         FROM pembayaran WHERE atlet_id = ? ORDER BY tarikh_akhir DESC, id DESC'
    );
    $stmt->execute([$atletId]);
    $invois = $stmt->fetchAll();

    foreach ($invois as &$i) {
        $i['id'] = (int)$i['id'];
        $i['no'] = noInvois($i['id'], (string)$i['tarikh_akhir']);
        $i['jumlah'] = (float)$i['jumlah'];
        $i['ada_bukti'] = (bool)$i['ada_bukti'];
        $i['pakej'] = $pakej;
    }
    unset($i);

    jawab(200, ['success' => true, 'data' => $invois]);
} catch (PDOException $e) {
    error_log('AthleteTrack athlete payments error: ' . $e->getMessage());
    jawab(500, ['success' => false, 'message' => 'Rekod pembayaran gagal dimuatkan.']);
}
