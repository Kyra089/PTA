<?php
// Atlet menambah, mengemaskini atau mengosongkan maklumat profil sendiri dan menukar kata laluan.
// Mesej mengikut carta alir profil atlet (Rajah 33).
require_once __DIR__ . '/_init.php';

perluKaedah('POST');
$atletId = perluLogin('atlet');

const GAGAL_MAKLUMAT = 'Gagal kemaskini maklumat. ';
const GAGAL_PASS = 'Gagal kemaskini kata laluan. ';

$data = json_decode(file_get_contents('php://input'), true);

if (!is_array($data)) {
    jawab(400, [
        'success' => false,
        'message' => GAGAL_MAKLUMAT . 'Data profil tidak sah.'
    ]);
}

$nama = trim($data['nama'] ?? '');
$telefon = trim($data['no_telefon_waris'] ?? '');
$email = trim($data['email'] ?? '');
$namaWaris = trim($data['nama_waris'] ?? '');
$sekolah = trim($data['sekolah'] ?? '');
$passLama = (string)($data['pass_lama'] ?? '');
$passBaru = (string)($data['pass_baru'] ?? '');
$passSahkan = (string)($data['pass_sahkan'] ?? '');
$tukarPass = $passLama !== '' || $passBaru !== '' || $passSahkan !== '';

if ($nama === '' || $telefon === '' || $email === '' || $namaWaris === '') {
    jawab(422, [
        'success' => false,
        'message' => GAGAL_MAKLUMAT . 'Sila lengkapkan nama, nama ibu/bapa, telefon waris dan e-mel.'
    ]);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jawab(422, [
        'success' => false,
        'message' => GAGAL_MAKLUMAT . 'Alamat e-mel tidak sah.'
    ]);
}

if (!telefonSah($telefon)) {
    jawab(422, ['success' => false, 'message' => GAGAL_MAKLUMAT . 'No. telefon tidak sah (contoh: 012-3456789).']);
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
    $stmt = $pdo->prepare(
        'SELECT id, kata_laluan FROM atlet WHERE id = ?'
    );
    $stmt->execute([$atletId]);
    $atlet = $stmt->fetch();

    if (!$atlet) {
        jawab(404, [
            'success' => false,
            'message' => GAGAL_MAKLUMAT . 'Rekod atlet tidak dijumpai.'
        ]);
    }

    if ($tukarPass && !password_verify($passLama, (string)$atlet['kata_laluan'])) {
        jawab(422, ['success' => false, 'message' => GAGAL_PASS . 'Kata laluan semasa tidak tepat.']);
    }

    // Nama sekolah adalah pilihan: biarkan kosong untuk memadam maklumat tersebut.
    $stmt = $pdo->prepare(
        'UPDATE atlet
         SET nama = ?, nama_waris = ?, no_telefon_waris = ?, email = ?, sekolah = ?
         WHERE id = ?'
    );

    $stmt->execute([
        $nama,
        $namaWaris,
        $telefon,
        $email,
        $sekolah === '' ? null : $sekolah,
        $atletId
    ]);

    if ($tukarPass) {
        $pdo->prepare('UPDATE atlet SET kata_laluan = ? WHERE id = ?')
            ->execute([password_hash($passBaru, PASSWORD_DEFAULT), $atletId]);
    }

    $_SESSION['nama'] = $nama;

    jawab(200, [
        'success' => true,
        'message' => $tukarPass ? 'Profil dan kata laluan berjaya dikemaskini.' : 'Profil berjaya dikemaskini.'
    ]);

} catch (PDOException $e) {
    error_log('AthleteTrack profile update error: ' . $e->getMessage());

    if ($e->getCode() === '23000') {
        jawab(409, [
            'success' => false,
            'message' => GAGAL_MAKLUMAT . 'E-mel tersebut telah digunakan oleh akaun lain.'
        ]);
    }

    jawab(500, [
        'success' => false,
        'message' => GAGAL_MAKLUMAT . 'Sila cuba lagi.'
    ]);
}
