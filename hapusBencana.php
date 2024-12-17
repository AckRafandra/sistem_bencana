<?php
include "koneksi.php"; // Menghubungkan ke database

$id_bencana = $_GET['id']; // Mendapatkan ID bencana dari URL

$query = "DELETE FROM bencana WHERE id_bencana = $id_bencana";
if ($db->query($query)) {
    header('Location: daftarBencana.php');
} else {
    echo "Error: " . $db->error;
}
?>
