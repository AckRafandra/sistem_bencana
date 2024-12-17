<?php 
include "koneksi.php"; // Menghubungkan ke database
session_start();

if (isset($_GET['id'])) {
    $id_petugas = $_GET['id'];

    // Validasi ID petugas untuk memastikan itu adalah angka
    if (!filter_var($id_petugas, FILTER_VALIDATE_INT)) {
        echo "ID Petugas tidak valid.";
        exit();
    }

    // Query untuk menghapus data petugas dengan prepared statement
    $query = $db->prepare("DELETE FROM petugas WHERE id_petugas = ?");
    $query->bind_param("i", $id_petugas);

    if ($query->execute()) {
        $_SESSION['success'] = "Data petugas berhasil dihapus.";
        header("Location: daftarPetugas.php");
        exit();
    } else {
        echo "Terjadi kesalahan: " . $db->error;
    }
} else {
    echo "ID Petugas tidak ditemukan.";
}
?>
