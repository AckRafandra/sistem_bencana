<?php
include "koneksi.php"; // Menghubungkan ke database

// Pastikan ada parameter id di URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID Bencana tidak valid.");
}

$id_bencana = $_GET['id']; // Mendapatkan ID bencana dari URL

// Ambil data bencana berdasarkan ID
$query = $db->prepare("SELECT * FROM bencana WHERE id_bencana = ?");
$query->bind_param("i", $id_bencana); // Bind parameter untuk ID bencana
$query->execute();
$result = $query->get_result();
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_bencana = $_POST['nama_bencana'];
    $jenis_bencana = $_POST['jenis_bencana'];
    $status = $_POST['status'];
    $kronologi = $_POST['kronologi'];
    $waktu_kejadian = $_POST['waktu_kejadian'];
    $lokasi_kejadian = $_POST['lokasi_kejadian'];

    // Menggunakan prepared statement untuk update data
$updateQuery = $db->prepare("UPDATE bencana SET 
                           nama_bencana = ?, 
                           jenis_bencana = ?, 
                           status = ?, 
                           kronologi = ?, 
                           waktu_kejadian = ?, 
                           lokasi_kejadian = ? 
                           WHERE id_bencana = ?");

// Bind parameter yang sesuai: 6 string + 1 integer untuk id_bencana
$updateQuery->bind_param("ssssssi", $nama_bencana, $jenis_bencana, $status, $kronologi, $waktu_kejadian, $lokasi_kejadian, $id_bencana);

    if ($updateQuery->execute()) {
        header('Location: daftarBencana.php'); // Redirect setelah berhasil update
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
    <title>Update Bencana</title>
</head>
<body>
    <h3>Update Data Bencana</h3>
    <form action="updateBencana.php?id=<?php echo $id_bencana; ?>" method="POST">
        <label for="nama_bencana">Nama Bencana</label><br>
        <input type="text" name="nama_bencana" value="<?php echo htmlspecialchars($row['nama_bencana']); ?>" required><br>
        
        <label for="jenis_bencana">Jenis Bencana</label><br>
        <input type="text" name="jenis_bencana" value="<?php echo htmlspecialchars($row['jenis_bencana']); ?>" required><br>
        
        <label for="status">Status</label><br>
        <input type="text" name="status" value="<?php echo htmlspecialchars($row['status']); ?>" required><br>
        
        <label for="kronologi">Kronologi</label><br>
        <textarea name="kronologi" required><?php echo htmlspecialchars($row['kronologi']); ?></textarea><br>
        
        <label for="waktu_kejadian">Waktu Kejadian</label><br>
        <input type="datetime-local" name="waktu_kejadian" value="<?php echo date('Y-m-d\TH:i', strtotime($row['waktu_kejadian'])); ?>" required><br>
        
        <label for="lokasi_kejadian">Lokasi Kejadian</label><br>
        <input type="text" name="lokasi_kejadian" value="<?php echo htmlspecialchars($row['lokasi_kejadian']); ?>" required><br>
        
        <button type="submit">Update Bencana</button>
    </form>
</body>
</html>
