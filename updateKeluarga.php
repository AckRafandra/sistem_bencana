<?php
include "koneksi.php"; // Menghubungkan ke database

// Pastikan ada parameter 'id' di URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("NIK tidak valid.");
}

$NIK = $_GET['id']; // Mendapatkan NIK dari URL

// Ambil data keluarga berdasarkan NIK
$query = $db->prepare("SELECT * FROM keluarga WHERE NIK = ?");
$query->bind_param("s", $NIK); // Bind parameter untuk NIK
$query->execute();
$result = $query->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("Data keluarga tidak ditemukan.");
}

// Proses update ketika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomor_telepon = $_POST['nomor_telepon'];
    $hubungan = $_POST['hubungan'];
    $nik_keluarga = $_POST['nik_keluarga'];

    // Query untuk mengupdate data keluarga dengan prepared statement
    $updateQuery = $db->prepare("UPDATE keluarga 
                                 SET nomor_telepon = ?, hubungan = ?, nik_keluarga = ? 
                                 WHERE NIK = ?");
    $updateQuery->bind_param("ssss", $nomor_telepon, $hubungan, $nik_keluarga, $NIK);

    if ($updateQuery->execute()) {
        // Setelah sukses, redirect ke halaman daftar keluarga
        header('Location: daftarKeluarga.php');
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
    <title>Update Data Keluarga</title>
</head>
<body>
    <h3>Update Data Keluarga</h3>
    <form action="updateKeluarga.php?id=<?php echo $NIK; ?>" method="POST">
        <input type="hidden" name="NIK" value="<?php echo htmlspecialchars($row['NIK']); ?>" required><br>
        <input type="text" name="nomor_telepon" value="<?php echo htmlspecialchars($row['nomor_telepon']); ?>" placeholder="Nomor Telepon" required><br>
        <input type="text" name="hubungan" value="<?php echo htmlspecialchars($row['hubungan']); ?>" placeholder="Hubungan" required><br>
        <input type="text" name="nik_keluarga" value="<?php echo htmlspecialchars($row['nik_keluarga']); ?>" placeholder="Nomor KK" required><br>
        <button type="submit">Update Data</button>
    </form>
</body>
</html>
