<?php include("connection.php"); 
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Pendaftaran Siswa Baru Digital Talent| STMIK IKMI CIREBON</title>
</head>

<body>
	<header>
		<h3>Siswa yang sudah mendaftar Digital Talent</h3>
	</header>

	<nav>
		<a href="form-daftar.php">[+] Tambah Baru</a>
	</nav>

	<br>

	<table border="1">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>Alamat</th>
				<th>Jenis Kelamin</th>
				<th>Agama</th>
				<th>Sekolah Asal</th>
				<th>Upload Photo</th>
				<th>Tindakan</th>
			</tr>
		</thead>
		<tbody>

			<?php
			$sql = "SELECT * FROM calon_siswadigitaltalent";
			$query = mysqli_query($db, $sql);

			while ($siswa = mysqli_fetch_array($query)) {
				echo "<tr>";

				echo "<td>" . $siswa['id'] . "</td>";
				echo "<td>" . $siswa['nama'] . "</td>";
				echo "<td>" . $siswa['alamat'] . "</td>";
				echo "<td>" . $siswa['jenis_kelamin'] . "</td>";
				echo "<td>" . $siswa['agama'] . "</td>";
				echo "<td>" . $siswa['sekolah_asal'] . "</td>";

				// Tampilkan gambar dengan tag <img>
				echo "<td><img src='upload/" . $siswa['upload_photo'] . "' alt='Foto Siswa' width='100'></td>";

				echo "<td>";
				echo "<a href='form-edit.php?id=" . $siswa['id'] . "'>Edit</a> | ";
				echo "<a href='hapus.php?id=" . $siswa['id'] . "'>Hapus</a>";
				echo "</td>";

				echo "</tr>";
			}
			?>

		</tbody>
	</table>

	<p>Total: <?php echo mysqli_num_rows($query) ?></p>

</body>

</html>
