<?php
    include "koneksi.php"; // Menghubungkan ke database
    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nik = $_POST['NIK'];
        $id_bencana = $_POST['id_bencana'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $nama = $_POST['nama'];
        $asal = $_POST['asal'];
        $usia = $_POST['usia'];
        $status = $_POST['status'];
        $id_posko = $_POST['id_posko'];

        // Query untuk memasukkan data korban
        $query = $db->prepare("INSERT INTO korban (NIK, id_bencana, jenis_kelamin, nama, asal, usia, status, id_posko) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $query->bind_param("sisssisi", $nik, $id_bencana, $jenis_kelamin, $nama, $asal, $usia, $status, $id_posko);

        if ($query->execute()) {
            header("Location: daftarKorban.php");
            exit();
        } else {
            echo "Error: " . $db->error;
        }
    }
?>
