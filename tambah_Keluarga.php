<?php
include "koneksi.php"; // Menghubungkan ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $NIK = $_POST['NIK'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $hubungan = $_POST['hubungan'];
    $nik_keluarga = $_POST['nik_keluarga'];

    // Query untuk menambah data keluarga ke dalam database
    $query = "INSERT INTO keluarga (NIK, nomor_telepon, hubungan, nik_keluarga) 
              VALUES ('$NIK', '$nomor_telepon', '$hubungan', '$nik_keluarga')";

    if ($db->query($query) === TRUE) {
        // Setelah sukses, redirect ke halaman daftar keluarga
        header('Location: daftarKeluarga.php'); 
    } else {
        echo "Error: " . $db->error;
    }
}
?>
