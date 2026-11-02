<?php
// GET  : senarai jurulatih.
// POST : {"aksi":"tambah"|"kemaskini"|"padam", ...}
require_once __DIR__ . '/_init.php';

perluLogin('admin');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $jurulatih = $pdo->query(
            'SELECT id, nama, no_kp, tarikh_lahir, kepakaran, telefon, email, nama_waris, telefon_waris, emel_waris
             FROM jurulatih ORDER BY nama'
        )->fetchAll();
        jawab(200, ['success' => true, 'data' => $jurulatih]);
    }

    perluKaedah('POST');
    $data = dataJson();
    $aksi = $data['aksi'] ?? '';
    $id = filter_var($data['id'] ?? null, FILTER_VALIDATE_INT);

    if ($aksi === 'padam') {
        if (!$id) {
            jawab(422, ['success' => false, 'message' => 'Gagal kemaskini maklumat. ID jurulatih tidak sah.']);
        }
        $stmt = $pdo->prepare('DELETE FROM jurulatih WHERE id = ?');
        $stmt->execute([$id]);
        if ($stmt->rowCount() === 0) {
            jawab(404, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Rekod jurulatih tidak dijumpai.']);
        }
        jawab(200, ['success' => true, 'message' => 'Rekod jurulatih berjaya dipadam.']);
    }

    if ($aksi !== 'tambah' && $aksi !== 'kemaskini') {
        jawab(422, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Aksi tidak sah.']);
    }

    $medan = [];
    foreach (['nama', 'no_kp', 'tarikh_lahir', 'kepakaran', 'telefon', 'email', 'nama_waris', 'telefon_waris', 'emel_waris'] as $m) {
        $medan[$m] = trim((string)($data[$m] ?? ''));
    }
    foreach (['nama', 'no_kp', 'tarikh_lahir', 'kepakaran', 'telefon', 'email', 'nama_waris', 'telefon_waris'] as $wajib) {
        if ($medan[$wajib] === '') {
            jawab(422, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Sila lengkapkan semua maklumat wajib jurulatih.']);
        }
    }
    if (!tarikhSah($medan['tarikh_lahir']) || $medan['tarikh_lahir'] > date('Y-m-d')) {
        jawab(422, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Tarikh lahir tidak sah.']);
    }
    if (!filter_var($medan['email'], FILTER_VALIDATE_EMAIL)) {
        jawab(422, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Alamat e-mel jurulatih tidak sah.']);
    }
    if ($medan['emel_waris'] !== '' && !filter_var($medan['emel_waris'], FILTER_VALIDATE_EMAIL)) {
        jawab(422, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Alamat e-mel waris tidak sah.']);
    }
    $medan['emel_waris'] = $medan['emel_waris'] === '' ? null : $medan['emel_waris'];

    $sama = $pdo->prepare('SELECT id FROM jurulatih WHERE no_kp = ? AND id <> ?');
    $sama->execute([$medan['no_kp'], $id ?: 0]);
    if ($sama->fetch()) {
        jawab(409, ['success' => false, 'message' => 'Gagal kemaskini maklumat. No. kad pengenalan ini sudah didaftarkan untuk jurulatih lain.']);
    }

    if ($aksi === 'tambah') {
        $pdo->prepare(
            'INSERT INTO jurulatih (nama, no_kp, tarikh_lahir, kepakaran, telefon, email, nama_waris, telefon_waris, emel_waris)
             VALUES (:nama, :no_kp, :tarikh_lahir, :kepakaran, :telefon, :email, :nama_waris, :telefon_waris, :emel_waris)'
        )->execute($medan);
        jawab(200, ['success' => true, 'message' => 'Jurulatih berjaya ditambah!']);
    }

    if (!$id) {
        jawab(422, ['success' => false, 'message' => 'Gagal kemaskini maklumat. ID jurulatih tidak sah.']);
    }
    $semak = $pdo->prepare('SELECT id FROM jurulatih WHERE id = ?');
    $semak->execute([$id]);
    if (!$semak->fetch()) {
        jawab(404, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Rekod jurulatih tidak dijumpai.']);
    }
    $pdo->prepare(
        'UPDATE jurulatih SET nama = :nama, no_kp = :no_kp, tarikh_lahir = :tarikh_lahir, kepakaran = :kepakaran,
                telefon = :telefon, email = :email, nama_waris = :nama_waris, telefon_waris = :telefon_waris,
                emel_waris = :emel_waris
         WHERE id = :id'
    )->execute($medan + ['id' => $id]);
    jawab(200, ['success' => true, 'message' => 'Maklumat jurulatih berjaya dikemaskini!']);
} catch (PDOException $e) {
    error_log('AthleteTrack coach error: ' . $e->getMessage());
    jawab(500, ['success' => false, 'message' => 'Rekod jurulatih gagal diproses.']);
}
