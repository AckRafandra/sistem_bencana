<?php 
$conn = new mysqli("localhost", "root", "", "db_bencana");
$query = $conn->query("SELECT * FROM bencana");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Daftar Bencana</title>
</head>
<body>
    <h2 style="text-align: center;">Daftar Bencana</h2>
    <table border="1" style="width: 80%; margin: auto; text-align: center;">
        <tr>
            <th>ID Bencana</th>
            <th>Jenis Bencana</th>
            <th>status</th>
            <th>kronologi</th>
            <th>waktu_kejadian</th>
            <th>lokasi_kejadian</th>
        </tr>
        <?php while ($row = $query->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id_bencana']; ?></td>
            <td><?php echo $row['jenis_bencana']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td><?php echo $row['kronologi']; ?></td>
            <td><?php echo $row['waktu_kejadian']; ?></td>
            <td><?php echo $row['lokasi_kejadian']; ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
