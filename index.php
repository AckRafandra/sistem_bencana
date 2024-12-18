<?php
    require 'koneksi.php';
    $hasil = mysqli_query($db, "SELECT * FROM bencana ORDER BY id_bencana");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">

        <link href="custom.css" rel="stylesheet" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

        <!-- bootstrap -->
        <link rel="stylesheet" href="bootstrap.min.css">

        <!--Memuat file Bootstrap icon secara daring -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    </head>
    <body>
    <header class="header">
        <nav><a>Beranda</a>   </nav>
        <form action="logout.php" method="POST">
            <button type="submit" name="logout" class="logout-btn">Logout</button>
        </form>
    </header>
        <div class="container">
            <h1>Data Bencana</h1>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col" style="text-align-center">No</th>
                        <th scope="col" style="text-align-center">Bencana</th>
                        <th scope="col" style="text-align-center">Lokasi</th>
                        <th scope="col" style="text-align-center">Tanggal dan Waktu</th>
                        <th scope="col" style="text-align-center">Detail</th>
                    </tr>   
                </thead>
                <tbody>
                        
                    <tr>   
                        <?php
                            $no=1;
                            while($data = mysqli_fetch_array($hasil)) {
                                echo "<th>" .$no. "</th>";
                                echo "<td>".$data['nama_bencana']."</td>";
                                echo "<td>".$data['lokasi_kejadian']."</td>";
                                echo "<td>".$data['waktu_kejadian']."</td>";
                                echo "<td style='text-align:center'><a href='detail_bencana.php?id_bencana=$data[id_bencana]' class='btn btn-danger btn-sm'
                                title='lihat'>lihat</a></td></tr>";
                                $no++;
                            }
                        ?>
                        
                    </tr>
                </tbody>
                
            </table>
        </div>
    </body>
</html>