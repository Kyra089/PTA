<?php
// GET  : senarai semua invois untuk halaman Pengurusan Pembayaran.
// POST : simpan keputusan admin, {"perubahan":[{"id":1,"status":"sah"|"tolak"|""}]}
// POST : hantar peringatan bayaran, {"aksi":"peringatan","id":[1,2,...]}
require_once __DIR__ . '/_init.php';
require_once __DIR__ . '/emel.php';

perluLogin('admin');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        pastikanInvoisBulanSemasa($pdo);

        $rekod = $pdo->query(
            'SELECT p.id, p.atlet_id, a.nama, ' . SQL_NAMA_PAKEJ . ' AS pakej, p.bulan, p.jumlah, p.tarikh_akhir, p.status,
                    p.tarikh_bayar, p.bukti_fail IS NOT NULL AS ada_bukti,
                    p.id = (SELECT MIN(p2.id) FROM pembayaran p2 WHERE p2.atlet_id = p.atlet_id) AS pendaftaran_baharu
             FROM pembayaran p
             JOIN atlet a ON a.id = p.atlet_id ' . SQL_PAKEJ_ATLET . '
             ORDER BY p.tarikh_akhir DESC, a.nama ASC'
        )->fetchAll();

        foreach ($rekod as &$r) {
            $r['id'] = (int)$r['id'];
            $r['pakej'] = normalPakej($r['pakej']);
            $r['jumlah'] = (float)$r['jumlah'];
            $r['ada_bukti'] = (bool)$r['ada_bukti'];
            $r['pendaftaran_baharu'] = (bool)$r['pendaftaran_baharu'];
        }
        unset($r);

        jawab(200, ['success' => true, 'data' => $rekod, 'bulan_semasa' => namaBulan(new DateTimeImmutable('today'))]);
    }

    perluKaedah('POST');
    $data = dataJson();

    // Peringatan bayaran kepada atlet yang invoisnya belum dibayar / bukti ditolak.
    if (($data['aksi'] ?? '') === 'peringatan') {
        $ids = array_values(array_filter(array_map('intval', (array)($data['id'] ?? []))));
        if (!$ids) {
            jawab(422, ['success' => false, 'message' => 'Tiada atlet yang belum membayar dalam senarai yang dipaparkan.']);
        }
        if (!emelDikonfigurasi()) {
            jawab(503, ['success' => false, 'message' => 'E-mel belum dikonfigurasi. Isi tetapan Gmail dalam fail config-emel.php dahulu. Peringatan tetap dipaparkan pada dashboard atlet.']);
        }
        $tanda = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $pdo->prepare("SELECT id, atlet_id, bulan, jumlah, tarikh_akhir, status FROM pembayaran
                               WHERE id IN ($tanda) AND status IN ('belum', 'ditolak')");
        $stmt->execute($ids);
        $berjaya = 0;
        $gagal = 0;
        foreach ($stmt->fetchAll() as $i) {
            $isi = ($i['status'] === 'ditolak'
                    ? "Bukti pembayaran anda bagi invois {$i['bulan']} telah ditolak. Sila muat naik bukti pembayaran yang baharu."
                    : "Ini adalah peringatan bahawa yuran bulan {$i['bulan']} belum dibayar.")
                . "\n\nJumlah: RM" . number_format((float)$i['jumlah'], 2)
                . "\nTarikh akhir bayaran: " . formatTarikhMs($i['tarikh_akhir']);
            emelAtlet($pdo, (int)$i['atlet_id'], "Peringatan Bayaran Yuran {$i['bulan']}", $isi) ? $berjaya++ : $gagal++;
        }
        if ($berjaya === 0 && $gagal > 0) {
            jawab(502, ['success' => false, 'message' => 'E-mel peringatan gagal dihantar. Semak tetapan config-emel.php dan sambungan internet.']);
        }
        jawab(200, ['success' => true, 'message' => "Peringatan dihantar melalui e-mel kepada $berjaya atlet" . ($gagal ? " ($gagal gagal)." : '.')]);
    }

    $perubahan = $data['perubahan'] ?? null;
    if (!is_array($perubahan) || !$perubahan) {
        jawab(422, ['success' => false, 'message' => 'Tiada perubahan untuk disimpan.']);
    }

    $statusBaru = ['sah' => 'sudah', 'tolak' => 'ditolak', '' => 'menunggu_sahkan'];
    $kemaskini = $pdo->prepare('UPDATE pembayaran SET status = ? WHERE id = ? AND bukti_fail IS NOT NULL');

    $pdo->beginTransaction();
    $berubah = [];
    foreach ($perubahan as $p) {
        $id = filter_var($p['id'] ?? null, FILTER_VALIDATE_INT);
        $status = (string)($p['status'] ?? '');
        if (!$id || !array_key_exists($status, $statusBaru)) {
            $pdo->rollBack();
            jawab(422, ['success' => false, 'message' => 'Data perubahan pembayaran tidak sah.']);
        }
        $kemaskini->execute([$statusBaru[$status], $id]);
        if ($kemaskini->rowCount() > 0) {
            $berubah[$id] = $status;
        }
    }
    $pdo->commit();

    // Maklumkan atlet melalui e-mel (jika e-mel telah dikonfigurasi).
    if ($berubah && emelDikonfigurasi()) {
        $stmt = $pdo->prepare('SELECT atlet_id, bulan, jumlah FROM pembayaran WHERE id = ?');
        foreach ($berubah as $id => $status) {
            if ($status === '') {
                continue;
            }
            $stmt->execute([$id]);
            $i = $stmt->fetch();
            $status === 'sah'
                ? emelAtlet($pdo, (int)$i['atlet_id'], "Pembayaran {$i['bulan']} Disahkan",
                    "Pembayaran anda bagi {$i['bulan']} (RM" . number_format((float)$i['jumlah'], 2) . ') telah disahkan oleh admin. Terima kasih.')
                : emelAtlet($pdo, (int)$i['atlet_id'], "Bukti Pembayaran {$i['bulan']} Ditolak",
                    "Bukti pembayaran anda bagi {$i['bulan']} telah ditolak oleh admin. Sila log masuk dan muat naik bukti pembayaran yang baharu.");
        }
    }

    jawab(200, ['success' => true, 'message' => 'Perubahan pembayaran berjaya disimpan!', 'bilangan' => count($berubah)]);
} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log('AthleteTrack admin payments error: ' . $e->getMessage());
    jawab(500, ['success' => false, 'message' => 'Rekod pembayaran gagal diproses.']);
}
