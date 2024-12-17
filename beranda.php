<?php 
    include "koneksi.php"; // Menggunakan koneksi dengan $db
    session_start();

    // Logout dan kirimkan ke tabel user
    if (isset($_POST['logout'])) {
        $user_id = $_SESSION['user_id']; // Asumsikan ada user_id di session
        $logout_time = date('Y-m-d H:i:s'); // Waktu logout

        // Menyimpan data logout ke tabel 'user'
        date_default_timezone_set('Asia/Jakarta');
        $query = $db->prepare("UPDATE user SET last_logout = ? WHERE id_user = ?");
        $query->bind_param("si", $logout_time, $user_id);
        if ($query->execute()) {
            // Hapus session dan logout
            session_unset();
            session_destroy();
            header('Location: login.php'); // Redirect ke halaman login
            exit();
        } else {
            echo "Error: " . $db->error;
        }
    }

    // Query untuk chart 1: Jumlah Bencana berdasarkan Jenis Bencana
    $query1 = $db->query("SELECT jenis_bencana, COUNT(*) AS total FROM bencana GROUP BY jenis_bencana");
    $chart1_labels = [];
    $chart1_data = [];

    while ($row = $query1->fetch_assoc()) {
        $chart1_labels[] = $row['jenis_bencana'];
        $chart1_data[] = $row['total'];
    }

    // Query untuk chart 2: Jumlah Korban berdasarkan Daerah
    $query2 = $db->query("SELECT asal, COUNT(*) AS total FROM korban GROUP BY asal");
    $chart2_labels = [];
    $chart2_data = [];

    while ($row = $query2->fetch_assoc()) {
        $chart2_labels[] = $row['asal'];
        $chart2_data[] = $row['total'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

        .graph-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }
        .graph {
            flex: 1 1 calc(50% - 20px);    
            background: #fff;
            border-radius: 8px;
            padding: 10px;
            color: #000;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            width: auto;
            height: 400px;
        }
        .graph canvas {
            width: auto; 
            height: 370px;   
        }
        /* Card Section */
        .card-container {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        .card {
            background: rgb(15, 47, 103);
            flex: 1;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        .card h3 {
            color: #1F80C0;
            margin-bottom: 10px;
        }
        .card p {
            font-size: 28px;
            font-weight: bold;
            color: #E8EEF1;
        }
        #chart1{
        width: 95%;
        height: auto;
        }
        #chart2{
        width: 350px;
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
        <button type="submit" name="logout" class="logout-btn" id="logout-btn">Logout</button>
    </div>

    <!-- Notifikasi -->
    <div id="notification" class="notification">
        <p id="notif-message">Logout berhasil!</p>
    </div>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="menu-btn" id="menu-btn">&#9776;</div>
        <h2>Dashboard Admin</h2>
    </nav>

    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <h3>Statistik Grafik</h3>
        
        <!-- Card Section -->
        <div class="card-container">
            <div class="card">
                <h3>Total Bencana</h3>
                <?php
                $result = $db->query("SELECT COUNT(*) AS total FROM bencana");
                if ($result) {
                    $row = $result->fetch_assoc();
                    echo "<p>" . $row['total'] . "</p>";
                } else {
                    echo "<p>Error: " . $db->error . "</p>";
                }
                ?>         
            </div>
            <div class="card">
                <h3>Total Korban</h3>
                <?php
                $result = $db->query("SELECT COUNT(*) AS total FROM korban");
                if ($result) {
                    $row = $result->fetch_assoc();
                    echo "<p>" . $row['total'] . "</p>";
                } else {
                    echo "<p>Error: " . $db->error . "</p>";
                }
                ?>
            </div>
            <div class="card">
                <h3>Total Posko</h3>
                <?php
                $result = $db->query("SELECT COUNT(DISTINCT id_posko) AS total FROM posko");
                if ($result) {
                    $row = $result->fetch_assoc();
                    echo "<p>" . $row['total'] . "</p>";
                } else {
                    echo "<p>Error: " . $db->error . "</p>";
                }
                ?>
            </div>
        </div>

        <!-- Graphs in two columns -->
        <div class="graph-container">
            <div class="graph">
                <h4>Jumlah Bencana Berdasarkan Jenis Bencana</h4>
                <canvas id="chart1"></canvas>
            </div>
            <div class="graph">
                <h4>Jumlah Korban Berdasarkan Daerah</h4>
                <canvas id="chart2"></canvas>
            </div>
        </div>
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

        // Fungsi untuk menampilkan notifikasi
        function showNotification(message, type) {
            const notif = document.getElementById("notification");
            const notifMessage = document.getElementById("notif-message");

            // Menyesuaikan jenis notifikasi (sukses atau error)
            notif.classList.remove("error", "show");
            if (type === "error") {
                notif.classList.add("error");
            }
            notif.classList.add("show");
            notifMessage.textContent = message;

            // Hapus notifikasi setelah 3 detik
            setTimeout(() => {
                notif.classList.remove("show");
            }, 3000);
        }

        const chart1Labels = <?php echo json_encode($chart1_labels); ?>;
        const chart1Data = <?php echo json_encode($chart1_data); ?>;

        const chart2Labels = <?php echo json_encode($chart2_labels); ?>;
        const chart2Data = <?php echo json_encode($chart2_data); ?>;

        // Grafik 1: Jumlah Bencana Berdasarkan Jenis Bencana
        const ctx1 = document.getElementById('chart1').getContext('2d');
        const chart1 = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: chart1Labels,
                datasets: [{
                    label: 'Jumlah Bencana',
                    data: chart1Data,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Grafik 2: Jumlah Korban Berdasarkan Daerah
        const ctx2 = document.getElementById('chart2').getContext('2d');
        const chart2 = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: chart2Labels,
                datasets: [{
                    label: 'Jumlah Korban',
                    data: chart2Data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 159, 64, 0.6)'
                    ]
                }]
            },
            options: {
                responsive: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        document.getElementById("logout-btn").addEventListener("click", function() {
            if (confirm("Apakah Anda yakin ingin logout?")) {
                // Buat objek FormData untuk mengirim data POST
                const formData = new FormData();
                formData.append("logout", true);
                // Kirim request POST ke beranda.php
                fetch("beranda.php", {
                    method: "POST",
                    body: formData
                }).then(response => {
                    if (response.ok) {
                        // Jika berhasil, redirect ke halaman login
                        window.location.href = "login.php";
                    } else {
                        alert("Logout gagal. Silakan coba lagi.");
                    }
                }).catch(error => {
                    console.error("Error:", error);
                    alert("Terjadi kesalahan. Silakan coba lagi.");
                });
            }
        });
    </script>
</body>
</html>
