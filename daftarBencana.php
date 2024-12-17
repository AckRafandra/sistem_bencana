<?php
    include "koneksi.php"; // Menghubungkan ke database
    session_start();

    // Menampilkan data bencana
    $query = "SELECT * FROM bencana ORDER BY id_bencana ASC";
    $result = $db->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Bencana</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- CSS Styling -->
    <style>
        @media screen and (max-width: 768px) {
            .graph-container {
                flex-direction: column;
                align-items: center;
            }
            .graph {
                width: 100%;
                max-width: 100%;
                margin-bottom: 20px;
            }
        }
        * {
            margin: 0;
            padding: 0;
            color: black;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            min-height: 100vh;
            background-color: rgb(5, 31, 60);
            color: #fff;
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: -220px;
            width: 220px;
            height: 100%;
            background: rgb(15, 47, 103);
            transition: all 0.3s ease;
            z-index: 1000;
            padding: 20px;
        }
        .sidebar.active {
            left: 0;
        }
        .sidebar h2 {
            color: #E8EEF1;
            margin-bottom: 20px;
        }
        .sidebar a {
            display: block;
            text-decoration: none;
            color: #E8EEF1;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .sidebar a:hover {
            background: #1F80C0;
        }
        .sidebar .close-sidebar {
            text-align: right;
            cursor: pointer;
            font-size: 20px;
            color: #E8EEF1;
            margin-bottom: 10px;
        }
        h2 {
            color: #333;
            margin: 20px 0;
        }
        h3 {
            color: white;
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgb(15, 47, 103);
            padding: 10px 20px;
            width: 100%;
            position: fixed;
            z-index: 999;
        }
        .navbar h2 {
            color: #E8EEF1;
        }
        .navbar .menu-btn {
            font-size: 20px;
            cursor: pointer;
            color: #E8EEF1;
        }
        
        /* Tombol Logout */
        .logout-btn {
            background-color: #1F80C0;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .logout-btn:hover {
            background-color: #1683b0;
            transform: scale(1.05);
        }

        .logout-btn:focus {
            outline: none;
        }
        /* Notifikasi */
        .notification {
            display: none;
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            transition: opacity 0.5s ease-in-out;
        }

        .notification.error {
            background-color: #dc3545;
        }

        .notification.show {
            display: block;
            opacity: 1;
        }

        /* Animasi keluar untuk notifikasi */
        @keyframes slide-in {
            from {
                bottom: -50px;
                opacity: 0;
            }
            to {
                bottom: 20px;
                opacity: 1;
            }
        }

        @keyframes slide-out {
            from {
                bottom: 20px;
                opacity: 1;
            }
            to {
                bottom: -50px;
                opacity: 0;
            }
        }

        /* Main Content */
        .main-content {
            margin-left: 0;
            margin-top: 60px;
            padding: 20px;
            flex: 1;
            transition: margin-left 0.3s ease;
        }
        .main-content.active {
            margin-left: 220px;
        }

        /* Styling Form */
        .form-container {
            margin-bottom: 40px;
            padding: 25px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
        }

        .form-container h3 {
            font-size: 24px;
            margin-bottom: 15px;
        }

        .form-container input,
        .form-container select {
            padding: 12px;
            margin: 10px 0;
            width: 100%;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 16px;
            box-sizing: border-box;
        }

        .form-container button {
            background-color: #1F80C0;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .form-container button:hover {
            background-color: #1683b0;
        }

        /* Styling Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 12px;
            text-align: center;
            font-size: 16px;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #1F80C0;
            color: black;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color:rgb(255, 255, 255);
        }

        table tr:hover {
            background-color:rgb(92, 154, 220);
        }

        table a {
            color: #1F80C0;
            text-decoration: none;
        }

        table a:hover {
            text-decoration: underline;
        }

        /* Styling untuk Tautan Aksi */
        td a {
            margin: 0 10px;
            font-weight: bold;
        }

        /* Responsivitas */
        @media (max-width: 768px) {
            table, .form-container {
                width: 100%;
                padding: 15px;
            }

            .form-container input,
            .form-container select,
            .form-container button {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="close-sidebar" id="close-sidebar">&times;</div>
        <h2>Menu</h2>
        <a href="beranda.php">Beranda</a>
        <a href="daftarKorban.php">Daftar Korban</a>
        <a href="daftarBencana.php">Daftar Bencana</a>
        <a href="daftarPetugas.php">Daftar Petugas</a>
        <a href="daftarPosko.php">Daftar Posko</a>
        <a href="daftarKeluarga.php">Daftar Keluarga</a>
        <form action="logout.php" method="POST">
            <button type="submit" name="logout" class="logout-btn">Logout</button>
        </form>
    </div>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="menu-btn" id="menu-btn">&#9776;</div>
        <h2>Dashboard Admin</h2>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Form Tambah Bencana -->
        <div class="form-container">
            <h4>Tambah Bencana</h4>
            <form action="tambah_bencana.php" method="POST">
                <input type="text" name="nama_bencana" placeholder="Nama Bencana" required>
                <input type="text" name="jenis_bencana" placeholder="Jenis Bencana" required>
                <input type="text" name="status" placeholder="Status" required>
                <input name="kronologi" placeholder="Kronologi" required></input>
                <input type="datetime-local" name="waktu_kejadian" placeholder="Waktu Kejadian" required>
                <input type="text" name="lokasi_kejadian" placeholder="Lokasi Kejadian" required>
                <button type="submit">Tambah Bencana</button>
            </form>
        </div>

        <!-- Tabel Daftar Bencana -->
        <h3>Daftar Bencana</h3>
        <table>
            <thead>
                <tr>
                    <th>ID Bencana</th>
                    <th>Nama Bencana</th>
                    <th>Jenis Bencana</th>
                    <th>Status</th>
                    <th>Kronologi</th>
                    <th>Waktu Kejadian</th>
                    <th>Lokasi Kejadian</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if ($result) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id_bencana'] . "</td>";
                            echo "<td>" . $row['nama_bencana'] . "</td>";
                            echo "<td>" . $row['jenis_bencana'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "<td>" . $row['kronologi'] . "</td>";
                            echo "<td>" . $row['waktu_kejadian'] . "</td>";
                            echo "<td>" . $row['lokasi_kejadian'] . "</td>";
                            echo "<td><a href='updateBencana.php?id=" . $row['id_bencana'] . "'>Update</a> | 
                                  <a href='hapusBencana.php?id=" . $row['id_bencana'] . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus?\")'>Delete</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>Tidak ada data bencana.</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Chart.js Scripts -->
    <script>
        // Sidebar toggle
        const menuBtn = document.getElementById('menu-btn');
        const closeSidebar = document.getElementById('close-sidebar');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');

        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            mainContent.classList.toggle('active');
        });

        closeSidebar.addEventListener('click', () => {
            sidebar.classList.remove('active');
            mainContent.classList.remove('active');
        });

    </script>
</body>
</html>
