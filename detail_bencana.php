<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bencana</title>

    <link rel="stylesheet" href="bootstrap.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <?php
        require 'koneksi.php';
        $id_bencana = $_GET['id_bencana'];
        $hasil = mysqli_query($db, "SELECT * FROM bencana WHERE id_bencana = $id_bencana ");

        while ($data = mysqli_fetch_array($hasil)) {
            $nama_bencana = $data['nama_bencana'];
            $jenis_bencana = $data['jenis_bencana'];
            $status = $data['status'];
            $kronologi = $data['kronologi'];
            $lokasi = $data['lokasi_kejadian'];
            $waktu = $data['waktu_kejadian'];
        }

        // $korban = mysqli_query($db, "SELECT * FROM korban WHERE id_bencana = $id_bencana ");

        $korban = mysqli_query($db, "SELECT korban.*, posko.nama_posko FROM korban LEFT JOIN posko ON korban.id_posko = posko.id_posko WHERE id_bencana = $id_bencana");
 
        $jumlah_korban = mysqli_query($db, "SELECT COUNT(id_korban) AS total FROM korban WHERE id_bencana = $id_bencana");
        $row = mysqli_fetch_assoc($jumlah_korban);
        $jumlah = $row['total'];

        $posko = mysqli_query($db, "SELECT * FROM posko WHERE id_posko in (select id_posko from bertugas  WHERE id_petugas in (select id_petugas from menangani  WHERE id_bencana = $id_bencana)) ");

        $petugas = mysqli_query($db, "SELECT * FROM petugas WHERE id_petugas in (select id_petugas from menangani  WHERE id_bencana = $id_bencana) ");

        
    ?>

</head>
<body>
<header class="header">
        <nav><a href="index.php">Beranda</a>   </nav>
        <form action="logout.php" method="POST">
            <button type="submit" name="logout" class="logout-btn">Logout</button>
        </form>
</header>
<div class="container">
    <h1><?php echo $nama_bencana;?></h1>
    <div class="card-container">
        <div class="card">
        <h5><?php echo "Kronologi : ", $kronologi;?></h5>
        <h5><?php echo "Lokasi : ", $lokasi;?></h5>
        <h5><?php echo "Tanggal dan Waktu : ", $waktu;?></h5>
        <h5><?php echo "Status Bencana : ", $status;?></h5>
        <h5><?php echo "Jumlah Korban : ",$jumlah;?></h5>
        </div>
    </div>


    <h3>Daftar Korban</h3>
    <table class="table table-hover">
        <thead>
            <th scope="col" style="text-align-center">No</th>
            <th scope="col" style="text-align-center">Nama</th>
            <th scope="col" style="text-align-center">Asal</th>
            <th scope="col" style="text-align-center">Jenis Kelamin</th>
            <th scope="col" style="text-align-center">Usia</th>
            <th scope="col" style="text-align-center">Status</th>
            <th scope="col" style="text-align-center">Lokasi</th>
        </thead>
        <tbody>
            <tr>
                <?php
                $no=1;
                while($data2 = mysqli_fetch_array($korban)) {
                    echo "<th>" .$no. "</th>";
                    echo "<td>".$data2['nama']."</td>";
                    echo "<td>".$data2['asal']."</td>";
                    echo "<td>".$data2['jenis_kelamin']."</td>";
                    echo "<td>".$data2['usia']."</td>";
                    echo "<td>".$data2['status']."</td>";
                    echo "<td>".$data2['nama_posko']."</td></tr>";
                    $no++;
                }
                
                ?>
            </tr>
        </tbody>
    </table>


    <h3>Posko Bencana</h3>
    <table class="table table-hover">
        <thead>
            <th scope="col" style="text-align-center">no</th>
            <th scope="col" style="text-align-center">Nama Posko</th>
            <th scope="col" style="text-align-center">Lokasi Posko</th>
            <th scope="col" style="text-align-center">Penanggung jawab</th>
            <th scope="col" style="text-align-center">Kontak Posko</th>
        </thead>
        <tbody>
            <tr>
                <?php
                $no=1;
                while($data4 = mysqli_fetch_array($posko)) {
                    echo "<th>" .$no. "</th>";
                    echo "<td>".$data4['nama_posko']."</td>";
                    echo "<td>".$data4['lokasi_posko']."</td>";
                    echo "<td>".$data4['penanggung_jawab']."</td>";
                    echo "<td>".$data4['kontak_posko']."</td></tr>";
                    $no++;
                }
                
                ?>
            </tr>
        </tbody>
    </table>
</div>
</body>
</html>