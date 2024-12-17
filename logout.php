<?php
include "koneksi.php";
session_start();

// Cek apakah pengguna sudah login
if (isset($_SESSION["is_login"]) && $_SESSION["is_login"] === true) {
    // Mendapatkan ID pengguna dari session
    $id_user = $_SESSION["id_user"];

    // Mengambil waktu logout saat ini
    date_default_timezone_set('Asia/Jakarta');
    $last_logout = date("Y-m-d H:i:s");

    // Query untuk memperbarui kolom last_logout di tabel users
    $update_sql = "UPDATE users SET last_logout='$last_logout' WHERE id_user='$id_user'";

    // Mengeksekusi query untuk update last_logout
    if ($db->query($update_sql) === TRUE) {
        // Menghapus semua data session
        session_unset();
        session_destroy();
        
        // Redirect ke halaman login setelah logout
        header("location: login.php");
    } else {
        echo "Error: " . $db->error;
    }
} else {
    // Jika pengguna belum login, redirect ke halaman login
    header("location: login.php");
}
?>
