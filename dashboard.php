
<?php 
    include "service/connect.php";
    session_start();

    if(isset($_POST['logout'])){
        session_unset();
        session_destroy();
        header('location: index.php');
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
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="close-sidebar" id="close-sidebar">&times;</div>
        <h2>Menu</h2>
        <a href="#">Home</a>
        <a href="#">Data</a>
        <button type="submit" name="logout" class="logout-btn" id="logout-btn">Logout</button>
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
            sidebar.classList.add('active');
            mainContent.classList.add('active');
        });

        closeSidebar.addEventListener('click', () => {
            sidebar.classList.remove('active');
            mainContent.classList.remove('active');
        });

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

            // Kirim request POST ke dashboard.php
            fetch("dashboard.php", {
                method: "POST",
                body: formData
            }).then(response => {
                if (response.ok) {
                    // Jika berhasil, redirect ke halaman login
                    window.location.href = "index.php";
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