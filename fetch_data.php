<?php
include 'koneksi.php';

// Query jumlah data
$total_bencana = $conn->query("SELECT COUNT(*) AS total FROM bencana")->fetch_assoc();
$total_korban = $conn->query("SELECT COUNT(*) AS total FROM korban")->fetch_assoc();
$total_petugas = $conn->query("SELECT COUNT(*) AS total FROM petugas")->fetch_assoc();
$total_posko = $conn->query("SELECT COUNT(*) AS total FROM posko")->fetch_assoc();
$total_keluarga = $conn->query("SELECT COUNT(*) AS total FROM keluarga")->fetch_assoc();

// Kirim data dalam bentuk JSON
echo json_encode([
    "total_bencana" => $total_bencana['total'],
    "total_korban" => $total_korban['total'],
    "total_petugas" => $total_petugas['total'],
    "total_posko" => $total_posko['total'],
    "total_keluarga" => $total_keluarga['total']
]);
?>
