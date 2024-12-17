<?php 
include "koneksi.php"; 
session_start();

if (isset($_GET['id'])) {
    $id_posko = $_GET['id'];

    // Query untuk menghapus data posko berdasarkan ID
    $query = "DELETE FROM posko WHERE id_posko = $id_posko";

    if ($db->query($query)) {
        header("Location: daftarPosko.php");
        exit();
    } else {
        echo "Terjadi kesalahan: " . $db->error;
    }
} else {
    echo "ID Posko tidak ditemukan.";
}
?>
