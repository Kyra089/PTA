<?php
// Fail asas yang dikongsi oleh semua API AthleteTrack.
define('ATHLETETRACK_API', true);

// Ralat PHP tidak boleh dicetak ke dalam respons JSON; ia dicatat dalam log Apache.
ini_set('display_errors', '0');
date_default_timezone_set('Asia/Kuala_Lumpur');

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax']);
    session_start();
}

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../db.php';

$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

const BULAN_MS = ['Januari', 'Februari', 'Mac', 'April', 'Mei', 'Jun', 'Julai', 'Ogos', 'September', 'Oktober', 'November', 'Disember'];

// Sesi latihan yang dibenarkan bagi setiap pakej (sama seperti PAKEJ_SESI dalam index.php).
const PAKEJ_SESI = [
    'Pakej Hari Biasa' => ['Sesi Petang (5.00pm – 6.15pm)', 'Sesi Malam (8.00pm – 9.15pm)'],
    'Pakej Hari Sabtu' => ['Sesi Petang (5.00pm – 6.30pm)'],
    'Pakej Lompat Tinggi' => ['Sesi Petang (5.00pm – 6.30pm)'],
    'Pakej Latihan Lontaran' => ['Sesi Malam (8.00pm – 9.00pm)'],
    'Pakej Larian Jarak Jauh (Dewasa)' => ['Sesi Malam (8.00pm – 9.15pm)'],
    'Pakej Larian Jarak Jauh (9-18 Tahun)' => ['Sesi Malam (8.00pm – 9.15pm)'],
];

const YURAN_BAJU = 25.00;

function jawab(int $status, array $data): void {
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function perluKaedah(string $kaedah): void {
    if ($_SERVER['REQUEST_METHOD'] !== $kaedah) {
        jawab(405, ['success' => false, 'message' => 'Kaedah permintaan tidak dibenarkan.']);
    }
}

// Pastikan pengguna telah log masuk dengan peranan yang betul; pulangkan ID pengguna.
function perluLogin(string $peranan): int {
    if (empty($_SESSION['user_id']) || ($_SESSION['peranan'] ?? '') !== $peranan) {
        jawab(401, [
            'success' => false,
            'message' => $peranan === 'admin' ? 'Sila log masuk sebagai Admin.' : 'Sila log masuk sebagai atlet.'
        ]);
    }
    return (int)$_SESSION['user_id'];
}

function dataJson(): array {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!is_array($data)) {
        jawab(400, ['success' => false, 'message' => 'Data tidak sah.']);
    }
    return $data;
}

function tarikhSah(string $tarikh): bool {
    $d = DateTime::createFromFormat('!Y-m-d', $tarikh);
    return $d && $d->format('Y-m-d') === $tarikh;
}

// Contoh: "November 2026"
function namaBulan(DateTimeInterface $tarikh): string {
    return BULAN_MS[(int)$tarikh->format('n') - 1] . ' ' . $tarikh->format('Y');
}

// Nama pakej disimpan dalam bentuk penuh, contoh "Pakej Hari Biasa".
// Rekod lama yang disimpan tanpa awalan "Pakej " dinormalkan semasa dibaca.
function normalPakej(?string $pakej): string {
    $pakej = trim((string)$pakej);
    if ($pakej === '' || stripos($pakej, 'Pakej ') === 0) {
        return $pakej;
    }
    return 'Pakej ' . $pakej;
}

function noInvois(int $id, string $tarikhAkhir): string {
    return sprintf('INV-%s-%03d', substr($tarikhAkhir, 0, 4), $id);
}

// Pakej atlet dirujuk melalui atlet.pakej_id (ERD). Lajur teks atlet.pakej hanya sandaran untuk rekod lama.
const SQL_PAKEJ_ATLET = 'LEFT JOIN pakej_sukan ps ON ps.id = a.pakej_id';
const SQL_NAMA_PAKEJ = 'COALESCE(ps.nama_pakej, a.pakej)';
// Kategori atlet (alias a = atlet):
//  belum     = yuran pendaftaran (invois pertama) belum dibayar / bukti ditolak / tiada invois
//  baharu    = resit pendaftaran telah dihantar dan didaftar kurang daripada sebulan
//  berdaftar = resit pendaftaran telah dihantar dan didaftar sebulan atau lebih
const SQL_KATEGORI_ATLET = "CASE WHEN (SELECT p0.status FROM pembayaran p0 WHERE p0.atlet_id = a.id ORDER BY p0.id LIMIT 1)
        IN ('menunggu_sahkan', 'sudah')
    THEN IF(a.tarikh_daftar > DATE_SUB(CURDATE(), INTERVAL 1 MONTH), 'baharu', 'berdaftar')
    ELSE 'belum' END";

// Cari pakej berdasarkan nama (dengan atau tanpa awalan "Pakej "). Pulangkan id, nama_pakej, harga, hari.
function cariPakej(PDO $pdo, string $nama): ?array {
    $stmt = $pdo->prepare('SELECT id, nama_pakej, harga, hari FROM pakej_sukan WHERE nama_pakej = ?');
    $stmt->execute([normalPakej($nama)]);
    $pakej = $stmt->fetch();
    return $pakej ?: null;
}

// No. kad pengenalan Malaysia: 12 digit, disimpan dalam format 000000-00-0000. Pulangkan '' jika tidak sah.
function normalKp(string $kp): string {
    $digit = preg_replace('/\D/', '', $kp);
    return strlen($digit) === 12 ? substr($digit, 0, 6) . '-' . substr($digit, 6, 2) . '-' . substr($digit, 8) : '';
}

function telefonSah(string $tel): bool {
    return (bool)preg_match('/^0\d{1,2}-?\d{7,8}$/', str_replace(' ', '', $tel));
}

function formatTarikhMs(string $tarikh): string {
    $d = new DateTimeImmutable(substr($tarikh, 0, 10));
    return (int)$d->format('j') . ' ' . BULAN_MS[(int)$d->format('n') - 1] . ' ' . $d->format('Y');
}

// Invois pendaftaran (invois pertama atlet) yang belum dibayar. Carta alir: atlet mesti membuat
// pembayaran pertama sebelum boleh ke dashboard.
function invoisDaftarBelumBayar(PDO $pdo, int $atletId): ?array {
    $stmt = $pdo->prepare(
        "SELECT p.id, p.bulan, p.jumlah, p.tarikh_akhir, p.status, a.nama, " . SQL_NAMA_PAKEJ . " AS pakej, ps.harga
         FROM pembayaran p JOIN atlet a ON a.id = p.atlet_id " . SQL_PAKEJ_ATLET . "
         WHERE p.atlet_id = ? ORDER BY p.id LIMIT 1"
    );
    $stmt->execute([$atletId]);
    $i = $stmt->fetch();
    if (!$i || !in_array($i['status'], ['belum', 'ditolak'], true)) {
        return null;
    }
    $yuran = $i['harga'] !== null ? (float)$i['harga'] : (float)$i['jumlah'] - YURAN_BAJU;
    return [
        'id' => (int)$i['id'], 'no' => noInvois((int)$i['id'], (string)$i['tarikh_akhir']),
        'nama' => $i['nama'], 'pakej' => normalPakej($i['pakej']), 'status' => $i['status'],
        'baju' => (float)$i['jumlah'] - $yuran, 'yuran' => $yuran,
        'jumlah' => (float)$i['jumlah'], 'tarikh_akhir' => $i['tarikh_akhir']
    ];
}

// E-mel notifikasi kepada atlet (diabaikan dengan senyap jika e-mel belum dikonfigurasi).
function emelAtlet(PDO $pdo, int $atletId, string $subjek, string $isi): bool {
    require_once __DIR__ . '/emel.php';
    if (!emelDikonfigurasi()) {
        return false;
    }
    $stmt = $pdo->prepare('SELECT nama, email FROM atlet WHERE id = ?');
    $stmt->execute([$atletId]);
    $a = $stmt->fetch();
    if (!$a || empty($a['email'])) {
        return false;
    }
    $badan = "Assalamualaikum dan salam sejahtera {$a['nama']},\n\n$isi\n\n"
        . "Bayaran melalui pindahan bank ke Maybank 5621-0685-7064 (Shah Alam Athletics). "
        . "Selepas membayar, sila log masuk ke AthleteTrack dan muat naik bukti pembayaran.\n\n"
        . "Terima kasih.\nKelab Olahraga Shah Alam\n\n(E-mel ini dijana secara automatik oleh sistem AthleteTrack.)";
    return hantarEmel($a['email'], $subjek, $badan);
}

// Jana invois bulan semasa bagi atlet yang belum mempunyai invois bulan ini, dan maklumkan melalui e-mel.
// Atlet tanpa pakej yang sah (pakej_id kosong) dilangkau kerana harganya tidak diketahui.
function pastikanInvoisBulanSemasa(PDO $pdo, ?int $atletId = null): void {
    $sekarang = new DateTimeImmutable('today');
    $bulan = namaBulan($sekarang);
    $tarikhAkhir = $sekarang->modify('first day of next month')->format('Y-m-05');

    $sql = 'SELECT a.id, ps.harga FROM atlet a JOIN pakej_sukan ps ON ps.id = a.pakej_id
            WHERE NOT EXISTS (SELECT 1 FROM pembayaran p WHERE p.atlet_id = a.id AND p.bulan = ?)';
    $param = [$bulan];
    if ($atletId !== null) {
        $sql .= ' AND a.id = ?';
        $param[] = $atletId;
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($param);

    $tambah = $pdo->prepare(
        'INSERT INTO pembayaran (atlet_id, bulan, jumlah, tarikh_akhir, status) VALUES (?, ?, ?, ?, \'belum\')'
    );
    foreach ($stmt->fetchAll() as $atlet) {
        $tambah->execute([$atlet['id'], $bulan, $atlet['harga'], $tarikhAkhir]);
        emelAtlet($pdo, (int)$atlet['id'], "Invois Yuran $bulan",
            "Invois yuran bulan $bulan sebanyak RM" . number_format((float)$atlet['harga'], 2)
            . " telah dikeluarkan. Tarikh akhir bayaran: " . formatTarikhMs($tarikhAkhir) . '.');
    }
}
