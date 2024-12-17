<?php 
// Koneksi Database
$dsn = "mysql:host=localhost;dbname=db_bencana;charset=utf8mb4";
$username = "root";
$password = "";

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi Gagal: " . $e->getMessage());
}

// CREATE: Tambah Data Korban
if (isset($_POST['create'])) {
    $NIK = $_POST['NIK'];
    $id_bencana = $_POST['id_bencana'];
    $nama = $_POST['nama'];
    $usia = $_POST['usia'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $asal = $_POST['asal'];
    $status = $_POST['status'];
    $id_posko = $_POST['id_posko'];

    $stmt = $conn->prepare("INSERT INTO korban (NIK, id_bencana, nama, usia, jenis_kelamin, asal, status, id_posko) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$NIK, $id_bencana, $nama, $usia, $jenis_kelamin, $asal, $status, $id_posko]);
    header("Location: daftarKorban.php");
    exit();
}

// Ambil semua data korban
$query = $conn->query("SELECT * FROM korban ORDER BY NIK ASC");
$korban = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Korban</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Chart.js & DataTables -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <style>
        /* General */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0; padding: 0; box-sizing: border-box;
            background: rgb(5, 31, 60);
            color: #fff;
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgb(15, 47, 103);
            padding: 10px 20px;
            position: sticky;
            z-index: 1000;
            top: 0; z-index: 1000;
        }
        .navbar h2 { color: #E8EEF1; }
        .menu-btn { 
            color: #E8EEF1; 
            font-size: 24px; 
            cursor: pointer; 
        }

        /* Sidebar */
        .sidebar {
            position: fixed; left: -250px; top: 0;
            width: 250px; height: 100%;
            background: rgb(15, 47, 103);
            color: #fff; padding: 20px;
            transition: all 0.3s ease-in-out;
            z-index: 999;
            overflow-y: auto;
        }
        .sidebar.active {
            z-index: 9999;
            left: 0; 
        }
        .sidebar h3 { text-align: center; color: #E8EEF1; }
        .sidebar a {
            color: white; text-decoration: none; display: block;
            margin: 15px 0; transition: color 0.3s ease;
        }
        .sidebar a:hover { color: rgb(255, 200, 0); }

        .sidebar #close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 28px;
            color: #fff;
            cursor: pointer;
        }
        .sidebar #close-btn:hover { color: rgb(255, 200, 0); }

        /* Main Content */
        .content {
            padding: 20px;
            margin-left: 0; 
            transition: margin-left 0.3s ease-in-out;
        }
        .content.shift { margin-left: 250px; }

        /* Form */
        .form-container {
            background: #f4f4f4; color: #333;
            padding: 15px; border-radius: 5px;
            margin-bottom: 20px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        .form-container input, .form-container select, .form-container button {
            margin: 8px 0;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
        }

        /* Table */
        table {
            background: white; width: 100%;
            text-align: center; color: #333;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            padding: 12px; border: 1px solid #ddd;
        }
        table th {
            background-color: rgb(15, 47, 103);
            color: white;
        }

        /* Buttons */
        button {
            padding: 10px;
            background-color: rgb(15, 47, 103);
            border: none;
            color: white;
            cursor: pointer;
        }
        button:hover { background-color: rgb(0, 28, 63); }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="menu-btn" id="menu-btn">&#9776;</div>
        <h2>Daftar Korban</h2>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <span id="close-btn">&times;</span>
        <h3>Menu</h3>
        <a href="beranda.php">Beranda</a>
        <a href="daftarKorban.php">Daftar Korban</a>
        <a href="daftarBencana.php">Daftar Bencana</a>
        <a href="daftarPetugas.php">Daftar Petugas</a>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="content" id="content">
        <!-- Form Tambah -->
        <div class="form-container">
            <h4>Tambah Korban Baru</h4>
            <form method="POST">
                <input type="text" name="NIK" placeholder="NIK" required>
                <input type="text" name="id_bencana" placeholder="ID Bencana" required>
                <input type="text" name="nama" placeholder="Nama" required>
                <input type="number" name="usia" placeholder="Usia" required>
                <select name="jenis_kelamin" required>
                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                    <option value="Laki-Laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
                <input type="text" name="asal" placeholder="Asal" required>
                <input type="text" name="status" placeholder="Status" required>
                <input type="text" name="id_posko" placeholder="ID Posko" required>
                <button type="submit" name="create">Tambah</button>
            </form>
        </div>

        <!-- Tabel Data -->
        <table id="korbanTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Usia</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($korban as $row): ?>
                    <tr>
                        <td><?= $row['id_korban'] ?></td>
                        <td><?= $row['NIK'] ?></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['usia'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Script -->
    <script>
        const menuBtn = document.getElementById('menu-btn');
        const closeBtn = document.getElementById('close-btn');
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');

        menuBtn.addEventListener('click', () => {
            sidebar.classList.add('active');
            content.classList.add('shift');
        });

        closeBtn.addEventListener('click', () => {
            sidebar.classList.remove('active');
            content.classList.remove('shift');
        });
    </script>
</body>
</html>
