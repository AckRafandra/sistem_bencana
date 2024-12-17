<?php
    include "koneksi.php"; // Menghubungkan ke database
    session_start();

    // Ambil ID korban dari parameter URL
    $id_korban = $_GET['id'];

    // Ambil data korban berdasarkan ID
    $query = $db->prepare("SELECT * FROM korban WHERE id_korban = ?");
    $query->bind_param("i", $id_korban);
    $query->execute();
    $result = $query->get_result();
    $korban = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nik = $_POST['nik'];
        $id_bencana = $_POST['id_bencana'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $nama = $_POST['nama'];
        $asal = $_POST['asal'];
        $usia = $_POST['usia'];
        $status = $_POST['status'];
        $id_posko = $_POST['id_posko'];

        // Update data korban
        $updateQuery = $db->prepare("UPDATE korban SET nik = ?, id_bencana = ?, jenis_kelamin = ?, nama = ?, asal = ?, usia = ?, status = ?, id_posko = ? WHERE id_korban = ?");
        $updateQuery->bind_param("sisssisi", $nik, $id_bencana, $jenis_kelamin, $nama, $asal, $usia, $status, $id_posko, $id_korban);

        if ($updateQuery->execute()) {
            header("Location: daftarKorban.php");
            exit();
        } else {
            echo "Error: " . $db->error;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Korban</title>
</head>
<body>
    <form action="updateKorban.php?id=<?php echo $id_korban; ?>" method="POST">
        <input type="text" name="nik" value="<?php echo $korban['NIK']; ?>" required>
        <input type="number" name="id_bencana" value="<?php echo $korban['id_bencana']; ?>" required>
        <select name="jenis_kelamin" required>
            <option value="L" <?php if ($korban['jenis_kelamin'] == 'L') echo 'selected'; ?>>Laki-laki</option>
            <option value="P" <?php if ($korban['jenis_kelamin'] == 'P') echo 'selected'; ?>>Perempuan</option>
        </select>
        <input type="text" name="nama" value="<?php echo $korban['nama']; ?>" required>
        <input type="text" name="asal" value="<?php echo $korban['asal']; ?>" required>
        <input type="number" name="usia" value="<?php echo $korban['usia']; ?>" required>
        <input type="text" name="status" value="<?php echo $korban['status']; ?>" required>
        <input type="number" name="id_posko" value="<?php echo $korban['id_posko']; ?>" required>
        <button type="submit">Update Korban</button>
    </form>
</body>
</html>
