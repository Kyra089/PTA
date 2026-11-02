<?php
require_once __DIR__ . '/_init.php';

perluKaedah('GET');
perluLogin('admin');

try {
// kategori: belum / baharu / berdaftar (lihat SQL_KATEGORI_ATLET).
$sql = "SELECT a.id, a.nama, a.no_kp, a.email, a.tarikh_lahir, a.pakej_id, " . SQL_NAMA_PAKEJ . " AS pakej, a.sesi,
               a.nama_waris, a.no_telefon_waris, a.emel_waris, a.sekolah,
               " . SQL_KATEGORI_ATLET . " AS kategori
        FROM atlet a " . SQL_PAKEJ_ATLET . "
        ORDER BY a.id DESC";

    $stmt = $pdo->query($sql);
    $atlet = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($atlet as &$a) {
        $a['pakej'] = normalPakej($a['pakej']);
    }
    unset($a);

    echo json_encode([
        'success' => true,
        'data' => $atlet
    ], JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    error_log('AthleteTrack athlete list error: ' . $e->getMessage());
    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Data atlet gagal dipaparkan.'
    ], JSON_UNESCAPED_UNICODE);
}
