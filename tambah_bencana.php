<?php
include "koneksi.php"; // Menghubungkan ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama_bencana = $_POST['nama_bencana'];
    $jenis_bencana = $_POST['jenis_bencana'];
    $status = $_POST['status'];
    $kronologi = $_POST['kronologi'];
    $waktu_kejadian = $_POST['waktu_kejadian'];
    $lokasi_kejadian = $_POST['lokasi_kejadian'];

    // Query untuk menambahkan data ke tabel bencana
    $query = $db->prepare("INSERT INTO bencana (nama_bencana, jenis_bencana, status, kronologi, waktu_kejadian, lokasi_kejadian) 
                           VALUES (?, ?, ?, ?, ?, ?)");
    $query->bind_param("ssssss", $nama_bencana, $jenis_bencana, $status, $kronologi, $waktu_kejadian, $lokasi_kejadian);

    // Eksekusi query
    if ($query->execute()) {
        // Redirect ke daftar bencana jika berhasil
        header('Location: daftarBencana.php');
        exit();
    } else {
        // Tampilkan pesan error jika gagal
        echo "Error: " . $db->error;
    }
}
?>
