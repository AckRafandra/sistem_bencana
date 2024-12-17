<?php
include "koneksi.php"; // Menghubungkan ke database
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama_petugas = $_POST['nama_petugas'];
    $kontak_petugas = $_POST['kontak_petugas'];
    $instansi = $_POST['instansi'];

    // Query untuk memasukkan data petugas
    $query = $db->prepare("INSERT INTO petugas (nama_petugas, kontak_petugas, instansi) 
                           VALUES (?, ?, ?)");
    $query->bind_param("sss", $nama_petugas, $kontak_petugas, $instansi);

    // Eksekusi query dan periksa hasilnya
    if ($query->execute()) {
        // Redirect ke halaman daftar petugas setelah berhasil
        header("Location: daftarPetugas.php");
        exit();
    } else {
        // Tampilkan error jika gagal
        echo "Error: " . $db->error;
    }
}
?>
