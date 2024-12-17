<?php 
include "koneksi.php"; // Menghubungkan ke database
session_start();

if (isset($_GET['id'])) {
    $id_petugas = $_GET['id'];

    // Ambil data petugas berdasarkan ID
    $query = "SELECT * FROM petugas WHERE id_petugas = $id_petugas";
    $result = $db->query($query);
    $data = $result->fetch_assoc();

    if (!$data) {
        die("Data petugas tidak ditemukan.");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data yang diubah
    $id_petugas = $_POST['id_petugas'];
    $nama_petugas = $_POST['nama_petugas'];
    $kontak_petugas = $_POST['kontak_petugas'];
    $instansi = $_POST['instansi'];

    // Query untuk update data
    $query = "UPDATE petugas SET nama_petugas = '$nama_petugas', kontak_petugas = '$kontak_petugas', instansi = '$instansi' WHERE id_petugas = $id_petugas";
    
    if ($db->query($query)) {
        header("Location: daftar_petugas.php");
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
    <title>Update Petugas</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* Styling forms and other elements as needed */
    </style>
</head>
<body>
    <div class="form-container">
        <h3>Update Petugas</h3>
        <form action="updatePetugas.php" method="POST">
            <input type="hidden" name="id_petugas" value="<?php echo $data['id_petugas']; ?>">
            <input type="text" name="nama_petugas" value="<?php echo $data['nama_petugas']; ?>" placeholder="Nama Petugas" required><br>
            <input type="text" name="kontak_petugas" value="<?php echo $data['kontak_petugas']; ?>" placeholder="Kontak Petugas" required><br>
            <input type="text" name="instansi" value="<?php echo $data['instansi']; ?>" placeholder="Instansi" required><br>
            <button type="submit">Update Petugas</button>
        </form>
    </div>
</body>
</html>
