<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

require_once "connection.php";

$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("sss", $full_name, $email, $hashed_password);

    if ($stmt->execute()) {
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['full_name'] = $full_name;
        $success_message = "Akun berhasil dibuat!";
        // Redirect to dashboard after showing the alert
        echo '<script>window.location.href = "dashboard.php";</script>';
        exit;
    } else {
        $error_message = "Terjadi kesalahan saat melakukan registrasi.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Registrasi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="register-container">
        <h2>Halaman Registrasi</h2>
        <form method="post">
            <div>
                <label for="full_name">Nama Lengkap:</label>
                <input type="text" id="full_name" name="full_name" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <button type="submit">Daftar</button>
            </div>
        </form>
        <?php if (isset($error_message)) { ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php } ?>
        <div>Sudah memiliki akun? <a href="index.php">Login di sini</a></div>
    </div>

    <?php if ($success_message !== "") { ?>
        <script>
            alert("<?php echo $success_message; ?>");
        </script>
    <?php } ?>
</body>
</html>
