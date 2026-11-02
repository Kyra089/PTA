<?php
require_once __DIR__ . '/_init.php';

perluKaedah('POST');
perluLogin('admin');

$data = json_decode(file_get_contents('php://input'), true);

if (!is_array($data)) {
    jawab(400, [
        'success' => false,
        'message' => 'Data tidak sah.'
    ]);
}

$id = filter_var($data['id'] ?? null, FILTER_VALIDATE_INT);
$nama = trim($data['nama'] ?? '');
$noKp = normalKp((string)($data['no_kp'] ?? ''));
$tarikhLahir = trim($data['tarikh_lahir'] ?? '');
$pakej = normalPakej($data['pakej'] ?? '');
const GAGAL = 'Gagal kemaskini maklumat. ';
$sesi = trim($data['sesi'] ?? '');
$telefon = trim($data['no_telefon_waris'] ?? '');
$email = trim($data['email'] ?? '');

if (!$id || $id < 1) {
    jawab(422, ['success' => false, 'message' => 'ID atlet tidak sah.']);
}

if (
    $nama === '' || $noKp === '' || $tarikhLahir === '' ||
    $pakej === '' || $sesi === '' || $telefon === '' || $email === ''
) {
    jawab(422, ['success' => false, 'message' => GAGAL . 'Sila lengkapkan semua maklumat (No. KP mesti 12 digit).']);
}

if (!telefonSah($telefon)) {
    jawab(422, ['success' => false, 'message' => GAGAL . 'No. telefon tidak sah (contoh: 012-3456789).']);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jawab(422, ['success' => false, 'message' => GAGAL . 'Alamat e-mel tidak sah.']);
}

if (!tarikhSah($tarikhLahir) || $tarikhLahir > date('Y-m-d')) {
    jawab(422, ['success' => false, 'message' => GAGAL . 'Tarikh lahir tidak sah.']);
}

// Sesi mesti sepadan dengan pakej yang dipilih (bagi pakej standard).
if (isset(PAKEJ_SESI[$pakej]) && !in_array($sesi, PAKEJ_SESI[$pakej], true)) {
    jawab(422, ['success' => false, 'message' => GAGAL . 'Pilihan sesi tidak sah untuk pakej ini.']);
}

try {
    $infoPakej = cariPakej($pdo, $pakej);
    if (!$infoPakej) {
        jawab(422, ['success' => false, 'message' => GAGAL . 'Pilihan pakej tidak sah.']);
    }

    $stmt = $pdo->prepare(
        'UPDATE atlet
         SET nama = ?, no_kp = ?, tarikh_lahir = ?, pakej_id = ?, pakej = ?,
             sesi = ?, no_telefon_waris = ?, email = ?
         WHERE id = ?'
    );

    $stmt->execute([
        $nama,
        $noKp,
        $tarikhLahir,
        $infoPakej['id'],
        $infoPakej['nama_pakej'],
        $sesi,
        $telefon,
        $email,
        $id
    ]);

    if ($stmt->rowCount() === 0) {
        $semak = $pdo->prepare('SELECT id FROM atlet WHERE id = ?');
        $semak->execute([$id]);

        if (!$semak->fetch()) {
            jawab(404, ['success' => false, 'message' => 'Rekod atlet tidak dijumpai.']);
        }
    }

    jawab(200, [
        'success' => true,
        'message' => 'Maklumat atlet berjaya dikemaskini.'
    ]);

} catch (PDOException $e) {
    error_log('AthleteTrack update athlete error: ' . $e->getMessage());

    if ($e->getCode() === '23000') {
        jawab(409, [
            'success' => false,
            'message' => GAGAL . 'No. kad pengenalan atau e-mel telah digunakan oleh atlet lain.'
        ]);
    }

    jawab(500, [
        'success' => false,
        'message' => GAGAL . 'Sila cuba lagi.'
    ]);
}
