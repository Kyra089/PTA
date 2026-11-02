<?php
// GET ?tarikh=YYYY-MM-DD        : semua atlet + status kehadiran pada tarikh itu + peratus bulan tersebut.
// GET ?dari=YYYY-MM-DD&hingga=.. : semua rekod kehadiran dalam julat (untuk laporan).
require_once __DIR__ . '/_init.php';

perluKaedah('GET');
perluLogin('admin');

try {
    // Hanya atlet yang telah membayar yuran pendaftaran (bukan "Belum Berdaftar").
    $atlet = $pdo->query('SELECT a.id, a.nama, a.sesi, ' . SQL_NAMA_PAKEJ . ' AS pakej FROM atlet a ' . SQL_PAKEJ_ATLET
        . ' WHERE ' . SQL_KATEGORI_ATLET . " <> 'belum' ORDER BY a.nama")->fetchAll();
    foreach ($atlet as &$a) {
        $a['id'] = (int)$a['id'];
        $a['pakej'] = normalPakej($a['pakej']);
    }
    unset($a);

    if (isset($_GET['dari'], $_GET['hingga'])) {
        $dari = (string)$_GET['dari'];
        $hingga = (string)$_GET['hingga'];
        if (!tarikhSah($dari) || !tarikhSah($hingga)) {
            jawab(422, ['success' => false, 'message' => 'Julat tarikh tidak sah.']);
        }
        $stmt = $pdo->prepare('SELECT atlet_id, tarikh, status FROM kehadiran WHERE tarikh BETWEEN ? AND ? ORDER BY tarikh');
        $stmt->execute([$dari, $hingga]);
        $rekod = $stmt->fetchAll();
        foreach ($rekod as &$r) {
            $r['atlet_id'] = (int)$r['atlet_id'];
        }
        unset($r);
        jawab(200, ['success' => true, 'data' => ['atlet' => $atlet, 'rekod' => $rekod]]);
    }

    $tarikh = (string)($_GET['tarikh'] ?? date('Y-m-d'));
    if (!tarikhSah($tarikh)) {
        jawab(422, ['success' => false, 'message' => 'Tarikh tidak sah.']);
    }
    $awalBulan = substr($tarikh, 0, 8) . '01';
    $akhirBulan = date('Y-m-t', strtotime($awalBulan));

    $stmt = $pdo->prepare('SELECT atlet_id, status FROM kehadiran WHERE tarikh = ?');
    $stmt->execute([$tarikh]);
    $statusHari = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    $stmt = $pdo->prepare(
        "SELECT atlet_id, SUM(status = 'hadir') AS hadir, COUNT(*) AS jumlah
         FROM kehadiran WHERE tarikh BETWEEN ? AND ? GROUP BY atlet_id"
    );
    $stmt->execute([$awalBulan, $akhirBulan]);
    $statBulan = [];
    foreach ($stmt->fetchAll() as $s) {
        $statBulan[(int)$s['atlet_id']] = $s;
    }

    foreach ($atlet as &$a) {
        $a['status'] = $statusHari[$a['id']] ?? '';
        $s = $statBulan[$a['id']] ?? null;
        $a['peratus'] = $s && (int)$s['jumlah'] > 0 ? (int)round($s['hadir'] / $s['jumlah'] * 100) : null;
    }
    unset($a);

    jawab(200, ['success' => true, 'data' => ['tarikh' => $tarikh, 'atlet' => $atlet]]);
} catch (PDOException $e) {
    error_log('AthleteTrack attendance list error: ' . $e->getMessage());
    jawab(500, ['success' => false, 'message' => 'Rekod kehadiran gagal dimuatkan.']);
}
