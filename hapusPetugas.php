<?php 
include "koneksi.php"; // Menghubungkan ke database
session_start();

if (isset($_GET['id'])) {
    $id_petugas = $_GET['id'];

    // Query untuk menghapus data petugas
    $query = "DELETE FROM petugas WHERE id_petugas = $id_petugas";

    if ($db->query($query)) {
        header("Location: daftar_petugas.php");
        exit();
    } else {
        echo "Terjadi kesalahan: " . $db->error;
    }
} else {
    echo "ID Petugas tidak ditemukan.";
}
?>
