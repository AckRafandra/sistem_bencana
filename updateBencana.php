<?php
include "koneksi.php"; // Menghubungkan ke database

$id_bencana = $_GET['id']; // Mendapatkan ID bencana dari URL

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_bencana = $_POST['nama_bencana'];
    $jenis_bencana = $_POST['jenis_bencana'];
    $status = $_POST['status'];
    $kronologi = $_POST['kronologi'];
    $waktu_kejadian = $_POST['waktu_kejadian'];
    $lokasi_kejadian = $_POST['lokasi_kejadian'];

    $query = "UPDATE bencana SET 
                nama_bencana = '$nama_bencana', 
                jenis_bencana = '$jenis_bencana', 
                status = '$status', 
                kronologi = '$kronologi', 
                waktu_kejadian = '$waktu_kejadian', 
                lokasi_kejadian = '$lokasi_kejadian' 
              WHERE id_bencana = $id_bencana";

    if ($db->query($query)) {
        header('Location: daftarBencana.php');
    } else {
        echo "Error: " . $db->error;
    }
} else {
    $query = "SELECT * FROM bencana WHERE id_bencana = $id_bencana";
    $result = $db->query($query);
    $row = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Bencana</title>
</head>
<body>
    <h3>Update Data Bencana</h3>
    <form action="update_bencana.php?id=<?php echo $id_bencana; ?>" method="POST">
        <input type="text" name="nama_bencana" value="<?php echo $row['nama_bencana']; ?>" required><br>
        <input type="text" name="jenis_bencana" value="<?php echo $row['jenis_bencana']; ?>" required><br>
        <input type="text" name="status" value="<?php echo $row['status']; ?>" required><br>
        <textarea name="kronologi" required><?php echo $row['kronologi']; ?></textarea><br>
        <input type="datetime-local" name="waktu_kejadian" value="<?php echo date('Y-m-d\TH:i', strtotime($row['waktu_kejadian'])); ?>" required><br>
        <input type="text" name="lokasi_kejadian" value="<?php echo $row['lokasi_kejadian']; ?>" required><br>
        <button type="submit">Update Bencana</button>
    </form>
</body>
</html>
