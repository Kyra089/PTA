<?php
require_once __DIR__ . '/_init.php';

perluKaedah('GET');
perluLogin('admin');

try {
    pastikanInvoisBulanSemasa($pdo);

    $hariIni = new DateTimeImmutable('today');
    $bulanSemasa = namaBulan($hariIni);

    // Hanya atlet yang telah membayar yuran pendaftaran (Atlet Baharu + Atlet Berdaftar).
    $jumlahAtlet = (int)$pdo->query('SELECT COUNT(*) FROM atlet a WHERE ' . SQL_KATEGORI_ATLET . " <> 'belum'")->fetchColumn();

    $stmt = $pdo->prepare("SELECT COALESCE(SUM(jumlah), 0) AS jumlah, COUNT(DISTINCT atlet_id) AS bil
                           FROM pembayaran WHERE bulan = ? AND status = 'sudah'");
    $stmt->execute([$bulanSemasa]);
    $kutipan = $stmt->fetch();

    $stmt = $pdo->prepare("SELECT SUM(status = 'hadir') AS hadir, COUNT(*) AS jumlah
                           FROM kehadiran WHERE tarikh BETWEEN ? AND ?");
    $stmt->execute([$hariIni->format('Y-m-01'), $hariIni->format('Y-m-t')]);
    $hadir = $stmt->fetch();

    $tertunggak = (int)$pdo->query("SELECT COUNT(DISTINCT atlet_id) FROM pembayaran WHERE status IN ('belum', 'ditolak')")
        ->fetchColumn();

    // Kutipan yuran yang telah disahkan bagi setiap bulan tahun semasa.
    $stmt = $pdo->prepare("SELECT bulan, SUM(jumlah) FROM pembayaran WHERE status = 'sudah' AND bulan LIKE ? GROUP BY bulan");
    $stmt->execute(['% ' . $hariIni->format('Y')]);
    $ikutBulan = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    $carta = [];
    for ($b = 1; $b <= (int)$hariIni->format('n'); $b++) {
        $nama = BULAN_MS[$b - 1] . ' ' . $hariIni->format('Y');
        $carta[] = ['bulan' => $nama, 'jumlah' => (float)($ikutBulan[$nama] ?? 0)];
    }

    $terkini = $pdo->query('SELECT a.nama, ' . SQL_NAMA_PAKEJ . ' AS pakej, a.tarikh_daftar FROM atlet a ' . SQL_PAKEJ_ATLET . ' ORDER BY a.id DESC LIMIT 3')->fetchAll();
    foreach ($terkini as &$t) {
        $t['pakej'] = normalPakej($t['pakej']);
    }
    unset($t);

    jawab(200, [
        'success' => true,
        'data' => [
            'bulan_semasa' => $bulanSemasa,
            'jumlah_atlet' => $jumlahAtlet,
            'kutipan_bulan_ini' => (float)$kutipan['jumlah'],
            'bil_atlet_bayar' => (int)$kutipan['bil'],
            'kehadiran_purata' => (int)$hadir['jumlah'] > 0 ? (int)round($hadir['hadir'] / $hadir['jumlah'] * 100) : null,
            'tertunggak' => $tertunggak,
            'carta' => $carta,
            'terkini' => $terkini
        ]
    ]);
} catch (PDOException $e) {
    error_log('AthleteTrack admin dashboard error: ' . $e->getMessage());
    jawab(500, ['success' => false, 'message' => 'Data dashboard gagal dimuatkan.']);
}
