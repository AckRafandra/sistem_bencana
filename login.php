<?php
include "koneksi.php";
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Menggunakan prepared statement untuk mencegah SQL injection
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Memeriksa apakah username dan password cocok
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Menyimpan data ke dalam session
        $_SESSION["id_user"] = $row["id_user"];
        $_SESSION["username"] = $row["username"];
        $_SESSION["role"] = $row["role"];
        $_SESSION["is_login"] = true;

        // Menyimpan waktu login ke dalam session
        date_default_timezone_set('Asia/Jakarta');
        $last_login = date("Y-m-d H:i:s");
        $_SESSION["last_login"] = $last_login;

        // Update last_login pada tabel users
        $update_stmt = $db->prepare("UPDATE users SET last_login = ? WHERE id_user = ?");
        $update_stmt->bind_param("si", $last_login, $row["id_user"]);
        $update_stmt->execute();

        // Redirect berdasarkan role
        if ($row['role'] === 'admin') {
            header("Location: beranda.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Rescue-Net</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
        }
        .header {
            background: rgb(15, 47, 103);
            color: white;
            padding: 10px 0;
            text-align: center;
            font-size: 1.5rem;
        }
        .login-container {
            background-color: white;
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        h2 {
            text-align: center;
            color: #002855;
        }
        label {
            font-weight: bold;
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #002855;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #00509d;
        }
        .error {
            color: red;
            font-size: 0.9rem;
            text-align: center;
            margin-top: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.8rem;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="header">
        <strong>Rescue-Net</strong>
    </div>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form action="login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" placeholder="Masukkan username" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Masukkan password" required>
            
            <button type="submit" name="login">Login</button>
        </form>
    </div>
    <div class="footer">
        &copy; 2024 Rescue-Net. Semua Hak Dilindungi.
    </div>
</body>
</html>
