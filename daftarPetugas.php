<?php 
$conn = new mysqli("localhost", "root", "", "db_bencana");
$query = $conn->query("SELECT * FROM petugas");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Daftar Petugas</title>
</head>
<body>
    <h2 style="text-align: center;">Daftar Petugas</h2>
    <table border="1" style="width: 80%; margin: auto; text-align: center;">
        <tr>
            <th>ID Petugas</th>
            <th>Nama Petugas</th>
            <th>kontak Petugas</th>
            <th>Instansi</th>
        </tr>
        <?php while ($row = $query->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id_petugas']; ?></td>
            <td><?php echo $row['nama_petugas']; ?></td>
            <td><?php echo $row['kontak_petugas']; ?></td>
            <td><?php echo $row['instansi']; ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
