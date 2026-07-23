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

    // PERBAIKAN: Mengubah nama tabel menjadi berita_db & memperbaiki kolom tanggal
    $conn->query("CREATE TABLE IF NOT EXISTS berita_db (
        id INT AUTO_INCREMENT PRIMARY KEY,
        judul VARCHAR(500) NOT NULL,
        kategori VARCHAR(100) DEFAULT 'Umum',
        tanggal DATE NOT NULL,
        gambar VARCHAR(500) DEFAULT NULL,
        isi TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    // Auto-create tabel pimpinan_db
    $conn->query("CREATE TABLE IF NOT EXISTS pimpinan_db (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nama VARCHAR(300) NOT NULL,
        masa_jabatan VARCHAR(200) NOT NULL,
        gambar VARCHAR(500) DEFAULT NULL,
        is_current TINYINT(1) DEFAULT 0,
        urutan INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    // Auto-create tabel video_terkait_db
    $conn->query("CREATE TABLE IF NOT EXISTS video_terkait_db (
        id INT AUTO_INCREMENT PRIMARY KEY,
        judul VARCHAR(500) NOT NULL,
        url_video VARCHAR(500) NOT NULL,
        thumbnail VARCHAR(500) DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    // Auto-create tabel struktur_organisasi_db
    $conn->query("CREATE TABLE IF NOT EXISTS struktur_organisasi_db (
        id INT AUTO_INCREMENT PRIMARY KEY,
        unsur VARCHAR(200) NOT NULL,
        jabatan VARCHAR(200) NOT NULL,
        nama VARCHAR(300) NOT NULL,
        parent_id INT DEFAULT NULL,
        urutan INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    // Auto-create tabel untuk gambar struktur organisasi
    $conn->query("CREATE TABLE IF NOT EXISTS struktur_organisasi_image_db (
        id INT PRIMARY KEY,
        gambar VARCHAR(500) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    // Seed default image if empty
    try {
        $checkImg = $conn->query("SELECT COUNT(*) as co FROM struktur_organisasi_image_db");
        if ($checkImg) {
            $rowI = $checkImg->fetch_assoc();
            if ($rowI['co'] == 0) {
                $conn->query("INSERT INTO struktur_organisasi_image_db (id, gambar) VALUES (1, 'assets/images/hero-bg.png')");
            }
        }
    } catch (Exception $e) {}


    // Check seed pimpinan_db
    try {
        $checkPimpinan = $conn->query("SELECT COUNT(*) as co FROM pimpinan_db");
        $rowP = $checkPimpinan->fetch_assoc();
        if ($rowP['co'] == 0) {
            $conn->query("INSERT INTO pimpinan_db (id, nama, masa_jabatan, gambar, is_current, urutan) VALUES
            (1, 'Brigadir Jenderal TNI Taufik Supriyadi', '2024 - Sekarang', 'assets/images/kabeng-taufik.jpg', 1, 95),
            (2, 'Kolonel Chb Subiakto, S.E.', '2023 - 2024', 'assets/images/kabeng-subiakto.jpg', 0, 90),
            (3, 'Kolonel Chb Nurcahyo Utomo, M.Si.', '2021 - 2023', 'assets/images/kabeng-nurcahyo.jpg', 0, 80),
            (4, 'Kolonel Chb Muhammad Muhson', '2020 - 2021', 'assets/images/kabeng-muhson.jpg', 0, 70),
            (5, 'Kolonel Chb Widodo, S.I.P.', '2019 - 2020', 'assets/images/kabeng-widodo.jpg', 0, 60),
            (6, 'Kolonel Chb Fitri Taufiq Sahary, S.E., M.M.', '2018 - 2019', 'assets/images/kabeng-fitri.jpg', 0, 55),
            (7, 'Kolonel Chb Jajat Drajat P., S.H.', '2018 - 2018', 'assets/images/kabeng-jajat.jpg', 0, 50),
            (8, 'Kolonel Chb Leo Yulius Hillman', '2016 - 2018', 'assets/images/kabeng-leo.jpg', 0, 45),
            (9, 'Kolonel Chb Zakaria', '2015 - 2016', 'assets/images/kabeng-zakaria.jpg', 0, 40),
            (10, 'Kolonel Chb Totok', '2014 - 2015', 'assets/images/kabeng-totok.jpg', 0, 35),
            (11, 'Kolonel Chb Sasmito Yupitoro, S.T.', '2011 - 2014', 'assets/images/kabeng-sasmito.jpg', 0, 30),
            (12, 'Kolonel Chb Harijono, S.T.', '2006 - 2011', 'assets/images/kabeng-harijono.jpg', 0, 25),
            (13, 'Kolonel Chb Sumarno', '2003 - 2006', 'assets/images/kabeng-sumarno.jpg', 0, 20),
            (14, 'Kolonel Chb E. Supribadio. TE', '1997 - 2003', 'assets/images/kabeng-supribadio.jpg', 0, 18),
            (15, 'Kolonel Chb Wiyono', '1991 - 1997', 'assets/images/kabeng-wiyono.jpg', 0, 16),
            (16, 'Kolonel Chb Widoyo', '1987 - 1991', 'assets/images/kabeng-widoyo.jpg', 0, 14),
            (17, 'Kolonel Chb Priyambodo', '1980 - 1987', 'assets/images/kabeng-priyambodo.jpg', 0, 12)");
        }
    } catch (Exception $e) {}

    // Check seed struktur_organisasi_db
    try {
        $checkOrgas = $conn->query("SELECT COUNT(*) as co FROM struktur_organisasi_db");
        $rowO = $checkOrgas->fetch_assoc();
        if ($rowO['co'] == 0) {
            $conn->query("INSERT INTO struktur_organisasi_db (unsur, jabatan, nama, urutan) VALUES
            ('pimpinan', 'KEPALA', 'Nama Kepala', 10),
            ('pimpinan', 'WAKIL KEPALA', 'Nama Wakil Kepala', 20),
            
            ('pembantu_pimpinan', 'KABAGUM', 'Nama Kabagum', 30),
            ('pembantu_pimpinan', 'KABAGRENDAL', 'Nama Kabagrendal', 40),
            
            ('pelayanan', 'PASITUUD', 'Nama Pasituud', 50),
            
            ('pelaksana_kabeng', 'KABENG SISKOM', 'Nama Kabeng Siskom', 60),
            ('pelaksana_subbeng_siskom', 'SUBBENG RADIO DIGILOG', 'Nama Kasubbeng', 61),
            ('pelaksana_subbeng_siskom', 'SUBBENG ALKOMSAL & MULTIMEDIA', 'Nama Kasubbeng', 62),
            ('pelaksana_subbeng_siskom', 'SUBBENG ALKOMSAT', 'Nama Kasubbeng', 63),
            
            ('pelaksana_kabeng', 'KABENG SISLEK', 'Nama Kabeng Sislek', 70),
            ('pelaksana_subbeng_sislek', 'SUBBENG ALDALLEK', 'Nama Kasubbeng', 71),
            ('pelaksana_subbeng_sislek', 'SUBBENG ALPERNIKA', 'Nama Kasubbeng', 72),
            ('pelaksana_subbeng_sislek', 'SUBBENG MATINDRALEK', 'Nama Kasubbeng', 73),
            ('pelaksana_subbeng_sislek', 'SUBBENG MEKATRONIKA', 'Nama Kasubbeng', 74),
            
            ('pelaksana_kabeng', 'KABENG JARINGAN DAN TIK', 'Nama Kabeng Jarnet TIK', 80),
            ('pelaksana_subbeng_jarnet', 'SUBBENG JARKABEL', 'Nama Kasubbeng', 81),
            ('pelaksana_subbeng_jarnet', 'SUBBENG JARNIRKABEL', 'Nama Kasubbeng', 82),
            ('pelaksana_subbeng_jarnet', 'SUBBENG TIK', 'Nama Kasubbeng', 83),
            
            ('pelaksana_kabeng', 'KABENG INTEGRASI & POWER SYSTEM', 'Nama Kabeng Integrasi', 90),
            ('pelaksana_subbeng_integrasi', 'SUBBENG INTEGRASI', 'Nama Kasubbeng', 91),
            ('pelaksana_subbeng_integrasi', 'SUBBENG POWER SYSTEM', 'Nama Kasubbeng', 92),
            
            ('pelaksana_kabeng', 'KAGUD', 'Nama Kagud', 100)");
        }
    } catch (Exception $e) {}

    return $conn;
}