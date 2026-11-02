<?php
// Admin menambah, mengemaskini atau mengosongkan maklumat profil sendiri dan menukar kata laluan.
// Mesej mengikut carta alir profil admin (Rajah 25).
require_once __DIR__ . '/_init.php';

perluKaedah('POST');
$adminId = perluLogin('admin');
$data = dataJson();

const GAGAL_MAKLUMAT = 'Gagal kemaskini maklumat. ';
const GAGAL_PASS = 'Gagal kemaskini kata laluan. ';

$nama = trim($data['nama'] ?? '');
$email = trim($data['email'] ?? '');
$noKpInput = trim($data['no_kp'] ?? '');
$tarikhLahir = trim($data['tarikh_lahir'] ?? '');
$telefon = trim($data['telefon'] ?? '');
$passLama = (string)($data['pass_lama'] ?? '');
$passBaru = (string)($data['pass_baru'] ?? '');
$passSahkan = (string)($data['pass_sahkan'] ?? '');
$tukarPass = $passLama !== '' || $passBaru !== '' || $passSahkan !== '';

// Nama dan e-mel wajib (e-mel digunakan untuk log masuk). Medan lain boleh dikosongkan.
if ($nama === '' || $email === '') {
    jawab(422, ['success' => false, 'message' => GAGAL_MAKLUMAT . 'Sila lengkapkan nama dan e-mel.']);
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jawab(422, ['success' => false, 'message' => GAGAL_MAKLUMAT . 'Alamat e-mel tidak sah.']);
}
$noKp = $noKpInput === '' ? '' : normalKp($noKpInput);
if ($noKpInput !== '' && $noKp === '') {
    jawab(422, ['success' => false, 'message' => GAGAL_MAKLUMAT . 'No. kad pengenalan mesti 12 digit (contoh: 820609-01-5371).']);
}
if ($tarikhLahir !== '' && (!tarikhSah($tarikhLahir) || $tarikhLahir >= date('Y-m-d'))) {
    jawab(422, ['success' => false, 'message' => GAGAL_MAKLUMAT . 'Tarikh lahir tidak sah.']);
}
if ($telefon !== '' && !telefonSah($telefon)) {
    jawab(422, ['success' => false, 'message' => GAGAL_MAKLUMAT . 'No. telefon tidak sah (contoh: 019-8877665).']);
}
if ($tukarPass) {
    if ($passLama === '' || $passBaru === '' || $passSahkan === '') {
        jawab(422, ['success' => false, 'message' => GAGAL_PASS . 'Sila isi ketiga-tiga ruangan kata laluan.']);
    }
    if (strlen($passBaru) < 8) {
        jawab(422, ['success' => false, 'message' => GAGAL_PASS . 'Kata laluan baharu mesti sekurang-kurangnya 8 aksara.']);
    }
    if ($passBaru !== $passSahkan) {
        jawab(422, ['success' => false, 'message' => GAGAL_PASS . 'Pengesahan kata laluan baharu tidak sama.']);
    }
}

try {
    $stmt = $pdo->prepare('SELECT kata_laluan FROM admin WHERE id = ?');
    $stmt->execute([$adminId]);
    $simpanan = $stmt->fetchColumn();

    if ($simpanan === false) {
        jawab(404, ['success' => false, 'message' => GAGAL_MAKLUMAT . 'Maklumat admin tidak dijumpai.']);
    }
    if ($tukarPass && !password_verify($passLama, (string)$simpanan)) {
        jawab(422, ['success' => false, 'message' => GAGAL_PASS . 'Kata laluan semasa tidak tepat.']);
    }

    $pdo->prepare('UPDATE admin SET nama = ?, no_kp = ?, tarikh_lahir = ?, telefon = ?, email = ? WHERE id = ?')
        ->execute([$nama, $noKp ?: null, $tarikhLahir ?: null, $telefon ?: null, $email, $adminId]);

    if ($tukarPass) {
        $pdo->prepare('UPDATE admin SET kata_laluan = ? WHERE id = ?')
            ->execute([password_hash($passBaru, PASSWORD_DEFAULT), $adminId]);
    }

    $_SESSION['nama'] = $nama;

    jawab(200, [
        'success' => true,
        'message' => $tukarPass ? 'Profil dan kata laluan berjaya dikemaskini.' : 'Profil berjaya dikemaskini.'
    ]);
} catch (PDOException $e) {
    error_log('AthleteTrack admin profile update error: ' . $e->getMessage());
    if ($e->getCode() === '23000') {
        jawab(409, ['success' => false, 'message' => GAGAL_MAKLUMAT . 'E-mel tersebut telah digunakan oleh akaun admin lain.']);
    }
    jawab(500, ['success' => false, 'message' => GAGAL_MAKLUMAT . 'Sila cuba lagi.']);
}
