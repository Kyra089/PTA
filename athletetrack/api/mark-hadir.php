<?php
// POST {"tarikh":"YYYY-MM-DD","rekod":[{"atlet_id":1,"status":"hadir"|"tidak"|""}]}
// Status "" membuang rekod atlet pada tarikh tersebut (belum ditanda).
require_once __DIR__ . '/_init.php';

perluKaedah('POST');
perluLogin('admin');

$data = dataJson();
$tarikh = (string)($data['tarikh'] ?? '');
$rekod = $data['rekod'] ?? null;

if (!tarikhSah($tarikh)) {
    jawab(422, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Sila pilih tarikh latihan yang sah.']);
}
if ($tarikh > date('Y-m-d')) {
    jawab(422, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Kehadiran tidak boleh ditanda untuk tarikh akan datang.']);
}
if (!is_array($rekod) || !$rekod) {
    jawab(422, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Tiada rekod kehadiran untuk disimpan.']);
}

try {
    $padam = $pdo->prepare('DELETE FROM kehadiran WHERE atlet_id = ? AND tarikh = ?');
    $tambah = $pdo->prepare('INSERT INTO kehadiran (atlet_id, tarikh, status) VALUES (?, ?, ?)');
    $semakAtlet = $pdo->prepare('SELECT a.id FROM atlet a WHERE a.id = ? AND ' . SQL_KATEGORI_ATLET . " <> 'belum'");

    $pdo->beginTransaction();
    foreach ($rekod as $r) {
        $atletId = filter_var($r['atlet_id'] ?? null, FILTER_VALIDATE_INT);
        $status = (string)($r['status'] ?? '');
        if (!$atletId || !in_array($status, ['hadir', 'tidak', ''], true)) {
            $pdo->rollBack();
            jawab(422, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Data kehadiran tidak sah.']);
        }
        $semakAtlet->execute([$atletId]);
        if (!$semakAtlet->fetch()) {
            $pdo->rollBack();
            jawab(404, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Atlet tidak dijumpai atau belum berdaftar.']);
        }
        // Satu rekod sahaja bagi setiap atlet pada satu tarikh.
        $padam->execute([$atletId, $tarikh]);
        if ($status !== '') {
            $tambah->execute([$atletId, $tarikh, $status]);
        }
    }
    $pdo->commit();

    jawab(200, ['success' => true, 'message' => 'Kehadiran berjaya disimpan!']);
} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log('AthleteTrack attendance save error: ' . $e->getMessage());
    jawab(500, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Kehadiran gagal disimpan.']);
}
