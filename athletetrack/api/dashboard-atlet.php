<?php
require_once __DIR__ . '/_init.php';

perluKaedah('GET');
$atletId = perluLogin('atlet');

try {
    pastikanInvoisBulanSemasa($pdo, $atletId);

    $stmt = $pdo->prepare('SELECT a.nama, ' . SQL_NAMA_PAKEJ . ' AS pakej, a.sesi, ps.harga, ps.hari
                           FROM atlet a ' . SQL_PAKEJ_ATLET . ' WHERE a.id = ?');
    $stmt->execute([$atletId]);
    $atlet = $stmt->fetch();
    if (!$atlet) {
        jawab(404, ['success' => false, 'message' => 'Maklumat atlet tidak dijumpai.']);
    }
    $atlet['pakej'] = normalPakej($atlet['pakej']);

    $pakej = ['harga' => $atlet['harga'], 'hari' => $atlet['hari']];
    unset($atlet['harga'], $atlet['hari']);

    $hariIni = new DateTimeImmutable('today');
    $stmt = $pdo->prepare("SELECT COALESCE(SUM(status = 'hadir'), 0) AS hadir, COUNT(*) AS jumlah
                           FROM kehadiran WHERE atlet_id = ? AND tarikh BETWEEN ? AND ?");
    $stmt->execute([$atletId, $hariIni->format('Y-m-01'), $hariIni->format('Y-m-t')]);
    $hadir = $stmt->fetch();

    $stmt = $pdo->prepare('SELECT id, bulan, jumlah, tarikh_akhir, status FROM pembayaran
                           WHERE atlet_id = ? ORDER BY tarikh_akhir DESC, id DESC');
    $stmt->execute([$atletId]);
    $invois = $stmt->fetchAll();
    $tertunggak = null;
    foreach ($invois as $i) {
        if (in_array($i['status'], ['belum', 'ditolak'], true)) {
            $tertunggak = $i; // yang paling lama (senarai disusun terbaru dahulu)
        }
    }

    // Bacaan terkini bagi setiap acara berbanding bacaan sebelumnya.
    $stmt = $pdo->prepare('SELECT acara, tarikh, markah FROM prestasi
                           WHERE atlet_id = ? AND acara IS NOT NULL ORDER BY acara, tarikh DESC');
    $stmt->execute([$atletId]);
    $prestasi = [];
    foreach ($stmt->fetchAll() as $p) {
        if (!isset($prestasi[$p['acara']])) {
            $prestasi[$p['acara']] = ['acara' => $p['acara'], 'terkini' => (float)$p['markah'], 'sebelum' => null];
        } elseif ($prestasi[$p['acara']]['sebelum'] === null) {
            $prestasi[$p['acara']]['sebelum'] = (float)$p['markah'];
        }
    }

    jawab(200, [
        'success' => true,
        'data' => [
            'bulan_semasa' => namaBulan($hariIni),
            'atlet' => $atlet,
            'harga' => $pakej['harga'] === null ? null : (float)$pakej['harga'],
            'hari' => $pakej['hari'],
            'hadir' => (int)$hadir['hadir'],
            'jumlah_sesi' => (int)$hadir['jumlah'],
            'invois_terkini' => $invois[0] ?? null,
            'invois_tertunggak' => $tertunggak,
            'prestasi' => array_values($prestasi)
        ]
    ]);
} catch (PDOException $e) {
    error_log('AthleteTrack athlete dashboard error: ' . $e->getMessage());
    jawab(500, ['success' => false, 'message' => 'Data dashboard gagal dimuatkan.']);
}
