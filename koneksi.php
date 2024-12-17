<?php
// ganti dengan informasi database Anda
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'db_bencana';

// Membuat koneksi
$db = new mysqli($host, $user, $password, $dbname);

// Cek koneksi
if ($db->connect_error) {
    die("Koneksi gagal: " . $db->connect_error);
}
?>