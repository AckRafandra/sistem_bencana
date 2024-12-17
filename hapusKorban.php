<?php
    include "koneksi.php"; // Menghubungkan ke database
    session_start();

    if (isset($_GET['id'])) {
        $id_korban = $_GET['id'];

        // Query untuk menghapus data korban
        $deleteQuery = $db->prepare("DELETE FROM korban WHERE id_korban = ?");
        $deleteQuery->bind_param("i", $id_korban);

        if ($deleteQuery->execute()) {
            header("Location: daftarKorban.php");
            exit();
        } else {
            echo "Error: " . $db->error;
        }
    }
?>
