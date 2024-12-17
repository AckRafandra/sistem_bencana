<?php
    include "koneksi.php";
    session_start();

    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";

        $result = $db->query($sql);

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();

            $_SESSION["username"] = $row["username"];
            $_SESSION["is_login"] = true;

            header("location: dashboard.php");
        }else{
            echo"akun tidak ditemukan";
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
        /* Reset styling */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
        }

        /* Header styling */
        .header {
            background: rgb(15, 47, 103);
            color: white;
            padding: 10px 0;
            text-align: center;
            font-size: 1.5rem;
        }

        /* Login container styling */
        .login-container {
            background-color: white;
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Form styling */
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

        /* Footer styling */
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.8rem;
            color: #555;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <strong>Rescue-Net</strong>
    </div>
    <!-- Login Form -->
    <div class="login-container">
        <h2>Login</h2>
        <form action="index.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" placeholder="Masukkan username" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Masukkan password" required>
            
            <button type="submit" name="login">Login</button>
        </form>
    </div>
    <!-- Footer -->
    <div class="footer">
        &copy; 2024 Rescue-Net. Semua Hak Dilindungi.
    </div>
</body>
</html>
