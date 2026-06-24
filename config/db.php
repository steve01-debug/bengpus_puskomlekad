<?php
// Konfigurasi database
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'bengpuskomlekad');

function getDB() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Koneksi database gagal: " . $conn->connect_error . " - Pastikan MySQL di XAMPP sudah berjalan.");
    }
    $conn->set_charset('utf8mb4');

    // Auto-update table structure for 'is_read'
    try {
        $checkColumn = $conn->query("SHOW COLUMNS FROM feedback LIKE 'is_read'");
        if ($checkColumn && $checkColumn->num_rows == 0) {
            $conn->query("ALTER TABLE feedback ADD COLUMN is_read TINYINT(1) DEFAULT 0 AFTER pesan");
        }
    } catch (Exception $e) {
        // Ignore errors if table doesn't exist yet
    }

    return $conn;
}
?>
