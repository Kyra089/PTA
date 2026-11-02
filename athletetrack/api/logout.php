<?php
session_start();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);

    echo json_encode([
        'success' => false,
        'message' => 'Kaedah permintaan tidak dibenarkan.'
    ], JSON_UNESCAPED_UNICODE);

    exit;
}

// Kosongkan semua data sesi pengguna.
$_SESSION = [];

// Hapuskan cookie sesi jika digunakan.
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

// Tamatkan sesi.
session_destroy();

echo json_encode([
    'success' => true,
    'message' => 'Log keluar berjaya.'
], JSON_UNESCAPED_UNICODE);