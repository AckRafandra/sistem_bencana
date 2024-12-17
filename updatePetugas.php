<?php
include "koneksi.php"; // Menghubungkan ke database

// Pastikan ada parameter id di URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID Petugas tidak valid.");
}

$id_petugas = $_GET['id']; // Mendapatkan ID petugas dari URL

// Ambil data petugas berdasarkan ID
$query = $db->prepare("SELECT * FROM petugas WHERE id_petugas = ?");
$query->bind_param("i", $id_petugas); // Bind parameter untuk ID petugas
$query->execute();
$result = $query->get_result();
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_petugas = $_POST['nama_petugas'];
    $kontak_petugas = $_POST['kontak_petugas'];
    $instansi = $_POST['instansi'];

    // Menggunakan prepared statement untuk update data
    $updateQuery = $db->prepare("UPDATE petugas SET 
                                nama_petugas = ?, 
                                kontak_petugas = ?, 
                                instansi = ? 
                                WHERE id_petugas = ?");

    // Bind parameter yang sesuai: 3 string + 1 integer untuk id_petugas
    $updateQuery->bind_param("sssi", $nama_petugas, $kontak_petugas, $instansi, $id_petugas);

    if ($updateQuery->execute()) {
        header('Location: daftarPetugas.php'); // Redirect setelah berhasil update
        exit();
    } else {
        echo "Error: " . $db->error; // Menampilkan error jika update gagal
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Petugas</title>
</head>
<body>
    <h3>Update Data Petugas</h3>
    <form action="updatePetugas.php?id=<?php echo $id_petugas; ?>" method="POST">
        <label for="nama_petugas">Nama Petugas</label><br>
        <input type="text" name="nama_petugas" value="<?php echo htmlspecialchars($row['nama_petugas']); ?>" required><br>
        
        <label for="kontak_petugas">Kontak Petugas</label><br>
        <input type="text" name="kontak_petugas" value="<?php echo htmlspecialchars($row['kontak_petugas']); ?>" required><br>
        
        <label for="instansi">Instansi</label><br>
        <input type="text" name="instansi" value="<?php echo htmlspecialchars($row['instansi']); ?>" required><br>
        
        <button type="submit">Update Petugas</button>
    </form>
</body>
</html>
