<?php 
include "koneksi.php"; 
session_start();

if (isset($_GET['id'])) {
    $id_posko = $_GET['id'];

    // Ambil data posko berdasarkan ID
    $query = "SELECT * FROM posko WHERE id_posko = $id_posko";
    $result = $db->query($query);
    $data = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_posko = $_POST['id_posko'];
    $nama_posko = $_POST['nama_posko'];
    $penanggung_jawab = $_POST['penanggung_jawab'];
    $lokasi_posko = $_POST['lokasi_posko'];
    $kontak_posko = $_POST['kontak_posko'];

    // Query untuk update data posko
    $query = "UPDATE posko 
              SET nama_posko = '$nama_posko', penanggung_jawab = '$penanggung_jawab', 
                  lokasi_posko = '$lokasi_posko', kontak_posko = '$kontak_posko' 
              WHERE id_posko = $id_posko";

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
    <title>Update Posko</title>
</head>
<body>
    <h3>Update Posko</h3>
    <form action="updatePosko.php" method="POST">
        <input type="hidden" name="id_posko" value="<?php echo $data['id_posko']; ?>">
        <input type="text" name="nama_posko" value="<?php echo $data['nama_posko']; ?>" required><br>
        <input type="text" name="penanggung_jawab" value="<?php echo $data['penanggung_jawab']; ?>" required><br>
        <input type="text" name="lokasi_posko" value="<?php echo $data['lokasi_posko']; ?>" required><br>
        <input type="text" name="kontak_posko" value="<?php echo $data['kontak_posko']; ?>" required><br>
        <button type="submit">Update Posko</button>
    </form>
</body>
</html>
