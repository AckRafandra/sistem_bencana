<?php 
$conn = new mysqli("localhost", "root", "", "db_bencana");
$query = $conn->query("SELECT * FROM posko");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Daftar Posko</title>
</head>
<body>
    <h2 style="text-align: center;">Daftar Posko</h2>
    <table border="1" style="width: 80%; margin: auto; text-align: center;">
        <tr>
            <th>ID Posko</th>
            <th>Nama Posko</th>
            <th>Penanggung Jawab</th>
            <th>Lokasi Posko</th>
            <th>Kontak Posko</th>
        </tr>
        <?php while ($row = $query->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id_posko']; ?></td>
            <td><?php echo $row['nama_posko']; ?></td>
            <td><?php echo $row['penanggung_jawab']; ?></td>
            <td><?php echo $row['lokasi_posko']; ?></td>
            <td><?php echo $row['kontak_posko']; ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
