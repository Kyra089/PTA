<?php
require_once __DIR__ . '/_init.php';

perluKaedah('POST');

$data = json_decode(file_get_contents('php://input'), true);

if (!is_array($data)) {
    jawab(400, [
        'success' => false,
        'message' => 'Data log masuk tidak sah.'
    ]);
}

$identiti = trim($data['no_kp'] ?? '');
$password = (string)($data['password'] ?? '');
$peranan = $data['peranan'] ?? 'atlet';

if ($identiti === '' || $password === '') {
    jawab(422, [
        'success' => false,
        'message' => 'Sila masukkan maklumat log masuk.'
    ]);
}

try {
    if ($peranan === 'admin') {
        $jadual = 'admin';
        $stmt = $pdo->prepare(
            'SELECT id, nama, email, kata_laluan FROM admin WHERE email = ?'
        );
        $stmt->execute([$identiti]);
    } elseif ($peranan === 'atlet') {
        $jadual = 'atlet';
        $stmt = $pdo->prepare(
            'SELECT id, nama, no_kp, email, kata_laluan FROM atlet WHERE no_kp = ? OR email = ?'
        );
        // Atlet boleh log masuk dengan No. KP (dengan/tanpa sengkang) atau e-mel.
        $stmt->execute([normalKp($identiti) ?: $identiti, $identiti]);
    } else {
        jawab(422, [
            'success' => false,
            'message' => 'Peranan pengguna tidak sah.'
        ]);
    }

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $simpanan = (string)($user['kata_laluan'] ?? '');
    $berhash = password_get_info($simpanan)['algo'] !== null;

    // Rekod lama mungkin menyimpan kata laluan sebagai teks biasa.
    $sah = $user && ($berhash
        ? password_verify($password, $simpanan)
        : ($simpanan !== '' && hash_equals($simpanan, $password)));

    if ($sah) {
        // Tukar kata laluan teks biasa / hash lama kepada hash semasa.
        if (!$berhash || password_needs_rehash($simpanan, PASSWORD_DEFAULT)) {
            $pdo->prepare("UPDATE $jadual SET kata_laluan = ? WHERE id = ?")
                ->execute([password_hash($password, PASSWORD_DEFAULT), $user['id']]);
        }

        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['peranan'] = $peranan;

        jawab(200, [
            'success' => true,
            'message' => 'Log masuk berjaya.',
            'data' => [
                'id' => (int)$user['id'],
                'nama' => $user['nama'],
                'peranan' => $peranan,
                'invois_daftar' => $peranan === 'atlet' ? invoisDaftarBelumBayar($pdo, (int)$user['id']) : null
            ]
        ]);
    }

    jawab(401, [
        'success' => false,
        'message' => 'Log masuk tidak berjaya. Sila cuba lagi.'
    ]);

} catch (PDOException $e) {
    error_log('AthleteTrack login error: ' . $e->getMessage());

    jawab(500, [
        'success' => false,
        'message' => 'Ralat pangkalan data semasa log masuk.'
    ]);
}
