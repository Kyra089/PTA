<?php
require_once __DIR__ . '/_init.php';

perluKaedah('GET');
$atletId = perluLogin('atlet');

try {
    $stmt = $pdo->prepare(
        'SELECT a.nama, a.no_kp, a.email, a.tarikh_lahir, ' . SQL_NAMA_PAKEJ . ' AS pakej, a.sesi,
                a.nama_waris, a.no_telefon_waris, a.emel_waris, a.sekolah,
                (SELECT p.status FROM pembayaran p WHERE p.atlet_id = a.id ORDER BY p.id LIMIT 1) AS status_daftar,
                ' . SQL_KATEGORI_ATLET . ' AS kategori
         FROM atlet a ' . SQL_PAKEJ_ATLET . '
         WHERE a.id = ?'
    );

    $stmt->execute([$atletId]);
    $atlet = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$atlet) {
        jawab(404, [
            'success' => false,
            'message' => 'Maklumat atlet tidak dijumpai.'
        ]);
    }

    $atlet['pakej'] = normalPakej($atlet['pakej']);

    jawab(200, [
        'success' => true,
        'data' => $atlet
    ]);

} catch (PDOException $e) {
    error_log('AthleteTrack profile error: ' . $e->getMessage());

    jawab(500, [
        'success' => false,
        'message' => 'Gagal mendapatkan maklumat profil.'
    ]);
}
