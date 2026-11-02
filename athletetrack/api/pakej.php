<?php
// GET  : senarai pakej sukan (umum — juga digunakan oleh borang pendaftaran atlet).
// POST : aksi=tambah|kemaskini|padam (admin). Borang multipart kerana poster boleh dimuat naik.
require_once __DIR__ . '/_init.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $pakej = $pdo->query(
            'SELECT p.id, p.nama_pakej, p.sukan, p.hari, p.sesi, p.harga, p.poster,
                    (SELECT COUNT(*) FROM atlet a WHERE a.pakej_id = p.id) AS bil_atlet
             FROM pakej_sukan p ORDER BY p.id'
        )->fetchAll();
        foreach ($pakej as &$p) {
            $p['id'] = (int)$p['id'];
            $p['harga'] = (float)$p['harga'];
            $p['bil_atlet'] = (int)$p['bil_atlet'];
        }
        unset($p);
        jawab(200, ['success' => true, 'data' => $pakej]);
    } catch (PDOException $e) {
        error_log('AthleteTrack package list error: ' . $e->getMessage());
        jawab(500, ['success' => false, 'message' => 'Senarai pakej gagal dimuatkan.']);
    }
}

perluKaedah('POST');
perluLogin('admin');

$aksi = $_POST['aksi'] ?? '';
$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);

// Simpan poster (jika ada) dan pulangkan laluan relatif, contoh "uploads/poster/xxx.jpg".
function simpanPoster(): ?string {
    $fail = $_FILES['poster'] ?? null;
    if (!$fail || $fail['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ($fail['error'] !== UPLOAD_ERR_OK || $fail['size'] > 5 * 1024 * 1024 || !is_uploaded_file($fail['tmp_name'])) {
        jawab(422, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Poster gagal dimuat naik (maksimum 5MB).']);
    }
    $jenis = ['image/jpeg' => 'jpg', 'image/png' => 'png'];
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($fail['tmp_name']);
    if (!isset($jenis[$mime])) {
        jawab(422, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Poster mestilah fail JPG atau PNG.']);
    }
    $folder = __DIR__ . '/../uploads/poster';
    if (!is_dir($folder)) {
        mkdir($folder, 0775, true);
    }
    $nama = 'poster_' . bin2hex(random_bytes(8)) . '.' . $jenis[$mime];
    if (!move_uploaded_file($fail['tmp_name'], $folder . '/' . $nama)) {
        jawab(500, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Poster gagal disimpan.']);
    }
    return 'uploads/poster/' . $nama;
}

try {
    if ($aksi === 'padam') {
        if (!$id) {
            jawab(422, ['success' => false, 'message' => 'Gagal kemaskini maklumat. ID pakej tidak sah.']);
        }
        $stmt = $pdo->prepare('SELECT nama_pakej FROM pakej_sukan WHERE id = ?');
        $stmt->execute([$id]);
        $nama = $stmt->fetchColumn();
        if ($nama === false) {
            jawab(404, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Pakej tidak dijumpai.']);
        }
        $guna = $pdo->prepare('SELECT COUNT(*) FROM atlet WHERE pakej_id = ?');
        $guna->execute([$id]);
        $bil = (int)$guna->fetchColumn();
        if ($bil > 0) {
            jawab(409, ['success' => false, 'message' => "Gagal kemaskini maklumat. Pakej ini sedang digunakan oleh $bil atlet. Tukar pakej atlet tersebut dahulu."]);
        }
        $pdo->prepare('DELETE FROM pakej_sukan WHERE id = ?')->execute([$id]);
        jawab(200, ['success' => true, 'message' => 'Pakej berjaya dipadam.']);
    }

    if ($aksi !== 'tambah' && $aksi !== 'kemaskini') {
        jawab(422, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Aksi tidak sah.']);
    }

    $nama = normalPakej($_POST['nama_pakej'] ?? '');
    $sukan = trim($_POST['sukan'] ?? '');
    $hari = trim($_POST['hari'] ?? '');
    $sesi = trim($_POST['sesi'] ?? '');
    $harga = filter_var($_POST['harga'] ?? null, FILTER_VALIDATE_FLOAT);

    if ($nama === '' || $sukan === '' || $hari === '' || $sesi === '' || $harga === false) {
        jawab(422, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Sila lengkapkan semua maklumat pakej.']);
    }
    if ($harga <= 0 || $harga > 9999.99) {
        jawab(422, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Yuran mestilah antara RM0.01 dan RM9999.99.']);
    }

    $sama = $pdo->prepare('SELECT id FROM pakej_sukan WHERE nama_pakej = ? AND id <> ?');
    $sama->execute([$nama, $id ?: 0]);
    if ($sama->fetch()) {
        jawab(409, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Nama pakej ini sudah wujud.']);
    }

    if ($aksi === 'tambah') {
        $poster = simpanPoster();
        $pdo->prepare('INSERT INTO pakej_sukan (nama_pakej, sukan, hari, sesi, harga, poster) VALUES (?, ?, ?, ?, ?, ?)')
            ->execute([$nama, $sukan, $hari, $sesi, $harga, $poster]);
        jawab(200, ['success' => true, 'message' => 'Pakej berjaya ditambah!']);
    }

    if (!$id) {
        jawab(422, ['success' => false, 'message' => 'Gagal kemaskini maklumat. ID pakej tidak sah.']);
    }
    $stmt = $pdo->prepare('SELECT nama_pakej, poster FROM pakej_sukan WHERE id = ?');
    $stmt->execute([$id]);
    $lama = $stmt->fetch();
    if (!$lama) {
        jawab(404, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Pakej tidak dijumpai.']);
    }
    $poster = simpanPoster() ?? $lama['poster'];

    $pdo->beginTransaction();
    $pdo->prepare('UPDATE pakej_sukan SET nama_pakej = ?, sukan = ?, hari = ?, sesi = ?, harga = ?, poster = ? WHERE id = ?')
        ->execute([$nama, $sukan, $hari, $sesi, $harga, $poster, $id]);
    // Jika nama pakej ditukar, atlet dalam pakej tersebut turut dikemaskini.
    if ($lama['nama_pakej'] !== $nama) {
        $pdo->prepare('UPDATE atlet SET pakej = ? WHERE pakej_id = ?')->execute([$nama, $id]);
    }
    $pdo->commit();

    jawab(200, ['success' => true, 'message' => 'Pakej berjaya dikemaskini!']);
} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log('AthleteTrack package save error: ' . $e->getMessage());
    jawab(500, ['success' => false, 'message' => 'Gagal kemaskini maklumat. Pakej gagal disimpan.']);
}
