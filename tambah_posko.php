<?php 
include "koneksi.php"; 
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_posko = $_POST['nama_posko'];
    $penanggung_jawab = $_POST['penanggung_jawab'];
    $lokasi_posko = $_POST['lokasi_posko'];
    $kontak_posko = $_POST['kontak_posko'];

    // Query untuk menyimpan data posko baru
    $query = "INSERT INTO posko (nama_posko, penanggung_jawab, lokasi_posko, kontak_posko) 
              VALUES ('$nama_posko', '$penanggung_jawab', '$lokasi_posko', '$kontak_posko')";

    if ($db->query($query)) {
        header("Location: daftarPosko.php");
        exit();
    } else {
        echo "Terjadi kesalahan: " . $db->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Posko</title>
</head>
<body>
    <h3>Tambah Posko Baru</h3>
    <form action="tambah_posko.php" method="POST">
        <input type="text" name="nama_posko" placeholder="Nama Posko" required><br>
        <input type="text" name="penanggung_jawab" placeholder="Penanggung Jawab" required><br>
        <input type="text" name="lokasi_posko" placeholder="Lokasi Posko" required><br>
        <input type="text" name="kontak_posko" placeholder="Kontak Posko" required><br>
        <button type="submit">Tambah Posko</button>
    </form>
</body>
</html>
