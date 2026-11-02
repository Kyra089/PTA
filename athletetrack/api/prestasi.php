<?php
// GET  : atlet + rekod prestasi bulan ini dan bulan lepas.
// POST : {"aksi":"tambah"|"kemaskini"|"padam", ...}
// Satu rekod = satu bacaan bagi (atlet, acara, bulan). Lajur tarikh menyimpan hari pertama bulan.
require_once __DIR__ . '/_init.php';

perluLogin('admin');

const ACARA_PRESTASI = ['Larian 100m (saat)', 'Lompat Jauh (m)', 'Lompat Tinggi (m)', 'Lontar Peluru (m)'];

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $ini = new DateTimeImmutable('first day of this month');
        $lepas = $ini->modify('-1 month');

        $atlet = $pdo->query('SELECT a.id, a.nama, ' . SQL_NAMA_PAKEJ . ' AS pakej FROM atlet a ' . SQL_PAKEJ_ATLET . ' ORDER BY a.nama')->fetchAll();
        foreach ($atlet as &$a) {
            $a['id'] = (int)$a['id'];
            $a['pakej'] = normalPakej($a['pakej']);
        }
        unset($a);

        $stmt = $pdo->prepare(
            "SELECT id, atlet_id, acara, DATE_FORMAT(tarikh, '%Y-%m') AS bulan, markah
             FROM prestasi WHERE tarikh IN (?, ?) AND acara IS NOT NULL"
        );
        $stmt->execute([$lepas->format('Y-m-d'), $ini->format('Y-m-d')]);
        $rekod = $stmt->fetchAll();
        foreach ($rekod as &$r) {
            $r['id'] = (int)$r['id'];
            $r['atlet_id'] = (int)$r['atlet_id'];
            $r['markah'] = (float)$r['markah'];
        }
        unset($r);

        jawab(200, [
            'success' => true,
            'data' => [
                'bulan_ini' => ['kod' => $ini->format('Y-m'), 'nama' => namaBulan($ini)],
                'bulan_lepas' => ['kod' => $lepas->format('Y-m'), 'nama' => namaBulan($lepas)],
                'atlet' => $atlet,
                'rekod' => $rekod
            ]
        ]);
    }

    perluKaedah('POST');
    $data = dataJson();
    $aksi = $data['aksi'] ?? '';
    $id = filter_var($data['id'] ?? null, FILTER_VALIDATE_INT);

    if ($aksi === 'padam') {
        if (!$id) {
            jawab(422, ['success' => false, 'message' => 'Gagal kemaskini maklumat. ID rekod prestasi tidak sah.']);
        }
        $stmt = $pdo->prepare('DELETE FROM prestasi WHERE id = ?');
        $stmt->execute([$id]);
        if ($stmt->rowCount() === 0) {
            jawab(404, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Rekod prestasi tidak dijumpai.']);
        }
        jawab(200, ['success' => true, 'message' => 'Rekod prestasi berjaya dipadam.']);
    }

    if ($aksi !== 'tambah' && $aksi !== 'kemaskini') {
        jawab(422, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Aksi tidak sah.']);
    }

    $atletId = filter_var($data['atlet_id'] ?? null, FILTER_VALIDATE_INT);
    $acara = (string)($data['acara'] ?? '');
    $bulan = (string)($data['bulan'] ?? '');
    $bacaan = filter_var($data['bacaan'] ?? null, FILTER_VALIDATE_FLOAT);

    if (!$atletId || !in_array($acara, ACARA_PRESTASI, true) || !preg_match('/^\d{4}-\d{2}$/', $bulan) || !tarikhSah($bulan . '-01')) {
        jawab(422, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Sila lengkapkan atlet, acara dan bulan.']);
    }
    if ($bacaan === false || $bacaan <= 0 || $bacaan >= 1000) {
        jawab(422, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Bacaan mestilah nombor positif (contoh: 13.5).']);
    }
    $tarikh = $bulan . '-01';

    $semakAtlet = $pdo->prepare('SELECT id FROM atlet WHERE id = ?');
    $semakAtlet->execute([$atletId]);
    if (!$semakAtlet->fetch()) {
        jawab(404, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Atlet tidak dijumpai.']);
    }

    $sedia = $pdo->prepare('SELECT id FROM prestasi WHERE atlet_id = ? AND acara = ? AND tarikh = ?');
    $sedia->execute([$atletId, $acara, $tarikh]);
    $idSedia = $sedia->fetchColumn();

    if ($aksi === 'tambah') {
        // Rekod untuk bulan yang sama dikemaskini, bukan diduplikasi.
        if ($idSedia) {
            $pdo->prepare('UPDATE prestasi SET markah = ? WHERE id = ?')->execute([$bacaan, $idSedia]);
        } else {
            $pdo->prepare('INSERT INTO prestasi (atlet_id, tarikh, acara, markah) VALUES (?, ?, ?, ?)')
                ->execute([$atletId, $tarikh, $acara, $bacaan]);
        }
        jawab(200, ['success' => true, 'message' => 'Rekod prestasi berjaya disimpan!']);
    }

    if (!$id) {
        jawab(422, ['success' => false, 'message' => 'Gagal kemaskini maklumat. ID rekod prestasi tidak sah.']);
    }
    if ($idSedia && (int)$idSedia !== $id) {
        jawab(409, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Rekod untuk atlet, acara dan bulan ini sudah wujud.']);
    }
    $stmt = $pdo->prepare('UPDATE prestasi SET atlet_id = ?, acara = ?, tarikh = ?, markah = ? WHERE id = ?');
    $stmt->execute([$atletId, $acara, $tarikh, $bacaan, $id]);
    if ($stmt->rowCount() === 0) {
        $semak = $pdo->prepare('SELECT id FROM prestasi WHERE id = ?');
        $semak->execute([$id]);
        if (!$semak->fetch()) {
            jawab(404, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Rekod prestasi tidak dijumpai.']);
        }
    }
    jawab(200, ['success' => true, 'message' => 'Rekod prestasi berjaya dikemaskini!']);
} catch (PDOException $e) {
    error_log('AthleteTrack performance error: ' . $e->getMessage());
    jawab(500, ['success' => false, 'message' => 'Rekod prestasi gagal diproses.']);
}
