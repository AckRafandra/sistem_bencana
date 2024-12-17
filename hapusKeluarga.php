<?php
include "koneksi.php"; // Menghubungkan ke database

if (isset($_GET['id'])) {
    $NIK = $_GET['id'];

    // Query untuk menghapus data keluarga berdasarkan NIK
    $query = "DELETE FROM keluarga WHERE NIK = '$NIK'";

    if ($db->query($query) === TRUE) {
        // Setelah sukses, redirect ke halaman daftar keluarga
        header('Location: daftarKeluarga.php');
    } else {
        echo "Error: " . $db->error;
    }
}
?>
