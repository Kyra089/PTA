<?php
// POST {"semak":"akaun"|"atlet"|"waris", ...} : semak satu langkah pendaftaran sahaja (tiada data disimpan).
// POST tanpa "semak"                          : semak semua langkah, simpan atlet dan invois pertama.
require_once __DIR__ . '/_init.php';

perluKaedah('POST');

$data = json_decode(file_get_contents('php://input'), true);
if (!is_array($data)) {
    jawab(400, ['success' => false, 'message' => 'Data pendaftaran tidak sah.']);
}
$semak = (string)($data['semak'] ?? '');
$email = trim($data['email'] ?? '');
$password = (string)($data['kata_laluan'] ?? '');
$passwordSahkan = (string)($data['kata_laluan_sahkan'] ?? $password);
$nama = trim($data['nama'] ?? '');
$noKp = normalKp((string)($data['no_kp'] ?? ''));
$tarikhLahir = trim($data['tarikh_lahir'] ?? '');
$sesi = trim($data['sesi'] ?? '');
$namaWaris = trim($data['nama_waris'] ?? '');
$telWaris = trim($data['no_telefon_waris'] ?? '');
$emelWaris = trim($data['emel_waris'] ?? '');
$sekolah = trim($data['sekolah'] ?? '');

// Mesej mengikut carta alir pendaftaran atlet (Rajah 32).
const GAGAL_AKAUN = 'Pendaftaran tidak berjaya. Sila cuba lagi. ';
const GAGAL_FORMAT = 'Pastikan maklumat lengkap dan mengikut format. ';
function gagal(string $mesej): void { jawab(422, ['success' => false, 'message' => $mesej]); }

try {
    // Langkah 1: maklumat akaun.
    if ($semak === '' || $semak === 'akaun') {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) gagal(GAGAL_AKAUN . 'Alamat e-mel tidak sah.');
        if (strlen($password) < 8) gagal(GAGAL_AKAUN . 'Kata laluan mesti sekurang-kurangnya 8 aksara.');
        if ($password !== $passwordSahkan) gagal(GAGAL_AKAUN . 'Pengesahan kata laluan tidak sama.');
        $stmt = $pdo->prepare('SELECT 1 FROM atlet WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) gagal(GAGAL_AKAUN . 'E-mel ini sudah didaftarkan.');
        if ($semak === 'akaun') jawab(200, ['success' => true]);
    }

    // Langkah 2: maklumat atlet.
    $pakej = cariPakej($pdo, (string)($data['pakej'] ?? ''));
    if ($semak === '' || $semak === 'atlet') {
        if (!$pakej) gagal(GAGAL_FORMAT . 'Sila pilih pakej.');
        if ($nama === '') gagal(GAGAL_FORMAT . 'Sila isi nama penuh.');
        if ($noKp === '') gagal(GAGAL_FORMAT . 'No. kad pengenalan mesti 12 digit (contoh: 010101-01-0101).');
        if (!tarikhSah($tarikhLahir) || $tarikhLahir >= date('Y-m-d')) gagal(GAGAL_FORMAT . 'Tarikh lahir tidak sah.');
        $stmt = $pdo->prepare('SELECT 1 FROM atlet WHERE no_kp = ?');
        $stmt->execute([$noKp]);
        if ($stmt->fetch()) gagal(GAGAL_FORMAT . 'No. kad pengenalan ini sudah didaftarkan.');
        if ($semak === 'atlet') jawab(200, ['success' => true]);
    }

    // Langkah 3: maklumat waris dan sesi.
    if ($namaWaris === '') gagal(GAGAL_FORMAT . 'Sila isi nama ibu/bapa/penjaga.');
    if (!telefonSah($telWaris)) gagal(GAGAL_FORMAT . 'No. telefon tidak sah (contoh: 012-3456789).');
    if (!filter_var($emelWaris, FILTER_VALIDATE_EMAIL)) gagal(GAGAL_FORMAT . 'Alamat e-mel ibu/bapa/penjaga tidak sah.');
    if ($sesi === '' || stripos($sesi, 'Pilih sesi') !== false) gagal(GAGAL_FORMAT . 'Sila pilih sesi latihan.');
    if ($pakej && isset(PAKEJ_SESI[$pakej['nama_pakej']]) && !in_array($sesi, PAKEJ_SESI[$pakej['nama_pakej']], true)) {
        gagal(GAGAL_FORMAT . 'Pilihan sesi tidak sah untuk pakej ini.');
    }
    if ($semak === 'waris') jawab(200, ['success' => true]);
    if ($semak !== '') gagal('Langkah pendaftaran tidak sah.');

    $harga = (float)$pakej['harga'];

    $pdo->beginTransaction();
    $stmt = $pdo->prepare('INSERT INTO atlet (nama, no_kp, email, kata_laluan, tarikh_lahir, pakej_id, pakej, sesi, nama_waris, no_telefon_waris, emel_waris, sekolah, tarikh_daftar)
                           VALUES (:nama, :no_kp, :email, :kata_laluan, :tarikh_lahir, :pakej_id, :pakej, :sesi, :nama_waris, :tel_waris, :emel_waris, :sekolah, NOW())');
    $stmt->execute([
        ':nama'=>$nama, ':no_kp'=>$noKp, ':email'=>$email,
        ':kata_laluan'=>password_hash($password, PASSWORD_DEFAULT),
        ':tarikh_lahir'=>$tarikhLahir, ':pakej_id'=>$pakej['id'], ':pakej'=>$pakej['nama_pakej'], ':sesi'=>$sesi,
        ':nama_waris'=>$namaWaris, ':tel_waris'=>$telWaris, ':emel_waris'=>$emelWaris,
        ':sekolah'=>$sekolah === '' ? null : $sekolah
    ]);
    $atletId = (int)$pdo->lastInsertId();

    // Kira jumlah bayaran: yuran bulan semasa + baju-T (bayaran sekali sahaja).
    $hariIni = new DateTimeImmutable('today');
    $tarikhAkhir = $hariIni->modify('first day of next month')->format('Y-m-05');
    $jumlah = $harga + YURAN_BAJU;
    $pdo->prepare('INSERT INTO pembayaran (atlet_id, bulan, jumlah, tarikh_akhir, status) VALUES (?, ?, ?, ?, \'belum\')')
        ->execute([$atletId, namaBulan($hariIni), $jumlah, $tarikhAkhir]);
    $pdo->commit();

    // Log masuk terus supaya atlet boleh memuat naik bukti pembayaran pertama.
    session_regenerate_id(true);
    $_SESSION['user_id'] = $atletId;
    $_SESSION['nama'] = $nama;
    $_SESSION['peranan'] = 'atlet';

    $invois = invoisDaftarBelumBayar($pdo, $atletId);
    emelAtlet($pdo, $atletId, 'Pendaftaran AthleteTrack — Invois ' . $invois['no'],
        "Pendaftaran anda bagi {$pakej['nama_pakej']} telah diterima.\n\n"
        . "No. invois: {$invois['no']}\nJumlah perlu dibayar: RM" . number_format($jumlah, 2)
        . " (yuran RM" . number_format($harga, 2) . " + baju-T RM" . number_format(YURAN_BAJU, 2) . ")\n"
        . 'Tarikh akhir bayaran: ' . formatTarikhMs($tarikhAkhir));

    jawab(200, [
        'success'=>true,
        'message'=>'Pendaftaran berjaya disimpan.',
        'data'=>['id'=>$atletId, 'nama'=>$nama, 'peranan'=>'atlet', 'invois_daftar'=>$invois]
    ]);
} catch (PDOException $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    if ($e->getCode() === '23000') jawab(409, ['success'=>false,'message'=>GAGAL_AKAUN . 'No. kad pengenalan atau e-mel ini sudah didaftarkan.']);
    error_log('AthleteTrack registration error: '.$e->getMessage());
    jawab(500, ['success'=>false,'message'=>'Ralat pangkalan data. Semak sambungan db.php dan jadual atlet.']);
}
