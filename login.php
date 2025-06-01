<?php
ob_start();
session_start();
include 'db_connection.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = trim($_POST['role'] ?? '');

    if ($username === "" || $password === "" || $role === "") {
        $error = "Semua field (username, password, role) harus diisi.";
    } else {
        // Prepare statement
        $sql = "SELECT * FROM login WHERE username = ? AND role = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . htmlspecialchars($conn->error));
        }

        $stmt->bind_param("ss", $username, $role);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if ($password === $user['password']) { // Ganti sesuai kebutuhan password hash
                if ($user['role'] !== $role) {
                    $error = "Role tidak sesuai dengan akun.";
                } else {
                    // Simpan session user lengkap
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];

                    // Redirect sesuai role
                    if ($user['role'] === 'admin') {
                        header("Location: admin/dashboard.php");
                        exit();
                    } elseif ($user['role'] === 'user') {
                        header("Location: user/dashboard.php");
                        exit();
                    } else {
                        $error = "Role tidak dikenal.";
                    }
                }
            } else {
                $error = "Password salah.";
            }
        } else {
            $error = "User tidak ditemukan atau role salah.";
        }
        $stmt->close();
    }
    $conn->close();
}
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Login | Media Pembelajaran</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-box {
            background-color: white;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            width: 320px;
            text-align: center;
        }
        .login-box h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .login-box input[type="text"],
        .login-box input[type="password"],
        .login-box select {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s ease;
        }
        .login-box input[type="text"]:focus,
        .login-box input[type="password"]:focus,
        .login-box select:focus {
            border-color: #2575fc;
        }
        .login-box input[type="submit"] {
            background-color: #2575fc;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s ease;
            margin-top: 15px;
            width: 95%;
        }
        .login-box input[type="submit"]:hover {
            background-color: #1a5edb;
        }
        .error {
            color: red;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Login</h2>

        <?php if (!empty($error)) : ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" action="login.php" autocomplete="off">
            <input type="text" name="username" placeholder="Username" required autofocus value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"><br>
            <input type="password" name="password" placeholder="Password" required><br>
            
            <select name="role" required>
                <option value="">-- Pilih Role --</option>
                <option value="admin" <?= (($_POST['role'] ?? '') === 'admin') ? 'selected' : '' ?>>Admin</option>
                <option value="user" <?= (($_POST['role'] ?? '') === 'user') ? 'selected' : '' ?>>User</option>
            </select><br>

            <input type="submit" value="Login">
        </form>

        <div class="footer">
            &copy; <?= date("Y") ?> Media Pembelajaran
        </div>
    </div>
</body>
</html>