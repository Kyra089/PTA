<?php
$host = 'localhost';
$db   = 'athletetrack_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $user,
        $pass
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log('AthleteTrack DB connection error: ' . $e->getMessage());

    // Fail API mesti sentiasa memulangkan JSON supaya fetch() tidak gagal membaca respons.
    if (defined('ATHLETETRACK_API')) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Sambungan pangkalan data gagal. Pastikan MySQL berjalan dalam XAMPP.'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    die('Sambungan pangkalan data gagal. Pastikan MySQL berjalan dalam XAMPP.');
}
