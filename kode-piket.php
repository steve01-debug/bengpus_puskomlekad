<?php
session_start();

// Daftar kelas sesuai script piket.py asli Anda
$daftar_kelas = ["kelas_A", "kelas_B"];

// 1. Aksi Simpan atau Update Data Kelas
if (isset($_POST['action']) && $_POST['action'] === 'simpan_piket') {
    $kelas = $_POST['kelas'] ?? '';
    
    if (in_array($kelas, $daftar_kelas)) {
        $total = intval($_POST['total'] ?? 0);
        $kurang = intval($_POST['kurang'] ?? 0);
        $hadir = $total - $kurang;
        
        $keterangan_raw = $_POST['keterangan'] ?? [];
        $keterangan = [];
        
        foreach ($keterangan_raw as $ket) {
            $ket = trim(strtoupper($ket)); 
            if ($ket !== "") {
                if (isset($keterangan[$ket])) {
                    $keterangan[$ket]++;
                } else {
                    $keterangan[$ket] = 1;
                }
            }
        }
        
        $_SESSION['rekap_piket'][$kelas] = [
            "total" => $total,
            "kurang" => $kurang,
            "hadir" => $hadir,
            "keterangan" => $keterangan
        ];
    }
    
    // Alihkan langsung ke URL bersih halaman piket tanpa merusak .htaccess
    header("Location: /bengpus_puskomlekad/piket");
    exit;
}

// 2. Aksi Reset Seluruh Data Rekapitulasi
if (isset($_GET['action']) && $_GET['action'] === 'reset') {
    unset($_SESSION['rekap_piket']);
    
    // Alihkan langsung ke URL bersih halaman piket tanpa merusak .htaccess
    header("Location: /bengpus_puskomlekad/piket");
    exit;
}