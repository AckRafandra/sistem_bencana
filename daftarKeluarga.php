<?php 
$conn = new mysqli("localhost", "root", "", "db_bencana");
$query = $conn->query("SELECT * FROM keluarga");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Daftar Keluarga</title>
</head>
<body>
    <h2 style="text-align: center;">Daftar Keluarga</h2>
    <table border="1" style="width: 80%; margin: auto; text-align: center;">
        <tr>
            <th>NIK</th>
            <th>Nomor Telepon</th>
            <th>Hubungan</th>
            <th>Nomor Kartu Keluaga</th>
        </tr>
        <?php while ($row = $query->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['NIK']; ?></td>
            <td><?php echo $row['nomor_telepon']; ?></td>
            <td><?php echo $row['hubungan']; ?></td>
            <td><?php echo $row['nik_keluarga']; ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
