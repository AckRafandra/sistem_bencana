<?php
include "koneksi.php"; // Menghubungkan ke database
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form dan sanitasi
    $nama_petugas = trim($_POST['nama_petugas']);
    $kontak_petugas = trim($_POST['kontak_petugas']);
    $instansi = trim($_POST['instansi']);

    // Validasi input
    if (empty($nama_petugas) || empty($kontak_petugas) || empty($instansi)) {
        echo "Semua kolom harus diisi!";
        exit();
    }

    // Validasi nomor kontak hanya berisi angka
    if (!preg_match('/^[0-9]+$/', $kontak_petugas)) {
        echo "Kontak petugas hanya boleh berisi angka!";
        exit();
    }

    // Query untuk memasukkan data petugas
    $query = $db->prepare("INSERT INTO petugas (nama_petugas, kontak_petugas, instansi) 
                           VALUES (?, ?, ?)");
    $query->bind_param("sss", $nama_petugas, $kontak_petugas, $instansi);

    // Eksekusi query dan periksa hasilnya
    if ($query->execute()) {
        // Menambahkan pesan sukses dan redirect
        $_SESSION['success'] = "Data petugas berhasil ditambahkan.";
        header("Location: daftarPetugas.php");
        exit();
    } else {
        // Tampilkan error jika gagal
        echo "Error: " . $db->error;
    }
}
?>
