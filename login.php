<?php
session_start();

$timeout = 60; // 60 detik = 1 menit
$usernameBenar = "admin";
$passwordBenar = "12345";

// Logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// Cek timeout session
if (isset($_SESSION['last_activity'])) {
    if (time() - $_SESSION['last_activity'] > $timeout) {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
}

// Proses login
$pesan = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($username == $usernameBenar && $password == $passwordBenar) {
        $_SESSION['username'] = $username;
        $_SESSION['last_activity'] = time();
        header("Location: login.php");
        exit();
    } else {
        $pesan = "Username atau password salah!";
    }
}

// Update waktu aktivitas kalau sudah login
if (isset($_SESSION['username'])) {
    $_SESSION['last_activity'] = time();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Session</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: linear-gradient(to right, #c7f0d8, #dff5c8);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .box {
            background: white;
            padding: 30px;
            width: 380px;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #111;
        }

        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .input-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
        }

        .btn:hover {
            background: #43a047;
        }

        .logout-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 18px;
            background: #e53935;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        .logout-btn:hover {
            background: #c62828;
        }

        .pesan {
            color: red;
            margin-bottom: 15px;
        }

        .info {
            margin-top: 10px;
            color: #333;
            font-size: 14px;
        }
    </style>
</head>
<body>

<?php if (isset($_SESSION['username'])): ?>
    <div class="box">
        <h2>Dashboard</h2>
        <p>Selamat datang, <b><?php echo $_SESSION['username']; ?></b>!</p>
        <p class="info">Kamu berhasil login.</p>
        <a href="login.php?logout=true" class="logout-btn">Logout</a>
    </div>
<?php else: ?>
    <div class="box">
        <h2>Login User</h2>

        <?php if ($pesan != ""): ?>
            <div class="pesan"><?php echo $pesan; ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan Username" required>
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan Password" required>
            </div>

            <button type="submit" class="btn">Login</button>
        </form>
    </div>
<?php endif; ?>

</body>
</html>