<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

require_once "connection.php";

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Ambil nama pengguna dari database berdasarkan user_id
$user_id = $_SESSION['user_id'];
$sql = "SELECT full_name FROM users WHERE id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $full_name = $row['full_name'];
} else {
    // Jika data pengguna tidak ditemukan, arahkan kembali ke halaman login
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Pendaftaran Siswa Baru Digital Talent | STMIK IKMI CIREBON</title>
</head>

<body>
	<header>
		<h2>Pendaftaran Siswa Baru Digital Talent</h2>
		<h2>Selamat datang, <?php echo $full_name; ?>!</h2>
		<h1>STMIK IKMI CIREBON</h1>
	</header>
	
	<h4>Menu</h4>
	<nav>
		<ul>
			<li><a href="form-daftar.php">Daftar Baru</a></li>
			<li><a href="list-siswadaftar.php">Pendaftar</a></li>
		</ul>
	</nav>
	<div>
        <!-- Tambahkan tombol logout di bawah -->
        <p><a href="logout.php">Logout</a></p>
    </div>
	
	<?php if(isset($_GET['status'])): ?>
	<p>
		<?php
			if($_GET['status'] == 'sukses'){
				echo "Pendaftaran siswa baru Digital Talent berhasil!";
			} else {
				echo "Pendaftaran gagal!";
			}
		?>
	</p>
	<?php endif; ?>
	
	</body>
</html>
