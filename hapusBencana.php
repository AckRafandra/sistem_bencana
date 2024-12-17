<?php
include "koneksi.php"; // Menghubungkan ke database

$id_bencana = $_GET['id']; // Mendapatkan ID bencana dari URL

// Validasi ID bencana untuk memastikan itu adalah angka
if (isset($id_bencana) && is_numeric($id_bencana)) {
    // Menggunakan prepared statement untuk menghapus data
    $query = $db->prepare("DELETE FROM bencana WHERE id_bencana = ?");
    $query->bind_param("i", $id_bencana); // Bind parameter ID bencana sebagai integer

    if ($query->execute()) {
        header('Location: daftarBencana.php');
        exit();
    } else {
        echo "Error: " . $db->error;
    }
} else {
    // Menangani kasus jika ID tidak valid atau tidak ada
    echo "ID bencana tidak valid.";
}
?>
