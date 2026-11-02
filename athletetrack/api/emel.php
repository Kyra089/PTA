<?php
// Penghantaran e-mel melalui SMTP (tanpa pustaka luar). Tetapan dalam config-emel.php.

function tetapanEmel(): array {
    static $tetapan = null;
    if ($tetapan === null) {
        $fail = __DIR__ . '/../config-emel.php';
        $tetapan = is_file($fail) ? (array)require $fail : [];
    }
    return $tetapan;
}

function emelDikonfigurasi(): bool {
    $t = tetapanEmel();
    return !empty($t['hos']) && !empty($t['pengguna']);
}

// Hantar satu e-mel teks biasa. Pulangkan true jika pelayan SMTP menerima mesej.
function hantarEmel(string $ke, string $subjek, string $badan): bool {
    if (!emelDikonfigurasi() || !filter_var($ke, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    $t = tetapanEmel();
    $keselamatan = $t['keselamatan'] ?? 'ssl';
    $alamat = ($keselamatan === 'ssl' ? 'ssl://' : 'tcp://') . $t['hos'] . ':' . (int)($t['port'] ?? 465);

    $sambungan = @stream_socket_client($alamat, $errno, $errstr, 15);
    if (!$sambungan) {
        error_log("AthleteTrack SMTP connect error: $errstr ($errno)");
        return false;
    }
    stream_set_timeout($sambungan, 15);

    $baca = function () use ($sambungan): string {
        $respons = '';
        while (($baris = fgets($sambungan, 515)) !== false) {
            $respons .= $baris;
            if (strlen($baris) < 4 || $baris[3] === ' ') {
                break;
            }
        }
        return $respons;
    };
    $arahan = function (string $teks, array $kodSah) use ($sambungan, $baca): bool {
        if ($teks !== '') {
            fwrite($sambungan, $teks . "\r\n");
        }
        $respons = $baca();
        if (!in_array((int)substr($respons, 0, 3), $kodSah, true)) {
            error_log('AthleteTrack SMTP error: ' . trim($respons));
            return false;
        }
        return true;
    };

    $pengguna = (string)$t['pengguna'];
    $namaPengirim = '=?UTF-8?B?' . base64_encode((string)($t['nama_pengirim'] ?? 'AthleteTrack')) . '?=';
    $hos = 'localhost';

    $ok = $arahan('', [220]) && $arahan("EHLO $hos", [250]);
    if ($ok && $keselamatan === 'tls') {
        $ok = $arahan('STARTTLS', [220])
            && stream_socket_enable_crypto($sambungan, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)
            && $arahan("EHLO $hos", [250]);
    }
    if ($ok && (string)($t['kata_laluan'] ?? '') !== '') {
        $ok = $arahan('AUTH LOGIN', [334])
            && $arahan(base64_encode($pengguna), [334])
            && $arahan(base64_encode((string)$t['kata_laluan']), [235]);
    }
    $ok = $ok && $arahan("MAIL FROM:<$pengguna>", [250]) && $arahan("RCPT TO:<$ke>", [250, 251]) && $arahan('DATA', [354]);

    if ($ok) {
        $badan = preg_replace("/\r?\n/", "\r\n", $badan);
        $badan = preg_replace('/^\./m', '..', $badan); // dot-stuffing
        $mesej = 'From: ' . $namaPengirim . " <$pengguna>\r\n"
            . "To: <$ke>\r\n"
            . 'Subject: =?UTF-8?B?' . base64_encode($subjek) . "?=\r\n"
            . 'Date: ' . date('r') . "\r\n"
            . "MIME-Version: 1.0\r\n"
            . "Content-Type: text/plain; charset=UTF-8\r\n"
            . "Content-Transfer-Encoding: 8bit\r\n\r\n"
            . $badan . "\r\n.";
        $ok = $arahan($mesej, [250]);
    }
    @fwrite($sambungan, "QUIT\r\n");
    fclose($sambungan);
    return $ok;
}
